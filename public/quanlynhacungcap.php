<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}

$ten = $_SESSION["ho_ten"] ?? '';
$role = $_SESSION["vai_tro"] ?? '';
$username = $_SESSION["ten_dang_nhap"] ?? '';
?>
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMS - Quản lý nhà cung cấp</title>
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="/_sdk/element_sdk.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/CSS/quanlynhacungcap.css">
    <style>body { box-sizing: border-box; }</style>
    <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
</head>
<body class="h-full">
<div class="wms-app">
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- SIDEBAR -->
    <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>

    <!-- MAIN CONTENT -->
    <div class="wms-main">
        <!-- HEADER -->
        <?php include __DIR__ . "/../views/Layout/header.php"; ?>

        <!-- MAIN CONTENT AREA -->
        <main class="wms-content">
            <!-- Page Header with Add Button -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <div class="content-header">
                    <h1 class="page-title" id="pageTitle">QUẢN LÝ NHÀ CUNG CẤP</h1>
                </div>
                <button id="addSupplierBtn" class="btn-primary" style="margin-bottom: 0;">
                    <svg style="width: 18px; height: 18px; margin-right: 6px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span id="addButtonText">Thêm nhà cung cấp</span>
                </button>
            </div>

            <!-- Toolbar - Search & Filters -->
            <div class="content-card" style="margin-bottom: 24px;">
                <div class="content-card-body" style="padding: 16px;">
                    <div class="toolbar">
                        <!-- Search -->
                        <div class="toolbar-group">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên / mã / SĐT..." class="toolbar-search">
                        </div>
                        <!-- Status Filter -->
                        <div class="toolbar-group">
                            <select id="statusFilter" class="toolbar-select">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1">Đang hợp tác</option>
                                <option value="0">Ngừng hợp tác</option>
                            </select>
                        </div>
                        <!-- Refresh Button -->
                        <button id="refreshBtn" class="btn-refresh">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <path d="M20.49 15a9 9 0 11-2-8.12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Suppliers Table -->
            <div class="content-card">
                <div class="content-card-body" style="padding: 0; overflow-x: auto;">
                    <table class="suppliers-table">
                        <thead>
                        <tr>
                            <th>Mã NCC</th>
                            <th>Tên nhà cung cấp</th>
                            <th>Người liên hệ</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody id="suppliersTableBody">
                        <tr>
                            <td colspan="9" style="text-align:center; padding:40px; color:#666;">
                                Đang tải dữ liệu...
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" id="prevBtn" disabled>← Trước</button>
                <div class="pagination-info">
                    <span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">1</strong></span>
                </div>
                <button class="pagination-btn" id="nextBtn" disabled>Tiếp theo →</button>
            </div>
        </main>

        <!-- Add/Edit Supplier Modal -->
        <div class="modal" id="supplierModal">
            <div class="modal-overlay" id="modalOverlay"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalTitle">Thêm nhà cung cấp mới</h2>
                    <button class="modal-close" id="modalClose">×</button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm" class="supplier-form">
                        <input type="hidden" id="supplierId" name="ma_nha_cung_cap">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="supplierCode">Mã nhà cung cấp</label>
                                <input type="text" id="supplierCode" name="ma_nha_cung_cap_code" placeholder="Tự động" readonly class="bg-gray-100">
                            </div>
                            <div class="form-group">
                                <label for="supplierName">Tên nhà cung cấp <span style="color: red;">*</span></label>
                                <input type="text" id="supplierName" name="ten_nha_cung_cap" placeholder="Nhập tên nhà cung cấp" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contactName">Người liên hệ</label>
                                <input type="text" id="contactName" name="nguoi_lien_he" placeholder="Nhập tên người liên hệ">
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Số điện thoại <span style="color: red;">*</span></label>
                                <input type="tel" id="phoneNumber" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="emailAddress">Email</label>
                                <input type="email" id="emailAddress" name="email" placeholder="Nhập địa chỉ email">
                            </div>
                            <div class="form-group">
                                <label for="supplierStatus">Trạng thái</label>
                                <select id="supplierStatus" name="trang_thai" class="form-select">
                                    <option value="1">Đang hợp tác</option>
                                    <option value="0">Ngừng hợp tác</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <textarea id="address" name="dia_chi" placeholder="Nhập địa chỉ nhà cung cấp..." rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" id="modalCancel">Hủy</button>
                    <button class="btn-primary" id="modalSave">Lưu</button>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="wms-footer">
            <p class="footer-text" id="footerText">© 2026 Warehouse Management System — Developed for Academic Project</p>
        </footer>
    </div>
