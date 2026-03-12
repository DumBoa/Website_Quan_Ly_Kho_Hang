<?php
session_start();
// Tắt hiển thị lỗi HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../config/config.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Phương thức không hợp lệ');
    }

    if (!$conn) {
        throw new Exception('Kết nối CSDL thất bại');
    }

    // Lấy dữ liệu từ form
    $ma_kho = isset($_POST['ma_kho']) ? (int)$_POST['ma_kho'] : 0;
    $ghi_chu = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : '';
    $ngay_kiem_ke = isset($_POST['ngay_kiem_ke']) ? $_POST['ngay_kiem_ke'] : date('Y-m-d');
    $ma_nguoi_tao = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;

    if ($ma_kho <= 0) {
        throw new Exception('Vui lòng chọn kho kiểm kê');
    }

    if ($ma_nguoi_tao <= 0) {
        throw new Exception('Không xác định được người tạo');
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Thêm phiếu kiểm kê
    $sql = "INSERT INTO phieu_kiem_ke (ma_kho, ma_nguoi_tao, ghi_chu, ngay_tao, trang_thai) 
            VALUES (?, ?, ?, ?, 'dang_kiem_ke')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $ma_kho, $ma_nguoi_tao, $ghi_chu, $ngay_kiem_ke);

    if (!$stmt->execute()) {
        throw new Exception('Lỗi tạo phiếu kiểm kê: ' . $stmt->error);
    }

    $ma_phieu_kiem_ke = $conn->insert_id;
    $stmt->close();

    // Lấy danh sách sản phẩm trong kho
    $product_sql = "
        SELECT ma_hang_hoa, so_luong 
        FROM ton_kho 
        WHERE ma_kho = ?
    ";
    $product_stmt = $conn->prepare($product_sql);
    $product_stmt->bind_param("i", $ma_kho);
    $product_stmt->execute();
    $products = $product_stmt->get_result();

    // Thêm chi tiết kiểm kê
    $detail_sql = "INSERT INTO chi_tiet_kiem_ke (ma_phieu_kiem_ke, ma_hang_hoa, so_luong_he_thong, so_luong_thuc_te, chenh_lech) 
                   VALUES (?, ?, ?, ?, ?)";
    $detail_stmt = $conn->prepare($detail_sql);

    while ($product = $products->fetch_assoc()) {
        $ma_hang_hoa = $product['ma_hang_hoa'];
        $so_luong_he_thong = $product['so_luong'];
        $so_luong_thuc_te = $so_luong_he_thong; // Mặc định bằng hệ thống
        $chenh_lech = 0;

        $detail_stmt->bind_param("iiiii", $ma_phieu_kiem_ke, $ma_hang_hoa, $so_luong_he_thong, $so_luong_thuc_te, $chenh_lech);
        
        if (!$detail_stmt->execute()) {
            throw new Exception('Lỗi thêm chi tiết kiểm kê: ' . $detail_stmt->error);
        }
    }

    $product_stmt->close();
    $detail_stmt->close();

    // Commit transaction
    $conn->commit();

    // Ghi lịch sử
    $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $history_sql = "INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip) 
                    VALUES (?, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', ?, ?, ?)";
    $history_stmt = $conn->prepare($history_sql);
    $chi_tiet = "Tạo phiếu kiểm kê KK-" . str_pad($ma_phieu_kiem_ke, 3, '0', STR_PAD_LEFT);
    $history_stmt->bind_param("iiss", $ma_nguoi_tao, $ma_phieu_kiem_ke, $chi_tiet, $ip);
    $history_stmt->execute();
    $history_stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Tạo phiếu kiểm kê thành công',
        'ma_phieu_kiem_ke' => $ma_phieu_kiem_ke
    ]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>