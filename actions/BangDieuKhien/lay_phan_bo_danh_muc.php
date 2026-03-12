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

    // Lấy top 4 danh mục có nhiều sản phẩm nhất
    $sql = "
        SELECT 
            dm.ten_danh_muc,
            COUNT(hh.ma_hang_hoa) as so_luong
        FROM danh_muc dm
        LEFT JOIN hang_hoa hh ON dm.ma_danh_muc = hh.ma_danh_muc AND hh.trang_thai = 1
        WHERE dm.trang_thai = 1
        GROUP BY dm.ma_danh_muc
        ORDER BY so_luong DESC
        LIMIT 4
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $labels = [];
    $values = [];
    $other_count = 0;

    while ($row = $result->fetch_assoc()) {
        if ($row['ten_danh_muc'] && $row['so_luong'] > 0) {
            $labels[] = $row['ten_danh_muc'];
            $values[] = (int)$row['so_luong'];
        }
    }

    // Tính tổng số sản phẩm
    $total_sql = "SELECT COUNT(*) as tong FROM hang_hoa WHERE trang_thai = 1";
    $total_result = $conn->query($total_sql);
    $total = $total_result->fetch_assoc();
    $total_products = (int)$total['tong'];

    // Nếu có sản phẩm khác không thuộc 4 danh mục top
    $sum_top = array_sum($values);
    if ($sum_top < $total_products) {
        $labels[] = 'Khác';
        $values[] = $total_products - $sum_top;
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'labels' => $labels,
            'values' => $values,
            'tong_san_pham' => $total_products
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>