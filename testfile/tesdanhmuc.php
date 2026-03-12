

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
  <link rel="stylesheet" href="../public/css/quanlydanhmucsanpham.css">
  <style>
   
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full">
  <div class="wms-app">
   <!-- Mobile Overlay -->
   <div class="mobile-overlay" id="mobileOverlay"></div><!-- ========================================
         SIDEBAR.PHP
         ======================================== -->
   
         <!-- ========================================
         MAIN CONTENT WRAPPER
         ======================================== -->
   <div class="wms-main">
    <!-- ========================================
           HEADER.PHP (TOPBAR)
           ======================================== -->
    <header class="wms-topbar">
     <div class="topbar-left">
      <!-- Sidebar Toggle --> <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
       <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"></line> <line x1="3" y1="6" x2="21" y2="6"></line> <line x1="3" y1="18" x2="21" y2="18"></line>
       </svg></button> <!-- Breadcrumb -->
      <nav class="breadcrumb" aria-label="Breadcrumb">
       <a href="#" class="breadcrumb-item">
        <svg width="16" height="16" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
         <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
        </svg></a> <span class="breadcrumb-separator">/</span> <span class="breadcrumb-item active" id="breadcrumbCurrent">Dashboard</span>
      </nav>
     </div>
     <div class="topbar-right">
      <!-- Search -->
      <div class="topbar-search">
       <svg class="topbar-search-icon" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"></circle> <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
       </svg><input type="text" placeholder="Search..." aria-label="Search">
      </div><!-- Notifications --> <button class="topbar-notification" aria-label="Notifications">
       <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"></path> <path d="M13.73 21a2 2 0 01-3.46 0"></path>
       </svg><span class="notification-badge">3</span> </button> <!-- User Dropdown -->
      <div class="topbar-user" id="userDropdown">
       <div class="topbar-user-trigger" id="userTrigger">
        <div class="topbar-user-avatar">
         AD
        </div><span class="topbar-user-name">Admin</span>
        <svg class="topbar-user-arrow" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
         <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
       </div><!-- Dropdown Menu -->
       <div class="user-dropdown">
        <div class="user-dropdown-header">
         <div class="user-dropdown-name">
          Admin User
         </div>
         <div class="user-dropdown-email">
          admin@wms.com
         </div>
        </div>
        <div class="user-dropdown-menu">
         <a href="#" class="user-dropdown-item">
          <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
           <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path> <circle cx="12" cy="7" r="4"></circle>
          </svg><span>Profile</span> </a> <a href="#" class="user-dropdown-item">
          <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
           <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect> <path d="M7 11V7a5 5 0 0110 0v4"></path>
          </svg><span>Change Password</span> </a>
         <div class="user-dropdown-divider"></div><a href="#" class="user-dropdown-item danger">
          <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
           <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path> <polyline points="16 17 21 12 16 7"></polyline> <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg><span>Logout</span> </a>
        </div>
       </div>
      </div>
     </div>
    </header><!-- ========================================
           MAIN CONTENT AREA
           ======================================== -->
    <main class="wms-content"><!-- Page Header --> <!-- Page Header with Add Button -->
     <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
      <div class="content-header">
       <h1 class="page-title" id="pageTitle">QUẢN LÝ DANH MỤC</h1>
      </div><button id="addCategoryBtn" class="btn-primary" style="margin-bottom: 0;">
       <svg style="width: 18px; height: 18px; margin-right: 6px;" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"></line> <line x1="5" y1="12" x2="19" y2="12"></line>
       </svg><span id="addButtonText">Thêm danh mục</span> </button>
     </div><!-- Toolbar - Search & Filters -->
     <div class="content-card" style="margin-bottom: 24px;">
      <div class="content-card-body" style="padding: 16px;">
       <div class="toolbar">
        <!-- Search -->
        <div class="toolbar-group">
         <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên danh mục..." class="toolbar-search">
        </div><!-- Status Filter -->
        <div class="toolbar-group">
         <select id="statusFilter" class="toolbar-select"> <option value="">Tất cả trạng thái</option> <option value="active">Hoạt động</option> <option value="inactive">Ngừng hoạt động</option> </select>
        </div><!-- Refresh Button --> <button id="refreshBtn" class="btn-refresh">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="23 4 23 10 17 10"></polyline> <path d="M20.49 15a9 9 0 11-2-8.12"></path>
         </svg></button>
       </div>
      </div>
     </div><!-- Categories Table -->
     <div class="content-card">
      <div class="content-card-body" style="padding: 0;">
       <table class="categories-table">
        <thead>
         <tr>
          <th>Mã danh mục</th>
          <th>Tên danh mục</th>
          <th>Danh mục cha</th>
          <th>Số lượng sản phẩm</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th>Thao tác</th>
         </tr>
        </thead>
        <tbody id="categoriesTableBody">
         <tr>
          <td><span class="category-id">DM-001</span></td>
          <td><strong>Điện tử</strong></td>
          <td>—</td>
          <td><span class="product-count">145</span></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>12/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="category-id">DM-002</span></td>
          <td><strong>Quần áo</strong></td>
          <td>—</td>
          <td><span class="product-count">89</span></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>10/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="category-id">DM-003</span></td>
          <td><strong>Laptop</strong></td>
          <td>Điện tử</td>
          <td><span class="product-count">34</span></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>08/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="category-id">DM-004</span></td>
          <td><strong>Phụ kiện máy tính</strong></td>
          <td>Điện tử</td>
          <td><span class="product-count">67</span></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>05/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="category-id">DM-005</span></td>
          <td><strong>Nội thất</strong></td>
          <td>—</td>
          <td><span class="product-count">42</span></td>
          <td><span class="status-badge inactive">Ngừng hoạt động</span></td>
          <td>01/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="category-id">DM-006</span></td>
          <td><strong>Thực phẩm</strong></td>
          <td>—</td>
          <td><span class="product-count">23</span></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>28/12/2024</td>
          <td>
           <div class="action-buttons"><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div><!-- Pagination -->
     <div class="pagination">
      <button class="pagination-btn" id="prevBtn">← Trước</button>
      <div class="pagination-info">
       <span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">3</strong></span>
      </div><button class="pagination-btn" id="nextBtn">Tiếp theo →</button>
     </div>
    </main><!-- Add/Edit Category Modal -->
    <div class="modal" id="categoryModal">
     <div class="modal-overlay" id="modalOverlay"></div>
     <div class="modal-content">
      <div class="modal-header">
       <h2 class="modal-title" id="modalTitle">Thêm danh mục mới</h2><button class="modal-close" id="modalClose">×</button>
      </div>
      <div class="modal-body">
       <form id="categoryForm" class="category-form">
        <div class="form-row">
         <div class="form-group">
          <label for="categoryCode">Mã danh mục</label> <input type="text" id="categoryCode" placeholder="VD: DM-001" required>
         </div>
         <div class="form-group">
          <label for="categoryName">Tên danh mục</label> <input type="text" id="categoryName" placeholder="Nhập tên danh mục" required>
         </div>
        </div>
        <div class="form-row full">
         <div class="form-group">
          <label for="parentCategory">Danh mục cha</label> <select id="parentCategory"> <option value="">Không (danh mục gốc)</option> <option value="electronics">Điện tử</option> <option value="clothing">Quần áo</option> <option value="furniture">Nội thất</option> <option value="food">Thực phẩm</option> </select>
         </div>
        </div>
        <div class="form-row full">
         <div class="form-group">
          <label for="categoryDescription">Mô tả</label> <textarea id="categoryDescription" placeholder="Nhập mô tả danh mục..." rows="3"></textarea>
         </div>
        </div>
        <div class="form-row full">
         <div class="form-group"><label>Trạng thái</label>
          <div class="status-radio-group"><label class="radio-label"> <input type="radio" name="categoryStatus" value="active" checked> <span>Hoạt động</span> </label> <label class="radio-label"> <input type="radio" name="categoryStatus" value="inactive"> <span>Ngừng hoạt động</span> </label>
          </div>
         </div>
        </div>
       </form>
      </div>
      <div class="modal-footer">
       <button class="btn-secondary" id="modalCancel">Hủy</button> <button class="btn-primary" id="modalSave">Lưu</button>
      </div>
     </div>
    </div><!-- ========================================
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
      page_title: 'QUẢN LÝ SẢN PHẨM',
      add_button_text: '+ Thêm sản phẩm',
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
          
          // Update page title
          const pageTitleEl = document.getElementById('pageTitle');
          if (pageTitleEl) {
            pageTitleEl.textContent = config.page_title || defaultConfig.page_title;
          }
          
          // Update add button text
          const addButtonTextEl = document.getElementById('addButtonText');
          if (addButtonTextEl) {
            addButtonTextEl.textContent = config.add_button_text || defaultConfig.add_button_text;
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
          ['footer_text', config.footer_text || defaultConfig.footer_text],
          ['page_title', config.page_title || defaultConfig.page_title],
          ['add_button_text', config.add_button_text || defaultConfig.add_button_text]
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
      e.preventDefault();
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
    
    // Initialize Charts - using simple bar/line visual representations
    function initCharts() {
      // Inventory Status Chart
      const inventoryCtx = document.getElementById('inventoryChart');
      if (inventoryCtx) {
        const ctx = inventoryCtx.getContext('2d');
        ctx.clearRect(0, 0, inventoryCtx.width, inventoryCtx.height);
        
        // Simple bar chart visualization
        const chartHeight = 300;
        const chartWidth = inventoryCtx.width;
        const barWidth = 40;
        const spacing = 15;
        const warehouses = [
          { name: 'Kho A', value: 8500 },
          { name: 'Kho B', value: 6200 },
          { name: 'Kho C', value: 7800 },
          { name: 'Kho D', value: 5400 }
        ];
        
        const maxValue = 10000;
        const startX = 60;
        
        ctx.strokeStyle = '#e2e8f0';
        ctx.lineWidth = 1;
        
        // Draw grid lines
        for (let i = 0; i <= 5; i++) {
          const y = chartHeight - (i * chartHeight / 5) - 30;
          ctx.beginPath();
          ctx.moveTo(startX, y);
          ctx.lineTo(chartWidth - 20, y);
          ctx.stroke();
          
          ctx.fillStyle = '#94a3b8';
          ctx.font = '12px Inter';
          ctx.textAlign = 'right';
          ctx.fillText((i * 2000).toLocaleString('vi-VN'), startX - 10, y + 4);
        }
        
        // Draw bars
        warehouses.forEach((warehouse, index) => {
          const x = startX + (index * (barWidth + spacing)) + barWidth / 2;
          const barHeight = (warehouse.value / maxValue) * (chartHeight - 60);
          const y = chartHeight - 30;
          
          ctx.fillStyle = '#3b82f6';
          ctx.fillRect(x - barWidth / 2, y - barHeight, barWidth, barHeight);
          
          // Labels
          ctx.fillStyle = '#1e293b';
          ctx.font = 'bold 13px Inter';
          ctx.textAlign = 'center';
          ctx.fillText(warehouse.name, x, chartHeight - 5);
          
          ctx.font = '12px Inter';
          ctx.fillStyle = '#3b82f6';
          ctx.fillText(warehouse.value.toLocaleString('vi-VN'), x, y - barHeight - 8);
        });
      }
      
      // Import/Export Comparison Chart
      const comparisonCtx = document.getElementById('comparisonChart');
      if (comparisonCtx) {
        const ctx = comparisonCtx.getContext('2d');
        ctx.clearRect(0, 0, comparisonCtx.width, comparisonCtx.height);
        
        const chartHeight = 300;
        const chartWidth = comparisonCtx.width;
        const days = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
        const imports = [450, 520, 480, 610, 720, 590, 680];
        const exports = [320, 380, 420, 390, 480, 520, 450];
        
        const maxValue = 800;
        const spacing = (chartWidth - 100) / days.length;
        const startX = 50;
        const startY = chartHeight - 40;
        
        // Draw grid
        ctx.strokeStyle = '#e2e8f0';
        ctx.lineWidth = 1;
        
        for (let i = 0; i <= 4; i++) {
          const y = startY - (i * (chartHeight - 60) / 4);
          ctx.beginPath();
          ctx.moveTo(startX, y);
          ctx.lineTo(chartWidth - 20, y);
          ctx.stroke();
          
          ctx.fillStyle = '#94a3b8';
          ctx.font = '12px Inter';
          ctx.textAlign = 'right';
          ctx.fillText((i * 200).toLocaleString('vi-VN'), startX - 10, y + 4);
        }
        
        // Draw import line
        ctx.strokeStyle = '#10b981';
        ctx.lineWidth = 2;
        ctx.beginPath();
        imports.forEach((value, i) => {
          const x = startX + spacing + (i * spacing);
          const y = startY - ((value / maxValue) * (chartHeight - 60));
          if (i === 0) ctx.moveTo(x, y);
          else ctx.lineTo(x, y);
        });
        ctx.stroke();
        
        // Draw export line
        ctx.strokeStyle = '#ef4444';
        ctx.lineWidth = 2;
        ctx.beginPath();
        exports.forEach((value, i) => {
          const x = startX + spacing + (i * spacing);
          const y = startY - ((value / maxValue) * (chartHeight - 60));
          if (i === 0) ctx.moveTo(x, y);
          else ctx.lineTo(x, y);
        });
        ctx.stroke();
        
        // Draw data points
        imports.forEach((value, i) => {
          const x = startX + spacing + (i * spacing);
          const y = startY - ((value / maxValue) * (chartHeight - 60));
          
          ctx.fillStyle = '#10b981';
          ctx.beginPath();
          ctx.arc(x, y, 4, 0, Math.PI * 2);
          ctx.fill();
        });
        
        exports.forEach((value, i) => {
          const x = startX + spacing + (i * spacing);
          const y = startY - ((value / maxValue) * (chartHeight - 60));
          
          ctx.fillStyle = '#ef4444';
          ctx.beginPath();
          ctx.arc(x, y, 4, 0, Math.PI * 2);
          ctx.fill();
        });
        
        // Draw day labels
        ctx.fillStyle = '#1e293b';
        ctx.font = 'bold 12px Inter';
        ctx.textAlign = 'center';
        days.forEach((day, i) => {
          const x = startX + spacing + (i * spacing);
          ctx.fillText(day, x, startY + 20);
        });
        
        // Draw legend
        ctx.fillStyle = '#10b981';
        ctx.fillRect(startX, 10, 12, 12);
        ctx.fillStyle = '#1e293b';
        ctx.font = '12px Inter';
        ctx.textAlign = 'left';
        ctx.fillText('Nhập hàng', startX + 20, 19);
        
        ctx.fillStyle = '#ef4444';
        ctx.fillRect(startX + 150, 10, 12, 12);
        ctx.fillStyle = '#1e293b';
        ctx.fillText('Xuất hàng', startX + 170, 19);
      }
    }
    
    // Initialize charts when DOM is ready
    setTimeout(initCharts, 100);
    
    // ========================================
    // CATEGORY MANAGEMENT JAVASCRIPT
    // ========================================
    
    // Modal Elements
    const categoryModal = document.getElementById('categoryModal');
    const categoryModalOverlay = document.getElementById('modalOverlay');
    const categoryModalClose = document.getElementById('modalClose');
    const categoryModalCancel = document.getElementById('modalCancel');
    const categoryModalSave = document.getElementById('modalSave');
    const categoryForm = document.getElementById('categoryForm');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const categoryRefreshBtn = document.getElementById('refreshBtn');
    
    // Toolbar Elements
    const categorySearchInput = document.getElementById('searchInput');
    const categoryStatusFilter = document.getElementById('statusFilter');
    
    // Pagination Elements
    const categoryPrevBtn = document.getElementById('prevBtn');
    const categoryNextBtn = document.getElementById('nextBtn');
    
    // Modal Functions
    function openCategoryModal() {
      categoryModal.classList.add('active');
      categoryForm.reset();
      document.getElementById('modalTitle').textContent = 'Thêm danh mục mới';
      categoryModalSave.textContent = 'Lưu';
      document.querySelector('input[name="categoryStatus"][value="active"]').checked = true;
    }
    
    function closeCategoryModal() {
      categoryModal.classList.remove('active');
      categoryForm.reset();
    }
    
    function setupCategoryActionButtons() {
      const editBtns = document.querySelectorAll('#categoriesTableBody .btn-action-edit');
      const deleteBtns = document.querySelectorAll('#categoriesTableBody .btn-action-delete');
      
      editBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          const row = e.target.closest('tr');
          const categoryId = row.querySelector('.category-id').textContent;
          const categoryName = row.cells[1].textContent;
          
          document.getElementById('categoryCode').value = categoryId;
          document.getElementById('categoryName').value = categoryName;
          
          document.getElementById('modalTitle').textContent = 'Chỉnh sửa danh mục';
          categoryModalSave.textContent = 'Cập nhật';
          openCategoryModal();
        });
      });
      
      deleteBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          const row = e.target.closest('tr');
          const categoryName = row.cells[1].textContent;
          
          if (confirm(`Bạn chắc chắn muốn xóa danh mục "${categoryName}"?`)) {
            row.style.opacity = '0.5';
            row.style.textDecoration = 'line-through';
            setTimeout(() => row.remove(), 300);
          }
        });
      });
    }
    
    // Event Listeners
    addCategoryBtn.addEventListener('click', openCategoryModal);
    categoryModalClose.addEventListener('click', closeCategoryModal);
    categoryModalCancel.addEventListener('click', closeCategoryModal);
    categoryModalOverlay.addEventListener('click', closeCategoryModal);
    
    // Prevent form submission
    categoryForm.addEventListener('submit', (e) => {
      e.preventDefault();
    });
    
    // Save button
    categoryModalSave.addEventListener('click', () => {
      const code = document.getElementById('categoryCode').value;
      const name = document.getElementById('categoryName').value;
      const status = document.querySelector('input[name="categoryStatus"]:checked').value;
      
      if (code && name) {
        alert('Danh mục đã được lưu thành công!');
        closeCategoryModal();
      } else {
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
      }
    });
    
    // Search functionality
    categorySearchInput.addEventListener('input', (e) => {
      const searchTerm = e.target.value.toLowerCase();
      const rows = document.querySelectorAll('#categoriesTableBody tr');
      
      rows.forEach(row => {
        const code = row.querySelector('.category-id').textContent.toLowerCase();
        const name = row.cells[1].textContent.toLowerCase();
        
        if (code.includes(searchTerm) || name.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
    
    // Filter functionality by status
    categoryStatusFilter.addEventListener('change', (e) => {
      const status = e.target.value;
      const rows = document.querySelectorAll('#categoriesTableBody tr');
      
      rows.forEach(row => {
        if (!status) {
          row.style.display = '';
        } else if (status === 'active' && row.querySelector('.status-badge.active')) {
          row.style.display = '';
        } else if (status === 'inactive' && row.querySelector('.status-badge.inactive')) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
    
    // Refresh button
    categoryRefreshBtn.addEventListener('click', () => {
      categorySearchInput.value = '';
      categoryStatusFilter.value = '';
      
      const rows = document.querySelectorAll('#categoriesTableBody tr');
      rows.forEach(row => row.style.display = '');
      
      categoryRefreshBtn.style.animation = 'spin 0.6s ease-in-out';
      setTimeout(() => {
        categoryRefreshBtn.style.animation = '';
      }, 600);
    });
    
    // Add spin animation
    const spinStyle = document.createElement('style');
    spinStyle.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
    document.head.appendChild(spinStyle);
    
    // Pagination
    let categoryCurrentPage = 1;
    let categoryTotalPages = 3;
    
    categoryPrevBtn.addEventListener('click', () => {
      if (categoryCurrentPage > 1) {
        categoryCurrentPage--;
        updateCategoryPagination();
      }
    });
    
    categoryNextBtn.addEventListener('click', () => {
      if (categoryCurrentPage < categoryTotalPages) {
        categoryCurrentPage++;
        updateCategoryPagination();
      }
    });
    
    function updateCategoryPagination() {
      document.getElementById('currentPage').textContent = categoryCurrentPage;
      categoryPrevBtn.disabled = categoryCurrentPage === 1;
      categoryNextBtn.disabled = categoryCurrentPage === categoryTotalPages;
    }
    
    // Initialize
    updateCategoryPagination();
    setupCategoryActionButtons();
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d676887529f2442',t:'MTc3MjUyNzk4MS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>