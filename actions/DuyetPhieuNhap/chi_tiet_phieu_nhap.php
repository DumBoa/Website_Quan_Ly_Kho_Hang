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

    // Kiểm tra quyền
    $vai_tro = $_SESSION['vai_tro'] ?? '';
    if (!in_array($vai_tro, ['QUAN_LY', 'ADMIN'])) {
        throw new Exception('Bạn không có quyền truy cập chức năng này');
    }

    $ma_phieu_nhap = isset($_GET['ma_phieu_nhap']) ? (int)$_GET['ma_phieu_nhap'] : 0;

    if ($ma_phieu_nhap <= 0) {
        throw new Exception('Mã phiếu nhập không hợp lệ');
    }

    // Lấy thông tin phiếu nhập
    $sql = "
        SELECT 
            pn.*,
            k.ten_kho,
            ncc.ten_nha_cung_cap,
            nd.ho_ten as nguoi_tao,
            nd2.ho_ten as nguoi_duyet
        FROM phieu_nhap pn
        LEFT JOIN kho k ON pn.ma_kho = k.ma_kho
        LEFT JOIN nha_cung_cap ncc ON pn.ma_nha_cung_cap = ncc.ma_nha_cung_cap
        LEFT JOIN nguoi_dung nd ON pn.ma_nguoi_tao = nd.ma_nguoi_dung
        LEFT JOIN nguoi_dung nd2 ON pn.ma_nguoi_duyet = nd2.ma_nguoi_dung
        WHERE pn.ma_phieu_nhap = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_nhap);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu nhập');
    }

    $phieu = $result->fetch_assoc();

    // Lấy chi tiết sản phẩm
    $sql = "
        SELECT 
            ct.*,
            hh.ma_san_pham,
            hh.ten_hang_hoa
        FROM chi_tiet_phieu_nhap ct
        JOIN hang_hoa hh ON ct.ma_hang_hoa = hh.ma_hang_hoa
        WHERE ct.ma_phieu_nhap = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_nhap);
    $stmt->execute();
    $products = $stmt->get_result();
    
    $san_phams = [];
    while ($sp = $products->fetch_assoc()) {
        $san_phams[] = [
            'ma_chi_tiet' => $sp['ma_chi_tiet'],
            'ma_hang_hoa' => $sp['ma_hang_hoa'],
            'ma_san_pham' => $sp['ma_san_pham'],
            'ten_hang_hoa' => $sp['ten_hang_hoa'],
            'so_luong' => $sp['so_luong'],
            'gia_nhap' => (float)$sp['gia_nhap'],
            'thanh_tien' => $sp['so_luong'] * $sp['gia_nhap']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ma_phieu_nhap' => $phieu['ma_phieu_nhap'],
            'ma_phieu' => 'PNK-' . str_pad($phieu['ma_phieu_nhap'], 3, '0', STR_PAD_LEFT),
            'ma_kho' => $phieu['ma_kho'],
            'ten_kho' => $phieu['ten_kho'],
            'ma_nha_cung_cap' => $phieu['ma_nha_cung_cap'],
            'ten_nha_cung_cap' => $phieu['ten_nha_cung_cap'],
            'so_mat_hang' => $phieu['so_mat_hang'],
            'tong_so_luong' => $phieu['tong_so_luong'],
            'tong_tien' => (float)$phieu['tong_tien'],
            'trang_thai' => $phieu['trang_thai'],
            'ghi_chu' => $phieu['ghi_chu'],
            'ngay_tao' => $phieu['ngay_tao'],
            'ngay_duyet' => $phieu['ngay_duyet'],
            'nguoi_tao' => $phieu['nguoi_tao'],
            'nguoi_duyet' => $phieu['nguoi_duyet'],
            'san_phams' => $san_phams
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>