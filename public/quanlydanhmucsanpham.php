<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}

// Include file kết nối
require_once '../config/config.php';

$ten = $_SESSION["ho_ten"] ?? '';
$role = $_SESSION["vai_tro"] ?? '';
$username = $_SESSION["ten_dang_nhap"] ?? '';
?>

<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMS - Quản lý danh mục</title>
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="/_sdk/element_sdk.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/CSS/quanlydanhmucsanpham.css">
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
                    <h1 class="page-title" id="pageTitle">QUẢN LÝ DANH MỤC</h1>
                </div>
                <button id="addCategoryBtn" class="btn-primary" style="margin-bottom: 0;">
                    <svg style="width: 18px; height: 18px; margin-right: 6px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span id="addButtonText">Thêm danh mục</span>
                </button>
            </div>

            <!-- Toolbar - Search & Filters -->
            <div class="content-card" style="margin-bottom: 24px;">
                <div class="content-card-body" style="padding: 16px;">
                    <div class="toolbar">
                        <!-- Search -->
                        <div class="toolbar-group">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên danh mục..." class="toolbar-search">
                        </div>
                        <!-- Status Filter -->
                        <div class="toolbar-group">
                            <select id="statusFilter" class="toolbar-select">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1">Hoạt động</option>
                                <option value="0">Ngừng hoạt động</option>
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

            <!-- Categories Table -->
            <div class="content-card">
                <div class="content-card-body" style="padding: 0; overflow-x: auto;">
                    <table class="categories-table">
                        <thead>
                        <tr>
                            <th>Mã danh mục</th>
                            <th>Tên danh mục</th>
                            <th>Số lượng sản phẩm</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody id="categoriesTableBody">
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#666;">
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

        <!-- Add/Edit Category Modal -->
        <div class="modal" id="categoryModal">
            <div class="modal-overlay" id="modalOverlay"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modalTitle">Thêm danh mục mới</h2>
                    <button class="modal-close" id="modalClose">×</button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" class="category-form">
                        <input type="hidden" id="categoryId" name="ma_danh_muc">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="categoryName">Tên danh mục <span style="color: red;">*</span></label>
                                <input type="text" id="categoryName" name="ten_danh_muc" placeholder="Nhập tên danh mục" required>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label for="categoryDescription">Mô tả</label>
                                <textarea id="categoryDescription" name="mo_ta" placeholder="Nhập mô tả danh mục..." rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-row full">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <div class="status-radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="trang_thai" value="1" checked>
                                        <span>Hoạt động</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="trang_thai" value="0">
                                        <span>Ngừng hoạt động</span>
                                    </label>
                                </div>
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
    // QUẢN LÝ DANH MỤC - JAVASCRIPT
    // ========================================

    // DOM Elements
    const categoryModal = document.getElementById('categoryModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalClose = document.getElementById('modalClose');
    const modalCancel = document.getElementById('modalCancel');
    const modalSave = document.getElementById('modalSave');
    const categoryForm = document.getElementById('categoryForm');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoriesTableBody = document.getElementById('categoriesTableBody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    // State
    let categories = [];
    let filteredCategories = [];
    let currentPage = 1;
    const itemsPerPage = 10;
    let isEditing = false;
    let currentEditId = null;

    // ========================================
    // LOAD DỮ LIỆU
    // ========================================

    async function loadCategories() {
        try {
            categoriesTableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px;">Đang tải dữ liệu...</td></tr>';

            const response = await fetch('../actions/QuanLyDanhMuc/lay_danh_sach.php');
            const data = await response.json();

            if (data.success) {
                categories = data.data || [];
                filteredCategories = [...categories];
                renderTable();
            } else {
                categoriesTableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px; color:#f00;">Lỗi: ' + (data.message || 'Không xác định') + '</td></tr>';
            }
        } catch (error) {
            console.error('Lỗi load danh mục:', error);
            categoriesTableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px; color:#f00;">Lỗi kết nối server</td></tr>';
        }
    }

    // ========================================
    // HIỂN THỊ BẢNG
    // ========================================

    function renderTable() {
        if (filteredCategories.length === 0) {
            categoriesTableBody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:40px; color:#666;">Không có danh mục nào</td></tr>';
            return;
        }

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = filteredCategories.slice(start, end);

        let html = '';

        pageData.forEach(cat => {
            const statusClass = cat.trang_thai == 1 ? 'active' : 'inactive';
            const statusText = cat.trang_thai == 1 ? 'Hoạt động' : 'Ngừng hoạt động';
            const ngayTao = cat.ngay_tao ? new Date(cat.ngay_tao).toLocaleDateString('vi-VN') : '';

            html += `
                <tr data-id="${cat.ma_danh_muc}">
                    <td><span class="category-id">${escapeHtml(cat.ma_danh_muc)}</span></td>
                    <td><strong>${escapeHtml(cat.ten_danh_muc)}</strong></td>
                    <td><span class="product-count">${cat.so_luong_san_pham || 0}</span></td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>${ngayTao}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action-edit" title="Sửa" onclick="editCategory(${cat.ma_danh_muc})">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button class="btn-action-delete" title="Xóa" onclick="deleteCategory(${cat.ma_danh_muc})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        categoriesTableBody.innerHTML = html;
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
        const totalPages = Math.ceil(filteredCategories.length / itemsPerPage) || 1;
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
        const totalPages = Math.ceil(filteredCategories.length / itemsPerPage);
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

        filteredCategories = categories.filter(cat => {
            // Search
            if (searchTerm) {
                const matchName = (cat.ten_danh_muc || '').toLowerCase().includes(searchTerm);
                if (!matchName) return false;
            }

            // Status filter
            if (status !== '') {
                if (cat.trang_thai != status) return false;
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
        loadCategories(); // Reload dữ liệu từ server

        refreshBtn.style.animation = 'spin 0.6s ease-in-out';
        setTimeout(() => {
            refreshBtn.style.animation = '';
        }, 600);
    });

    // ========================================
    // MODAL FUNCTIONS
    // ========================================

    function openModal() {
        categoryModal.classList.add('active');
    }

    function closeModal() {
        categoryModal.classList.remove('active');
        categoryForm.reset();
        document.querySelector('input[name="trang_thai"][value="1"]').checked = true;
        isEditing = false;
        currentEditId = null;
    }

    addCategoryBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').textContent = 'Thêm danh mục mới';
        modalSave.textContent = 'Thêm';
        document.getElementById('categoryId').value = '';
        openModal();
    });

    modalClose.addEventListener('click', closeModal);
    modalCancel.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', closeModal);

    // ========================================
    // SỬA DANH MỤC
    // ========================================

    window.editCategory = function(maDanhMuc) {
        const category = categories.find(c => c.ma_danh_muc == maDanhMuc);
        if (!category) return;

        document.getElementById('categoryId').value = category.ma_danh_muc;
        document.getElementById('categoryName').value = category.ten_danh_muc;
        document.getElementById('categoryDescription').value = category.mo_ta || '';

        if (category.trang_thai == 1) {
            document.querySelector('input[name="trang_thai"][value="1"]').checked = true;
        } else {
            document.querySelector('input[name="trang_thai"][value="0"]').checked = true;
        }

        document.getElementById('modalTitle').textContent = 'Chỉnh sửa danh mục';
        modalSave.textContent = 'Cập nhật';
        isEditing = true;
        currentEditId = maDanhMuc;

        openModal();
    };

    // ========================================
    // XÓA DANH MỤC
    // ========================================

    window.deleteCategory = async function(maDanhMuc) {
        if (!confirm('Bạn chắc chắn muốn xóa danh mục này?')) return;

        try {
            const response = await fetch('../actions/QuanLyDanhMuc/xoa_danh_muc.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ma_danh_muc=${maDanhMuc}`
            });

            const data = await response.json();

            if (data.success) {
                alert('Xóa thành công!');
                loadCategories();
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
        const categoryName = document.getElementById('categoryName').value.trim();

        if (!categoryName) {
            alert('Vui lòng nhập tên danh mục!');
            return;
        }

        const url = isEditing
            ? '../actions/QuanLyDanhMuc/sua_danh_muc.php'
            : '../actions/QuanLyDanhMuc/them_danh_muc.php';

        const formData = new FormData(categoryForm);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                closeModal();
                loadCategories();
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
        loadCategories();
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