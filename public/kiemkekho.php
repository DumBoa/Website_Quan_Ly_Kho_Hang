<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}

$ma_nguoi_dung = $_SESSION["ma_nguoi_dung"];
$ten = $_SESSION["ho_ten"];
$role = $_SESSION["vai_tro"];
$username = $_SESSION["ten_dang_nhap"];
?>

<!doctype html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm Kê Kho - Quản Lý Kho</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="/_sdk/element_sdk.js"></script>
    <link rel="stylesheet" href="../public/CSS/dashboard.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f0f3f9',
                            100: '#e1e7f3',
                            200: '#c3cfe7',
                            300: '#a5b7db',
                            400: '#879fcf',
                            500: '#6987c3',
                            600: '#4b6fb7',
                            700: '#1e3a5f',
                            800: '#162c47',
                            900: '#0e1e2f'
                        }
                    },
                    fontFamily: {
                        inter: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        /* Table Styles - Giữ nguyên của bạn */
        .audit-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .audit-table thead {
            background-color: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        .audit-table thead th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #1e3a5f;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .audit-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .audit-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .audit-table tbody td {
            padding: 12px 16px;
            color: #374151;
        }

        .audit-table input {
            width: 100%;
            padding: 6px 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .audit-table input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .difference-positive {
            color: #10b981;
            font-weight: 600;
        }

        .difference-negative {
            color: #ef4444;
            font-weight: 600;
        }

        .row-highlight {
            background-color: #fef3c7;
        }

        /* Modal Styles - Giữ nguyên của bạn */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow: auto;
            transform: scale(0.9);
            transition: all 0.3s;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        /* Toast Styles */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            padding: 14px 20px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s;
            z-index: 2000;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-success {
            background: #059669;
        }

        .toast-error {
            background: #dc2626;
        }
        
        /* ========== BUTTON STYLES - TỪ PHIEUXUAT.PHP ========== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
        }
        
        .btn-primary {
            background: #1e3a5f;
            color: white;
        }
        
        .btn-primary:hover {
            background: #152a45;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
        }
        
        .btn-danger:hover {
            background: #dc2626;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline {
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        
        .btn-outline:hover {
            background: #f8fafc;
            border-color: #334e68;
            color: #1e293b;
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
            color: #1f2937;
        }
        
        /* ========== FORM INPUT STYLES ========== */
        .form-input,
        .form-select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
        }
        
        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #334e68;
            box-shadow: 0 0 0 3px rgba(51, 78, 104, 0.1);
        }
        
        .form-input::placeholder {
            color: #94a3b8;
        }
        
        .form-input.bg-slate-50,
        .form-select.bg-slate-50 {
            background-color: #f8fafc;
            cursor: not-allowed;
        }
        
        /* ========== CONTENT CARD STYLES ========== */
        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .content-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .content-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .content-card-body {
            padding: 20px;
        }
        
        .content-card-body.p-0 {
            padding: 0;
        }
        
        /* ========== BADGE STYLES ========== */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-approved {
            background: #d1fae5;
            color: #059669;
        }
        
        .badge-rejected {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .badge-dang-kiem-ke {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-hoan-thanh {
            background: #d1fae5;
            color: #059669;
        }
        
        .badge-da-dieu-chinh {
            background: #dbeafe;
            color: #1e40af;
        }
        
        /* ========== PAGINATION STYLES ========== */
        .pagination-btn {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: #f8fafc;
            color: #1e293b;
            border-color: #334e68;
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination-btn.active {
            background: #1e3a5f;
            color: white;
            border-color: #1e3a5f;
        }
        
        .pagination-info {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }
        
        /* ========== ANIMATIONS ========== */
        .btn-transition {
            transition: all 0.2s ease;
        }
        
        .slide-in {
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* ========== UTILITY CLASSES ========== */
        .bg-navy-700 {
            background-color: #1e3a5f;
        }
        
        .text-navy-700 {
            color: #1e3a5f;
        }
        
        .text-navy-800 {
            color: #162c47;
        }
        
        .border-navy-700 {
            border-color: #1e3a5f;
        }
        
        /* ========== SEARCH WRAPPER ========== */
        .search-wrapper {
            position: relative;
        }
        
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 18px;
            height: 18px;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
            font-family: 'Inter', sans-serif;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #334e68;
            box-shadow: 0 0 0 3px rgba(51, 78, 104, 0.1);
        }
        
        /* ========== ACTION BUTTONS ========== */
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-action-view,
        .btn-action-edit,
        .btn-action-delete {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            background: #f8fafc;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 16px;
        }
        
        .btn-action-view:hover {
            background: #dbeafe;
        }
        
        .btn-action-edit:hover {
            background: #fef3c7;
        }
        
        .btn-action-delete:hover {
            background: #fee2e2;
        }
        
        /* ========== TOOLBAR STYLES ========== */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .toolbar-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 200px;
        }
        
        .toolbar-search {
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            color: #1e293b;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            flex: 1;
        }
        
        .toolbar-search:focus {
            outline: none;
            border-color: #334e68;
            box-shadow: 0 0 0 3px rgba(51, 78, 104, 0.1);
        }
        
        .btn-refresh {
            width: 40px;
            height: 40px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #64748b;
        }
        
        .btn-refresh:hover {
            background: #f8fafc;
            color: #1e293b;
            border-color: #334e68;
        }
    </style>
</head>
<body class="h-full">
    <div class="wms-app">
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- Sidebar -->
        <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>

        <!-- Main Content -->
        <div class="wms-main">
            <!-- Topbar -->
            <?php include __DIR__ . "/../views/Layout/header.php"; ?>

            <!-- Page Content -->
            <main class="wms-content custom-scrollbar">
                <!-- Page Header -->
                <div class="mb-6 animate-fadeIn">
                    <nav class="flex items-center gap-2 text-sm mb-4">
                        <a href="#" class="text-slate-500 hover:text-navy-700 transition-colors">Trang chủ</a>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-navy-700 font-medium">Kiểm kê kho</span>
                    </nav>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h1 id="page-title" class="text-4xl font-bold text-navy-800">KIỂM KÊ KHO</h1>
                            <p id="page-description" class="text-slate-600">Đối chiếu số lượng hàng hóa trong hệ thống với số lượng thực tế tại kho.</p>
                        </div>
                        <button id="create-btn" class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span id="create-btn-text">Tạo phiên kiểm kê</span>
                        </button>
                    </div>
                </div>

                <!-- Filter Toolbar -->
                <div class="content-card p-5 mb-6 animate-fadeIn" style="animation-delay: 0.1s">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Chọn kho</label>
                            <select id="filter-warehouse" class="form-select">
                                <option value="">Tất cả kho</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Trạng thái</label>
                            <select id="filter-status" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="dang_kiem_ke">Đang kiểm kê</option>
                                <option value="hoan_thanh">Hoàn thành</option>
                                <option value="da_dieu_chinh">Đã điều chỉnh</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Từ ngày</label>
                            <input type="date" id="filter-from" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Đến ngày</label>
                            <input type="date" id="filter-to" class="form-input">
                        </div>
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button id="refresh-btn" class="btn btn-outline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Làm mới
                        </button>
                        <button id="apply-filter-btn" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Lọc
                        </button>
                    </div>
                </div>

                <!-- Audit Sessions Table -->
                <div class="content-card overflow-hidden animate-fadeIn" style="animation-delay: 0.15s">
                    <div class="content-card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="audit-table">
                                <thead>
                                    <tr>
                                        <th>Mã kiểm kê</th>
                                        <th>Kho</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày hoàn thành</th>
                                        <th>Tổng SP</th>
                                        <th>Chênh lệch</th>
                                        <th>Người thực hiện</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="audit-tbody">
                                    <tr>
                                        <td colspan="9" class="text-center py-10 text-slate-500">
                                            Đang tải dữ liệu...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50">
                        <span class="text-sm text-slate-600" id="pagination-info">Hiển thị 0-0 trong 0 phiên kiểm kê</span>
                        <div class="flex items-center gap-2" id="pagination-controls">
                            <!-- Pagination buttons will be rendered here -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Create Audit Modal -->
    <div id="audit-modal" class="modal-overlay">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-navy-700">
                <h2 class="text-xl font-bold text-white">Tạo phiên kiểm kê mới</h2>
                <button id="close-modal" class="text-white hover:text-slate-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <!-- Form Section 1: General Info -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-navy-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs">1</span> 
                        Thông tin chung
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Mã kiểm kê *</label>
                            <input type="text" id="audit-code" class="form-input bg-slate-50" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Kho kiểm kê *</label>
                            <select id="warehouse-select" class="form-select">
                                <option value="">Chọn kho...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Ngày kiểm kê *</label>
                            <input type="date" id="audit-date" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Người kiểm kê</label>
                            <input type="text" value="<?php echo htmlspecialchars($ten); ?>" class="form-input bg-slate-50" readonly>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Ghi chú</label>
                        <textarea id="audit-note" class="form-input" rows="2" placeholder="Nhập ghi chú kiểm kê..."></textarea>
                    </div>
                </div>

                <!-- Form Section 2: Product Audit -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-navy-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs">2</span> 
                        Danh sách sản phẩm kiểm kê
                    </h3>
                    
                    <div id="product-list-container" class="hidden">
                        <div class="mb-4 flex gap-2">
                            <input type="text" id="product-search" placeholder="Tìm sản phẩm..." class="flex-1 form-input">
                            <button id="search-product-btn" class="btn btn-outline">Tìm</button>
                        </div>
                        <div class="overflow-x-auto max-h-96 border border-slate-200 rounded-lg">
                            <table class="audit-table">
                                <thead class="sticky top-0 bg-slate-100">
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Tồn kho hệ thống</th>
                                        <th>Số lượng thực tế</th>
                                        <th>Chênh lệch</th>
                                    </tr>
                                </thead>
                                <tbody id="product-tbody">
                                    <!-- Products will be loaded here -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <p class="text-sm text-slate-600 mb-1">Tổng sản phẩm kiểm kê</p>
                                <p class="text-2xl font-bold text-navy-800" id="total-products">0</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <p class="text-sm text-slate-600 mb-1">Sản phẩm chênh lệch</p>
                                <p class="text-2xl font-bold text-orange-600" id="diff-products">0</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <p class="text-sm text-slate-600 mb-1">Tổng chênh lệch</p>
                                <p class="text-2xl font-bold" id="total-diff">0</p>
                            </div>
                        </div>
                    </div>

                    <div id="no-warehouse-selected" class="text-center py-10 text-slate-500">
                        Vui lòng chọn kho để hiển thị danh sách sản phẩm
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button id="cancel-btn" class="btn btn-outline">Hủy</button>
                <button id="save-draft-btn" class="btn btn-secondary">Lưu tạm</button>
                <button id="complete-btn" class="btn btn-success">Hoàn thành kiểm kê</button>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-navy-700">
                <h2 class="text-xl font-bold text-white">Chi tiết kiểm kê</h2>
                <button id="close-detail-modal" class="text-white hover:text-slate-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="detail-content" class="p-6">
                <!-- Detail content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal-overlay">
        <div class="modal-content max-w-md">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-semibold text-navy-800">Xác nhận xóa</h3>
            </div>
            <div class="p-6">
                <p class="text-slate-600">Bạn có chắc chắn muốn xóa phiếu kiểm kê <strong id="delete-code"></strong>?</p>
                <p class="text-sm text-slate-500 mt-2">Hành động này không thể hoàn tác.</p>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                <button id="cancel-delete-btn" class="btn btn-outline">Hủy</button>
                <button id="confirm-delete-btn" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <svg class="w-5 h-5" id="toastIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
        <span id="toastMessage"></span>
    </div>

    <script>
        // ==================== CẤU HÌNH ====================
        const currentUser = {
            ma_nguoi_dung: <?php echo json_encode($ma_nguoi_dung ?? 0); ?>,
            ho_ten: <?php echo json_encode($ten ?? ''); ?>,
            vai_tro: <?php echo json_encode($role ?? ''); ?>
        };

        const defaultConfig = {
            page_title: 'KIỂM KÊ KHO',
            page_description: 'Đối chiếu số lượng hàng hóa trong hệ thống với số lượng thực tế tại kho.',
            create_session_btn: '+ Tạo phiên kiểm kê'
        };

        // ==================== BIẾN TOÀN CỤC ====================
        let auditList = [];
        let filteredList = [];
        let khoList = [];
        let currentAuditId = null;
        let currentPage = 1;
        const itemsPerPage = 10;

        // ==================== UTILITY FUNCTIONS ====================
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const date = new Date(dateStr);
            return date.toLocaleDateString('vi-VN');
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastIcon = document.getElementById('toastIcon');
            const toastMessage = document.getElementById('toastMessage');

            toast.className = `toast toast-${type}`;
            toastMessage.textContent = message;

            if (type === 'success') {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
            } else if (type === 'error') {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            } else {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            }

            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // ==================== API CALLS ====================
        async function loadAuditList() {
            try {
                const ma_kho = document.getElementById('filter-warehouse')?.value || '';
                const trang_thai = document.getElementById('filter-status')?.value || '';
                const tu_ngay = document.getElementById('filter-from')?.value || '';
                const den_ngay = document.getElementById('filter-to')?.value || '';

                let url = '../actions/KiemKeKho/lay_danh_sach_phieu_kiem_ke.php?';
                const params = new URLSearchParams();
                if (ma_kho) params.append('ma_kho', ma_kho);
                if (trang_thai) params.append('trang_thai', trang_thai);
                if (tu_ngay) params.append('tu_ngay', tu_ngay);
                if (den_ngay) params.append('den_ngay', den_ngay);

                const response = await fetch(url + params.toString());
                const result = await response.json();

                if (result.success) {
                    auditList = result.data;
                    filteredList = [...auditList];
                    renderAuditTable();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                console.error('Error loading audit list:', error);
                showToast('Lỗi tải danh sách kiểm kê', 'error');
            }
        }

        async function loadKhoList() {
            try {
                const response = await fetch('../actions/KiemKeKho/lay_danh_sach_kho.php');
                const result = await response.json();

                if (result.success) {
                    khoList = result.data;
                    renderKhoOptions();
                }
            } catch (error) {
                console.error('Error loading kho list:', error);
            }
        }

        async function loadProductsByKho(maKho) {
            try {
                const response = await fetch(`../actions/KiemKeKho/lay_san_pham_theo_kho.php?ma_kho=${maKho}`);
                const result = await response.json();

                if (result.success) {
                    renderProductTable(result.data);
                    document.getElementById('total-products').textContent = result.data.length;
                    return result.data;
                } else {
                    showToast(result.message, 'error');
                    return [];
                }
            } catch (error) {
                console.error('Error loading products:', error);
                showToast('Lỗi tải danh sách sản phẩm', 'error');
                return [];
            }
        }

        async function createAudit() {
            const maKho = document.getElementById('warehouse-select').value;
            const ghiChu = document.getElementById('audit-note').value;
            const ngayKiemKe = document.getElementById('audit-date').value;

            if (!maKho) {
                showToast('Vui lòng chọn kho kiểm kê', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('ma_kho', maKho);
            formData.append('ghi_chu', ghiChu);
            formData.append('ngay_kiem_ke', ngayKiemKe);

            try {
                const response = await fetch('../actions/KiemKeKho/them_phieu_kiem_ke.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showToast(result.message, 'success');
                    closeModal('audit-modal');
                    loadAuditList();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                console.error('Error creating audit:', error);
                showToast('Lỗi tạo phiếu kiểm kê', 'error');
            }
        }

        async function deleteAudit(id) {
            const formData = new FormData();
            formData.append('ma_phieu_kiem_ke', id);

            try {
                const response = await fetch('../actions/KiemKeKho/xoa_phieu_kiem_ke.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showToast(result.message, 'success');
                    closeModal('delete-modal');
                    loadAuditList();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (error) {
                console.error('Error deleting audit:', error);
                showToast('Lỗi xóa phiếu kiểm kê', 'error');
            }
        }

        async function updateActualQuantity(maChiTiet, soLuong) {
            const formData = new FormData();
            formData.append('ma_chi_tiet', maChiTiet);
            formData.append('so_luong_thuc_te', soLuong);

            try {
                const response = await fetch('../actions/KiemKeKho/cap_nhat_so_luong_thuc_te.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    return result.chenh_lech;
                } else {
                    showToast(result.message, 'error');
                    return null;
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
                showToast('Lỗi cập nhật số lượng', 'error');
                return null;
            }
        }

        // ==================== HOÀN THÀNH KIỂM KÊ ====================
// ==================== HOÀN THÀNH KIỂM KÊ ====================
async function completeAudit() {
    if (!currentAuditId) {
        showToast('Không tìm thấy phiếu kiểm kê', 'error');
        return;
    }

    // Xác nhận trước khi hoàn thành
    if (!confirm('Bạn có chắc chắn muốn hoàn thành kiểm kê? Sau khi hoàn thành, số lượng tồn kho sẽ được cập nhật theo số lượng thực tế.')) {
        return;
    }

    showToast('Đang cập nhật dữ liệu...', 'info');

    // Thu thập dữ liệu từ bảng
    const rows = document.querySelectorAll('#product-tbody tr');
    
    // Cập nhật từng sản phẩm
    for (const row of rows) {
        const maHangHoa = row.dataset.id;
        const input = row.querySelector('.product-input');
        const actualQty = parseInt(input.value) || 0;
        
        // Lấy số lượng hệ thống từ cột thứ 4 (index 3)
        const systemQtyCell = row.querySelector('.system-qty');
        const systemQty = systemQtyCell ? parseInt(systemQtyCell.textContent) : 0;
        
        // Tính chênh lệch
        const diff = actualQty - systemQty;
        
        // Cập nhật ô chênh lệch
        const diffCell = row.querySelector('.diff-cell span');
        if (diffCell) {
            if (diff > 0) {
                diffCell.className = 'difference-positive';
                diffCell.textContent = '+' + diff;
            } else if (diff < 0) {
                diffCell.className = 'difference-negative';
                diffCell.textContent = diff;
            } else {
                diffCell.className = 'text-slate-600';
                diffCell.textContent = '0';
            }
        }

        // Gửi cập nhật lên server nếu có thay đổi
        if (maHangHoa) {
            const formData = new FormData();
            formData.append('ma_chi_tiet', maHangHoa);
            formData.append('so_luong_thuc_te', actualQty);

            try {
                await fetch('../actions/KiemKeKho/cap_nhat_so_luong_thuc_te.php', {
                    method: 'POST',
                    body: formData
                });
            } catch (error) {
                console.error('Error updating quantity:', error);
            }
        }
    }

    // Cập nhật lại summary trước khi hoàn thành
    updateSummary();

    // Gửi request hoàn thành kiểm kê
    const formData = new FormData();
    formData.append('ma_phieu_kiem_ke', currentAuditId);

    try {
        const response = await fetch('../actions/KiemKeKho/hoan_thanh_kiem_ke.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            closeModal('audit-modal');
            loadAuditList(); // Tải lại danh sách
            currentAuditId = null;
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error completing audit:', error);
        showToast('Lỗi hoàn thành kiểm kê', 'error');
    }
}

        // ==================== RENDER FUNCTIONS ====================
        function renderKhoOptions() {
            const filterSelect = document.getElementById('filter-warehouse');
            const modalSelect = document.getElementById('warehouse-select');

            const options = khoList.map(k => 
                `<option value="${k.ma_kho}">${k.ten_kho}</option>`
            ).join('');

            if (filterSelect) {
                filterSelect.innerHTML = '<option value="">Tất cả kho</option>' + options;
            }
            if (modalSelect) {
                modalSelect.innerHTML = '<option value="">Chọn kho...</option>' + options;
            }
        }

        function renderAuditTable() {
            const tbody = document.getElementById('audit-tbody');
            
            if (filteredList.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center py-10 text-slate-500">Không có dữ liệu</td></tr>';
                updatePagination();
                return;
            }

            const start = (currentPage - 1) * itemsPerPage;
            const end = Math.min(start + itemsPerPage, filteredList.length);
            const pageData = filteredList.slice(start, end);

            tbody.innerHTML = pageData.map(item => `
                <tr>
                    <td><span class="font-mono font-medium text-blue-600">${item.ma_phieu}</span></td>
                    <td>${item.ten_kho}</td>
                    <td>${formatDate(item.ngay_tao)}</td>
                    <td>${item.ngay_hoan_thanh ? formatDate(item.ngay_hoan_thanh) : '-'}</td>
                    <td>${item.tong_sp}</td>
                    <td>
                        ${item.tong_chenh_lech > 0 ? 
                            `<span class="difference-positive">+${item.tong_chenh_lech}</span>` : 
                            item.tong_chenh_lech < 0 ? 
                            `<span class="difference-negative">${item.tong_chenh_lech}</span>` : 
                            '<span class="text-slate-600">0</span>'}
                        (${item.sp_chenh_lech} SP)
                    </td>
                    <td>${item.nguoi_tao}</td>
                    <td>
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full ${item.trang_thai_class}">
                            ${item.trang_thai_text}
                        </span>
                    </td>
                    <td>
                        <button class="text-blue-600 hover:text-blue-800 font-medium text-xs mr-2" 
                                onclick="viewDetail(${item.ma_phieu_kiem_ke})">
                            Chi tiết
                        </button>
                        ${item.trang_thai === 'dang_kiem_ke' ? `
                            <button class="text-green-600 hover:text-green-800 font-medium text-xs mr-2" 
                                    onclick="continueAudit(${item.ma_phieu_kiem_ke})">
                                Tiếp tục
                            </button>
                            <button class="text-red-600 hover:text-red-800 font-medium text-xs" 
                                    onclick="openDeleteModal('${item.ma_phieu}', ${item.ma_phieu_kiem_ke})">
                                Xóa
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');

            updatePagination();
        }

        function updatePagination() {
            const totalPages = Math.ceil(filteredList.length / itemsPerPage);
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, filteredList.length);

            document.getElementById('pagination-info').textContent = 
                `Hiển thị ${filteredList.length > 0 ? start : 0}-${end} trong ${filteredList.length} phiên kiểm kê`;

            const controls = document.getElementById('pagination-controls');
            let html = '';

            // Previous button
            html += `<button onclick="changePage(${currentPage - 1})" 
                class="px-3 py-1 border rounded ${currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-slate-100'}" 
                ${currentPage <= 1 ? 'disabled' : ''}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>`;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    html += `<button onclick="changePage(${i})" 
                        class="px-3 py-1 border rounded ${i === currentPage ? 'bg-navy-700 text-white' : 'hover:bg-slate-100'}">
                        ${i}
                    </button>`;
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    html += `<span class="px-2">...</span>`;
                }
            }

            // Next button
            html += `<button onclick="changePage(${currentPage + 1})" 
                class="px-3 py-1 border rounded ${currentPage >= totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-slate-100'}" 
                ${currentPage >= totalPages ? 'disabled' : ''}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>`;

            controls.innerHTML = html;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredList.length / itemsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderAuditTable();
        }

        function renderProductTable(products) {
            const tbody = document.getElementById('product-tbody');
            
            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-slate-500">Không có sản phẩm</td></tr>';
                return;
            }

            tbody.innerHTML = products.map(product => `
                <tr data-id="${product.ma_hang_hoa}">
                    <td class="font-mono">${product.ma_san_pham}</td>
                    <td>${product.ten_san_pham}</td>
                    <td>${product.danh_muc}</td>
                    <td class="system-qty">${product.ton_kho_he_thong}</td>
                    <td>
                        <input type="number" class="product-input" value="${product.ton_kho_he_thong}" min="0">
                    </td>
                    <td class="diff-cell"><span class="text-slate-600">0</span></td>
                </tr>
            `).join('');

            setupProductInputs();
        }

        function setupProductInputs() {
            const inputs = document.querySelectorAll('.product-input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const row = this.closest('tr');
                    const systemQty = parseInt(row.querySelector('.system-qty').textContent);
                    const actualQty = parseInt(this.value) || 0;
                    const diff = actualQty - systemQty;
                    
                    const diffCell = row.querySelector('.diff-cell span');
                    if (diff > 0) {
                        diffCell.className = 'difference-positive';
                        diffCell.textContent = '+' + diff;
                    } else if (diff < 0) {
                        diffCell.className = 'difference-negative';
                        diffCell.textContent = diff;
                    } else {
                        diffCell.className = 'text-slate-600';
                        diffCell.textContent = '0';
                    }
                    
                    updateSummary();
                });
            });
        }

        function updateSummary() {
    const rows = document.querySelectorAll('#product-tbody tr');
    let diffProducts = 0;
    let totalDiff = 0;

    rows.forEach(row => {
        const systemQtyCell = row.querySelector('.system-qty');
        const systemQty = systemQtyCell ? parseInt(systemQtyCell.textContent) : 0;
        
        const input = row.querySelector('.product-input');
        const actualQty = input ? parseInt(input.value) || 0 : 0;
        
        const diff = actualQty - systemQty;
        
        if (diff !== 0) {
            diffProducts++;
            totalDiff += diff;
        }
    });

    document.getElementById('diff-products').textContent = diffProducts;
    
    const totalDiffEl = document.getElementById('total-diff');
    totalDiffEl.textContent = totalDiff > 0 ? '+' + totalDiff : totalDiff;
    if (totalDiff > 0) {
        totalDiffEl.className = 'text-2xl font-bold text-green-600';
    } else if (totalDiff < 0) {
        totalDiffEl.className = 'text-2xl font-bold text-red-600';
    } else {
        totalDiffEl.className = 'text-2xl font-bold text-navy-800';
    }
}

        // ==================== MODAL FUNCTIONS ====================
        // ==================== MODAL FUNCTIONS ====================
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        
        // Reset form khi đóng modal
        if (modalId === 'audit-modal') {
            document.getElementById('product-list-container').classList.add('hidden');
            document.getElementById('no-warehouse-selected').classList.remove('hidden');
            document.getElementById('product-tbody').innerHTML = '';
            document.getElementById('audit-note').value = '';
        }
    }
}

        function openDeleteModal(code, id) {
            currentAuditId = id;
            document.getElementById('delete-code').textContent = code;
            openModal('delete-modal');
        }

        // ==================== XEM CHI TIẾT ====================
async function viewDetail(id) {
    try {
        showToast('Đang tải chi tiết...', 'info');
        
        const response = await fetch(`../actions/KiemKeKho/lay_chi_tiet_phieu_kiem_ke.php?ma_phieu_kiem_ke=${id}`);
        const result = await response.json();

        if (result.success) {
            renderDetailModal(result.data);
            openModal('detail-modal');
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error loading detail:', error);
        showToast('Lỗi tải chi tiết', 'error');
    }
}

function renderDetailModal(data) {
    const content = document.getElementById('detail-content');
    
    // Tính tổng chênh lệch
    const totalDiff = data.san_phams.reduce((sum, sp) => sum + sp.chenh_lech, 0);
    const diffProducts = data.san_phams.filter(sp => sp.chenh_lech !== 0).length;
    
    const productsHtml = data.san_phams.map(sp => `
        <tr>
            <td class="font-mono">${sp.ma_san_pham}</td>
            <td>${sp.ten_san_pham}</td>
            <td>${sp.danh_muc}</td>
            <td class="text-right">${sp.so_luong_he_thong}</td>
            <td class="text-right">${sp.so_luong_thuc_te}</td>
            <td class="text-right">
                ${sp.chenh_lech > 0 ? 
                    `<span class="difference-positive">+${sp.chenh_lech}</span>` : 
                    sp.chenh_lech < 0 ? 
                    `<span class="difference-negative">${sp.chenh_lech}</span>` : 
                    '0'}
            </td>
        </tr>
    `).join('');

    content.innerHTML = `
        <div class="space-y-6">
            <!-- Thông tin chung -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 p-4 rounded-lg">
                    <p class="text-xs text-slate-500">Mã phiếu</p>
                    <p class="text-lg font-semibold text-navy-800">${data.ma_phieu}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg">
                    <p class="text-xs text-slate-500">Kho</p>
                    <p class="text-lg font-semibold text-navy-800">${data.ten_kho}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg">
                    <p class="text-xs text-slate-500">Ngày tạo</p>
                    <p class="text-lg font-semibold text-navy-800">${formatDate(data.ngay_tao)}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg">
                    <p class="text-xs text-slate-500">Người tạo</p>
                    <p class="text-lg font-semibold text-navy-800">${data.nguoi_tao}</p>
                </div>
            </div>
            
            <!-- Thống kê nhanh -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-blue-600 mb-1">Tổng SP</p>
                    <p class="text-2xl font-bold text-blue-800">${data.san_phams.length}</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-orange-600 mb-1">SP chênh lệch</p>
                    <p class="text-2xl font-bold text-orange-800">${diffProducts}</p>
                </div>
                <div class="${totalDiff > 0 ? 'bg-green-50' : totalDiff < 0 ? 'bg-red-50' : 'bg-slate-50'} p-4 rounded-lg text-center">
                    <p class="text-sm ${totalDiff > 0 ? 'text-green-600' : totalDiff < 0 ? 'text-red-600' : 'text-slate-600'} mb-1">Tổng chênh lệch</p>
                    <p class="text-2xl font-bold ${totalDiff > 0 ? 'text-green-800' : totalDiff < 0 ? 'text-red-800' : 'text-slate-800'}">
                        ${totalDiff > 0 ? '+' : ''}${totalDiff}
                    </p>
                </div>
            </div>

            <!-- Bảng chi tiết sản phẩm -->
            <div>
                <h4 class="font-semibold text-navy-800 mb-3">Chi tiết sản phẩm</h4>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Mã SP</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th class="text-right">Hệ thống</th>
                                <th class="text-right">Thực tế</th>
                                <th class="text-right">Chênh lệch</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${productsHtml}
                        </tbody>
                        <tfoot class="bg-slate-50 font-semibold">
                            <tr>
                                <td colspan="3" class="text-right">Tổng cộng:</td>
                                <td class="text-right">${data.san_phams.reduce((sum, sp) => sum + sp.so_luong_he_thong, 0)}</td>
                                <td class="text-right">${data.san_phams.reduce((sum, sp) => sum + sp.so_luong_thuc_te, 0)}</td>
                                <td class="text-right ${totalDiff > 0 ? 'difference-positive' : totalDiff < 0 ? 'difference-negative' : ''}">
                                    ${totalDiff > 0 ? '+' : ''}${totalDiff}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <!-- Ghi chú nếu có -->
            ${data.ghi_chu ? `
                <div class="bg-slate-50 p-4 rounded-lg">
                    <p class="text-xs text-slate-500 mb-1">Ghi chú</p>
                    <p class="text-sm">${data.ghi_chu}</p>
                </div>
            ` : ''}
        </div>
    `;
}

        function renderDetailModal(data) {
            const content = document.getElementById('detail-content');
            
            const productsHtml = data.san_phams.map(sp => `
                <tr>
                    <td class="font-mono">${sp.ma_san_pham}</td>
                    <td>${sp.ten_san_pham}</td>
                    <td>${sp.danh_muc}</td>
                    <td class="text-right">${sp.so_luong_he_thong}</td>
                    <td class="text-right">${sp.so_luong_thuc_te}</td>
                    <td class="text-right">
                        ${sp.chenh_lech > 0 ? 
                            `<span class="difference-positive">+${sp.chenh_lech}</span>` : 
                            sp.chenh_lech < 0 ? 
                            `<span class="difference-negative">${sp.chenh_lech}</span>` : 
                            '0'}
                    </td>
                </tr>
            `).join('');

            content.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-3 rounded">
                            <p class="text-xs text-slate-500">Mã phiếu</p>
                            <p class="font-medium">${data.ma_phieu}</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded">
                            <p class="text-xs text-slate-500">Kho</p>
                            <p class="font-medium">${data.ten_kho}</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded">
                            <p class="text-xs text-slate-500">Ngày tạo</p>
                            <p class="font-medium">${formatDate(data.ngay_tao)}</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded">
                            <p class="text-xs text-slate-500">Người tạo</p>
                            <p class="font-medium">${data.nguoi_tao}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="audit-table">
                            <thead>
                                <tr>
                                    <th>Mã SP</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Hệ thống</th>
                                    <th>Thực tế</th>
                                    <th>Chênh lệch</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${productsHtml}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        // ==================== TIẾP TỤC KIỂM KÊ ====================
// ==================== TIẾP TỤC KIỂM KÊ ====================
async function continueAudit(id) {
    try {
        currentAuditId = id;
        showToast('Đang tải dữ liệu...', 'info');
        
        // Load chi tiết phiếu kiểm kê
        const response = await fetch(`../actions/KiemKeKho/lay_chi_tiet_phieu_kiem_ke.php?ma_phieu_kiem_ke=${id}`);
        const result = await response.json();

        if (result.success) {
            const data = result.data;
            
            // Set giá trị cho form
            document.getElementById('audit-code').value = data.ma_phieu;
            
            // Set kho
            const warehouseSelect = document.getElementById('warehouse-select');
            if (warehouseSelect) {
                warehouseSelect.value = data.ma_kho;
                
                // Load sản phẩm của kho
                await loadProductsByKhoForContinue(data.ma_kho, data.san_phams);
            }
            
            // Set ngày kiểm kê
            const auditDate = document.getElementById('audit-date');
            if (auditDate) {
                const date = new Date(data.ngay_tao);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                auditDate.value = `${year}-${month}-${day}`;
            }
            
            // Set ghi chú
            const auditNote = document.getElementById('audit-note');
            if (auditNote) {
                auditNote.value = data.ghi_chu || '';
            }
            
            // Hiển thị container sản phẩm
            document.getElementById('product-list-container').classList.remove('hidden');
            document.getElementById('no-warehouse-selected').classList.add('hidden');
            
            // Mở modal
            openModal('audit-modal');
            
            showToast('Đã tải dữ liệu kiểm kê', 'success');
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error continuing audit:', error);
        showToast('Lỗi tải dữ liệu kiểm kê', 'error');
    }
}

// Hàm load sản phẩm cho tiếp tục kiểm kê
async function loadProductsByKhoForContinue(maKho, existingProducts) {
    try {
        const response = await fetch(`../actions/KiemKeKho/lay_san_pham_theo_kho.php?ma_kho=${maKho}`);
        const result = await response.json();

        if (result.success) {
            renderProductTableForContinue(result.data, existingProducts);
            document.getElementById('total-products').textContent = result.data.length;
            return result.data;
        } else {
            showToast(result.message, 'error');
            return [];
        }
    } catch (error) {
        console.error('Error loading products:', error);
        showToast('Lỗi tải danh sách sản phẩm', 'error');
        return [];
    }
}

// Render bảng sản phẩm với dữ liệu cũ
function renderProductTableForContinue(products, existingProducts) {
    const tbody = document.getElementById('product-tbody');
    
    if (products.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-slate-500">Không có sản phẩm</td></tr>';
        return;
    }

    tbody.innerHTML = products.map(product => {
        // Tìm số lượng thực tế từ dữ liệu cũ
        const existing = existingProducts.find(ep => ep.ma_hang_hoa === product.ma_hang_hoa);
        const actualQty = existing ? existing.so_luong_thuc_te : product.ton_kho_he_thong;
        const diff = actualQty - product.ton_kho_he_thong;
        
        return `
        <tr data-id="${product.ma_hang_hoa}">
            <td class="font-mono">${product.ma_san_pham}</td>
            <td>${product.ten_san_pham}</td>
            <td>${product.danh_muc}</td>
            <td class="system-qty">${product.ton_kho_he_thong}</td>
            <td>
                <input type="number" class="product-input" value="${actualQty}" min="0" data-original="${product.ton_kho_he_thong}">
            </td>
            <td class="diff-cell">
                ${diff > 0 ? 
                    `<span class="difference-positive">+${diff}</span>` : 
                    diff < 0 ? 
                    `<span class="difference-negative">${diff}</span>` : 
                    '<span class="text-slate-600">0</span>'}
            </td>
        </tr>
    `}).join('');

    setupProductInputs();
    updateSummary();
}

        // ==================== EVENT LISTENERS ====================
        document.addEventListener('DOMContentLoaded', () => {
            // Load initial data
            loadKhoList();
            loadAuditList();

            // Set today's date for audit modal
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('audit-date').value = today;

            // Generate audit code
            const code = `KK${String(Date.now()).slice(-6)}`;
            document.getElementById('audit-code').value = code;

            // Create button
            document.getElementById('create-btn').addEventListener('click', () => {
                openModal('audit-modal');
            });

            // Filter buttons
            document.getElementById('apply-filter-btn').addEventListener('click', () => {
                currentPage = 1;
                loadAuditList();
            });


            document.getElementById('refresh-btn').addEventListener('click', () => {
                document.getElementById('filter-warehouse').value = '';
                document.getElementById('filter-status').value = '';
                document.getElementById('filter-from').value = '';
                document.getElementById('filter-to').value = '';
                currentPage = 1;
                loadAuditList();
                showToast('Đã làm mới bộ lọc', 'success');
            });

            // Warehouse select change in modal
            document.getElementById('warehouse-select').addEventListener('change', async function() {
                const maKho = this.value;
                if (maKho) {
                    document.getElementById('product-list-container').classList.remove('hidden');
                    document.getElementById('no-warehouse-selected').classList.add('hidden');
                    await loadProductsByKho(maKho);
                } else {
                    document.getElementById('product-list-container').classList.add('hidden');
                    document.getElementById('no-warehouse-selected').classList.remove('hidden');
                }
            });

            // Modal buttons
            document.getElementById('close-modal').addEventListener('click', () => closeModal('audit-modal'));
            document.getElementById('cancel-btn').addEventListener('click', () => closeModal('audit-modal'));
            document.getElementById('close-detail-modal').addEventListener('click', () => closeModal('detail-modal'));
            document.getElementById('cancel-delete-btn').addEventListener('click', () => closeModal('delete-modal'));

            // Save draft
            document.getElementById('save-draft-btn').addEventListener('click', createAudit);

            // Complete audit
            // Trong DOMContentLoaded, tìm dòng:
document.getElementById('complete-btn').addEventListener('click', completeAudit);
            document.getElementById('complete-btn').addEventListener('click', async () => {
                if (currentAuditId) {
                    await completeAudit(currentAuditId);
                } else {
                    showToast('Chưa có phiếu kiểm kê nào được chọn', 'error');
                }
            });

            // Confirm delete
            document.getElementById('confirm-delete-btn').addEventListener('click', () => {
                if (currentAuditId) {
                    deleteAudit(currentAuditId);
                }
            });

            // Close modals on overlay click
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.remove('active');
                        document.body.style.overflow = 'auto';
                    }
                });
            });

            // Close on escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                        modal.classList.remove('active');
                        document.body.style.overflow = 'auto';
                    });
                }
            });
        });

        // Element SDK
        if (window.elementSdk) {
            window.elementSdk.init({
                defaultConfig,
                onConfigChange: async (config) => {
                    document.getElementById('page-title').textContent = config.page_title || defaultConfig.page_title;
                    document.getElementById('page-description').textContent = config.page_description || defaultConfig.page_description;
                    document.getElementById('create-btn-text').textContent = config.create_session_btn || defaultConfig.create_session_btn;
                },
                mapToCapabilities: () => ({
                    recolorables: [],
                    borderables: [],
                    fontEditable: undefined,
                    fontSizeable: undefined
                }),
                mapToEditPanelValues: (config) => new Map([
                    ['page_title', config.page_title || defaultConfig.page_title],
                    ['page_description', config.page_description || defaultConfig.page_description],
                    ['create_session_btn', config.create_session_btn || defaultConfig.create_session_btn]
                ])
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>

<script>
  // 2. Cấu hình các tùy chọn cho nút bấm (Widget)
  const options = {
    bottom: '32px', // cách đáy
    right: '32px',  // cách phải
    left: 'unset', 
    time: '2.5s',   // thời gian chuyển màu
    mixColor: '#fff', 
    backgroundColor: '#fff',  
    buttonColorDark: '#100f2c', 
    buttonColorLight: '#fff',
    saveInCookies: true, // Thư viện có sẵn tính năng lưu vào Cookie
    label: '🌓', // Icon của nút
    autoMatchOsTheme: true // Tự động khớp với chế độ của máy tính
  }

  // 3. Khởi tạo
  const darkmode = new Darkmode(options);
  
  // Hiển thị cái nút tròn ở góc màn hình
  darkmode.showWidget();

  // 4. Mẹo nhỏ để ép nó hoạt động trên mọi trang:
  // Nếu Cookie không hoạt động tốt trên InfinityFree, ta dùng thêm LocalStorage
  window.addEventListener('load', () => {
    if (localStorage.getItem('darkmode') === 'true') {
      if (!darkmode.isActivated()) {
        darkmode.toggle();
      }
    }
  });

  // Lắng nghe lúc người dùng bấm vào cái nút tròn đó
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('darkmode-toggle')) {
        setTimeout(() => {
            localStorage.setItem('darkmode', darkmode.isActivated());
        }, 100);
    }
  });
</script>
</body>
</html>