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

    $ma_nha_cung_cap = isset($_GET['ma_nha_cung_cap']) ? (int)$_GET['ma_nha_cung_cap'] : 0;

    if ($ma_nha_cung_cap <= 0) {
        throw new Exception('Mã nhà cung cấp không hợp lệ');
    }

    // Lấy thông tin nhà cung cấp
    $stmt = $conn->prepare("
        SELECT 
            ma_nha_cung_cap,
            ten_nha_cung_cap,
            nguoi_lien_he,
            so_dien_thoai,
            email,
            dia_chi,
            trang_thai,
            ngay_tao
        FROM nha_cung_cap 
        WHERE ma_nha_cung_cap = ?
    ");
    $stmt->bind_param("i", $ma_nha_cung_cap);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy nhà cung cấp');
    }

    $supplier = $result->fetch_assoc();

    // Lấy danh sách sản phẩm của nhà cung cấp
    $stmt = $conn->prepare("
        SELECT 
            ma_hang_hoa,
            ma_san_pham,
            ten_hang_hoa,
            gia_nhap,
            so_luong
        FROM hang_hoa hh
        LEFT JOIN ton_kho tk ON hh.ma_hang_hoa = tk.ma_hang_hoa
        WHERE hh.ma_nha_cung_cap = ? AND hh.trang_thai = 1
        LIMIT 10
    ");
    $stmt->bind_param("i", $ma_nha_cung_cap);
    $stmt->execute();
    $products = $stmt->get_result();
    
    $product_list = [];
    while ($product = $products->fetch_assoc()) {
        $product_list[] = [
            'ma_san_pham' => $product['ma_san_pham'],
            'ten_hang_hoa' => $product['ten_hang_hoa'],
            'gia_nhap' => $product['gia_nhap'],
            'so_luong' => $product['so_luong'] ?? 0
        ];
    }

    echo json_encode([
        'success' => true, 
        'data' => [
            'supplier' => [
                'ma_nha_cung_cap' => $supplier['ma_nha_cung_cap'],
                'ten_nha_cung_cap' => $supplier['ten_nha_cung_cap'],
                'nguoi_lien_he' => $supplier['nguoi_lien_he'],
                'so_dien_thoai' => $supplier['so_dien_thoai'],
                'email' => $supplier['email'],
                'dia_chi' => $supplier['dia_chi'],
                'trang_thai' => (int)$supplier['trang_thai'],
                'ngay_tao' => $supplier['ngay_tao']
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