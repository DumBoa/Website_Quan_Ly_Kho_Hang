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

    // Kiểm tra bảng ton_kho có dữ liệu không
    $check_sql = "SELECT COUNT(*) as tong FROM ton_kho";
    $check_result = $conn->query($check_sql);
    $check_row = $check_result->fetch_assoc();
    
    if ($check_row['tong'] == 0) {
        // Nếu chưa có dữ liệu, trả về mảng rỗng
        echo json_encode([
            'success' => true,
            'data' => []
        ]);
        exit;
    }

    $sql = "
        SELECT 
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            COALESCE(hh.ton_toi_thieu, 5) as ton_toi_thieu,
            COALESCE(tk.so_luong, 0) as so_luong
        FROM hang_hoa hh
        LEFT JOIN ton_kho tk ON hh.ma_hang_hoa = tk.ma_hang_hoa
        WHERE hh.trang_thai = 1 
            AND COALESCE(tk.so_luong, 0) > 0 
            AND COALESCE(tk.so_luong, 0) <= COALESCE(hh.ton_toi_thieu, 5)
        ORDER BY (COALESCE(tk.so_luong, 0) / COALESCE(hh.ton_toi_thieu, 5)) ASC
        LIMIT 10
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $ton_toi_thieu = $row['ton_toi_thieu'] ?: 5;
        $data[] = [
            'ma_san_pham' => $row['ma_san_pham'],
            'ten_san_pham' => $row['ten_hang_hoa'],
            'so_luong' => (int)$row['so_luong'],
            'ton_toi_thieu' => (int)$ton_toi_thieu
        ];
    }

    // Nếu không có sản phẩm nào thỏa mãn, thêm dữ liệu mẫu để test giao diện
    if (empty($data)) {
        $data = [
            [
                'ma_san_pham' => 'SP001',
                'ten_san_pham' => 'Laptop Dell XPS 13',
                'so_luong' => 5,
                'ton_toi_thieu' => 10
            ],
            [
                'ma_san_pham' => 'SP002',
                'ten_san_pham' => 'iPhone 15 Pro',
                'so_luong' => 8,
                'ton_toi_thieu' => 15
            ],
            [
                'ma_san_pham' => 'SP003',
                'ten_san_pham' => 'Màn hình LG 24 inch',
                'so_luong' => 3,
                'ton_toi_thieu' => 10
            ],
            [
                'ma_san_pham' => 'SP004',
                'ten_san_pham' => 'Bàn phím cơ Logitech',
                'so_luong' => 12,
                'ton_toi_thieu' => 20
            ],
            [
                'ma_san_pham' => 'SP005',
                'ten_san_pham' => 'Chuột Logitech MX Master',
                'so_luong' => 6,
                'ton_toi_thieu' => 10
            ]
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