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

    // Lấy dữ liệu từ form
    $ten_vai_tro = isset($_POST['ten_vai_tro']) ? trim($_POST['ten_vai_tro']) : '';
    $mo_ta = isset($_POST['mo_ta']) ? trim($_POST['mo_ta']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;
    $permissions = isset($_POST['permissions']) ? json_decode($_POST['permissions'], true) : [];

    // Validate
    if (empty($ten_vai_tro)) {
        throw new Exception('Vui lòng nhập tên vai trò');
    }

    // Kiểm tra tên vai trò đã tồn tại chưa (trừ vai trò hiện tại)
    $check = $conn->prepare("SELECT ma_vai_tro FROM vai_tro WHERE ten_vai_tro = ? AND ma_vai_tro != ?");
    $check->bind_param("si", $ten_vai_tro, $ma_vai_tro);
    $check->execute();
    $checkResult = $check->get_result();
    if ($checkResult->num_rows > 0) {
        throw new Exception('Tên vai trò đã tồn tại');
    }
    $check->close();

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Cập nhật thông tin vai trò
    $sql = "UPDATE vai_tro SET ten_vai_tro = ?, mo_ta = ?, trang_thai = ? WHERE ma_vai_tro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $ten_vai_tro, $mo_ta, $trang_thai, $ma_vai_tro);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật vai trò: ' . $stmt->error);
    }
    $stmt->close();

    // Xóa quyền cũ
    $del_sql = "DELETE FROM vai_tro_quyen WHERE ma_vai_tro = ?";
    $del_stmt = $conn->prepare($del_sql);
    $del_stmt->bind_param("i", $ma_vai_tro);
    $del_stmt->execute();
    $del_stmt->close();

    // Thêm quyền mới
    if (!empty($permissions)) {
        $perm_sql = "INSERT INTO vai_tro_quyen (ma_vai_tro, chuc_nang, hanh_dong) VALUES (?, ?, ?)";
        $perm_stmt = $conn->prepare($perm_sql);

        foreach ($permissions as $chuc_nang => $hanh_dongs) {
            foreach ($hanh_dongs as $hanh_dong) {
                $perm_stmt->bind_param("iss", $ma_vai_tro, $chuc_nang, $hanh_dong);
                if (!$perm_stmt->execute()) {
                    throw new Exception('Lỗi cập nhật quyền: ' . $perm_stmt->error);
                }
            }
        }
        $perm_stmt->close();
    }

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true, 
        'message' => 'Cập nhật vai trò thành công'
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