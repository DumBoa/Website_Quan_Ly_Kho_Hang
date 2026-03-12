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

    $ma_nguoi_dung = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;

    if ($ma_nguoi_dung <= 0) {
        throw new Exception('Không xác định được người dùng');
    }

    $mat_khau_cu = isset($_POST['mat_khau_cu']) ? $_POST['mat_khau_cu'] : '';
    $mat_khau_moi = isset($_POST['mat_khau_moi']) ? $_POST['mat_khau_moi'] : '';
    $xac_nhan = isset($_POST['xac_nhan']) ? $_POST['xac_nhan'] : '';

    // Validate
    if (empty($mat_khau_cu)) {
        throw new Exception('Vui lòng nhập mật khẩu hiện tại');
    }

    if (empty($mat_khau_moi)) {
        throw new Exception('Vui lòng nhập mật khẩu mới');
    }

    if (strlen($mat_khau_moi) < 6) {
        throw new Exception('Mật khẩu mới phải có ít nhất 6 ký tự');
    }

    if ($mat_khau_moi !== $xac_nhan) {
        throw new Exception('Mật khẩu xác nhận không khớp');
    }

    if ($mat_khau_cu === $mat_khau_moi) {
        throw new Exception('Mật khẩu mới phải khác mật khẩu cũ');
    }

    // Kiểm tra mật khẩu cũ
    $check = $conn->prepare("SELECT mat_khau FROM nguoi_dung WHERE ma_nguoi_dung = ?");
    $check->bind_param("i", $ma_nguoi_dung);
    $check->execute();
    $result = $check->get_result();
    $user = $result->fetch_assoc();
    $check->close();

    if (!password_verify($mat_khau_cu, $user['mat_khau'])) {
        throw new Exception('Mật khẩu hiện tại không đúng');
    }

    // Mã hóa mật khẩu mới
    $mat_khau_hash = password_hash($mat_khau_moi, PASSWORD_DEFAULT);

    // Cập nhật mật khẩu
    $sql = "UPDATE nguoi_dung SET mat_khau = ? WHERE ma_nguoi_dung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $mat_khau_hash, $ma_nguoi_dung);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi đổi mật khẩu: ' . $stmt->error);
    }

    $stmt->close();

    // Ghi lịch sử
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $history_sql = "INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip) 
                    VALUES (?, 'Đổi mật khẩu', 'nguoi_dung', ?, 'Thay đổi mật khẩu', ?)";
    $history_stmt = $conn->prepare($history_sql);
    $history_stmt->bind_param("iis", $ma_nguoi_dung, $ma_nguoi_dung, $ip);
    $history_stmt->execute();
    $history_stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Đổi mật khẩu thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>