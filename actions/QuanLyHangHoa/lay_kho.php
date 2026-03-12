<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/config.php';

// Thêm debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại']);
    exit;
}

$sql = "SELECT ma_kho, ten_kho FROM kho ORDER BY ten_kho";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'ma_kho' => $row['ma_kho'],
        'ten_kho' => $row['ten_kho']
    ];
}

echo json_encode(['success' => true, 'data' => $data]);
?>