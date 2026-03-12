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
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0;

    if ($ma_nguoi_dung <= 0) {
        throw new Exception('Mã người dùng không hợp lệ');
    }

    // Không cho phép tự khóa chính mình
    if ($ma_nguoi_dung == $_SESSION['ma_nguoi_dung']) {
        throw new Exception('Không thể thay đổi trạng thái của chính mình');
    }

    $sql = "UPDATE nguoi_dung SET trang_thai = ? WHERE ma_nguoi_dung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $trang_thai, $ma_nguoi_dung);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật trạng thái: ' . $stmt->error);
    }

    $stmt->close();

    $message = $trang_thai == 1 ? 'Đã mở khóa tài khoản' : 'Đã khóa tài khoản';

    echo json_encode([
        'success' => true, 
        'message' => $message
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>