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

    // Lấy thông tin ảnh cũ
    $avatar = $conn->prepare("SELECT anh_dai_dien FROM nguoi_dung WHERE ma_nguoi_dung = ?");
    $avatar->bind_param("i", $ma_nguoi_dung);
    $avatar->execute();
    $result = $avatar->get_result();
    $user = $result->fetch_assoc();
    $avatar->close();

    $anh_cu = $user['anh_dai_dien'] ?? '';

    // Cập nhật database (xóa ảnh)
    $sql = "UPDATE nguoi_dung SET anh_dai_dien = NULL WHERE ma_nguoi_dung = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nguoi_dung);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa ảnh đại diện: ' . $stmt->error);
    }

    $stmt->close();

    // Xóa file ảnh cũ nếu có
    if (!empty($anh_cu)) {
        $file_path = '../../uploads/avatars/' . $anh_cu;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa ảnh đại diện thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>