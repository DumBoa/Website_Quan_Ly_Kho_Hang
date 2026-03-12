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

    $ma_danh_muc = isset($_POST['ma_danh_muc']) ? (int)$_POST['ma_danh_muc'] : 0;

    if ($ma_danh_muc <= 0) {
        throw new Exception('Mã danh mục không hợp lệ');
    }

    // Kiểm tra danh mục có tồn tại không
    $stmt = $conn->prepare("SELECT * FROM danh_muc WHERE ma_danh_muc = ?");
    $stmt->bind_param("i", $ma_danh_muc);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy danh mục');
    }
    
    $category = $result->fetch_assoc();
    $stmt->close();

    // Kiểm tra xem danh mục có sản phẩm không
    $stmt = $conn->prepare("SELECT COUNT(*) as so_luong FROM hang_hoa WHERE ma_danh_muc = ? AND trang_thai = 1");
    $stmt->bind_param("i", $ma_danh_muc);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['so_luong'] > 0) {
        throw new Exception('Không thể xóa danh mục đang có sản phẩm');
    }
    $stmt->close();

    // Thực hiện xóa cứng (xóa hẳn khỏi database) hoặc soft delete
    // Option 1: Xóa cứng (xóa hẳn)
    $sql = "DELETE FROM danh_muc WHERE ma_danh_muc = ?";
    
    // Option 2: Soft delete (cập nhật trạng thái) - comment dòng trên và uncomment dòng dưới nếu muốn dùng soft delete
    // $sql = "UPDATE danh_muc SET trang_thai = 0 WHERE ma_danh_muc = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_danh_muc);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa danh mục: ' . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception('Không thể xóa danh mục');
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa danh mục thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>