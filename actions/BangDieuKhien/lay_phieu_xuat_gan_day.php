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

    $sql = "
        SELECT 
            px.ma_phieu_xuat,
            px.ngay_tao,
            px.trang_thai,
            px.tong_so_luong,
            k.ten_kho
        FROM phieu_xuat px
        LEFT JOIN kho k ON px.ma_kho = k.ma_kho
        ORDER BY px.ngay_tao DESC
        LIMIT 5
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_phieu' => 'PXK-' . str_pad($row['ma_phieu_xuat'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => date('d/m/Y', strtotime($row['ngay_tao'])),
            'trang_thai' => (int)$row['trang_thai'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'kho' => $row['ten_kho'] ?? '—'
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>