

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
  <title>Báo Cáo &amp; Thống Kê Kho</title>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link rel="stylesheet" href="../public/CSS/baocaothongke.css">
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
   
  </style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <style>body { box-sizing: border-box; }</style>
 </head>
 <body class="h-full">
  <div class="wms-app">
   <!-- Sidebar -->
   
   
   
   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>
   
   
   <!-- Main Content -->
   <main class="main-content">
    <!-- Topbar -->
    
    
    
     <?php include __DIR__ . "/../views/Layout/header.php"; ?>
    
    
    <!-- Page Content -->
    <div class="p-6" id="pageContent"><!-- Dashboard View -->
     <div id="dashboardView"><!-- Breadcrumb & Title -->
      <div class="mb-8 animate-fade-in">
       <nav class="flex items-center gap-2 text-sm text-gray-500 mb-3"><a href="#" class="hover:text-navy-600">Trang chủ</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg><span class="text-gray-900">Báo cáo</span>
       </nav>
       <h1 class="text-3xl font-bold text-navy-900" id="pageTitle">BÁO CÁO &amp; THỐNG KÊ KHO</h1>
       <p class="text-gray-600 mt-2">Quản lý và theo dõi toàn bộ hoạt động nhập - xuất - tồn kho</p>
      </div><!-- Quick Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
       <div class="card p-5">
        <div class="flex items-center justify-between">
         <div>
          <p class="text-sm text-gray-600 mb-1">Phiếu nhập</p>
          <p class="text-2xl font-bold text-navy-900">48</p>
         </div>
         <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-xl">
          📥
         </div>
        </div>
       </div>
       <div class="card p-5">
        <div class="flex items-center justify-between">
         <div>
          <p class="text-sm text-gray-600 mb-1">Phiếu xuất</p>
          <p class="text-2xl font-bold text-navy-900">92</p>
         </div>
         <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-xl">
          📤
         </div>
        </div>
       </div>
       <div class="card p-5">
        <div class="flex items-center justify-between">
         <div>
          <p class="text-sm text-gray-600 mb-1">Sản phẩm</p>
          <p class="text-2xl font-bold text-navy-900">156</p>
         </div>
         <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-xl">
          📦
         </div>
        </div>
       </div>
       <div class="card p-5">
        <div class="flex items-center justify-between">
         <div>
          <p class="text-sm text-gray-600 mb-1">Giá trị tồn</p>
          <p class="text-2xl font-bold text-navy-900">$524K</p>
         </div>
         <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center text-xl">
          💰
         </div>
        </div>
       </div>
      </div><!-- Report Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"><!-- Import Report -->
       <div class="card p-6 hover:shadow-lg transition-shadow cursor-pointer" onclick="navigateToReport('import')">
        <div class="flex items-start justify-between mb-4">
         <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-2xl">
          📥
         </div>
         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Báo cáo phiếu nhập</h3>
        <p class="text-sm text-gray-600 mb-4">Thống kê toàn bộ phiếu nhập kho theo nhà cung cấp, thời gian và giá trị</p>
        <div class="flex items-center gap-2 text-navy-600 text-sm font-medium"><span>Xem báo cáo</span>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
         </svg>
        </div>
       </div><!-- Export Report -->
       <div class="card p-6 hover:shadow-lg transition-shadow cursor-pointer" onclick="navigateToReport('export')">
        <div class="flex items-start justify-between mb-4">
         <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-2xl">
          📤
         </div>
         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Báo cáo phiếu xuất</h3>
        <p class="text-sm text-gray-600 mb-4">Theo dõi phiếu xuất kho theo bộ phận nhận, thời gian và giá trị xuất</p>
        <div class="flex items-center gap-2 text-navy-600 text-sm font-medium"><span>Xem báo cáo</span>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
         </svg>
        </div>
       </div><!-- Inventory Report -->
       <div class="card p-6 hover:shadow-lg transition-shadow cursor-pointer" onclick="navigateToReport('inventory')">
        <div class="flex items-start justify-between mb-4">
         <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-2xl">
          🏢
         </div>
         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Báo cáo tồn kho</h3>
        <p class="text-sm text-gray-600 mb-4">Tình trạng tồn kho hiện tại theo kho, danh mục và giá trị tồn</p>
        <div class="flex items-center gap-2 text-navy-600 text-sm font-medium"><span>Xem báo cáo</span>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
         </svg>
        </div>
       </div><!-- Movement Report -->
       <div class="card p-6 hover:shadow-lg transition-shadow cursor-pointer" onclick="navigateToReport('movement')">
        <div class="flex items-start justify-between mb-4">
         <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-2xl">
          📊
         </div>
         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Báo cáo nhập - xuất - tồn</h3>
        <p class="text-sm text-gray-600 mb-4">Theo dõi biến động kho với chi tiết tồn đầu, nhập, xuất, tồn cuối</p>
        <div class="flex items-center gap-2 text-navy-600 text-sm font-medium"><span>Xem báo cáo</span>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
         </svg>
        </div>
       </div><!-- Product Report -->
       <div class="card p-6 hover:shadow-lg transition-shadow cursor-pointer" onclick="navigateToReport('product')">
        <div class="flex items-start justify-between mb-4">
         <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-2xl">
          📦
         </div>
         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Báo cáo sản phẩm</h3>
        <p class="text-sm text-gray-600 mb-4">Thống kê chi tiết sản phẩm trong kho, tần suất nhập xuất</p>
        <div class="flex items-center gap-2 text-navy-600 text-sm font-medium"><span>Xem báo cáo</span>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
         </svg>
        </div>
       </div><!-- Supplier Report -->
       <div class="card p-6 hover:shadow-lg transition-shadow cursor-pointer" onclick="navigateToReport('supplier')">
        <div class="flex items-start justify-between mb-4">
         <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center text-2xl">
          🚚
         </div>
         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Báo cáo nhà cung cấp</h3>
        <p class="text-sm text-gray-600 mb-4">Thống kê nhập hàng theo nhà cung cấp, tần suất và giá trị</p>
        <div class="flex items-center gap-2 text-navy-600 text-sm font-medium"><span>Xem báo cáo</span>
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
         </svg>
        </div>
       </div>
      </div>
     </div><!-- Report Details View (Hidden by default) -->
     <div id="reportView" style="display: none;"><!-- Will be populated by JavaScript -->
     </div>
    </div>
   </main>
  </div><!-- Toast Notification -->
  <div class="toast" id="toast">
   <svg class="w-5 h-5" id="toastIcon" fill="none" stroke="currentColor" viewbox="0 0 24 24"></svg><span id="toastMessage"></span>
  </div>
  <script>
    // ==================== CẤU HÌNH ====================
    const currentUser = {
        ma_nguoi_dung: <?php echo json_encode($ma_nguoi_dung ?? 0); ?>,
        ho_ten: <?php echo json_encode($ten ?? ''); ?>,
        vai_tro: <?php echo json_encode($role ?? ''); ?>
    };

    const defaultConfig = {
        page_title: 'BÁO CÁO & THỐNG KÊ KHO'
    };

    // ==================== BIẾN TOÀN CỤC ====================
    let currentReport = null;
    let reportCharts = {};
    let nhaCungCapList = [];
    let khoList = [];
    let danhMucList = [];
    
    // Phân trang
    let currentPage = 1;
    const itemsPerPage = 10;
    let reportData = [];

    // Dữ liệu thống kê tổng quan
    let thongKeTongQuan = {
        import: { tong: 0, tong_gia_tri: 0 },
        export: { tong: 0, tong_gia_tri: 0 },
        product: { tong: 0 },
        inventory: { tong_gia_tri: 0 }
    };

    // ==================== UTILITY FUNCTIONS ====================
    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
    }

    function formatNumber(value) {
        return new Intl.NumberFormat('vi-VN').format(value);
    }

    function formatDate(dateStr) {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        return date.toLocaleDateString('vi-VN');
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
    async function loadThongKeTongQuan() {
        try {
            const response = await fetch('../actions/BaoCaoThongKe/lay_thong_ke_tong_quan.php');
            const result = await response.json();

            if (result.success) {
                thongKeTongQuan = result.data;
                updateQuickStats();
            }
        } catch (error) {
            console.error('Error loading statistics:', error);
        }
    }

    async function loadNhaCungCapList() {
        try {
            const response = await fetch('../actions/BaoCaoThongKe/lay_danh_sach_nha_cung_cap.php');
            const result = await response.json();

            if (result.success) {
                nhaCungCapList = result.data;
            }
        } catch (error) {
            console.error('Error loading supplier list:', error);
        }
    }

    async function loadKhoList() {
        try {
            const response = await fetch('../actions/BaoCaoThongKe/lay_danh_sach_kho.php');
            const result = await response.json();

            if (result.success) {
                khoList = result.data;
            }
        } catch (error) {
            console.error('Error loading warehouse list:', error);
        }
    }

    async function loadDanhMucList() {
        try {
            const response = await fetch('../actions/BaoCaoThongKe/lay_danh_sach_danh_muc.php');
            const result = await response.json();

            if (result.success) {
                danhMucList = result.data;
            }
        } catch (error) {
            console.error('Error loading category list:', error);
        }
    }

    async function loadBaoCaoNhap(tuNgay, denNgay, maNCC, maKho) {
        try {
            let url = '../actions/BaoCaoThongKe/lay_bao_cao_phieu_nhap.php?';
            const params = new URLSearchParams();
            if (tuNgay) params.append('tu_ngay', tuNgay);
            if (denNgay) params.append('den_ngay', denNgay);
            if (maNCC) params.append('ma_nha_cung_cap', maNCC);
            if (maKho) params.append('ma_kho', maKho);

            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                return result;
            } else {
                showToast(result.message, 'error');
                return null;
            }
        } catch (error) {
            console.error('Error loading import report:', error);
            showToast('Lỗi tải báo cáo nhập', 'error');
            return null;
        }
    }

    async function loadBaoCaoXuat(tuNgay, denNgay, maKho, boPhan) {
        try {
            let url = '../actions/BaoCaoThongKe/lay_bao_cao_phieu_xuat.php?';
            const params = new URLSearchParams();
            if (tuNgay) params.append('tu_ngay', tuNgay);
            if (denNgay) params.append('den_ngay', denNgay);
            if (maKho) params.append('ma_kho', maKho);
            if (boPhan) params.append('bo_phan', boPhan);

            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                return result;
            } else {
                showToast(result.message, 'error');
                return null;
            }
        } catch (error) {
            console.error('Error loading export report:', error);
            showToast('Lỗi tải báo cáo xuất', 'error');
            return null;
        }
    }

    async function loadBaoCaoTonKho(maKho, maDanhMuc, trangThai) {
        try {
            let url = '../actions/BaoCaoThongKe/lay_bao_cao_ton_kho.php?';
            const params = new URLSearchParams();
            if (maKho) params.append('ma_kho', maKho);
            if (maDanhMuc) params.append('ma_danh_muc', maDanhMuc);
            if (trangThai) params.append('trang_thai', trangThai);

            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                return result;
            } else {
                showToast(result.message, 'error');
                return null;
            }
        } catch (error) {
            console.error('Error loading inventory report:', error);
            showToast('Lỗi tải báo cáo tồn kho', 'error');
            return null;
        }
    }

    async function loadBaoCaoNhapXuatTon(thang, nam, maKho) {
        try {
            let url = '../actions/BaoCaoThongKe/lay_bao_cao_nhap_xuat_ton.php?';
            const params = new URLSearchParams();
            if (thang) params.append('thang', thang);
            if (nam) params.append('nam', nam);
            if (maKho) params.append('ma_kho', maKho);

            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                return result;
            } else {
                showToast(result.message, 'error');
                return null;
            }
        } catch (error) {
            console.error('Error loading movement report:', error);
            showToast('Lỗi tải báo cáo nhập xuất tồn', 'error');
            return null;
        }
    }

    async function loadBaoCaoSanPham(maDanhMuc, maKho, trangThai) {
        try {
            let url = '../actions/BaoCaoThongKe/lay_bao_cao_san_pham.php?';
            const params = new URLSearchParams();
            if (maDanhMuc) params.append('ma_danh_muc', maDanhMuc);
            if (maKho) params.append('ma_kho', maKho);
            if (trangThai) params.append('trang_thai', trangThai);

            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                return result;
            } else {
                showToast(result.message, 'error');
                return null;
            }
        } catch (error) {
            console.error('Error loading product report:', error);
            showToast('Lỗi tải báo cáo sản phẩm', 'error');
            return null;
        }
    }

    async function loadBaoCaoNhaCungCap(tuNgay, denNgay) {
        try {
            let url = '../actions/BaoCaoThongKe/lay_bao_cao_nha_cung_cap.php?';
            const params = new URLSearchParams();
            if (tuNgay) params.append('tu_ngay', tuNgay);
            if (denNgay) params.append('den_ngay', denNgay);

            const response = await fetch(url + params.toString());
            const result = await response.json();

            if (result.success) {
                return result;
            } else {
                showToast(result.message, 'error');
                return null;
            }
        } catch (error) {
            console.error('Error loading supplier report:', error);
            showToast('Lỗi tải báo cáo nhà cung cấp', 'error');
            return null;
        }
    }

    // ==================== UPDATE UI ====================
    function updateQuickStats() {
        const stats = document.querySelectorAll('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4 .card .text-2xl');
        if (stats.length >= 4) {
            stats[0].textContent = formatNumber(thongKeTongQuan.import.tong);
            stats[1].textContent = formatNumber(thongKeTongQuan.export.tong);
            stats[2].textContent = formatNumber(thongKeTongQuan.product.tong);
            stats[3].textContent = formatCurrency(thongKeTongQuan.inventory.tong_gia_tri);
        }
    }

    // ==================== REPORT NAVIGATION ====================
    function navigateToReport(reportType) {
        currentReport = reportType;
        currentPage = 1;
        renderReport(reportType);
        document.getElementById('dashboardView').style.display = 'none';
        document.getElementById('reportView').style.display = 'block';
    }

    function backToDashboard() {
        currentReport = null;
        Object.keys(reportCharts).forEach(key => {
            if (reportCharts[key]) {
                reportCharts[key].destroy();
            }
        });
        reportCharts = {};
        document.getElementById('dashboardView').style.display = 'block';
        document.getElementById('reportView').style.display = 'none';
    }

    // ==================== RENDER REPORT ====================
    async function renderReport(reportType) {
        let result = null;

        // Load dữ liệu theo loại báo cáo
        switch(reportType) {
            case 'import':
                result = await loadBaoCaoNhap(
                    document.getElementById('filterFromDate')?.value,
                    document.getElementById('filterToDate')?.value,
                    document.getElementById('filterSupplier')?.value,
                    document.getElementById('filterWarehouse')?.value
                );
                break;
            case 'export':
                result = await loadBaoCaoXuat(
                    document.getElementById('filterFromDate')?.value,
                    document.getElementById('filterToDate')?.value,
                    document.getElementById('filterWarehouse')?.value,
                    document.getElementById('filterDepartment')?.value
                );
                break;
            case 'inventory':
                result = await loadBaoCaoTonKho(
                    document.getElementById('filterWarehouse')?.value,
                    document.getElementById('filterCategory')?.value,
                    document.getElementById('filterStatus')?.value
                );
                break;
            case 'movement':
                const today = new Date();
                result = await loadBaoCaoNhapXuatTon(
                    document.getElementById('filterMonth')?.value || today.getMonth() + 1,
                    document.getElementById('filterYear')?.value || today.getFullYear(),
                    document.getElementById('filterWarehouse')?.value
                );
                break;
            case 'product':
                result = await loadBaoCaoSanPham(
                    document.getElementById('filterCategory')?.value,
                    document.getElementById('filterWarehouse')?.value,
                    document.getElementById('filterStatus')?.value
                );
                break;
            case 'supplier':
                result = await loadBaoCaoNhaCungCap(
                    document.getElementById('filterFromDate')?.value,
                    document.getElementById('filterToDate')?.value
                );
                break;
        }

        if (!result || !result.success) {
            showToast('Không có dữ liệu', 'warning');
            return;
        }

        reportData = result.data;
        const thongKe = result.thong_ke;
        const title = getReportTitle(reportType);

        let html = `
            <div class="animate-fade-in">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                            <a href="#" class="hover:text-navy-600" onclick="backToDashboard()">Báo cáo</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="text-gray-900">${title}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-navy-900">${title}</h1>
                    </div>
                    <button class="btn btn-outline" onclick="backToDashboard()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Quay lại
                    </button>
                </div>

                <!-- Filter Section -->
                <div class="card p-5 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        ${renderFilterInputs(reportType)}
                        <div class="flex items-end gap-2 lg:col-span-1">
                            <button class="btn btn-primary w-full" onclick="applyReportFilter('${reportType}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Lọc
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    ${renderSummaryCards(reportType, thongKe)}
                </div>

                <!-- Chart Section -->
                <div class="card p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Biểu đồ thống kê</h3>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="reportChart"></canvas>
                    </div>
                </div>

                <!-- Export Buttons -->
                <div class="flex gap-3 mb-6">
                    <button class="btn btn-outline" onclick="exportReport('${reportType}', 'excel')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Xuất Excel
                    </button>
                    <button class="btn btn-outline" onclick="exportReport('${reportType}', 'csv')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Xuất CSV
                    </button>
                    <button class="btn btn-outline" onclick="printReport()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm-6-4h.01M9 16h.01"/>
                        </svg>
                        In báo cáo
                    </button>
                </div>

                <!-- Data Table với phân trang -->
                <div class="card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    ${getTableHeaders(reportType).map(header => `<th>${header}</th>`).join('')}
                                </tr>
                            </thead>
                            <tbody id="report-table-body">
                                ${renderTableRows(reportType, 1)}
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Hiển thị <span id="pagination-start">1</span>-<span id="pagination-end">${Math.min(itemsPerPage, reportData.length)}</span> 
                                trong <span id="pagination-total">${reportData.length}</span> dòng
                            </div>
                            <div class="flex items-center gap-2" id="pagination-controls">
                                ${renderPagination(reportData.length)}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('reportView').innerHTML = html;
        renderReportChart(reportType, thongKe);
    }

    function renderTableRows(reportType, page) {
        const start = (page - 1) * itemsPerPage;
        const end = Math.min(start + itemsPerPage, reportData.length);
        const pageData = reportData.slice(start, end);

        return pageData.map(row => `<tr>${getTableCells(reportType, row)}</tr>`).join('');
    }

    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (totalPages <= 1) return '';

        let html = '';
        
        // Nút Previous
        html += `<button onclick="changePage(${currentPage - 1})" 
            class="px-3 py-1 border rounded ${currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'}" 
            ${currentPage <= 1 ? 'disabled' : ''}>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>`;

        // Các nút số trang
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                html += `<button onclick="changePage(${i})" 
                    class="px-3 py-1 border rounded ${i === currentPage ? 'bg-navy-700 text-white' : 'hover:bg-gray-100'}">
                    ${i}
                </button>`;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                html += `<span class="px-2">...</span>`;
            }
        }

        // Nút Next
        html += `<button onclick="changePage(${currentPage + 1})" 
            class="px-3 py-1 border rounded ${currentPage >= totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'}" 
            ${currentPage >= totalPages ? 'disabled' : ''}>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>`;

        return html;
    }

    function changePage(page) {
        const totalPages = Math.ceil(reportData.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        
        currentPage = page;
        
        // Cập nhật bảng
        const tbody = document.getElementById('report-table-body');
        if (tbody) {
            tbody.innerHTML = renderTableRows(currentReport, currentPage);
        }

        // Cập nhật thông tin phân trang
        const start = (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, reportData.length);
        
        const startEl = document.getElementById('pagination-start');
        const endEl = document.getElementById('pagination-end');
        const controlsEl = document.getElementById('pagination-controls');
        
        if (startEl) startEl.textContent = start;
        if (endEl) endEl.textContent = end;
        if (controlsEl) controlsEl.innerHTML = renderPagination(reportData.length);
    }

    function getReportTitle(reportType) {
        const titles = {
            import: 'BÁO CÁO PHIẾU NHẬP KHO',
            export: 'BÁO CÁO PHIẾU XUẤT KHO',
            inventory: 'BÁO CÁO TỒN KHO',
            movement: 'BÁO CÁO NHẬP - XUẤT - TỒN',
            product: 'BÁO CÁO SẢN PHẨM',
            supplier: 'BÁO CÁO NHÀ CUNG CẤP'
        };
        return titles[reportType] || 'BÁO CÁO';
    }

    function renderFilterInputs(reportType) {
        const filterConfigs = {
            import: ['fromDate', 'toDate', 'supplier', 'warehouse'],
            export: ['fromDate', 'toDate', 'warehouse', 'department'],
            inventory: ['warehouse', 'category', 'status'],
            movement: ['warehouse', 'month', 'year'],
            product: ['category', 'warehouse', 'status'],
            supplier: ['fromDate', 'toDate']
        };

        const filterHTML = {
            fromDate: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input type="date" class="form-input" id="filterFromDate" value="${new Date().toISOString().split('T')[0]}">
                </div>`,
            toDate: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input type="date" class="form-input" id="filterToDate" value="${new Date().toISOString().split('T')[0]}">
                </div>`,
            supplier: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhà cung cấp</label>
                    <select class="form-select" id="filterSupplier">
                        <option value="">Tất cả</option>
                        ${nhaCungCapList.map(ncc => `<option value="${ncc.ma_nha_cung_cap}">${ncc.ten_nha_cung_cap}</option>`).join('')}
                    </select>
                </div>`,
            warehouse: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kho</label>
                    <select class="form-select" id="filterWarehouse">
                        <option value="">Tất cả kho</option>
                        ${khoList.map(k => `<option value="${k.ma_kho}">${k.ten_kho}</option>`).join('')}
                    </select>
                </div>`,
            department: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bộ phận</label>
                    <select class="form-select" id="filterDepartment">
                        <option value="">Tất cả</option>
                        <option value="Kinh doanh">Kinh doanh</option>
                        <option value="Sản xuất">Sản xuất</option>
                        <option value="Kỹ thuật">Kỹ thuật</option>
                        <option value="Hành chính">Hành chính</option>
                    </select>
                </div>`,
            category: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select class="form-select" id="filterCategory">
                        <option value="">Tất cả</option>
                        ${danhMucList.map(d => `<option value="${d.ma_danh_muc}">${d.ten_danh_muc}</option>`).join('')}
                    </select>
                </div>`,
            status: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Tất cả</option>
                        <option value="normal">Bình thường</option>
                        <option value="low-stock">Sắp hết</option>
                        <option value="out-of-stock">Hết hàng</option>
                    </select>
                </div>`,
            month: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tháng</label>
                    <select class="form-select" id="filterMonth">
                        ${Array.from({length: 12}, (_, i) => `<option value="${i+1}" ${i+1 === new Date().getMonth()+1 ? 'selected' : ''}>Tháng ${i+1}</option>`).join('')}
                    </select>
                </div>`,
            year: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Năm</label>
                    <select class="form-select" id="filterYear">
                        ${Array.from({length: 5}, (_, i) => `<option value="${new Date().getFullYear() - i}" ${i === 0 ? 'selected' : ''}>${new Date().getFullYear() - i}</option>`).join('')}
                    </select>
                </div>`
        };

        return (filterConfigs[reportType] || []).map(filter => filterHTML[filter] || '').join('');
    }

    function renderSummaryCards(reportType, thongKe) {
        switch(reportType) {
            case 'import':
                return `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Tổng phiếu</p>
                        <p class="text-2xl font-bold text-blue-800">${formatNumber(thongKe?.tong_phieu || 0)}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Tổng số lượng</p>
                        <p class="text-2xl font-bold text-green-800">${formatNumber(thongKe?.tong_so_luong || 0)}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">Tổng giá trị</p>
                        <p class="text-2xl font-bold text-purple-800">${formatCurrency(thongKe?.tong_gia_tri || 0)}</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="text-sm text-orange-600 mb-1">Nhà cung cấp</p>
                        <p class="text-2xl font-bold text-orange-800">${Object.keys(thongKe?.theo_ncc || {}).length}</p>
                    </div>
                `;
            case 'export':
                return `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Tổng phiếu</p>
                        <p class="text-2xl font-bold text-blue-800">${formatNumber(thongKe?.tong_phieu || 0)}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Tổng số lượng</p>
                        <p class="text-2xl font-bold text-green-800">${formatNumber(thongKe?.tong_so_luong || 0)}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">Tổng giá trị</p>
                        <p class="text-2xl font-bold text-purple-800">${formatCurrency(thongKe?.tong_gia_tri || 0)}</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="text-sm text-orange-600 mb-1">Bộ phận</p>
                        <p class="text-2xl font-bold text-orange-800">${Object.keys(thongKe?.theo_bo_phan || {}).length}</p>
                    </div>
                `;
            case 'inventory':
                return `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Tổng sản phẩm</p>
                        <p class="text-2xl font-bold text-blue-800">${formatNumber(thongKe?.tong_san_pham || 0)}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Tổng số lượng</p>
                        <p class="text-2xl font-bold text-green-800">${formatNumber(thongKe?.tong_so_luong || 0)}</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-red-600 mb-1">Sắp hết hàng</p>
                        <p class="text-2xl font-bold text-red-800">${formatNumber(thongKe?.sap_het || 0)}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">Giá trị tồn</p>
                        <p class="text-2xl font-bold text-purple-800">${formatCurrency(thongKe?.tong_gia_tri || 0)}</p>
                    </div>
                `;
            case 'movement':
                return `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Tồn đầu</p>
                        <p class="text-2xl font-bold text-blue-800">${formatNumber(thongKe?.tong_ton_dau || 0)}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Tổng nhập</p>
                        <p class="text-2xl font-bold text-green-800">${formatNumber(thongKe?.tong_nhap || 0)}</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-red-600 mb-1">Tổng xuất</p>
                        <p class="text-2xl font-bold text-red-800">${formatNumber(thongKe?.tong_xuat || 0)}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">Tồn cuối</p>
                        <p class="text-2xl font-bold text-purple-800">${formatNumber(thongKe?.tong_ton_cuoi || 0)}</p>
                    </div>
                `;
            case 'product':
                return `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Tổng sản phẩm</p>
                        <p class="text-2xl font-bold text-blue-800">${formatNumber(thongKe?.tong_san_pham || 0)}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Tồn kho</p>
                        <p class="text-2xl font-bold text-green-800">${formatNumber(thongKe?.tong_ton_kho || 0)}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">Giá trị nhập</p>
                        <p class="text-2xl font-bold text-purple-800">${formatCurrency(thongKe?.tong_gia_tri_nhap || 0)}</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="text-sm text-orange-600 mb-1">Giá trị xuất</p>
                        <p class="text-2xl font-bold text-orange-800">${formatCurrency(thongKe?.tong_gia_tri_xuat || 0)}</p>
                    </div>
                `;
            case 'supplier':
                return `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Nhà cung cấp</p>
                        <p class="text-2xl font-bold text-blue-800">${formatNumber(thongKe?.tong_nha_cung_cap || 0)}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Phiếu nhập</p>
                        <p class="text-2xl font-bold text-green-800">${formatNumber(thongKe?.tong_phieu_nhap || 0)}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">Số lượng nhập</p>
                        <p class="text-2xl font-bold text-purple-800">${formatNumber(thongKe?.tong_so_luong || 0)}</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <p class="text-sm text-orange-600 mb-1">Giá trị nhập</p>
                        <p class="text-2xl font-bold text-orange-800">${formatCurrency(thongKe?.tong_gia_tri || 0)}</p>
                    </div>
                `;
            default:
                return '';
        }
    }

    function getTableHeaders(reportType) {
        const headers = {
            import: ['Mã phiếu', 'Ngày nhập', 'Nhà cung cấp', 'Kho', 'Số mặt hàng', 'Tổng SL', 'Giá trị', 'Người tạo'],
            export: ['Mã phiếu', 'Ngày xuất', 'Kho', 'Người nhận', 'Bộ phận', 'Số mặt hàng', 'Tổng SL', 'Giá trị', 'Người tạo'],
            inventory: ['Mã SP', 'Tên sản phẩm', 'Danh mục', 'Kho', 'Tồn kho', 'Tồn tối thiểu', 'Giá trị', 'Trạng thái'],
            movement: ['Mã SP', 'Tên sản phẩm', 'Tồn đầu', 'Nhập', 'Xuất', 'Tồn cuối'],
            product: ['Mã SP', 'Tên sản phẩm', 'Danh mục', 'Lần nhập', 'Lần xuất', 'Tồn kho', 'Giá trị nhập', 'Giá trị xuất'],
            supplier: ['Nhà cung cấp', 'Người liên hệ', 'SĐT', 'Số phiếu', 'Số SP', 'Tổng SL', 'Giá trị nhập']
        };
        return headers[reportType] || [];
    }

    function getTableCells(reportType, row) {
        const cells = [];
        
        switch(reportType) {
            case 'import':
                cells.push(`<td class="font-medium">${row.ma_phieu || ''}</td>`);
                cells.push(`<td>${row.ngay_tao || ''}</td>`);
                cells.push(`<td>${row.nha_cung_cap || ''}</td>`);
                cells.push(`<td>${row.kho || ''}</td>`);
                cells.push(`<td class="text-center">${row.so_mat_hang || 0}</td>`);
                cells.push(`<td class="text-right">${formatNumber(row.tong_so_luong || 0)}</td>`);
                cells.push(`<td class="text-right font-medium">${formatCurrency(row.tong_tien || 0)}</td>`);
                cells.push(`<td>${row.nguoi_tao || ''}</td>`);
                break;
            case 'export':
                cells.push(`<td class="font-medium">${row.ma_phieu || ''}</td>`);
                cells.push(`<td>${row.ngay_tao || ''}</td>`);
                cells.push(`<td>${row.kho || ''}</td>`);
                cells.push(`<td>${row.nguoi_nhan || ''}</td>`);
                cells.push(`<td>${row.bo_phan || ''}</td>`);
                cells.push(`<td class="text-center">${row.so_mat_hang || 0}</td>`);
                cells.push(`<td class="text-right">${formatNumber(row.tong_so_luong || 0)}</td>`);
                cells.push(`<td class="text-right font-medium">${formatCurrency(row.tong_gia_tri || 0)}</td>`);
                cells.push(`<td>${row.nguoi_tao || ''}</td>`);
                break;
            case 'inventory':
                cells.push(`<td class="font-medium">${row.ma_san_pham || ''}</td>`);
                cells.push(`<td>${row.ten_san_pham || ''}</td>`);
                cells.push(`<td>${row.danh_muc || ''}</td>`);
                cells.push(`<td>${row.kho || ''}</td>`);
                cells.push(`<td class="text-right font-medium">${formatNumber(row.so_luong || 0)}</td>`);
                cells.push(`<td class="text-center">${row.ton_toi_thieu || 0}</td>`);
                cells.push(`<td class="text-right">${formatCurrency(row.gia_tri || 0)}</td>`);
                cells.push(`<td class="text-center">${getStatusBadge(row.trang_thai || 'normal')}</td>`);
                break;
            case 'movement':
                cells.push(`<td class="font-medium">${row.ma_san_pham || ''}</td>`);
                cells.push(`<td>${row.ten_san_pham || ''}</td>`);
                cells.push(`<td class="text-right">${formatNumber(row.ton_dau || 0)}</td>`);
                cells.push(`<td class="text-right">${formatNumber(row.tong_nhap || 0)}</td>`);
                cells.push(`<td class="text-right">${formatNumber(row.tong_xuat || 0)}</td>`);
                cells.push(`<td class="text-right font-medium">${formatNumber(row.ton_cuoi || 0)}</td>`);
                break;
            case 'product':
                cells.push(`<td class="font-medium">${row.ma_san_pham || ''}</td>`);
                cells.push(`<td>${row.ten_san_pham || ''}</td>`);
                cells.push(`<td>${row.danh_muc || ''}</td>`);
                cells.push(`<td class="text-center">${row.so_lan_nhap || 0}</td>`);
                cells.push(`<td class="text-center">${row.so_lan_xuat || 0}</td>`);
                cells.push(`<td class="text-right font-medium">${formatNumber(row.ton_kho || 0)}</td>`);
                cells.push(`<td class="text-right">${formatCurrency(row.gia_tri_nhap || 0)}</td>`);
                cells.push(`<td class="text-right">${formatCurrency(row.gia_tri_xuat || 0)}</td>`);
                break;
            case 'supplier':
                cells.push(`<td class="font-medium">${row.ten_nha_cung_cap || ''}</td>`);
                cells.push(`<td>${row.nguoi_lien_he || ''}</td>`);
                cells.push(`<td>${row.so_dien_thoai || ''}</td>`);
                cells.push(`<td class="text-center">${row.so_phieu_nhap || 0}</td>`);
                cells.push(`<td class="text-center">${row.so_san_pham || 0}</td>`);
                cells.push(`<td class="text-right">${formatNumber(row.tong_so_luong || 0)}</td>`);
                cells.push(`<td class="text-right font-medium">${formatCurrency(row.tong_gia_tri || 0)}</td>`);
                break;
        }

        return cells.map(cell => cell).join('');
    }

    function getStatusBadge(status) {
        if (status === 'out-of-stock' || status === 'Hết hàng') {
            return '<span class="badge badge-out">Hết hàng</span>';
        } else if (status === 'low-stock' || status === 'Sắp hết') {
            return '<span class="badge badge-low">Sắp hết</span>';
        } else if (status === 1 || status === 'normal') {
            return '<span class="badge badge-normal">Bình thường</span>';
        } else if (status === 0) {
            return '<span class="badge badge-out">Ngừng KD</span>';
        }
        return '<span class="badge badge-normal">Bình thường</span>';
    }

    function renderReportChart(reportType, thongKe) {
        setTimeout(() => {
            const ctx = document.getElementById('reportChart')?.getContext('2d');
            if (!ctx) return;

            let chartConfig = {};

            switch(reportType) {
                case 'import':
                case 'export':
                    chartConfig = {
                        type: reportType === 'import' ? 'bar' : 'line',
                        data: {
                            labels: Object.keys(thongKe?.theo_ngay || {}),
                            datasets: [{
                                label: 'Giá trị (VNĐ)',
                                data: Object.values(thongKe?.theo_ngay || {}),
                                backgroundColor: reportType === 'import' ? '#102a43' : '#dc2626',
                                borderColor: reportType === 'import' ? '#102a43' : '#dc2626',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: reportType === 'export'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) label += ': ';
                                            if (context.parsed.y !== null) {
                                                label += formatCurrency(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return formatCurrency(value);
                                        }
                                    }
                                }
                            }
                        }
                    };
                    break;
                case 'inventory':
                    const labels = Object.keys(thongKe?.theo_danh_muc || {});
                    const values = Object.values(thongKe?.theo_danh_muc || {}).map(item => item.gia_tri);
                    
                    chartConfig = {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: ['#102a43', '#0284c7', '#059669', '#d97706', '#7c3aed', '#db2777']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) label += ': ';
                                            if (context.parsed !== null) {
                                                label += formatCurrency(context.parsed);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    };
                    break;
                case 'movement':
                    const topProducts = reportData.slice(0, 10);
                    chartConfig = {
                        type: 'bar',
                        data: {
                            labels: topProducts.map(item => item.ma_san_pham),
                            datasets: [
                                {
                                    label: 'Nhập',
                                    data: topProducts.map(item => item.tong_nhap),
                                    backgroundColor: '#059669'
                                },
                                {
                                    label: 'Xuất',
                                    data: topProducts.map(item => item.tong_xuat),
                                    backgroundColor: '#dc2626'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' }
                            },
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    };
                    break;
                case 'product':
                    const topProducts2 = reportData.slice(0, 10);
                    chartConfig = {
                        type: 'bar',
                        data: {
                            labels: topProducts2.map(item => item.ma_san_pham),
                            datasets: [
                                {
                                    label: 'Giá trị nhập',
                                    data: topProducts2.map(item => item.gia_tri_nhap / 1000000), // Chia cho triệu để dễ nhìn
                                    backgroundColor: '#102a43'
                                },
                                {
                                    label: 'Giá trị xuất',
                                    data: topProducts2.map(item => item.gia_tri_xuat / 1000000),
                                    backgroundColor: '#d97706'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) label += ': ';
                                            if (context.parsed.y !== null) {
                                                label += formatCurrency(context.parsed.y * 1000000);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return value + 'M';
                                        }
                                    }
                                }
                            }
                        }
                    };
                    break;
                case 'supplier':
                    chartConfig = {
                        type: 'bar',
                        data: {
                            labels: reportData.slice(0, 10).map(item => item.ten_nha_cung_cap),
                            datasets: [{
                                label: 'Giá trị nhập',
                                data: reportData.slice(0, 10).map(item => item.tong_gia_tri),
                                backgroundColor: '#102a43'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) label += ': ';
                                            if (context.parsed.y !== null) {
                                                label += formatCurrency(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return formatCurrency(value);
                                        }
                                    }
                                }
                            }
                        }
                    };
                    break;
            }

            if (reportCharts[reportType]) {
                reportCharts[reportType].destroy();
            }
            reportCharts[reportType] = new Chart(ctx, chartConfig);
        }, 100);
    }

    async function applyReportFilter(reportType) {
        currentPage = 1;
        await renderReport(reportType);
        showToast('Đã áp dụng bộ lọc thành công!', 'success');
    }

    function exportReport(reportType, format) {
        const url = `../actions/BaoCaoThongKe/xuat_bao_cao_excel.php?loai=${reportType}&dinh_dang=${format}`;
        window.location.href = url;
        showToast(`Đang xuất file ${format.toUpperCase()}...`, 'info');
    }

    function printReport() {
        window.print();
        showToast('Đã gửi lệnh in', 'success');
    }

    // ==================== SIDEBAR & MOBILE TOGGLE ====================
document.addEventListener('DOMContentLoaded', function () {
    // Load dữ liệu
    loadThongKeTongQuan();
    loadNhaCungCapList();
    loadKhoList();
    loadDanhMucList();

    // Sidebar elements
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileOverlay = document.getElementById('mobileOverlay');

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

        // Gắn sự kiện
        sidebarToggle.addEventListener('click', toggleSidebar);

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', closeMobileSidebar);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isMobile) {
                closeMobileSidebar();
            }
        });

        window.addEventListener('resize', handleResize);
        handleResize();
    }

    // Gọi hàm khởi tạo dropdown (nếu tách riêng file thì import hoặc để script load sau)
    initUserDropdown();
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
  </html>
  <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>

<script>

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