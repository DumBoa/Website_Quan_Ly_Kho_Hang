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

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arvo', serif;
            background: #f4f4f4;
            color: #333;
            line-height: 1.6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background: #1a1a1a;
            color: #f4f4f4;
        }

        .page_404 {
            padding: 40px 15px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        .four_zero_four_bg {
            background-image: url('https://cdn.dribbble.com/users/722246/screenshots/3066818/404-page.gif');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height: 400px;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .four_zero_four_bg h1 {
            font-size: clamp(120px, 20vw, 180px);
            font-weight: 700;
            color: #39ac31;
            line-height: 1;
            margin-bottom: 20px;
        }

        .contant_box_404 {
            max-width: 600px;
            margin: 0 auto;
        }

        h3 {
            font-size: clamp(28px, 6vw, 50px);
            margin-bottom: 20px;
            color: #2c3e50;
        }

        body.dark-mode h3 {
            color: #e0e0e0;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #555;
        }

        body.dark-mode p {
            color: #aaa;
        }

        .link_404 {
            display: inline-block;
            padding: 14px 32px;
            background: #39ac31;
            color: white !important;
            text-decoration: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(57, 172, 49, 0.3);
        }

        .link_404:hover {
            background: #2e8b2e;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(57, 172, 49, 0.4);
        }

        /* Dark mode toggle button positioning */
        .darkmode-toggle {
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .four_zero_four_bg {
                height: 300px;
                background-size: contain;
            }
            
            .page_404 {
                padding: 30px 15px;
            }
        }
                /* Stars background - chỉ hiển thị khi darkmode */
        .stars-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0;
            transition: opacity 1s ease;
        }
        
        body.dark-mode .stars-container {
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
        
        .star-small { width: 2px; height: 2px; }
        .star-medium { width: 3px; height: 3px; }
        .star-large { width: 4px; height: 4px; }
        
        .star-cluster {
            position: absolute;
            width: 30px;
            height: 30px;
        }
        
        .star-cluster .star {
            position: absolute;
        }
    </style>
</head>
<body>

    <!-- Stars Container - Chỉ hiển thị khi darkmode -->
    <div class="stars-container" id="stars-container"></div>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    
                    <div class="four_zero_four_bg">
                        <!-- 404 animation from Dribbble -->
                    </div>
                    
                    <div class="contant_box_404">
                        <h3>Oops! Bạn bị lạc rồi!</h3>
                        
                        <p>Trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển.</p>
                        
                        <a href="../public/dashboard.php" class="link_404">Quay về trang chủ</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>

    <script>
        // ==================== DARKMODE CONFIGURATION ====================
        (function() {
            // Cấu hình Darkmode
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
            };

            // Khởi tạo Darkmode
            const darkmode = new Darkmode(options);
            
            // Hiển thị nút toggle
            darkmode.showWidget();

            // Áp dụng chế độ đã lưu
            function applySavedMode() {
                const isDark = localStorage.getItem('darkmode') === 'true';
                if (isDark && !darkmode.isActivated()) {
                    darkmode.toggle();
                } else if (!isDark && darkmode.isActivated()) {
                    darkmode.toggle();
                }
            }

            // Lắng nghe sự kiện click vào nút darkmode
                       // Lắng nghe sự kiện click vào nút darkmode
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList && e.target.classList.contains('darkmode-toggle')) {
                    setTimeout(function() {
                        localStorage.setItem('darkmode', darkmode.isActivated());
                        
                        // Thêm/xóa class dark-mode cho body
                        if (darkmode.isActivated()) {
                            document.body.classList.add('dark-mode');
                        } else {
                            document.body.classList.remove('dark-mode');
                        }
                    }, 100);
                }
            });

            // Áp dụng khi trang load
            window.addEventListener('load', function() {
                applySavedMode();
                
                // Đồng bộ class với trạng thái darkmode
                if (darkmode.isActivated()) {
                    document.body.classList.add('dark-mode');
                }
            });

            // Lắng nghe thay đổi từ localStorage (đồng bộ giữa các tab)
            window.addEventListener('storage', function(e) {
                if (e.key === 'darkmode') {
                    if (e.newValue === 'true' && !darkmode.isActivated()) {
                        darkmode.toggle();
                        document.body.classList.add('dark-mode');
                    } else if (e.newValue === 'false' && darkmode.isActivated()) {
                        darkmode.toggle();
                        document.body.classList.remove('dark-mode');
                    }
                }
            });

        })();
        // ==================== STARS EFFECT ====================
        function createStars() {
            const starsContainer = document.getElementById('stars-container');
            if (!starsContainer) return;
            
            starsContainer.innerHTML = '';
            
            // Create 200 normal stars
            for (let i = 0; i < 200; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                
                const size = Math.random();
                if (size < 0.6) star.classList.add('star-small');
                else if (size < 0.9) star.classList.add('star-medium');
                else star.classList.add('star-large');
                
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 5 + 's';
                
                starsContainer.appendChild(star);
            }
            
            // Create 10 shooting stars
            for (let i = 0; i < 10; i++) {
                const shootingStar = document.createElement('div');
                shootingStar.className = 'shooting-star';
                shootingStar.style.left = Math.random() * 70 + '%';
                shootingStar.style.top = Math.random() * 30 + '%';
                shootingStar.style.animationDelay = Math.random() * 10 + 's';
                starsContainer.appendChild(shootingStar);
            }
            
            // Create star clusters
            for (let j = 0; j < 15; j++) {
                const cluster = document.createElement('div');
                cluster.className = 'star-cluster';
                cluster.style.left = Math.random() * 90 + '%';
                cluster.style.top = Math.random() * 90 + '%';
                
                const starCount = Math.floor(Math.random() * 5) + 3;
                for (let k = 0; k < starCount; k++) {
                    const star = document.createElement('div');
                    star.className = 'star star-small';
                    star.style.left = (Math.random() * 20 - 10) + 'px';
                    star.style.top = (Math.random() * 20 - 10) + 'px';
                    star.style.animationDelay = Math.random() * 5 + 's';
                    cluster.appendChild(star);
                }
                
                starsContainer.appendChild(cluster);
            }
        }

        // Gọi function khi trang load
        window.addEventListener('load', function() {
            createStars();
            // Giữ nguyên các function khác
            applySavedMode();
            if (darkmode.isActivated()) {
                document.body.classList.add('dark-mode');
            }
        });
        // ==================== ADDITIONAL DEBUG INFO (Có thể xóa trong production) ====================
        console.log('404 page loaded at:', new Date().toLocaleString('vi-VN'));
        console.log('User:', {
            ten: '<?php echo $ten; ?>',
            vai_tro: '<?php echo $role; ?>',
            ten_dang_nhap: '<?php echo $username; ?>'
        });

    </script>

    <!-- Thông tin debug ẩn (chỉ hiện trong console) -->
    <!-- 
        Trang 404 được thiết kế với:
        - Font Arvo từ Google Fonts
        - Animation 404 từ Dribbble
        - Darkmode toggle button
        - Responsive cho mobile
    -->

</body>
</html>