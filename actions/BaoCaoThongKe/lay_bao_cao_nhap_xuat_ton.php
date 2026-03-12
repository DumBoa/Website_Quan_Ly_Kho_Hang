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
    $thang = isset($_GET['thang']) ? (int)$_GET['thang'] : (int)date('m');
    $nam = isset($_GET['nam']) ? (int)$_GET['nam'] : (int)date('Y');
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;

    $ngay_dau_thang = "$nam-$thang-01";
    $ngay_cuoi_thang = date('Y-m-t', strtotime($ngay_dau_thang));

    // Lấy danh sách sản phẩm
    $sql = "SELECT ma_hang_hoa, ma_san_pham, ten_hang_hoa, ma_danh_muc FROM hang_hoa WHERE trang_thai = 1";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Tính tồn đầu kỳ (trước ngày đầu tháng)
        $ton_dau_sql = "
            SELECT SUM(so_luong) as ton_dau
            FROM ton_kho 
            WHERE ma_hang_hoa = ? AND ma_kho = ?
        ";
        $stmt = $conn->prepare($ton_dau_sql);
        $stmt->bind_param("ii", $row['ma_hang_hoa'], $ma_kho);
        $stmt->execute();
        $ton_dau_result = $stmt->get_result();
        $ton_dau = $ton_dau_result->fetch_assoc()['ton_dau'] ?? 0;
        $stmt->close();

        // Tính tổng nhập trong tháng
        $nhap_sql = "
            SELECT SUM(so_luong) as tong_nhap
            FROM chi_tiet_phieu_nhap ct
            JOIN phieu_nhap pn ON ct.ma_phieu_nhap = pn.ma_phieu_nhap
            WHERE ct.ma_hang_hoa = ? AND pn.ma_kho = ? 
            AND DATE(pn.ngay_tao) BETWEEN ? AND ? AND pn.trang_thai = 1
        ";
        $stmt = $conn->prepare($nhap_sql);
        $stmt->bind_param("iiss", $row['ma_hang_hoa'], $ma_kho, $ngay_dau_thang, $ngay_cuoi_thang);
        $stmt->execute();
        $nhap_result = $stmt->get_result();
        $tong_nhap = $nhap_result->fetch_assoc()['tong_nhap'] ?? 0;
        $stmt->close();

        // Tính tổng xuất trong tháng
        $xuat_sql = "
            SELECT SUM(so_luong) as tong_xuat
            FROM chi_tiet_phieu_xuat ct
            JOIN phieu_xuat px ON ct.ma_phieu_xuat = px.ma_phieu_xuat
            WHERE ct.ma_hang_hoa = ? AND px.ma_kho = ? 
            AND DATE(px.ngay_tao) BETWEEN ? AND ? AND px.trang_thai = 1
        ";
        $stmt = $conn->prepare($xuat_sql);
        $stmt->bind_param("iiss", $row['ma_hang_hoa'], $ma_kho, $ngay_dau_thang, $ngay_cuoi_thang);
        $stmt->execute();
        $xuat_result = $stmt->get_result();
        $tong_xuat = $xuat_result->fetch_assoc()['tong_xuat'] ?? 0;
        $stmt->close();

        // Tính tồn cuối kỳ
        $ton_cuoi = $ton_dau + $tong_nhap - $tong_xuat;

        $data[] = [
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_san_pham' => $row['ten_hang_hoa'],
            'ton_dau' => (int)$ton_dau,
            'tong_nhap' => (int)$tong_nhap,
            'tong_xuat' => (int)$tong_xuat,
            'ton_cuoi' => (int)$ton_cuoi
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'thang' => $thang,
            'nam' => $nam,
            'tong_ton_dau' => array_sum(array_column($data, 'ton_dau')),
            'tong_nhap' => array_sum(array_column($data, 'tong_nhap')),
            'tong_xuat' => array_sum(array_column($data, 'tong_xuat')),
            'tong_ton_cuoi' => array_sum(array_column($data, 'ton_cuoi'))
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>