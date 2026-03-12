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

    // Lấy danh sách phiếu xuất
    $sql = "
        SELECT 
            px.ma_phieu_xuat,
            px.ma_kho,
            k.ten_kho,
            px.bo_phan_nguoi_nhan,
            px.so_mat_hang,
            px.tong_so_luong,
            px.tong_gia_tri,
            px.trang_thai,
            px.ghi_chu,
            px.ngay_tao,
            px.ngay_duyet,
            nd.ho_ten as nguoi_tao,
            nd2.ho_ten as nguoi_duyet
        FROM phieu_xuat px
        LEFT JOIN kho k ON px.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON px.ma_nguoi_tao = nd.ma_nguoi_dung
        LEFT JOIN nguoi_dung nd2 ON px.ma_nguoi_duyet = nd2.ma_nguoi_dung
        ORDER BY px.ngay_tao DESC
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

        // Tách người nhận và bộ phận
        $nguoi_nhan = '';
        $bo_phan = '';
        if (!empty($row['bo_phan_nguoi_nhan'])) {
            $parts = explode('|', $row['bo_phan_nguoi_nhan']);
            $nguoi_nhan = $parts[0] ?? '';
            $bo_phan = $parts[1] ?? '';
        }

        $data[] = [
            'ma_phieu_xuat' => (int)$row['ma_phieu_xuat'],
            'ma_phieu' => 'PXK-' . str_pad($row['ma_phieu_xuat'], 3, '0', STR_PAD_LEFT),
            'ngay_tao' => $row['ngay_tao'],
            'ma_kho' => $row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? '—',
            'nguoi_nhan' => $nguoi_nhan,
            'bo_phan' => $bo_phan,
            'so_mat_hang' => (int)$row['so_mat_hang'],
            'tong_so_luong' => (int)$row['tong_so_luong'],
            'tong_gia_tri' => (float)$row['tong_gia_tri'],
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