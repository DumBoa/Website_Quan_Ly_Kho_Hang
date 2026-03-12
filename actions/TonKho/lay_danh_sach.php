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

    // Lấy tham số lọc
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $ma_danh_muc = isset($_GET['ma_danh_muc']) ? (int)$_GET['ma_danh_muc'] : 0;
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            tk.ma_ton_kho,
            tk.ma_kho,
            k.ten_kho,
            tk.ma_hang_hoa,
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            hh.gia_nhap,
            hh.gia_ban,
            dm.ma_danh_muc,
            dm.ten_danh_muc,
            tk.so_luong,
            hh.ton_toi_thieu
        FROM ton_kho tk
        INNER JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN kho k ON tk.ma_kho = k.ma_kho
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE 1=1
    ";

    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (hh.ma_san_pham LIKE '%$search%' OR hh.ten_hang_hoa LIKE '%$search%')";
    }
    
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
    $tong_so_luong = 0;
    $tong_gia_tri = 0;
    $dem_sap_het = 0;

    while ($row = $result->fetch_assoc()) {
        $ton_toi_thieu = $row['ton_toi_thieu'] ?? 5;
        
        // Xác định trạng thái tồn kho
        if ($row['so_luong'] <= 0) {
            $trang_thai_ton = 'out-of-stock';
        } elseif ($row['so_luong'] <= $ton_toi_thieu) {
            $trang_thai_ton = 'low-stock';
            $dem_sap_het++;
        } else {
            $trang_thai_ton = 'normal';
        }

        $data[] = [
            'ma_ton_kho' => (int)$row['ma_ton_kho'],
            'ma_kho' => (int)$row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? 'Chưa có kho',
            'ma_hang_hoa' => (int)$row['ma_hang_hoa'],
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_hang_hoa' => $row['ten_hang_hoa'],
            'ma_danh_muc' => (int)$row['ma_danh_muc'],
            'ten_danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
            'so_luong' => (int)$row['so_luong'],
            'ton_toi_thieu' => $ton_toi_thieu,
            'gia_nhap' => (float)$row['gia_nhap'],
            'gia_ban' => (float)$row['gia_ban'],
            'gia_tri' => (int)$row['so_luong'] * (float)$row['gia_nhap'],
            'trang_thai_ton' => $trang_thai_ton
        ];

        $tong_so_luong += (int)$row['so_luong'];
        $tong_gia_tri += (int)$row['so_luong'] * (float)$row['gia_nhap'];
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_san_pham' => count($data),
            'tong_so_luong' => $tong_so_luong,
            'tong_gia_tri' => $tong_gia_tri,
            'sap_het' => $dem_sap_het
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>