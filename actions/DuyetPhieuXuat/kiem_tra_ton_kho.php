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
        throw new Exception('Bạn không có quyền thực hiện chức năng này');
    }

    $ma_phieu_xuat = isset($_GET['ma_phieu_xuat']) ? (int)$_GET['ma_phieu_xuat'] : 0;

    if ($ma_phieu_xuat <= 0) {
        throw new Exception('Mã phiếu xuất không hợp lệ');
    }

    // Lấy thông tin phiếu xuất
    $stmt = $conn->prepare("SELECT * FROM phieu_xuat WHERE ma_phieu_xuat = ?");
    $stmt->bind_param("i", $ma_phieu_xuat);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy phiếu xuất');
    }

    $phieu = $result->fetch_assoc();
    $stmt->close();

    // Lấy chi tiết phiếu xuất và kiểm tra tồn kho
    $stmt = $conn->prepare("
        SELECT ct.*, hh.ma_san_pham, hh.ten_hang_hoa, tk.so_luong as ton_kho
        FROM chi_tiet_phieu_xuat ct
        JOIN hang_hoa hh ON ct.ma_hang_hoa = hh.ma_hang_hoa
        LEFT JOIN ton_kho tk ON ct.ma_hang_hoa = tk.ma_hang_hoa AND tk.ma_kho = ?
        WHERE ct.ma_phieu_xuat = ?
    ");
    $stmt->bind_param("ii", $phieu['ma_kho'], $ma_phieu_xuat);
    $stmt->execute();
    $products = $stmt->get_result();
    
    $warnings = [];
    $has_warning = false;
    
    while ($sp = $products->fetch_assoc()) {
        $ton_kho = (int)($sp['ton_kho'] ?? 0);
        if ($sp['so_luong'] > $ton_kho) {
            $has_warning = true;
            $warnings[] = [
                'ma_san_pham' => $sp['ma_san_pham'],
                'ten_hang_hoa' => $sp['ten_hang_hoa'],
                'so_luong_xuat' => $sp['so_luong'],
                'ton_kho' => $ton_kho
            ];
        }
    }

    echo json_encode([
        'success' => true,
        'has_warning' => $has_warning,
        'warnings' => $warnings
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>