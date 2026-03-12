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

    // Lấy danh sách danh mục kèm số lượng sản phẩm
    $sql = "
        SELECT 
            dm.ma_danh_muc,
            dm.ten_danh_muc,
            dm.mo_ta,
            dm.ngay_tao,
            dm.trang_thai,
            COUNT(hh.ma_hang_hoa) AS so_luong_san_pham
        FROM danh_muc dm
        LEFT JOIN hang_hoa hh ON dm.ma_danh_muc = hh.ma_danh_muc AND hh.trang_thai = 1
        GROUP BY dm.ma_danh_muc
        ORDER BY dm.ngay_tao DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_danh_muc' => $row['ma_danh_muc'],
            'ten_danh_muc' => $row['ten_danh_muc'],
            'mo_ta' => $row['mo_ta'],
            'ngay_tao' => $row['ngay_tao'],
            'trang_thai' => (int)$row['trang_thai'],
            'so_luong_san_pham' => (int)$row['so_luong_san_pham']
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