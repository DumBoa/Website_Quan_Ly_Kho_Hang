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
    $ten_danh_muc = trim($_POST['ten_danh_muc'] ?? '');
    $mo_ta = trim($_POST['mo_ta'] ?? '');
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    // Validate
    if (empty($ten_danh_muc)) {
        throw new Exception('Tên danh mục không được để trống');
    }

    // Kiểm tra tên danh mục đã tồn tại chưa
    $stmt = $conn->prepare("SELECT ma_danh_muc FROM danh_muc WHERE ten_danh_muc = ?");
    $stmt->bind_param("s", $ten_danh_muc);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('Tên danh mục đã tồn tại');
    }
    $stmt->close();

    // Thêm danh mục mới
    $sql = "INSERT INTO danh_muc (ten_danh_muc, mo_ta, trang_thai) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $ten_danh_muc, $mo_ta, $trang_thai);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm danh mục: ' . $stmt->error);
    }

    $ma_danh_muc = $conn->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Thêm danh mục thành công',
        'ma_danh_muc' => $ma_danh_muc
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>