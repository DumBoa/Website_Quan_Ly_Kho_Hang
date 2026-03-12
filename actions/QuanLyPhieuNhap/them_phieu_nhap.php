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
    $ma_nha_cung_cap = isset($_POST['ma_nha_cung_cap']) ? (int)$_POST['ma_nha_cung_cap'] : 0;
    $ghi_chu = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : '';
    $trang_thai = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0;
    $ma_nguoi_tao = isset($_SESSION['ma_nguoi_dung']) ? (int)$_SESSION['ma_nguoi_dung'] : 0;
    
    // Lấy danh sách sản phẩm từ JSON
    $san_phams = isset($_POST['san_phams']) ? json_decode($_POST['san_phams'], true) : [];

    // Validate
    if ($ma_kho <= 0) {
        throw new Exception('Vui lòng chọn kho nhập');
    }

    if ($ma_nha_cung_cap <= 0) {
        throw new Exception('Vui lòng chọn nhà cung cấp');
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
    $tong_tien = 0;

    // Kiểm tra và lấy ma_hang_hoa cho từng sản phẩm
    foreach ($san_phams as &$sp) {
        if (empty($sp['ma_hang_hoa']) || $sp['ma_hang_hoa'] == 0) {
            // Nếu là sản phẩm mới, thêm vào database
            $ma_san_pham = $sp['ma_san_pham'];
            $ten_hang_hoa = $sp['ten_hang_hoa'];
            $gia_nhap = $sp['gia_nhap'];
            
            // Kiểm tra sản phẩm đã tồn tại chưa
            $stmt = $conn->prepare("SELECT ma_hang_hoa FROM hang_hoa WHERE ma_san_pham = ?");
            $stmt->bind_param("s", $ma_san_pham);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Sản phẩm đã tồn tại
                $row = $result->fetch_assoc();
                $sp['ma_hang_hoa'] = $row['ma_hang_hoa'];
            } else {
                // Thêm sản phẩm mới
                $insert = $conn->prepare("INSERT INTO hang_hoa (ma_san_pham, ten_hang_hoa, ma_nha_cung_cap, gia_nhap, trang_thai) VALUES (?, ?, ?, ?, 1)");
                $insert->bind_param("ssid", $ma_san_pham, $ten_hang_hoa, $ma_nha_cung_cap, $gia_nhap);
                if (!$insert->execute()) {
                    throw new Exception('Lỗi thêm sản phẩm mới: ' . $insert->error);
                }
                $sp['ma_hang_hoa'] = $insert->insert_id;
                $insert->close();
            }
            $stmt->close();
        }
        
        $tong_so_luong += (int)$sp['so_luong'];
        $tong_tien += (int)$sp['so_luong'] * (float)$sp['gia_nhap'];
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Thêm phiếu nhập
    $sql = "INSERT INTO phieu_nhap (ma_kho, ma_nha_cung_cap, so_mat_hang, tong_so_luong, tong_tien, trang_thai, ghi_chu, ma_nguoi_tao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("iiiidisi", $ma_kho, $ma_nha_cung_cap, $so_mat_hang, $tong_so_luong, $tong_tien, $trang_thai, $ghi_chu, $ma_nguoi_tao);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm phiếu nhập: ' . $stmt->error);
    }

    $ma_phieu_nhap = $conn->insert_id;
    $stmt->close();

    // Thêm chi tiết phiếu nhập
    $sql = "INSERT INTO chi_tiet_phieu_nhap (ma_phieu_nhap, ma_hang_hoa, so_luong, gia_nhap) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi prepare statement chi tiết: ' . $conn->error);
    }

    // Trong them_phieu_nhap.php, phần thêm chi tiết phiếu nhập
foreach ($san_phams as $sp) {
    $ma_hang_hoa = (int)$sp['ma_hang_hoa'];
    $so_luong = (int)$sp['so_luong'];
    $gia_nhap = (float)$sp['gia_nhap'];
    
    $stmt->bind_param("iiid", $ma_phieu_nhap, $ma_hang_hoa, $so_luong, $gia_nhap);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm chi tiết phiếu nhập: ' . $stmt->error);
    }

    // Nếu phiếu đã duyệt (trang_thai = 1), cập nhật tồn kho
    if ($trang_thai == 1) {
        // Kiểm tra tồn kho đã có chưa
        $check = $conn->prepare("SELECT ma_ton_kho FROM ton_kho WHERE ma_kho = ? AND ma_hang_hoa = ?");
        $check->bind_param("ii", $ma_kho, $ma_hang_hoa);
        $check->execute();
        $checkResult = $check->get_result();
        
        if ($checkResult->num_rows > 0) {
            // Cập nhật số lượng (CỘNG thêm)
            $update = $conn->prepare("UPDATE ton_kho SET so_luong = so_luong + ? WHERE ma_kho = ? AND ma_hang_hoa = ?");
            $update->bind_param("iii", $so_luong, $ma_kho, $ma_hang_hoa);
            $update->execute();
            $update->close();
        } else {
            // Thêm mới
            $insert = $conn->prepare("INSERT INTO ton_kho (ma_kho, ma_hang_hoa, so_luong) VALUES (?, ?, ?)");
            $insert->bind_param("iii", $ma_kho, $ma_hang_hoa, $so_luong);
            $insert->execute();
            $insert->close();
        }
        $check->close();
    }
}

    $stmt->close();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true, 
        'message' => $trang_thai == 0 ? 'Lưu nháp thành công' : 'Gửi duyệt thành công',
        'ma_phieu_nhap' => $ma_phieu_nhap
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