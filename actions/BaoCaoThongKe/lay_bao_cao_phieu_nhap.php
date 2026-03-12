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
    $ma_nha_cung_cap = isset($_GET['ma_nha_cung_cap']) ? (int)$_GET['ma_nha_cung_cap'] : 0;
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;

    // Lấy danh sách phiếu nhập
    $sql = "
        SELECT 
            pn.ma_phieu_nhap,
            pn.ngay_tao,
            pn.ma_nha_cung_cap,
            ncc.ten_nha_cung_cap,
            k.ten_kho,
            pn.so_mat_hang,
            pn.tong_so_luong,
            pn.tong_tien,
            nd.ho_ten as nguoi_tao
        FROM phieu_nhap pn
        LEFT JOIN nha_cung_cap ncc ON pn.ma_nha_cung_cap = ncc.ma_nha_cung_cap
        LEFT JOIN kho k ON pn.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON pn.ma_nguoi_tao = nd.ma_nguoi_dung
        WHERE DATE(pn.ngay_tao) BETWEEN ? AND ?
    ";

    if ($ma_nha_cung_cap > 0) {
        $sql .= " AND pn.ma_nha_cung_cap = $ma_nha_cung_cap";
    }

    if ($ma_kho > 0) {
        $sql .= " AND pn.ma_kho = $ma_kho";
    }

    $sql .= " ORDER BY pn.ngay_tao DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tu_ngay, $den_ngay);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_phieu' => 'PNK-' . str_pad($row['ma_phieu_nhap'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => date('d/m/Y', strtotime($row['ngay_tao'])),
            'nha_cung_cap' => $row['ten_nha_cung_cap'] ?? '—',
            'kho' => $row['ten_kho'] ?? '—',
            'so_mat_hang' => (int)$row['so_mat_hang'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'tong_tien' => (float)$row['tong_tien'],
            'nguoi_tao' => $row['nguoi_tao'] ?? '—'
        ];
    }

    // Thống kê theo nhà cung cấp
    $supplier_stats = [];
    foreach ($data as $item) {
        $ncc = $item['nha_cung_cap'];
        if (!isset($supplier_stats[$ncc])) {
            $supplier_stats[$ncc] = [
                'so_phieu' => 0,
                'tong_so_luong' => 0,
                'tong_gia_tri' => 0
            ];
        }
        $supplier_stats[$ncc]['so_phieu']++;
        $supplier_stats[$ncc]['tong_so_luong'] += $item['tong_so_luong'];
        $supplier_stats[$ncc]['tong_gia_tri'] += $item['tong_tien'];
    }

    // Thống kê theo ngày
    $daily_stats = [];
    $current = strtotime($tu_ngay);
    $end = strtotime($den_ngay);
    
    while ($current <= $end) {
        $date = date('Y-m-d', $current);
        $daily_stats[date('d/m', $current)] = 0;
        $current = strtotime('+1 day', $current);
    }

    foreach ($data as $item) {
        $ngay = date('d/m', strtotime($item['ngay_tao']));
        if (isset($daily_stats[$ngay])) {
            $daily_stats[$ngay] += $item['tong_tien'];
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_phieu' => count($data),
            'tong_so_luong' => array_sum(array_column($data, 'tong_so_luong')),
            'tong_gia_tri' => array_sum(array_column($data, 'tong_tien')),
            'theo_ncc' => $supplier_stats,
            'theo_ngay' => $daily_stats
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>