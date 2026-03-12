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

    // Lấy dữ liệu từ form
    $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $ma_vai_tro = isset($_POST['ma_vai_tro']) ? (int)$_POST['ma_vai_tro'] : 0;
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    // Validate
    if (empty($ho_ten)) {
        throw new Exception('Vui lòng nhập họ tên');
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email không hợp lệ');
    }
    if ($ma_vai_tro <= 0) {
        throw new Exception('Vui lòng chọn vai trò');
    }

    // Kiểm tra email đã tồn tại chưa (ngoại trừ user hiện tại)
    $check = $conn->prepare("SELECT ma_nguoi_dung FROM nguoi_dung WHERE email = ? AND ma_nguoi_dung != ?");
    $check->bind_param("si", $email, $ma_nguoi_dung);
    $check->execute();
    $checkResult = $check->get_result();
    if ($checkResult->num_rows > 0) {
        throw new Exception('Email đã được sử dụng bởi người dùng khác');
    }
    $check->close();

    // Xử lý upload ảnh đại diện mới
    $anh_dai_dien = null;
    $update_avatar = false;
    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/avatars/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['anh_dai_dien']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $file_name;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['anh_dai_dien']['type'], $allowed_types)) {
            throw new Exception('Chỉ chấp nhận file ảnh JPG, PNG, GIF');
        }

        if (move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'], $target_path)) {
            $anh_dai_dien = $file_name;
            $update_avatar = true;
        }
    }

    // Cập nhật thông tin
    if ($update_avatar) {
        $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, so_dien_thoai = ?, ma_vai_tro = ?, trang_thai = ?, anh_dai_dien = ? WHERE ma_nguoi_dung = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiisi", $ho_ten, $email, $so_dien_thoai, $ma_vai_tro, $trang_thai, $anh_dai_dien, $ma_nguoi_dung);
    } else {
        $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, so_dien_thoai = ?, ma_vai_tro = ?, trang_thai = ? WHERE ma_nguoi_dung = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $ho_ten, $email, $so_dien_thoai, $ma_vai_tro, $trang_thai, $ma_nguoi_dung);
    }

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật người dùng: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Cập nhật người dùng thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>