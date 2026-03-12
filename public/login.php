<!doctype html>
<html lang="vi">
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
    * { font-family: 'Inter', system-ui, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body { 
        height: 100vh; 
        overflow: hidden; 
        background: linear-gradient(135deg, #4b26c3 0%, #2f177d 100%);
    }
    
    /* Animation cho thông báo đẩy từ trên xuống */
    @keyframes slideInDown {
      from { transform: translate(-50%, -100%); opacity: 0; }
      to { transform: translate(-50%, 0); opacity: 1; }
    }
    .notification-animation {
      animation: slideInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Tuỳ chỉnh input autofill để không bị đổi màu nền */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px white inset !important;
        -webkit-text-fill-color: #1f2937 !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* QUAN TRỌNG: Vô hiệu hóa darkmode trên toàn bộ container chứa ảnh */
    
    .darkmode-toggle {
        z-index: 9999 !important;
    }
    
    /* Đảm bảo phần tử chứa ảnh và ảnh không bị darkmode tác động */
    .keep-color,
    .keep-color img,
    img[src*="bg_login.png"] {
        filter: none !important;
        mix-blend-mode: normal !important;
        isolation: isolate !important;
        position: relative !important;
        z-index: 30 !important;
    }
    
    /* Thêm một lớp overlay trong suốt để chặn darkmode */
    .keep-color::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: transparent;
        z-index: 31;
        pointer-events: none;
    }

    /* Đảm bảo darkmode không ảnh hưởng đến khu vực ảnh */
    .darkmode--activated .keep-color,
    .darkmode--activated .keep-color img,
    .darkmode--activated img[src*="bg_login.png"] {
        filter: none !important;
        background-color: transparent !important;
        mix-blend-mode: normal !important;
    }

    /* Vô hiệu hóa darkmode trên toàn bộ body con nhưng vẫn giữ nút hoạt động */
    .darkmode--activated body > *:not(.darkmode-layer):not(.darkmode-toggle) {
        position: relative;
        z-index: 1;
    }
      /* QUAN TRỌNG: Vô hiệu hóa darkmode trên ảnh */
    .darkmode--activated img[src*="bg_login.png"],
    .darkmode--activated .keep-color,
    .darkmode--activated .keep-color * {
        filter: none !important;
        mix-blend-mode: normal !important;
        background-color: transparent !important;
        opacity: 1 !important;
        isolation: isolate !important;
    }
    
    /* Đảm bảo ảnh luôn hiển thị đúng */
    img[src*="bg_login.png"] {
        position: relative !important;
        z-index: 9999 !important;
    }
    
    /* Đẩy darkmode layer xuống dưới ảnh */
    .darkmode-layer {
        z-index: 2 !important;
    }
    
    /* Giữ nguyên màu cho khu vực ảnh */
    .keep-color {
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
    }

    /* Stars background - chỉ hiển thị khi darkmode */
    .stars-container {
    position: fixed;
    inset: 0;                   /* thay cho top:0 left:0 width:100% height:100% */
    pointer-events: none;
    z-index: 10;                 /* thấp hơn card (z-10) nhưng cao hơn nền gradient */
    opacity: 0;
    transition: opacity 0.6s ease;
}
    .bg-white.rounded-\[30px\] {
    z-index: 1;                /* hoặc 20 nếu vẫn bị che */
}
    .darkmode--activated .stars-container {
        opacity: 1;
    }
    
    .star {
        position: absolute;
        background-color: white;
        border-radius: 50%;
        animation: twinkle 3s infinite ease-in-out;
    }
    
    @keyframes twinkle {
        0%, 100% { opacity: 0.2; transform: scale(0.8); }
        50% { opacity: 1; transform: scale(1.2); }
    }
    
    /* Shooting stars */
    .shooting-star {
        position: absolute;
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.8);
        opacity: 0;
        animation: shoot 4s linear infinite;
    }
    
    @keyframes shoot {
        0% {
            transform: translateX(0) translateY(0) rotate(45deg);
            opacity: 1;
            width: 2px;
            height: 2px;
        }
        70% {
            opacity: 1;
        }
        100% {
            transform: translateX(200px) translateY(200px) rotate(45deg);
            opacity: 0;
            width: 0px;
            height: 0px;
        }
    }
    
    /* Small stars with different sizes */
    .star-small { width: 2px; height: 2px; }
    .star-medium { width: 3px; height: 3px; }
    .star-large { width: 4px; height: 4px; }
    
    /* Star clusters */
    .star-cluster {
        position: absolute;
        width: 30px;
        height: 30px;
    }
    
    .star-cluster .star {
        position: absolute;
    }
  </style>
  <script>
    // Thêm đoạn script này ngay sau style
    (function() {
        // Tạo observer để theo dõi khi darkmode thay đổi
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class' && 
                    document.documentElement.classList.contains('darkmode--activated')) {
                    
                    // Tìm và reset ảnh ngay lập tức
                    const images = document.querySelectorAll('img[src*="bg_login.png"]');
                    images.forEach(function(img) {
                        img.style.setProperty('filter', 'none', 'important');
                        img.style.setProperty('mix-blend-mode', 'normal', 'important');
                        img.style.setProperty('background-color', 'transparent', 'important');
                    });
                }
            });
        });
        
        // Bắt đầu theo dõi
        observer.observe(document.documentElement, { attributes: true });
        
        // Cũng theo dõi khi click vào nút darkmode
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('darkmode-toggle')) {
                setTimeout(function() {
                    const images = document.querySelectorAll('img[src*="bg_login.png"]');
                    images.forEach(function(img) {
                        img.style.setProperty('filter', 'none', 'important');
                        img.style.setProperty('mix-blend-mode', 'normal', 'important');
                    });
                }, 50);
            }
        });
    })();
