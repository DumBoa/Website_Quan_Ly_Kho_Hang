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

    // Lấy tham số lọc
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;
    $trang_thai = isset($_GET['trang_thai']) ? $_GET['trang_thai'] : '';
    $tu_ngay = isset($_GET['tu_ngay']) ? $_GET['tu_ngay'] : '';
    $den_ngay = isset($_GET['den_ngay']) ? $_GET['den_ngay'] : '';

    // Xây dựng câu truy vấn
    $sql = "
        SELECT 
            pk.ma_phieu_kiem_ke,
            pk.ma_kho,
            k.ten_kho,
            pk.ngay_tao,
            pk.ngay_hoan_thanh,
            pk.trang_thai,
            pk.ghi_chu,
            nd.ho_ten as nguoi_tao,
            (SELECT COUNT(*) FROM chi_tiet_kiem_ke WHERE ma_phieu_kiem_ke = pk.ma_phieu_kiem_ke) as tong_sp,
            (SELECT COUNT(*) FROM chi_tiet_kiem_ke WHERE ma_phieu_kiem_ke = pk.ma_phieu_kiem_ke AND chenh_lech != 0) as sp_chenh_lech,
            (SELECT SUM(chenh_lech) FROM chi_tiet_kiem_ke WHERE ma_phieu_kiem_ke = pk.ma_phieu_kiem_ke) as tong_chenh_lech
        FROM phieu_kiem_ke pk
        LEFT JOIN kho k ON pk.ma_kho = k.ma_kho
        LEFT JOIN nguoi_dung nd ON pk.ma_nguoi_tao = nd.ma_nguoi_dung
        WHERE 1=1
    ";

    if ($ma_kho > 0) {
        $sql .= " AND pk.ma_kho = $ma_kho";
    }

    if (!empty($trang_thai)) {
        $sql .= " AND pk.trang_thai = '$trang_thai'";
    }

    if (!empty($tu_ngay)) {
        $sql .= " AND DATE(pk.ngay_tao) >= '$tu_ngay'";
    }

    if (!empty($den_ngay)) {
        $sql .= " AND DATE(pk.ngay_tao) <= '$den_ngay'";
    }

    $sql .= " ORDER BY pk.ngay_tao DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Lỗi truy vấn: ' . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Xác định trạng thái hiển thị
        $status_text = '';
        $status_class = '';
        
        switch ($row['trang_thai']) {
            case 'dang_kiem_ke':
                $status_text = 'Đang kiểm kê';
                $status_class = 'bg-orange-100 text-orange-700';
                break;
            case 'hoan_thanh':
                $status_text = 'Hoàn thành';
                $status_class = 'bg-green-100 text-green-700';
                break;
            case 'da_dieu_chinh':
                $status_text = 'Đã điều chỉnh';
                $status_class = 'bg-teal-100 text-teal-700';
                break;
            default:
                $status_text = $row['trang_thai'];
                $status_class = 'bg-slate-100 text-slate-700';
        }

        $data[] = [
            'ma_phieu_kiem_ke' => (int)$row['ma_phieu_kiem_ke'],
            'ma_phieu' => 'KK-' . str_pad($row['ma_phieu_kiem_ke'], 3, '0', STR_PAD_LEFT),
            'ma_kho' => (int)$row['ma_kho'],
            'ten_kho' => $row['ten_kho'] ?? '—',
            'ngay_tao' => $row['ngay_tao'],
            'ngay_hoan_thanh' => $row['ngay_hoan_thanh'],
            'trang_thai' => $row['trang_thai'],
            'trang_thai_text' => $status_text,
            'trang_thai_class' => $status_class,
            'ghi_chu' => $row['ghi_chu'] ?? '',
            'nguoi_tao' => $row['nguoi_tao'] ?? '—',
            'tong_sp' => (int)$row['tong_sp'],
            'sp_chenh_lech' => (int)$row['sp_chenh_lech'],
            'tong_chenh_lech' => (int)$row['tong_chenh_lech']
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