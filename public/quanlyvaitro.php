<?php
session_start();

if (!isset($_SESSION["ma_nguoi_dung"])) {
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
  <title>Quản Lý Vai Trò</title>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
    rel="stylesheet">
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
    html,
    body {
      height: 100%;
      margin: 0;
      font-family: 'Inter', sans-serif;
    }

    .app-wrapper {
      height: 100%;
      width: 100%;
      overflow: auto;
      background: #f1f5f9;
    }

    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
    }

    .data-table th {
      background: #f8fafc;
      font-weight: 600;
      text-align: left;
      padding: 12px 16px;
      font-size: 13px;
      color: #334e68;
      border-bottom: 2px solid #e2e8f0;
      white-space: nowrap;
    }

    .data-table td {
      padding: 14px 16px;
      border-bottom: 1px solid #e2e8f0;
      font-size: 14px;
      color: #475569;
    }

    .data-table tbody tr:hover {
      background: #f8fafc;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }

    .badge-active {
      background: #d1fae5;
      color: #059669;
    }

    .badge-locked {
      background: #fee2e2;
      color: #dc2626;
    }

    .badge-admin {
      background: #dbeafe;
      color: #0284c7;
    }

    .badge-manager {
      background: #f3e8ff;
      color: #9333ea;
    }

    .badge-warehouse {
      background: #dcfce7;
      color: #16a34a;
    }

    .badge-staff {
      background: #f3f4f6;
      color: #6b7280;
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

    .btn-success {
      background: #059669;
      color: white;
    }

    .btn-success:hover {
      background: #047857;
    }

    .btn-danger {
      background: #dc2626;
      color: white;
    }

    .btn-danger:hover {
      background: #b91c1c;
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

    .btn-sm {
      padding: 6px 12px;
      font-size: 13px;
    }

    .btn-icon {
      padding: 6px 10px;
    }

    .form-input {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      font-size: 14px;
      transition: all 0.2s;
      background: white;
    }

    .form-input:focus {
      outline: none;
      border-color: #102a43;
      box-shadow: 0 0 0 3px rgba(16, 42, 67, 0.1);
    }

    .form-select {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      font-size: 14px;
      background: white;
      cursor: pointer;
    }

    .form-select:focus {
      outline: none;
      border-color: #102a43;
    }

    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

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
      max-width: 600px;
      width: 90%;
      max-height: 90vh;
      overflow: auto;
      transform: scale(0.9);
      transition: all 0.3s;
    }

    .modal-overlay.active .modal-content {
      transform: scale(1);
    }

    .pagination {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .pagination button {
      min-width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #e2e8f0;
      background: white;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .pagination button:hover:not(:disabled) {
      background: #f8fafc;
      border-color: #cbd5e1;
    }

    .pagination button.active {
      background: #102a43;
      color: white;
      border-color: #102a43;
    }

    .pagination button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .sidebar {
      width: 260px;
      background: #102a43;
      height: 100%;
      position: fixed;
      left: 0;
      top: 0;
      overflow-y: auto;
      z-index: 100;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      color: #9fb3c8;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.2s;
    }

    .sidebar-menu a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white;
    }

    .sidebar-menu a.active {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      border-left: 3px solid #38bdf8;
    }

    .main-content {
      margin-left: 260px;
      min-height: 100%;
    }

    .topbar {
      background: white;
      height: 64px;
      border-bottom: 1px solid #e2e8f0;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fadeIn 0.3s ease-out;
    }

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

    .avatar-preview {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      background: #f1f5f9;
      border: 2px solid #e2e8f0;
    }

    .avatar-upload {
      position: relative;
      width: fit-content;
    }

    .avatar-upload input[type="file"] {
      display: none;
    }

    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }
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
      margin-left: 260px;
      /* giá trị mặc định khi sidebar mở */
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      min-height: 100vh;
    }

    /* Khi sidebar collapsed */
    .wms-sidebar.collapsed+.main-content,
    .wms-sidebar.collapsed~.main-content {
      margin-left: 72px;
      /* giá trị khi sidebar thu gọn */
    }

    /* Đảm bảo topbar/header không bị che */
    .topbar,
    .header {
      margin-left: 260px;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: sticky;
      top: 0;
      z-index: 90;
      background: white;
    }

    .wms-sidebar.collapsed~.topbar,
    .wms-sidebar.collapsed~.header {
      margin-left: 72px;
    }

    /* Mobile responsive (giữ nguyên logic dashboard) */
    @media (max-width: 1024px) {
      .wms-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }

      .wms-sidebar.open {
        transform: translateX(0);
      }

      .main-content,
      .topbar,
      .header {
        margin-left: 0 !important;
      }
    }

    html,
    body {
      height: 100%;
      margin: 0;
      overflow: hidden;
      /* ← thêm dòng này */
      font-family: 'Inter', sans-serif;
    }

    .app-wrapper {
      height: 100vh;
      /* thay vì 100% */
      width: 100%;
      overflow: hidden;
      /* ← thêm dòng này */
      background: #f1f5f9;
      display: flex;
      /* ← rất quan trọng */
      flex-direction: row;
    }

    .main-content {
      margin-left: 260px;
      flex: 1;
      /* ← cho phép chiếm hết không gian còn lại */
      overflow-y: auto;
      /* ← đây là chìa khóa để scroll được */
      min-height: 100vh;
      padding-bottom: 40px;
      /* tránh nội dung bị che bởi toast */
    }

    /* Nếu bạn có .topbar sticky */
    .topbar {
      margin-left: 260px;
      width: calc(100% - 260px);
      /* ← rất quan trọng khi sidebar fixed */
      z-index: 50;
    }

    /* Khi sidebar collapse */
    .wms-sidebar.collapsed+.main-content,
    .wms-sidebar.collapsed~.main-content {
      margin-left: 72px;
    }

    .wms-sidebar.collapsed~.topbar,
    .wms-sidebar.collapsed~.header {
      margin-left: 72px;
      width: calc(100% - 72px);
    }
  </style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <style>
    body {
      box-sizing: border-box;
    }
  </style>
