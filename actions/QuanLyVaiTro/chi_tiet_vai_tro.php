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
    if ($vai_tro !== 'ADMIN') {
        throw new Exception('Bạn không có quyền truy cập chức năng này');
    }

    $ma_vai_tro = isset($_GET['ma_vai_tro']) ? (int)$_GET['ma_vai_tro'] : 0;

    if ($ma_vai_tro <= 0) {
        throw new Exception('Mã vai trò không hợp lệ');
    }

    $sql = "SELECT vt.*, COUNT(nd.ma_nguoi_dung) as so_nguoi_dung
            FROM vai_tro vt
            LEFT JOIN nguoi_dung nd ON vt.ma_vai_tro = nd.ma_vai_tro
            WHERE vt.ma_vai_tro = ?
            GROUP BY vt.ma_vai_tro";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_vai_tro);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Không tìm thấy vai trò');
    }

    $row = $result->fetch_assoc();

    // Lấy danh sách quyền của vai trò
    $permissions_sql = "SELECT chuc_nang, hanh_dong FROM vai_tro_quyen WHERE ma_vai_tro = ?";
    $permissions_stmt = $conn->prepare($permissions_sql);
    $permissions_stmt->bind_param("i", $ma_vai_tro);
    $permissions_stmt->execute();
    $permissions_result = $permissions_stmt->get_result();
    
    $permissions = [];
    while ($perm = $permissions_result->fetch_assoc()) {
        if (!isset($permissions[$perm['chuc_nang']])) {
            $permissions[$perm['chuc_nang']] = [];
        }
        $permissions[$perm['chuc_nang']][] = $perm['hanh_dong'];
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ma_vai_tro' => (int)$row['ma_vai_tro'],
            'ten_vai_tro' => $row['ten_vai_tro'],
            'mo_ta' => $row['mo_ta'] ?? '',
            'so_nguoi_dung' => (int)$row['so_nguoi_dung'],
            'trang_thai' => (int)$row['trang_thai'],
            'ngay_tao' => $row['ngay_tao'],
            'permissions' => $permissions
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>