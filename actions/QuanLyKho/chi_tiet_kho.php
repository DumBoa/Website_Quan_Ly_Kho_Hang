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

    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;

    if ($ma_kho <= 0) {
        throw new Exception('Mã kho không hợp lệ');
    }

    // Lấy thông tin kho
    $stmt = $conn->prepare("
        SELECT 
            ma_kho,
            ten_kho,
            dia_chi,
            nguoi_quan_ly,
            so_dien_thoai,
            suc_chua,
            mo_ta,
            trang_thai,
            ngay_tao
        FROM kho 
        WHERE ma_kho = ?
    ");
    $stmt->bind_param("i", $ma_kho);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy kho');
    }

    $warehouse = $result->fetch_assoc();

    // Lấy danh sách sản phẩm trong kho
    $stmt = $conn->prepare("
        SELECT 
            hh.ma_hang_hoa,
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            tk.so_luong,
            hh.gia_nhap
        FROM ton_kho tk
        JOIN hang_hoa hh ON tk.ma_hang_hoa = hh.ma_hang_hoa
        WHERE tk.ma_kho = ? AND tk.so_luong > 0
        ORDER BY tk.so_luong DESC
        LIMIT 20
    ");
    $stmt->bind_param("i", $ma_kho);
    $stmt->execute();
    $products = $stmt->get_result();
    
    $product_list = [];
    $tong_san_pham = 0;
    while ($product = $products->fetch_assoc()) {
        $product_list[] = [
            'ma_san_pham' => $product['ma_san_pham'],
            'ten_hang_hoa' => $product['ten_hang_hoa'],
            'so_luong' => $product['so_luong'],
            'gia_nhap' => $product['gia_nhap']
        ];
        $tong_san_pham += $product['so_luong'];
    }

    echo json_encode([
        'success' => true, 
        'data' => [
            'warehouse' => [
                'ma_kho' => $warehouse['ma_kho'],
                'ten_kho' => $warehouse['ten_kho'],
                'dia_chi' => $warehouse['dia_chi'],
                'nguoi_quan_ly' => $warehouse['nguoi_quan_ly'],
                'so_dien_thoai' => $warehouse['so_dien_thoai'],
                'suc_chua' => $warehouse['suc_chua'],
                'mo_ta' => $warehouse['mo_ta'],
                'trang_thai' => (int)$warehouse['trang_thai'],
                'ngay_tao' => $warehouse['ngay_tao'],
                'tong_san_pham' => $tong_san_pham
            ],
            'products' => $product_list
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>