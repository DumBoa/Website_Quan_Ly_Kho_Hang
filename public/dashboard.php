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
    <title>Dashboard WMS - Quản Lý Kho</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="/_sdk/element_sdk.js"></script>
    <link rel="stylesheet" href="../public/CSS/dashboard.css">
    
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
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
    </style>
</head>
<body class="h-full font-inter">
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
                <div class="mb-8 animate-fadeIn">
                    <nav class="flex items-center gap-2 text-sm mb-4">
                        <a href="#" class="text-slate-500 hover:text-navy-700 transition-colors">Trang chủ</a>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-navy-700 font-medium">Dashboard</span>
                    </nav>
                    <h1 id="page-title" class="text-4xl font-bold text-navy-800 mb-2">TỔNG QUAN HỆ THỐNG KHO</h1>
                    <p id="page-description" class="text-slate-600">Theo dõi tình trạng hoạt động của hệ thống kho hàng theo thời gian thực.</p>
                </div>

                <!-- 6 Key Metrics Cards -->
                <div class="stats-grid mb-8">
                    <div class="stat-card animate-fadeIn" style="animation-delay: 0.05s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stat-card-icon blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <span class="stat-card-change up" id="product-change">+8%</span>
                        </div>
                        <p class="stat-card-label">Tổng sản phẩm</p>
                        <p class="stat-card-value" id="total-products">0</p>
                        <p class="text-xs text-slate-500 mt-2" id="product-growth">+120 trong 7 ngày</p>
                    </div>

                    <div class="stat-card animate-fadeIn" style="animation-delay: 0.1s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stat-card-icon green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="stat-card-change up" id="inventory-change">+5.2%</span>
                        </div>
                        <p class="stat-card-label">Tổng tồn kho</p>
                        <p class="stat-card-value" id="total-inventory">0</p>
                        <p class="text-xs text-slate-500 mt-2" id="inventory-today">+3,200 hôm nay</p>
                    </div>

                    <div class="stat-card animate-fadeIn" style="animation-delay: 0.15s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stat-card-icon orange">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="stat-card-change" id="warehouse-badge">Tất cả</span>
                        </div>
                        <p class="stat-card-label">Tổng số kho</p>
                        <p class="stat-card-value" id="total-warehouses">0</p>
                        <p class="text-xs text-slate-500 mt-2" id="warehouse-status">Đang hoạt động</p>
                    </div>

                    <div class="stat-card animate-fadeIn" style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stat-card-icon purple">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="stat-card-change up" id="supplier-change">+2</span>
                        </div>
                        <p class="stat-card-label">Nhà cung cấp</p>
                        <p class="stat-card-value" id="total-suppliers">0</p>
                        <p class="text-xs text-slate-500 mt-2" id="supplier-month">Tháng này</p>
                    </div>

                    <div class="stat-card animate-fadeIn" style="animation-delay: 0.25s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stat-card-icon" style="background: #fee2e2;">
                                <svg class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="stat-card-change" id="import-badge">Hôm nay</span>
                        </div>
                        <p class="stat-card-label">Phiếu nhập</p>
                        <p class="stat-card-value" id="today-imports">0</p>
                        <p class="text-xs text-slate-500 mt-2" id="pending-imports">Đang chờ: 0</p>
                    </div>

                    <div class="stat-card animate-fadeIn" style="animation-delay: 0.3s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stat-card-icon" style="background: #cffafe;">
                                <svg class="w-6 h-6 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <span class="stat-card-change" id="export-badge">Hôm nay</span>
                        </div>
                        <p class="stat-card-label">Phiếu xuất</p>
                        <p class="stat-card-value" id="today-exports">0</p>
                        <p class="text-xs text-slate-500 mt-2" id="shipping-exports">Đang giao: 0</p>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="content-grid mb-8">
                    <!-- Activity Chart -->
                    <div class="content-card p-6 animate-fadeIn" style="animation-delay: 0.35s">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="content-card-title flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Hoạt động nhập - xuất kho (7 ngày qua)
                            </h3>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1 text-xs text-white bg-navy-700 rounded hover:bg-navy-800 transition-colors">Tuần</button>
                                <button class="px-3 py-1 text-xs text-slate-600 bg-slate-100 rounded hover:bg-slate-200 transition-colors">Tháng</button>
                            </div>
                        </div>
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>

                    <!-- Category Distribution -->
                    <div class="content-card p-6 animate-fadeIn" style="animation-delay: 0.4s">
                        <h3 class="content-card-title mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Phân bố theo danh mục
                        </h3>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tables Row -->
                <div class="content-grid mb-8">
                    <!-- Recent Imports Table -->
                    <div class="content-card overflow-hidden animate-fadeIn" style="animation-delay: 0.45s">
                        <div class="content-card-header">
                            <h3 class="content-card-title flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 0a3 3 0 110-6 3 3 0 010 6z" />
                                </svg>
                                Phiếu nhập mới nhất
                            </h3>
                            <a href="/Project_QuanLyKhoHang/public/phieunhap.php" class="content-card-action">Xem tất cả</a>
                        </div>
                        <div class="content-card-body p-0">
                            <div class="divide-y divide-slate-100" id="recent-imports">
                                <!-- Data will be loaded by JS -->
                                <div class="p-4 text-center text-slate-500">Đang tải dữ liệu...</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Exports Table -->
                    <div class="content-card overflow-hidden animate-fadeIn" style="animation-delay: 0.5s">
                        <div class="content-card-header">
                            <h3 class="content-card-title flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 0a3 3 0 110-6 3 3 0 010 6z" />
                                </svg>
                                Phiếu xuất mới nhất
                            </h3>
                            <a href="/Project_QuanLyKhoHang/public/phieuxuat.php" class="content-card-action">Xem tất cả</a>
                        </div>
                        <div class="content-card-body p-0">
                            <div class="divide-y divide-slate-100" id="recent-exports">
                                <!-- Data will be loaded by JS -->
                                <div class="p-4 text-center text-slate-500">Đang tải dữ liệu...</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="content-card overflow-hidden animate-fadeIn" style="animation-delay: 0.55s">
                    <div class="content-card-header bg-red-50">
                        <h3 class="content-card-title flex items-center gap-2 text-red-900">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M8.228 8.228a7 7 0 110 9.944M5.586 5.586a9 9 0 0112.828 0m-17.072 0a11 11 0 0115.656 0" />
                            </svg>
                            Cảnh báo tồn kho thấp
                        </h3>
                    </div>
                    <div class="content-card-body p-0">
                        <div class="divide-y divide-slate-100" id="low-stock-items">
                            <!-- Data will be loaded by JS -->
                            <div class="p-4 text-center text-slate-500">Đang tải dữ liệu...</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card p-6 mt-6 animate-fadeIn" style="animation-delay: 0.6s">
                    <h3 class="content-card-title mb-5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Thao tác nhanh
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        <button onclick="window.location.href='/Project_QuanLyKhoHang/public/phieunhap.php'" 
                                class="px-4 py-3 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 transition-all text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tạo phiếu nhập
                        </button>
                        <button onclick="window.location.href='/Project_QuanLyKhoHang/public/phieuxuat.php'"
                                class="px-4 py-3 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 transition-all text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tạo phiếu xuất
                        </button>
                        <button onclick="window.location.href='/Project_QuanLyKhoHang/public/quanlysanpham.php'"
                                class="px-4 py-3 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 transition-all text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Thêm sản phẩm
                        </button>
                        <button onclick="window.location.href='/Project_QuanLyKhoHang/public/tonkho.php'"
                                class="px-4 py-3 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 transition-all text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            </svg>
                            Xem tồn kho
                        </button>
                        <button onclick="window.location.href='/Project_QuanLyKhoHang/public/baocaothongke.php'"
                                class="px-4 py-3 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 transition-all text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Xem báo cáo
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-navy-800 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-slideIn">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-message">Thao tác thành công!</span>
        </div>
    </div>

    <script>
        // ==================== CẤU HÌNH ====================
        const currentUser = {
            ma_nguoi_dung: <?php echo json_encode($ma_nguoi_dung ?? 0); ?>,
            ho_ten: <?php echo json_encode($ten ?? ''); ?>,
            vai_tro: <?php echo json_encode($role ?? ''); ?>
        };

        const defaultConfig = {
            page_title: 'TỔNG QUAN HỆ THỐNG KHO',
            page_description: 'Theo dõi tình trạng hoạt động của hệ thống kho hàng theo thời gian thực.'
        };

        // ==================== BIẾN TOÀN CỤC ====================
        let activityChart = null;
        let categoryChart = null;

        // ==================== API CALLS ====================
        async function loadDashboardData() {
            try {
                // Lấy thống kê tổng quan
                const statsResponse = await fetch('../actions/BangDieuKhien/lay_thong_ke_tong_quan.php');
                const statsResult = await statsResponse.json();
                
                if (statsResult.success) {
                    updateStatsCards(statsResult.data);
                }

                // Lấy hoạt động 7 ngày gần nhất
                const activityResponse = await fetch('../actions/BangDieuKhien/lay_hoat_dong_7_ngay.php');
                const activityResult = await activityResponse.json();
                
                if (activityResult.success) {
                    renderActivityChart(activityResult.data);
                }

                // Lấy phân bố danh mục
                const categoryResponse = await fetch('../actions/BangDieuKhien/lay_phan_bo_danh_muc.php');
                const categoryResult = await categoryResponse.json();
                
                if (categoryResult.success) {
                    renderCategoryChart(categoryResult.data);
                }

                // Lấy phiếu nhập gần đây
                const importsResponse = await fetch('../actions/BangDieuKhien/lay_phieu_nhap_gan_day.php');
                const importsResult = await importsResponse.json();
                
                if (importsResult.success) {
                    renderRecentImports(importsResult.data);
                }

                // Lấy phiếu xuất gần đây
                const exportsResponse = await fetch('../actions/BangDieuKhien/lay_phieu_xuat_gan_day.php');
                const exportsResult = await exportsResponse.json();
                
                if (exportsResult.success) {
                    renderRecentExports(exportsResult.data);
                }

                // Lấy sản phẩm sắp hết hàng
                const lowStockResponse = await fetch('../actions/BangDieuKhien/lay_san_pham_sap_het.php');
                const lowStockResult = await lowStockResponse.json();
                
                if (lowStockResult.success) {
                    renderLowStockItems(lowStockResult.data);
                }

            } catch (error) {
                console.error('Error loading dashboard data:', error);
                showToast('Lỗi tải dữ liệu dashboard', 'error');
            }
        }

        function updateStatsCards(data) {
            // Cập nhật các thẻ thống kê
            document.getElementById('total-products').textContent = formatNumber(data.tong_san_pham || 0);
            document.getElementById('total-inventory').textContent = formatNumber(data.tong_ton_kho || 0);
            document.getElementById('total-warehouses').textContent = data.tong_kho || 0;
            document.getElementById('total-suppliers').textContent = data.tong_nha_cung_cap || 0;
            document.getElementById('today-imports').textContent = data.phieu_nhap_hom_nay || 0;
            document.getElementById('today-exports').textContent = data.phieu_xuat_hom_nay || 0;

            // Cập nhật thông tin phụ
            document.getElementById('pending-imports').textContent = `Đang chờ: ${data.phieu_nhap_cho_duyet || 0}`;
            document.getElementById('shipping-exports').textContent = `Đang giao: ${data.phieu_xuat_dang_giao || 0}`;
            document.getElementById('product-growth').textContent = `+${data.san_pham_moi_7_ngay || 0} trong 7 ngày`;
            
            // Cập nhật badge
            document.getElementById('product-change').innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg> +${data.tang_truong_san_pham || 0}%`;
        }

        function renderActivityChart(data) {
            const ctx = document.getElementById('activityChart')?.getContext('2d');
            if (!ctx) return;

            if (activityChart) activityChart.destroy();

            activityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels || ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                    datasets: [
                        {
                            label: 'Nhập kho',
                            data: data.imports || [0, 0, 0, 0, 0, 0, 0],
                            backgroundColor: '#3b82f6',
                            borderRadius: 6
                        },
                        {
                            label: 'Xuất kho',
                            data: data.exports || [0, 0, 0, 0, 0, 0, 0],
                            backgroundColor: '#10b981',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }

        function renderCategoryChart(data) {
            const ctx = document.getElementById('categoryChart')?.getContext('2d');
            if (!ctx) return;

            if (categoryChart) categoryChart.destroy();

            categoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels || ['Điện tử', 'Linh kiện', 'Văn phòng', 'Khác'],
                    datasets: [{
                        data: data.values || [0, 0, 0, 0],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#6b7280'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${formatNumber(value)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        function renderRecentImports(data) {
            const container = document.getElementById('recent-imports');
            if (!data || data.length === 0) {
                container.innerHTML = '<div class="p-4 text-center text-slate-500">Không có dữ liệu</div>';
                return;
            }

            container.innerHTML = data.map(item => `
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono text-sm text-blue-600 font-medium">${item.ma_phieu}</span>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getStatusClass(item.trang_thai)}">
                            ${getStatusText(item.trang_thai)}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 mb-1">${item.nha_cung_cap} • ${item.tong_so_luong} sản phẩm</p>
                    <p class="text-xs text-slate-500">${item.ngay_tao}</p>
                </div>
            `).join('');
        }

        function renderRecentExports(data) {
            const container = document.getElementById('recent-exports');
            if (!data || data.length === 0) {
                container.innerHTML = '<div class="p-4 text-center text-slate-500">Không có dữ liệu</div>';
                return;
            }

            container.innerHTML = data.map(item => `
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono text-sm text-blue-600 font-medium">${item.ma_phieu}</span>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getStatusClass(item.trang_thai)}">
                            ${getStatusText(item.trang_thai)}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 mb-1">${item.kho} • ${item.tong_so_luong} sản phẩm</p>
                    <p class="text-xs text-slate-500">${item.ngay_tao}</p>
                </div>
            `).join('');
        }

        function renderLowStockItems(data) {
    const container = document.getElementById('low-stock-items');
    if (!container) return;

    console.log('Low stock data:', data); // Debug

    if (!data || data.length === 0) {
        container.innerHTML = '<div class="p-4 text-center text-slate-500">Không có sản phẩm nào sắp hết hàng</div>';
        return;
    }

    container.innerHTML = data.map(item => {
        const level = getStockLevel(item.so_luong, item.ton_toi_thieu);
        return `
            <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                <div>
                    <p class="font-semibold text-navy-800 text-sm">${item.ma_san_pham} - ${item.ten_san_pham}</p>
                    <p class="text-xs text-slate-600 mt-1">Tồn kho: <span class="${level.color} font-medium">${item.so_luong}</span> • Mức cảnh báo: ${item.ton_toi_thieu}</p>
                </div>
                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full ${level.badge}">
                    ${level.text}
                </span>
            </div>
        `;
    }).join('');
}

        function getStatusClass(status) {
            switch(status) {
                case 0: return 'bg-yellow-100 text-yellow-700'; // Chờ duyệt
                case 1: return 'bg-green-100 text-green-700';   // Đã duyệt
                case 2: return 'bg-red-100 text-red-700';       // Từ chối
                default: return 'bg-slate-100 text-slate-700';
            }
        }

        function getStatusText(status) {
            switch(status) {
                case 0: return 'Chờ duyệt';
                case 1: return 'Đã duyệt';
                case 2: return 'Từ chối';
                default: return 'Không xác định';
            }
        }

        function getStockLevel(quantity, minStock) {
    if (quantity <= 0) {
        return { 
            level: 'out', 
            color: 'text-red-600', 
            badge: 'bg-red-100 text-red-700', 
            text: 'Hết hàng' 
        };
    } else if (quantity <= minStock * 0.5) {
        return { 
            level: 'critical', 
            color: 'text-red-600', 
            badge: 'bg-red-100 text-red-700', 
            text: 'Nguy cấp' 
        };
    } else if (quantity <= minStock) {
        return { 
            level: 'low', 
            color: 'text-orange-600', 
            badge: 'bg-orange-100 text-orange-700', 
            text: 'Sắp hết' 
        };
    } else if (quantity <= minStock * 2) {
        return { 
            level: 'medium', 
            color: 'text-yellow-600', 
            badge: 'bg-yellow-100 text-yellow-700', 
            text: 'Trung bình' 
        };
    } else {
        return { 
            level: 'normal', 
            color: 'text-green-600', 
            badge: 'bg-green-100 text-green-700', 
            text: 'Bình thường' 
        };
    }
}

        function formatNumber(value) {
            return new Intl.NumberFormat('vi-VN').format(value);
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.querySelector('div').className = 
                `${type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'} 
                 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-slideIn`;
            
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // ==================== SIDEBAR & DROPDOWN TOGGLE ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Load dữ liệu dashboard
            loadDashboardData();

            // Sidebar elements
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const userDropdown = document.getElementById('userDropdown');
            const userTrigger = document.getElementById('userTrigger');
            
            let isSidebarCollapsed = false;
            let isMobile = window.innerWidth <= 768;
            
            if (sidebar && sidebarToggle) {
                function toggleSidebar() {
                    if (isMobile) {
                        if (mobileOverlay) {
                            sidebar.classList.toggle('mobile-open');
                            mobileOverlay.classList.toggle('active');
                        }
                    } else {
                        isSidebarCollapsed = !isSidebarCollapsed;
                        sidebar.classList.toggle('collapsed', isSidebarCollapsed);
                    }
                }
                
                function closeMobileSidebar() {
                    if (sidebar && mobileOverlay) {
                        sidebar.classList.remove('mobile-open');
                        mobileOverlay.classList.remove('active');
                    }
                }
                
                function toggleUserDropdown(e) {
                    e.stopPropagation();
                    if (userDropdown) {
                        userDropdown.classList.toggle('open');
                    }
                }
                
                function closeUserDropdown() {
                    if (userDropdown) {
                        userDropdown.classList.remove('open');
                    }
                }
                
                function handleResize() {
                    const wasMobile = isMobile;
                    isMobile = window.innerWidth <= 768;
                    
                    if (wasMobile !== isMobile) {
                        if (sidebar) {
                            sidebar.classList.remove('collapsed', 'mobile-open');
                        }
                        if (mobileOverlay) {
                            mobileOverlay.classList.remove('active');
                        }
                        isSidebarCollapsed = false;
                    }
                }
                
                sidebarToggle.addEventListener('click', toggleSidebar);
                
                if (mobileOverlay) {
                    mobileOverlay.addEventListener('click', closeMobileSidebar);
                }
                
                if (userTrigger) {
                    userTrigger.addEventListener('click', toggleUserDropdown);
                }
                
                document.addEventListener('click', (e) => {
                    if (userDropdown && !userDropdown.contains(e.target) && userTrigger && !userTrigger.contains(e.target)) {
                        closeUserDropdown();
                    }
                });
                
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        closeUserDropdown();
                        if (isMobile) {
                            closeMobileSidebar();
                        }
                    }
                });
                
                window.addEventListener('resize', handleResize);
                handleResize();
            }
        });

        // Element SDK
        if (window.elementSdk) {
            window.elementSdk.init({
                defaultConfig,
                onConfigChange: async (config) => {
                    document.getElementById('page-title').textContent = config.page_title || defaultConfig.page_title;
                    document.getElementById('page-description').textContent = config.page_description || defaultConfig.page_description;
                },
                mapToCapabilities: () => ({
                    recolorables: [],
                    borderables: [],
                    fontEditable: undefined,
                    fontSizeable: undefined
                }),
                mapToEditPanelValues: (config) => new Map([
                    ['page_title', config.page_title || defaultConfig.page_title],
                    ['page_description', config.page_description || defaultConfig.page_description]
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