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

    if ($ma_phieu_nhap <= 0) {
        throw new Exception('Mã phiếu nhập không hợp lệ');
    }

    // Kiểm tra phiếu có tồn tại không
    $stmt = $conn->prepare("SELECT trang_thai FROM phieu_nhap WHERE ma_phieu_nhap = ?");
    $stmt->bind_param("i", $ma_phieu_nhap);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu nhập');
    }

    $phieu = $result->fetch_assoc();
    $stmt->close();

    // Không cho xóa phiếu đã duyệt
    if ($phieu['trang_thai'] == 1) {
        throw new Exception('Không thể xóa phiếu đã duyệt');
    }

    // Xóa chi tiết phiếu nhập (ON DELETE CASCADE sẽ tự động xóa)
    $sql = "DELETE FROM phieu_nhap WHERE ma_phieu_nhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_nhap);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa phiếu nhập: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa phiếu nhập thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>