</script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              main: '#362194', // Màu xanh tím chủ đạo của chữ và nút
              bg: '#4122b1'    // Màu nền gradient
            }
          }
        }
      }
    }
  </script>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
</head>
<body class="flex items-center justify-center p-4 relative">

    <!-- Stars Container - Chỉ hiển thị khi darkmode -->
    <div class="stars-container fixed inset-0 pointer-events-none z-[5]" id="stars-container">
        <!-- stars sẽ được tạo bằng JS -->
    </div>

    <!-- Các chấm trắng trang trí nền (giữ lại để hiển thị mặc định) -->
    <div class="absolute top-12 left-1/3 w-2 h-2 bg-white rounded-full opacity-80 shadow-[0_0_10px_white]"></div>
    <div class="absolute top-24 right-1/4 w-3 h-3 bg-white rounded-full opacity-60"></div>
    <div class="absolute bottom-1/4 left-1/4 w-2 h-2 bg-white rounded-full opacity-40"></div>

    <!-- Khu vực thông báo - KHÔNG bị ảnh hưởng bởi darkmode nhờ z-index cao -->
    <div id="notification-area" class="fixed top-6 left-1/2 z-50 w-full max-w-md px-4 pointer-events-none">
      
      <div id="error-notification" class="hidden w-full bg-white rounded-xl shadow-2xl border-l-4 border-red-500 overflow-hidden notification-animation pointer-events-auto">
        <div class="flex items-start gap-4 p-4">
          <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="flex-1">
            <h3 id="error-title" class="text-sm font-bold text-gray-900 mb-1"></h3>
            <p id="error-detail" class="text-sm text-gray-600"></p>
          </div>
          <button onclick="hideNotification()" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
      </div>

      <div id="success-notification" class="hidden w-full bg-white rounded-xl shadow-2xl border-l-4 border-green-500 overflow-hidden notification-animation pointer-events-auto">
        <div class="flex items-start gap-4 p-4">
          <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="flex-1">
            <p class="text-sm font-medium text-gray-900">Đăng nhập thành công! Đang chuyển hướng...</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Card chính màu trắng -->
    <div class="bg-white rounded-[30px] w-full max-w-[1100px] h-[650px] shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex flex-col relative z-10 overflow-hidden">
        
        <!-- Header với menu Home, App, Web, Login, signup -->
        <div class="flex justify-between items-center px-12 pt-8 pb-4">
            <div class="flex items-center gap-10 text-xs font-semibold text-gray-800">
                <div class="w-4 h-4 bg-brand-main rounded-[3px] flex items-center justify-center rotate-45">
                    <div class="w-1.5 h-1.5 bg-white rounded-sm"></div>
                </div>
                <a href="#" class="hover:text-brand-main transition-colors">Home</a>
                <a href="#" class="hover:text-brand-main transition-colors">App</a>
                <a href="#" class="hover:text-brand-main transition-colors">Web</a>
            </div>
            <div class="flex items-center gap-8 text-xs font-semibold">
                <a href="#" class="text-brand-main border-b-2 border-brand-main pb-1">Log in</a>
                
            </div>
        </div>

        <!-- Nội dung chính: Ảnh bên trái, Form bên phải -->
        <div class="flex flex-1 items-center px-8 pb-8">
            
            <!-- Khu vực ảnh - ĐƯỢC BẢO VỆ KHỎI DARKMODE -->
            <div class="hidden lg:flex w-3/5 justify-center items-center relative keep-color" id="image-protected-area">
                <img src="../assets/bg_login.png" alt="Night Scene" class="w-full max-w-[550px] object-contain ml-8 scale-110 relative" style="filter: none !important;" id="protected-image" />
            </div>

            <!-- Khu vực form đăng nhập -->
            <div class="w-full lg:w-2/5 px-12 lg:px-8 mt-[-40px]">
                
                <div class="mb-12">
                    <h1 class="text-[32px] font-bold text-brand-main leading-tight tracking-wide">Hey!</h1>
                    <h2 class="text-[32px] font-bold text-brand-main leading-tight tracking-wide">Welcome back</h2>
                </div>

                <form id="login-form" class="space-y-8">
                    
                    <!-- Username field -->
                    <div class="relative">
                        <label for="username" class="block text-[11px] font-semibold text-gray-400 mb-1 uppercase tracking-wider">User Name</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="ten_dang_nhap" 
                            class="w-full border-b border-gray-200 py-2 text-sm text-gray-800 font-medium focus:outline-none focus:border-brand-main bg-transparent transition-colors placeholder-gray-800"
                            placeholder="Tên Đăng Nhập"
                            autocomplete="username"
                            required
                        >
                    </div>

                    <!-- Password field -->
                    <div class="relative">
                        <label for="password" class="block text-[11px] font-semibold text-gray-400 mb-1 uppercase tracking-wider">Pass Word</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="mat_khau" 
                            class="w-full border-b border-gray-200 py-2 text-lg text-gray-800 focus:outline-none focus:border-brand-main bg-transparent transition-colors placeholder-gray-800 pr-10 tracking-[0.2em]"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" id="toggle-password" class="absolute right-0 top-1/2 translate-y-[-20%] text-gray-400 hover:text-gray-600">
                            <svg id="eye-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-off-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>

                    <!-- Forgot password link -->
                    <div class="flex justify-end pt-1">
                        <a href="#" class="text-[11px] font-bold text-brand-main hover:text-brand-bg transition-colors">Forget?</a>
                    </div>

                    <!-- Login button -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            id="login-button" 
                            class="w-36 py-3 bg-brand-main text-white text-sm font-semibold rounded-[10px] shadow-[0_8px_20px_rgba(54,33,148,0.4)] hover:bg-brand-bg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            <span id="login-button-text">Login</span>
                            <svg id="login-spinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript - Giữ nguyên hoàn toàn chức năng -->
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
        
        const errorNotification = document.getElementById('error-notification');
        const successNotification = document.getElementById('success-notification');
        const errorTitle = document.getElementById('error-title');
        const errorDetail = document.getElementById('error-detail');

        // Toggle password visibility
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', !isPassword);
            eyeOffIcon.classList.toggle('hidden', isPassword);
        });

        function hideNotification() {
            errorNotification.classList.add('hidden');
            successNotification.classList.add('hidden');
        }

        function showError(title, detail) {
            errorTitle.textContent = title;
            errorDetail.textContent = detail;
            errorNotification.classList.remove('hidden');
            successNotification.classList.add('hidden');
            setTimeout(() => { 
                errorNotification.classList.add('hidden'); 
            }, 5000);
        }

        function showSuccess() {
            successNotification.classList.remove('hidden');
            errorNotification.classList.add('hidden');
        }

        function setLoading(isLoading) {
            loginButton.disabled = isLoading;
            loginSpinner.classList.toggle('hidden', !isLoading);
            loginButtonText.classList.toggle('hidden', isLoading);
        }

        // Form submit handler
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideNotification();

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

        // Hide notifications when typing
        usernameInput.addEventListener('input', hideNotification);
        passwordInput.addEventListener('input', hideNotification);

        if (window.elementSdk) {
            window.elementSdk.init({ 
                defaultConfig: {}, 
                onConfigChange: () => {}, 
                mapToCapabilities: () => {}, 
                mapToEditPanelValues: () => {} 
            });
        }

        // Function to create stars
        function createStars() {
    const container = document.getElementById('stars-container');
    if (!container) return;

    // Xóa sạch trước khi tạo lại (tránh trùng lặp khi reload/toggle nhiều lần)
    container.innerHTML = '';

    // Normal stars
    for (let i = 0; i < 180; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        
        const sizeClass = Math.random() < 0.6 ? 'star-small' :
                         Math.random() < 0.9 ? 'star-medium' : 'star-large';
        star.classList.add(sizeClass);

        star.style.left = Math.random() * 100 + '%';
        star.style.top  = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 6 + 's';
        
        container.appendChild(star);
    }

    // Shooting stars
    for (let i = 0; i < 8; i++) {
        const shooting = document.createElement('div');
        shooting.className = 'shooting-star';
        shooting.style.left = Math.random() * 80 + '%';
        shooting.style.top  = Math.random() * 40 + '%';
        shooting.style.animationDelay = Math.random() * 12 + 's';
        container.appendChild(shooting);
    }

    // Star clusters (tùy chọn)
    for (let j = 0; j < 12; j++) {
        const cluster = document.createElement('div');
        cluster.className = 'star-cluster';
        cluster.style.left = Math.random() * 100 + '%';
        cluster.style.top  = Math.random() * 100 + '%';

        const count = Math.floor(Math.random() * 5) + 3;
        for (let k = 0; k < count; k++) {
            const star = document.createElement('div');
            star.className = 'star star-small';
            star.style.left = (Math.random() * 40 - 20) + 'px';
            star.style.top  = (Math.random() * 40 - 20) + 'px';
            star.style.animationDelay = Math.random() * 5 + 's';
            cluster.appendChild(star);
        }
        container.appendChild(cluster);
    }
}

