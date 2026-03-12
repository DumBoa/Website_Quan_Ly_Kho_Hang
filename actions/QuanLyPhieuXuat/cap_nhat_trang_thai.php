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

    $ma_phieu_xuat = isset($_POST['ma_phieu_xuat']) ? (int)$_POST['ma_phieu_xuat'] : 0;

    if ($ma_phieu_xuat <= 0) {
        throw new Exception('Mã phiếu xuất không hợp lệ');
    }

    // Kiểm tra phiếu có tồn tại không
    $stmt = $conn->prepare("SELECT trang_thai FROM phieu_xuat WHERE ma_phieu_xuat = ?");
    $stmt->bind_param("i", $ma_phieu_xuat);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu xuất');
    }

    $phieu = $result->fetch_assoc();
    $stmt->close();

    // Không cho xóa phiếu đã duyệt
    if ($phieu['trang_thai'] == 1) {
        throw new Exception('Không thể xóa phiếu đã duyệt');
    }

    // Xóa chi tiết phiếu xuất (ON DELETE CASCADE sẽ tự động xóa)
    $sql = "DELETE FROM phieu_xuat WHERE ma_phieu_xuat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_xuat);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa phiếu xuất: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa phiếu xuất thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>