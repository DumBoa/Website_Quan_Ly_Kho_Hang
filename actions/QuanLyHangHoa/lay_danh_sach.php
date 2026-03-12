<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/config.php';

// Thêm debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit;
}

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại']);
    exit;
}

// Sửa query - loại bỏ cột mo_ta vì không tồn tại trong bảng hang_hoa
$sql = "
    SELECT 
        hh.ma_hang_hoa,
        hh.ma_san_pham,
        hh.ten_hang_hoa,
        hh.gia_nhap,
        hh.ngay_tao,
        dm.ma_danh_muc,
        dm.ten_danh_muc,
        k.ma_kho,
        k.ten_kho,
        COALESCE(tk.so_luong, 0) AS so_luong,
        ROUND(COALESCE(hh.gia_nhap, 0) * 1.3, 0) AS gia_ban,
        CASE 
            WHEN COALESCE(tk.so_luong, 0) > 20 THEN 'Còn hàng'
            WHEN COALESCE(tk.so_luong, 0) > 0 THEN 'Sắp hết'
            ELSE 'Hết hàng'
        END AS trang_thai_text,
        CASE 
            WHEN COALESCE(tk.so_luong, 0) > 20 THEN 'in-stock'
            WHEN COALESCE(tk.so_luong, 0) > 0 THEN 'low-stock'
            ELSE 'out-of-stock'
        END AS trang_thai_class
    FROM hang_hoa hh
    LEFT JOIN ton_kho tk ON hh.ma_hang_hoa = tk.ma_hang_hoa
    LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
    LEFT JOIN kho k ON tk.ma_kho = k.ma_kho
    WHERE hh.trang_thai = 1 OR hh.trang_thai IS NULL
    ORDER BY hh.ngay_tao DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    // Chuyển đổi các giá trị NULL thành chuỗi rỗng hoặc 0
    $data[] = [
        'ma_hang_hoa' => $row['ma_hang_hoa'] ?? 0,
        'ma_san_pham' => $row['ma_san_pham'] ?? '',
        'ten_hang_hoa' => $row['ten_hang_hoa'] ?? '',
        'gia_nhap' => $row['gia_nhap'] ?? 0,
        'mo_ta' => '', // Không có cột mo_ta nên để rỗng
        'ngay_tao' => $row['ngay_tao'] ?? '',
        'ma_danh_muc' => $row['ma_danh_muc'] ?? 0,
        'ten_danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
        'ma_kho' => $row['ma_kho'] ?? 0,
        'ten_kho' => $row['ten_kho'] ?? '-',
        'so_luong' => $row['so_luong'] ?? 0,
        'gia_ban' => $row['gia_ban'] ?? 0,
        'trang_thai_text' => $row['trang_thai_text'] ?? 'Hết hàng',
        'trang_thai_class' => $row['trang_thai_class'] ?? 'out-of-stock'
    ];
}

echo json_encode(['success' => true, 'data' => $data]);
?>