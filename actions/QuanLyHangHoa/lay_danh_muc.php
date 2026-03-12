<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/config.php';

// Thêm debug để kiểm tra lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra kết nối
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại']);
    exit;
}

// Lấy danh mục (không có điều kiện trang_thai vì bảng danh_muc trong CSDL của bạn không có cột này)
$sql = "SELECT ma_danh_muc, ten_danh_muc FROM danh_muc ORDER BY ten_danh_muc";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'ma_danh_muc' => $row['ma_danh_muc'],
        'ten_danh_muc' => $row['ten_danh_muc']
    ];
}

echo json_encode(['success' => true, 'data' => $data]);
?>