// Gọi lại khi darkmode thay đổi (tăng độ tin cậy)
window.addEventListener('load', createStars);

// Thêm listener theo dõi darkmode (rất hữu ích nếu toggle nhiều lần)
const darkmodeObserver = new MutationObserver(() => {
    if (document.documentElement.classList.contains('darkmode--activated')) {
        // Đảm bảo stars được tạo và hiển thị
        createStars(); // gọi lại để chắc chắn
        document.getElementById('stars-container').style.opacity = '1';
    }
});
darkmodeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

        // Call createStars when page loads
        window.addEventListener('load', createStars);
    </script>

    <!-- Darkmode Script - Đã cấu hình để không ảnh hưởng đến ảnh -->
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <script>
        // Cấu hình darkmode
        const options = {
            bottom: '32px', 
            right: '32px', 
            left: 'unset', 
            time: '2.5s', // Đặt thành 0s để tránh hiệu ứng chuyển tiếp làm ảnh hưởng
            mixColor: '#fff', 
            backgroundColor: '#fff', 
            buttonColorDark: '#100f2c',
            buttonColorLight: '#fff', 
            saveInCookies: true, 
            label: '🌓', 
            autoMatchOsTheme: true
        };

        // Khởi tạo darkmode
        const darkmode = new Darkmode(options);
        
        // Customize darkmode để bảo vệ ảnh
        const originalToggle = darkmode.toggle;
        darkmode.toggle = function() {
            originalToggle.apply(this, arguments);
            
            // Sau khi toggle, đảm bảo ảnh vẫn giữ nguyên
            setTimeout(() => {
                const protectedImage = document.getElementById('protected-image');
                const imageArea = document.getElementById('image-protected-area');
                
                if (protectedImage) {
                    protectedImage.style.filter = 'none';
                    protectedImage.style.mixBlendMode = 'normal';
                }
                
                if (imageArea) {
                    imageArea.style.filter = 'none';
                    imageArea.style.mixBlendMode = 'normal';
                }
                
                // Thêm class đặc biệt để bảo vệ ảnh
                document.documentElement.style.setProperty('--darkmode-bg-image', 'none');
            }, 10);
        };

        // Hiển thị widget
        darkmode.showWidget();

        // Kiểm tra và khôi phục ảnh mỗi khi darkmode thay đổi
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class' && 
                    document.documentElement.classList.contains('darkmode--activated')) {
                    
                    const protectedImage = document.getElementById('protected-image');
                    const imageArea = document.getElementById('image-protected-area');
                    
                    if (protectedImage) {
                        protectedImage.style.setProperty('filter', 'none', 'important');
                        protectedImage.style.setProperty('mix-blend-mode', 'normal', 'important');
                    }
                    
                    if (imageArea) {
                        imageArea.style.setProperty('filter', 'none', 'important');
                        imageArea.style.setProperty('mix-blend-mode', 'normal', 'important');
                    }
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });

        window.addEventListener('load', () => {
            if (localStorage.getItem('darkmode') === 'true') {
                if (!darkmode.isActivated()) {
                    darkmode.toggle();
                }
            }
            
            // Đảm bảo ảnh không bị ảnh hưởng sau khi load
            setTimeout(() => {
                const protectedImage = document.getElementById('protected-image');
                if (protectedImage) {
                    protectedImage.style.filter = 'none';
                    protectedImage.style.mixBlendMode = 'normal';
                }
            }, 100);
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('darkmode-toggle')) {
                setTimeout(() => { 
                    localStorage.setItem('darkmode', darkmode.isActivated());
                    
                    // Đảm bảo ảnh không bị ảnh hưởng sau khi click
                    const protectedImage = document.getElementById('protected-image');
                    if (protectedImage) {
                        protectedImage.style.filter = 'none';
                        protectedImage.style.mixBlendMode = 'normal';
                    }
                }, 50);
            }
        });
    </script>
</body>
</html>