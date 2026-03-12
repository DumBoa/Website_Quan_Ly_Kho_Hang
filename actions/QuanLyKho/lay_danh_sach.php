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

    // Lấy danh sách kho kèm tổng số sản phẩm
    $sql = "
        SELECT 
            k.ma_kho,
            k.ten_kho,
            k.dia_chi,
            k.nguoi_quan_ly,
            k.so_dien_thoai,
            k.suc_chua,
            k.mo_ta,
            k.trang_thai,
            k.ngay_tao,
            k.nguoi_quan_ly,
            COALESCE(SUM(tk.so_luong), 0) AS tong_san_pham
        FROM kho k
        LEFT JOIN ton_kho tk ON k.ma_kho = tk.ma_kho
        GROUP BY k.ma_kho
        ORDER BY k.ngay_tao DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_kho' => (int)$row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? '',
            'dia_chi' => $row['dia_chi'] ?? '',
            'nguoi_quan_ly' => $row['nguoi_quan_ly'] ?? '',
            'so_dien_thoai' => $row['so_dien_thoai'] ?? '',
            'suc_chua' => $row['suc_chua'] ? (float)$row['suc_chua'] : 0,
            'mo_ta' => $row['mo_ta'] ?? '',
            'trang_thai' => isset($row['trang_thai']) ? (int)$row['trang_thai'] : 1,
            'ngay_tao' => $row['ngay_tao'] ?? '',
            'tong_san_pham' => (int)$row['tong_san_pham'],
            'ma_nguoi_quan_ly' => $row['ma_nguoi_quan_ly'] ? (int)$row['ma_nguoi_quan_ly'] : 0
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