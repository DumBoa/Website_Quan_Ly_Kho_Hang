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

    $ma_hang_hoa = isset($_GET['ma_hang_hoa']) ? (int)$_GET['ma_hang_hoa'] : 0;

    if ($ma_hang_hoa <= 0) {
        throw new Exception('Mã hàng hóa không hợp lệ');
    }

    // Lấy thông tin chi tiết tồn kho theo từng kho
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
            hh.ton_toi_thieu,
            (SELECT SUM(so_luong) FROM chi_tiet_phieu_nhap WHERE ma_hang_hoa = hh.ma_hang_hoa) as tong_nhap,
            (SELECT SUM(so_luong) FROM chi_tiet_phieu_xuat WHERE ma_hang_hoa = hh.ma_hang_hoa) as tong_xuat
        FROM ton_kho tk
        INNER JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN kho k ON tk.ma_kho = k.ma_kho
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE tk.ma_hang_hoa = ?
        ORDER BY k.ten_kho
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_hang_hoa);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy thông tin tồn kho');
    }

    $ton_kho_theo_kho = [];
    $tong_so_luong = 0;
    $tong_gia_tri = 0;
    $thong_tin_sp = null;

    while ($row = $result->fetch_assoc()) {
        if (!$thong_tin_sp) {
            $thong_tin_sp = [
                'ma_hang_hoa' => (int)$row['ma_hang_hoa'],
                'ma_san_pham' => $row['ma_san_pham'],
                'ten_hang_hoa' => $row['ten_hang_hoa'],
                'ma_danh_muc' => (int)$row['ma_danh_muc'],
                'ten_danh_muc' => $row['ten_danh_muc'],
                'gia_nhap' => (float)$row['gia_nhap'],
                'gia_ban' => (float)$row['gia_ban'],
                'ton_toi_thieu' => (int)$row['ton_toi_thieu'],
                'tong_nhap' => (int)$row['tong_nhap'],
                'tong_xuat' => (int)$row['tong_xuat']
            ];
        }

        $ton_kho_theo_kho[] = [
            'ma_kho' => (int)$row['ma_kho'],
            'ten_kho' => $row['ten_kho'],
            'so_luong' => (int)$row['so_luong']
        ];

        $tong_so_luong += (int)$row['so_luong'];
        $tong_gia_tri += (int)$row['so_luong'] * (float)$row['gia_nhap'];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'thong_tin_sp' => $thong_tin_sp,
            'ton_kho_theo_kho' => $ton_kho_theo_kho,
            'tong_so_luong' => $tong_so_luong,
            'tong_gia_tri' => $tong_gia_tri
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>