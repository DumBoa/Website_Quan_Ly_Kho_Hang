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

    // Kiểm tra quyền (chỉ QUAN_LY và ADMIN mới được duyệt)
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if (!in_array($vai_tro, ['QUAN_LY', 'ADMIN'])) {
        throw new Exception('Bạn không có quyền truy cập chức năng này');
    }

    // Lấy tham số lọc
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $nguoi_nhan = isset($_GET['nguoi_nhan']) ? trim($_GET['nguoi_nhan']) : '';
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';
    $tu_ngay = isset($_GET['tu_ngay']) ? $_GET['tu_ngay'] : '';
    $den_ngay = isset($_GET['den_ngay']) ? $_GET['den_ngay'] : '';

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            px.ma_phieu_xuat,
            px.ma_kho,
            k.ten_kho,
            px.bo_phan_nguoi_nhan,
            px.so_mat_hang,
            px.tong_so_luong,
            px.tong_gia_tri,
            px.trang_thai,
            px.ghi_chu,
            px.ngay_tao,
            px.ngay_duyet,
            nd.ho_ten as nguoi_tao,
            nd2.ho_ten as nguoi_duyet
        FROM phieu_xuat px
        LEFT JOIN kho k ON px.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON px.ma_nguoi_tao = nd.ma_nguoi_dung
        LEFT JOIN nguoi_dung nd2 ON px.ma_nguoi_duyet = nd2.ma_nguoi_dung
        WHERE 1=1
    ";

    // Thêm điều kiện lọc
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (px.ma_phieu_xuat LIKE '%$search%' OR px.ghi_chu LIKE '%$search%')";
    }
    if ($ma_kho > 0) {
        $sql .= " AND px.ma_kho = $ma_kho";
    }
    if (!empty($nguoi_nhan)) {
        $nguoi_nhan = $conn->real_escape_string($nguoi_nhan);
        $sql .= " AND px.bo_phan_nguoi_nhan LIKE '%$nguoi_nhan%'";
    }
    if ($trang_thai !== '') {
        $sql .= " AND px.trang_thai = " . (int)$trang_thai;
    }
    if (!empty($tu_ngay)) {
        $sql .= " AND DATE(px.ngay_tao) >= '$tu_ngay'";
    }
    if (!empty($den_ngay)) {
        $sql .= " AND DATE(px.ngay_tao) <= '$den_ngay'";
    }

    $sql .= " ORDER BY px.ngay_tao DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    // Đếm số lượng theo trạng thái
    $count_sql = "SELECT 
                    SUM(CASE WHEN trang_thai = 0 THEN 1 ELSE 0 END) as cho_duyet,
                    SUM(CASE WHEN trang_thai = 1 THEN 1 ELSE 0 END) as da_duyet,
                    SUM(CASE WHEN trang_thai = 2 THEN 1 ELSE 0 END) as tu_choi,
                    COUNT(*) as tong
                  FROM phieu_xuat";
    $count_result = $conn->query($count_sql);
    $counts = $count_result->fetch_assoc();

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
            'ma_phieu_xuat' => (int)$row['ma_phieu_xuat'],
            'ma_phieu' => 'PXK-' . str_pad($row['ma_phieu_xuat'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => $row['ngay_tao'],
            'ma_kho' => $row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? '—',
            'nguoi_nhan' => $nguoi_nhan,
            'bo_phan' => $bo_phan,
            'so_mat_hang' => (int)$row['so_mat_hang'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'tong_gia_tri' => (float)$row['tong_gia_tri'],
            'trang_thai' => (int)$row['trang_thai'],
            'ghi_chu' => $row['ghi_chu'] ?? '',
            'ngay_duyet' => $row['ngay_duyet'],
            'nguoi_tao' => $row['nguoi_tao'] ?? '—',
            'nguoi_duyet' => $row['nguoi_duyet'] ?? '—'
        ];
    }

    echo json_encode([
        'success' => true, 
        'data' => $data,
        'counts' => [
            'cho_duyet' => (int)$counts['cho_duyet'],
            'da_duyet' => (int)$counts['da_duyet'],
            'tu_choi' => (int)$counts['tu_choi'],
            'tong' => (int)$counts['tong']
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>