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
  <title>Hồ Sơ Cá Nhân</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 10px 16px;
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
    
    .btn-secondary {
      background: #f3f4f6;
      color: #6b7280;
    }
    
    .btn-secondary:hover {
      background: #e5e7eb;
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
    
    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid #e5e7eb;
      transition: all 0.3s ease;
    }
    
    .avatar-large {
      width: 120px;
      height: 120px;
      border-radius: 8px;
      object-fit: cover;
      border: 2px solid #e5e7eb;
    }
    
    .avatar-upload-btn {
      display: inline-block;
      margin-top: 12px;
      padding: 8px 16px;
      background: #102a43;
      color: white;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      border: none;
    }
    
    .avatar-upload-btn:hover {
      background: #243b53;
    }
    
    .avatar-upload-input {
      display: none;
    }
    
    .info-row {
      display: grid;
      grid-template-columns: 120px 1fr;
      gap: 16px;
      padding: 12px 0;
      border-bottom: 1px solid #f3f4f6;
    }
    
    .info-row:last-child {
      border-bottom: none;
    }
    
    .info-label {
      color: #6b7280;
      font-size: 13px;
      font-weight: 500;
    }
    
    .info-value {
      color: #1f2937;
      font-size: 14px;
      font-weight: 500;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #1f2937;
      margin-bottom: 8px;
    }
    
    .form-label .required {
      color: #dc2626;
    }
    
    .badge-active {
      background: #d1fae5;
      color: #059669;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
      display: inline-block;
    }
    
    .badge-role {
      background: #dbeafe;
      color: #1e40af;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      display: inline-block;
    }
    
    .activity-item {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid #f3f4f6;
    }
    
    .activity-item:last-child {
      border-bottom: none;
    }
    
    .activity-icon {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    
    .activity-content {
      flex: 1;
    }
    
    .activity-text {
      font-size: 13px;
      color: #1f2937;
      font-weight: 500;
    }
    
    .activity-time {
      font-size: 12px;
      color: #9ca3af;
      margin-top: 2px;
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
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
      animation: fadeIn 0.3s ease-out;
    }

    /* Sidebar compatibility */
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

    .main-content {
      margin-left: 260px;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      min-height: 100vh;
    }

    .wms-sidebar.collapsed + .main-content,
    .wms-sidebar.collapsed ~ .main-content {
      margin-left: 72px;
    }

    .topbar {
      margin-left: 260px;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: sticky;
      top: 0;
      z-index: 90;
      background: white;
    }

    .wms-sidebar.collapsed ~ .topbar {
      margin-left: 72px;
    }

    @media (max-width: 1024px) {
      .wms-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      
      .wms-sidebar.open {
        transform: translateX(0);
      }
      
      .main-content,
      .topbar {
        margin-left: 0 !important;
      }
    }

    .app-wrapper {
      height: 100vh;
      width: 100%;
      overflow: hidden;
      background: #f1f5f9;
      display: flex;
      flex-direction: row;
    }

    .main-content {
      flex: 1;
      overflow-y: auto;
      min-height: 100vh;
      padding-bottom: 40px;
    }

    .topbar {
      width: calc(100% - 260px);
      z-index: 50;
    }

    .wms-sidebar.collapsed ~ .topbar {
      width: calc(100% - 72px);
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
      <main class="wms-content">
        <div class="max-w-1200px mx-auto">
          <!-- Breadcrumb -->
          <nav class="animate-fade-in flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="#" onclick="event.preventDefault()" class="text-gray-500 hover:text-navy-600">Trang chủ</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-900">Hồ sơ cá nhân</span>
          </nav>

          <!-- Page Title -->
          <div class="animate-fade-in mb-8">
            <h1 id="pageTitle" class="text-2xl font-bold text-navy-900">HỒ SƠ CÁ NHÂN</h1>
            <p id="pageDescription" class="text-gray-500 mt-1">Quản lý thông tin tài khoản của bạn</p>
          </div>

          <!-- User Info Card -->
          <div class="card animate-fade-in p-8 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <!-- Left Column: Avatar -->
              <div class="text-center md:text-left">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 120'%3E%3Ccircle cx='60' cy='40' r='30' fill='%23102a43'/%3E%3Cpath d='M20 120 Q20 85 60 85 Q100 85 100 120' fill='%23102a43'/%3E%3C/svg%3E" 
                     alt="Avatar" 
                     class="avatar-large mx-auto md:mx-0" 
                     id="avatarPreview">
                <input type="file" id="avatarInput" class="avatar-upload-input" accept="image/*" onchange="previewAvatar(event)">
                <div class="mt-4 flex gap-2 justify-center md:justify-start">
                  <button class="avatar-upload-btn" onclick="document.getElementById('avatarInput').click()">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Đổi ảnh
                  </button>
                  <button class="btn btn-outline btn-sm" onclick="deleteAvatar()" title="Xóa ảnh">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Right Column: Basic Info -->
              <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <p class="text-sm text-gray-500">Họ và tên</p>
                    <p class="text-lg font-semibold text-gray-900" id="infoFullName">Đang tải...</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Tên đăng nhập</p>
                    <p class="text-lg font-semibold text-gray-900" id="infoUsername">Đang tải...</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-lg text-gray-700" id="infoEmail">Đang tải...</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Số điện thoại</p>
                    <p class="text-lg text-gray-700" id="infoPhone">Đang tải...</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Vai trò</p>
                    <div>
                      <span class="badge-role" id="infoRole">Đang tải...</span>
                    </div>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Trạng thái</p>
                    <span class="badge-active" id="infoStatus">Hoạt động</span>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Ngày tạo</p>
                    <p class="text-lg text-gray-700" id="infoCreated">Đang tải...</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Info Section -->
          <div class="card animate-fade-in p-8 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Chỉnh sửa thông tin</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div class="form-group">
                <label class="form-label">Họ và tên <span class="required">*</span></label>
                <input type="text" class="form-input" id="editFullName" placeholder="Nhập họ tên">
              </div>
              <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-input" id="editEmail" placeholder="Nhập email">
              </div>
              <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="tel" class="form-input" id="editPhone" placeholder="Nhập số điện thoại">
              </div>
            </div>
            <div class="flex gap-3">
              <button class="btn btn-primary" onclick="saveProfileInfo()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Lưu thay đổi
              </button>
              <button class="btn btn-secondary" onclick="resetProfileForm()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Hủy
              </button>
            </div>
          </div>

          <!-- Change Password Section -->
          <div class="card animate-fade-in p-8 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Đổi mật khẩu</h2>
            <div class="grid grid-cols-1 gap-6 mb-6">
              <div class="form-group">
                <label class="form-label">Mật khẩu hiện tại <span class="required">*</span></label>
                <input type="password" class="form-input" placeholder="Nhập mật khẩu hiện tại" id="currentPassword">
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                  <label class="form-label">Mật khẩu mới <span class="required">*</span></label>
                  <input type="password" class="form-input" placeholder="Nhập mật khẩu mới" id="newPassword">
                </div>
                <div class="form-group">
                  <label class="form-label">Xác nhận mật khẩu mới <span class="required">*</span></label>
                  <input type="password" class="form-input" placeholder="Nhập lại mật khẩu mới" id="confirmPassword">
                </div>
              </div>
            </div>
            <button class="btn btn-primary" onclick="changePassword()">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              Cập nhật mật khẩu
            </button>
          </div>

          <!-- Recent Activity -->
          <div class="card animate-fade-in p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Hoạt động gần đây</h2>
            <div id="activityList">
              <!-- Activities will be rendered here -->
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="toast" id="toast">
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
        page_title: 'HỒ SƠ CÁ NHÂN',
        page_description: 'Quản lý thông tin tài khoản của bạn'
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let userData = null;

    // ==================== UTILITY FUNCTIONS ====================
    function formatDateTime(dateTimeStr) {
        if (!dateTimeStr) return '-';
        const date = new Date(dateTimeStr);
        const time = date.toLocaleTimeString('vi-VN');
        const dateStr = date.toLocaleDateString('vi-VN');
        return `${dateStr} ${time}`;
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toastIcon');
        const toastMessage = document.getElementById('toastMessage');

        toast.className = `toast toast-${type}`;
        toastMessage.textContent = message;

        if (type === 'success') {
            toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
        } else {
            toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
        }

        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // ==================== API CALLS ====================
    async function loadUserProfile() {
        try {
            const response = await fetch('../actions/Profile/lay_thong_tin.php');
            const result = await response.json();

            if (result.success) {
                userData = result.data;
                renderUserInfo();
                renderActivities();
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error loading profile:', error);
            showToast('Lỗi tải thông tin người dùng', 'error');
        }
    }

    async function saveProfileInfo() {
        const fullName = document.getElementById('editFullName').value.trim();
        const email = document.getElementById('editEmail').value.trim();
        const phone = document.getElementById('editPhone').value.trim();

        if (!fullName) {
            showToast('Vui lòng nhập họ và tên', 'error');
            return;
        }

        if (!validateEmail(email)) {
            showToast('Email không hợp lệ', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('ho_ten', fullName);
        formData.append('email', email);
        formData.append('so_dien_thoai', phone);

        const avatarFile = document.getElementById('avatarInput').files[0];
        if (avatarFile) {
            formData.append('anh_dai_dien', avatarFile);
        }

        try {
            const response = await fetch('../actions/Profile/cap_nhat_thong_tin.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                await loadUserProfile(); // Reload data
                // Reset avatar input
                document.getElementById('avatarInput').value = '';
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving profile:', error);
            showToast('Lỗi cập nhật thông tin', 'error');
        }
    }

    async function changePassword() {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (!currentPassword || !newPassword || !confirmPassword) {
            showToast('Vui lòng điền đầy đủ các trường', 'error');
            return;
        }

        if (newPassword.length < 6) {
            showToast('Mật khẩu mới phải có ít nhất 6 ký tự', 'error');
            return;
        }

        if (newPassword !== confirmPassword) {
            showToast('Mật khẩu xác nhận không khớp', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('mat_khau_cu', currentPassword);
        formData.append('mat_khau_moi', newPassword);
        formData.append('xac_nhan', confirmPassword);

        try {
            const response = await fetch('../actions/Profile/doi_mat_khau.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                // Clear form
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error changing password:', error);
            showToast('Lỗi đổi mật khẩu', 'error');
        }
    }

    async function deleteAvatar() {
        if (!confirm('Bạn có chắc chắn muốn xóa ảnh đại diện?')) {
            return;
        }

        try {
            const response = await fetch('../actions/Profile/xoa_avatar.php', {
                method: 'POST'
            });
            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                await loadUserProfile(); // Reload data
                // Reset avatar input
                document.getElementById('avatarInput').value = '';
            } else {
                showToast(result.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting avatar:', error);
            showToast('Lỗi xóa ảnh đại diện', 'error');
        }
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderUserInfo() {
        if (!userData) return;

        // Update avatar
        const avatarPreview = document.getElementById('avatarPreview');
        if (userData.anh_dai_dien) {
            avatarPreview.src = userData.anh_dai_dien;
        } else {
            avatarPreview.src = 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 120 120\'%3E%3Ccircle cx=\'60\' cy=\'40\' r=\'30\' fill=\'%23102a43\'/%3E%3Cpath d=\'M20 120 Q20 85 60 85 Q100 85 100 120\' fill=\'%23102a43\'/%3E%3C/svg%3E';
        }

        // Update user info display
        document.getElementById('infoFullName').textContent = userData.ho_ten;
        document.getElementById('infoUsername').textContent = userData.ten_dang_nhap;
        document.getElementById('infoEmail').textContent = userData.email;
        document.getElementById('infoPhone').textContent = userData.so_dien_thoai || '-';
        document.getElementById('infoRole').textContent = userData.ten_vai_tro;
        
        const status = document.getElementById('infoStatus');
        if (userData.trang_thai == 1) {
            status.className = 'badge-active';
            status.textContent = 'Hoạt động';
        } else {
            status.className = 'badge-locked';
            status.textContent = 'Bị khóa';
        }

        const date = new Date(userData.ngay_tao);
        document.getElementById('infoCreated').textContent = date.toLocaleDateString('vi-VN');

        // Update edit form
        document.getElementById('editFullName').value = userData.ho_ten;
        document.getElementById('editEmail').value = userData.email;
        document.getElementById('editPhone').value = userData.so_dien_thoai || '';
    }

    function renderActivities() {
        const activityList = document.getElementById('activityList');
        
        if (!userData || !userData.activities || userData.activities.length === 0) {
            activityList.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">Chưa có hoạt động nào</p>';
            return;
        }

        activityList.innerHTML = userData.activities.map(activity => `
            <div class="activity-item">
                <div class="activity-icon">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="activity-content">
                    <div class="activity-text">${activity.hanh_dong}</div>
                    <div class="activity-time">${formatDateTime(activity.thoi_gian)}</div>
                </div>
            </div>
        `).join('');
    }

    // ==================== UI FUNCTIONS ====================
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
                // Auto save after selecting avatar
                saveProfileInfo();
            };
            reader.readAsDataURL(file);
        }
    }

    function resetProfileForm() {
        if (userData) {
            document.getElementById('editFullName').value = userData.ho_ten;
            document.getElementById('editEmail').value = userData.email;
            document.getElementById('editPhone').value = userData.so_dien_thoai || '';
        }
        showToast('Đã hủy các thay đổi', 'success');
    }

    // ==================== SIDEBAR TOGGLE ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Load user profile
        loadUserProfile();

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
                document.getElementById('pageTitle').textContent = config.page_title || defaultConfig.page_title;
                document.getElementById('pageDescription').textContent = config.page_description || defaultConfig.page_description;
            },
            mapToCapabilities: (config) => ({
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
    const options = {
      bottom: '32px',
      right: '32px',
      left: 'unset',
      time: '2.5s',
      mixColor: '#fff',
      backgroundColor: '#fff',
      buttonColorDark: '#100f2c',
      buttonColorLight: '#fff',
      saveInCookies: true,
      label: '🌓',
      autoMatchOsTheme: true
    }

    const darkmode = new Darkmode(options);
    darkmode.showWidget();

    window.addEventListener('load', () => {
      if (localStorage.getItem('darkmode') === 'true') {
        if (!darkmode.isActivated()) {
          darkmode.toggle();
        }
      }
    });

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