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

    // Kiểm tra quyền (chỉ ADMIN mới được quản lý vai trò)
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if ($vai_tro !== 'ADMIN') {
        throw new Exception('Bạn không có quyền truy cập chức năng này');
    }

    // Lấy tham số lọc
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';

    // Xây dựng câu truy vấn
    $sql = "SELECT vt.*, COUNT(nd.ma_nguoi_dung) as so_nguoi_dung
            FROM vai_tro vt
            LEFT JOIN nguoi_dung nd ON vt.ma_vai_tro = nd.ma_vai_tro
            WHERE 1=1";

    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (vt.ten_vai_tro LIKE '%$search%' OR vt.mo_ta LIKE '%$search%')";
    }

    if ($trang_thai !== '') {
        $sql .= " AND vt.trang_thai = " . (int)$trang_thai;
    }

    $sql .= " GROUP BY vt.ma_vai_tro ORDER BY vt.ma_vai_tro";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_vai_tro' => (int)$row['ma_vai_tro'],
            'ten_vai_tro' => $row['ten_vai_tro'],
            'mo_ta' => $row['mo_ta'] ?? '',
            'so_nguoi_dung' => (int)$row['so_nguoi_dung'],
            'trang_thai' => (int)$row['trang_thai'],
            'ngay_tao' => $row['ngay_tao']
        ];
    }

    echo json_encode([
        'success' => true, 
        'data' => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>