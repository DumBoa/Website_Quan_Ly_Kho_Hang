<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}
?>
<?php
$ten = $_SESSION["ho_ten"];
$role = $_SESSION["vai_tro"];
$username = $_SESSION["ten_dang_nhap"];
?>
<!doctype html>
<html lang="vi" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duyệt Phiếu Xuất Kho</title>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/CSS/duyetphieuxuat.css">
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
            inter: ['Inter', 'sans-serif']
          }
        }
      }
    }
  </script>
  <style>
   /* Đảm bảo phần nội dung chính có thể cuộn */
#pageContent {
  height: calc(100vh - 64px);  /* 64px là chiều cao topbar */
  overflow-y: auto;
  padding: 24px;
}

/* Hoặc nếu muốn đơn giản hơn */
.p-6 {
  overflow-y: auto;
  max-height: calc(100vh - 120px);
}

/* Đảm bảo bảng có thể cuộn ngang khi cần */
.overflow-x-auto {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full">
  <div class="wms-app">
   <!-- Sidebar -->
   
   
   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>
   
   <!-- Main Content -->
   <main class="wms-main">
    <!-- Topbar -->
    
    <?php include __DIR__ . "/../views/Layout/header.php"; ?>
    
    <!-- Page Content -->
    <div class="p-6" id="pageContent">
     <!-- List View -->
     <div id="listView">
      <!-- Breadcrumb & Title -->
      <div class="mb-6 animate-fade-in">
       <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="#" class="hover:text-navy-600">Trang chủ</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg><span class="text-gray-900">Duyệt phiếu xuất</span>
       </nav>
       <h1 class="text-2xl font-bold text-navy-900" id="pageTitle">DUYỆT PHIẾU XUẤT KHO</h1>
      </div><!-- Stats Cards -->
      <!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 animate-fade-in stats-cards">
    <div class="card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900" id="statChoDuyet">0</p>
                <p class="text-sm text-gray-500">Chờ duyệt</p>
            </div>
        </div>
    </div>
    
    <div class="card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900" id="statDaDuyet">0</p>
                <p class="text-sm text-gray-500">Đã duyệt</p>
            </div>
        </div>
    </div>
    
    <div class="card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900" id="statTuChoi">0</p>
                <p class="text-sm text-gray-500">Từ chối</p>
            </div>
        </div>
    </div>
    
    <div class="card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900" id="statTong">0</p>
                <p class="text-sm text-gray-500">Tổng phiếu</p>
            </div>
        </div>
    </div>
</div><!-- Filter Toolbar -->
      <div class="card p-5 mb-6 animate-fade-in">
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="lg:col-span-1">
         <label class="block text-sm font-medium text-gray-700 mb-1">Mã phiếu</label> <input type="text" placeholder="Nhập mã phiếu..." class="form-input" id="searchCode">
        </div>
        <div>
         <label class="block text-sm font-medium text-gray-700 mb-1">Kho xuất</label> <select class="form-select" id="filterWarehouse"> <option value="">Tất cả kho</option> <option value="KHO-HN">Kho Hà Nội</option> <option value="KHO-SG">Kho Sài Gòn</option> <option value="KHO-DN">Kho Đà Nẵng</option> </select>
        </div>
        <div>
         <label class="block text-sm font-medium text-gray-700 mb-1">Người nhận</label> <select class="form-select" id="filterSupplier"> <option value="">Tất cả người nhận</option> <option value="BP-KT">Bộ phận K/T</option> <option value="BP-HD">Bộ phận Hành động</option> <option value="BP-QL">Bộ phận Quản lý</option> </select>
        </div>
        <div>
         <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label> <select class="form-select" id="filterStatus"> <option value="">Tất cả</option> <option value="pending">Chờ duyệt</option> <option value="approved">Đã duyệt</option> <option value="rejected">Từ chối</option> </select>
        </div>
        <div>
         <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label> <input type="date" class="form-input" id="filterFromDate">
        </div>
        <div>
         <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label> <input type="date" class="form-input" id="filterToDate">
        </div>
       </div>
       <div class="flex justify-end mt-4 gap-3">
        <button class="btn btn-outline" onclick="resetFilters()">
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
         </svg> Làm mới </button> <button class="btn btn-primary" onclick="applyFilters()">
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
         </svg> Tìm kiếm </button>
       </div>
      </div><!-- Data Table -->
      <div class="card overflow-hidden animate-fade-in">
       <div class="overflow-x-auto">
        <table class="data-table" id="dataTable">
         <thead>
          <tr>
           <th><input type="checkbox" class="rounded" id="selectAll"></th>
           <th>Mã phiếu</th>
           <th>Ngày tạo</th>
           <th>Kho xuất</th>
           <th>Người nhận</th>
           <th>Số mặt hàng</th>
           <th>Tổng SL</th>
           <th>Tổng giá trị</th>
           <th>Người tạo</th>
           <th>Trạng thái</th>
           <th>Thao tác</th>
          </tr>
         </thead>
         <tbody id="tableBody">
          <!-- Data will be rendered here -->
         </tbody>
        </table>
       </div><!-- Pagination -->
       <!-- Pagination -->
<div class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
    <p class="text-sm text-gray-600">
        Hiển thị <span class="font-medium" id="displayStart">0</span>-<span class="font-medium" id="displayEnd">0</span> 
        trong <span class="font-medium" id="totalRecords">0</span> phiếu
    </p>
    <div class="pagination" id="paginationControls">
        <!-- Pagination buttons sẽ được render bằng JavaScript -->
    </div>
</div>
      </div>
     </div><!-- Detail View -->
     <div id="detailView" style="display: none;">
      <!-- Will be rendered dynamically -->
     </div>
    </div>
   </main><!-- Approval Modal -->
   <div class="modal-overlay" id="approvalModal">
    <div class="modal-content">
     <div class="p-5 border-b border-gray-100">
      <h3 class="text-lg font-semibold text-gray-900">Xác nhận duyệt phiếu</h3>
     </div>
     <div class="p-5">
      <p class="text-gray-600 mb-4">Bạn có chắc chắn muốn duyệt phiếu xuất <strong id="modalReceiptCode"></strong>?</p>
      <div class="mb-4">
       <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú duyệt</label> <textarea class="form-input" rows="3" placeholder="Nhập ghi chú (không bắt buộc)..." id="approvalNote"></textarea>
      </div>
      <div id="inventoryWarning" class="hidden bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
       <div class="flex items-start gap-2">
        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-6v0m0 0H9m3 0h3m-3 0v6m0-6v0m0 0v6" />
        </svg>
        <div class="text-sm">
         <p class="font-medium text-red-800">⚠️ Cảnh báo: Số lượng không đủ tồn kho</p>
         <p class="text-red-700 mt-1" id="inventoryWarningText"></p>
        </div>
       </div>
      </div>
     </div>
     <div class="p-5 border-t border-gray-100 flex justify-end gap-3">
      <button class="btn btn-outline" onclick="closeModal('approvalModal')">Hủy bỏ</button> <button class="btn btn-success" onclick="confirmApproval()">
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
       </svg> Xác nhận duyệt </button>
     </div>
    </div>
   </div><!-- Reject Modal -->
   <div class="modal-overlay" id="rejectModal">
    <div class="modal-content">
     <div class="p-5 border-b border-gray-100">
      <h3 class="text-lg font-semibold text-gray-900">Từ chối phiếu xuất</h3>
     </div>
     <div class="p-5">
      <p class="text-gray-600 mb-4">Bạn có chắc chắn muốn từ chối phiếu xuất <strong id="modalRejectCode"></strong>?</p>
      <div class="mb-4">
       <label class="block text-sm font-medium text-gray-700 mb-1">Lý do từ chối <span class="text-red-500">*</span></label> <textarea class="form-input" rows="3" placeholder="Nhập lý do từ chối..." id="rejectReason" required></textarea>
      </div>
     </div>
     <div class="p-5 border-t border-gray-100 flex justify-end gap-3">
      <button class="btn btn-outline" onclick="closeModal('rejectModal')">Hủy bỏ</button> <button class="btn btn-danger" onclick="confirmReject()">
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
       </svg> Xác nhận từ chối </button>
     </div>
    </div>
   </div><!-- Toast Notification -->
   <div class="toast" id="toast">
    <svg class="w-5 h-5" id="toastIcon" fill="none" stroke="currentColor" viewbox="0 0 24 24"></svg><span id="toastMessage"></span>
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
        page_title: 'DUYỆT PHIẾU XUẤT KHO'
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let allReceipts = [];
    let currentReceipt = null;
    let filteredData = [];
    let khoList = [];
    let currentPage = 1;
    const itemsPerPage = 10;

    // ==================== UTILITY FUNCTIONS ====================
    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        return date.toLocaleDateString('vi-VN');
    }

    function getStatusBadge(status) {
        switch (parseInt(status)) {
            case 0:
                return '<span class="badge badge-pending">Chờ duyệt</span>';
            case 1:
                return '<span class="badge badge-approved">Đã duyệt</span>';
            case 2:
                return '<span class="badge badge-rejected">Từ chối</span>';
            default:
                return '<span class="badge">Không xác định</span>';
        }
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
    async function loadReceiptList() {
        try {
            // Xây dựng URL với các tham số lọc
            const search = document.getElementById('searchCode').value;
            const ma_kho = document.getElementById('filterWarehouse').value;
            const nguoi_nhan = document.getElementById('filterSupplier').value;
            const trang_thai = document.getElementById('filterStatus').value;
            const tu_ngay = document.getElementById('filterFromDate').value;
            const den_ngay = document.getElementById('filterToDate').value;

            let url = '../actions/DuyetPhieuXuat/lay_danh_sach.php?';
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (ma_kho) params.append('ma_kho', ma_kho);
            if (nguoi_nhan) params.append('nguoi_nhan', nguoi_nhan);
            if (trang_thai !== '') params.append('trang_thai', trang_thai);
            if (tu_ngay) params.append('tu_ngay', tu_ngay);
            if (den_ngay) params.append('den_ngay', den_ngay);
            
            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                allReceipts = result.data;
                filteredData = [...allReceipts];
                renderTable();
                updateStats(result.counts || {
                    cho_duyet: 0,
                    da_duyet: 0,
                    tu_choi: 0,
                    tong: 0
                });
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading receipts:', error);
            showToast('Lỗi tải danh sách phiếu xuất', 'error');
        }
    }

    async function loadKhoList() {
        try {
            const response = await fetch('../actions/DuyetPhieuXuat/lay_danh_sach_kho.php');
            const result = await response.json();

            if (result.success) {
                khoList = result.data;
                renderKhoOptions();
            }
        } catch (error) {
            console.error('Error loading kho list:', error);
        }
    }

    async function loadReceiptDetail(id) {
        try {
            const response = await fetch(`../actions/DuyetPhieuXuat/chi_tiet_phieu_xuat.php?ma_phieu_xuat=${id}`);
            const result = await response.json();

            if (result.success) {
                currentReceipt = result.data;
                renderDetailView();
                // Kiểm tra tồn kho nếu phiếu đang chờ duyệt
                if (currentReceipt.trang_thai === 0) {
                    checkInventory(id);
                }
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading receipt detail:', error);
            showToast('Lỗi tải chi tiết phiếu xuất', 'error');
        }
    }

    async function checkInventory(id) {
        try {
            const response = await fetch(`../actions/DuyetPhieuXuat/kiem_tra_ton_kho.php?ma_phieu_xuat=${id}`);
            const result = await response.json();

            if (result.success && result.has_warning) {
                showInventoryWarning(result.warnings);
            }
        } catch (error) {
            console.error('Error checking inventory:', error);
        }
    }

    async function updateReceiptStatus(id, status, lyDo = '') {
        const formData = new FormData();
        formData.append('ma_phieu_xuat', id);
        formData.append('trang_thai', status);
        if (lyDo) {
            formData.append('ly_do', lyDo);
        }

        try {
            const response = await fetch('../actions/DuyetPhieuXuat/cap_nhat_trang_thai.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                // Cập nhật lại danh sách
                await loadReceiptList();
                // Nếu đang ở detail view, quay lại list
                if (document.getElementById('detailView').style.display === 'block') {
                    backToList();
                }
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error updating status:', error);
            showToast('Lỗi cập nhật trạng thái', 'error');
        }
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderKhoOptions() {
        const select = document.getElementById('filterWarehouse');
        select.innerHTML = '<option value="">Tất cả kho</option>' + 
            khoList.map(k => `<option value="${k.ma_kho}">${k.ten_kho}</option>`).join('');
    }

    function renderTable() {
    const tbody = document.getElementById('tableBody');
    
    if (!tbody) return;

    if (filteredData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="11" class="text-center py-10 text-gray-500">Không có dữ liệu</td></tr>';
        return;
    }

    // Tính phân trang
    const start = (currentPage - 1) * itemsPerPage;
    const end = Math.min(start + itemsPerPage, filteredData.length);
    const paginatedData = filteredData.slice(start, end);

    tbody.innerHTML = paginatedData.map(item => `
        <tr class="${item.trang_thai === 0 ? 'bg-amber-50/50' : ''}">
            <td>
                <input type="checkbox" class="rounded row-checkbox" data-id="${item.ma_phieu_xuat}">
            </td>
            <td>
                <a href="#" onclick="viewDetail(${item.ma_phieu_xuat})" class="text-navy-600 font-medium hover:underline">${item.ma_phieu}</a>
            </td>
            <td>${formatDate(item.ngay_tao)}</td>
            <td>${item.ten_kho}</td>
            <td>${item.nguoi_nhan} ${item.bo_phan ? '<br><span class="text-xs text-gray-400">' + item.bo_phan + '</span>' : ''}</td>
            <td class="text-center">${item.so_mat_hang}</td>
            <td class="text-center">${item.tong_so_luong}</td>
            <td class="text-right font-medium">${formatCurrency(item.tong_gia_tri)}</td>
            <td>${item.nguoi_tao}</td>
            <td>${getStatusBadge(item.trang_thai)}</td>
            <td>
                <div class="flex items-center gap-2">
                    <button class="btn btn-outline btn-sm btn-icon" onclick="viewDetail(${item.ma_phieu_xuat})" title="Xem chi tiết">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    ${item.trang_thai === 0 ? `
                        <button class="btn btn-success btn-sm btn-icon" onclick="openApprovalModal(${item.ma_phieu_xuat})" title="Duyệt phiếu">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                        <button class="btn btn-danger btn-sm btn-icon" onclick="openRejectModal(${item.ma_phieu_xuat})" title="Từ chối">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    ` : ''}
                </div>
            </td>
        </tr>
    `).join('');

    // Cập nhật phân trang
    updatePagination();
}

    function updatePagination() {
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(currentPage * itemsPerPage, filteredData.length);

    // Kiểm tra các element tồn tại trước khi set
    const displayStart = document.getElementById('displayStart');
    const displayEnd = document.getElementById('displayEnd');
    const totalRecords = document.getElementById('totalRecords');
    const paginationControls = document.getElementById('paginationControls');

    if (displayStart) {
        displayStart.textContent = filteredData.length > 0 ? start : 0;
    }
    if (displayEnd) {
        displayEnd.textContent = end;
    }
    if (totalRecords) {
        totalRecords.textContent = filteredData.length;
    }

    // Render các nút phân trang
    if (paginationControls) {
        let paginationHtml = '<button onclick="changePage(' + (currentPage - 1) + ')" ' + (currentPage <= 1 ? 'disabled' : '') + '>' +
            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>' +
            '</button>';

        // Hiển thị tối đa 5 nút số trang
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        if (startPage > 1) {
            paginationHtml += '<button onclick="changePage(1)">1</button>';
            if (startPage > 2) {
                paginationHtml += '<button disabled>...</button>';
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHtml += '<button disabled>...</button>';
            }
            paginationHtml += `<button onclick="changePage(${totalPages})">${totalPages}</button>`;
        }

        paginationHtml += '<button onclick="changePage(' + (currentPage + 1) + ')" ' + (currentPage >= totalPages ? 'disabled' : '') + '>' +
            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>' +
            '</button>';

        paginationControls.innerHTML = paginationHtml;
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

    function changePage(page) {
        if (page < 1 || page > Math.ceil(filteredData.length / itemsPerPage)) return;
        currentPage = page;
        renderTable();
    }

    function updateStats(counts) {
    const statChoDuyet = document.getElementById('statChoDuyet');
    const statDaDuyet = document.getElementById('statDaDuyet');
    const statTuChoi = document.getElementById('statTuChoi');
    const statTong = document.getElementById('statTong');

    if (statChoDuyet) statChoDuyet.textContent = counts.cho_duyet || 0;
    if (statDaDuyet) statDaDuyet.textContent = counts.da_duyet || 0;
    if (statTuChoi) statTuChoi.textContent = counts.tu_choi || 0;
    if (statTong) statTong.textContent = counts.tong || 0;
}

    function showInventoryWarning(warnings) {
        const warningDiv = document.getElementById('inventoryWarning');
        const warningText = document.getElementById('inventoryWarningText');
        
        let html = '<ul class="list-disc pl-4">';
        warnings.forEach(w => {
            html += `<li><strong>${w.ma_san_pham} - ${w.ten_hang_hoa}:</strong> Xuất ${w.so_luong_xuat} / Tồn ${w.ton_kho}</li>`;
        });
        html += '</ul>';
        
        warningText.innerHTML = html;
        warningDiv.classList.remove('hidden');
    }

    // ==================== DETAIL VIEW FUNCTIONS ====================
    function renderDetailView() {
        if (!currentReceipt) return;

        document.getElementById('listView').style.display = 'none';
        document.getElementById('detailView').style.display = 'block';

        const receipt = currentReceipt;
        const totalQty = receipt.san_phams ? receipt.san_phams.reduce((sum, p) => sum + p.so_luong, 0) : 0;
        const totalValue = receipt.san_phams ? receipt.san_phams.reduce((sum, p) => sum + p.thanh_tien, 0) : 0;

        document.getElementById('detailView').innerHTML = `
            <div class="animate-fade-in">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Trang chủ</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Duyệt phiếu xuất</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900">${receipt.ma_phieu}</span>
                </nav>
                
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-navy-900">CHI TIẾT PHIẾU XUẤT</h1>
                    <button class="btn btn-outline" onclick="backToList()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Receipt Info -->
                    <div class="lg:col-span-2 card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Thông tin phiếu xuất
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                            <div class="info-row">
                                <span class="info-label">Mã phiếu:</span>
                                <span class="info-value text-navy-600">${receipt.ma_phieu}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ngày tạo:</span>
                                <span class="info-value">${formatDate(receipt.ngay_tao)}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kho xuất:</span>
                                <span class="info-value">${receipt.ten_kho}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Người nhận:</span>
                                <span class="info-value">${receipt.nguoi_nhan}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Bộ phận:</span>
                                <span class="info-value">${receipt.bo_phan || '—'}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Người tạo:</span>
                                <span class="info-value">${receipt.nguoi_tao}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Trạng thái:</span>
                                <span class="info-value">${getStatusBadge(receipt.trang_thai)}</span>
                            </div>
                            <div class="info-row md:col-span-2">
                                <span class="info-label">Ghi chú:</span>
                                <span class="info-value">${receipt.ghi_chu || 'Không có ghi chú'}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="summary-card">
                        <h3 class="text-lg font-semibold mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Tổng kết phiếu
                        </h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="summary-item">
                                <div class="summary-value">${receipt.so_mat_hang}</div>
                                <div class="summary-label">Mặt hàng</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-value">${receipt.tong_so_luong}</div>
                                <div class="summary-label">Tổng SL</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-value">${(receipt.tong_gia_tri / 1000000).toFixed(1)}M</div>
                                <div class="summary-label">Tổng tiền</div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-white/20">
                            <div class="text-center">
                                <div class="text-sm opacity-80 mb-1">Tổng giá trị phiếu</div>
                                <div class="text-2xl font-bold">${formatCurrency(receipt.tong_gia_tri)}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card overflow-hidden mb-6">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Danh sách sản phẩm trong phiếu
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-right">Giá xuất</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${receipt.san_phams && receipt.san_phams.length > 0 ? receipt.san_phams.map((product, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td class="font-medium text-navy-600">${product.ma_san_pham}</td>
                                        <td>${product.ten_hang_hoa}</td>
                                        <td class="text-center">${product.so_luong}</td>
                                        <td class="text-right">${formatCurrency(product.gia_xuat)}</td>
                                        <td class="text-right font-medium">${formatCurrency(product.thanh_tien)}</td>
                                    </tr>
                                `).join('') : '<tr><td colspan="6" class="text-center py-4">Không có sản phẩm</td></tr>'}
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50 font-semibold">
                                    <td colspan="3" class="text-right">Tổng cộng:</td>
                                    <td class="text-center">${receipt.tong_so_luong}</td>
                                    <td></td>
                                    <td class="text-right text-navy-600">${formatCurrency(receipt.tong_gia_tri)}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Approval Section -->
                ${receipt.trang_thai === 0 ? `
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Khu vực phê duyệt
                        </h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú duyệt</label>
                            <textarea class="form-input" rows="3" placeholder="Nhập ghi chú duyệt/từ chối (không bắt buộc khi duyệt)..." id="detailApprovalNote"></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-3">
                            <button class="btn btn-outline" onclick="backToList()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Quay lại
                            </button>
                            <button class="btn btn-danger" onclick="rejectFromDetail()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Từ chối
                            </button>
                            <button class="btn btn-success" onclick="approveFromDetail()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Duyệt phiếu
                            </button>
                        </div>
                    </div>
                ` : `
                    <div class="card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                ${receipt.trang_thai === 1 ? `
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Phiếu đã được duyệt</p>
                                        <p class="text-sm text-gray-500">Hàng hóa đã được xuất khỏi kho</p>
                                    </div>
                                ` : `
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Phiếu đã bị từ chối</p>
                                        <p class="text-sm text-gray-500">Lý do: ${receipt.ghi_chu ? receipt.ghi_chu.split('Lý do từ chối: ')[1] || receipt.ghi_chu : 'Không có lý do'}</p>
                                    </div>
                                `}
                            </div>
                            <button class="btn btn-outline" onclick="backToList()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Quay lại
                            </button>
                        </div>
                    </div>
                `}
            </div>
        `;
    }

    // ==================== VIEW FUNCTIONS ====================
    window.viewDetail = function(id) {
        loadReceiptDetail(id);
    };

    window.backToList = function() {
        document.getElementById('listView').style.display = 'block';
        document.getElementById('detailView').style.display = 'none';
        currentReceipt = null;
    };

    // ==================== MODAL FUNCTIONS ====================
    window.openApprovalModal = function(id) {
        currentReceipt = allReceipts.find(item => item.ma_phieu_xuat == id);
        if (!currentReceipt) return;
        
        document.getElementById('modalReceiptCode').textContent = currentReceipt.ma_phieu;
        document.getElementById('approvalNote').value = '';
        document.getElementById('inventoryWarning').classList.add('hidden');
        document.getElementById('approvalModal').classList.add('active');
        
        // Kiểm tra tồn kho
        checkInventory(id);
    };

    window.openRejectModal = function(id) {
        currentReceipt = allReceipts.find(item => item.ma_phieu_xuat == id);
        if (!currentReceipt) return;
        
        document.getElementById('modalRejectCode').textContent = currentReceipt.ma_phieu;
        document.getElementById('rejectReason').value = '';
        document.getElementById('rejectModal').classList.add('active');
    };

    window.closeModal = function(modalId) {
        document.getElementById(modalId).classList.remove('active');
    };

    window.confirmApproval = function() {
        if (currentReceipt) {
            const note = document.getElementById('approvalNote').value;
            updateReceiptStatus(currentReceipt.ma_phieu_xuat, 1, note);
            closeModal('approvalModal');
        }
    };

    window.confirmReject = function() {
        const reason = document.getElementById('rejectReason').value.trim();
        if (!reason) {
            showToast('Vui lòng nhập lý do từ chối!', 'error');
            return;
        }
        
        if (currentReceipt) {
            updateReceiptStatus(currentReceipt.ma_phieu_xuat, 2, reason);
            closeModal('rejectModal');
        }
    };

    window.approveFromDetail = function() {
        if (currentReceipt) {
            const note = document.getElementById('detailApprovalNote')?.value || '';
            updateReceiptStatus(currentReceipt.ma_phieu_xuat, 1, note);
        }
    };

    window.rejectFromDetail = function() {
        const note = document.getElementById('detailApprovalNote')?.value.trim();
        if (!note) {
            showToast('Vui lòng nhập lý do từ chối!', 'error');
            return;
        }
        
        if (currentReceipt) {
            updateReceiptStatus(currentReceipt.ma_phieu_xuat, 2, note);
        }
    };

    // ==================== FILTER FUNCTIONS ====================
    window.applyFilters = function() {
        currentPage = 1;
        loadReceiptList();
    };

    window.resetFilters = function() {
        document.getElementById('searchCode').value = '';
        document.getElementById('filterWarehouse').value = '';
        document.getElementById('filterSupplier').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';
        
        currentPage = 1;
        loadReceiptList();
        showToast('Đã làm mới bộ lọc', 'success');
    };

    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
        // Load initial data
        loadKhoList();
        loadReceiptList();

        // Setup select all checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Close modals on overlay click
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // Mobile menu toggle
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar')?.classList.toggle('open');
        });
    });

    // Element SDK
    if (window.elementSdk) {
        window.elementSdk.init({
            defaultConfig,
            onConfigChange: async (config) => {
                document.getElementById('pageTitle').textContent = config.page_title || defaultConfig.page_title;
            },
            mapToCapabilities: (config) => ({
                recolorables: [],
                borderables: [],
                fontEditable: undefined,
                fontSizeable: undefined
            }),
            mapToEditPanelValues: (config) => new Map([
                ['page_title', config.page_title || defaultConfig.page_title]
            ])
        });
    }

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

</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d7f4a7b250b07af',t:'MTc3Mjc3ODQwOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
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