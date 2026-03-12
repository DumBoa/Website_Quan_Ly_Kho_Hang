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

    $ma_nguoi_dung = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;

    if ($ma_nguoi_dung <= 0) {
        throw new Exception('Không xác định được người dùng');
    }

    // Lấy thông tin người dùng
    $sql = "SELECT nd.*, vt.ten_vai_tro
            FROM nguoi_dung nd
            LEFT JOIN vai_tro vt ON nd.ma_vai_tro = vt.ma_vai_tro
            WHERE nd.ma_nguoi_dung = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nguoi_dung);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy thông tin người dùng');
    }

    $user = $result->fetch_assoc();

    // Xử lý đường dẫn ảnh đại diện
    $anh_dai_dien = $user['anh_dai_dien'];
    if ($anh_dai_dien && file_exists('../../uploads/avatars/' . $anh_dai_dien)) {
        $anh_dai_dien = '/Project_QuanLyKhoHang/uploads/avatars/' . $anh_dai_dien;
    } else {
        $anh_dai_dien = null;
    }

    // Lấy hoạt động gần đây của người dùng
    $activity_sql = "SELECT hanh_dong, thoi_gian FROM lich_su_he_thong 
                     WHERE ma_nguoi_dung = ? 
                     ORDER BY thoi_gian DESC 
                     LIMIT 10";
    $activity_stmt = $conn->prepare($activity_sql);
    $activity_stmt->bind_param("i", $ma_nguoi_dung);
    $activity_stmt->execute();
    $activity_result = $activity_stmt->get_result();
    
    $activities = [];
    while ($act = $activity_result->fetch_assoc()) {
        $activities[] = [
            'hanh_dong' => $act['hanh_dong'],
            'thoi_gian' => $act['thoi_gian']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ma_nguoi_dung' => (int)$user['ma_nguoi_dung'],
            'ten_dang_nhap' => $user['ten_dang_nhap'],
            'ho_ten' => $user['ho_ten'],
            'email' => $user['email'],
            'so_dien_thoai' => $user['so_dien_thoai'] ?? '',
            'ma_vai_tro' => (int)$user['ma_vai_tro'],
            'ten_vai_tro' => $user['ten_vai_tro'] ?? '',
            'trang_thai' => (int)$user['trang_thai'],
            'ngay_tao' => $user['ngay_tao'],
            'anh_dai_dien' => $anh_dai_dien,
            'activities' => $activities
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>