<?php
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

    // Lấy dữ liệu từ form
    $ma_nha_cung_cap = isset($_POST['ma_nha_cung_cap']) ? (int)$_POST['ma_nha_cung_cap'] : 0;
    $ten_nha_cung_cap = trim($_POST['ten_nha_cung_cap'] ?? '');
    $nguoi_lien_he = trim($_POST['nguoi_lien_he'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    // Validate
    if ($ma_nha_cung_cap <= 0) {
        throw new Exception('Mã nhà cung cấp không hợp lệ');
    }

    if (empty($ten_nha_cung_cap)) {
        throw new Exception('Tên nhà cung cấp không được để trống');
    }

    if (empty($so_dien_thoai)) {
        throw new Exception('Số điện thoại không được để trống');
    }

    // Kiểm tra email nếu có
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email không hợp lệ');
    }

    // Lấy số điện thoại cũ để so sánh
    $stmt = $conn->prepare("SELECT so_dien_thoai FROM nha_cung_cap WHERE ma_nha_cung_cap = ?");
    $stmt->bind_param("i", $ma_nha_cung_cap);
    $stmt->execute();
    $result = $stmt->get_result();
    $oldData = $result->fetch_assoc();
    $stmt->close();

    // Chỉ kiểm tra trùng số điện thoại nếu số điện thoại thay đổi
    if ($oldData && $oldData['so_dien_thoai'] !== $so_dien_thoai) {
        $stmt = $conn->prepare("SELECT ma_nha_cung_cap FROM nha_cung_cap WHERE so_dien_thoai = ? AND ma_nha_cung_cap != ?");
        $stmt->bind_param("si", $so_dien_thoai, $ma_nha_cung_cap);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception('Số điện thoại đã tồn tại ở nhà cung cấp khác');
        }
        $stmt->close();
    }

    // Kiểm tra email nếu có và email thay đổi
    if (!empty($email) && $oldData && $oldData['email'] !== $email) {
        $stmt = $conn->prepare("SELECT ma_nha_cung_cap FROM nha_cung_cap WHERE email = ? AND email != '' AND ma_nha_cung_cap != ?");
        $stmt->bind_param("si", $email, $ma_nha_cung_cap);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception('Email đã tồn tại ở nhà cung cấp khác');
        }
        $stmt->close();
    }

    // Cập nhật nhà cung cấp
    $sql = "UPDATE nha_cung_cap 
            SET ten_nha_cung_cap = ?, nguoi_lien_he = ?, so_dien_thoai = ?, email = ?, dia_chi = ?, trang_thai = ? 
            WHERE ma_nha_cung_cap = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sssssii", $ten_nha_cung_cap, $nguoi_lien_he, $so_dien_thoai, $email, $dia_chi, $trang_thai, $ma_nha_cung_cap);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật nhà cung cấp: ' . $stmt->error);
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Cập nhật nhà cung cấp thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>