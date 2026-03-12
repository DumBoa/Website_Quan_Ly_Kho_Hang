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

    // Lấy danh sách người dùng có vai trò QUAN_LY
    $sql = "
        SELECT 
            nd.ma_nguoi_dung,
            nd.ho_ten,
            nd.email,
            nd.so_dien_thoai
        FROM nguoi_dung nd
        JOIN vai_tro vt ON nd.ma_vai_tro = vt.ma_vai_tro
        WHERE vt.ten_vai_tro = 'QUAN_LY' AND nd.trang_thai = 1
        ORDER BY nd.ho_ten
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_nguoi_dung' => (int)$row['ma_nguoi_dung'],
            'ho_ten' => $row['ho_ten'] ?? '',
            'email' => $row['email'] ?? '',
            'so_dien_thoai' => $row['so_dien_thoai'] ?? ''
        ];
    }

    echo json_encode(['success' => true, 'data' => $data]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>