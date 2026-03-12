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

    $ma_phieu_kiem_ke = isset($_POST['ma_phieu_kiem_ke']) ? (int)$_POST['ma_phieu_kiem_ke'] : 0;

    if ($ma_phieu_kiem_ke <= 0) {
        throw new Exception('Mã phiếu kiểm kê không hợp lệ');
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Lấy chi tiết kiểm kê
    $detail_sql = "
        SELECT ct.*, tk.ma_ton_kho, tk.ma_kho
        FROM chi_tiet_kiem_ke ct
        LEFT JOIN ton_kho tk ON ct.ma_hang_hoa = tk.ma_hang_hoa
        WHERE ct.ma_phieu_kiem_ke = ?
    ";
    $detail_stmt = $conn->prepare($detail_sql);
    $detail_stmt->bind_param("i", $ma_phieu_kiem_ke);
    $detail_stmt->execute();
    $details = $detail_stmt->get_result();

    $tong_chenh_lech = 0;
    $updated_count = 0;

    while ($row = $details->fetch_assoc()) {
        $tong_chenh_lech += $row['chenh_lech'];
        
        // Nếu có chênh lệch và tồn tại bản ghi ton_kho
        if ($row['chenh_lech'] != 0 && $row['ma_ton_kho']) {
            // Cập nhật tồn kho theo số lượng thực tế
            $update_sql = "UPDATE ton_kho SET so_luong = ? WHERE ma_ton_kho = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $row['so_luong_thuc_te'], $row['ma_ton_kho']);
            
            if ($update_stmt->execute()) {
                $updated_count++;
            }
            $update_stmt->close();
        }
    }

    // Cập nhật trạng thái phiếu kiểm kê
    $trang_thai = ($tong_chenh_lech == 0) ? 'hoan_thanh' : 'da_dieu_chinh';
    
    $update_phieu_sql = "UPDATE phieu_kiem_ke SET trang_thai = ?, ngay_hoan_thanh = NOW() WHERE ma_phieu_kiem_ke = ?";
    $update_phieu_stmt = $conn->prepare($update_phieu_sql);
    $update_phieu_stmt->bind_param("si", $trang_thai, $ma_phieu_kiem_ke);
    
    if (!$update_phieu_stmt->execute()) {
        throw new Exception('Lỗi cập nhật trạng thái phiếu: ' . $update_phieu_stmt->error);
    }
    $update_phieu_stmt->close();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Hoàn thành kiểm kê thành công',
        'data' => [
            'tong_chenh_lech' => $tong_chenh_lech,
            'so_sp_dieu_chinh' => $updated_count
        ]
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