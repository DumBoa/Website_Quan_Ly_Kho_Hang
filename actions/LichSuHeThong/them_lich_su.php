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

    // Hàm này thường được gọi nội bộ từ các action khác
    // Không cần kiểm tra quyền vì nó chỉ ghi log

    $ma_nguoi_dung = isset($_POST['ma_nguoi_dung']) ? (int)$_POST['ma_nguoi_dung'] : 0;
    $hanh_dong = isset($_POST['hanh_dong']) ? trim($_POST['hanh_dong']) : '';
    $doi_tuong = isset($_POST['doi_tuong']) ? trim($_POST['doi_tuong']) : '';
    $ma_doi_tuong = isset($_POST['ma_doi_tuong']) ? trim($_POST['ma_doi_tuong']) : '';
    $chi_tiet = isset($_POST['chi_tiet']) ? trim($_POST['chi_tiet']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? trim($_POST['trang_thai']) : 'success';
    $du_lieu_truoc = isset($_POST['du_lieu_truoc']) ? $_POST['du_lieu_truoc'] : null;
    $du_lieu_sau = isset($_POST['du_lieu_sau']) ? $_POST['du_lieu_sau'] : null;

    // Lấy IP người dùng
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

    if (empty($hanh_dong)) {
        throw new Exception('Thiếu thông tin hành động');
    }

    if ($ma_nguoi_dung <= 0 && isset($_SESSION['ma_nguoi_dung'])) {
        $ma_nguoi_dung = $_SESSION['ma_nguoi_dung'];
    }

    $sql = "INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, trang_thai, du_lieu_truoc, du_lieu_sau) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssss", $ma_nguoi_dung, $hanh_dong, $doi_tuong, $ma_doi_tuong, $chi_tiet, $ip, $trang_thai, $du_lieu_truoc, $du_lieu_sau);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi ghi lịch sử: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Đã ghi lịch sử thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>