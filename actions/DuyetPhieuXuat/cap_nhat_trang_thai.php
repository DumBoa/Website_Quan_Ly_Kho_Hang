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

    $ma_phieu_xuat = isset($_POST['ma_phieu_xuat']) ? (int)$_POST['ma_phieu_xuat'] : 0;
    $trang_thai_moi = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0;
    $ly_do = isset($_POST['ly_do']) ? trim($_POST['ly_do']) : '';
    $ma_nguoi_duyet = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;

    if ($ma_phieu_xuat <= 0) {
        throw new Exception('Mã phiếu xuất không hợp lệ');
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

    // Lấy thông tin phiếu xuất
    $stmt = $conn->prepare("SELECT * FROM phieu_xuat WHERE ma_phieu_xuat = ?");
    $stmt->bind_param("i", $ma_phieu_xuat);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu xuất');
    }

    $phieu = $result->fetch_assoc();
    $stmt->close();

    // Kiểm tra phiếu đã được xử lý chưa
    if ($phieu['trang_thai'] != 0) {
        throw new Exception('Phiếu này đã được xử lý trước đó');
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Nếu duyệt phiếu (chuyển từ 0 sang 1), cập nhật tồn kho (đã được trừ khi tạo phiếu)
    // Không cần cập nhật tồn kho ở đây vì đã trừ khi tạo phiếu

    // Cập nhật trạng thái phiếu xuất
    $sql = "UPDATE phieu_xuat SET 
            trang_thai = ?, 
            ma_nguoi_duyet = ?, 
            ngay_duyet = NOW()" . 
            ($trang_thai_moi == 2 ? ", ghi_chu = CONCAT(ghi_chu, '\nLý do từ chối: ', ?)" : "") . 
            " WHERE ma_phieu_xuat = ?";
    
    $stmt = $conn->prepare($sql);
    
    if ($trang_thai_moi == 2) {
        $stmt->bind_param("iisi", $trang_thai_moi, $ma_nguoi_duyet, $ly_do, $ma_phieu_xuat);
    } else {
        $stmt->bind_param("iii", $trang_thai_moi, $ma_nguoi_duyet, $ma_phieu_xuat);
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