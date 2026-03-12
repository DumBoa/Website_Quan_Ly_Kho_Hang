<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once '../../config/config.php';

try {
    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    $dinh_dang = isset($_GET['dinh_dang']) ? $_GET['dinh_dang'] : 'csv';
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $ma_danh_muc = isset($_GET['ma_danh_muc']) ? (int)$_GET['ma_danh_muc'] : 0;

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            dm.ten_danh_muc,
            k.ten_kho,
            tk.so_luong,
            hh.ton_toi_thieu,
            hh.gia_nhap,
            (tk.so_luong * hh.gia_nhap) as gia_tri
        FROM ton_kho tk
        INNER JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN kho k ON tk.ma_kho = k.ma_kho
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE 1=1
    ";

    if ($ma_kho > 0) {
        $sql .= " AND tk.ma_kho = $ma_kho";
    }
    
    if ($ma_danh_muc > 0) {
        $sql .= " AND hh.ma_danh_muc = $ma_danh_muc";
    }

    $sql .= " ORDER BY hh.ten_hang_hoa ASC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Xuất file theo định dạng
    if ($dinh_dang === 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="ton_kho_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
        
        // Header
        fputcsv($output, ['Mã SP', 'Tên sản phẩm', 'Danh mục', 'Kho', 'Số lượng', 'Tồn tối thiểu', 'Giá nhập', 'Giá trị']);
        
        // Data
        foreach ($data as $row) {
            fputcsv($output, [
                $row['ma_san_pham'],
                $row['ten_hang_hoa'],
                $row['ten_danh_muc'] ?? '',
                $row['ten_kho'] ?? '',
                $row['so_luong'],
                $row['ton_toi_thieu'] ?? 5,
                number_format($row['gia_nhap'], 0, ',', '.'),
                number_format($row['gia_tri'], 0, ',', '.')
            ]);
        }
        
        fclose($output);
        exit;
    } elseif ($dinh_dang === 'excel') {
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="ton_kho_' . date('Y-m-d') . '.xls"');
        
        echo '<html>';
        echo '<meta charset="UTF-8">';
        echo '<table border="1">';
        echo '<tr><th>Mã SP</th><th>Tên sản phẩm</th><th>Danh mục</th><th>Kho</th><th>Số lượng</th><th>Tồn tối thiểu</th><th>Giá nhập</th><th>Giá trị</th></tr>';
        
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>' . $row['ma_san_pham'] . '</td>';
            echo '<td>' . $row['ten_hang_hoa'] . '</td>';
            echo '<td>' . ($row['ten_danh_muc'] ?? '') . '</td>';
            echo '<td>' . ($row['ten_kho'] ?? '') . '</td>';
            echo '<td>' . $row['so_luong'] . '</td>';
            echo '<td>' . ($row['ton_toi_thieu'] ?? 5) . '</td>';
            echo '<td>' . number_format($row['gia_nhap'], 0, ',', '.') . '</td>';
            echo '<td>' . number_format($row['gia_tri'], 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        exit;
    }

} catch (Exception $e) {
    echo 'Lỗi: ' . $e->getMessage();
}
?>