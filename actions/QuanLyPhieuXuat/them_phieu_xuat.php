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
    $nguoi_nhan = isset($_POST['nguoi_nhan']) ? trim($_POST['nguoi_nhan']) : '';
    $bo_phan = isset($_POST['bo_phan']) ? trim($_POST['bo_phan']) : '';
    $ghi_chu = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0; // 0: chờ duyệt, 1: đã duyệt
    $ma_nguoi_tao = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;
    
    // Lấy danh sách sản phẩm từ JSON
    $san_phams = isset($_POST['san_phams']) ? json_decode($_POST['san_phams'], true) : [];

    // Validate
    if ($ma_kho <= 0) {
        throw new Exception('Vui lòng chọn kho xuất');
    }

    if (empty($nguoi_nhan)) {
        throw new Exception('Vui lòng nhập tên người nhận');
    }

    if (empty($san_phams)) {
        throw new Exception('Vui lòng thêm ít nhất một sản phẩm');
    }

    if ($ma_nguoi_tao <= 0) {
        throw new Exception('Không xác định được người tạo');
    }

    // Tính toán tổng
    $so_mat_hang = count($san_phams);
    $tong_so_luong = 0;
    $tong_gia_tri = 0;

    // Kiểm tra tồn kho trước khi xuất
    foreach ($san_phams as $sp) {
        $ma_hang_hoa = (int)$sp['ma_hang_hoa'];
        $so_luong_xuat = (int)$sp['so_luong'];
        
        // Kiểm tra tồn kho
        $check = $conn->prepare("SELECT so_luong FROM ton_kho WHERE ma_kho = ? AND ma_hang_hoa = ?");
        $check->bind_param("ii", $ma_kho, $ma_hang_hoa);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Sản phẩm {$sp['ten_hang_hoa']} không có trong kho");
        }
        
        $ton_kho = $result->fetch_assoc();
        if ($ton_kho['so_luong'] < $so_luong_xuat) {
            throw new Exception("Sản phẩm {$sp['ten_hang_hoa']} chỉ còn {$ton_kho['so_luong']} trong kho");
        }
        
        $tong_so_luong += $so_luong_xuat;
        $tong_gia_tri += $so_luong_xuat * (float)$sp['gia_xuat'];
        $check->close();
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Tạo chuỗi bo_phan_nguoi_nhan
    $bo_phan_nguoi_nhan = $nguoi_nhan . ($bo_phan ? '|' . $bo_phan : '');

    // Thêm phiếu xuất
    $sql = "INSERT INTO phieu_xuat (ma_kho, bo_phan_nguoi_nhan, so_mat_hang, tong_so_luong, tong_gia_tri, trang_thai, ghi_chu, ma_nguoi_tao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("isiiidsi", $ma_kho, $bo_phan_nguoi_nhan, $so_mat_hang, $tong_so_luong, $tong_gia_tri, $trang_thai, $ghi_chu, $ma_nguoi_tao);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm phiếu xuất: ' . $stmt->error);
    }

    $ma_phieu_xuat = $conn->insert_id;
    $stmt->close();

    // Thêm chi tiết phiếu xuất và cập nhật tồn kho
    $sql = "INSERT INTO chi_tiet_phieu_xuat (ma_phieu_xuat, ma_hang_hoa, so_luong, gia_xuat) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement chi tiết: ' . $conn->error);
    }

    foreach ($san_phams as $sp) {
        $ma_hang_hoa = (int)$sp['ma_hang_hoa'];
        $so_luong = (int)$sp['so_luong'];
        $gia_xuat = (float)$sp['gia_xuat'];
        
        $stmt->bind_param("iiid", $ma_phieu_xuat, $ma_hang_hoa, $so_luong, $gia_xuat);
        
        if (!$stmt->execute()) {
            throw new Exception('Lỗi thêm chi tiết phiếu xuất: ' . $stmt->error);
        }

        // Cập nhật tồn kho (trừ đi số lượng xuất)
        $update = $conn->prepare("UPDATE ton_kho SET so_luong = so_luong - ? WHERE ma_kho = ? AND ma_hang_hoa = ?");
        $update->bind_param("iii", $so_luong, $ma_kho, $ma_hang_hoa);
        $update->execute();
        $update->close();
    }

    $stmt->close();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true, 
        'message' => $trang_thai == 0 ? 'Lưu nháp thành công' : 'Gửi duyệt thành công',
        'ma_phieu_xuat' => $ma_phieu_xuat
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