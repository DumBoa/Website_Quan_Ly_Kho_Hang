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

    $ma_vai_tro = isset($_POST['ma_vai_tro']) ? (int)$_POST['ma_vai_tro'] : 0;

    if ($ma_vai_tro <= 0) {
        throw new Exception('Mã vai trò không hợp lệ');
    }

    // Kiểm tra vai trò có tồn tại không
    $check = $conn->prepare("SELECT ma_vai_tro, ten_vai_tro FROM vai_tro WHERE ma_vai_tro = ?");
    $check->bind_param("i", $ma_vai_tro);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy vai trò');
    }
    
    $role = $result->fetch_assoc();
    $check->close();

    // Kiểm tra xem có người dùng nào đang sử dụng vai trò này không
    $user_check = $conn->prepare("SELECT COUNT(*) as total FROM nguoi_dung WHERE ma_vai_tro = ?");
    $user_check->bind_param("i", $ma_vai_tro);
    $user_check->execute();
    $user_result = $user_check->get_result();
    $user_count = $user_result->fetch_assoc()['total'];
    $user_check->close();

    if ($user_count > 0) {
        throw new Exception('Không thể xóa vai trò này vì đang có ' . $user_count . ' người dùng sử dụng');
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Xóa quyền của vai trò
    $del_perm = $conn->prepare("DELETE FROM vai_tro_quyen WHERE ma_vai_tro = ?");
    $del_perm->bind_param("i", $ma_vai_tro);
    $del_perm->execute();
    $del_perm->close();

    // Xóa vai trò
    $sql = "DELETE FROM vai_tro WHERE ma_vai_tro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_vai_tro);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa vai trò: ' . $stmt->error);
    }

    // Commit transaction
    $conn->commit();
    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa vai trò thành công'
    ]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>