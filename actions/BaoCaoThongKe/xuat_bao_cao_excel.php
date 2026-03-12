<?php
session_start();
require_once '../../config/config.php';

$loai_bao_cao = isset($_GET['loai']) ? $_GET['loai'] : 'import';
$dinh_dang = isset($_GET['dinh_dang']) ? $_GET['dinh_dang'] : 'excel';

// Lấy dữ liệu theo loại báo cáo
$data = [];
switch ($loai_bao_cao) {
    case 'import':
        $sql = "SELECT pn.*, ncc.ten_nha_cung_cap, k.ten_kho, nd.ho_ten 
                FROM phieu_nhap pn
                LEFT JOIN nha_cung_cap ncc ON pn.ma_nha_cung_cap = ncc.ma_nha_cung_cap
                LEFT JOIN kho k ON pn.ma_kho = k.ma_kho
                LEFT JOIN nguoi_dung nd ON pn.ma_nguoi_tao = nd.ma_nguoi_dung
                ORDER BY pn.ngay_tao DESC";
        $result = $conn->query($sql);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'Mã phiếu' => 'PNK-' . str_pad($row['ma_phieu_nhap'], 3, '0', STR_PAD_LEFT),
                'Ngày tạo' => date('d/m/Y', strtotime($row['ngay_tao'])),
                'Nhà cung cấp' => $row['ten_nha_cung_cap'] ?? '',
                'Kho' => $row['ten_kho'] ?? '',
                'Số mặt hàng' => $row['so_mat_hang'],
                'Tổng số lượng' => $row['tong_so_luong'],
                'Tổng giá trị' => $row['tong_tien'],
                'Người tạo' => $row['ho_ten'] ?? ''
            ];
        }
        break;
        
    case 'export':
        // Tương tự...
        break;
}

// Xuất file
if ($dinh_dang === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="bao_cao_' . $loai_bao_cao . '_' . date('Y-m-d') . '.xls"');
    
    echo '<table border="1">';
    if (!empty($data)) {
        // Header
        echo '<tr>';
        foreach (array_keys($data[0]) as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';
        
        // Data
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . $cell . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</table>';
} elseif ($dinh_dang === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="bao_cao_' . $loai_bao_cao . '_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
    
    if (!empty($data)) {
        fputcsv($output, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
}
?>