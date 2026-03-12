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
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $ma_nguoi_dung = isset($_GET['ma_nguoi_dung']) ? (int)$_GET['ma_nguoi_dung'] : 0;
    $hanh_dong = isset($_GET['hanh_dong']) ? trim($_GET['hanh_dong']) : '';
    $trang_thai = isset($_GET['trang_thai']) ? trim($_GET['trang_thai']) : '';
    $tu_ngay = isset($_GET['tu_ngay']) ? $_GET['tu_ngay'] : '';
    $den_ngay = isset($_GET['den_ngay']) ? $_GET['den_ngay'] : '';

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            ls.*,
            nd.ho_ten,
            nd.ten_dang_nhap,
            vt.ten_vai_tro
        FROM lich_su_he_thong ls
        LEFT JOIN nguoi_dung nd ON ls.ma_nguoi_dung = nd.ma_nguoi_dung
        LEFT JOIN vai_tro vt ON nd.ma_vai_tro = vt.ma_vai_tro
        WHERE 1=1
    ";

    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (ls.hanh_dong LIKE '%$search%' OR ls.chi_tiet LIKE '%$search%' OR nd.ho_ten LIKE '%$search%')";
    }
    if ($ma_nguoi_dung > 0) {
        $sql .= " AND ls.ma_nguoi_dung = $ma_nguoi_dung";
    }
    if (!empty($hanh_dong)) {
        $hanh_dong = $conn->real_escape_string($hanh_dong);
        $sql .= " AND ls.hanh_dong = '$hanh_dong'";
    }
    if (!empty($trang_thai)) {
        $trang_thai = $conn->real_escape_string($trang_thai);
        $sql .= " AND ls.trang_thai = '$trang_thai'";
    }
    if (!empty($tu_ngay)) {
        $sql .= " AND DATE(ls.thoi_gian) >= '$tu_ngay'";
    }
    if (!empty($den_ngay)) {
        $sql .= " AND DATE(ls.thoi_gian) <= '$den_ngay'";
    }

    $sql .= " ORDER BY ls.thoi_gian DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    // Đếm thống kê cho hôm nay
    $today = date('Y-m-d');
    $stats_sql = "
        SELECT 
            COUNT(*) as tong_hoat_dong,
            SUM(CASE WHEN DATE(thoi_gian) = '$today' THEN 1 ELSE 0 END) as hom_nay,
            SUM(CASE WHEN hanh_dong LIKE '%dang nhap%' AND DATE(thoi_gian) = '$today' THEN 1 ELSE 0 END) as dang_nhap_hom_nay,
            SUM(CASE WHEN hanh_dong LIKE '%tao phieu%' AND DATE(thoi_gian) = '$today' THEN 1 ELSE 0 END) as tao_phieu_hom_nay,
            SUM(CASE WHEN hanh_dong LIKE '%sua%' AND DATE(thoi_gian) = '$today' THEN 1 ELSE 0 END) as chinh_sua_hom_nay
        FROM lich_su_he_thong
    ";
    $stats_result = $conn->query($stats_sql);
    $stats = $stats_result->fetch_assoc();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Xử lý thông tin trước/sau thay đổi nếu có
        $truoc = null;
        $sau = null;
        if (!empty($row['du_lieu_truoc']) && $row['du_lieu_truoc'] !== 'null') {
            $truoc = json_decode($row['du_lieu_truoc'], true);
        }
        if (!empty($row['du_lieu_sau']) && $row['du_lieu_sau'] !== 'null') {
            $sau = json_decode($row['du_lieu_sau'], true);
        }

        $data[] = [
            'ma_lich_su' => (int)$row['ma_lich_su'],
            'thoi_gian' => $row['thoi_gian'],
            'ma_nguoi_dung' => (int)$row['ma_nguoi_dung'],
            'nguoi_dung' => $row['ho_ten'] ?? 'Không xác định',
            'ten_dang_nhap' => $row['ten_dang_nhap'] ?? '',
            'vai_tro' => $row['ten_vai_tro'] ?? '',
            'hanh_dong' => $row['hanh_dong'],
            'doi_tuong' => $row['doi_tuong'],
            'ma_doi_tuong' => $row['ma_doi_tuong'],
            'chi_tiet' => $row['chi_tiet'],
            'ip' => $row['ip'],
            'trang_thai' => $row['trang_thai'],
            'du_lieu_truoc' => $truoc,
            'du_lieu_sau' => $sau
        ];
    }

    echo json_encode([
        'success' => true, 
        'data' => $data,
        'stats' => [
            'hom_nay' => (int)($stats['hom_nay'] ?? 0),
            'dang_nhap_hom_nay' => (int)($stats['dang_nhap_hom_nay'] ?? 0),
            'tao_phieu_hom_nay' => (int)($stats['tao_phieu_hom_nay'] ?? 0),
            'chinh_sua_hom_nay' => (int)($stats['chinh_sua_hom_nay'] ?? 0),
            'tong_hoat_dong' => (int)($stats['tong_hoat_dong'] ?? 0)
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>