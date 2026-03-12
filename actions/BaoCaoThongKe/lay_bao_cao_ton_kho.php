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
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $ma_danh_muc = isset($_GET['ma_danh_muc']) ? (int)$_GET['ma_danh_muc'] : 0;
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';

    // Lấy danh sách tồn kho
    $sql = "
        SELECT 
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            dm.ten_danh_muc,
            k.ma_kho,
            k.ten_kho,
            tk.so_luong,
            hh.ton_toi_thieu,
            hh.gia_nhap,
            hh.gia_ban,
            (tk.so_luong * hh.gia_nhap) as gia_tri
        FROM ton_kho tk
        INNER JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN kho k ON tk.ma_kho = k.ma_kho
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE hh.trang_thai = 1
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
    $tong_gia_tri = 0;
    $tong_so_luong = 0;
    $sap_het = 0;
    $het_hang = 0;

    while ($row = $result->fetch_assoc()) {
        $ton_toi_thieu = $row['ton_toi_thieu'] ?? 5;
        
        // Xác định trạng thái
        if ($row['so_luong'] <= 0) {
            $trang_thai_ton = 'out-of-stock';
            $het_hang++;
        } elseif ($row['so_luong'] <= $ton_toi_thieu) {
            $trang_thai_ton = 'low-stock';
            $sap_het++;
        } else {
            $trang_thai_ton = 'normal';
        }

        // Lọc theo trạng thái nếu có
        if ($trang_thai && $trang_thai_ton !== $trang_thai) {
            continue;
        }

        $data[] = [
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_san_pham' => $row['ten_hang_hoa'],
            'danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
            'kho' => $row['ten_kho'] ?? 'Chưa có kho',
            'so_luong' => (int)$row['so_luong'],
            'ton_toi_thieu' => $ton_toi_thieu,
            'gia_nhap' => (float)$row['gia_nhap'],
            'gia_ban' => (float)$row['gia_ban'],
            'gia_tri' => (float)$row['gia_tri'],
            'trang_thai' => $trang_thai_ton
        ];

        $tong_so_luong += (int)$row['so_luong'];
        $tong_gia_tri += (float)$row['gia_tri'];
    }

    // Thống kê theo danh mục
    $category_stats = [];
    foreach ($data as $item) {
        $dm = $item['danh_muc'];
        if (!isset($category_stats[$dm])) {
            $category_stats[$dm] = [
                'so_luong' => 0,
                'gia_tri' => 0
            ];
        }
        $category_stats[$dm]['so_luong'] += $item['so_luong'];
        $category_stats[$dm]['gia_tri'] += $item['gia_tri'];
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_san_pham' => count($data),
            'tong_so_luong' => $tong_so_luong,
            'tong_gia_tri' => $tong_gia_tri,
            'sap_het' => $sap_het,
            'het_hang' => $het_hang,
            'theo_danh_muc' => $category_stats
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>