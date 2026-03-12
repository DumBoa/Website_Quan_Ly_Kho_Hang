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

    // Lấy danh sách phiếu nhập
    $sql = "
        SELECT 
            pn.ma_phieu_nhap,
            pn.ma_kho,
            k.ten_kho,
            pn.ma_nha_cung_cap,
            ncc.ten_nha_cung_cap,
            pn.so_mat_hang,
            pn.tong_so_luong,
            pn.tong_tien,
            pn.trang_thai,
            pn.ghi_chu,
            pn.ngay_tao,
            pn.ngay_duyet,
            nd.ho_ten as nguoi_tao,
            nd2.ho_ten as nguoi_duyet
        FROM phieu_nhap pn
        LEFT JOIN kho k ON pn.ma_kho = k.ma_kho
        LEFT JOIN nha_cung_cap ncc ON pn.ma_nha_cung_cap = ncc.ma_nha_cung_cap
        LEFT JOIN nguoi_dung nd ON pn.ma_nguoi_tao = nd.ma_nguoi_dung
        LEFT JOIN nguoi_dung nd2 ON pn.ma_nguoi_duyet = nd2.ma_nguoi_dung
        ORDER BY pn.ngay_tao DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $trang_thai_text = '';
        $trang_thai_class = '';
        
        switch ($row['trang_thai']) {
            case 0:
                $trang_thai_text = 'Chờ duyệt';
                $trang_thai_class = 'pending';
                break;
            case 1:
                $trang_thai_text = 'Đã duyệt';
                $trang_thai_class = 'approved';
                break;
            case 2:
                $trang_thai_text = 'Từ chối';
                $trang_thai_class = 'rejected';
                break;
        }

        $data[] = [
            'ma_phieu_nhap' => (int)$row['ma_phieu_nhap'],
            'ma_phieu' => 'PNK-' . str_pad($row['ma_phieu_nhap'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => $row['ngay_tao'],
            'ma_nha_cung_cap' => $row['ma_nha_cung_cap'],
            'ten_nha_cung_cap' => $row['ten_nha_cung_cap'] ?? '—',
            'ma_kho' => $row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? '—',
            'so_mat_hang' => (int)$row['so_mat_hang'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'tong_tien' => (float)$row['tong_tien'],
            'trang_thai' => (int)$row['trang_thai'],
            'trang_thai_text' => $trang_thai_text,
            'trang_thai_class' => $trang_thai_class,
            'nguoi_tao' => $row['nguoi_tao'] ?? '—',
            'nguoi_duyet' => $row['nguoi_duyet'] ?? '—',
            'ghi_chu' => $row['ghi_chu'] ?? ''
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