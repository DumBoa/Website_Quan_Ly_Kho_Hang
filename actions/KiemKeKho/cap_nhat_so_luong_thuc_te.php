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

    // Lấy tham số từ request
    $ma_chi_tiet = isset($_POST['ma_chi_tiet']) ? (int)$_POST['ma_chi_tiet'] : 0;
    $ma_phieu_kiem_ke = isset($_POST['ma_phieu_kiem_ke']) ? (int)$_POST['ma_phieu_kiem_ke'] : 0;
    $ma_hang_hoa = isset($_POST['ma_hang_hoa']) ? (int)$_POST['ma_hang_hoa'] : 0;
    $so_luong_thuc_te = isset($_POST['so_luong_thuc_te']) ? (int)$_POST['so_luong_thuc_te'] : 0;

    // Xác định cách cập nhật
    if ($ma_chi_tiet > 0) {
        // Cập nhật theo ma_chi_tiet
        $sql = "UPDATE chi_tiet_kiem_ke SET so_luong_thuc_te = ? WHERE ma_chi_tiet = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $so_luong_thuc_te, $ma_chi_tiet);
    } elseif ($ma_phieu_kiem_ke > 0 && $ma_hang_hoa > 0) {
        // Cập nhật theo ma_phieu_kiem_ke và ma_hang_hoa
        $sql = "UPDATE chi_tiet_kiem_ke SET so_luong_thuc_te = ? WHERE ma_phieu_kiem_ke = ? AND ma_hang_hoa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $so_luong_thuc_te, $ma_phieu_kiem_ke, $ma_hang_hoa);
    } else {
        throw new Exception('Thiếu thông tin cập nhật');
    }

    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật số lượng: ' . $stmt->error);
    }

    // Tính lại chênh lệch
    $update_diff_sql = "UPDATE chi_tiet_kiem_ke SET chenh_lech = so_luong_thuc_te - so_luong_he_thong 
                        WHERE ma_phieu_kiem_ke = ? AND ma_hang_hoa = ?";
    $update_diff_stmt = $conn->prepare($update_diff_sql);
    $update_diff_stmt->bind_param("ii", $ma_phieu_kiem_ke, $ma_hang_hoa);
    $update_diff_stmt->execute();
    $update_diff_stmt->close();

    // Lấy giá trị chênh lệch mới
    $select_sql = "SELECT chenh_lech FROM chi_tiet_kiem_ke WHERE ma_phieu_kiem_ke = ? AND ma_hang_hoa = ?";
    $select_stmt = $conn->prepare($select_sql);
    $select_stmt->bind_param("ii", $ma_phieu_kiem_ke, $ma_hang_hoa);
    $select_stmt->execute();
    $select_result = $select_stmt->get_result();
    $row = $select_result->fetch_assoc();
    $chenh_lech = $row ? $row['chenh_lech'] : 0;

    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật số lượng thành công',
        'chenh_lech' => $chenh_lech
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>