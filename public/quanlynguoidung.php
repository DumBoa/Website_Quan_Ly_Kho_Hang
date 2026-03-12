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
  <title>Quản Lý Người Dùng</title>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
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
    html, body {
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
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
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

html, body {
  height: 100%;
  margin: 0;
  overflow: auto;           /* ← thêm dòng này */
  font-family: 'Inter', sans-serif;
}

.app-wrapper {
  height: 100vh;              /* thay vì 100% */
  width: 100%;
  overflow: hidden;           /* ← thêm dòng này */
  background: #f1f5f9;
  display: flex;              /* ← rất quan trọng */
  flex-direction: row;
}

.main-content {
  margin-left: 260px;
  flex: 1;                    /* ← cho phép chiếm hết không gian còn lại */
  overflow-y: auto;           /* ← đây là chìa khóa để scroll được */
  min-height: 100vh;
  padding-bottom: 40px;       /* tránh nội dung bị che bởi toast */
}

/* Nếu bạn có .topbar sticky */
.topbar {
  margin-left: 260px;
  width: calc(100% - 260px);  /* ← rất quan trọng khi sidebar fixed */
  z-index: 50;
}

/* Khi sidebar collapse */
.wms-sidebar.collapsed + .main-content,
.wms-sidebar.collapsed ~ .main-content {
  margin-left: 72px;
}

.wms-sidebar.collapsed ~ .topbar,
.wms-sidebar.collapsed ~ .header {
  margin-left: 72px;
  width: calc(100% - 72px);
}
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
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <style>body { box-sizing: border-box; }</style>
 </head>
 <body class="h-full">
  <div class="wms_app"><!-- Sidebar -->
   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?><!-- Main Content -->
   <main class="main-content"><!-- Topbar -->
    <?php include __DIR__ . "/../views/Layout/header.php"; ?><!-- Page Content -->
    <div class="p-6" id="pageContent"><!-- List View -->
     <div id="listView"><!-- Breadcrumb & Title -->
      <div class="mb-6 animate-fade-in flex items-center justify-between">
       <div>
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2"><a href="#" class="hover:text-navy-600">Trang chủ</a>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg><span class="text-gray-900">Người dùng</span>
        </nav>
        <h1 class="text-2xl font-bold text-navy-900" id="pageTitle">QUẢN LÝ NGƯỜI DÙNG</h1>
       </div><button class="btn btn-primary" onclick="openCreateModal()">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg> Thêm người dùng </button>
      </div><!-- Filter Toolbar -->
      <div class="card p-5 mb-6 animate-fade-in">
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="lg:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label> <input type="text" placeholder="Tên, email, tên đăng nhập..." class="form-input" id="searchInput">
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label> <select class="form-select" id="filterRole"> <option value="">Tất cả vai trò</option> <option value="admin">Admin</option> <option value="manager">Quản lý</option> <option value="warehouse">Thủ kho</option> <option value="staff">Nhân viên</option> </select>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label> <select class="form-select" id="filterStatus"> <option value="">Tất cả</option> <option value="active">Hoạt động</option> <option value="locked">Bị khóa</option> </select>
        </div>
        <div class="flex items-end"><button class="btn btn-outline w-full" onclick="resetFilters()">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
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
           <th>Avatar</th>
           <th>Tên người dùng</th>
           <th>Tên đăng nhập</th>
           <th>Email</th>
           <th>Vai trò</th>
           <th>Trạng thái</th>
           <th>Ngày tạo</th>
           <th>Thao tác</th>
          </tr>
         </thead>
         <tbody id="tableBody"><!-- Data will be rendered here -->
         </tbody>
        </table>
       </div><!-- Pagination -->
       <!-- Pagination -->
<div class="px-6 py-4 flex items-center justify-between border-t border-gray-100">
    <p class="text-sm text-gray-600">
        Hiển thị <span class="font-medium" id="displayStart">0</span>-<span class="font-medium" id="displayEnd">0</span> 
        trong <span class="font-medium" id="totalUsers">0</span> người dùng
    </p>
    <div class="pagination" id="paginationControls">
        <!-- Pagination buttons sẽ được render bằng JavaScript -->
    </div>
</div>
      </div>
     </div><!-- Detail View -->
     <div id="detailView" style="display: none;"><!-- Will be rendered dynamically -->
     </div><!-- Create/Edit Form View -->
     <div id="formView" style="display: none;"><!-- Will be rendered dynamically -->
     </div>
    </div>
   </main><!-- Create User Modal -->
   <div class="modal-overlay" id="createModal">
    <div class="modal-content">
     <div class="p-5 border-b border-gray-100">
      <h3 class="text-lg font-semibold text-gray-900">Thêm người dùng mới</h3>
     </div>
     <div class="p-5 overflow-y-auto" style="max-height: calc(90vh - 120px);">
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Tên người dùng <span class="text-red-500">*</span></label> <input type="text" class="form-input" id="createFullName" placeholder="Nhập tên người dùng">
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập <span class="text-red-500">*</span></label> <input type="text" class="form-input" id="createUsername" placeholder="Nhập tên đăng nhập">
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label> <input type="email" class="form-input" id="createEmail" placeholder="Nhập email">
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu <span class="text-red-500">*</span></label> <input type="password" class="form-input" id="createPassword" placeholder="Nhập mật khẩu">
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu <span class="text-red-500">*</span></label> <input type="password" class="form-input" id="createConfirmPassword" placeholder="Xác nhận mật khẩu">
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Vai trò <span class="text-red-500">*</span></label> <select class="form-select" id="createRole"> <option value="staff">Nhân viên</option> <option value="warehouse">Thủ kho</option> <option value="manager">Quản lý</option> <option value="admin">Admin</option> </select>
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label> <input type="tel" class="form-input" id="createPhone" placeholder="Nhập số điện thoại">
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
       <div class="avatar-upload">
        <div class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center cursor-pointer border-2 border-dashed border-gray-300 hover:border-navy-600" onclick="document.getElementById('createAvatar').click()"><img id="createAvatarPreview" src="" alt="Avatar" class="w-20 h-20 rounded-lg object-cover" style="display: none;">
         <svg class="w-8 h-8 text-gray-400" id="createAvatarIcon" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
         </svg>
        </div><input type="file" id="createAvatar" accept="image/*" onchange="previewAvatar(event, 'create')">
       </div>
      </div>
      <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label> <textarea class="form-input" id="createNote" rows="3" placeholder="Nhập ghi chú (không bắt buộc)..."></textarea>
      </div>
     </div>
     <div class="p-5 border-t border-gray-100 flex justify-end gap-3"><button class="btn btn-outline" onclick="closeModal('createModal')">Hủy bỏ</button> <button class="btn btn-primary" onclick="saveUser('create')">
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
       </svg> Lưu </button>
     </div>
    </div>
   </div><!-- Delete Confirmation Modal -->
   <div class="modal-overlay" id="deleteModal">
    <div class="modal-content">
     <div class="p-5 border-b border-gray-100">
      <h3 class="text-lg font-semibold text-gray-900">Xác nhận xóa người dùng</h3>
     </div>
     <div class="p-5">
      <p class="text-gray-600">Bạn có chắc chắn muốn xóa người dùng <strong id="deleteUserName"></strong>?</p>
      <p class="text-sm text-gray-500 mt-2">Hành động này không thể hoàn tác.</p>
     </div>
     <div class="p-5 border-t border-gray-100 flex justify-end gap-3"><button class="btn btn-outline" onclick="closeModal('deleteModal')">Hủy bỏ</button> <button class="btn btn-danger" onclick="confirmDelete()">
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
       </svg> Xóa người dùng </button>
     </div>
    </div>
   </div><!-- Lock/Unlock Confirmation Modal -->
   <div class="modal-overlay" id="lockModal">
    <div class="modal-content">
     <div class="p-5 border-b border-gray-100">
      <h3 class="text-lg font-semibold text-gray-900" id="lockModalTitle">Xác nhận khóa tài khoản</h3>
     </div>
     <div class="p-5">
      <p class="text-gray-600" id="lockModalMessage"></p>
     </div>
     <div class="p-5 border-t border-gray-100 flex justify-end gap-3"><button class="btn btn-outline" onclick="closeModal('lockModal')">Hủy bỏ</button> <button class="btn btn-danger" id="lockConfirmBtn" onclick="confirmLock()">
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm6-10V7a3 3 0 00-6 0v4a3 3 0 006 0z" />
       </svg> Xác nhận </button>
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
        page_title: 'QUẢN LÝ NGƯỜI DÙNG'
    };
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
    // ==================== BIẾN TOÀN CỤC ====================
    let allUsers = [];
    let filteredUsers = [];
    let roles = [];
    let currentUserDetail = null;
    let userToDelete = null;
    let userToLock = null;
    let currentPage = 1;
    const itemsPerPage = 10;

    // ==================== UTILITY FUNCTIONS ====================
    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        return date.toLocaleDateString('vi-VN');
    }

    function getRoleBadge(role) {
        switch (role) {
            case 'ADMIN':
                return '<span class="badge badge-admin">Admin</span>';
            case 'QUAN_LY':
                return '<span class="badge badge-manager">Quản lý</span>';
            case 'THU_KHO':
                return '<span class="badge badge-warehouse">Thủ kho</span>';
            case 'NHAN_VIEN':
                return '<span class="badge badge-staff">Nhân viên</span>';
            default:
                return '<span class="badge">' + role + '</span>';
        }
    }

    function getStatusBadge(status) {
        if (status == 1) {
            return '<span class="badge badge-active">Hoạt động</span>';
        } else {
            return '<span class="badge badge-locked">Bị khóa</span>';
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
    async function loadUserList() {
          if (!document.getElementById('displayStart') || 
        !document.getElementById('displayEnd') || 
        !document.getElementById('totalUsers') || 
        !document.getElementById('paginationControls')) {
        console.error('Pagination elements not found');
        return;
    }
        try {
            const search = document.getElementById('searchInput').value;
            const ma_vai_tro = document.getElementById('filterRole').value;
            const trang_thai = document.getElementById('filterStatus').value;

            let url = '../actions/QuanLyNguoiDung/lay_danh_sach.php?';
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (ma_vai_tro) params.append('ma_vai_tro', ma_vai_tro);
            if (trang_thai !== '') params.append('trang_thai', trang_thai);
            
            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                allUsers = result.data;
                filteredUsers = [...allUsers];
                renderTable();
                document.getElementById('totalUsers').textContent = allUsers.length;
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading users:', error);
            showToast('Lỗi tải danh sách người dùng', 'error');
        }
    }

    async function loadRoles() {
        try {
            const response = await fetch('../actions/QuanLyNguoiDung/lay_danh_sach_vai_tro.php');
            const result = await response.json();

            if (result.success) {
                roles = result.data;
                renderRoleOptions();
            }
        } catch (error) {
            console.error('Error loading roles:', error);
        }
    }

    async function loadUserDetail(id) {
        try {
            const response = await fetch(`../actions/QuanLyNguoiDung/chi_tiet_nguoi_dung.php?ma_nguoi_dung=${id}`);
            const result = await response.json();

            if (result.success) {
                currentUserDetail = result.data;
                renderDetailView();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading user detail:', error);
            showToast('Lỗi tải chi tiết người dùng', 'error');
        }
    }

    async function saveUser(type) {
        if (!validateForm(type === 'create')) return;

        const formData = new FormData();
        formData.append('ho_ten', document.getElementById('createFullName').value.trim());
        formData.append('ten_dang_nhap', document.getElementById('createUsername').value.trim());
        formData.append('email', document.getElementById('createEmail').value.trim());
        formData.append('ma_vai_tro', document.getElementById('createRole').value);
        formData.append('so_dien_thoai', document.getElementById('createPhone').value.trim());
        formData.append('trang_thai', '1');
        formData.append('ghi_chu', document.getElementById('createNote').value.trim());

        if (type === 'create') {
            formData.append('mat_khau', document.getElementById('createPassword').value);
        }

        const avatarFile = document.getElementById('createAvatar').files[0];
        if (avatarFile) {
            formData.append('anh_dai_dien', avatarFile);
        }

        try {
            const url = type === 'create' 
                ? '../actions/QuanLyNguoiDung/them_nguoi_dung.php'
                : '../actions/QuanLyNguoiDung/cap_nhat_nguoi_dung.php';
            
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                closeModal('createModal');
                await loadUserList();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving user:', error);
            showToast('Lỗi lưu người dùng', 'error');
        }
    }

    async function updateUser() {
        const formData = new FormData();
        formData.append('ma_nguoi_dung', currentUserDetail.ma_nguoi_dung);
        formData.append('ho_ten', document.getElementById('editFullName').value.trim());
        formData.append('email', document.getElementById('editEmail').value.trim());
        formData.append('ma_vai_tro', document.getElementById('editRole').value);
        formData.append('so_dien_thoai', document.getElementById('editPhone').value.trim());
        formData.append('trang_thai', document.getElementById('editStatus').value);

        const avatarFile = document.getElementById('editAvatar').files[0];
        if (avatarFile) {
            formData.append('anh_dai_dien', avatarFile);
        }

        try {
            const response = await fetch('../actions/QuanLyNguoiDung/cap_nhat_nguoi_dung.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                backToList();
                await loadUserList();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error updating user:', error);
            showToast('Lỗi cập nhật người dùng', 'error');
        }
    }

    

    async function toggleLockUser(id, status) {
        try {
            const formData = new FormData();
            formData.append('ma_nguoi_dung', id);
            formData.append('trang_thai', status);

            const response = await fetch('../actions/QuanLyNguoiDung/cap_nhat_trang_thai.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                closeModal('lockModal');
                await loadUserList();
                if (currentUserDetail && currentUserDetail.ma_nguoi_dung == id) {
                    currentUserDetail.trang_thai = status;
                }
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error toggling user lock:', error);
            showToast('Lỗi cập nhật trạng thái', 'error');
        }
    }

    async function changePassword(id, newPassword) {
        try {
            const formData = new FormData();
            formData.append('ma_nguoi_dung', id);
            formData.append('mat_khau_moi', newPassword);

            const response = await fetch('../actions/QuanLyNguoiDung/doi_mat_khau.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                closeModal('passwordModal');
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error changing password:', error);
            showToast('Lỗi đổi mật khẩu', 'error');
        }
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderRoleOptions() {
        const filterSelect = document.getElementById('filterRole');
        const createSelect = document.getElementById('createRole');
        const editSelect = document.getElementById('editRole');

        const options = roles.map(r => 
            `<option value="${r.ma_vai_tro}">${r.ten_vai_tro}</option>`
        ).join('');

        if (filterSelect) {
            filterSelect.innerHTML = '<option value="">Tất cả vai trò</option>' + options;
        }
        if (createSelect) {
            createSelect.innerHTML = options;
        }
        if (editSelect) {
            editSelect.innerHTML = options;
        }
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        
        if (filteredUsers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center py-10 text-gray-500">Không có dữ liệu</td></tr>';
            return;
        }

        // Tính phân trang
        const start = (currentPage - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, filteredUsers.length);
        const paginatedData = filteredUsers.slice(start, end);

        tbody.innerHTML = paginatedData.map(user => `
            <tr>
                <td>${user.ma_nguoi_dung}</td>
                <td>
                    ${user.anh_dai_dien ? 
                        `<img src="${user.anh_dai_dien}" class="w-10 h-10 rounded-full object-cover">` : 
                        `<div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold">${user.ho_ten.charAt(0)}</div>`
                    }
                </td>
                <td class="font-medium text-gray-900">${user.ho_ten}</td>
                <td><code class="bg-gray-50 px-2 py-1 rounded text-sm">${user.ten_dang_nhap}</code></td>
                <td>${user.email}</td>
                <td>${getRoleBadge(user.ten_vai_tro)}</td>
                <td>${getStatusBadge(user.trang_thai)}</td>
                <td>${formatDate(user.ngay_tao)}</td>
                <td>
                    <div class="flex items-center gap-2">
                        <button class="btn btn-outline btn-sm btn-icon" onclick="viewDetail(${user.ma_nguoi_dung})" title="Xem chi tiết">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="btn btn-outline btn-sm btn-icon" onclick="editUser(${user.ma_nguoi_dung})" title="Chỉnh sửa">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        ${user.ma_nguoi_dung != currentUser.ma_nguoi_dung ? `
                            <button class="btn btn-outline btn-sm btn-icon" onclick="toggleLock(${user.ma_nguoi_dung}, ${user.trang_thai})" title="${user.trang_thai == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản'}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm6-10V7a3 3 0 00-6 0v4a3 3 0 006 0z"/>
                                </svg>
                            </button>
                            <button class="btn btn-outline btn-sm btn-icon" onclick="deleteUser(${user.ma_nguoi_dung}, '${user.ho_ten}')" title="Xóa">
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

    function updatePagination() {
    const totalPages = Math.ceil(filteredUsers.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(currentPage * itemsPerPage, filteredUsers.length);

    // Kiểm tra các element tồn tại trước khi set
    const displayStart = document.getElementById('displayStart');
    const displayEnd = document.getElementById('displayEnd');
    const totalUsersEl = document.getElementById('totalUsers');
    const paginationControls = document.getElementById('paginationControls');

    if (displayStart) {
        displayStart.textContent = filteredUsers.length > 0 ? start : 0;
    }
    if (displayEnd) {
        displayEnd.textContent = end;
    }
    if (totalUsersEl) {
        totalUsersEl.textContent = filteredUsers.length;
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
    const totalPages = Math.ceil(filteredUsers.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderTable();
}

    // ==================== DETAIL VIEW FUNCTIONS ====================
    function viewDetail(id) {
        loadUserDetail(id);
    }

    function renderDetailView() {
        if (!currentUserDetail) return;

        document.getElementById('listView').style.display = 'none';
        document.getElementById('detailView').style.display = 'block';
        document.getElementById('formView').style.display = 'none';

        const user = currentUserDetail;

        document.getElementById('detailView').innerHTML = `
            <div class="animate-fade-in">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Trang chủ</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Người dùng</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900">${user.ho_ten}</span>
                </nav>
                
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-navy-900">CHI TIẾT NGƯỜI DÙNG</h1>
                    <button class="btn btn-outline" onclick="backToList()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- User Info Card -->
                    <div class="card p-6">
                        <div class="text-center">
                            ${user.anh_dai_dien ? 
                                `<img src="${user.anh_dai_dien}" class="w-24 h-24 mx-auto mb-4 rounded-full object-cover">` : 
                                `<div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-4xl font-bold">${user.ho_ten.charAt(0)}</div>`
                            }
                            <h2 class="text-xl font-bold text-gray-900 mb-1">${user.ho_ten}</h2>
                            <p class="text-sm text-gray-500 mb-3">${user.ten_dang_nhap}</p>
                            <div class="flex justify-center gap-2 mb-4">
                                ${getRoleBadge(user.ten_vai_tro)}
                                ${getStatusBadge(user.trang_thai)}
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="lg:col-span-2 card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin tài khoản</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium text-gray-900">${user.email}</span>
                            </div>
                            <div class="flex justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-600">Số điện thoại:</span>
                                <span class="font-medium text-gray-900">${user.so_dien_thoai || '-'}</span>
                            </div>
                            <div class="flex justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-600">Vai trò:</span>
                                <span class="font-medium text-gray-900">${user.ten_vai_tro}</span>
                            </div>
                            <div class="flex justify-between pb-3 border-b border-gray-100">
                                <span class="text-gray-600">Trạng thái:</span>
                                <span class="font-medium">${getStatusBadge(user.trang_thai)}</span>
                            </div>
                            <div class="flex justify-between pb-3">
                                <span class="text-gray-600">Ngày tạo:</span>
                                <span class="font-medium text-gray-900">${formatDate(user.ngay_tao)}</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button class="btn btn-outline flex-1" onclick="editUser(${user.ma_nguoi_dung})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Chỉnh sửa
                            </button>
                            ${user.ma_nguoi_dung != currentUser.ma_nguoi_dung ? `
                                <button class="btn btn-outline flex-1" onclick="toggleLock(${user.ma_nguoi_dung}, ${user.trang_thai})">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm6-10V7a3 3 0 00-6 0v4a3 3 0 006 0z"/>
                                    </svg>
                                    ${user.trang_thai == 1 ? 'Khóa' : 'Mở khóa'}
                                </button>
                                <button class="btn btn-outline flex-1" onclick="openChangePasswordModal(${user.ma_nguoi_dung})">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    Đổi mật khẩu
                                </button>
                            ` : ''}
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
        currentUserDetail = null;
    }

    function openCreateModal() {
        document.getElementById('createFullName').value = '';
        document.getElementById('createUsername').value = '';
        document.getElementById('createEmail').value = '';
        document.getElementById('createPassword').value = '';
        document.getElementById('createConfirmPassword').value = '';
        document.getElementById('createRole').value = roles.length > 0 ? roles[0].ma_vai_tro : '';
        document.getElementById('createPhone').value = '';
        document.getElementById('createNote').value = '';
        document.getElementById('createAvatarPreview').style.display = 'none';
        document.getElementById('createAvatarIcon').style.display = 'block';
        document.getElementById('createModal').classList.add('active');
    }

    function editUser(id) {
        currentUserDetail = allUsers.find(u => u.ma_nguoi_dung == id);
        if (!currentUserDetail) return;

        document.getElementById('listView').style.display = 'none';
        document.getElementById('detailView').style.display = 'none';
        document.getElementById('formView').style.display = 'block';
        
        renderEditForm();
    }

    function renderEditForm() {
        const user = currentUserDetail;
        document.getElementById('formView').innerHTML = `
            <div class="animate-fade-in">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Trang chủ</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="#" class="hover:text-navy-600" onclick="backToList()">Người dùng</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900">Chỉnh sửa</span>
                </nav>

                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-navy-900">CHỈNH SỬA NGƯỜI DÙNG</h1>
                    <button class="btn btn-outline" onclick="backToList()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                </div>

                <div class="card p-6 max-w-2xl">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên người dùng <span class="text-red-500">*</span></label>
                        <input type="text" class="form-input" id="editFullName" value="${user.ho_ten}">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
                        <input type="text" class="form-input" value="${user.ten_dang_nhap}" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" class="form-input" id="editEmail" value="${user.email}">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vai trò <span class="text-red-500">*</span></label>
                        <select class="form-select" id="editRole"></select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input type="tel" class="form-input" id="editPhone" value="${user.so_dien_thoai || ''}">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <select class="form-select" id="editStatus">
                            <option value="1" ${user.trang_thai == 1 ? 'selected' : ''}>Hoạt động</option>
                            <option value="0" ${user.trang_thai == 0 ? 'selected' : ''}>Bị khóa</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
                        <div class="avatar-upload">
                            <div class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center cursor-pointer border-2 border-dashed border-gray-300 hover:border-navy-600" onclick="document.getElementById('editAvatar').click()">
                                <img id="editAvatarPreview" src="${user.anh_dai_dien || ''}" alt="Avatar" class="w-20 h-20 rounded-lg object-cover" style="${user.anh_dai_dien ? 'display: block;' : 'display: none;'}">
                                <svg class="w-8 h-8 text-gray-400" id="editAvatarIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="${user.anh_dai_dien ? 'display: none;' : 'display: block;'}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <input type="file" id="editAvatar" accept="image/*" onchange="previewAvatar(event, 'edit')">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button class="btn btn-outline flex-1" onclick="backToList()">Hủy bỏ</button>
                        <button class="btn btn-primary flex-1" onclick="updateUser()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Cập nhật
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Populate role options
        const editSelect = document.getElementById('editRole');
        editSelect.innerHTML = roles.map(r => 
            `<option value="${r.ma_vai_tro}" ${r.ma_vai_tro == user.ma_vai_tro ? 'selected' : ''}>${r.ten_vai_tro}</option>`
        ).join('');
    }

    function previewAvatar(event, type) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(type + 'AvatarPreview');
                const icon = document.getElementById(type + 'AvatarIcon');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (icon) icon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }

    function validateForm(isCreate = true) {
        const fullName = document.getElementById('createFullName').value.trim();
        const username = document.getElementById('createUsername').value.trim();
        const email = document.getElementById('createEmail').value.trim();
        const password = document.getElementById('createPassword').value;
        const confirmPassword = document.getElementById('createConfirmPassword').value;

        if (!fullName) {
            showToast('Vui lòng nhập tên người dùng', 'error');
            return false;
        }

        if (!username) {
            showToast('Vui lòng nhập tên đăng nhập', 'error');
            return false;
        }

        if (!email || !email.includes('@')) {
            showToast('Vui lòng nhập email hợp lệ', 'error');
            return false;
        }

        if (isCreate) {
            if (!password || password.length < 6) {
                showToast('Mật khẩu phải có ít nhất 6 ký tự', 'error');
                return false;
            }

            if (password !== confirmPassword) {
                showToast('Mật khẩu xác nhận không khớp', 'error');
                return false;
            }
        }

        return true;
    }

    // ==================== MODAL FUNCTIONS ====================
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    // Sửa lại hàm deleteUser
function deleteUser(id, name) {
    userToDelete = { id, name };
    document.getElementById('deleteUserName').textContent = name;
    document.getElementById('deleteModal').classList.add('active');
}

// Sửa lại hàm confirmDelete
async function confirmDelete() {
    if (!userToDelete) {
        showToast('Không có người dùng nào được chọn', 'error');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('ma_nguoi_dung', userToDelete.id);

        const response = await fetch('../actions/QuanLyNguoiDung/xoa_nguoi_dung.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            closeModal('deleteModal');
            await loadUserList(); // Load lại danh sách
            userToDelete = null; // Reset biến
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        showToast('Lỗi xóa người dùng: ' + error.message, 'error');
    }
}

    function toggleLock(id, currentStatus) {
        userToLock = { id, currentStatus };
        const isLocked = currentStatus == 0;
        document.getElementById('lockModalTitle').textContent = isLocked ? 'Xác nhận mở khóa tài khoản' : 'Xác nhận khóa tài khoản';
        
        const user = allUsers.find(u => u.ma_nguoi_dung == id);
        document.getElementById('lockModalMessage').innerHTML = isLocked 
            ? `Bạn có chắc chắn muốn mở khóa tài khoản của <strong>${user.ho_ten}</strong>?`
            : `Bạn có chắc chắn muốn khóa tài khoản của <strong>${user.ho_ten}</strong>?`;
        
        document.getElementById('lockConfirmBtn').innerHTML = isLocked
            ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg> Mở khóa'
            : '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm6-10V7a3 3 0 00-6 0v4a3 3 0 006 0z"/></svg> Khóa';

        document.getElementById('lockModal').classList.add('active');
    }

    function confirmLock() {
        if (userToLock) {
            const newStatus = userToLock.currentStatus == 1 ? 0 : 1;
            toggleLockUser(userToLock.id, newStatus);
        }
    }

    function openChangePasswordModal(id) {
        document.getElementById('passwordModal').innerHTML = `
            <div class="modal-overlay active" id="passwordModal">
                <div class="modal-content">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Đổi mật khẩu</h3>
                    </div>
                    <div class="p-5">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới <span class="text-red-500">*</span></label>
                            <input type="password" class="form-input" id="newPassword" placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu <span class="text-red-500">*</span></label>
                            <input type="password" class="form-input" id="confirmNewPassword" placeholder="Xác nhận mật khẩu mới">
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-100 flex justify-end gap-3">
                        <button class="btn btn-outline" onclick="closeModal('passwordModal')">Hủy bỏ</button>
                        <button class="btn btn-primary" onclick="confirmChangePassword(${id})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Xác nhận
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('passwordModal').classList.add('active');
    }

    function confirmChangePassword(id) {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmNewPassword').value;

        if (!newPassword || newPassword.length < 6) {
            showToast('Mật khẩu phải có ít nhất 6 ký tự', 'error');
            return;
        }

        if (newPassword !== confirmPassword) {
            showToast('Mật khẩu xác nhận không khớp', 'error');
            return;
        }

        changePassword(id, newPassword);
    }

    // ==================== FILTER FUNCTIONS ====================
    function applyFilters() {
        currentPage = 1;
        loadUserList();
    }

    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterRole').value = '';
        document.getElementById('filterStatus').value = '';
        
        currentPage = 1;
        loadUserList();
        showToast('Đã làm mới bộ lọc', 'success');
    }

    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
        // Load initial data
        loadRoles();
        loadUserList();

        // Setup event listeners
        document.getElementById('searchInput').addEventListener('keyup', applyFilters);
        document.getElementById('filterRole').addEventListener('change', applyFilters);
        document.getElementById('filterStatus').addEventListener('change', applyFilters);

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
    // Thêm vào cuối file, sau khi renderTable lần đầu
if (filteredUsers.length === 0) {
    if (document.getElementById('displayStart')) {
        document.getElementById('displayStart').textContent = '0';
    }
    if (document.getElementById('displayEnd')) {
        document.getElementById('displayEnd').textContent = '0';
    }
    if (document.getElementById('totalUsers')) {
        document.getElementById('totalUsers').textContent = '0';
    }
    if (document.getElementById('paginationControls')) {
        document.getElementById('paginationControls').innerHTML = '';
    }
}
</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d7f4e4352aa07af',t:'MTc3Mjc3ODU2My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
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