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

    if ($ma_nguoi_dung <= 0) {
        throw new Exception('Mã người dùng không hợp lệ');
    }

    // Không cho phép xóa chính mình
    if ($ma_nguoi_dung == $_SESSION['ma_nguoi_dung']) {
        throw new Exception('Không thể xóa tài khoản của chính mình');
    }

    // Kiểm tra người dùng có tồn tại không
    $check = $conn->prepare("SELECT ma_nguoi_dung FROM nguoi_dung WHERE ma_nguoi_dung = ?");
    $check->bind_param("i", $ma_nguoi_dung);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy người dùng');
    }
    $check->close();

    // Lấy thông tin ảnh đại diện để xóa file
    $avatar = $conn->prepare("SELECT anh_dai_dien FROM nguoi_dung WHERE ma_nguoi_dung = ?");
    $avatar->bind_param("i", $ma_nguoi_dung);
    $avatar->execute();
    $avatarResult = $avatar->get_result();
    $user = $avatarResult->fetch_assoc();
    $avatar->close();

    // Xóa người dùng
    $sql = "DELETE FROM nguoi_dung WHERE ma_nguoi_dung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nguoi_dung);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa người dùng: ' . $stmt->error);
    }

    // Xóa file ảnh đại diện nếu có
    if (!empty($user['anh_dai_dien'])) {
        $file_path = '../../uploads/avatars/' . $user['anh_dai_dien'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa người dùng thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>