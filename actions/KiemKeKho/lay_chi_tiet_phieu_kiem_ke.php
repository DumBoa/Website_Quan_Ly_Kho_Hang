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

    $ma_phieu_kiem_ke = isset($_GET['ma_phieu_kiem_ke']) ? (int)$_GET['ma_phieu_kiem_ke'] : 0;

    if ($ma_phieu_kiem_ke <= 0) {
        throw new Exception('Mã phiếu kiểm kê không hợp lệ');
    }

    // Lấy thông tin phiếu kiểm kê
    $sql = "
        SELECT 
            pk.*,
            k.ten_kho,
            nd.ho_ten as nguoi_tao
        FROM phieu_kiem_ke pk
        LEFT JOIN kho k ON pk.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON pk.ma_nguoi_tao = nd.ma_nguoi_dung
        WHERE pk.ma_phieu_kiem_ke = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_phieu_kiem_ke);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu kiểm kê');
    }

    $phieu = $result->fetch_assoc();

    // Lấy chi tiết sản phẩm kiểm kê
    $detail_sql = "
        SELECT 
            ct.*,
            hh.ma_san_pham,
            hh.ten_hang_hoa,
            dm.ten_danh_muc
        FROM chi_tiet_kiem_ke ct
        INNER JOIN hang_hoa hh ON ct.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE ct.ma_phieu_kiem_ke = ?
        ORDER BY hh.ten_hang_hoa ASC
    ";

    $detail_stmt = $conn->prepare($detail_sql);
    $detail_stmt->bind_param("i", $ma_phieu_kiem_ke);
    $detail_stmt->execute();
    $details = $detail_stmt->get_result();

    $san_phams = [];
    while ($sp = $details->fetch_assoc()) {
        $san_phams[] = [
            'ma_chi_tiet' => (int)$sp['ma_chi_tiet'],
            'ma_hang_hoa' => (int)$sp['ma_hang_hoa'],
            'ma_san_pham' => $sp['ma_san_pham'],
            'ten_san_pham' => $sp['ten_hang_hoa'],
            'danh_muc' => $sp['ten_danh_muc'] ?? 'Chưa phân loại',
            'so_luong_he_thong' => (int)$sp['so_luong_he_thong'],
            'so_luong_thuc_te' => (int)$sp['so_luong_thuc_te'],
            'chenh_lech' => (int)$sp['chenh_lech']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ma_phieu_kiem_ke' => (int)$phieu['ma_phieu_kiem_ke'],
            'ma_phieu' => 'KK-' . str_pad($phieu['ma_phieu_kiem_ke'], 3, '0', STR_PAD_LEFT),
            'ma_kho' => (int)$phieu['ma_kho'],
            'ten_kho' => $phieu['ten_kho'] ?? '—',
            'ngay_tao' => $phieu['ngay_tao'],
            'ngay_hoan_thanh' => $phieu['ngay_hoan_thanh'],
            'trang_thai' => $phieu['trang_thai'],
            'ghi_chu' => $phieu['ghi_chu'] ?? '',
            'nguoi_tao' => $phieu['nguoi_tao'] ?? '—',
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