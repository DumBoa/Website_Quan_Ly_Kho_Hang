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

    $ma_nha_cung_cap = isset($_POST['ma_nha_cung_cap']) ? (int)$_POST['ma_nha_cung_cap'] : 0;

    if ($ma_nha_cung_cap <= 0) {
        throw new Exception('Mã nhà cung cấp không hợp lệ');
    }

    // Kiểm tra nhà cung cấp có tồn tại không
    $stmt = $conn->prepare("SELECT * FROM nha_cung_cap WHERE ma_nha_cung_cap = ?");
    $stmt->bind_param("i", $ma_nha_cung_cap);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy nhà cung cấp');
    }
    $stmt->close();

    // Kiểm tra xem nhà cung cấp có sản phẩm không
    $stmt = $conn->prepare("SELECT COUNT(*) as so_luong FROM hang_hoa WHERE ma_nha_cung_cap = ? AND trang_thai = 1");
    $stmt->bind_param("i", $ma_nha_cung_cap);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['so_luong'] > 0) {
        throw new Exception('Không thể xóa nhà cung cấp đang cung cấp sản phẩm');
    }
    $stmt->close();

    // Thực hiện xóa (soft delete)
    $sql = "UPDATE nha_cung_cap SET trang_thai = 0 WHERE ma_nha_cung_cap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nha_cung_cap);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa nhà cung cấp: ' . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception('Không thể xóa nhà cung cấp');
    }

    $stmt->close();

    echo json_encode([
        'success' => true, 
        'message' => 'Xóa nhà cung cấp thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>