<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;

    if ($ma_kho <= 0) {
        throw new Exception('Vui lòng chọn kho');
    }

    // Lấy danh sách sản phẩm trong kho
    $sql = "
        SELECT 
            tk.ma_ton_kho,
            tk.ma_hang_hoa,
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            dm.ten_danh_muc,
            tk.so_luong as ton_kho_he_thong
        FROM ton_kho tk
        INNER JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE tk.ma_kho = ? AND hh.trang_thai = 1
        ORDER BY hh.ten_hang_hoa ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_kho);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_ton_kho' => (int)$row['ma_ton_kho'],
            'ma_hang_hoa' => (int)$row['ma_hang_hoa'],
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_san_pham' => $row['ten_hang_hoa'],
            'danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
            'ton_kho_he_thong' => (int)$row['ton_kho_he_thong']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>