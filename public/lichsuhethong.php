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
  <title>Lịch Sử Hệ Thống - Quản Lý Kho</title>
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
    /* Các style bổ sung */
    .table-row:hover {
      background: #f8fafc;
    }

    .status-success {
      background: #dcfce7;
      color: #166534;
    }

    .status-failed {
      background: #fee2e2;
      color: #991b1b;
    }

    .status-warning {
      background: #fef3c7;
      color: #92400e;
    }

    .timeline-item::before {
      content: '';
      position: absolute;
      left: 11px;
      top: 28px;
      bottom: -12px;
      width: 2px;
      background: #e2e8f0;
    }

    .timeline-item:last-child::before {
      display: none;
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

    @keyframes slideIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    .animate-slideIn {
      animation: slideIn 0.2s ease-out;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }

    .badge-success {
      background: #d1fae5;
      color: #059669;
    }

    .badge-failed {
      background: #fee2e2;
      color: #dc2626;
    }

    .badge-warning {
      background: #fef3c7;
      color: #d97706;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      border: none;
    }

    .btn-primary {
      background: #102a43;
      color: white;
    }

    .btn-primary:hover {
      background: #243b53;
    }

    .btn-outline {
      background: white;
      color: #475569;
      border: 1px solid #e2e8f0;
    }

    .btn-outline:hover {
      background: #f8fafc;
      border-color: #cbd5e1;
    }
     /* ========================================
   SIDEBAR TOGGLE COMPATIBILITY
   ======================================== */

/* Sidebar cơ bản (đảm bảo khớp với dashboard.css) */
.wms-sidebar {
  width: var(--sidebar-width, 260px);
  transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  z-index: 100;
}

.wms-sidebar.collapsed {
  width: var(--sidebar-collapsed-width, 72px);
}

/* Main content dịch chuyển theo sidebar */
.main-content {
  margin-left: 260px;                    /* giá trị mặc định khi sidebar mở */
  transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  min-height: 100vh;
}

/* Khi sidebar collapsed */
.wms-sidebar.collapsed + .main-content,
.wms-sidebar.collapsed ~ .main-content {
  margin-left: 72px;                     /* giá trị khi sidebar thu gọn */
}

/* Đảm bảo topbar/header không bị che */
.topbar, .header {
  margin-left: 260px;
  transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: sticky;
  top: 0;
  z-index: 90;
  background: white;
}

.wms-sidebar.collapsed ~ .topbar,
.wms-sidebar.collapsed ~ .header {
  margin-left: 72px;
}
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
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
      <main class="wms-content">
        <!-- Breadcrumb & Title -->
        <div class="mb-6 animate-fadeIn">
          <nav class="flex items-center gap-2 text-sm mb-3">
            <a href="#" class="text-slate-500 hover:text-navy-700 transition-colors">Trang chủ</a>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="#" class="text-slate-500 hover:text-navy-700 transition-colors">Hệ thống</a>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-navy-700 font-medium">Lịch sử hệ thống</span>
          </nav>
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h1 id="page-title" class="text-2xl font-bold text-navy-800">LỊCH SỬ HOẠT ĐỘNG HỆ THỐNG</h1>
              <p id="page-description" class="text-slate-500 mt-1">Theo dõi và truy vết toàn bộ hoạt động người dùng trong hệ thống quản lý kho.</p>
            </div>
            <!-- Export Buttons -->
            <div class="flex items-center gap-2">
              <button onclick="exportData('excel')" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg> Excel
              </button>
              <button onclick="exportData('csv')" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg> CSV
              </button>
              <button onclick="exportData('pdf')" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg> PDF
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="content-card p-5 animate-fadeIn" style="animation-delay: 0.1s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 mb-1">Hoạt động hôm nay</p>
                <p class="text-2xl font-bold text-navy-800" id="stat-today">0</p>
                <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg> So với hôm qua
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-card p-5 animate-fadeIn" style="animation-delay: 0.15s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 mb-1">Lượt đăng nhập</p>
                <p class="text-2xl font-bold text-navy-800" id="stat-login">0</p>
                <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg> So với hôm qua
                </p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-card p-5 animate-fadeIn" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 mb-1">Tạo phiếu mới</p>
                <p class="text-2xl font-bold text-navy-800" id="stat-import">0</p>
                <p class="text-xs text-amber-600 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg> Tương đương hôm qua
                </p>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="content-card p-5 animate-fadeIn" style="animation-delay: 0.25s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 mb-1">Chỉnh sửa dữ liệu</p>
                <p class="text-2xl font-bold text-navy-800" id="stat-edit">0</p>
                <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg> So với hôm qua
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
        </div>
    </div>
</div>

        <!-- Filter Card -->
        <div class="content-card p-5 mb-6 animate-fadeIn" style="animation-delay: 0.3s">
          <h3 class="text-sm font-semibold text-navy-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg> Bộ lọc dữ liệu
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Người dùng</label>
              <select id="filter-user" class="form-input">
                <option value="">Tất cả người dùng</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Vai trò</label>
              <select id="filter-role" class="form-input">
                <option value="">Tất cả vai trò</option>
                <option value="ADMIN">Admin</option>
                <option value="QUAN_LY">Quản lý</option>
                <option value="THU_KHO">Thủ kho</option>
                <option value="NHAN_VIEN">Nhân viên</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Loại hoạt động</label>
              <select id="filter-action" class="form-input">
                <option value="">Tất cả hoạt động</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Trạng thái</label>
              <select id="filter-status" class="form-input">
                <option value="">Tất cả trạng thái</option>
                <option value="success">Thành công</option>
                <option value="failed">Thất bại</option>
                <option value="warning">Cảnh báo</option>
              </select>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Từ ngày</label>
              <input type="date" id="filter-from" class="form-input">
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Đến ngày</label>
              <input type="date" id="filter-to" class="form-input">
            </div>
            <div class="lg:col-span-2">
              <label class="block text-xs font-medium text-slate-600 mb-1.5">Tìm kiếm nhanh</label>
              <div class="relative">
                <input type="text" id="search-input" placeholder="Tìm theo tên, mã phiếu, sản phẩm, hành động..." class="form-input pl-10">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          <div class="flex items-center gap-3">
    <button id="apply-filter-btn" class="btn btn-primary flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg> Lọc dữ liệu
    </button>
    <button id="reset-filter-btn" class="btn btn-outline flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg> Reset
    </button>
</div>
        </div>

        <!-- Main Content Area với 2 cột -->
        <div class="flex flex-col xl:flex-row gap-6">
          <!-- Bảng lịch sử -->
          <div class="flex-1">
            <div class="content-card overflow-hidden animate-fadeIn" style="animation-delay: 0.35s">
              <div class="content-card-header">
                <h3 class="content-card-title flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg> Bảng lịch sử hoạt động
                </h3>
                <span id="total-records" class="text-xs text-slate-500 bg-slate-100 px-3 py-1 rounded-full">Tổng: 0 bản ghi</span>
              </div>
              <div class="content-card-body p-0">
                <div class="overflow-x-auto">
                  <table class="w-full">
                    <thead class="bg-slate-50">
                      <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Thời gian</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Người dùng</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Vai trò</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Hành động</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Đối tượng</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Chi tiết</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">IP</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Thao tác</th>
                      </tr>
                    </thead>
                    <tbody id="log-table-body" class="divide-y divide-slate-100">
                      <!-- Rows will be inserted by JS -->
                    </tbody>
                  </table>
                </div>
                <!-- Pagination -->
                <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                  <div class="text-sm text-slate-500">
                    Hiển thị <span class="font-medium text-slate-700" id="pagination-start">0</span>-<span class="font-medium text-slate-700" id="pagination-end">0</span> 
                    trong <span class="font-medium text-slate-700" id="pagination-total">0</span> bản ghi
                  </div>
                  <div class="flex items-center gap-1" id="pagination-controls">
                    <!-- Pagination buttons will be rendered here -->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Timeline Sidebar -->
          <div class="xl:w-80 flex-shrink-0">
            <div class="content-card p-5 sticky top-6 animate-fadeIn" style="animation-delay: 0.4s">
              <h3 class="text-sm font-semibold text-navy-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg> Hoạt động gần đây
              </h3>
              <div id="activity-timeline" class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar pr-2">
                <!-- Timeline items will be inserted by JS -->
              </div>
              <button class="w-full mt-4 py-2 text-sm text-navy-700 font-medium bg-navy-50 rounded-md hover:bg-navy-100 transition-colors">
                Xem tất cả hoạt động
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Detail Modal -->
  <div id="detail-modal" class="fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute inset-0" onclick="closeModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
      <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90%] overflow-hidden pointer-events-auto animate-slideIn">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-navy-700">
          <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg> Chi tiết hoạt động
          </h3>
          <button onclick="closeModal()" class="text-white hover:text-slate-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div id="modal-content" class="p-6 overflow-y-auto custom-scrollbar" style="max-height: calc(90vh - 80px);">
          <!-- Modal content will be inserted by JS -->
        </div>
      </div>
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
        page_title: 'LỊCH SỬ HOẠT ĐỘNG HỆ THỐNG',
        page_description: 'Theo dõi và truy vết toàn bộ hoạt động người dùng trong hệ thống quản lý kho.'
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let allLogs = [];
    let filteredLogs = [];
    let users = [];
    let actions = [];
    let currentPage = 1;
    const itemsPerPage = 10;

    // ==================== UTILITY FUNCTIONS ====================
    function formatDateTime(dateTimeStr) {
        if (!dateTimeStr) return '-';
        const date = new Date(dateTimeStr);
        const time = date.toLocaleTimeString('vi-VN');
        const dateStr = date.toLocaleDateString('vi-VN');
        return { time, date: dateStr };
    }

    function getRoleBadgeClass(role) {
        const classes = {
            'ADMIN': 'bg-red-100 text-red-700',
            'QUAN_LY': 'bg-blue-100 text-blue-700',
            'THU_KHO': 'bg-green-100 text-green-700',
            'NHAN_VIEN': 'bg-purple-100 text-purple-700'
        };
        return classes[role] || 'bg-slate-100 text-slate-700';
    }

    function getStatusClass(status) {
        const classes = {
            'success': 'badge-success',
            'failed': 'badge-failed',
            'warning': 'badge-warning'
        };
        return classes[status] || 'bg-slate-100 text-slate-700';
    }

    function getStatusText(status) {
        const texts = {
            'success': 'Thành công',
            'failed': 'Thất bại',
            'warning': 'Cảnh báo'
        };
        return texts[status] || status;
    }

    function getActionIcon(action) {
        const icons = {
            'Đăng nhập': '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>',
            'Đăng xuất': '<svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>',
            'Tạo phiếu nhập': '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>',
            'Duyệt phiếu nhập': '<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
            'Tạo phiếu xuất': '<svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>',
            'Duyệt phiếu xuất': '<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
            'Thêm sản phẩm': '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>',
            'Sửa sản phẩm': '<svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
            'Xóa sản phẩm': '<svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>',
            'Cập nhật kho': '<svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>',
            'Kiểm kê kho': '<svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
            'Thay đổi quyền': '<svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'
        };
        return icons[action] || '<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        toastMessage.textContent = message;
        
        // Set màu sắc theo type
        const bgColor = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600';
        toast.querySelector('div').className = `${bgColor} text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-slideIn`;
        
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

    // ==================== API CALLS ====================
    async function loadLogList() {
    try {
        // Kiểm tra các element cần thiết
        const search = document.getElementById('search-input')?.value || '';
        const ma_nguoi_dung = document.getElementById('filter-user')?.value || '';
        const hanh_dong = document.getElementById('filter-action')?.value || '';
        const trang_thai = document.getElementById('filter-status')?.value || '';
        const tu_ngay = document.getElementById('filter-from')?.value || '';
        const den_ngay = document.getElementById('filter-to')?.value || '';

        let url = '../actions/LichSuHeThong/lay_danh_sach.php?';
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (ma_nguoi_dung) params.append('ma_nguoi_dung', ma_nguoi_dung);
        if (hanh_dong) params.append('hanh_dong', hanh_dong);
        if (trang_thai) params.append('trang_thai', trang_thai);
        if (tu_ngay) params.append('tu_ngay', tu_ngay);
        if (den_ngay) params.append('den_ngay', den_ngay);
        
        const response = await fetch(url + params.toString());
        const result = await response.json();

        if (result.success) {
            allLogs = result.data;
            filteredLogs = [...allLogs];
            renderLogTable();
            
            // Kiểm tra stats có tồn tại không trước khi update
            if (result.counts) {
                updateStats(result.counts);
            } else if (result.stats) {
                updateStats(result.stats);
            }
            
            const totalRecords = document.getElementById('total-records');
            if (totalRecords) {
                totalRecords.textContent = `Tổng: ${allLogs.length.toLocaleString()} bản ghi`;
            }
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error loading logs:', error);
        showToast('Lỗi tải lịch sử hệ thống', 'error');
    }
}

    async function loadUsers() {
        try {
            const response = await fetch('../actions/LichSuHeThong/lay_danh_sach_nguoi_dung.php');
            const result = await response.json();

            if (result.success) {
                users = result.data;
                renderUserOptions();
            }
        } catch (error) {
            console.error('Error loading users:', error);
        }
    }

    async function loadActions() {
        try {
            const response = await fetch('../actions/LichSuHeThong/lay_danh_sach_hanh_dong.php');
            const result = await response.json();

            if (result.success) {
                actions = result.data;
                renderActionOptions();
            }
        } catch (error) {
            console.error('Error loading actions:', error);
        }
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderUserOptions() {
        const select = document.getElementById('filter-user');
        const options = users.map(u => 
            `<option value="${u.ma_nguoi_dung}">${u.ho_ten} (${u.ten_dang_nhap})</option>`
        ).join('');
        select.innerHTML = '<option value="">Tất cả người dùng</option>' + options;
    }

    function renderActionOptions() {
        const select = document.getElementById('filter-action');
        const options = actions.map(a => 
            `<option value="${a.value}">${a.label}</option>`
        ).join('');
        select.innerHTML = '<option value="">Tất cả hoạt động</option>' + options;
    }

    function renderLogTable() {
        const tbody = document.getElementById('log-table-body');
        
        if (filteredLogs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center py-10 text-gray-500">Không có dữ liệu lịch sử</td></tr>';
            return;
        }

        // Tính phân trang
        const start = (currentPage - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, filteredLogs.length);
        const paginatedData = filteredLogs.slice(start, end);

        tbody.innerHTML = paginatedData.map(log => {
            const datetime = formatDateTime(log.thoi_gian);
            return `
            <tr class="table-row transition-colors hover:bg-slate-50">
                <td class="px-4 py-3">
                    <div class="text-sm font-medium text-slate-800">${datetime.time}</div>
                    <div class="text-xs text-slate-500">${datetime.date}</div>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-navy-100 rounded-full flex items-center justify-center text-navy-700 font-medium text-xs">
                            ${log.nguoi_dung ? log.nguoi_dung.split(' ').map(n => n[0]).join('').slice(0, 2) : '??'}
                        </div>
                        <span class="text-sm text-slate-700">${log.nguoi_dung}</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getRoleBadgeClass(log.vai_tro)}">
                        ${log.vai_tro || 'Không xác định'}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-700 flex items-center gap-1.5">
                        ${getActionIcon(log.hanh_dong)}
                        ${log.hanh_dong}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm font-mono text-blue-600">${log.ma_doi_tuong || ''}</span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-600 max-w-xs truncate block">${log.chi_tiet || ''}</span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-xs font-mono text-slate-500">${log.ip || ''}</span>
                </td>
                <td class="px-4 py-3">
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getStatusClass(log.trang_thai)}">
                        ${getStatusText(log.trang_thai)}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <button onclick="viewDetail(${log.ma_lich_su})" class="px-3 py-1.5 text-xs font-medium text-navy-700 bg-navy-50 rounded-md hover:bg-navy-100 transition-colors">
                        Xem
                    </button>
                </td>
            </tr>
        `}).join('');

        updatePagination();
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredLogs.length / itemsPerPage);
        const start = (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, filteredLogs.length);

        document.querySelector('.flex.flex-col.sm\\:flex-row.items-center.justify-between.gap-4 .text-sm span:first-child').textContent = filteredLogs.length > 0 ? start : 0;
        document.querySelector('.flex.flex-col.sm\\:flex-row.items-center.justify-between.gap-4 .text-sm span:nth-child(2)').textContent = end;
        document.querySelector('.flex.flex-col.sm\\:flex-row.items-center.justify-between.gap-4 .text-sm span:last-child').textContent = filteredLogs.length;

        // Render các nút phân trang
        const paginationDiv = document.querySelector('.flex.items-center.gap-1');
        if (!paginationDiv) return;

        let paginationHtml = `<button onclick="changePage('prev')" class="px-3 py-1.5 text-sm text-slate-600 bg-slate-100 rounded-md hover:bg-slate-200 transition-colors ${currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>`;

        // Hiển thị tối đa 5 nút số trang
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        if (startPage > 1) {
            paginationHtml += `<button onclick="changePage(1)" class="px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-100 rounded-md transition-colors">1</button>`;
            if (startPage > 2) {
                paginationHtml += `<span class="px-2 text-slate-400">...</span>`;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `<button onclick="changePage(${i})" class="px-3 py-1.5 text-sm ${i === currentPage ? 'font-medium text-white bg-navy-700' : 'text-slate-600 hover:bg-slate-100'} rounded-md transition-colors">${i}</button>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHtml += `<span class="px-2 text-slate-400">...</span>`;
            }
            paginationHtml += `<button onclick="changePage(${totalPages})" class="px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-100 rounded-md transition-colors">${totalPages}</button>`;
        }

        paginationHtml += `<button onclick="changePage('next')" class="px-3 py-1.5 text-sm text-slate-600 bg-slate-100 rounded-md hover:bg-slate-200 transition-colors ${currentPage >= totalPages ? 'opacity-50 cursor-not-allowed' : ''}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>`;

        paginationDiv.innerHTML = paginationHtml;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredLogs.length / itemsPerPage);
        
        if (page === 'prev') {
            if (currentPage > 1) currentPage--;
            else return;
        } else if (page === 'next') {
            if (currentPage < totalPages) currentPage++;
            else return;
        } else {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
        }
        
        renderLogTable();
    }

    function updateStats(stats) {
    console.log('Updating stats with:', stats); // Debug
    
    // Kiểm tra các element tồn tại trước khi set
    const statToday = document.getElementById('stat-today');
    const statLogin = document.getElementById('stat-login');
    const statImport = document.getElementById('stat-import');
    const statEdit = document.getElementById('stat-edit');

    if (statToday) {
        statToday.textContent = stats.hom_nay || 0;
    } else {
        console.warn('Element stat-today not found');
    }
    
    if (statLogin) {
        statLogin.textContent = stats.dang_nhap_hom_nay || 0;
    } else {
        console.warn('Element stat-login not found');
    }
    
    if (statImport) {
        statImport.textContent = stats.tao_phieu_hom_nay || 0;
    } else {
        console.warn('Element stat-import not found');
    }
    
    if (statEdit) {
        statEdit.textContent = stats.chinh_sua_hom_nay || 0;
    } else {
        console.warn('Element stat-edit not found');
    }
}

    // ==================== DETAIL VIEW FUNCTIONS ====================
    function viewDetail(id) {
        const log = allLogs.find(l => l.ma_lich_su === id);
        if (!log) return;

        const modal = document.getElementById('detail-modal');
        const content = document.getElementById('modal-content');
        const datetime = formatDateTime(log.thoi_gian);
        
        content.innerHTML = `
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Người thực hiện</p>
                    <p class="text-sm font-medium text-slate-800">${log.nguoi_dung}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Vai trò</p>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getRoleBadgeClass(log.vai_tro)}">${log.vai_tro || 'Không xác định'}</span>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Hành động</p>
                    <p class="text-sm font-medium text-slate-800 flex items-center gap-1.5">
                        ${getActionIcon(log.hanh_dong)}
                        ${log.hanh_dong}
                    </p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Đối tượng</p>
                    <p class="text-sm font-mono text-blue-600">${log.ma_doi_tuong || ''}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Thời gian</p>
                    <p class="text-sm font-medium text-slate-800">${datetime.time} - ${datetime.date}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-500 mb-1">Địa chỉ IP</p>
                    <p class="text-sm font-mono text-slate-800">${log.ip || 'Không xác định'}</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 mb-4">
                <p class="text-xs text-slate-500 mb-1">Chi tiết</p>
                <p class="text-sm text-slate-700">${log.chi_tiet || 'Không có chi tiết'}</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 mb-4">
                <p class="text-xs text-slate-500 mb-1">Trạng thái</p>
                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getStatusClass(log.trang_thai)}">${getStatusText(log.trang_thai)}</span>
            </div>

            ${log.du_lieu_truoc || log.du_lieu_sau ? `
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                        <p class="text-xs text-red-600 font-medium mb-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Dữ liệu trước thay đổi
                        </p>
                        ${log.du_lieu_truoc ? Object.entries(log.du_lieu_truoc).map(([key, value]) => `
                            <div class="mb-1">
                                <span class="text-xs text-slate-500">${key}:</span>
                                <span class="text-sm text-slate-700 ml-1">${value}</span>
                            </div>
                        `).join('') : '<p class="text-sm text-slate-500 italic">Không có dữ liệu</p>'}
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                        <p class="text-xs text-green-600 font-medium mb-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Dữ liệu sau thay đổi
                        </p>
                        ${log.du_lieu_sau ? Object.entries(log.du_lieu_sau).map(([key, value]) => `
                            <div class="mb-1">
                                <span class="text-xs text-slate-500">${key}:</span>
                                <span class="text-sm text-slate-700 ml-1">${value}</span>
                            </div>
                        `).join('') : '<p class="text-sm text-slate-500 italic">Không có dữ liệu</p>'}
                    </div>
                </div>
            ` : ''}
        `;

        modal.classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }

    // ==================== FILTER FUNCTIONS ====================
    // ==================== FILTER FUNCTIONS ====================
function applyFilters() {
    console.log('Applying filters...'); // Debug
    
    // Lấy giá trị từ các input
    const search = document.getElementById('search-input')?.value || '';
    const ma_nguoi_dung = document.getElementById('filter-user')?.value || '';
    const hanh_dong = document.getElementById('filter-action')?.value || '';
    const trang_thai = document.getElementById('filter-status')?.value || '';
    const tu_ngay = document.getElementById('filter-from')?.value || '';
    const den_ngay = document.getElementById('filter-to')?.value || '';

    console.log('Filter values:', { search, ma_nguoi_dung, hanh_dong, trang_thai, tu_ngay, den_ngay });

    // Lọc dữ liệu
    filteredLogs = allLogs.filter(log => {
        // Filter by search
        if (search) {
            const searchLower = search.toLowerCase();
            const matchSearch = 
                (log.nguoi_dung && log.nguoi_dung.toLowerCase().includes(searchLower)) ||
                (log.hanh_dong && log.hanh_dong.toLowerCase().includes(searchLower)) ||
                (log.chi_tiet && log.chi_tiet.toLowerCase().includes(searchLower)) ||
                (log.ma_doi_tuong && log.ma_doi_tuong.toLowerCase().includes(searchLower));
            if (!matchSearch) return false;
        }

        // Filter by user
        if (ma_nguoi_dung && log.ma_nguoi_dung != ma_nguoi_dung) {
            return false;
        }

        // Filter by action
        if (hanh_dong && log.hanh_dong !== hanh_dong) {
            return false;
        }

        // Filter by status
        if (trang_thai && log.trang_thai !== trang_thai) {
            return false;
        }

        // Filter by date range
        if (tu_ngay || den_ngay) {
            const logDate = new Date(log.thoi_gian).toISOString().split('T')[0];
            
            if (tu_ngay && logDate < tu_ngay) {
                return false;
            }
            if (den_ngay && logDate > den_ngay) {
                return false;
            }
        }

        return true;
    });

    console.log('Filtered logs count:', filteredLogs.length);

    // Reset về trang đầu tiên
    currentPage = 1;
    
    // Render lại bảng với dữ liệu đã lọc
    renderLogTable();
    
    // Hiển thị thông báo
    const message = `Tìm thấy ${filteredLogs.length} kết quả`;
    showToast(message, 'success');
}

function resetFilters() {
    console.log('Resetting filters...'); // Debug
    
    // Reset tất cả các input
    const searchInput = document.getElementById('search-input');
    const filterUser = document.getElementById('filter-user');
    const filterAction = document.getElementById('filter-action');
    const filterStatus = document.getElementById('filter-status');
    const filterFrom = document.getElementById('filter-from');
    const filterTo = document.getElementById('filter-to');
    
    if (searchInput) searchInput.value = '';
    if (filterUser) filterUser.value = '';
    if (filterAction) filterAction.value = '';
    if (filterStatus) filterStatus.value = '';
    if (filterFrom) filterFrom.value = '';
    if (filterTo) filterTo.value = '';
    
    // Reset về dữ liệu gốc
    filteredLogs = [...allLogs];
    currentPage = 1;
    
    // Render lại bảng
    renderLogTable();
    
    showToast('Đã reset bộ lọc!', 'success');
}

    // ==================== SEARCH HANDLER ====================
    // ==================== SEARCH HANDLER ====================
function handleSearch(e) {
    const search = e.target.value;
    
    // Clear previous timeout
    if (window.searchTimeout) {
        clearTimeout(window.searchTimeout);
    }
    
    // Set new timeout để tránh gọi API liên tục
    window.searchTimeout = setTimeout(() => {
        if (search.length >= 2 || search.length === 0) {
            applyFilters();
        }
    }, 500);
}

    // ==================== EXPORT FUNCTIONS ====================
    function exportData(type) {
        showToast(`Đang xuất file ${type.toUpperCase()}...`);
        
        // Tạo dữ liệu xuất
        const exportData = filteredLogs.map(log => ({
            'Thời gian': log.thoi_gian,
            'Người dùng': log.nguoi_dung,
            'Vai trò': log.vai_tro,
            'Hành động': log.hanh_dong,
            'Đối tượng': log.ma_doi_tuong,
            'Chi tiết': log.chi_tiet,
            'IP': log.ip,
            'Trạng thái': log.trang_thai
        }));

        if (type === 'csv') {
            exportToCSV(exportData, 'lich_su_he_thong.csv');
        } else if (type === 'excel') {
            exportToExcel(exportData, 'lich_su_he_thong.xlsx');
        } else {
            // PDF - chưa implement
            setTimeout(() => {
                showToast(`Xuất file ${type.toUpperCase()} thành công!`);
            }, 1500);
        }
    }

    function exportToCSV(data, filename) {
        const headers = Object.keys(data[0] || {}).join(',');
        const rows = data.map(row => Object.values(row).map(val => `"${val}"`).join(',')).join('\n');
        const csv = headers + '\n' + rows;
        
        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();
        URL.revokeObjectURL(link.href);
        
        showToast('Xuất file CSV thành công!');
    }

    function exportToExcel(data, filename) {
        // Chuyển đổi JSON thành worksheet
        const wsData = [
            Object.keys(data[0] || {}),
            ...data.map(row => Object.values(row))
        ];
        
        const csv = wsData.map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');
        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename.replace('.xlsx', '.csv');
        link.click();
        URL.revokeObjectURL(link.href);
        
        showToast('Xuất file Excel thành công!');
    }

    // ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', () => {
    // Load initial data
    loadUsers();
    loadActions();
    loadLogList();

    // Setup event listeners cho các filter
    const searchInput = document.getElementById('search-input');
    const filterUser = document.getElementById('filter-user');
    const filterAction = document.getElementById('filter-action');
    const filterStatus = document.getElementById('filter-status');
    const filterFrom = document.getElementById('filter-from');
    const filterTo = document.getElementById('filter-to');
    const applyBtn = document.querySelector('button[onclick="applyFilters()"]');
    const resetBtn = document.querySelector('button[onclick="resetFilters()"]');

    // Gán sự kiện bằng addEventListener thay vì onclick trong HTML
    if (applyBtn) {
        applyBtn.addEventListener('click', applyFilters);
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', resetFilters);
    }

    // Thêm sự kiện change cho các select
    if (filterUser) {
        filterUser.addEventListener('change', applyFilters);
    }
    
    if (filterAction) {
        filterAction.addEventListener('change', applyFilters);
    }
    
    if (filterStatus) {
        filterStatus.addEventListener('change', applyFilters);
    }
    
    if (filterFrom) {
        filterFrom.addEventListener('change', applyFilters);
    }
    
    if (filterTo) {
        filterTo.addEventListener('change', applyFilters);
    }

    // Search input với debounce
    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }

    // Close modal on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
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
            },
            mapToCapabilities: (config) => ({
                recolorables: [
                    {
                        get: () => config.primary_color || defaultConfig.primary_color,
                        set: (value) => window.elementSdk.setConfig({ primary_color: value })
                    }
                ],
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
    // ==================== SIDEBAR & DROPDOWN TOGGLE ====================
document.addEventListener('DOMContentLoaded', function() {
    // Khai báo các element
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const userDropdown = document.getElementById('userDropdown');
    const userTrigger = document.getElementById('userTrigger');
    const navItems = document.querySelectorAll('.nav-item');
    const breadcrumbCurrent = document.getElementById('breadcrumbCurrent');
    
    // State
    let isSidebarCollapsed = false;
    let isMobile = window.innerWidth <= 768;
    
    // Kiểm tra các element tồn tại trước khi sử dụng
    if (!sidebar || !sidebarToggle) {
        console.warn('Sidebar elements not found');
        return;
    }
    
    // Sidebar Toggle Function
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
    
    // Close Mobile Sidebar
    function closeMobileSidebar() {
        if (sidebar && mobileOverlay) {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.remove('active');
        }
    }
    
    // Handle Navigation Click
    function handleNavClick(e) {
        const clickedItem = e.currentTarget;
        const pageName = clickedItem.getAttribute('data-page');
        
        // Update active state
        navItems.forEach(item => item.classList.remove('active'));
        clickedItem.classList.add('active');
        
        // Update breadcrumb
        const pageNames = {
            'dashboard': 'Dashboard',
            'products': 'Quản lý sản phẩm',
            'categories': 'Danh mục',
            'suppliers': 'Nhà cung cấp',
            'warehouses': 'Kho hàng',
            'inventory': 'Tồn kho',
            'import': 'Nhập hàng',
            'export': 'Xuất hàng',
            'users': 'Người dùng',
            'roles': 'Vai trò',
            'reports': 'Báo cáo',
            'history': 'Lịch sử'
        };
        
        if (breadcrumbCurrent && pageNames[pageName]) {
            breadcrumbCurrent.textContent = pageNames[pageName];
        }
        
        // Close mobile sidebar after navigation
        if (isMobile) {
            closeMobileSidebar();
        }
    }
    
    // Toggle User Dropdown
    function toggleUserDropdown(e) {
        e.stopPropagation();
        if (userDropdown) {
            userDropdown.classList.toggle('open');
        }
    }
    
    // Close User Dropdown
    function closeUserDropdown() {
        if (userDropdown) {
            userDropdown.classList.remove('open');
        }
    }
    
    // Handle Window Resize
    function handleResize() {
        const wasMobile = isMobile;
        isMobile = window.innerWidth <= 768;
        
        if (wasMobile !== isMobile) {
            // Reset sidebar state on viewport change
            if (sidebar) {
                sidebar.classList.remove('collapsed', 'mobile-open');
            }
            if (mobileOverlay) {
                mobileOverlay.classList.remove('active');
            }
            isSidebarCollapsed = false;
        }
    }
    
    // Gắn sự kiện cho các nút (chỉ khi element tồn tại)
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMobileSidebar);
    }
    
    if (userTrigger) {
        userTrigger.addEventListener('click', toggleUserDropdown);
    }
    
    // Gắn sự kiện cho nav items
    if (navItems.length > 0) {
        navItems.forEach(item => {
            item.addEventListener('click', handleNavClick);
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (userDropdown && !userDropdown.contains(e.target) && userTrigger && !userTrigger.contains(e.target)) {
            closeUserDropdown();
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeUserDropdown();
            if (isMobile) {
                closeMobileSidebar();
            }
        }
    });
    
    // Window resize
    window.addEventListener('resize', handleResize);
    
    // Initial check
    handleResize();
});
</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d9805f4a1bc03d3',t:'MTc3MzAzNzc0NS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
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