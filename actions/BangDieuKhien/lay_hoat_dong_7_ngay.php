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

    $labels = [];
    $imports = [];
    $exports = [];

    // Lấy dữ liệu 7 ngày gần nhất
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $day_name = date('w', strtotime($date));
        
        // Chuyển đổi sang tên thứ
        $day_names = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
        $labels[] = $day_names[$day_name];

        // Đếm số lượng phiếu nhập trong ngày
        $import_sql = "SELECT COUNT(*) as sl FROM phieu_nhap WHERE DATE(ngay_tao) = ?";
        $import_stmt = $conn->prepare($import_sql);
        $import_stmt->bind_param("s", $date);
        $import_stmt->execute();
        $import_result = $import_stmt->get_result();
        $import = $import_result->fetch_assoc();
        $imports[] = (int)$import['sl'];
        $import_stmt->close();

        // Đếm số lượng phiếu xuất trong ngày
        $export_sql = "SELECT COUNT(*) as sl FROM phieu_xuat WHERE DATE(ngay_tao) = ?";
        $export_stmt = $conn->prepare($export_sql);
        $export_stmt->bind_param("s", $date);
        $export_stmt->execute();
        $export_result = $export_stmt->get_result();
        $export = $export_result->fetch_assoc();
        $exports[] = (int)$export['sl'];
        $export_stmt->close();
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'labels' => $labels,
            'imports' => $imports,
            'exports' => $exports
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>