</div>

<script>
    // ========================================
    // QUẢN LÝ NHÀ CUNG CẤP - JAVASCRIPT
    // ========================================

    // DOM Elements
    const supplierModal = document.getElementById('supplierModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalClose = document.getElementById('modalClose');
    const modalCancel = document.getElementById('modalCancel');
    const modalSave = document.getElementById('modalSave');
    const supplierForm = document.getElementById('supplierForm');
    const addSupplierBtn = document.getElementById('addSupplierBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const suppliersTableBody = document.getElementById('suppliersTableBody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    // State
    let suppliers = [];
    let filteredSuppliers = [];
    let currentPage = 1;
    const itemsPerPage = 10;
    let isEditing = false;
    let currentEditId = null;

    // ========================================
    // LOAD DỮ LIỆU
    // ========================================

    async function loadSuppliers() {
        try {
            suppliersTableBody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:40px;">Đang tải dữ liệu...</td></tr>';

            const response = await fetch('../actions/QuanLyNhaCungCap/lay_danh_sach.php');
            const data = await response.json();

            if (data.success) {
                suppliers = data.data || [];
                filteredSuppliers = [...suppliers];
                renderTable();
            } else {
                suppliersTableBody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:40px; color:#f00;">Lỗi: ' + (data.message || 'Không xác định') + '</td></tr>';
            }
        } catch (error) {
            console.error('Lỗi load nhà cung cấp:', error);
            suppliersTableBody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:40px; color:#f00;">Lỗi kết nối server</td></tr>';
        }
    }

    // ========================================
    // HIỂN THỊ BẢNG
    // ========================================

    function renderTable() {
        if (filteredSuppliers.length === 0) {
            suppliersTableBody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:40px; color:#666;">Không có nhà cung cấp nào</td></tr>';
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = filteredSuppliers.slice(start, end);

        let html = '';

        pageData.forEach(supplier => {
            const statusClass = supplier.trang_thai == 1 ? 'active' : 'inactive';
            const statusText = supplier.trang_thai == 1 ? 'Đang hợp tác' : 'Ngừng hợp tác';
            const ngayTao = supplier.ngay_tao ? new Date(supplier.ngay_tao).toLocaleDateString('vi-VN') : '';

            html += `
                <tr data-id="${supplier.ma_nha_cung_cap}">
                    <td><span class="supplier-id">NCC-${String(supplier.ma_nha_cung_cap).padStart(3, '0')}</span></td>
                    <td><strong>${escapeHtml(supplier.ten_nha_cung_cap)}</strong></td>
                    <td>${escapeHtml(supplier.nguoi_lien_he || '—')}</td>
                    <td>${escapeHtml(supplier.so_dien_thoai || '—')}</td>
                    <td>${escapeHtml(supplier.email || '—')}</td>
                    <td>${escapeHtml(supplier.dia_chi || '—')}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>${ngayTao}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action-view" title="Xem chi tiết" onclick="viewSupplier(${supplier.ma_nha_cung_cap})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            </button>
                            <button class="btn-action-edit" title="Sửa" onclick="editSupplier(${supplier.ma_nha_cung_cap})">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button class="btn-action-delete" title="Xóa" onclick="deleteSupplier(${supplier.ma_nha_cung_cap})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        suppliersTableBody.innerHTML = html;
        updatePagination();
    }

    function escapeHtml(text) {
        if (!text && text !== 0) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // ========================================
    // PHÂN TRANG
    // ========================================

    function updatePagination() {
        const totalPages = Math.ceil(filteredSuppliers.length / itemsPerPage) || 1;
        document.getElementById('currentPage').textContent = currentPage;
        document.getElementById('totalPages').textContent = totalPages;

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    nextBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredSuppliers.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderTable();
        }
    });

    // ========================================
    // TÌM KIẾM VÀ LỌC
    // ========================================

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const status = statusFilter.value;

        filteredSuppliers = suppliers.filter(supplier => {
            // Search
            if (searchTerm) {
                const matchCode = `NCC-${String(supplier.ma_nha_cung_cap).padStart(3, '0')}`.toLowerCase().includes(searchTerm);
                const matchName = (supplier.ten_nha_cung_cap || '').toLowerCase().includes(searchTerm);
                const matchPhone = (supplier.so_dien_thoai || '').toLowerCase().includes(searchTerm);
                
                if (!matchCode && !matchName && !matchPhone) return false;
            }

            // Status filter
            if (status !== '') {
                if (supplier.trang_thai != status) return false;
            }

            return true;
        });

        currentPage = 1;
        renderTable();
    }

    searchInput.addEventListener('input', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

    refreshBtn.addEventListener('click', () => {
        searchInput.value = '';
        statusFilter.value = '';
        applyFilters();
        loadSuppliers();

        refreshBtn.style.animation = 'spin 0.6s ease-in-out';
        setTimeout(() => {
            refreshBtn.style.animation = '';
        }, 600);
    });

    // ========================================
    // MODAL FUNCTIONS
    // ========================================

    function openModal() {
        supplierModal.classList.add('active');
    }

    function closeModal() {
        supplierModal.classList.remove('active');
        supplierForm.reset();
        document.getElementById('supplierId').value = '';
        document.getElementById('supplierCode').value = '';
        document.getElementById('supplierStatus').value = '1';
        isEditing = false;
        currentEditId = null;
    }

    addSupplierBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').textContent = 'Thêm nhà cung cấp mới';
        modalSave.textContent = 'Thêm';
        document.getElementById('supplierCode').value = 'Tự động';
        openModal();
    });

    modalClose.addEventListener('click', closeModal);
    modalCancel.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', closeModal);

    // ========================================
    // XEM CHI TIẾT
    // ========================================

    window.viewSupplier = async function(maNhaCungCap) {
        try {
            const response = await fetch(`../actions/QuanLyNhaCungCap/chi_tiet_nha_cung_cap.php?ma_nha_cung_cap=${maNhaCungCap}`);
            const data = await response.json();

            if (data.success) {
                const supplier = data.data.supplier;
                const products = data.data.products;

                let productHtml = products.length > 0 
                    ? products.map(p => `- ${p.ma_san_pham}: ${p.ten_hang_hoa} (${p.so_luong} sản phẩm)`).join('\n')
                    : 'Không có sản phẩm nào';

                alert(`CHI TIẾT NHÀ CUNG CẤP\n\n` +
                      `Mã: NCC-${String(supplier.ma_nha_cung_cap).padStart(3, '0')}\n` +
                      `Tên: ${supplier.ten_nha_cung_cap}\n` +
                      `Người liên hệ: ${supplier.nguoi_lien_he || '—'}\n` +
                      `SĐT: ${supplier.so_dien_thoai || '—'}\n` +
                      `Email: ${supplier.email || '—'}\n` +
                      `Địa chỉ: ${supplier.dia_chi || '—'}\n` +
                      `Trạng thái: ${supplier.trang_thai == 1 ? 'Đang hợp tác' : 'Ngừng hợp tác'}\n` +
                      `Ngày tạo: ${new Date(supplier.ngay_tao).toLocaleDateString('vi-VN')}\n\n` +
                      `SẢN PHẨM CUNG CẤP:\n${productHtml}`);
            } else {
                alert('Lỗi: ' + (data.message || 'Không thể tải chi tiết'));
            }
        } catch (error) {
            alert('Lỗi kết nối: ' + error.message);
        }
    };

    // ========================================
    // SỬA NHÀ CUNG CẤP
    // ========================================

    window.editSupplier = function(maNhaCungCap) {
        const supplier = suppliers.find(s => s.ma_nha_cung_cap == maNhaCungCap);
        if (!supplier) return;

        document.getElementById('supplierId').value = supplier.ma_nha_cung_cap;
        document.getElementById('supplierCode').value = `NCC-${String(supplier.ma_nha_cung_cap).padStart(3, '0')}`;
        document.getElementById('supplierName').value = supplier.ten_nha_cung_cap || '';
        document.getElementById('contactName').value = supplier.nguoi_lien_he || '';
        document.getElementById('phoneNumber').value = supplier.so_dien_thoai || '';
        document.getElementById('emailAddress').value = supplier.email || '';
        document.getElementById('address').value = supplier.dia_chi || '';
        document.getElementById('supplierStatus').value = supplier.trang_thai || '1';

        document.getElementById('modalTitle').textContent = 'Chỉnh sửa nhà cung cấp';
        modalSave.textContent = 'Cập nhật';
        isEditing = true;
        currentEditId = maNhaCungCap;

        openModal();
    };

    // ========================================
    // XÓA NHÀ CUNG CẤP
    // ========================================

    window.deleteSupplier = async function(maNhaCungCap) {
        if (!confirm('Bạn chắc chắn muốn xóa nhà cung cấp này?')) return;

        try {
            const response = await fetch('../actions/QuanLyNhaCungCap/xoa_nha_cung_cap.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ma_nha_cung_cap=${maNhaCungCap}`
            });

            const data = await response.json();

            if (data.success) {
                alert('Xóa thành công!');
                loadSuppliers();
            } else {
                alert('Lỗi: ' + (data.message || 'Xóa thất bại'));
            }
        } catch (error) {
            alert('Lỗi kết nối: ' + error.message);
        }
    };

    // ========================================
    // LƯU (THÊM/SỬA)
    // ========================================

    modalSave.addEventListener('click', async () => {
        const supplierName = document.getElementById('supplierName').value.trim();
        const phoneNumber = document.getElementById('phoneNumber').value.trim();

        if (!supplierName) {
            alert('Vui lòng nhập tên nhà cung cấp!');
            return;
        }

        if (!phoneNumber) {
            alert('Vui lòng nhập số điện thoại!');
            return;
        }

        const url = isEditing
            ? '../actions/QuanLyNhaCungCap/sua_nha_cung_cap.php'
            : '../actions/QuanLyNhaCungCap/them_nha_cung_cap.php';

        const formData = new FormData(supplierForm);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                closeModal();
                loadSuppliers();
            } else {
                alert('Lỗi: ' + (data.message || 'Không xác định'));
            }
        } catch (error) {
            alert('Lỗi kết nối server: ' + error.message);
        }
    });

    // ========================================
    // LAYOUT FUNCTIONS
    // ========================================

    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const userDropdown = document.getElementById('userDropdown');
    const userTrigger = document.getElementById('userTrigger');

    let isSidebarCollapsed = false;
    let isMobile = window.innerWidth <= 768;

    function toggleSidebar() {
        if (isMobile) {
            sidebar.classList.toggle('mobile-open');
            mobileOverlay.classList.toggle('active');
        } else {
            isSidebarCollapsed = !isSidebarCollapsed;
            sidebar.classList.toggle('collapsed', isSidebarCollapsed);
        }
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        mobileOverlay.classList.remove('active');
    }

    function toggleUserDropdown(e) {
        e.stopPropagation();
        userDropdown.classList.toggle('open');
    }

    function closeUserDropdown() {
        userDropdown.classList.remove('open');
    }

    function handleResize() {
        const wasMobile = isMobile;
        isMobile = window.innerWidth <= 768;

        if (wasMobile !== isMobile) {
            sidebar.classList.remove('collapsed', 'mobile-open');
            mobileOverlay.classList.remove('active');
            isSidebarCollapsed = false;
        }
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMobileSidebar);
    }

    if (userTrigger) {
        userTrigger.addEventListener('click', toggleUserDropdown);
    }

    document.addEventListener('click', (e) => {
        if (userDropdown && !userDropdown.contains(e.target)) {
            closeUserDropdown();
        }
    });

    window.addEventListener('resize', handleResize);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeUserDropdown();
            if (isMobile) {
                closeMobileSidebar();
            }
            closeModal();
        }
    });

    handleResize();

    // ========================================
    // KHỞI TẠO
    // ========================================

    document.addEventListener('DOMContentLoaded', () => {
        loadSuppliers();
    });

    // Thêm animation spin
    const style = document.createElement('style');
    style.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
    document.head.appendChild(style);
</script>
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