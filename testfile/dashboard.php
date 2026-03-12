
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
<html lang="en" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WMS - Warehouse Management System</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <link rel= "stylesheet" href="../public/CSS/dashboard.css">

  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
<!-- Trong phần head -->
<link rel="stylesheet" href="../public/CSS/stars.css">

<!-- Trước thẻ đóng body -->
<script src="../public/CSS/stars.js"></script>
 </head>
 <body class="h-full">
  <div class="wms-app"><!-- Mobile Overlay -->
   <div class="mobile-overlay" id="mobileOverlay"></div><!-- ========================================
         SIDEBAR.PHP
         ======================================== -->
   
   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>
         <!-- ========================================
         MAIN CONTENT WRAPPER
         ======================================== -->
   <div class="wms-main"><!-- ========================================
           HEADER.PHP (TOPBAR)
           ======================================== -->
    <?php include __DIR__ . "/../views/Layout/header.php"; ?>
    
           <!-- ========================================
           MAIN CONTENT AREA
           ======================================== -->
    <main class="wms-content">
     <div class="content-header">
      <h1 class="page-title">Dashboard</h1>
      <p class="page-subtitle">Welcome back! Here's what's happening with your warehouse today.</p>
     </div><!-- Stats Cards -->
     <div class="stats-grid">
      <div class="stat-card">
       <div class="stat-card-header">
        <div class="stat-card-icon blue">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
         </svg>
        </div><span class="stat-card-change up">+12.5%</span>
       </div>
       <div class="stat-card-value">
        2,847
       </div>
       <div class="stat-card-label">
        Total Products
       </div>
      </div>
      <div class="stat-card">
       <div class="stat-card-header">
        <div class="stat-card-icon green">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path> <polyline points="7 10 12 15 17 10"></polyline> <line x1="12" y1="15" x2="12" y2="3"></line>
         </svg>
        </div><span class="stat-card-change up">+8.2%</span>
       </div>
       <div class="stat-card-value">
        156
       </div>
       <div class="stat-card-label">
        Import Orders
       </div>
      </div>
      <div class="stat-card">
       <div class="stat-card-header">
        <div class="stat-card-icon purple">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path> <polyline points="17 8 12 3 7 8"></polyline> <line x1="12" y1="3" x2="12" y2="15"></line>
         </svg>
        </div><span class="stat-card-change down">-3.1%</span>
       </div>
       <div class="stat-card-value">
        89
       </div>
       <div class="stat-card-label">
        Export Orders
       </div>
      </div>
      <div class="stat-card">
       <div class="stat-card-header">
        <div class="stat-card-icon orange">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path> <polyline points="9 22 9 12 15 12 15 22"></polyline>
         </svg>
        </div><span class="stat-card-change up">+2</span>
       </div>
       <div class="stat-card-value">
        8
       </div>
       <div class="stat-card-label">
        Active Warehouses
       </div>
      </div>
     </div><!-- Content Grid -->
     <div class="content-grid"><!-- Recent Orders -->
      <div class="content-card">
       <div class="content-card-header">
        <h2 class="content-card-title">Recent Orders</h2><a href="#" class="content-card-action">View All</a>
       </div>
       <div class="content-card-body" style="padding: 0;">
        <table class="orders-table">
         <thead>
          <tr>
           <th>Order ID</th>
           <th>Type</th>
           <th>Warehouse</th>
           <th>Status</th>
           <th>Date</th>
          </tr>
         </thead>
         <tbody>
          <tr>
           <td><span class="order-id">#ORD-2024-001</span></td>
           <td>Import</td>
           <td>Warehouse A</td>
           <td><span class="status-badge completed">Completed</span></td>
           <td>Jan 15, 2026</td>
          </tr>
          <tr>
           <td><span class="order-id">#ORD-2024-002</span></td>
           <td>Export</td>
           <td>Warehouse B</td>
           <td><span class="status-badge processing">Processing</span></td>
           <td>Jan 15, 2026</td>
          </tr>
          <tr>
           <td><span class="order-id">#ORD-2024-003</span></td>
           <td>Import</td>
           <td>Warehouse A</td>
           <td><span class="status-badge pending">Pending</span></td>
           <td>Jan 14, 2026</td>
          </tr>
          <tr>
           <td><span class="order-id">#ORD-2024-004</span></td>
           <td>Export</td>
           <td>Warehouse C</td>
           <td><span class="status-badge completed">Completed</span></td>
           <td>Jan 14, 2026</td>
          </tr>
          <tr>
           <td><span class="order-id">#ORD-2024-005</span></td>
           <td>Import</td>
           <td>Warehouse B</td>
           <td><span class="status-badge processing">Processing</span></td>
           <td>Jan 13, 2026</td>
          </tr>
         </tbody>
        </table>
       </div>
      </div><!-- Recent Activity -->
      <div class="content-card">
       <div class="content-card-header">
        <h2 class="content-card-title">Recent Activity</h2><a href="#" class="content-card-action">View All</a>
       </div>
       <div class="content-card-body">
        <div class="activity-list">
         <div class="activity-item">
          <div class="activity-icon import">
           <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path> <polyline points="7 10 12 15 17 10"></polyline> <line x1="12" y1="15" x2="12" y2="3"></line>
           </svg>
          </div>
          <div class="activity-content">
           <p class="activity-text"><strong>New import</strong> received at Warehouse A</p>
           <p class="activity-time">2 minutes ago</p>
          </div>
         </div>
         <div class="activity-item">
          <div class="activity-icon export">
           <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"></path> <polyline points="17 8 12 3 7 8"></polyline> <line x1="12" y1="3" x2="12" y2="15"></line>
           </svg>
          </div>
          <div class="activity-content">
           <p class="activity-text"><strong>Order #2024-002</strong> shipped successfully</p>
           <p class="activity-time">15 minutes ago</p>
          </div>
         </div>
         <div class="activity-item">
          <div class="activity-icon alert">
           <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path> <line x1="12" y1="9" x2="12" y2="13"></line> <line x1="12" y1="17" x2="12.01" y2="17"></line>
           </svg>
          </div>
          <div class="activity-content">
           <p class="activity-text"><strong>Low stock alert</strong> for SKU-1234</p>
           <p class="activity-time">1 hour ago</p>
          </div>
         </div>
         <div class="activity-item">
          <div class="activity-icon user">
           <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path> <circle cx="12" cy="7" r="4"></circle>
           </svg>
          </div>
          <div class="activity-content">
           <p class="activity-text"><strong>New user</strong> added to the system</p>
           <p class="activity-time">3 hours ago</p>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </main><!-- ========================================
           FOOTER.PHP
           ======================================== -->
    <footer class="wms-footer">
     <p class="footer-text" id="footerText">© 2026 Warehouse Management System — Developed for Academic Project</p>
    </footer>
   </div>
  </div><!-- ========================================
       LAYOUT.JS - JavaScript for Layout Interactions
       ======================================== -->
  <script>
    // ========================================
    // LAYOUT.JS - WMS Admin Layout JavaScript
    // ========================================
    
    // Default configuration
    const defaultConfig = {
      system_name: 'WMS',
      footer_text: '© 2026 Warehouse Management System — Developed for Academic Project',
      primary_color: '#1e3a5f',
      secondary_color: '#f8fafc',
      text_color: '#1e293b',
      accent_color: '#3b82f6',
      font_family: 'Inter'
    };
    
    // Initialize Element SDK
    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange: async (config) => {
          // Update system name
          const systemNameEl = document.getElementById('systemName');
          if (systemNameEl) {
            systemNameEl.textContent = config.system_name || defaultConfig.system_name;
          }
          
          // Update footer text
          const footerTextEl = document.getElementById('footerText');
          if (footerTextEl) {
            footerTextEl.textContent = config.footer_text || defaultConfig.footer_text;
          }
          
          // Update colors
          const root = document.documentElement;
          root.style.setProperty('--primary-navy', config.primary_color || defaultConfig.primary_color);
          root.style.setProperty('--bg-light', config.secondary_color || defaultConfig.secondary_color);
          root.style.setProperty('--text-primary', config.text_color || defaultConfig.text_color);
          root.style.setProperty('--accent-blue', config.accent_color || defaultConfig.accent_color);
          
          // Update font
          const fontFamily = config.font_family || defaultConfig.font_family;
          document.body.style.fontFamily = `${fontFamily}, -apple-system, BlinkMacSystemFont, sans-serif`;
        },
        mapToCapabilities: (config) => ({
          recolorables: [
            {
              get: () => config.primary_color || defaultConfig.primary_color,
              set: (value) => {
                config.primary_color = value;
                window.elementSdk.setConfig({ primary_color: value });
              }
            },
            {
              get: () => config.secondary_color || defaultConfig.secondary_color,
              set: (value) => {
                config.secondary_color = value;
                window.elementSdk.setConfig({ secondary_color: value });
              }
            },
            {
              get: () => config.text_color || defaultConfig.text_color,
              set: (value) => {
                config.text_color = value;
                window.elementSdk.setConfig({ text_color: value });
              }
            },
            {
              get: () => config.accent_color || defaultConfig.accent_color,
              set: (value) => {
                config.accent_color = value;
                window.elementSdk.setConfig({ accent_color: value });
              }
            }
          ],
          borderables: [],
          fontEditable: {
            get: () => config.font_family || defaultConfig.font_family,
            set: (value) => {
              config.font_family = value;
              window.elementSdk.setConfig({ font_family: value });
            }
          },
          fontSizeable: undefined
        }),
        mapToEditPanelValues: (config) => new Map([
          ['system_name', config.system_name || defaultConfig.system_name],
          ['footer_text', config.footer_text || defaultConfig.footer_text]
        ])
      });
    }
    
    // DOM Elements
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
    
    // Sidebar Toggle Function
    function toggleSidebar() {
      if (isMobile) {
        sidebar.classList.toggle('mobile-open');
        mobileOverlay.classList.toggle('active');
      } else {
        isSidebarCollapsed = !isSidebarCollapsed;
        sidebar.classList.toggle('collapsed', isSidebarCollapsed);
      }
    }
    
    // Close Mobile Sidebar
    function closeMobileSidebar() {
      sidebar.classList.remove('mobile-open');
      mobileOverlay.classList.remove('active');
    }
    
    // Toggle User Dropdown
    function toggleUserDropdown(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('open');
    }
    
    // Close User Dropdown
    function closeUserDropdown() {
      userDropdown.classList.remove('open');
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
    
    // Handle Window Resize
    function handleResize() {
      const wasMobile = isMobile;
      isMobile = window.innerWidth <= 768;
      
      if (wasMobile !== isMobile) {
        // Reset sidebar state on viewport change
        sidebar.classList.remove('collapsed', 'mobile-open');
        mobileOverlay.classList.remove('active');
        isSidebarCollapsed = false;
      }
    }
    
    // Event Listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    mobileOverlay.addEventListener('click', closeMobileSidebar);
    userTrigger.addEventListener('click', toggleUserDropdown);
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target)) {
        closeUserDropdown();
      }
    });
    
    // Navigation clicks
    navItems.forEach(item => {
      item.addEventListener('click', handleNavClick);
    });
    
    // Window resize
    window.addEventListener('resize', handleResize);
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeUserDropdown();
        if (isMobile) {
          closeMobileSidebar();
        }
      }
    });
    
    // Initialize
    handleResize();
  </script>

 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d673e9b70285168',t:'MTc3MjUyNjI2My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
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