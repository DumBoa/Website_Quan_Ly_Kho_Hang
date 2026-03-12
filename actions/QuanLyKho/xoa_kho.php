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

    $ma_kho = isset($_POST['ma_kho']) ? (int)$_POST['ma_kho'] : 0;

    if ($ma_kho <= 0) {
        throw new Exception('Mã kho không hợp lệ');
    }

    // Kiểm tra kho có tồn tại không
    $stmt = $conn->prepare("SELECT * FROM kho WHERE ma_kho = ?");
    $stmt->bind_param("i", $ma_kho);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy kho');
    }
    $stmt->close();

    // Kiểm tra xem kho có sản phẩm không
    $stmt = $conn->prepare("SELECT COUNT(*) as so_luong FROM ton_kho WHERE ma_kho = ? AND so_luong > 0");
    $stmt->bind_param("i", $ma_kho);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['so_luong'] > 0) {
        throw new Exception('Không thể xóa kho đang chứa sản phẩm');
    }
    $stmt->close();

    // Thực hiện xóa (soft delete)
    $sql = "UPDATE kho SET trang_thai = 0 WHERE ma_kho = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_kho);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa kho: ' . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception('Không thể xóa kho');
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa kho thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>