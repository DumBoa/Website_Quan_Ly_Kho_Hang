<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}

$ten = $_SESSION["ho_ten"];
$role = $_SESSION["vai_tro"];
$username = $_SESSION["ten_dang_nhap"];
?>

<!doctype html>
<html lang="vi" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản Lý Tồn Kho - WMS</title>
  
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Sử dụng dashboard.css để đồng bộ layout -->
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
          fontFamily: { 'inter': ['Inter', 'sans-serif'] }
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
    .input-focus:focus { outline: none; border-color: #334e68; box-shadow: 0 0 0 3px rgba(51,78,104,0.1); }
    .btn-transition { transition: all 0.2s ease; }
    .slide-in { animation: slideIn 0.3s ease; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
    .badge-low { background: #fef3c7; color: #d97706; }
    .badge-out { background: #fee2e2; color: #dc2626; }
    .badge-normal { background: #d1fae5; color: #059669; }
  </style>
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
      <!-- Nếu chưa có header.php, bạn có thể tạm thay bằng đoạn code header đơn giản bên dưới -->

      <!-- Main Content Area -->
      <main class="wms-content custom-scrollbar" id="main-content">

        <div class="content-header">
          <h1 class="page-title">Quản Lý Tồn Kho</h1>
          <p class="page-subtitle">Theo dõi số lượng hàng tồn, cảnh báo sắp hết hàng và giá trị kho hàng</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-card-header">
              <div class="stat-card-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
              </div>
            </div>
            <div class="stat-card-value" id="total-products">0</div>
            <div class="stat-card-label">Tổng sản phẩm</div>
          </div>

          <div class="stat-card">
            <div class="stat-card-header">
              <div class="stat-card-icon green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
              </div>
            </div>
            <div class="stat-card-value" id="total-quantity">0</div>
            <div class="stat-card-label">Tổng số lượng</div>
          </div>

          <div class="stat-card">
            <div class="stat-card-header">
              <div class="stat-card-icon orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 9v2m0 4v2m0 4v2M6.34 5.66L7.76 4.24M4.24 7.76L5.66 6.34m9.9-2.42l1.41 1.41M19.76 7.76l-1.41-1.41m-2.42 9.9l1.41 1.41M16.34 19.66l-1.41-1.41"/>
                </svg>
              </div>
            </div>
            <div class="stat-card-value" id="low-stock-count">0</div>
            <div class="stat-card-label">Sắp hết hàng</div>
          </div>

          <div class="stat-card">
            <div class="stat-card-header">
              <div class="stat-card-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
            </div>
            <div class="stat-card-value" id="total-value">0 ₫</div>
            <div class="stat-card-label">Tổng giá trị kho</div>
          </div>
        </div>

        <!-- Toolbar & Filters -->
        <div class="content-card mb-6">
          <div class="content-card-header">
            <h2 class="content-card-title">Danh sách tồn kho</h2>
          </div>
          <div class="content-card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
              <!-- Search -->
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <div class="relative">
                  <input type="text" id="search-input" placeholder="Mã / Tên sản phẩm..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm">
                  <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                </div>
              </div>

              <!-- Warehouse Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kho</label>
                <select id="warehouse-filter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">Tất cả kho</option>
                  <option value="kho1">Kho Hà Nội</option>
                  <option value="kho2">Kho Sài Gòn</option>
                  <option value="kho3">Kho Đà Nẵng</option>
                </select>
              </div>

              <!-- Category Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                <select id="category-filter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">Tất cả danh mục</option>
                  <option value="hanghoa">Hàng hóa</option>
                  <option value="vattu">Vật tư</option>
                  <option value="nguyenlieu">Nguyên liệu</option>
                </select>
              </div>

              <!-- Status Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select id="status-filter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg input-focus text-sm bg-white">
                  <option value="">Tất cả</option>
                  <option value="normal">Bình thường</option>
                  <option value="low-stock">Sắp hết</option>
                  <option value="out-of-stock">Hết hàng</option>
                </select>
              </div>

              <!-- Refresh Button -->
              <div class="flex items-end">
                <button id="refresh-btn" class="w-full py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                  Làm mới
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Inventory Table -->
        <div class="content-card">
          <div class="content-card-body p-0">
            <div class="overflow-x-auto">
              <table class="w-full text-left">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-6 py-4 font-medium text-gray-700">Mã SP</th>
                    <th class="px-6 py-4 font-medium text-gray-700">Tên sản phẩm</th>
                    <th class="px-6 py-4 font-medium text-gray-700">Danh mục</th>
                    <th class="px-6 py-4 font-medium text-gray-700">Kho</th>
                    <th class="px-6 py-4 font-medium text-gray-700 text-center">Tồn kho</th>
                    <th class="px-6 py-4 font-medium text-gray-700 text-center">Tồn tối thiểu</th>
                    <th class="px-6 py-4 font-medium text-gray-700 text-center">Trạng thái</th>
                    <th class="px-6 py-4 font-medium text-gray-700 text-center">Hành động</th>
                  </tr>
                </thead>
                <tbody id="inventory-table-body">
                  <!-- Dữ liệu sẽ được render bằng JS -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </main>

      <!-- Footer -->
      <footer class="wms-footer">
        <p class="footer-text">© 2026 Warehouse Management System — Developed for Academic Project</p>
      </footer>

    </div>
  </div>

  <!-- Toast Notification -->
  <div id="toast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
    <div class="px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 text-white">
      <span id="toast-message"></span>
    </div>
  </div>

  <!-- JavaScript -->
 <script>
    // ==================== CẤU HÌNH ====================
    const currentUser = {
        ma_nguoi_dung: <?php echo json_encode($ma_nguoi_dung ?? 0); ?>,
        ho_ten: <?php echo json_encode($ten ?? ''); ?>,
        vai_tro: <?php echo json_encode($role ?? ''); ?>
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let inventoryData = [];
    let filteredInventory = [];
    let khoList = [];
    let danhMucList = [];
    let currentPage = 1;
    const itemsPerPage = 15;

    // ==================== UTILITY FUNCTIONS ====================
    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
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
             text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3`;
        
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function getStockStatus(quantity, minStock) {
        if (quantity <= 0) return 'out-of-stock';
        if (quantity <= minStock) return 'low-stock';
        return 'normal';
    }

    function getStatusBadge(status) {
        if (status === 'out-of-stock') return '<span class="badge badge-out">Hết hàng</span>';
        if (status === 'low-stock') return '<span class="badge badge-low">Sắp hết</span>';
        return '<span class="badge badge-normal">Bình thường</span>';
    }

    function getStatusText(status) {
        if (status === 'out-of-stock') return 'Hết hàng';
        if (status === 'low-stock') return 'Sắp hết';
        return 'Bình thường';
    }

    // ==================== API CALLS ====================
    async function loadInventory() {
        try {
            const search = document.getElementById('search-input')?.value || '';
            const ma_kho = document.getElementById('warehouse-filter')?.value || '';
            const ma_danh_muc = document.getElementById('category-filter')?.value || '';
            const trang_thai = document.getElementById('status-filter')?.value || '';

            let url = '../actions/TonKho/lay_danh_sach.php?';
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (ma_kho) params.append('ma_kho', ma_kho);
            if (ma_danh_muc) params.append('ma_danh_muc', ma_danh_muc);
            
            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                inventoryData = result.data;
                applyFilters(trang_thai);
                updateStatistics(result.thong_ke);
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading inventory:', error);
            showToast('Lỗi tải dữ liệu tồn kho', 'error');
        }
    }

    async function loadKhoList() {
        try {
            const response = await fetch('../actions/TonKho/lay_danh_sach_kho.php');
            const result = await response.json();
            
            if (result.success) {
                khoList = result.data;
                renderKhoOptions();
            }
        } catch (error) {
            console.error('Error loading kho list:', error);
        }
    }

    async function loadDanhMucList() {
        try {
            const response = await fetch('../actions/TonKho/lay_danh_sach_danh_muc.php');
            const result = await response.json();
            
            if (result.success) {
                danhMucList = result.data;
                renderDanhMucOptions();
            }
        } catch (error) {
            console.error('Error loading danh muc list:', error);
        }
    }

    async function loadChiTietTonKho(maHangHoa) {
        try {
            const response = await fetch(`../actions/TonKho/chi_tiet_ton_kho.php?ma_hang_hoa=${maHangHoa}`);
            const result = await response.json();

            if (result.success) {
                showChiTietModal(result.data);
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading detail:', error);
            showToast('Lỗi tải chi tiết', 'error');
        }
    }

    async function updateTonToiThieu(maHangHoa, tonToiThieu) {
        const formData = new FormData();
        formData.append('ma_hang_hoa', maHangHoa);
        formData.append('ton_toi_thieu', tonToiThieu);

        try {
            const response = await fetch('../actions/TonKho/cap_nhat_ton_toi_thieu.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                loadInventory(); // Reload data
                closeModal('editMinStockModal');
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error updating min stock:', error);
            showToast('Lỗi cập nhật tồn tối thiểu', 'error');
        }
    }

    function exportData(type) {
        const ma_kho = document.getElementById('warehouse-filter')?.value || '';
        const ma_danh_muc = document.getElementById('category-filter')?.value || '';
        
        let url = `../actions/TonKho/xuat_bao_cao.php?dinh_dang=${type}`;
        if (ma_kho) url += `&ma_kho=${ma_kho}`;
        if (ma_danh_muc) url += `&ma_danh_muc=${ma_danh_muc}`;
        
        window.location.href = url;
        showToast(`Đang xuất file ${type.toUpperCase()}...`, 'info');
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderKhoOptions() {
        const select = document.getElementById('warehouse-filter');
        select.innerHTML = '<option value="">Tất cả kho</option>' + 
            khoList.map(k => `<option value="${k.ma_kho}">${k.ten_kho}</option>`).join('');
    }

    function renderDanhMucOptions() {
        const select = document.getElementById('category-filter');
        select.innerHTML = '<option value="">Tất cả danh mục</option>' + 
            danhMucList.map(d => `<option value="${d.ma_danh_muc}">${d.ten_danh_muc}</option>`).join('');
    }

    function renderInventoryTable() {
        const tbody = document.getElementById('inventory-table-body');
        if (!tbody) return;

        if (filteredInventory.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-10 text-gray-500">Không có dữ liệu</td></tr>';
            return;
        }

        // Tính phân trang
        const start = (currentPage - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, filteredInventory.length);
        const paginatedData = filteredInventory.slice(start, end);

        tbody.innerHTML = paginatedData.map(item => {
            const status = getStockStatus(item.so_luong, item.ton_toi_thieu);
            return `
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium">${item.ma_san_pham || '---'}</td>
                    <td class="px-6 py-4">${item.ten_hang_hoa || 'Không có tên'}</td>
                    <td class="px-6 py-4">${item.ten_danh_muc || '---'}</td>
                    <td class="px-6 py-4">${item.ten_kho || '---'}</td>
                    <td class="px-6 py-4 text-center font-medium">${formatNumber(item.so_luong || 0)}</td>
                    <td class="px-6 py-4 text-center">${item.ton_toi_thieu || 5}</td>
                    <td class="px-6 py-4 text-center">${getStatusBadge(status)}</td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-600 hover:text-blue-800 mx-1" 
                                onclick="loadChiTietTonKho(${item.ma_hang_hoa})"
                                title="Xem chi tiết">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        ${currentUser.vai_tro === 'ADMIN' || currentUser.vai_tro === 'QUAN_LY' ? `
                            <button class="text-green-600 hover:text-green-800 mx-1" 
                                    onclick="openEditMinStockModal(${item.ma_hang_hoa}, ${item.ton_toi_thieu}, '${item.ten_hang_hoa}')"
                                    title="Cập nhật tồn tối thiểu">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `;
        }).join('');

        updatePagination();
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredInventory.length / itemsPerPage);
        const start = (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, filteredInventory.length);

        // Kiểm tra xem có element phân trang không
        const paginationContainer = document.querySelector('.pagination-container');
        if (!paginationContainer) return;

        let paginationHtml = `
            <div class="flex items-center justify-between mt-4">
                <div class="text-sm text-gray-600">
                    Hiển thị <span class="font-medium">${filteredInventory.length > 0 ? start : 0}</span> - 
                    <span class="font-medium">${end}</span> trong 
                    <span class="font-medium">${filteredInventory.length}</span> sản phẩm
                </div>
                <div class="flex items-center gap-2">
        `;

        paginationHtml += `<button onclick="changePage(${currentPage - 1})" 
            class="px-3 py-1 border rounded ${currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'}" 
            ${currentPage <= 1 ? 'disabled' : ''}>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>`;

        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                paginationHtml += `<button onclick="changePage(${i})" 
                    class="px-3 py-1 border rounded ${i === currentPage ? 'bg-navy-700 text-white' : 'hover:bg-gray-100'}">
                    ${i}
                </button>`;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                paginationHtml += `<span class="px-2">...</span>`;
            }
        }

        paginationHtml += `<button onclick="changePage(${currentPage + 1})" 
            class="px-3 py-1 border rounded ${currentPage >= totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'}" 
            ${currentPage >= totalPages ? 'disabled' : ''}>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>`;

        paginationHtml += '</div></div>';
        paginationContainer.innerHTML = paginationHtml;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredInventory.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderInventoryTable();
    }

    function updateStatistics(thongKe) {
        document.getElementById('total-products').textContent = formatNumber(thongKe.tong_san_pham || 0);
        document.getElementById('total-quantity').textContent = formatNumber(thongKe.tong_so_luong || 0);
        document.getElementById('low-stock-count').textContent = formatNumber(thongKe.sap_het || 0);
        document.getElementById('total-value').textContent = formatCurrency(thongKe.tong_gia_tri || 0);
    }

    function applyFilters(statusFilter = null) {
        const search = document.getElementById('search-input')?.value.toLowerCase() || '';
        const ma_kho = document.getElementById('warehouse-filter')?.value || '';
        const ma_danh_muc = document.getElementById('category-filter')?.value || '';
        const trang_thai = statusFilter || document.getElementById('status-filter')?.value || '';

        filteredInventory = inventoryData.filter(item => {
            // Filter by search
            if (search && !item.ma_san_pham.toLowerCase().includes(search) && 
                !item.ten_hang_hoa.toLowerCase().includes(search)) {
                return false;
            }
            // Filter by warehouse
            if (ma_kho && item.ma_kho != ma_kho) return false;
            // Filter by category
            if (ma_danh_muc && item.ma_danh_muc != ma_danh_muc) return false;
            // Filter by status
            if (trang_thai && item.trang_thai_ton !== trang_thai) return false;
            
            return true;
        });

        currentPage = 1;
        renderInventoryTable();
    }

    // ==================== MODAL FUNCTIONS ====================
    function showChiTietModal(data) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailModalContent');
        
        const sp = data.thong_tin_sp;
        const tongNhap = sp.tong_nhap || 0;
        const tongXuat = sp.tong_xuat || 0;
        const tonDauKy = data.tong_so_luong - tongNhap + tongXuat;

        content.innerHTML = `
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Mã sản phẩm</p>
                        <p class="font-medium">${sp.ma_san_pham}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Tên sản phẩm</p>
                        <p class="font-medium">${sp.ten_hang_hoa}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Danh mục</p>
                        <p class="font-medium">${sp.ten_danh_muc || '---'}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Giá nhập</p>
                        <p class="font-medium">${formatCurrency(sp.gia_nhap)}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Giá bán</p>
                        <p class="font-medium">${formatCurrency(sp.gia_ban)}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Tồn tối thiểu</p>
                        <p class="font-medium">${sp.ton_toi_thieu}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="font-medium mb-3">Thống kê nhập xuất</h4>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-blue-50 p-3 rounded">
                            <p class="text-xs text-blue-600">Tồn đầu kỳ</p>
                            <p class="text-xl font-bold text-blue-700">${formatNumber(tonDauKy)}</p>
                        </div>
                        <div class="bg-green-50 p-3 rounded">
                            <p class="text-xs text-green-600">Tổng nhập</p>
                            <p class="text-xl font-bold text-green-700">${formatNumber(tongNhap)}</p>
                        </div>
                        <div class="bg-red-50 p-3 rounded">
                            <p class="text-xs text-red-600">Tổng xuất</p>
                            <p class="text-xl font-bold text-red-700">${formatNumber(tongXuat)}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="font-medium mb-3">Tồn kho theo kho</h4>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs">Kho</th>
                                <th class="px-3 py-2 text-right text-xs">Số lượng</th>
                                <th class="px-3 py-2 text-right text-xs">Giá trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.ton_kho_theo_kho.map(item => `
                                <tr class="border-b">
                                    <td class="px-3 py-2">${item.ten_kho}</td>
                                    <td class="px-3 py-2 text-right">${formatNumber(item.so_luong)}</td>
                                    <td class="px-3 py-2 text-right">${formatCurrency(item.so_luong * sp.gia_nhap)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                        <tfoot class="bg-gray-50 font-medium">
                            <tr>
                                <td class="px-3 py-2">Tổng cộng</td>
                                <td class="px-3 py-2 text-right">${formatNumber(data.tong_so_luong)}</td>
                                <td class="px-3 py-2 text-right">${formatCurrency(data.tong_gia_tri)}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
    }

    function openEditMinStockModal(maHangHoa, currentValue, tenSanPham) {
        document.getElementById('editMinStockId').value = maHangHoa;
        document.getElementById('editMinStockName').textContent = tenSanPham;
        document.getElementById('editMinStockValue').value = currentValue;
        document.getElementById('editMinStockModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function confirmEditMinStock() {
        const maHangHoa = document.getElementById('editMinStockId').value;
        const newValue = parseInt(document.getElementById('editMinStockValue').value);
        
        if (isNaN(newValue) || newValue < 0) {
            showToast('Giá trị không hợp lệ', 'error');
            return;
        }
        
        updateTonToiThieu(maHangHoa, newValue);
    }

    // ==================== SIDEBAR & DROPDOWN TOGGLE ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Khai báo các element
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const userDropdown = document.getElementById('userDropdown');
        const userTrigger = document.getElementById('userTrigger');
        
        // State
        let isSidebarCollapsed = false;
        let isMobile = window.innerWidth <= 768;
        
        // Kiểm tra các element tồn tại trước khi sử dụng
        if (sidebar && sidebarToggle) {
            
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
                    if (sidebar) {
                        sidebar.classList.remove('collapsed', 'mobile-open');
                    }
                    if (mobileOverlay) {
                        mobileOverlay.classList.remove('active');
                    }
                    isSidebarCollapsed = false;
                }
            }
            
            // Gắn sự kiện
            sidebarToggle.addEventListener('click', toggleSidebar);
            
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', closeMobileSidebar);
            }
            
            if (userTrigger) {
                userTrigger.addEventListener('click', toggleUserDropdown);
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
        }
    });

    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
        // Load dữ liệu
        loadKhoList();
        loadDanhMucList();
        loadInventory();

        // Gắn sự kiện filter
        document.getElementById('search-input')?.addEventListener('input', () => applyFilters());
        document.getElementById('warehouse-filter')?.addEventListener('change', () => applyFilters());
        document.getElementById('category-filter')?.addEventListener('change', () => applyFilters());
        document.getElementById('status-filter')?.addEventListener('change', () => applyFilters());

        // Refresh button
        document.getElementById('refresh-btn')?.addEventListener('click', () => {
            document.getElementById('search-input').value = '';
            document.getElementById('warehouse-filter').value = '';
            document.getElementById('category-filter').value = '';
            document.getElementById('status-filter').value = '';
            loadInventory();
            showToast('Đã làm mới dữ liệu', 'success');
        });

        // Export buttons
        document.querySelectorAll('[onclick^="exportData"]').forEach(btn => {
            const match = btn.getAttribute('onclick').match(/'([^']+)'/);
            if (match) {
                const type = match[1];
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    exportData(type);
                });
            }
        });

        // Close modals when clicking overlay
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.closest('.fixed').classList.add('hidden');
                }
            });
        });
    });
