<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    $sql = "SELECT ma_nguoi_dung, ho_ten, ten_dang_nhap FROM nguoi_dung WHERE trang_thai = 1 ORDER BY ho_ten";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_nguoi_dung' => (int)$row['ma_nguoi_dung'],
            'ho_ten' => $row['ho_ten'],
            'ten_dang_nhap' => $row['ten_dang_nhap']
        ];
    }

    echo json_encode(['success' => true, 'data' => $data]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>