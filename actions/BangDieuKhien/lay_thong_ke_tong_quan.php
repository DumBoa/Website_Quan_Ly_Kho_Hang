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

    // Tổng sản phẩm
    $product_sql = "SELECT COUNT(*) as tong FROM hang_hoa WHERE trang_thai = 1";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();

    // Sản phẩm mới trong 7 ngày qua
    $new_product_sql = "SELECT COUNT(*) as moi FROM hang_hoa WHERE ngay_tao >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $new_product_result = $conn->query($new_product_sql);
    $new_product = $new_product_result->fetch_assoc();

    // Tổng tồn kho
    $inventory_sql = "SELECT SUM(so_luong) as tong FROM ton_kho";
    $inventory_result = $conn->query($inventory_sql);
    $inventory = $inventory_result->fetch_assoc();

    // Tổng số kho
    $warehouse_sql = "SELECT COUNT(*) as tong FROM kho WHERE trang_thai = 1";
    $warehouse_result = $conn->query($warehouse_sql);
    $warehouse = $warehouse_result->fetch_assoc();

    // Tổng nhà cung cấp
    $supplier_sql = "SELECT COUNT(*) as tong FROM nha_cung_cap WHERE trang_thai = 1";
    $supplier_result = $conn->query($supplier_sql);
    $supplier = $supplier_result->fetch_assoc();

    // Phiếu nhập hôm nay
    $import_today_sql = "SELECT COUNT(*) as tong FROM phieu_nhap WHERE DATE(ngay_tao) = CURDATE()";
    $import_today_result = $conn->query($import_today_sql);
    $import_today = $import_today_result->fetch_assoc();

    // Phiếu nhập chờ duyệt
    $import_pending_sql = "SELECT COUNT(*) as tong FROM phieu_nhap WHERE trang_thai = 0";
    $import_pending_result = $conn->query($import_pending_sql);
    $import_pending = $import_pending_result->fetch_assoc();

    // Phiếu xuất hôm nay
    $export_today_sql = "SELECT COUNT(*) as tong FROM phieu_xuat WHERE DATE(ngay_tao) = CURDATE()";
    $export_today_result = $conn->query($export_today_sql);
    $export_today = $export_today_result->fetch_assoc();

    // Phiếu xuất đang giao (trạng thái 1 - đã duyệt)
    $export_shipping_sql = "SELECT COUNT(*) as tong FROM phieu_xuat WHERE trang_thai = 1";
    $export_shipping_result = $conn->query($export_shipping_sql);
    $export_shipping = $export_shipping_result->fetch_assoc();

    // Tính tăng trưởng sản phẩm so với tháng trước
    $last_month_product_sql = "SELECT COUNT(*) as tong FROM hang_hoa WHERE ngay_tao BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    $last_month_product_result = $conn->query($last_month_product_sql);
    $last_month_product = $last_month_product_result->fetch_assoc();
    
    $tang_truong = 0;
    if ($last_month_product['tong'] > 0) {
        $tang_truong = round((($product['tong'] - $last_month_product['tong']) / $last_month_product['tong']) * 100);
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'tong_san_pham' => (int)$product['tong'],
            'san_pham_moi_7_ngay' => (int)$new_product['moi'],
            'tang_truong_san_pham' => $tang_truong,
            'tong_ton_kho' => (int)$inventory['tong'],
            'tong_kho' => (int)$warehouse['tong'],
            'tong_nha_cung_cap' => (int)$supplier['tong'],
            'phieu_nhap_hom_nay' => (int)$import_today['tong'],
            'phieu_nhap_cho_duyet' => (int)$import_pending['tong'],
            'phieu_xuat_hom_nay' => (int)$export_today['tong'],
            'phieu_xuat_dang_giao' => (int)$export_shipping['tong']
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>