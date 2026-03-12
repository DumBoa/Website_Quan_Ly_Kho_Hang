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
    $ten_nha_cung_cap = trim($_POST['ten_nha_cung_cap'] ?? '');
    $nguoi_lien_he = trim($_POST['nguoi_lien_he'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    // Validate
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

    // Kiểm tra số điện thoại đã tồn tại chưa
    $stmt = $conn->prepare("SELECT ma_nha_cung_cap FROM nha_cung_cap WHERE so_dien_thoai = ?");
    $stmt->bind_param("s", $so_dien_thoai);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('Số điện thoại đã tồn tại');
    }
    $stmt->close();

    // Thêm nhà cung cấp mới
    $sql = "INSERT INTO nha_cung_cap (ten_nha_cung_cap, nguoi_lien_he, so_dien_thoai, email, dia_chi, trang_thai) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sssssi", $ten_nha_cung_cap, $nguoi_lien_he, $so_dien_thoai, $email, $dia_chi, $trang_thai);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm nhà cung cấp: ' . $stmt->error);
    }

    $ma_nha_cung_cap = $conn->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Thêm nhà cung cấp thành công',
        'ma_nha_cung_cap' => $ma_nha_cung_cap
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>