</script>
<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute inset-0 bg-black bg-opacity-50" onclick="closeModal('detailModal')"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b flex items-center justify-between bg-navy-700">
                <h3 class="text-lg font-semibold text-white">Chi tiết tồn kho</h3>
                <button onclick="closeModal('detailModal')" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="detailModalContent" class="p-6 overflow-y-auto" style="max-height: calc(90vh - 80px);">
                <!-- Content will be inserted by JS -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Min Stock Modal -->
<div id="editMinStockModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute inset-0 bg-black bg-opacity-50" onclick="closeModal('editMinStockModal')"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="px-6 py-4 border-b flex items-center justify-between bg-navy-700">
                <h3 class="text-lg font-semibold text-white">Cập nhật tồn tối thiểu</h3>
                <button onclick="closeModal('editMinStockModal')" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <input type="hidden" id="editMinStockId">
                <p class="mb-4">Sản phẩm: <span id="editMinStockName" class="font-medium"></span></p>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tồn tối thiểu</label>
                    <input type="number" id="editMinStockValue" min="0" class="w-full px-3 py-2 border rounded">
                </div>
                <div class="flex justify-end gap-2">
                    <button onclick="closeModal('editMinStockModal')" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Hủy
                    </button>
                    <button onclick="confirmEditMinStock()" class="px-4 py-2 bg-navy-700 text-white rounded hover:bg-navy-800">
                        Cập nhật
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm container cho phân trang -->
<div class="pagination-container"></div>
</body>

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