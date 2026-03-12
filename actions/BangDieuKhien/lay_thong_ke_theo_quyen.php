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

    $vai_tro = $_SESSION['vai_tro'] ?? '';

    $data = [];

    // Thống kê chung cho tất cả
    $data['tong_san_pham'] = $conn->query("SELECT COUNT(*) as tong FROM hang_hoa WHERE trang_thai = 1")->fetch_assoc()['tong'] ?? 0;
    $data['tong_ton_kho'] = $conn->query("SELECT SUM(so_luong) as tong FROM ton_kho")->fetch_assoc()['tong'] ?? 0;
    $data['phieu_nhap_cho_duyet'] = $conn->query("SELECT COUNT(*) as tong FROM phieu_nhap WHERE trang_thai = 0")->fetch_assoc()['tong'] ?? 0;
    $data['phieu_xuat_cho_duyet'] = $conn->query("SELECT COUNT(*) as tong FROM phieu_xuat WHERE trang_thai = 0")->fetch_assoc()['tong'] ?? 0;

    // Nếu là ADMIN hoặc QUAN_LY, thêm thống kê chi tiết
    if (in_array($vai_tro, ['ADMIN', 'QUAN_LY'])) {
        $data['tong_nha_cung_cap'] = $conn->query("SELECT COUNT(*) as tong FROM nha_cung_cap WHERE trang_thai = 1")->fetch_assoc()['tong'] ?? 0;
        $data['tong_kho'] = $conn->query("SELECT COUNT(*) as tong FROM kho WHERE trang_thai = 1")->fetch_assoc()['tong'] ?? 0;
        $data['tong_nguoi_dung'] = $conn->query("SELECT COUNT(*) as tong FROM nguoi_dung WHERE trang_thai = 1")->fetch_assoc()['tong'] ?? 0;
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