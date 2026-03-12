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

    // Danh sách chức năng mặc định
    $functions = [
        ['id' => 'products', 'name' => 'Quản lý sản phẩm'],
        ['id' => 'categories', 'name' => 'Danh mục hàng hóa'],
        ['id' => 'suppliers', 'name' => 'Nhà cung cấp'],
        ['id' => 'warehouses', 'name' => 'Kho hàng'],
        ['id' => 'import', 'name' => 'Phiếu nhập'],
        ['id' => 'export', 'name' => 'Phiếu xuất'],
        ['id' => 'inventory', 'name' => 'Tồn kho'],
        ['id' => 'stocktake', 'name' => 'Kiểm kê kho'],
        ['id' => 'reports', 'name' => 'Báo cáo'],
        ['id' => 'users', 'name' => 'Quản lý người dùng'],
        ['id' => 'roles', 'name' => 'Quản lý vai trò'],
        ['id' => 'history', 'name' => 'Lịch sử hệ thống']
    ];

    $actions = [
        ['id' => 'view', 'name' => 'Xem'],
        ['id' => 'create', 'name' => 'Thêm'],
        ['id' => 'edit', 'name' => 'Sửa'],
        ['id' => 'delete', 'name' => 'Xóa'],
        ['id' => 'approve', 'name' => 'Duyệt']
    ];

    echo json_encode([
        'success' => true,
        'data' => [
            'functions' => $functions,
            'actions' => $actions
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>