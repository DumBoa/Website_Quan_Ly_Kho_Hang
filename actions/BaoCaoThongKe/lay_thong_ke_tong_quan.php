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

    // Thống kê tổng số phiếu nhập
    $import_sql = "SELECT COUNT(*) as tong, SUM(tong_tien) as tong_gia_tri FROM phieu_nhap";
    $import_result = $conn->query($import_sql);
    $import_stats = $import_result->fetch_assoc();

    // Thống kê tổng số phiếu xuất
    $export_sql = "SELECT COUNT(*) as tong, SUM(tong_gia_tri) as tong_gia_tri FROM phieu_xuat";
    $export_result = $conn->query($export_sql);
    $export_stats = $export_result->fetch_assoc();

    // Thống kê tổng số sản phẩm
    $product_sql = "SELECT COUNT(*) as tong FROM hang_hoa WHERE trang_thai = 1";
    $product_result = $conn->query($product_sql);
    $product_stats = $product_result->fetch_assoc();

    // Thống kê tổng giá trị tồn kho
    $inventory_sql = "SELECT SUM(tk.so_luong * hh.gia_nhap) as tong_gia_tri 
                      FROM ton_kho tk 
                      JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa";
    $inventory_result = $conn->query($inventory_sql);
    $inventory_stats = $inventory_result->fetch_assoc();

    echo json_encode([
        'success' => true,
        'data' => [
            'import' => [
                'tong' => (int)($import_stats['tong'] ?? 0),
                'tong_gia_tri' => (float)($import_stats['tong_gia_tri'] ?? 0)
            ],
            'export' => [
                'tong' => (int)($export_stats['tong'] ?? 0),
                'tong_gia_tri' => (float)($export_stats['tong_gia_tri'] ?? 0)
            ],
            'product' => [
                'tong' => (int)($product_stats['tong'] ?? 0)
            ],
            'inventory' => [
                'tong_gia_tri' => (float)($inventory_stats['tong_gia_tri'] ?? 0)
            ]
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>