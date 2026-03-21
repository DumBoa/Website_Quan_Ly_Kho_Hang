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
    $thang = isset($_GET['thang']) ? (int)$_GET['thang'] : (int)date('m');
    $nam = isset($_GET['nam']) ? (int)$_GET['nam'] : (int)date('Y');
    $ma_kho = isset($_GET['ma_kho']) ? (int)$_GET['ma_kho'] : 0;

    $ngay_dau_thang = "$nam-$thang-01";
    $ngay_cuoi_thang = date('Y-m-t', strtotime($ngay_dau_thang));

    // Lấy danh sách sản phẩm có tồn kho
    $sql = "
        SELECT DISTINCT 
            hh.ma_hang_hoa, 
            hh.ma_san_pham, 
            hh.ten_hang_hoa, 
            hh.ma_danh_muc,
            dm.ten_danh_muc
        FROM hang_hoa hh
        LEFT JOIN danh_muc dm ON hh.ma_danh_muc = dm.ma_danh_muc
        WHERE hh.trang_thai = 1
        ORDER BY hh.ten_hang_hoa
    ";
    
    $result = $conn->query($sql);
    
    $data = [];
    $tong_ton_dau = 0;
    $tong_nhap = 0;
    $tong_xuat = 0;
    $tong_ton_cuoi = 0;

    while ($row = $result->fetch_assoc()) {
        // Tính tồn đầu kỳ (lấy từ bảng ton_kho tại thời điểm đầu tháng)
        // Ở đây ta lấy số lượng hiện tại vì chưa có lịch sử tồn kho
        $ton_dau_sql = "
            SELECT SUM(so_luong) as ton_dau
            FROM ton_kho 
            WHERE ma_hang_hoa = ? AND ma_kho = ?
        ";
        $stmt = $conn->prepare($ton_dau_sql);
        $stmt->bind_param("ii", $row['ma_hang_hoa'], $ma_kho);
        $stmt->execute();
        $ton_dau_result = $stmt->get_result();
        $ton_dau = $ton_dau_result->fetch_assoc()['ton_dau'] ?? 0;
        $stmt->close();

        // Tính tổng nhập trong tháng
        $nhap_sql = "
            SELECT COALESCE(SUM(ct.so_luong), 0) as tong_nhap
            FROM chi_tiet_phieu_nhap ct
            JOIN phieu_nhap pn ON ct.ma_phieu_nhap = pn.ma_phieu_nhap
            WHERE ct.ma_hang_hoa = ? 
            AND pn.ma_kho = ? 
            AND DATE(pn.ngay_tao) BETWEEN ? AND ? 
            AND pn.trang_thai = 1
        ";
        $stmt = $conn->prepare($nhap_sql);
        $stmt->bind_param("iiss", $row['ma_hang_hoa'], $ma_kho, $ngay_dau_thang, $ngay_cuoi_thang);
        $stmt->execute();
        $nhap_result = $stmt->get_result();
        $tong_nhap_thang = (int)($nhap_result->fetch_assoc()['tong_nhap'] ?? 0);
        $stmt->close();

        // Tính tổng xuất trong tháng
        $xuat_sql = "
            SELECT COALESCE(SUM(ct.so_luong), 0) as tong_xuat
            FROM chi_tiet_phieu_xuat ct
            JOIN phieu_xuat px ON ct.ma_phieu_xuat = px.ma_phieu_xuat
            WHERE ct.ma_hang_hoa = ? 
            AND px.ma_kho = ? 
            AND DATE(px.ngay_tao) BETWEEN ? AND ? 
            AND px.trang_thai = 1
        ";
        $stmt = $conn->prepare($xuat_sql);
        $stmt->bind_param("iiss", $row['ma_hang_hoa'], $ma_kho, $ngay_dau_thang, $ngay_cuoi_thang);
        $stmt->execute();
        $xuat_result = $stmt->get_result();
        $tong_xuat_thang = (int)($xuat_result->fetch_assoc()['tong_xuat'] ?? 0);
        $stmt->close();

        // Tính tồn cuối kỳ (có thể tính từ tồn đầu + nhập - xuất)
        $ton_cuoi = $ton_dau + $tong_nhap_thang - $tong_xuat_thang;

        // Chỉ thêm vào data nếu có biến động hoặc tồn kho > 0
        if ($ton_dau > 0 || $tong_nhap_thang > 0 || $tong_xuat_thang > 0 || $ton_cuoi > 0) {
            $data[] = [
                'ma_san_pham' => $row['ma_san_pham'],
                'ten_san_pham' => $row['ten_hang_hoa'],
                'danh_muc' => $row['ten_danh_muc'] ?? 'Chưa phân loại',
                'ton_dau' => (int)$ton_dau,
                'tong_nhap' => (int)$tong_nhap_thang,
                'tong_xuat' => (int)$tong_xuat_thang,
                'ton_cuoi' => (int)$ton_cuoi
            ];

            $tong_ton_dau += $ton_dau;
            $tong_nhap += $tong_nhap_thang;
            $tong_xuat += $tong_xuat_thang;
            $tong_ton_cuoi += $ton_cuoi;
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'thong_ke' => [
            'thang' => $thang,
            'nam' => $nam,
            'tong_ton_dau' => $tong_ton_dau,
            'tong_nhap' => $tong_nhap,
            'tong_xuat' => $tong_xuat,
            'tong_ton_cuoi' => $tong_ton_cuoi
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>