</head>

<body class="h-full">
  <div class="app-wrapper">
    <!-- Sidebar -->
    <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?><!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <?php include __DIR__ . "/../views/Layout/header.php"; ?>
      <!-- Page Content -->
      <div class="p-6" id="pageContent">
        <!-- List View -->
        <div id="listView">
          <!-- Breadcrumb & Title -->
          <div class="mb-6 animate-fade-in flex items-center justify-between">
            <div>
              <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="#" class="hover:text-navy-600">Trang chủ</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg><span class="text-gray-900">Vai trò</span>
              </nav>
              <h1 class="text-2xl font-bold text-navy-900" id="pageTitle">QUẢN LÝ VAI TRÒ</h1>
            </div><button class="btn btn-primary" onclick="openCreateModal()">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg> Thêm vai trò </button>
          </div><!-- Filter Toolbar -->
          <div class="card p-5 mb-6 animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label> <input type="text"
                  placeholder="Tên vai trò, mô tả..." class="form-input" id="searchInput">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label> <select
                  class="form-select" id="filterStatus">
                  <option value="">Tất cả</option>
                  <option value="active">Hoạt động</option>
                  <option value="inactive">Ngừng sử dụng</option>
                </select>
              </div>
              <div class="flex items-end">
                <button class="btn btn-outline w-full" onclick="resetFilters()">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg> Làm mới </button>
              </div>
            </div>
          </div><!-- Data Table -->
          <div class="card overflow-hidden animate-fade-in">
            <div class="overflow-x-auto">
              <table class="data-table" id="dataTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tên vai trò</th>
                    <th>Mô tả</th>
                    <th>Số người dùng</th>
                    <th>Ngày tạo</th>
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
                Hiển thị <span class="font-medium" id="displayStart">0</span>-<span class="font-medium"
                  id="displayEnd">0</span>
                trong <span class="font-medium" id="totalRoles">0</span> vai trò
              </p>
              <div class="pagination" id="paginationControls">
                <!-- Pagination buttons sẽ được render bằng JavaScript -->
              </div>
            </div>
          </div>
        </div><!-- Detail View -->
        <div id="detailView" style="display: none;">
          <!-- Will be rendered dynamically -->
        </div><!-- Create/Edit Form View -->
        <div id="formView" style="display: none;">
          <!-- Will be rendered dynamically -->
        </div>
      </div>
    </main><!-- Create User Modal -->
    <div class="modal-overlay" id="createModal">
      <div class="modal-content">
        <div class="p-5 border-b border-gray-100">
          <h3 class="text-lg font-semibold text-gray-900">Thêm vai trò mới</h3>
        </div>
        <div class="p-5 overflow-y-auto" style="max-height: calc(90vh - 120px);">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tên vai trò <span
                class="text-red-500">*</span></label> <input type="text" class="form-input" id="createName"
              placeholder="VD: Quản lý kho, Thủ kho...">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả vai trò</label> <textarea
              class="form-input" id="createDescription" rows="3" placeholder="Nhập mô tả vai trò..."></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label> <select class="form-select"
              id="createStatus">
              <option value="active">Hoạt động</option>
              <option value="inactive">Ngừng sử dụng</option>
            </select>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-semibold text-gray-900">Phân quyền chức năng</h3>
              <div class="flex gap-2"><button
                  class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100"
                  onclick="selectAllPermissions()">Chọn tất cả</button> <button
                  class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded hover:bg-gray-100"
                  onclick="deselectAllPermissions()">Bỏ chọn</button>
              </div>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-sm" style="border-collapse: collapse;">
                <thead>
                  <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th
                      style="padding: 10px 12px; text-align: left; font-weight: 600; color: #334e68; font-size: 13px;">
                      Chức năng</th>
                    <th
                      style="padding: 10px 12px; text-align: center; font-weight: 600; color: #334e68; font-size: 13px; width: 50px;">
                      Xem</th>
                    <th
                      style="padding: 10px 12px; text-align: center; font-weight: 600; color: #334e68; font-size: 13px; width: 50px;">
                      Thêm</th>
                    <th
                      style="padding: 10px 12px; text-align: center; font-weight: 600; color: #334e68; font-size: 13px; width: 50px;">
                      Sửa</th>
                    <th
                      style="padding: 10px 12px; text-align: center; font-weight: 600; color: #334e68; font-size: 13px; width: 50px;">
                      Xóa</th>
                    <th
                      style="padding: 10px 12px; text-align: center; font-weight: 600; color: #334e68; font-size: 13px; width: 50px;">
                      Duyệt</th>
                  </tr>
                </thead>
                <tbody id="permissionTable"><!-- Will be rendered by JS -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="p-5 border-t border-gray-100 flex justify-end gap-3">
          <button class="btn btn-outline" onclick="closeModal('createModal')">Hủy bỏ</button> <button
            class="btn btn-primary" onclick="saveRole('create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg> Lưu </button>
        </div>
      </div>
    </div><!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
      <div class="modal-content">
        <div class="p-5 border-b border-gray-100">
          <h3 class="text-lg font-semibold text-gray-900">Xác nhận xóa vai trò</h3>
        </div>
        <div class="p-5">
          <p class="text-gray-600">Bạn có chắc chắn muốn xóa vai trò <strong id="deleteRoleName"></strong>?</p>
          <p class="text-sm text-gray-500 mt-2">Hành động này không thể hoàn tác.</p>
        </div>
        <div class="p-5 border-t border-gray-100 flex justify-end gap-3">
          <button class="btn btn-outline" onclick="closeModal('deleteModal')">Hủy bỏ</button> <button
            class="btn btn-danger" onclick="confirmDelete()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg> Xóa vai trò </button>
        </div>
      </div>
    </div><!-- Lock/Unlock Confirmation Modal -->
    <div class="modal-overlay" id="lockModal">
      <div class="modal-content">
        <div class="p-5 border-b border-gray-100">
          <h3 class="text-lg font-semibold text-gray-900" id="lockModalTitle">Xác nhận thay đổi trạng thái</h3>
        </div>
        <div class="p-5">
          <p class="text-gray-600" id="lockModalMessage"></p>
        </div>
        <div class="p-5 border-t border-gray-100 flex justify-end gap-3">
          <button class="btn btn-outline" onclick="closeModal('lockModal')">Hủy bỏ</button> <button
            class="btn btn-primary" id="lockConfirmBtn" onclick="confirmLock()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg> Xác nhận </button>
        </div>
      </div>
    </div><!-- Toast Notification -->
    <div class="toast" id="toast">
      <svg class="w-5 h-5" id="toastIcon" fill="none" stroke="currentColor" viewbox="0 0 24 24"></svg><span
        id="toastMessage"></span>
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
      page_title: 'QUẢN LÝ VAI TRÒ'
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let allRoles = [];
    let filteredRoles = [];
    let functions = [];
    let actions = [];
    let currentRole = null;
    let roleToDelete = null;
    let roleToUpdate = null;
    let currentPage = 1;
    const itemsPerPage = 10;

    // ==================== UTILITY FUNCTIONS ====================
    function formatDate(dateStr) {
      if (!dateStr) return '-';
      const date = new Date(dateStr);
      return date.toLocaleDateString('vi-VN');
    }

    function getStatusBadge(status) {
      if (status == 1) {
        return '<span class="badge badge-active">Hoạt động</span>';
      } else {
        return '<span class="badge" style="background: #f3f4f6; color: #6b7280;">Ngừng sử dụng</span>';
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
    async function loadRoleList() {
      // Kiểm tra các element cần thiết
      if (!document.getElementById('displayStart') ||
        !document.getElementById('displayEnd') ||
        !document.getElementById('totalRoles') ||
        !document.getElementById('paginationControls')) {
        console.error('Pagination elements not found');
        return;
      }

      try {
        const search = document.getElementById('searchInput').value;
        const trang_thai = document.getElementById('filterStatus').value;

        let url = '../actions/QuanLyVaiTro/lay_danh_sach.php?';
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (trang_thai !== '') params.append('trang_thai', trang_thai === 'active' ? '1' : '0');

        const response = await fetch(url + params.toString());
        const result = await response.json();

        if (result.success) {
          allRoles = result.data;
          filteredRoles = [...allRoles];
          renderTable();
          if (document.getElementById('totalRoles')) {
            document.getElementById('totalRoles').textContent = allRoles.length;
          }
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error loading roles:', error);
        showToast('Lỗi tải danh sách vai trò', 'error');
      }
    }

    async function loadPermissions() {
      try {
        const response = await fetch('../actions/QuanLyVaiTro/lay_danh_sach_quyen.php');
        const result = await response.json();

        if (result.success) {
          functions = result.data.functions;
          actions = result.data.actions;
          renderPermissionTable();
        }
      } catch (error) {
        console.error('Error loading permissions:', error);
      }
    }

    async function loadRoleDetail(id) {
      try {
        const response = await fetch(`../actions/QuanLyVaiTro/chi_tiet_vai_tro.php?ma_vai_tro=${id}`);
        const result = await response.json();

        if (result.success) {
          currentRole = result.data;
          renderDetailView();
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error loading role detail:', error);
        showToast('Lỗi tải chi tiết vai trò', 'error');
      }
    }

    async function saveRole(type) {
      if (!validateForm()) return;

      const name = document.getElementById('createName').value.trim();
      const description = document.getElementById('createDescription').value.trim();
      const status = document.getElementById('createStatus').value === 'active' ? 1 : 0;
      const permissions = getSelectedPermissions();

      const formData = new FormData();
      formData.append('ten_vai_tro', name);
      formData.append('mo_ta', description);
      formData.append('trang_thai', status);
      formData.append('permissions', JSON.stringify(permissions));

      if (type === 'edit' && currentRole) {
        formData.append('ma_vai_tro', currentRole.ma_vai_tro);
      }

      try {
        const url = type === 'create'
          ? '../actions/QuanLyVaiTro/them_vai_tro.php'
          : '../actions/QuanLyVaiTro/cap_nhat_vai_tro.php';

        const response = await fetch(url, {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          showToast(result.message, 'success');
          closeModal('createModal');
          await loadRoleList();
          if (type === 'edit') {
            backToList();
          }
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error saving role:', error);
        showToast('Lỗi lưu vai trò', 'error');
      }
    }



    async function toggleRoleStatus(id, currentStatus) {
      try {
        const formData = new FormData();
        formData.append('ma_vai_tro', id);
        formData.append('trang_thai', currentStatus == 1 ? 0 : 1);

        const response = await fetch('../actions/QuanLyVaiTro/cap_nhat_trang_thai.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          showToast(result.message, 'success');
          closeModal('lockModal');
          await loadRoleList();
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error toggling role status:', error);
        showToast('Lỗi cập nhật trạng thái', 'error');
      }
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderTable() {
      const tbody = document.getElementById('tableBody');

      if (filteredRoles.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-10 text-gray-500">Không có dữ liệu</td></tr>';
        return;
      }

      // Tính phân trang
      const start = (currentPage - 1) * itemsPerPage;
      const end = Math.min(start + itemsPerPage, filteredRoles.length);
      const paginatedData = filteredRoles.slice(start, end);

      tbody.innerHTML = paginatedData.map(role => `
            <tr>
                <td>${role.ma_vai_tro}</td>
                <td class="font-medium text-gray-900">${role.ten_vai_tro}</td>
                <td>${role.mo_ta || '-'}</td>
                <td><span class="bg-blue-50 px-2 py-1 rounded text-sm text-blue-600 font-medium">${role.so_nguoi_dung} người</span></td>
                <td>${formatDate(role.ngay_tao)}</td>
                <td>${getStatusBadge(role.trang_thai)}</td>
                <td>
                    <div class="flex items-center gap-2">
                        <button class="btn btn-outline btn-sm btn-icon" onclick="viewDetail(${role.ma_vai_tro})" title="Xem chi tiết">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="btn btn-outline btn-sm btn-icon" onclick="editRole(${role.ma_vai_tro})" title="Chỉnh sửa">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        ${role.so_nguoi_dung === 0 ? `
                        <button class="btn btn-outline btn-sm btn-icon" onclick="deleteRole(${role.ma_vai_tro}, '${role.ten_vai_tro.replace(/'/g, "\\'")}')" title="Xóa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                               </svg>
                        </button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `).join('');

      updatePagination();
    }
    // Khởi tạo phân trang khi không có dữ liệu
    if (filteredRoles.length === 0) {
      if (document.getElementById('displayStart')) {
        document.getElementById('displayStart').textContent = '0';
      }
      if (document.getElementById('displayEnd')) {
        document.getElementById('displayEnd').textContent = '0';
      }
      if (document.getElementById('totalRoles')) {
        document.getElementById('totalRoles').textContent = '0';
      }
      if (document.getElementById('paginationControls')) {
        document.getElementById('paginationControls').innerHTML = '';
      }
    }
    function updatePagination() {
      const totalPages = Math.ceil(filteredRoles.length / itemsPerPage);
      const start = (currentPage - 1) * itemsPerPage + 1;
      const end = Math.min(currentPage * itemsPerPage, filteredRoles.length);

      // Kiểm tra các element tồn tại trước khi set
      const displayStart = document.getElementById('displayStart');
      const displayEnd = document.getElementById('displayEnd');
      const totalRolesEl = document.getElementById('totalRoles');
      const paginationControls = document.getElementById('paginationControls');

      if (displayStart) {
        displayStart.textContent = filteredRoles.length > 0 ? start : 0;
      }
      if (displayEnd) {
        displayEnd.textContent = end;
      }
      if (totalRolesEl) {
        totalRolesEl.textContent = filteredRoles.length;
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

    function changePage(page) {
      const totalPages = Math.ceil(filteredRoles.length / itemsPerPage);
      if (page < 1 || page > totalPages) return;
      currentPage = page;
      renderTable();
    }

    function renderPermissionTable() {
      const tbody = document.getElementById('permissionTable');
      if (!tbody) return;

      tbody.innerHTML = functions.map(func => `
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 10px 12px; text-align: left; font-size: 14px; color: #334e68;">${func.name}</td>
                ${actions.map(action => `
                    <td style="padding: 10px 12px; text-align: center;">
                        <input type="checkbox" 
                               data-function="${func.id}" 
                               data-permission="${action.id}" 
                               class="permission-checkbox" 
                               style="cursor: pointer; width: 16px; height: 16px;">
                    </td>
                `).join('')}
            </tr>
        `).join('');
    }

    // ==================== DETAIL VIEW FUNCTIONS ====================
    function viewDetail(id) {
      loadRoleDetail(id);
    }

    function renderDetailView() {
      if (!currentRole) return;

      document.getElementById('listView').style.display = 'none';
      document.getElementById('detailView').style.display = 'block';
      document.getElementById('formView').style.display = 'none';

      const role = currentRole;
      const permissionsList = Object.entries(role.permissions || {})
        .filter(([_, perms]) => perms.length > 0)
        .map(([func, perms]) => {
          const funcName = functions.find(f => f.id === func)?.name || func;
          return `
                    <div class="flex items-start gap-2 mb-2">
                        <span class="text-gray-600">${funcName}:</span>
                        <div class="flex gap-1">
                            ${perms.map(perm => {
            const permLabels = { view: 'Xem', create: 'Thêm', edit: 'Sửa', delete: 'Xóa', approve: 'Duyệt' };
            const permName = actions.find(a => a.id === perm)?.name || permLabels[perm] || perm;
            return `<span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-medium">${permName}</span>`;
          }).join('')}
                        </div>
                    </div>
                `;
        }).join('');

      document.getElementById('detailView').innerHTML = `
            <div class="animate-fade-in">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Trang chủ</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Vai trò</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900">${role.ten_vai_tro}</span>
                </nav>
                
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-navy-900">CHI TIẾT VAI TRÒ</h1>
                    <button class="btn btn-outline" onclick="backToList()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Role Info -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin vai trò</h3>
                        <div class="space-y-3">
                            <div class="pb-3 border-b border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Tên vai trò</p>
                                <p class="font-medium text-gray-900">${role.ten_vai_tro}</p>
                            </div>
                            <div class="pb-3 border-b border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Mô tả</p>
                                <p class="font-medium text-gray-900">${role.mo_ta || '-'}</p>
                            </div>
                            <div class="pb-3 border-b border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Số người dùng</p>
                                <p class="font-medium text-gray-900">${role.so_nguoi_dung} người</p>
                            </div>
                            <div class="pb-3 border-b border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Trạng thái</p>
                                <p class="font-medium">${getStatusBadge(role.trang_thai)}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Ngày tạo</p>
                                <p class="font-medium text-gray-900">${formatDate(role.ngay_tao)}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="lg:col-span-2 card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quyền truy cập</h3>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            ${permissionsList || '<p class="text-gray-500 text-sm">Chưa có quyền nào được cấp</p>'}
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button class="btn btn-outline flex-1" onclick="editRole(${role.ma_vai_tro})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Chỉnh sửa
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // ==================== FORM FUNCTIONS ====================
    function backToList() {
      document.getElementById('listView').style.display = 'block';
      document.getElementById('detailView').style.display = 'none';
      document.getElementById('formView').style.display = 'none';
      currentRole = null;
    }

    function openCreateModal() {
      document.getElementById('createName').value = '';
      document.getElementById('createDescription').value = '';
      document.getElementById('createStatus').value = 'active';
      renderPermissionTable();
      document.getElementById('createModal').classList.add('active');
    }

    function editRole(id) {
      currentRole = allRoles.find(r => r.ma_vai_tro == id);
      if (!currentRole) return;

      document.getElementById('createName').value = currentRole.ten_vai_tro;
      document.getElementById('createDescription').value = currentRole.mo_ta || '';
      document.getElementById('createStatus').value = currentRole.trang_thai == 1 ? 'active' : 'inactive';

      renderPermissionTable();

      // Load và check các quyền hiện tại
      loadRolePermissions(id);

      document.getElementById('createModal').classList.add('active');
    }

    async function loadRolePermissions(id) {
      try {
        const response = await fetch(`../actions/QuanLyVaiTro/chi_tiet_vai_tro.php?ma_vai_tro=${id}`);
        const result = await response.json();

        if (result.success && result.data.permissions) {
          // Reset all checkboxes
          document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);

          // Check existing permissions
          Object.entries(result.data.permissions).forEach(([func, perms]) => {
            perms.forEach(perm => {
              const cb = document.querySelector(`[data-function="${func}"][data-permission="${perm}"]`);
              if (cb) cb.checked = true;
            });
          });
        }
      } catch (error) {
        console.error('Error loading role permissions:', error);
      }
    }

    function selectAllPermissions() {
      document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
    }

    function deselectAllPermissions() {
      document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
    }

    function getSelectedPermissions() {
      const permissions = {};

      document.querySelectorAll('.permission-checkbox:checked').forEach(cb => {
        const func = cb.getAttribute('data-function');
        const perm = cb.getAttribute('data-permission');

        if (!permissions[func]) {
          permissions[func] = [];
        }
        permissions[func].push(perm);
      });

      return permissions;
    }

    function validateForm() {
      const name = document.getElementById('createName').value.trim();

      if (!name) {
        showToast('Vui lòng nhập tên vai trò', 'error');
        return false;
      }

      return true;
    }

    // ==================== MODAL FUNCTIONS ====================
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

function deleteRole(id, name) {
    roleToDelete = { id, name };
    document.getElementById('deleteRoleName').textContent = name;
    document.getElementById('deleteModal').classList.add('active');
}

async function confirmDelete() {
    if (!roleToDelete) {
        showToast('Không có vai trò nào được chọn', 'error');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('ma_vai_tro', roleToDelete.id);

        const response = await fetch('../actions/QuanLyVaiTro/xoa_vai_tro.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            closeModal('deleteModal');
            await loadRoleList();
            roleToDelete = null;
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error deleting role:', error);
        showToast('Lỗi xóa vai trò: ' + error.message, 'error');
    }
}

function toggleStatus(id, currentStatus, name) {
    roleToUpdate = { id, currentStatus, name };
    const isActive = currentStatus == 1;
    document.getElementById('lockModalTitle').textContent = 'Xác nhận thay đổi trạng thái';
    document.getElementById('lockModalMessage').innerHTML = isActive 
        ? `Bạn có chắc chắn muốn ngừng sử dụng vai trò <strong>${name}</strong>?`
        : `Bạn có chắc chắn muốn kích hoạt lại vai trò <strong>${name}</strong>?`;

    document.getElementById('lockConfirmBtn').innerHTML = isActive
        ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg> Ngừng sử dụng'
        : '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg> Kích hoạt';

    document.getElementById('lockModal').classList.add('active');
}

async function confirmLock() {
    if (roleToUpdate) {
        await toggleRoleStatus(roleToUpdate.id, roleToUpdate.currentStatus);
    }
}

    // ==================== FILTER FUNCTIONS ====================
    function applyFilters() {
      currentPage = 1;
      loadRoleList();
    }

    function resetFilters() {
      document.getElementById('searchInput').value = '';
      document.getElementById('filterStatus').value = '';

      currentPage = 1;
      loadRoleList();
      showToast('Đã làm mới bộ lọc', 'success');
    }

    // ==================== SIDEBAR & DROPDOWN TOGGLE ====================
    document.addEventListener('DOMContentLoaded', function () {
      // Sidebar elements
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      const mobileOverlay = document.getElementById('mobileOverlay');
      const userDropdown = document.getElementById('userDropdown');
      const userTrigger = document.getElementById('userTrigger');
      const navItems = document.querySelectorAll('.nav-item');
      const breadcrumbCurrent = document.getElementById('breadcrumbCurrent');

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

        function handleNavClick(e) {
          const clickedItem = e.currentTarget;
          const pageName = clickedItem.getAttribute('data-page');

          navItems.forEach(item => item.classList.remove('active'));
          clickedItem.classList.add('active');

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

          if (isMobile) {
            closeMobileSidebar();
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

        if (navItems.length > 0) {
          navItems.forEach(item => {
            item.addEventListener('click', handleNavClick);
          });
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

    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
      // Load initial data
      loadPermissions();
      loadRoleList();

      // Setup event listeners
      document.getElementById('searchInput').addEventListener('keyup', applyFilters);
      document.getElementById('filterStatus').addEventListener('change', applyFilters);

      // Close modals on overlay click
      document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function (e) {
          if (e.target === this) {
            this.classList.remove('active');
          }
        });
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
  </script>
  <script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'9d7f53c2b38d07af',t:'MTc3Mjc3ODc4OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script>
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