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
    $ma_danh_muc = isset($_GET['ma_danh_muc']) ? (int)$_GET['ma_danh_muc'] : 0;
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $trang_thai = isset($_GET['trang_thai']) ? (int)$_GET['trang_thai'] : -1;

    // Lấy danh sách sản phẩm
    $sql = "
        SELECT 
            hh.ma_hang_hoa,
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            dm.ten_danh_muc,
            hh.gia_nhap,
            hh.gia_ban,
            hh.trang_thai,
            COALESCE(SUM(tk.so_luong), 0) as tong_ton,
            (SELECT COUNT(*) FROM chi_tiet_phieu_nhap WHERE ma_hang_hoa = hh.ma_hang_hoa) as so_lan_nhap,
            (SELECT COUNT(*) FROM chi_tiet_phieu_xuat WHERE ma_hang_hoa = hh.ma_hang_hoa) as so_lan_xuat,
            (SELECT COALESCE(SUM(so_luong), 0) FROM chi_tiet_phieu_nhap WHERE ma_hang_hoa = hh.ma_hang_hoa) as tong_nhap,
            (SELECT COALESCE(SUM(so_luong), 0) FROM chi_tiet_phieu_xuat WHERE ma_hang_hoa = hh.ma_hang_hoa) as tong_xuat
        FROM hang_hoa hh
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        LEFT JOIN ton_kho tk ON hh.ma_hang_hoa = tk.ma_hang_hoa
        WHERE 1=1
    ";

    if ($ma_danh_muc > 0) {
        $sql .= " AND hh.ma_danh_muc = $ma_danh_muc";
    }

    if ($ma_kho > 0) {
        $sql .= " AND tk.ma_kho = $ma_kho";
    }

    if ($trang_thai >= 0) {
        $sql .= " AND hh.trang_thai = $trang_thai";
    }

    $sql .= " GROUP BY hh.ma_hang_hoa ORDER BY hh.ten_hang_hoa ASC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    $tong_gia_tri_nhap = 0;
    $tong_gia_tri_xuat = 0;

    while ($row = $result->fetch_assoc()) {
        $gia_tri_nhap = $row['tong_nhap'] * $row['gia_nhap'];
        $gia_tri_xuat = $row['tong_xuat'] * $row['gia_ban'];
        
        $data[] = [
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_san_pham' => $row['ten_hang_hoa'],
            'danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
            'gia_nhap' => (float)$row['gia_nhap'],
            'gia_ban' => (float)$row['gia_ban'],
            'so_lan_nhap' => (int)$row['so_lan_nhap'],
            'so_lan_xuat' => (int)$row['so_lan_xuat'],
            'tong_nhap' => (int)$row['tong_nhap'],
            'tong_xuat' => (int)$row['tong_xuat'],
            'ton_kho' => (int)$row['tong_ton'],
            'gia_tri_nhap' => $gia_tri_nhap,
            'gia_tri_xuat' => $gia_tri_xuat,
            'trang_thai' => (int)$row['trang_thai']
        ];

        $tong_gia_tri_nhap += $gia_tri_nhap;
        $tong_gia_tri_xuat += $gia_tri_xuat;
    }

    // Thống kê theo danh mục
    $category_stats = [];
    foreach ($data as $item) {
        $dm = $item['danh_muc'];
        if (!isset($category_stats[$dm])) {
            $category_stats[$dm] = [
                'so_luong_sp' => 0,
                'tong_nhap' => 0,
                'tong_xuat' => 0,
                'ton_kho' => 0
            ];
        }
        $category_stats[$dm]['so_luong_sp']++;
        $category_stats[$dm]['tong_nhap'] += $item['tong_nhap'];
        $category_stats[$dm]['tong_xuat'] += $item['tong_xuat'];
        $category_stats[$dm]['ton_kho'] += $item['ton_kho'];
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_san_pham' => count($data),
            'tong_ton_kho' => array_sum(array_column($data, 'ton_kho')),
            'tong_gia_tri_nhap' => $tong_gia_tri_nhap,
            'tong_gia_tri_xuat' => $tong_gia_tri_xuat,
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