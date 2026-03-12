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

    // Kiểm tra quyền (chỉ ADMIN mới được quản lý người dùng)
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if ($vai_tro !== 'ADMIN') {
        throw new Exception('Bạn không có quyền truy cập chức năng này');
    }

    // Lấy tham số lọc
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $ma_vai_tro = isset($_GET['ma_vai_tro']) ? (int)$_GET['ma_vai_tro'] : 0;
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            nd.ma_nguoi_dung,
            nd.ten_dang_nhap,
            nd.ho_ten,
            nd.email,
            nd.so_dien_thoai,
            nd.ma_vai_tro,
            vt.ten_vai_tro,
            nd.trang_thai,
            nd.ngay_tao,
            nd.anh_dai_dien
        FROM nguoi_dung nd
        LEFT JOIN vai_tro vt ON nd.ma_vai_tro = vt.ma_vai_tro
        WHERE 1=1
    ";

    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (nd.ho_ten LIKE '%$search%' OR nd.ten_dang_nhap LIKE '%$search%' OR nd.email LIKE '%$search%')";
    }
    if ($ma_vai_tro > 0) {
        $sql .= " AND nd.ma_vai_tro = $ma_vai_tro";
    }
    if ($trang_thai !== '') {
        $sql .= " AND nd.trang_thai = " . (int)$trang_thai;
    }

    $sql .= " ORDER BY nd.ngay_tao DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Xử lý đường dẫn ảnh đại diện
        $anh_dai_dien = $row['anh_dai_dien'];
        if ($anh_dai_dien && file_exists('../../uploads/avatars/' . $anh_dai_dien)) {
            $anh_dai_dien = '/Project_QuanLyKhoHang/uploads/avatars/' . $anh_dai_dien;
        } else {
            $anh_dai_dien = null;
        }

        $data[] = [
            'ma_nguoi_dung' => (int)$row['ma_nguoi_dung'],
            'ten_dang_nhap' => $row['ten_dang_nhap'],
            'ho_ten' => $row['ho_ten'],
            'email' => $row['email'],
            'so_dien_thoai' => $row['so_dien_thoai'] ?? '',
            'ma_vai_tro' => (int)$row['ma_vai_tro'],
            'ten_vai_tro' => $row['ten_vai_tro'] ?? '',
            'trang_thai' => (int)$row['trang_thai'],
            'ngay_tao' => $row['ngay_tao'],
            'anh_dai_dien' => $anh_dai_dien
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