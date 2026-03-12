<?php
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

    $ma_san_pham   = trim($_POST['ma_san_pham'] ?? '');
    $ten_hang_hoa  = trim($_POST['ten_hang_hoa'] ?? '');
    $ma_danh_muc   = (int)($_POST['ma_danh_muc'] ?? 0);
    $gia_nhap      = (float)str_replace(',', '', $_POST['gia_nhap'] ?? 0);
    $so_luong      = (int)($_POST['so_luong'] ?? 0);
    $ma_kho        = (int)($_POST['ma_kho'] ?? 0);

    if (empty($ma_san_pham)) {
        throw new Exception('Thiếu mã sản phẩm');
    }

    $conn->begin_transaction();

    // Cập nhật hang_hoa
    $stmt = $conn->prepare("
        UPDATE hang_hoa 
        SET ten_hang_hoa = ?, ma_danh_muc = ?, gia_nhap = ?
        WHERE ma_san_pham = ?
    ");
    if (!$stmt) {
        throw new Exception('Lỗi prepare: ' . $conn->error);
    }
    
    $stmt->bind_param("sids", $ten_hang_hoa, $ma_danh_muc, $gia_nhap, $ma_san_pham);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật: ' . $stmt->error);
    }
    $stmt->close();

    // Lấy ma_hang_hoa
    $stmt = $conn->prepare("SELECT ma_hang_hoa FROM hang_hoa WHERE ma_san_pham = ?");
    $stmt->bind_param("s", $ma_san_pham);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $ma_hang_hoa = $row['ma_hang_hoa'] ?? 0;
    $stmt->close();

    // Cập nhật tồn kho
    if ($ma_hang_hoa > 0 && $ma_kho > 0) {
        // Kiểm tra đã có tồn kho chưa
        $check = $conn->prepare("SELECT ma_ton_kho FROM ton_kho WHERE ma_hang_hoa = ?");
        $check->bind_param("i", $ma_hang_hoa);
        $check->execute();
        $checkResult = $check->get_result();
        
        if ($checkResult->num_rows > 0) {
            $stmt = $conn->prepare("
                UPDATE ton_kho 
                SET so_luong = ?, ma_kho = ?
                WHERE ma_hang_hoa = ?
            ");
            $stmt->bind_param("iii", $so_luong, $ma_kho, $ma_hang_hoa);
        } else {
            $stmt = $conn->prepare("
                INSERT INTO ton_kho (ma_kho, ma_hang_hoa, so_luong) 
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("iii", $ma_kho, $ma_hang_hoa, $so_luong);
        }
        
        if (!$stmt->execute()) {
            throw new Exception('Lỗi cập nhật tồn kho: ' . $stmt->error);
        }
        $stmt->close();
    }

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);

} catch (Exception $e) {
    if (isset($conn) && $conn) {
        $conn->rollback();
    }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>