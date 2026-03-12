
<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}

// Lấy thông tin người dùng từ SESSION
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
  <title>Quản Lý Phiếu Xuất Kho - WMS</title>

  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Sử dụng dashboard.css để fix sidebar không đè nội dung -->
  <link rel="stylesheet" href="../public/CSS/dashboard.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy: {
              50: '#f0f4f8',
              100: '#d9e2ec',
              200: '#bcccdc',
              300: '#9fb3c8',
              400: '#829ab1',
              500: '#627d98',
              600: '#486581',
              700: '#334e68',
              800: '#243b53',
              900: '#102a43'
            }
          },
          fontFamily: {
            'inter': ['Inter', 'sans-serif']
          }
        }
      }
    }
  </script>

  <style>
    * { font-family: 'Inter', sans-serif; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    .table-row-hover:hover { background-color: #f8fafc; }
    .input-focus:focus { outline: none; border-color: #334e68; box-shadow: 0 0 0 3px rgba(51, 78, 104, 0.1); }
    .btn-transition { transition: all 0.2s ease; }
    .modal-overlay { background: rgba(16, 42, 67, 0.5); backdrop-filter: blur(4px); }
    .slide-in { animation: slideIn 0.3s ease; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }
    .badge-pending { background: #fef3c7; color: #d97706; }
    .badge-approved { background: #d1fae5; color: #059669; }
    .badge-rejected { background: #fee2e2; color: #dc2626; }
    .stock-low { background: #fee2e2; color: #dc2626; }
    .stock-medium { background: #fef3c7; color: #d97706; }
    .stock-high { background: #d1fae5; color: #059669; }
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

    <!-- Main Content Wrapper -->
    <div class="wms-main">

      <!-- Topbar / Header -->
      <?php include __DIR__ . "/../views/Layout/header.php"; ?>

      <!-- Page Content -->
      <main class="wms-content custom-scrollbar" id="main-content">

        <!-- LIST VIEW -->
        <div id="list-view">

          <!-- Breadcrumb & Title -->
          <div class="mb-6 slide-in">
            <nav class="text-sm text-gray-500 mb-2">
              <a href="#" class="hover:text-navy-700">Trang chủ</a> <span class="mx-2">/</span>
              <span class="text-navy-700 font-medium">Phiếu xuất kho</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
              <h1 class="text-2xl font-bold text-navy-900" id="page-title">QUẢN LÝ PHIẾU XUẤT KHO</h1>
              <button id="create-export-btn" class="inline-flex items-center gap-2 px-5 py-2.5 bg-navy-700 text-white rounded-lg hover:bg-navy-800 btn-transition font-medium shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg> Tạo phiếu xuất
              </button>
            </div>
          </div>

          <!-- Toolbar -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 mb-6 slide-in">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
              <!-- Search -->
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <div class="relative">
                  <input type="text" id="search-input" placeholder="Nhập mã phiếu xuất..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm">
                  <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>
              <!-- Warehouse Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kho xuất</label>
                <select id="warehouse-filter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">Tất cả kho</option>
                </select>
              </div>
              <!-- Status Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select id="status-filter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">Tất cả</option>
                  <option value="0">Chờ duyệt</option>
                  <option value="1">Đã duyệt</option>
                  <option value="2">Từ chối</option>
                </select>
              </div>
              <!-- Date Range -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                <input type="date" id="date-from" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                <input type="date" id="date-to" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm">
              </div>
            </div>
            <div class="flex justify-end mt-4 pt-4 border-t border-gray-100">
              <button id="refresh-btn" class="inline-flex items-center gap-2 px-4 py-2 text-navy-700 border border-navy-200 rounded-lg hover:bg-navy-50 btn-transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg> Làm mới
              </button>
            </div>
          </div>

          <!-- Table -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden slide-in">
            <div class="overflow-x-auto custom-scrollbar">
              <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Mã phiếu</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Kho xuất</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Người nhận/Bộ phận</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700 uppercase tracking-wider">Số mặt hàng</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700 uppercase tracking-wider">Tổng SL</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-navy-700 uppercase tracking-wider">Tổng giá trị</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700 uppercase tracking-wider">Người tạo</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700 uppercase tracking-wider">Thao tác</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="export-table-body">
                  <!-- Dữ liệu sẽ được render bằng JS -->
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
              <p class="text-sm text-gray-600">Hiển thị <span class="font-medium" id="display-start">1</span>-<span class="font-medium" id="display-end">10</span> của <span class="font-medium" id="total-records">0</span> phiếu</p>
              <div class="flex items-center gap-1" id="pagination-controls">
                <!-- Pagination sẽ được render bằng JS -->
              </div>
            </div>
          </div>
        </div>

        <!-- CREATE VIEW -->
        <div id="create-view" class="hidden">
          <!-- Breadcrumb & Title -->
          <div class="mb-6 slide-in">
            <nav class="text-sm text-gray-500 mb-2">
              <a href="#" class="hover:text-navy-700">Trang chủ</a> <span class="mx-2">/</span>
              <a href="#" id="back-to-list" class="hover:text-navy-700">Phiếu xuất kho</a> <span class="mx-2">/</span>
              <span class="text-navy-700 font-medium">Tạo phiếu xuất</span>
            </nav>
            <h1 class="text-2xl font-bold text-navy-900">TẠO PHIẾU XUẤT KHO MỚI</h1>
          </div>

          <!-- General Info -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 slide-in">
            <h2 class="text-lg font-semibold text-navy-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg> Thông tin chung
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mã phiếu xuất <span class="text-red-500">*</span></label>
                <input type="text" id="export-code" value="Tự động tạo" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-gray-50" readonly>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày xuất <span class="text-red-500">*</span></label>
                <input type="date" id="export-date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kho xuất <span class="text-red-500">*</span></label>
                <select id="export-warehouse" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">-- Chọn kho --</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Người nhận <span class="text-red-500">*</span></label>
                <input type="text" id="receiver" placeholder="Nhập tên người nhận" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bộ phận</label>
                <select id="department" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">-- Chọn bộ phận --</option>
                  <option value="Kinh doanh">Kinh doanh</option>
                  <option value="Sản xuất">Sản xuất</option>
                  <option value="Kỹ thuật">Kỹ thuật</option>
                  <option value="Hành chính">Hành chính</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Người tạo</label>
                <input type="text" id="creator" value="<?php echo htmlspecialchars($ten); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50" readonly>
              </div>
              <div class="md:col-span-2 lg:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                <textarea id="export-note" rows="2" placeholder="Nhập ghi chú (nếu có)" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm resize-none"></textarea>
              </div>
            </div>
          </div>

          <!-- Danh sách sản phẩm nhập -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 slide-in">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold text-navy-900">Danh sách sản phẩm xuất</h2>
              <button id="add-empty-row" class="inline-flex items-center gap-2 px-4 py-2 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 btn-transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg> Thêm dòng trống
              </button>
            </div>
            
            <div class="overflow-x-auto custom-scrollbar" style="max-height: 300px; overflow-y: auto;">
              <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">STT</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Mã SP</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Tên sản phẩm</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Số lượng</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Tồn kho</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-navy-700">Giá xuất</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-navy-700">Thành tiền</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Xóa</th>
                  </tr>
                </thead>
                <tbody id="export-products-body" class="divide-y divide-gray-100">
                  <!-- Dữ liệu sẽ được render bằng JS -->
                </tbody>
              </table>
              <div id="empty-export-state" class="text-center py-10 text-gray-500 hidden">
                Chưa có sản phẩm nào. Hãy chọn sản phẩm từ bảng bên dưới.
              </div>
            </div>

            <!-- Phân trang cho bảng sản phẩm nhập -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
              <span class="text-sm text-gray-600">
                Tổng số: <span id="selected-total-rows">0</span> sản phẩm
              </span>
              <div class="flex gap-2">
                <button id="selected-prev-btn" class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>←</button>
                <span class="text-sm px-3 py-1"><span id="selected-current-page">1</span>/<span id="selected-total-pages">1</span></span>
                <button id="selected-next-btn" class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>→</button>
              </div>
            </div>
          </div>

          <!-- Danh sách sản phẩm để chọn -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 slide-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
              <h2 class="text-lg font-semibold text-navy-900">Danh sách sản phẩm</h2>
              <div class="flex gap-2">
                <input type="text" id="product-search" placeholder="Tìm kiếm sản phẩm..." 
                       class="w-64 px-4 py-2 border border-gray-300 rounded-lg input-focus text-sm">
                <button id="search-product-btn" class="px-4 py-2 bg-navy-700 text-white rounded-lg hover:bg-navy-800 btn-transition text-sm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                </button>
              </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
              <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Mã SP</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Tên sản phẩm</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Danh mục</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Kho</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Tồn kho</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-navy-700">Giá xuất</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Trạng thái</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Thao tác</th>
                  </tr>
                </thead>
                <tbody id="product-choose-body" class="divide-y divide-gray-100">
                  <!-- Dữ liệu sẽ được render bằng JS -->
                </tbody>
              </table>
            </div>

            <!-- Phân trang cho bảng sản phẩm chọn -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
              <span class="text-sm text-gray-600">
                Hiển thị <span id="product-display-start">0</span>-<span id="product-display-end">0</span> / <span id="product-total-rows">0</span> sản phẩm
              </span>
              <div class="flex gap-2">
                <button id="product-prev-btn" class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>←</button>
                <span class="text-sm px-3 py-1"><span id="product-current-page">1</span>/<span id="product-total-pages">1</span></span>
                <button id="product-next-btn" class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>→</button>
              </div>
            </div>
          </div>

          <!-- Tổng kết -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 slide-in">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Tổng số mặt hàng</div>
                <div class="text-2xl font-bold text-navy-700" id="total-items">0</div>
              </div>
              <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Tổng số lượng</div>
                <div class="text-2xl font-bold text-navy-700" id="total-quantity">0</div>
              </div>
              <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Tổng giá trị</div>
                <div class="text-2xl font-bold text-green-600" id="total-value">0</div>
              </div>
            </div>
          </div>

          <!-- Nút hành động -->
          <div class="flex justify-end gap-3 mb-6 slide-in">
            <button id="cancel-btn" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 btn-transition font-medium">Hủy</button>
            <button id="save-draft-btn" class="px-6 py-2.5 border border-navy-300 text-navy-700 rounded-lg hover:bg-navy-50 btn-transition font-medium">Lưu nháp</button>
            <button id="submit-btn" class="px-6 py-2.5 bg-navy-700 text-white rounded-lg hover:bg-navy-800 btn-transition font-medium">Gửi duyệt</button>
          </div>
        </div>

        <!-- DETAIL VIEW -->
        <div id="detail-view" class="hidden">
          <!-- Breadcrumb & Title -->
          <div class="mb-6 slide-in">
            <nav class="text-sm text-gray-500 mb-2">
              <a href="#" class="hover:text-navy-700">Trang chủ</a> <span class="mx-2">/</span>
              <a href="#" id="back-to-list-from-detail" class="hover:text-navy-700">Phiếu xuất kho</a> <span class="mx-2">/</span>
              <span class="text-navy-700 font-medium">Chi tiết phiếu xuất</span>
            </nav>
            <div class="flex items-center justify-between">
              <h1 class="text-2xl font-bold text-navy-900" id="detail-title">CHI TIẾT PHIẾU XUẤT</h1>
              <button id="back-to-list-btn" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 btn-transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg> Quay lại
              </button>
            </div>
          </div>

          <!-- Thông tin phiếu -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 slide-in">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold text-navy-900">Thông tin phiếu xuất</h2>
              <div id="detail-status"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <div>
                <div class="text-sm text-gray-500">Mã phiếu</div>
                <div class="text-base font-medium text-navy-700" id="detail-code">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Ngày tạo</div>
                <div class="text-base" id="detail-date">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Kho xuất</div>
                <div class="text-base" id="detail-warehouse">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Người nhận</div>
                <div class="text-base" id="detail-receiver">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Bộ phận</div>
                <div class="text-base" id="detail-department">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Người tạo</div>
                <div class="text-base" id="detail-creator">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Người duyệt</div>
                <div class="text-base" id="detail-approver">-</div>
              </div>
              <div>
                <div class="text-sm text-gray-500">Ngày duyệt</div>
                <div class="text-base" id="detail-approve-date">-</div>
              </div>
              <div class="lg:col-span-4">
                <div class="text-sm text-gray-500">Ghi chú</div>
                <div class="text-base" id="detail-note">-</div>
              </div>
            </div>
          </div>

          <!-- Chi tiết sản phẩm -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 slide-in">
            <h2 class="text-lg font-semibold text-navy-900 mb-4">Danh sách sản phẩm</h2>
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Mã SP</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-navy-700">Tên sản phẩm</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-navy-700">Số lượng</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-navy-700">Giá xuất</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-navy-700">Thành tiền</th>
                  </tr>
                </thead>
                <tbody id="detail-products-body" class="divide-y divide-gray-100">
                  <!-- Dữ liệu sẽ được render bằng JS -->
                </tbody>
                <tfoot class="bg-gray-50 border-t border-gray-200">
                  <tr>
                    <td colspan="2" class="px-4 py-3 text-right font-medium">Tổng cộng:</td>
                    <td class="px-4 py-3 text-center font-medium" id="detail-total-qty">0</td>
                    <td class="px-4 py-3"></td>
                    <td class="px-4 py-3 text-right font-medium" id="detail-total-amount">0</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Nút duyệt/từ chối -->
          <div id="approval-buttons" class="flex justify-end gap-3 mb-6 slide-in hidden">
            <button id="reject-btn" class="px-6 py-2.5 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 btn-transition font-medium">Từ chối</button>
            <button id="approve-btn" class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 btn-transition font-medium">Duyệt phiếu</button>
          </div>
        </div>

      </main>

      <!-- Footer -->
      <footer class="wms-footer">
        <p class="footer-text">© 2026 Warehouse Management System</p>
      </footer>

    </div>
  </div>

  <!-- Toast Notification -->
  <div id="toast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
    <div class="px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 text-white">
      <span id="toast-message"></span>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="delete-modal" class="fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute inset-0" onclick="closeDeleteModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 w-full max-w-md slide-in">
      <div class="text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Xác nhận xóa</h3>
        <p class="text-gray-600 mb-6">Bạn có chắc chắn muốn xóa phiếu xuất này? Hành động này không thể hoàn tác.</p>
        <div class="flex gap-3 justify-center">
          <button onclick="closeDeleteModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 btn-transition font-medium">Hủy bỏ</button>
          <button onclick="confirmDelete()" class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 btn-transition font-medium">Xóa phiếu</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    //////////////////////////////// side bar toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    // State
    let isSidebarCollapsed = false;
    let isMobile = window.innerWidth <= 768;
    
    // Sidebar Toggle Function
    function toggleSidebar() {
      if (isMobile) {
        sidebar.classList.toggle('mobile-open');
        mobileOverlay.classList.toggle('active');
      } else {
        isSidebarCollapsed = !isSidebarCollapsed;
        sidebar.classList.toggle('collapsed', isSidebarCollapsed);
      }
    }
    
    // Close Mobile Sidebar
    function closeMobileSidebar() {
      sidebar.classList.remove('mobile-open');
      mobileOverlay.classList.remove('active');
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
        'products': 'Product Management',
        'categories': 'Categories',
        'suppliers': 'Suppliers',
        'warehouses': 'Warehouses',
        'inventory': 'Inventory',
        'import': 'Import Orders',
        'export': 'Export Orders',
        'users': 'Users',
        'reports': 'Reports'
      };
      
      if (breadcrumbCurrent && pageNames[pageName]) {
        breadcrumbCurrent.textContent = pageNames[pageName];
      }
      
      // Close mobile sidebar after navigation
      if (isMobile) {
        closeMobileSidebar();
      }
    }
    
    // Handle Window Resize
    function handleResize() {
      const wasMobile = isMobile;
      isMobile = window.innerWidth <= 768;
      
      if (wasMobile !== isMobile) {
        // Reset sidebar state on viewport change
        sidebar.classList.remove('collapsed', 'mobile-open');
        mobileOverlay.classList.remove('active');
        isSidebarCollapsed = false;
      }
    }
    
    // Event Listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    mobileOverlay.addEventListener('click', closeMobileSidebar);
    userTrigger.addEventListener('click', toggleUserDropdown);
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target)) {
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

    // ==================== CẤU HÌNH ====================
    const currentUser = {
        ma_nguoi_dung: <?php echo $ma_nguoi_dung; ?>,
        ho_ten: '<?php echo $ten; ?>',
        vai_tro: '<?php echo $role; ?>'
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let exportList = [];
    let warehouses = [];
    let allProducts = [];
    let exportProducts = [];
    let currentDetailId = null;
    let deleteTargetId = null;
    
    // Biến phân trang
    let currentPage = 1;
    let totalPages = 1;
    let currentProductPage = 1;
    let currentSelectedPage = 1;
    const productsPerPage = 10;
    const selectedPerPage = 5;

    // ==================== UTILITY FUNCTIONS ====================
    window.showToast = function(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        
        toastMessage.textContent = message;
        const bgColor = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600';
        toast.querySelector('div').className = `${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3`;
        
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN');
    }

    function getStatusBadge(status) {
        switch(status) {
            case 0: return '<span class="badge badge-pending">Chờ duyệt</span>';
            case 1: return '<span class="badge badge-approved">Đã duyệt</span>';
            case 2: return '<span class="badge badge-rejected">Từ chối</span>';
            default: return '<span class="badge">Không xác định</span>';
        }
    }

    function getStockClass(quantity) {
        if (quantity <= 0) return 'stock-low';
        if (quantity < 10) return 'stock-low';
        if (quantity < 50) return 'stock-medium';
        return 'stock-high';
    }

    // ==================== API CALLS ====================
    async function loadExportList() {
        try {
            const response = await fetch('../actions/QuanLyPhieuXuat/lay_danh_sach.php');
            const result = await response.json();

            if (result.success) {
                exportList = result.data;
                renderExportTable();
                updatePagination();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading export list:', error);
            showToast('Lỗi tải danh sách phiếu xuất', 'error');
        }
    }

    async function loadWarehouses() {
        try {
            const response = await fetch('../actions/QuanLyPhieuXuat/lay_danh_sach_kho.php');
            const result = await response.json();

            if (result.success) {
                warehouses = result.data;
                renderWarehouseOptions();
            }
        } catch (error) {
            console.error('Error loading warehouses:', error);
        }
    }

    async function loadProductListForChoose(search = '') {
        try {
            let url = '../actions/QuanLyPhieuXuat/lay_danh_sach_hang_hoa.php';
            if (search) {
                url += `?search=${encodeURIComponent(search)}`;
            }

            const response = await fetch(url);
            const result = await response.json();

            if (result.success) {
                allProducts = result.data;
                currentProductPage = 1;
                renderProductChooseTable();
                updateProductPagination();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading products:', error);
            showToast('Lỗi tải danh sách sản phẩm', 'error');
        }
    }

    async function loadExportDetail(id) {
        try {
            const response = await fetch(`../actions/QuanLyPhieuXuat/chi_tiet_phieu_xuat.php?ma_phieu_xuat=${id}`);
            const result = await response.json();

            if (result.success) {
                renderExportDetail(result.data);
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading export detail:', error);
            showToast('Lỗi tải chi tiết phiếu xuất', 'error');
        }
    }

    async function deleteExport(id) {
        const formData = new FormData();
        formData.append('ma_phieu_xuat', id);

        try {
            const response = await fetch('../actions/QuanLyPhieuXuat/xoa_phieu_xuat.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                loadExportList();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting export:', error);
            showToast('Lỗi xóa phiếu xuất', 'error');
        }
    }

    async function updateExportStatus(id, status) {
        const formData = new FormData();
        formData.append('ma_phieu_xuat', id);
        formData.append('trang_thai', status);

        try {
            const response = await fetch('../actions/QuanLyPhieuXuat/cap_nhat_trang_thai.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                loadExportList();
                showListView();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error updating status:', error);
            showToast('Lỗi cập nhật trạng thái', 'error');
        }
    }

    async function saveExport(status) {
        // Validate
        const warehouseId = document.getElementById('export-warehouse').value;
        const receiver = document.getElementById('receiver').value;
        const department = document.getElementById('department').value;
        const notes = document.getElementById('export-note').value;

        if (!warehouseId) {
            showToast('Vui lòng chọn kho xuất', 'error');
            return;
        }
        if (!receiver) {
            showToast('Vui lòng nhập người nhận', 'error');
            return;
        }

        if (exportProducts.length === 0) {
            showToast('Vui lòng thêm ít nhất một sản phẩm', 'error');
            return;
        }

        // Kiểm tra tồn kho
        const overStock = exportProducts.find(p => p.so_luong > p.ton_kho);
        if (overStock) {
            showToast(`Sản phẩm "${overStock.ten_hang_hoa}" chỉ còn ${overStock.ton_kho} trong kho`, 'error');
            return;
        }

        // Gửi request
        const formData = new FormData();
        formData.append('ma_kho', warehouseId);
        formData.append('nguoi_nhan', receiver);
        formData.append('bo_phan', department);
        formData.append('ghi_chu', notes);
        formData.append('trang_thai', status);
        formData.append('san_phams', JSON.stringify(exportProducts));

        try {
            const response = await fetch('../actions/QuanLyPhieuXuat/them_phieu_xuat.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                setTimeout(() => {
                    showListView();
                    loadExportList();
                }, 1500);
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving export:', error);
            showToast('Lỗi lưu phiếu xuất', 'error');
        }
    }

    const userDropdown = document.getElementById('userDropdown');
// Toggle User Dropdown
    function toggleUserDropdown(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('open');
    }
    
    // Close User Dropdown
    function closeUserDropdown() {
      userDropdown.classList.remove('open');
    }
userTrigger.addEventListener('click', toggleUserDropdown);
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target)) {
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

    // ==================== RENDER FUNCTIONS ====================
    function renderExportTable() {
        const tbody = document.getElementById('export-table-body');
        
        if (exportList.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center py-10 text-gray-500">Không có dữ liệu</td></tr>';
            return;
        }

        // Tính phân trang
        const start = (currentPage - 1) * 10;
        const end = Math.min(start + 10, exportList.length);
        const paginatedData = exportList.slice(start, end);

        tbody.innerHTML = paginatedData.map(item => `
            <tr class="table-row-hover">
                <td class="px-4 py-3 text-sm font-medium text-navy-700">${item.ma_phieu}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${formatDate(item.ngay_tao)}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${item.ten_kho}</td>
                <td class="px-4 py-3 text-sm text-gray-600">
                    ${item.nguoi_nhan}<br>
                    <span class="text-xs text-gray-400">${item.bo_phan || ''}</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600 text-center">${item.so_mat_hang}</td>
                <td class="px-4 py-3 text-sm text-gray-600 text-center">${item.tong_so_luong}</td>
                <td class="px-4 py-3 text-sm font-medium text-navy-700 text-right">${formatCurrency(item.tong_gia_tri)}</td>
                <td class="px-4 py-3 text-center">${getStatusBadge(item.trang_thai)}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${item.nguoi_tao}</td>
                <td class="px-4 py-3 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button onclick="viewExport(${item.ma_phieu_xuat})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg btn-transition" title="Xem chi tiết">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        ${item.trang_thai === 0 ? `
                            <button onclick="editExport(${item.ma_phieu_xuat})" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg btn-transition" title="Sửa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button onclick="openDeleteModal(${item.ma_phieu_xuat})" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg btn-transition" title="Xóa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `).join('');

        // Cập nhật thông tin phân trang
        document.getElementById('display-start').textContent = exportList.length > 0 ? start + 1 : 0;
        document.getElementById('display-end').textContent = end;
        document.getElementById('total-records').textContent = exportList.length;
    }

    function updatePagination() {
        totalPages = Math.ceil(exportList.length / 10);
        const paginationDiv = document.getElementById('pagination-controls');
        
        let html = '';
        for (let i = 1; i <= totalPages; i++) {
            html += `<button class="px-3 py-1.5 text-sm ${i === currentPage ? 'bg-navy-700 text-white' : 'text-gray-600 hover:bg-gray-200'} rounded-lg btn-transition" onclick="goToPage(${i})">${i}</button>`;
        }
        paginationDiv.innerHTML = html;
    }

    window.goToPage = function(page) {
        currentPage = page;
        renderExportTable();
        updatePagination();
    };

    function renderWarehouseOptions() {
        const select = document.getElementById('export-warehouse');
        const filterSelect = document.getElementById('warehouse-filter');
        
        const options = warehouses.map(w => 
            `<option value="${w.ma_kho}">${w.ten_kho}</option>`
        ).join('');
        
        select.innerHTML = '<option value="">-- Chọn kho --</option>' + options;
        filterSelect.innerHTML = '<option value="">Tất cả kho</option>' + options;
    }

    function renderProductChooseTable() {
        const tbody = document.getElementById('product-choose-body');
        
        if (allProducts.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-10 text-gray-500">Không có sản phẩm nào</td></tr>';
            return;
        }

        const start = (currentProductPage - 1) * productsPerPage;
        const end = Math.min(start + productsPerPage, allProducts.length);
        const paginatedProducts = allProducts.slice(start, end);

        tbody.innerHTML = paginatedProducts.map(product => {
            const stockClass = getStockClass(product.ton_kho);
            const isSelected = exportProducts.find(p => p.ma_hang_hoa === product.ma_hang_hoa);
            
            return `
            <tr class="table-row-hover cursor-pointer ${isSelected ? 'bg-blue-50' : ''}" 
                data-id="${product.ma_hang_hoa}"
                data-code="${product.ma_san_pham}"
                data-name="${product.ten_hang_hoa}"
                data-price="${product.gia_xuat}"
                data-stock="${product.ton_kho}"
                onclick="selectProductFromTable(this)">
                <td class="px-4 py-3 text-sm font-medium text-navy-700">${product.ma_san_pham}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${product.ten_hang_hoa}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${product.ten_danh_muc}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${product.ten_kho}</td>
                <td class="px-4 py-3 text-center">
                    <span class="badge ${stockClass}">${product.ton_kho}</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600 text-right">${formatCurrency(product.gia_xuat)}</td>
                <td class="px-4 py-3 text-center">
                    <span class="badge ${product.trang_thai == 1 ? 'badge-approved' : 'badge-rejected'}">
                        ${product.trang_thai == 1 ? 'Đang bán' : 'Ngừng bán'}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <button onclick="addToExportList(event, this)" 
                            class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg btn-transition"
                            title="Thêm vào phiếu xuất">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    function renderExportProductsTable() {
        const tbody = document.getElementById('export-products-body');
        const emptyState = document.getElementById('empty-export-state');

        if (exportProducts.length === 0) {
            tbody.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        
        const start = (currentSelectedPage - 1) * selectedPerPage;
        const end = Math.min(start + selectedPerPage, exportProducts.length);
        const paginatedProducts = exportProducts.slice(start, end);

        tbody.innerHTML = paginatedProducts.map((p, index) => `
            <tr class="table-row-hover" data-product-id="${p.ma_hang_hoa}">
                <td class="px-4 py-3 text-sm text-gray-600">${start + index + 1}</td>
                <td class="px-4 py-3 text-sm font-medium text-navy-700">${p.ma_san_pham}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${p.ten_hang_hoa}</td>
                <td class="px-4 py-3 text-center">
                    <input type="number" min="1" max="${p.ton_kho}" value="${p.so_luong}" 
                           onchange="updateQuantity('${p.ma_hang_hoa}', this.value)"
                           class="w-20 px-2 py-1.5 border border-gray-300 rounded-lg text-sm text-center input-focus">
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm ${p.so_luong > p.ton_kho ? 'text-red-600 font-medium' : 'text-gray-600'}">
                        ${p.ton_kho}
                    </span>
                </td>
                <td class="px-4 py-3 text-right text-sm text-gray-600">${formatCurrency(p.gia_xuat)}</td>
                <td class="px-4 py-3 text-right text-sm font-medium text-navy-700">${formatCurrency(p.thanh_tien)}</td>
                <td class="px-4 py-3 text-center">
                    <button onclick="removeProduct('${p.ma_hang_hoa}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg btn-transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            </tr>
        `).join('');

        updateSelectedPagination();
    }

    function renderExportDetail(data) {
        document.getElementById('detail-code').textContent = data.ma_phieu;
        document.getElementById('detail-date').textContent = formatDate(data.ngay_tao);
        document.getElementById('detail-warehouse').textContent = data.ten_kho;
        document.getElementById('detail-receiver').textContent = data.nguoi_nhan;
        document.getElementById('detail-department').textContent = data.bo_phan || '-';
        document.getElementById('detail-creator').textContent = data.nguoi_tao;
        document.getElementById('detail-approver').textContent = data.nguoi_duyet || '-';
        document.getElementById('detail-approve-date').textContent = data.ngay_duyet ? formatDate(data.ngay_duyet) : '-';
        document.getElementById('detail-note').textContent = data.ghi_chu || '-';
        document.getElementById('detail-status').innerHTML = getStatusBadge(data.trang_thai);

        // Hiển thị sản phẩm
        const tbody = document.getElementById('detail-products-body');
        if (data.san_phams && data.san_phams.length > 0) {
            tbody.innerHTML = data.san_phams.map(sp => `
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-600">${sp.ma_san_pham}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${sp.ten_hang_hoa}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-center">${sp.so_luong}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-right">${formatCurrency(sp.gia_xuat)}</td>
                    <td class="px-4 py-3 text-sm font-medium text-navy-700 text-right">${formatCurrency(sp.thanh_tien)}</td>
                </tr>
            `).join('');

            document.getElementById('detail-total-qty').textContent = data.tong_so_luong;
            document.getElementById('detail-total-amount').textContent = formatCurrency(data.tong_gia_tri);
        }

        // Hiển thị nút duyệt nếu phiếu đang chờ duyệt và user có quyền
        const approvalDiv = document.getElementById('approval-buttons');
        if (data.trang_thai === 0 && (currentUser.vai_tro === 'QUAN_LY' || currentUser.vai_tro === 'ADMIN')) {
            approvalDiv.classList.remove('hidden');
        } else {
            approvalDiv.classList.add('hidden');
        }

        currentDetailId = data.ma_phieu_xuat;
    }

    // ==================== PRODUCT MANAGEMENT ====================
    window.selectProductFromTable = function(row) {
        const productId = row.dataset.id;
        const productCode = row.dataset.code;
        const productName = row.dataset.name;
        const productPrice = parseFloat(row.dataset.price);
        const productStock = parseInt(row.dataset.stock);

        addProductToExportList({
            ma_hang_hoa: parseInt(productId),
            ma_san_pham: productCode,
            ten_hang_hoa: productName,
            gia_xuat: productPrice,
            ton_kho: productStock
        });

        // Highlight dòng được chọn
        document.querySelectorAll('#product-choose-body tr').forEach(r => {
            r.classList.remove('bg-blue-50');
        });
        row.classList.add('bg-blue-50');
    };

    window.addToExportList = function(event, button) {
        event.stopPropagation();
        const row = button.closest('tr');
        selectProductFromTable(row);
    };

    function addProductToExportList(product) {
        // Kiểm tra sản phẩm đã có chưa
        const existing = exportProducts.find(p => p.ma_hang_hoa === product.ma_hang_hoa);
        if (existing) {
            existing.so_luong++;
            existing.thanh_tien = existing.so_luong * existing.gia_xuat;
        } else {
            exportProducts.push({
                ...product,
                so_luong: 1,
                thanh_tien: product.gia_xuat
            });
        }

        currentSelectedPage = Math.ceil(exportProducts.length / selectedPerPage);
        renderExportProductsTable();
        updateSummary();
    }

    window.addEmptyRow = function() {
        // Tạo sản phẩm tạm thời
        const tempProduct = {
            ma_hang_hoa: Date.now(),
            ma_san_pham: 'TEMP',
            ten_hang_hoa: 'Nhập tay',
            gia_xuat: 0,
            ton_kho: 999999,
            so_luong: 1,
            thanh_tien: 0
        };
        exportProducts.push(tempProduct);
        
        currentSelectedPage = Math.ceil(exportProducts.length / selectedPerPage);
        renderExportProductsTable();
        updateSummary();
    };

    window.updateQuantity = function(productId, qty) {
        const product = exportProducts.find(p => p.ma_hang_hoa == productId);
        if (product) {
            const newQty = parseInt(qty) || 1;
            product.so_luong = Math.min(newQty, product.ton_kho);
            product.thanh_tien = product.so_luong * product.gia_xuat;
            renderExportProductsTable();
            updateSummary();
        }
    };

    window.removeProduct = function(productId) {
        exportProducts = exportProducts.filter(p => p.ma_hang_hoa != productId);
        
        if (exportProducts.length === 0) {
            currentSelectedPage = 1;
        } else if (currentSelectedPage > Math.ceil(exportProducts.length / selectedPerPage)) {
            currentSelectedPage = Math.ceil(exportProducts.length / selectedPerPage);
        }
        
        renderExportProductsTable();
        updateSummary();
    };

    function updateSummary() {
        const totalItems = exportProducts.length;
        const totalQuantity = exportProducts.reduce((sum, p) => sum + p.so_luong, 0);
        const totalValue = exportProducts.reduce((sum, p) => sum + p.thanh_tien, 0);

        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('total-quantity').textContent = totalQuantity;
        document.getElementById('total-value').textContent = formatCurrency(totalValue);
    }

    // ==================== PAGINATION FUNCTIONS ====================
    function updateProductPagination() {
        const totalPages = Math.ceil(allProducts.length / productsPerPage);
        const start = (currentProductPage - 1) * productsPerPage + 1;
        const end = Math.min(currentProductPage * productsPerPage, allProducts.length);

        document.getElementById('product-display-start').textContent = allProducts.length > 0 ? start : 0;
        document.getElementById('product-display-end').textContent = end;
        document.getElementById('product-total-rows').textContent = allProducts.length;
        document.getElementById('product-current-page').textContent = currentProductPage;
        document.getElementById('product-total-pages').textContent = totalPages || 1;

        document.getElementById('product-prev-btn').disabled = currentProductPage <= 1;
        document.getElementById('product-next-btn').disabled = currentProductPage >= totalPages;
    }

    function updateSelectedPagination() {
        const totalPages = Math.ceil(exportProducts.length / selectedPerPage);
        document.getElementById('selected-total-rows').textContent = exportProducts.length;
        document.getElementById('selected-current-page').textContent = currentSelectedPage;
        document.getElementById('selected-total-pages').textContent = totalPages || 1;

        document.getElementById('selected-prev-btn').disabled = currentSelectedPage <= 1;
        document.getElementById('selected-next-btn').disabled = currentSelectedPage >= totalPages;
    }

    // ==================== VIEW NAVIGATION ====================
    window.showCreateForm = function() {
        document.getElementById('list-view').classList.add('hidden');
        document.getElementById('create-view').classList.remove('hidden');
        document.getElementById('detail-view').classList.add('hidden');
        
        // Reset form
        document.getElementById('export-code').value = 'Tự động tạo';
        document.getElementById('export-date').value = new Date().toISOString().split('T')[0];
        document.getElementById('export-warehouse').value = '';
        document.getElementById('receiver').value = '';
        document.getElementById('department').value = '';
        document.getElementById('export-note').value = '';
        
        exportProducts = [];
        currentSelectedPage = 1;
        renderExportProductsTable();
        updateSummary();
        loadProductListForChoose();
    };

    window.showListView = function() {
        document.getElementById('list-view').classList.remove('hidden');
        document.getElementById('create-view').classList.add('hidden');
        document.getElementById('detail-view').classList.add('hidden');
        loadExportList();
    };

    window.showDetailView = function() {
        document.getElementById('list-view').classList.add('hidden');
        document.getElementById('create-view').classList.add('hidden');
        document.getElementById('detail-view').classList.remove('hidden');
    };

    // ==================== EVENT HANDLERS ====================
    window.viewExport = function(id) {
        showDetailView();
        loadExportDetail(id);
    };

    window.editExport = function(id) {
        showToast('Tính năng đang phát triển', 'info');
    };

    window.openDeleteModal = function(id) {
        deleteTargetId = id;
        document.getElementById('delete-modal').classList.remove('hidden');
    };

    window.closeDeleteModal = function() {
        document.getElementById('delete-modal').classList.add('hidden');
        deleteTargetId = null;
    };

    window.confirmDelete = function() {
        if (deleteTargetId) {
            deleteExport(deleteTargetId);
            closeDeleteModal();
        }
    };

    // Filter functions
    function applyFilters() {
        const search = document.getElementById('search-input').value.toLowerCase();
        const warehouse = document.getElementById('warehouse-filter').value;
        const status = document.getElementById('status-filter').value;
        const dateFrom = document.getElementById('date-from').value;
        const dateTo = document.getElementById('date-to').value;

        const filtered = exportList.filter(item => {
            if (search && !item.ma_phieu.toLowerCase().includes(search)) return false;
            if (warehouse && item.ma_kho != warehouse) return false;
            if (status !== '' && item.trang_thai != status) return false;
            if (dateFrom && new Date(item.ngay_tao) < new Date(dateFrom)) return false;
            if (dateTo) {
                const toDate = new Date(dateTo);
                toDate.setHours(23, 59, 59);
                if (new Date(item.ngay_tao) > toDate) return false;
            }
            return true;
        });

        // Hiển thị kết quả lọc trực tiếp (không phân trang)
        const tbody = document.getElementById('export-table-body');
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center py-10 text-gray-500">Không tìm thấy kết quả</td></tr>';
        } else {
            tbody.innerHTML = filtered.map(item => `
                <tr class="table-row-hover">
                    <td class="px-4 py-3 text-sm font-medium text-navy-700">${item.ma_phieu}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${formatDate(item.ngay_tao)}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${item.ten_kho}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${item.nguoi_nhan}<br><span class="text-xs text-gray-400">${item.bo_phan || ''}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-center">${item.so_mat_hang}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-center">${item.tong_so_luong}</td>
                    <td class="px-4 py-3 text-sm font-medium text-navy-700 text-right">${formatCurrency(item.tong_gia_tri)}</td>
                    <td class="px-4 py-3 text-center">${getStatusBadge(item.trang_thai)}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${item.nguoi_tao}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <button onclick="viewExport(${item.ma_phieu_xuat})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg btn-transition">👁️</button>
                            ${item.trang_thai === 0 ? `
                                <button onclick="editExport(${item.ma_phieu_xuat})" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg btn-transition">✏️</button>
                                <button onclick="openDeleteModal(${item.ma_phieu_xuat})" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg btn-transition">🗑️</button>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `).join('');
        }
    }

    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
        // Load initial data
        loadExportList();
        loadWarehouses();

        // Set current date
        document.getElementById('export-date').value = new Date().toISOString().split('T')[0];

        // Setup event listeners
        document.getElementById('create-export-btn').addEventListener('click', showCreateForm);
        document.getElementById('back-to-list').addEventListener('click', showListView);
        document.getElementById('back-to-list-from-detail').addEventListener('click', showListView);
        document.getElementById('back-to-list-btn').addEventListener('click', showListView);
        document.getElementById('cancel-btn').addEventListener('click', showListView);
        document.getElementById('save-draft-btn').addEventListener('click', () => saveExport(0));
        document.getElementById('submit-btn').addEventListener('click', () => saveExport(1));
        document.getElementById('add-empty-row').addEventListener('click', addEmptyRow);
        document.getElementById('refresh-btn').addEventListener('click', () => {
            document.getElementById('search-input').value = '';
            document.getElementById('warehouse-filter').value = '';
            document.getElementById('status-filter').value = '';
            document.getElementById('date-from').value = '';
            document.getElementById('date-to').value = '';
            loadExportList();
        });

        // Filter events
        document.getElementById('search-input').addEventListener('input', applyFilters);
        document.getElementById('warehouse-filter').addEventListener('change', applyFilters);
        document.getElementById('status-filter').addEventListener('change', applyFilters);
        document.getElementById('date-from').addEventListener('change', applyFilters);
        document.getElementById('date-to').addEventListener('change', applyFilters);

        // Product search
        let searchTimeout;
        document.getElementById('product-search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadProductListForChoose(this.value.trim());
            }, 500);
        });

        document.getElementById('search-product-btn').addEventListener('click', function() {
            const searchTerm = document.getElementById('product-search').value.trim();
            loadProductListForChoose(searchTerm);
        });

        // Pagination events
        document.getElementById('product-prev-btn').addEventListener('click', () => {
            if (currentProductPage > 1) {
                currentProductPage--;
                renderProductChooseTable();
                updateProductPagination();
            }
        });

        document.getElementById('product-next-btn').addEventListener('click', () => {
            const totalPages = Math.ceil(allProducts.length / productsPerPage);
            if (currentProductPage < totalPages) {
                currentProductPage++;
                renderProductChooseTable();
                updateProductPagination();
            }
        });

        document.getElementById('selected-prev-btn').addEventListener('click', () => {
            if (currentSelectedPage > 1) {
                currentSelectedPage--;
                renderExportProductsTable();
            }
        });

        document.getElementById('selected-next-btn').addEventListener('click', () => {
            const totalPages = Math.ceil(exportProducts.length / selectedPerPage);
            if (currentSelectedPage < totalPages) {
                currentSelectedPage++;
                renderExportProductsTable();
            }
        });

        // Approval buttons
        document.getElementById('approve-btn').addEventListener('click', () => {
            if (currentDetailId) {
                updateExportStatus(currentDetailId, 1);
            }
        });

        document.getElementById('reject-btn').addEventListener('click', () => {
            if (currentDetailId) {
                updateExportStatus(currentDetailId, 2);
            }
        });

        // Modal close
        document.querySelector('.modal-overlay').addEventListener('click', closeDeleteModal);
    });

</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d77de30d28fe2e0',t:'MTc3MjcwMDU3My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
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