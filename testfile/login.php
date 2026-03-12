<!doctype html>
<html lang="vi" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập - Inventory Management System</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Inter', system-ui, sans-serif; }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
  </style>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a5a'
            }
          }
        }
      }
    }
  </script>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
</head>
<body class="h-full">
  <div id="app-wrapper" class="w-full h-full flex flex-col" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
    <main class="flex-1 flex items-center justify-center p-6 overflow-auto">
      <div class="w-full max-w-md">
        <div id="login-card" class="rounded-2xl shadow-xl p-8 md:p-10" style="background-color: #ffffff;">
          <!-- Logo & System Name -->
          <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl mb-4" style="background-color: #1e3a5a;">
              <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <h1 id="system-name" class="text-xl font-bold" style="color: #1e3a5a;">Inventory Management System</h1>
          </div>

          <h2 id="login-title" class="text-center text-lg font-semibold mb-6" style="color: #334155;">Đăng nhập hệ thống</h2>

          <!-- Error Message -->
          <div id="error-container" class="hidden mb-6">
            <div id="error-message" class="flex items-start gap-3 p-4 rounded-lg bg-red-50 border border-red-200">
              <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div>
                <p id="error-title" class="text-sm font-medium text-red-800"></p>
                <p id="error-detail" class="text-sm text-red-600 mt-0.5"></p>
              </div>
            </div>
          </div>

          <!-- Success Message -->
          <div id="success-container" class="hidden mb-6">
            <div class="flex items-center gap-3 p-4 rounded-lg bg-green-50 border border-green-200">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-sm font-medium text-green-800">Đăng nhập thành công! Đang chuyển hướng...</p>
            </div>
          </div>

          <!-- Login Form -->
          <form id="login-form" class="space-y-5">
            <!-- Username -->
            <div>
              <label for="username" class="block text-sm font-medium mb-2" style="color: #334155;">Tên đăng nhập</label>
              <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2" style="color: #64748b;">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </span>
                <input type="text" id="username" name="ten_dang_nhap" class="w-full pl-11 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all duration-200" style="background-color: #f8fafc; color: #1e293b;" placeholder="Nhập tên đăng nhập" autocomplete="username" required>
              </div>
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium mb-2" style="color: #334155;">Mật khẩu</label>
              <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2" style="color: #64748b;">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </span>
                <input type="password" id="password" name="mat_khau" class="w-full pl-11 pr-12 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all duration-200" style="background-color: #f8fafc; color: #1e293b;" placeholder="Nhập mật khẩu" autocomplete="current-password" required>
                <button type="button" id="toggle-password" class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 rounded hover:bg-gray-200 transition-colors" style="color: #64748b;" aria-label="Hiện/ẩn mật khẩu">
                  <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
              <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
              <label for="remember" class="ml-2.5 text-sm cursor-pointer" style="color: #475569;">Ghi nhớ đăng nhập</label>
            </div>

            <!-- Submit -->
            <button type="submit" id="login-button" class="w-full py-3.5 px-4 rounded-lg font-semibold text-white transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-lg active:scale-[0.98]" style="background-color: #1e3a5a;" onmouseover="this.style.backgroundColor='#2d4a6a'" onmouseout="this.style.backgroundColor='#1e3a5a'">
              <span id="login-button-text">Đăng nhập</span>
              <svg id="login-spinner" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
              </svg>
            </button>
          </form>
        </div>

        <p id="footer-text" class="text-center text-sm mt-6" style="color: #64748b;">© 2024 Inventory Management System. Hệ thống nội bộ.</p>
      </div>
    </main>
  </div>

  <script>
    // DOM Elements
    const form = document.getElementById('login-form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');
    const loginButton = document.getElementById('login-button');
    const loginButtonText = document.getElementById('login-button-text');
    const loginSpinner = document.getElementById('login-spinner');
    const errorContainer = document.getElementById('error-container');
    const errorTitle = document.getElementById('error-title');
    const errorDetail = document.getElementById('error-detail');
    const successContainer = document.getElementById('success-container');

    // Toggle password
    togglePasswordBtn.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      eyeIcon.classList.toggle('hidden', !isPassword);
      eyeOffIcon.classList.toggle('hidden', isPassword);
    });

    function showError(title, detail) {
      errorTitle.textContent = title;
      errorDetail.textContent = detail;
      errorContainer.classList.remove('hidden');
      successContainer.classList.add('hidden');
      errorContainer.style.animation = 'shake 0.6s ease-in-out';
    }

    function showSuccess() {
      successContainer.classList.remove('hidden');
      errorContainer.classList.add('hidden');
    }

    function hideMessages() {
      errorContainer.classList.add('hidden');
      successContainer.classList.add('hidden');
    }

    function setLoading(isLoading) {
      loginButton.disabled = isLoading;
      loginSpinner.classList.toggle('hidden', !isLoading);
      loginButtonText.classList.toggle('hidden', isLoading);
      loginButton.style.opacity = isLoading ? '0.8' : '1';
      loginButton.style.cursor = isLoading ? 'not-allowed' : 'pointer';
    }

    // Submit bằng AJAX - giữ UX mượt
    form.addEventListener('submit', async (e) => {

  e.preventDefault();
  hideMessages();

  const username = usernameInput.value.trim();
  const password = passwordInput.value;

  if (!username || !password) {
    showError('Thông tin chưa đầy đủ', 'Vui lòng nhập tên đăng nhập và mật khẩu.');
    return;
  }

  setLoading(true);

  try {

    const formData = new FormData(form);

    const response = await fetch('../actions/QuanLyDangNhap/login_action.php', {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (data.status === "success") {

      showSuccess();

      setTimeout(() => {
        window.location.href = "../public/dashboard.php";
      }, 1000);

    } else {

      showError("Đăng nhập thất bại", data.message);

    }

  } catch (error) {

    showError("Lỗi kết nối", "Không thể kết nối server.");

  } finally {

    setLoading(false);

  }

});

    // Xóa thông báo lỗi khi người dùng bắt đầu gõ lại
    usernameInput.addEventListener('input', hideMessages);
    passwordInput.addEventListener('input', hideMessages);

    // Initialize SDK
    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange,
        mapToCapabilities,
        mapToEditPanelValues
      });
    }

    // Add shake animation
    const style = document.createElement('style');
    style.textContent = `
      @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
      }
    `;
    document.head.appendChild(style);

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