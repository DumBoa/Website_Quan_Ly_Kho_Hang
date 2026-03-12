<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Phương thức không hợp lệ');
    }

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    // Kiểm tra quyền (chỉ ADMIN và QUAN_LY mới được cập nhật)
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if (!in_array($vai_tro, ['ADMIN', 'QUAN_LY'])) {
        throw new Exception('Bạn không có quyền thực hiện chức năng này');
    }

    $ma_hang_hoa = isset($_POST['ma_hang_hoa']) ? (int)$_POST['ma_hang_hoa'] : 0;
    $ton_toi_thieu = isset($_POST['ton_toi_thieu']) ? (int)$_POST['ton_toi_thieu'] : 0;

    if ($ma_hang_hoa <= 0) {
        throw new Exception('Mã hàng hóa không hợp lệ');
    }

    if ($ton_toi_thieu < 0) {
        throw new Exception('Tồn tối thiểu không được âm');
    }

    $sql = "UPDATE hang_hoa SET ton_toi_thieu = ? WHERE ma_hang_hoa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $ton_toi_thieu, $ma_hang_hoa);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật tồn tối thiểu: ' . $stmt->error);
    }

    $stmt->close();

    // Ghi lịch sử
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $history_sql = "INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip) 
                    VALUES (?, 'Cập nhật tồn tối thiểu', 'hang_hoa', ?, ?, ?)";
    $history_stmt = $conn->prepare($history_sql);
    $chi_tiet = "Cập nhật tồn tối thiểu sản phẩm ID $ma_hang_hoa thành $ton_toi_thieu";
    $history_stmt->bind_param("iiss", $_SESSION['ma_nguoi_dung'], $ma_hang_hoa, $chi_tiet, $ip);
    $history_stmt->execute();
    $history_stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Cập nhật tồn tối thiểu thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>