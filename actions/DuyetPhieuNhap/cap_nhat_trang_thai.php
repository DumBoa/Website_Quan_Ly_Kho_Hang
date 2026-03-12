<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Phương thức không hợp lệ');
    }

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    // Kiểm tra quyền
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if (!in_array($vai_tro, ['QUAN_LY', 'ADMIN'])) {
        throw new Exception('Bạn không có quyền thực hiện chức năng này');
    }

    $ma_phieu_nhap = isset($_POST['ma_phieu_nhap']) ? (int)$_POST['ma_phieu_nhap'] : 0;
    $trang_thai_moi = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0;
    $ly_do = isset($_POST['ly_do']) ? trim($_POST['ly_do']) : '';
    $ma_nguoi_duyet = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;

    if ($ma_phieu_nhap <= 0) {
        throw new Exception('Mã phiếu nhập không hợp lệ');
    }

    if (!in_array($trang_thai_moi, [1, 2])) {
        throw new Exception('Trạng thái không hợp lệ');
    }

    if ($trang_thai_moi == 2 && empty($ly_do)) {
        throw new Exception('Vui lòng nhập lý do từ chối');
    }

    if ($ma_nguoi_duyet <= 0) {
        throw new Exception('Không xác định được người duyệt');
    }

    // Lấy thông tin phiếu nhập
    $stmt = $conn->prepare("SELECT * FROM phieu_nhap WHERE ma_phieu_nhap = ?");
    $stmt->bind_param("i", $ma_phieu_nhap);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu nhập');
    }

    $phieu = $result->fetch_assoc();
    $stmt->close();

    // Kiểm tra phiếu đã được xử lý chưa
    if ($phieu['trang_thai'] != 0) {
        throw new Exception('Phiếu này đã được xử lý trước đó');
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Nếu duyệt phiếu (chuyển từ 0 sang 1), cập nhật tồn kho
    if ($trang_thai_moi == 1) {
        // Lấy chi tiết phiếu nhập
        $stmt = $conn->prepare("SELECT * FROM chi_tiet_phieu_nhap WHERE ma_phieu_nhap = ?");
        $stmt->bind_param("i", $ma_phieu_nhap);
        $stmt->execute();
        $chi_tiet = $stmt->get_result();
        
        while ($ct = $chi_tiet->fetch_assoc()) {
            $ma_hang_hoa = $ct['ma_hang_hoa'];
            $so_luong = $ct['so_luong'];
            
            // Kiểm tra tồn kho đã có chưa
            $check = $conn->prepare("SELECT ma_ton_kho FROM ton_kho WHERE ma_kho = ? AND ma_hang_hoa = ?");
            $check->bind_param("ii", $phieu['ma_kho'], $ma_hang_hoa);
            $check->execute();
            $checkResult = $check->get_result();
            
            if ($checkResult->num_rows > 0) {
                // Cập nhật số lượng (cộng thêm)
                $update = $conn->prepare("UPDATE ton_kho SET so_luong = so_luong + ? WHERE ma_kho = ? AND ma_hang_hoa = ?");
                $update->bind_param("iii", $so_luong, $phieu['ma_kho'], $ma_hang_hoa);
                $update->execute();
                $update->close();
            } else {
                // Thêm mới
                $insert = $conn->prepare("INSERT INTO ton_kho (ma_kho, ma_hang_hoa, so_luong) VALUES (?, ?, ?)");
                $insert->bind_param("iii", $phieu['ma_kho'], $ma_hang_hoa, $so_luong);
                $insert->execute();
                $insert->close();
            }
            $check->close();
        }
        $stmt->close();
    }

    // Cập nhật trạng thái phiếu nhập
    $sql = "UPDATE phieu_nhap SET 
            trang_thai = ?, 
            ma_nguoi_duyet = ?, 
            ngay_duyet = NOW()" . 
            ($trang_thai_moi == 2 ? ", ghi_chu = CONCAT(ghi_chu, '\nLý do từ chối: ', ?)" : "") . 
            " WHERE ma_phieu_nhap = ?";
    
    $stmt = $conn->prepare($sql);
    
    if ($trang_thai_moi == 2) {
        $stmt->bind_param("iisi", $trang_thai_moi, $ma_nguoi_duyet, $ly_do, $ma_phieu_nhap);
    } else {
        $stmt->bind_param("iii", $trang_thai_moi, $ma_nguoi_duyet, $ma_phieu_nhap);
    }
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật trạng thái: ' . $stmt->error);
    }

    $stmt->close();

    // Commit transaction
    $conn->commit();

    $trang_thai_text = $trang_thai_moi == 1 ? 'Đã duyệt' : 'Từ chối';

    echo json_encode([
        'success' => true, 
        'message' => "Đã cập nhật trạng thái phiếu thành $trang_thai_text",
        'trang_thai' => $trang_thai_moi
    ]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>