<?php
// Đặt ở đầu file - KHÔNG CÓ KÝ TỰ NÀO TRƯỚC <?php
// Bật hiển thị lỗi để debug - tạm thời bật lên
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Xóa bộ đệm đầu ra
ob_clean();

header('Content-Type: application/json; charset=utf-8');

// Mảng để lưu kết quả
$response = ['success' => false, 'message' => ''];

try {
    // Kiểm tra file config
    $configPath = '../../config/config.php';
    if (!file_exists($configPath)) {
        throw new Exception('Không tìm thấy file config tại: ' . realpath(dirname(__FILE__) . '/../..') . '/config/config.php');
    }
    
    require_once $configPath;
    
    if (!isset($conn) || !$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    // Kiểm tra bảng nha_cung_cap có tồn tại không
    $checkTable = $conn->query("SHOW TABLES LIKE 'nha_cung_cap'");
    if ($checkTable->num_rows === 0) {
        throw new Exception('Bảng nha_cung_cap không tồn tại trong CSDL');
    }

    // Lấy danh sách nhà cung cấp
    $sql = "SELECT ma_nha_cung_cap, ten_nha_cung_cap, nguoi_lien_he, so_dien_thoai, email, dia_chi, trang_thai, ngay_tao FROM nha_cung_cap ORDER BY ngay_tao DESC";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_nha_cung_cap' => (int)$row['ma_nha_cung_cap'],
            'ten_nha_cung_cap' => $row['ten_nha_cung_cap'] ?? '',
            'nguoi_lien_he' => $row['nguoi_lien_he'] ?? '',
            'so_dien_thoai' => $row['so_dien_thoai'] ?? '',
            'email' => $row['email'] ?? '',
            'dia_chi' => $row['dia_chi'] ?? '',
            'trang_thai' => isset($row['trang_thai']) ? (int)$row['trang_thai'] : 1,
            'ngay_tao' => $row['ngay_tao'] ?? ''
        ];
    }

    $response = ['success' => true, 'data' => $data];

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

// Xóa bộ đệm và trả về JSON
ob_clean();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
?>