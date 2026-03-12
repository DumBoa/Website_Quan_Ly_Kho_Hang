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

    // Kiểm tra quyền
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if ($vai_tro !== 'ADMIN') {
        throw new Exception('Bạn không có quyền truy cập chức năng này');
    }

    $ma_nguoi_dung = isset($_GET['ma_nguoi_dung']) ? (int)$_GET['ma_nguoi_dung'] : 0;

    if ($ma_nguoi_dung <= 0) {
        throw new Exception('Mã người dùng không hợp lệ');
    }

    $sql = "
        SELECT 
            nd.*,
            vt.ten_vai_tro
        FROM nguoi_dung nd
        LEFT JOIN vai_tro vt ON nd.ma_vai_tro = vt.ma_vai_tro
        WHERE nd.ma_nguoi_dung = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nguoi_dung);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy người dùng');
    }

    $row = $result->fetch_assoc();

    // Xử lý đường dẫn ảnh đại diện
    $anh_dai_dien = $row['anh_dai_dien'];
    if ($anh_dai_dien && file_exists('../../uploads/avatars/' . $anh_dai_dien)) {
        $anh_dai_dien = '/Project_QuanLyKhoHang/uploads/avatars/' . $anh_dai_dien;
    } else {
        $anh_dai_dien = null;
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ma_nguoi_dung' => (int)$row['ma_nguoi_dung'],
            'ten_dang_nhap' => $row['ten_dang_nhap'],
            'ho_ten' => $row['ho_ten'],
            'email' => $row['email'],
            'so_dien_thoai' => $row['so_dien_thoai'] ?? '',
            'ma_vai_tro' => (int)$row['ma_vai_tro'],
            'ten_vai_tro' => $row['ten_vai_tro'],
            'trang_thai' => (int)$row['trang_thai'],
            'ngay_tao' => $row['ngay_tao'],
            'ngay_cap_nhat' => $row['ngay_cap_nhat'],
            'anh_dai_dien' => $anh_dai_dien
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>