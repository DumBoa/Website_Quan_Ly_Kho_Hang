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
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';

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
            (SELECT COALESCE(COUNT(*), 0) FROM chi_tiet_phieu_nhap WHERE ma_hang_hoa = hh.ma_hang_hoa) as so_lan_nhap,
            (SELECT COALESCE(COUNT(*), 0) FROM chi_tiet_phieu_xuat WHERE ma_hang_hoa = hh.ma_hang_hoa) as so_lan_xuat,
            (SELECT COALESCE(SUM(so_luong), 0) FROM chi_tiet_phieu_nhap WHERE ma_hang_hoa = hh.ma_hang_hoa) as tong_nhap,
            (SELECT COALESCE(SUM(so_luong), 0) FROM chi_tiet_phieu_xuat WHERE ma_hang_hoa = hh.ma_hang_hoa) as tong_xuat,
            COALESCE((SELECT SUM(so_luong) FROM ton_kho WHERE ma_hang_hoa = hh.ma_hang_hoa), 0) as ton_kho
        FROM hang_hoa hh
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE 1=1
    ";

    if ($ma_danh_muc > 0) {
        $sql .= " AND hh.ma_danh_muc = $ma_danh_muc";
    }

    if ($trang_thai !== '') {
        if ($trang_thai === 'normal') {
            $sql .= " AND hh.trang_thai = 1";
        } elseif ($trang_thai === 'inactive') {
            $sql .= " AND hh.trang_thai = 0";
        }
    }

    $sql .= " GROUP BY hh.ma_hang_hoa ORDER BY hh.ten_hang_hoa ASC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    $tong_san_pham = 0;
    $tong_ton_kho = 0;
    $tong_gia_tri_nhap = 0;
    $tong_gia_tri_xuat = 0;
    $category_stats = [];

    while ($row = $result->fetch_assoc()) {
        $gia_tri_nhap = $row['tong_nhap'] * ($row['gia_nhap'] ?? 0);
        $gia_tri_xuat = $row['tong_xuat'] * ($row['gia_ban'] ?? 0);
        
        // Lọc theo kho nếu có
        if ($ma_kho > 0) {
            // Kiểm tra sản phẩm có trong kho không
            $check_kho_sql = "SELECT COUNT(*) as has FROM ton_kho WHERE ma_hang_hoa = ? AND ma_kho = ?";
            $stmt = $conn->prepare($check_kho_sql);
            $stmt->bind_param("ii", $row['ma_hang_hoa'], $ma_kho);
            $stmt->execute();
            $check_result = $stmt->get_result();
            $has_in_kho = $check_result->fetch_assoc()['has'] > 0;
            $stmt->close();
            
            if (!$has_in_kho) {
                continue;
            }
            
            // Lấy tồn kho theo kho cụ thể
            $ton_kho_sql = "SELECT COALESCE(SUM(so_luong), 0) as ton FROM ton_kho WHERE ma_hang_hoa = ? AND ma_kho = ?";
            $stmt = $conn->prepare($ton_kho_sql);
            $stmt->bind_param("ii", $row['ma_hang_hoa'], $ma_kho);
            $stmt->execute();
            $ton_result = $stmt->get_result();
            $ton_kho = $ton_result->fetch_assoc()['ton'];
            $stmt->close();
        } else {
            $ton_kho = $row['ton_kho'];
        }

        $data[] = [
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_san_pham' => $row['ten_hang_hoa'],
            'danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
            'gia_nhap' => (float)($row['gia_nhap'] ?? 0),
            'gia_ban' => (float)($row['gia_ban'] ?? 0),
            'so_lan_nhap' => (int)$row['so_lan_nhap'],
            'so_lan_xuat' => (int)$row['so_lan_xuat'],
            'tong_nhap' => (int)$row['tong_nhap'],
            'tong_xuat' => (int)$row['tong_xuat'],
            'ton_kho' => (int)$ton_kho,
            'gia_tri_nhap' => (float)$gia_tri_nhap,
            'gia_tri_xuat' => (float)$gia_tri_xuat,
            'trang_thai' => (int)$row['trang_thai']
        ];

        $tong_san_pham++;
        $tong_ton_kho += (int)$ton_kho;
        $tong_gia_tri_nhap += $gia_tri_nhap;
        $tong_gia_tri_xuat += $gia_tri_xuat;

        // Thống kê theo danh mục
        $dm = $row['ten_danh_muc'] ?? 'Chưa phân loại';
        if (!isset($category_stats[$dm])) {
            $category_stats[$dm] = [
                'so_luong_sp' => 0,
                'tong_ton' => 0
            ];
        }
        $category_stats[$dm]['so_luong_sp']++;
        $category_stats[$dm]['tong_ton'] += (int)$ton_kho;
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_san_pham' => $tong_san_pham,
            'tong_ton_kho' => $tong_ton_kho,
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