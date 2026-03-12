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

    // Lấy dữ liệu từ form
    $ho_ten = isset($_POST['ho_ten']) ? trim($_POST['ho_ten']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : '';

    // Validate
    if (empty($ho_ten)) {
        throw new Exception('Vui lòng nhập họ tên');
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email không hợp lệ');
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

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['anh_dai_dien']['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            throw new Exception('Chỉ chấp nhận file ảnh JPG, PNG, GIF');
        }

        if ($_FILES['anh_dai_dien']['size'] > 5 * 1024 * 1024) {
            throw new Exception('Kích thước file không được vượt quá 5MB');
        }

        if (move_uploaded_file($_FILES['anh_dai_dien']['tmp_name'], $target_path)) {
            $anh_dai_dien = $file_name;
            $update_avatar = true;
        }
    }

    // Cập nhật thông tin
    if ($update_avatar) {
        $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, so_dien_thoai = ?, anh_dai_dien = ? WHERE ma_nguoi_dung = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $ho_ten, $email, $so_dien_thoai, $anh_dai_dien, $ma_nguoi_dung);
    } else {
        $sql = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, so_dien_thoai = ? WHERE ma_nguoi_dung = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $ho_ten, $email, $so_dien_thoai, $ma_nguoi_dung);
    }

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật thông tin: ' . $stmt->error);
    }

    $stmt->close();

    // Ghi lịch sử
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $history_sql = "INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip) 
                    VALUES (?, 'Cập nhật hồ sơ cá nhân', 'nguoi_dung', ?, 'Cập nhật thông tin cá nhân', ?)";
    $history_stmt = $conn->prepare($history_sql);
    $history_stmt->bind_param("iis", $ma_nguoi_dung, $ma_nguoi_dung, $ip);
    $history_stmt->execute();
    $history_stmt->close();

    // Cập nhật session
    $_SESSION['ho_ten'] = $ho_ten;

    echo json_encode([
        'success' => true, 
        'message' => 'Cập nhật thông tin thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>