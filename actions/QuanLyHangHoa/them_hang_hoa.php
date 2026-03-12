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

    // Kiểm tra kết nối
    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    // Lấy dữ liệu từ form
    $ma_san_pham   = trim($_POST['ma_san_pham'] ?? '');
    $ten_hang_hoa  = trim($_POST['ten_hang_hoa'] ?? '');
    $ma_danh_muc   = (int)($_POST['ma_danh_muc'] ?? 0);
    $ma_kho        = (int)($_POST['ma_kho'] ?? 0);
    $gia_nhap      = (float)str_replace(',', '', $_POST['gia_nhap'] ?? 0);
    $so_luong      = (int)($_POST['so_luong'] ?? 0);
    $mo_ta         = trim($_POST['mo_ta'] ?? '');

    // Validate
    if (empty($ma_san_pham)) {
        throw new Exception('Thiếu mã sản phẩm');
    }
    if (empty($ten_hang_hoa)) {
        throw new Exception('Thiếu tên sản phẩm');
    }
    if ($ma_danh_muc <= 0) {
        throw new Exception('Vui lòng chọn danh mục');
    }
    if ($ma_kho <= 0) {
        throw new Exception('Vui lòng chọn kho');
    }

    // Kiểm tra mã sản phẩm đã tồn tại chưa
    $stmt = $conn->prepare("SELECT ma_hang_hoa FROM hang_hoa WHERE ma_san_pham = ?");
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }
    
    $stmt->bind_param("s", $ma_san_pham);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('Mã sản phẩm đã tồn tại');
    }
    $stmt->close();

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Thêm vào hang_hoa (loại bỏ cột mo_ta nếu không tồn tại)
    $stmt = $conn->prepare("
        INSERT INTO hang_hoa (ma_san_pham, ten_hang_hoa, ma_danh_muc, gia_nhap) 
        VALUES (?, ?, ?, ?)
    ");
    if (!$stmt) {
        throw new Exception('Lỗi prepare insert hang_hoa: ' . $conn->error);
    }
    
    $stmt->bind_param("ssid", $ma_san_pham, $ten_hang_hoa, $ma_danh_muc, $gia_nhap);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm hàng hóa: ' . $stmt->error);
    }
    
    $ma_hang_hoa = $conn->insert_id;
    $stmt->close();

    // Thêm tồn kho
    $stmt = $conn->prepare("
        INSERT INTO ton_kho (ma_kho, ma_hang_hoa, so_luong) 
        VALUES (?, ?, ?)
    ");
    if (!$stmt) {
        throw new Exception('Lỗi prepare insert ton_kho: ' . $conn->error);
    }
    
    $stmt->bind_param("iii", $ma_kho, $ma_hang_hoa, $so_luong);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm tồn kho: ' . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Thêm sản phẩm thành công',
        'ma_hang_hoa' => $ma_hang_hoa
    ]);

} catch (Exception $e) {
    // Rollback nếu có lỗi
    if (isset($conn) && $conn) {
        $conn->rollback();
    }
    
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
} catch (Throwable $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Lỗi hệ thống: ' . $e->getMessage()
    ]);
}
?>