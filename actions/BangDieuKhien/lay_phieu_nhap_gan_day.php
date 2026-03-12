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
            pn.ma_phieu_nhap,
            pn.ngay_tao,
            pn.trang_thai,
            pn.tong_so_luong,
            ncc.ten_nha_cung_cap
        FROM phieu_nhap pn
        LEFT JOIN nha_cung_cap ncc ON pn.ma_nha_cung_cap = ncc.ma_nha_cung_cap
        ORDER BY pn.ngay_tao DESC
        LIMIT 5
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_phieu' => 'PNK-' . str_pad($row['ma_phieu_nhap'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => date('d/m/Y', strtotime($row['ngay_tao'])),
            'trang_thai' => (int)$row['trang_thai'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'nha_cung_cap' => $row['ten_nha_cung_cap'] ?? '—'
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