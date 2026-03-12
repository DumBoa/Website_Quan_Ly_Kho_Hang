<?php
$role = $_SESSION["vai_tro"] ?? "";
$hoTen = $_SESSION["ho_ten"] ?? "User";
$ma_nguoi_dung = $_SESSION["ma_nguoi_dung"] ?? 0;

// Lấy avatar từ database
$avatar = '';
if ($ma_nguoi_dung > 0) {
    require_once __DIR__ . '/../../config/config.php';
    $stmt = $conn->prepare("SELECT anh_dai_dien FROM nguoi_dung WHERE ma_nguoi_dung = ?");
    $stmt->bind_param("i", $ma_nguoi_dung);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $avatar = $row['anh_dai_dien'];
    }
    $stmt->close();
}

// Xác định trang hiện tại để active menu
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="../public/CSS/asidemenu.css">

<aside class="wms-sidebar" id="sidebar">
    <!-- Header / Logo -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 7h-3a2 2 0 01-2-2V2"></path>
                <path d="M9 18a2 2 0 01-2-2V4a2 2 0 012-2h7l4 4v10a2 2 0 01-2 2H9z"></path>
                <path d="M3 7.6v12.8A1.6 1.6 0 004.6 22h9.8"></path>
            </svg>
        </div>
        <div class="sidebar-brand">
            <h1>WMS</h1>
            <p>Quản lý kho hàng</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <!-- ==================== DASHBOARD - TẤT CẢ ROLE ==================== -->
        <div class="nav-section">
            <div class="nav-section-title">Tổng quan</div>
            <a href="/Project_QuanLyKhoHang/public/dashboard.php" class="nav-item <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </span>
                <span class="nav-item-text">Dashboard</span>
            </a>
        </div>

        <!-- ==================== THỦ KHO ==================== -->
        <?php if ($role === "THU_KHO"): ?>
        
        <!-- Thông tin & Hàng hóa -->
        <div class="nav-section">
            <div class="nav-section-title">Thông tin & Hàng hóa</div>
            
            <a href="/Project_QuanLyKhoHang/public/quanlysanpham.php" class="nav-item <?= $current_page == 'quanlysanpham.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Hàng hóa</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlydanhmucsanpham.php" class="nav-item <?= $current_page == 'quanlydanhmucsanpham.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Danh mục</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlynhacungcap.php" class="nav-item <?= $current_page == 'quanlynhacungcap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 00-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Nhà cung cấp</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlykhohang.php" class="nav-item <?= $current_page == 'quanlykhohang.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Kho hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/tonkho.php" class="nav-item <?= $current_page == 'tonkho.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3h18v18H3z"></path>
                        <path d="M12 8v8"></path>
                        <path d="M8 12h8"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Tồn kho</span>
            </a>
        </div>

        <!-- Hoạt động -->
        <div class="nav-section">
            <div class="nav-section-title">Hoạt động</div>
            
            <a href="/Project_QuanLyKhoHang/public/phieunhap.php" class="nav-item <?= $current_page == 'phieunhap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Nhập hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/phieuxuat.php" class="nav-item <?= $current_page == 'phieuxuat.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Xuất hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/baocaothongke.php" class="nav-item <?= $current_page == 'baocaothongke.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Báo cáo</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/kiemkekho.php" class="nav-item <?= $current_page == 'kiemkekho.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20v-8"></path>
                        <path d="M4 8l8-4 8 4"></path>
                        <path d="M4 16l8 4 8-4"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Kiểm kê kho</span>
            </a>
        </div>

        <?php endif; ?>


        <!-- ==================== QUẢN LÝ ==================== -->
        <?php if ($role === "QUAN_LY"): ?>

        <!-- Thông tin & Hàng hóa -->
        <div class="nav-section">
            <div class="nav-section-title">Thông tin & Hàng hóa</div>
            
            <a href="/Project_QuanLyKhoHang/public/quanlysanpham.php" class="nav-item <?= $current_page == 'quanlysanpham.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Hàng hóa</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlydanhmucsanpham.php" class="nav-item <?= $current_page == 'quanlydanhmucsanpham.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Danh mục</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlynhacungcap.php" class="nav-item <?= $current_page == 'quanlynhacungcap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 00-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Nhà cung cấp</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlykhohang.php" class="nav-item <?= $current_page == 'quanlykhohang.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Kho hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/tonkho.php" class="nav-item <?= $current_page == 'tonkho.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3h18v18H3z"></path>
                        <path d="M12 8v8"></path>
                        <path d="M8 12h8"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Tồn kho</span>
            </a>
        </div>

        <!-- Hoạt động -->
        <div class="nav-section">
            <div class="nav-section-title">Hoạt động</div>
            
            <a href="/Project_QuanLyKhoHang/public/phieunhap.php" class="nav-item <?= $current_page == 'phieunhap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Nhập hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/phieuxuat.php" class="nav-item <?= $current_page == 'phieuxuat.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Xuất hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/baocaothongke.php" class="nav-item <?= $current_page == 'baocaothongke.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Báo cáo</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/kiemkekho.php" class="nav-item <?= $current_page == 'kiemkekho.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20v-8"></path>
                        <path d="M4 8l8-4 8 4"></path>
                        <path d="M4 16l8 4 8-4"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Kiểm kê kho</span>
            </a>
        </div>

        <!-- Duyệt phiếu -->
        <div class="nav-section">
            <div class="nav-section-title">Duyệt phiếu</div>
            
            <a href="/Project_QuanLyKhoHang/public/duyetphieunhap.php" class="nav-item <?= $current_page == 'duyetphieunhap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Duyệt phiếu nhập</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/duyetphieuxuat.php" class="nav-item <?= $current_page == 'duyetphieuxuat.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Duyệt phiếu xuất</span>
            </a>
        </div>

        <?php endif; ?>


        <!-- ==================== ADMIN ==================== -->
        <?php if ($role === "ADMIN"): ?>

  

        <!-- Thông tin & Hàng hóa -->
        <div class="nav-section">
            <div class="nav-section-title">Thông tin & Hàng hóa</div>
            
            <a href="/Project_QuanLyKhoHang/public/quanlysanpham.php" class="nav-item <?= $current_page == 'quanlysanpham.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Hàng hóa</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlydanhmucsanpham.php" class="nav-item <?= $current_page == 'quanlydanhmucsanpham.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Danh mục</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlynhacungcap.php" class="nav-item <?= $current_page == 'quanlynhacungcap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 00-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Nhà cung cấp</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlykhohang.php" class="nav-item <?= $current_page == 'quanlykhohang.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Kho hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/tonkho.php" class="nav-item <?= $current_page == 'tonkho.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3h18v18H3z"></path>
                        <path d="M12 8v8"></path>
                        <path d="M8 12h8"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Tồn kho</span>
            </a>
        </div>

        <!-- Hoạt động -->
        <div class="nav-section">
            <div class="nav-section-title">Hoạt động</div>
            
            <a href="/Project_QuanLyKhoHang/public/phieunhap.php" class="nav-item <?= $current_page == 'phieunhap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Nhập hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/phieuxuat.php" class="nav-item <?= $current_page == 'phieuxuat.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Xuất hàng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/duyetphieunhap.php" class="nav-item <?= $current_page == 'duyetphieunhap.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Duyệt phiếu nhập</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/duyetphieuxuat.php" class="nav-item <?= $current_page == 'duyetphieuxuat.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="nav-item-text">Duyệt phiếu xuất</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/baocaothongke.php" class="nav-item <?= $current_page == 'baocaothongke.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </span>
                <span class="nav-item-text">Báo cáo</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/kiemkekho.php" class="nav-item <?= $current_page == 'kiemkekho.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20v-8"></path>
                        <path d="M4 8l8-4 8 4"></path>
                        <path d="M4 16l8 4 8-4"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Kiểm kê kho</span>
            </a>
        </div>

        <!-- Hệ thống -->
        <div class="nav-section">
            <div class="nav-section-title">Hệ thống</div>

            <a href="/Project_QuanLyKhoHang/public/quanlynguoidung.php" class="nav-item <?= $current_page == 'quanlynguoidung.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                </span>
                <span class="nav-item-text">Quản lý người dùng</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/quanlyvaitro.php" class="nav-item <?= $current_page == 'quanlyvaitro.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Quản lý vai trò</span>
            </a>

            <a href="/Project_QuanLyKhoHang/public/lichsuhethong.php" class="nav-item <?= $current_page == 'lichsuhethong.php' ? 'active' : '' ?>">
                <span class="nav-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
                <span class="nav-item-text">Lịch sử hệ thống</span>
            </a>
        </div>

        <?php endif; ?>

    </nav>

    <!-- User Info với Avatar -->
    <a href="../public/profile.php">
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <?php if ($avatar && file_exists(__DIR__ . '/../../uploads/avatars/' . $avatar)): ?>
                        <img src="/Project_QuanLyKhoHang/uploads/avatars/<?= htmlspecialchars($avatar) ?>" 
                            alt="Avatar" 
                            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        <?= strtoupper(substr($hoTen ?? 'User', 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        <?= htmlspecialchars($hoTen ?? 'Người dùng') ?>
                    </div>
                    <div class="sidebar-user-role">
                        <?= htmlspecialchars($role ?? 'Không xác định') ?>
                    </div>
                </div>
            </div>
        </div>
    </a>
</aside>