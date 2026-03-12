<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit;
}

$ma_san_pham = trim($_POST['ma_san_pham'] ?? '');

if (empty($ma_san_pham)) {
    echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm']);
    exit;
}

// Soft delete - chỉ cập nhật trạng thái
$stmt = $conn->prepare("UPDATE hang_hoa SET trang_thai = 0 WHERE ma_san_pham = ?");
$stmt->bind_param("s", $ma_san_pham);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Xóa thành công']);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>