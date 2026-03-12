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

    // Kiểm tra quyền
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if ($vai_tro !== 'ADMIN') {
        throw new Exception('Bạn không có quyền thực hiện chức năng này');
    }

    $ma_nguoi_dung = isset($_POST['ma_nguoi_dung']) ? (int)$_POST['ma_nguoi_dung'] : 0;
    $mat_khau_moi = isset($_POST['mat_khau_moi']) ? $_POST['mat_khau_moi'] : '';

    if ($ma_nguoi_dung <= 0) {
        throw new Exception('Mã người dùng không hợp lệ');
    }

    if (empty($mat_khau_moi)) {
        throw new Exception('Vui lòng nhập mật khẩu mới');
    }

    if (strlen($mat_khau_moi) < 6) {
        throw new Exception('Mật khẩu phải có ít nhất 6 ký tự');
    }

    $mat_khau_hash = password_hash($mat_khau_moi, PASSWORD_DEFAULT);

    $sql = "UPDATE nguoi_dung SET mat_khau = ? WHERE ma_nguoi_dung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $mat_khau_hash, $ma_nguoi_dung);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi đổi mật khẩu: ' . $stmt->error);
    }

    $stmt->close();

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