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
    $ten_kho = isset($_POST['ten_kho']) ? trim($_POST['ten_kho']) : '';
    $dia_chi = isset($_POST['dia_chi']) ? trim($_POST['dia_chi']) : '';
    $ma_nguoi_quan_ly = isset($_POST['ma_nguoi_quan_ly']) ? (int)$_POST['ma_nguoi_quan_ly'] : 0;
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : '';
    $suc_chua = isset($_POST['suc_chua']) && $_POST['suc_chua'] !== '' ? (float)$_POST['suc_chua'] : null;
    $mo_ta = isset($_POST['mo_ta']) ? trim($_POST['mo_ta']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 1;

    // Validate
    if (empty($ten_kho)) {
        throw new Exception('Tên kho không được để trống');
    }

    if (empty($dia_chi)) {
        throw new Exception('Địa chỉ không được để trống');
    }

    if ($ma_nguoi_quan_ly <= 0) {
        throw new Exception('Vui lòng chọn người quản lý');
    }

    if (empty($so_dien_thoai)) {
        throw new Exception('Số điện thoại không được để trống');
    }

    // Kiểm tra tên kho đã tồn tại chưa
    $stmt = $conn->prepare("SELECT ma_kho FROM kho WHERE ten_kho = ?");
    $stmt->bind_param("s", $ten_kho);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('Tên kho đã tồn tại');
    }
    $stmt->close();

    // Lấy thông tin người quản lý để lưu tên (nếu cần)
    $stmt = $conn->prepare("SELECT ho_ten FROM nguoi_dung WHERE ma_nguoi_dung = ?");
    $stmt->bind_param("i", $ma_nguoi_quan_ly);
    $stmt->execute();
    $result = $stmt->get_result();
    $nguoiQuanLy = $result->fetch_assoc();
    $ten_nguoi_quan_ly = $nguoiQuanLy['ho_ten'] ?? '';
    $stmt->close();

    // Thêm kho mới
    $sql = "INSERT INTO kho (ten_kho, dia_chi, nguoi_quan_ly, so_dien_thoai, suc_chua, mo_ta, trang_thai, ma_nguoi_quan_ly) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ssssdsii", $ten_kho, $dia_chi, $ten_nguoi_quan_ly, $so_dien_thoai, $suc_chua, $mo_ta, $trang_thai, $ma_nguoi_quan_ly);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm kho: ' . $stmt->error);
    }

    $ma_kho = $conn->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Thêm kho thành công',
        'ma_kho' => $ma_kho
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>