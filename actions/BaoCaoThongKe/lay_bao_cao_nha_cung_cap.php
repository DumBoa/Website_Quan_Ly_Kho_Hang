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
    $tu_ngay = isset($_GET['tu_ngay']) ? $_GET['tu_ngay'] : date('Y-m-01');
    $den_ngay = isset($_GET['den_ngay']) ? $_GET['den_ngay'] : date('Y-m-d');

    // Debug: Log tham số
    error_log("Tu ngay: $tu_ngay, Den ngay: $den_ngay");

    // Lấy danh sách nhà cung cấp và thống kê
    $sql = "
        SELECT 
            ncc.ma_nha_cung_cap,
            ncc.ten_nha_cung_cap,
            ncc.nguoi_lien_he,
            ncc.so_dien_thoai,
            ncc.email,
            COUNT(DISTINCT pn.ma_phieu_nhap) as so_phieu_nhap,
            COUNT(DISTINCT hh.ma_hang_hoa) as so_san_pham,
            COALESCE(SUM(pn.tong_so_luong), 0) as tong_so_luong,
            COALESCE(SUM(pn.tong_tien), 0) as tong_gia_tri
        FROM nha_cung_cap ncc
        LEFT JOIN hang_hoa hh ON ncc.ma_nha_cung_cap = hh.ma_nha_cung_cap
        LEFT JOIN phieu_nhap pn ON ncc.ma_nha_cung_cap = pn.ma_nha_cung_cap 
            AND DATE(pn.ngay_tao) BETWEEN ? AND ? AND pn.trang_thai = 1
        WHERE ncc.trang_thai = 1
        GROUP BY ncc.ma_nha_cung_cap
        ORDER BY tong_gia_tri DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tu_ngay, $den_ngay);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    $tong_ncc = 0;
    $tong_phieu = 0;
    $tong_sl = 0;
    $tong_gt = 0;
    $monthly_stats = [];

    while ($row = $result->fetch_assoc()) {
        // Chỉ thêm vào data nếu có dữ liệu
        if ($row['so_phieu_nhap'] > 0 || $row['so_san_pham'] > 0 || $row['tong_gia_tri'] > 0) {
            $data[] = [
                'ma_nha_cung_cap' => $row['ma_nha_cung_cap'],
                'ten_nha_cung_cap' => $row['ten_nha_cung_cap'],
                'nguoi_lien_he' => $row['nguoi_lien_he'] ?? '',
                'so_dien_thoai' => $row['so_dien_thoai'] ?? '',
                'email' => $row['email'] ?? '',
                'so_phieu_nhap' => (int)$row['so_phieu_nhap'],
                'so_san_pham' => (int)$row['so_san_pham'],
                'tong_so_luong' => (int)$row['tong_so_luong'],
                'tong_gia_tri' => (float)$row['tong_gia_tri']
            ];

            $tong_ncc++;
            $tong_phieu += (int)$row['so_phieu_nhap'];
            $tong_sl += (int)$row['tong_so_luong'];
            $tong_gt += (float)$row['tong_gia_tri'];
        }
    }

    // Thống kê theo tháng
    $thang_sql = "
        SELECT 
            MONTH(pn.ngay_tao) as thang,
            YEAR(pn.ngay_tao) as nam,
            COUNT(*) as so_phieu,
            SUM(pn.tong_so_luong) as tong_sl,
            SUM(pn.tong_tien) as tong_gt
        FROM phieu_nhap pn
        WHERE pn.trang_thai = 1 AND DATE(pn.ngay_tao) BETWEEN ? AND ?
        GROUP BY YEAR(pn.ngay_tao), MONTH(pn.ngay_tao)
        ORDER BY nam DESC, thang DESC
    ";
    
    $monthly_stmt = $conn->prepare($thang_sql);
    $monthly_stmt->bind_param("ss", $tu_ngay, $den_ngay);
    $monthly_stmt->execute();
    $monthly_result = $monthly_stmt->get_result();
    
    while ($row = $monthly_result->fetch_assoc()) {
        $key = "Tháng {$row['thang']}/{$row['nam']}";
        $monthly_stats[$key] = (float)$row['tong_gt'];
    }

    // Debug: Log kết quả
    error_log("So luong nha cung cap: " . count($data));
    error_log("Tong gia tri: " . $tong_gt);

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_nha_cung_cap' => $tong_ncc,
            'tong_phieu_nhap' => $tong_phieu,
            'tong_so_luong' => $tong_sl,
            'tong_gia_tri' => $tong_gt,
            'theo_thang' => $monthly_stats
        ]
    ]);

} catch (Exception $e) {
    error_log("Loi: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>