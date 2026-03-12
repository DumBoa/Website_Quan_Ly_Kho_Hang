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

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Lấy danh sách hàng hóa với thông tin cơ bản
    $sql = "SELECT 
                hh.ma_hang_hoa, 
                hh.ma_san_pham, 
                hh.ten_hang_hoa, 
                hh.gia_nhap,
                hh.trang_thai,
                dm.ten_danh_muc,
                k.ten_kho,
                COALESCE(SUM(tk.so_luong), 0) as ton_kho
            FROM hang_hoa hh
            LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
            LEFT JOIN ton_kho tk ON hh.ma_hang_hoa = tk.ma_hang_hoa
            LEFT JOIN kho k ON tk.ma_kho = k.ma_kho
            WHERE 1=1";
    
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (hh.ma_san_pham LIKE '%$search%' OR hh.ten_hang_hoa LIKE '%$search%')";
    }
    
    $sql .= " GROUP BY hh.ma_hang_hoa ORDER BY hh.ten_hang_hoa";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ma_hang_hoa' => (int)$row['ma_hang_hoa'],
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_hang_hoa' => $row['ten_hang_hoa'],
            'gia_nhap' => (float)$row['gia_nhap'],
            'trang_thai' => (int)$row['trang_thai'],
            'ten_danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
            'ten_kho' => $row['ten_kho'] ?? 'Chưa có',
            'ton_kho' => (int)$row['ton_kho']
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