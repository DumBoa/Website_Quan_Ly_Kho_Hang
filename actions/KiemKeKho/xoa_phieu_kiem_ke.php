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

    $ma_phieu_kiem_ke = isset($_POST['ma_phieu_kiem_ke']) ? (int)$_POST['ma_phieu_kiem_ke'] : 0;

    if ($ma_phieu_kiem_ke <= 0) {
        throw new Exception('Mã phiếu kiểm kê không hợp lệ');
    }

    // Kiểm tra phiếu có tồn tại không
    $check = $conn->prepare("SELECT trang_thai FROM phieu_kiem_ke WHERE ma_phieu_kiem_ke = ?");
    $check->bind_param("i", $ma_phieu_kiem_ke);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu kiểm kê');
    }

    $phieu = $result->fetch_assoc();
    $check->close();

    // Chỉ cho xóa phiếu đang kiểm kê
    if ($phieu['trang_thai'] !== 'dang_kiem_ke') {
        throw new Exception('Chỉ có thể xóa phiếu đang kiểm kê');
    }

    // Xóa chi tiết trước (ON DELETE CASCADE sẽ tự động xóa)
    $sql = "DELETE FROM phieu_kiem_ke WHERE ma_phieu_kiem_ke = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_kiem_ke);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa phiếu kiểm kê: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Xóa phiếu kiểm kê thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>