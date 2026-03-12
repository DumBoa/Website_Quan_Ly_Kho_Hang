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

    // Lấy dữ liệu từ form
    $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
    $ten_dang_nhap = isset($_POST['ten_dang_nhap']) ? trim($_POST['ten_dang_nhap']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mat_khau = isset($_POST['mat_khau']) ? $_POST['mat_khau'] : '';
    $ma_vai_tro = isset($_POST['ma_vai_tro']) ? (int)$_POST['ma_vai_tro'] : 0;
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;
    $ghi_chu = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : '';

    // Validate
    if (empty($ho_ten)) {
        throw new Exception('Vui lòng nhập họ tên');
    }
    if (empty($ten_dang_nhap)) {
        throw new Exception('Vui lòng nhập tên đăng nhập');
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email không hợp lệ');
    }
    if (empty($mat_khau)) {
        throw new Exception('Vui lòng nhập mật khẩu');
    }
    if (strlen($mat_khau) < 6) {
        throw new Exception('Mật khẩu phải có ít nhất 6 ký tự');
    }
    if ($ma_vai_tro <= 0) {
        throw new Exception('Vui lòng chọn vai trò');
    }

    // Kiểm tra tên đăng nhập đã tồn tại chưa
    $check = $conn->prepare("SELECT ma_nguoi_dung FROM nguoi_dung WHERE ten_dang_nhap = ?");
    $check->bind_param("s", $ten_dang_nhap);
    $check->execute();
    $checkResult = $check->get_result();
    if ($checkResult->num_rows > 0) {
        throw new Exception('Tên đăng nhập đã tồn tại');
    }
    $check->close();

    // Kiểm tra email đã tồn tại chưa
    $check = $conn->prepare("SELECT ma_nguoi_dung FROM nguoi_dung WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $checkResult = $check->get_result();
    if ($checkResult->num_rows > 0) {
        throw new Exception('Email đã được sử dụng');
    }
    $check->close();

    // Xử lý upload ảnh đại diện
    $anh_dai_dien = null;
    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/avatars/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['anh_dai_dien']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $file_name;

        // Kiểm tra loại file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['anh_dai_dien']['type'], $allowed_types)) {
            throw new Exception('Chỉ chấp nhận file ảnh JPG, PNG, GIF');
        }

        if (move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'], $target_path)) {
            $anh_dai_dien = $file_name;
        }
    }

    // Mã hóa mật khẩu
    $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);

    // Thêm người dùng mới
    $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, ho_ten, email, so_dien_thoai, ma_vai_tro, trang_thai, anh_dai_dien) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiis", $ten_dang_nhap, $mat_khau_hash, $ho_ten, $email, $so_dien_thoai, $ma_vai_tro, $trang_thai, $anh_dai_dien);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm người dùng: ' . $stmt->error);
    }

    $ma_nguoi_dung = $conn->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Thêm người dùng thành công',
        'ma_nguoi_dung' => $ma_nguoi_dung
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>