<?php
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    $field = $_GET['field'] ?? '';
    $value = $_GET['value'] ?? '';
    $exclude_id = isset($_GET['exclude_id']) ? (int)$_GET['exclude_id'] : 0;

    if (empty($field) || empty($value)) {
        throw new Exception('Thiếu thông tin kiểm tra');
    }

    $allowed_fields = ['so_dien_thoai', 'email'];
    if (!in_array($field, $allowed_fields)) {
        throw new Exception('Trường kiểm tra không hợp lệ');
    }

    $sql = "SELECT ma_nha_cung_cap FROM nha_cung_cap WHERE $field = ?";
    if ($exclude_id > 0) {
        $sql .= " AND ma_nha_cung_cap != ?";
    }

    $stmt = $conn->prepare($sql);
    
    if ($exclude_id > 0) {
        $stmt->bind_param("si", $value, $exclude_id);
    } else {
        $stmt->bind_param("s", $value);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo json_encode([
        'success' => true,
        'exists' => $result->num_rows > 0
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>