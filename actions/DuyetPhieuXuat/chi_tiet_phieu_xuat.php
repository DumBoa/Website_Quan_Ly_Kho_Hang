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

    $ma_phieu_xuat = isset($_GET['ma_phieu_xuat']) ? (int)$_GET['ma_phieu_xuat'] : 0;

    if ($ma_phieu_xuat <= 0) {
        throw new Exception('Mã phiếu xuất không hợp lệ');
    }

    // Lấy thông tin phiếu xuất
    $sql = "
        SELECT 
            px.*,
            k.ten_kho,
            nd.ho_ten as nguoi_tao,
            nd2.ho_ten as nguoi_duyet
        FROM phieu_xuat px
        LEFT JOIN kho k ON px.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON px.ma_nguoi_tao = nd.ma_nguoi_dung
        LEFT JOIN nguoi_dung nd2 ON px.ma_nguoi_duyet = nd2.ma_nguoi_dung
        WHERE px.ma_phieu_xuat = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_xuat);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu xuất');
    }

    $phieu = $result->fetch_assoc();

    // Tách người nhận và bộ phận
    $nguoi_nhan = '';
    $bo_phan = '';
    if (!empty($phieu['bo_phan_nguoi_nhan'])) {
        $parts = explode('|', $phieu['bo_phan_nguoi_nhan']);
        $nguoi_nhan = $parts[0] ?? '';
        $bo_phan = $parts[1] ?? '';
    }

    // Lấy chi tiết sản phẩm
    $sql = "
        SELECT 
            ct.*,
            hh.ma_san_pham,
            hh.ten_hang_hoa
        FROM chi_tiet_phieu_xuat ct
        JOIN hang_hoa hh ON ct.ma_hang_hoa = hh.ma_hang_hoa
        WHERE ct.ma_phieu_xuat = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_xuat);
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
            'gia_xuat' => (float)$sp['gia_xuat'],
            'thanh_tien' => $sp['so_luong'] * $sp['gia_xuat']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ma_phieu_xuat' => $phieu['ma_phieu_xuat'],
            'ma_phieu' => 'PXK-' . str_pad($phieu['ma_phieu_xuat'], 3, '0', STR_PAD_LEFT),
            'ma_kho' => $phieu['ma_kho'],
            'ten_kho' => $phieu['ten_kho'],
            'nguoi_nhan' => $nguoi_nhan,
            'bo_phan' => $bo_phan,
            'so_mat_hang' => $phieu['so_mat_hang'],
            'tong_so_luong' => $phieu['tong_so_luong'],
            'tong_gia_tri' => (float)$phieu['tong_gia_tri'],
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