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
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    if ($ma_vai_tro <= 0) {
        throw new Exception('Mã vai trò không hợp lệ');
    }

    // Kiểm tra vai trò có tồn tại không
    $check = $conn->prepare("SELECT ma_vai_tro FROM vai_tro WHERE ma_vai_tro = ?");
    $check->bind_param("i", $ma_vai_tro);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy vai trò');
    }
    $check->close();

    $sql = "UPDATE vai_tro SET trang_thai = ? WHERE ma_vai_tro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $trang_thai, $ma_vai_tro);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật trạng thái: ' . $stmt->error);
    }

    $stmt->close();

    $message = $trang_thai == 1 ? 'Đã kích hoạt vai trò' : 'Đã ngừng sử dụng vai trò';

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