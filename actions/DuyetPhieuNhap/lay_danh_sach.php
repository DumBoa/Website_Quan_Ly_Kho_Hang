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
    $ma_ncc = isset($_GET['ma_ncc']) ? (int)$_GET['ma_ncc'] : 0;
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';
    $tu_ngay = isset($_GET['tu_ngay']) ? $_GET['tu_ngay'] : '';
    $den_ngay = isset($_GET['den_ngay']) ? $_GET['den_ngay'] : '';

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            pn.ma_phieu_nhap,
            pn.ma_kho,
            k.ten_kho,
            pn.ma_nha_cung_cap,
            ncc.ten_nha_cung_cap,
            pn.so_mat_hang,
            pn.tong_so_luong,
            pn.tong_tien,
            pn.trang_thai,
            pn.ghi_chu,
            pn.ngay_tao,
            pn.ngay_duyet,
            nd.ho_ten as nguoi_tao,
            nd2.ho_ten as nguoi_duyet
        FROM phieu_nhap pn
        LEFT JOIN kho k ON pn.ma_kho = k.ma_kho
        LEFT JOIN nha_cung_cap ncc ON pn.ma_nha_cung_cap = ncc.ma_nha_cung_cap
        LEFT JOIN nguoi_dung nd ON pn.ma_nguoi_tao = nd.ma_nguoi_dung
        LEFT JOIN nguoi_dung nd2 ON pn.ma_nguoi_duyet = nd2.ma_nguoi_dung
        WHERE 1=1
    ";

    // Thêm điều kiện lọc
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (pn.ma_phieu_nhap LIKE '%$search%' OR pn.ghi_chu LIKE '%$search%')";
    }
    if ($ma_kho > 0) {
        $sql .= " AND pn.ma_kho = $ma_kho";
    }
    if ($ma_ncc > 0) {
        $sql .= " AND pn.ma_nha_cung_cap = $ma_ncc";
    }
    if ($trang_thai !== '') {
        $sql .= " AND pn.trang_thai = " . (int)$trang_thai;
    }
    if (!empty($tu_ngay)) {
        $sql .= " AND DATE(pn.ngay_tao) >= '$tu_ngay'";
    }
    if (!empty($den_ngay)) {
        $sql .= " AND DATE(pn.ngay_tao) <= '$den_ngay'";
    }

    $sql .= " ORDER BY pn.ngay_tao DESC";

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
                  FROM phieu_nhap";
    $count_result = $conn->query($count_sql);
    $counts = $count_result->fetch_assoc();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_phieu_nhap' => (int)$row['ma_phieu_nhap'],
            'ma_phieu' => 'PNK-' . str_pad($row['ma_phieu_nhap'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => $row['ngay_tao'],
            'ma_kho' => $row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? '—',
            'ma_nha_cung_cap' => $row['ma_nha_cung_cap'],
            'ten_nha_cung_cap' => $row['ten_nha_cung_cap'] ?? '—',
            'so_mat_hang' => (int)$row['so_mat_hang'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'tong_tien' => (float)$row['tong_tien'],
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