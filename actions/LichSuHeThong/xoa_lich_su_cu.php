<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    // Kiểm tra quyền (chỉ ADMIN mới được xóa lịch sử)
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if ($vai_tro !== 'ADMIN') {
        throw new Exception('Bạn không có quyền thực hiện chức năng này');
    }

    // Xóa lịch sử cũ hơn 90 ngày
    $sql = "DELETE FROM lich_su_he_thong WHERE thoi_gian < DATE_SUB(NOW(), INTERVAL 90 DAY)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $so_luong_xoa = $stmt->affected_rows;
    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => "Đã xóa $so_luong_xoa bản ghi lịch sử cũ hơn 90 ngày"
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>