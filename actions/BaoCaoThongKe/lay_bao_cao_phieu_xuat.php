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
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $bo_phan = isset($_GET['bo_phan']) ? $_GET['bo_phan'] : '';

    // Lấy danh sách phiếu xuất
    $sql = "
        SELECT 
            px.ma_phieu_xuat,
            px.ngay_tao,
            px.ma_kho,
            k.ten_kho,
            px.bo_phan_nguoi_nhan,
            px.so_mat_hang,
            px.tong_so_luong,
            px.tong_gia_tri,
            nd.ho_ten as nguoi_tao
        FROM phieu_xuat px
        LEFT JOIN kho k ON px.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON px.ma_nguoi_tao = nd.ma_nguoi_dung
        WHERE DATE(px.ngay_tao) BETWEEN ? AND ?
    ";

    if ($ma_kho > 0) {
        $sql .= " AND px.ma_kho = $ma_kho";
    }

    if (!empty($bo_phan)) {
        $sql .= " AND px.bo_phan_nguoi_nhan LIKE '%$bo_phan%'";
    }

    $sql .= " ORDER BY px.ngay_tao DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tu_ngay, $den_ngay);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Tách người nhận và bộ phận
        $nguoi_nhan = '';
        $bo_phan = '';
        if (!empty($row['bo_phan_nguoi_nhan'])) {
            $parts = explode('|', $row['bo_phan_nguoi_nhan']);
            $nguoi_nhan = $parts[0] ?? '';
            $bo_phan = $parts[1] ?? '';
        }

        $data[] = [
            'ma_phieu' => 'PXK-' . str_pad($row['ma_phieu_xuat'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => date('d/m/Y', strtotime($row['ngay_tao'])),
            'kho' => $row['ten_kho'] ?? '—',
            'nguoi_nhan' => $nguoi_nhan,
            'bo_phan' => $bo_phan,
            'so_mat_hang' => (int)$row['so_mat_hang'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'tong_gia_tri' => (float)$row['tong_gia_tri'],
            'nguoi_tao' => $row['nguoi_tao'] ?? '—'
        ];
    }

    // Thống kê theo bộ phận
    $dept_stats = [];
    foreach ($data as $item) {
        $bp = $item['bo_phan'] ?: 'Không xác định';
        if (!isset($dept_stats[$bp])) {
            $dept_stats[$bp] = [
                'so_phieu' => 0,
                'tong_so_luong' => 0,
                'tong_gia_tri' => 0
            ];
        }
        $dept_stats[$bp]['so_phieu']++;
        $dept_stats[$bp]['tong_so_luong'] += $item['tong_so_luong'];
        $dept_stats[$bp]['tong_gia_tri'] += $item['tong_gia_tri'];
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
            $daily_stats[$ngay] += $item['tong_gia_tri'];
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'tong_phieu' => count($data),
            'tong_so_luong' => array_sum(array_column($data, 'tong_so_luong')),
            'tong_gia_tri' => array_sum(array_column($data, 'tong_gia_tri')),
            'theo_bo_phan' => $dept_stats,
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