<?php
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

    $ma_phieu_nhap = isset($_POST['ma_phieu_nhap']) ? (int)$_POST['ma_phieu_nhap'] : 0;
    $trang_thai_moi = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0;
    $ma_nguoi_duyet = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 1;

    if ($ma_phieu_nhap <= 0) {
        throw new Exception('Mã phiếu nhập không hợp lệ');
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

    // Nếu chuyển từ chờ duyệt (0) sang đã duyệt (1), cập nhật tồn kho
    if ($phieu['trang_thai'] == 0 && $trang_thai_moi == 1) {
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
                // Cập nhật số lượng (CỘNG thêm)
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

    // Cập nhật trạng thái
    $sql = "UPDATE phieu_nhap SET trang_thai = ?, ma_nguoi_duyet = ?, ngay_duyet = NOW() WHERE ma_phieu_nhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $trang_thai_moi, $ma_nguoi_duyet, $ma_phieu_nhap);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật trạng thái: ' . $stmt->error);
    }

    $stmt->close();

    $trang_thai_text = '';
    switch ($trang_thai_moi) {
        case 0: $trang_thai_text = 'Chờ duyệt'; break;
        case 1: $trang_thai_text = 'Đã duyệt'; break;
        case 2: $trang_thai_text = 'Từ chối'; break;
    }

    echo json_encode([
        'success' => true, 
        'message' => 'Đã cập nhật trạng thái thành ' . $trang_thai_text
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>