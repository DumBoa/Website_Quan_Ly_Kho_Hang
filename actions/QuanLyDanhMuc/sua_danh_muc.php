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

    // Lấy dữ liệu từ form
    $ma_danh_muc = isset($_POST['ma_danh_muc']) ? (int)$_POST['ma_danh_muc'] : 0;
    $ten_danh_muc = trim($_POST['ten_danh_muc'] ?? '');
    $mo_ta = trim($_POST['mo_ta'] ?? '');
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    // Validate
    if ($ma_danh_muc <= 0) {
        throw new Exception('Mã danh mục không hợp lệ');
    }

    if (empty($ten_danh_muc)) {
        throw new Exception('Tên danh mục không được để trống');
    }

    // Kiểm tra tên danh mục đã tồn tại chưa (trừ chính nó)
    $stmt = $conn->prepare("SELECT ma_danh_muc FROM danh_muc WHERE ten_danh_muc = ? AND ma_danh_muc != ?");
    $stmt->bind_param("si", $ten_danh_muc, $ma_danh_muc);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('Tên danh mục đã tồn tại');
    }
    $stmt->close();

    // Cập nhật danh mục
    $sql = "UPDATE danh_muc SET ten_danh_muc = ?, mo_ta = ?, trang_thai = ? WHERE ma_danh_muc = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ssii", $ten_danh_muc, $mo_ta, $trang_thai, $ma_danh_muc);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật danh mục: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Cập nhật danh mục thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>