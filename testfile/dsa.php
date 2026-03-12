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
  <title>WMS - Import Management System</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../public/CSS/phieunhap.css">

  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full">
  <div class="wms-app">
   <div class="mobile-overlay" id="mobileOverlay"></div><!-- SIDEBAR -->
   
   
   
   
   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?> 

   
   
   
   
   
   
   
   
   
   <!-- MAIN CONTENT WRAPPER -->
   <div class="wms-main"><!-- TOPBAR -->
    <?php include __DIR__ . "/../views/Layout/header.php"; ?> 
   
   
   
   <!-- MAIN CONTENT AREA -->
    <main class="wms-content" id="importListPage">
     <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
      <div class="content-header">
       <h1 class="page-title" id="pageTitle">QUẢN LÝ PHIẾU NHẬP KHO</h1>
      </div><button id="addImportBtn" class="btn-primary" style="margin-bottom: 0;">
       <svg style="width: 18px; height: 18px; margin-right: 6px;" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line> <line x1="5" y1="12" x2="19" y2="12"></line>
       </svg><span id="addButtonText">Tạo phiếu nhập</span> </button>
     </div>
     <div class="content-card" style="margin-bottom: 24px;">
      <div class="content-card-body" style="padding: 16px;">
       <div class="toolbar">
        <div class="toolbar-group"><input type="text" id="searchInput" placeholder="Tìm kiếm theo mã phiếu..." class="toolbar-search">
        </div>
        <div class="toolbar-group"><select id="supplierFilter" class="toolbar-select"> <option value="">Tất cả nhà cung cấp</option> <option value="supplier1">Công ty ABC</option> <option value="supplier2">Công ty XYZ</option> <option value="supplier3">Công ty 123</option> </select>
        </div>
        <div class="toolbar-group"><select id="warehouseFilter" class="toolbar-select"> <option value="">Tất cả kho</option> <option value="hanoi">Kho Hà Nội</option> <option value="hcm">Kho TP.HCM</option> <option value="danang">Kho Đà Nẵng</option> </select>
        </div>
        <div class="toolbar-group"><select id="statusFilter" class="toolbar-select"> <option value="">Tất cả trạng thái</option> <option value="pending">Chờ duyệt</option> <option value="approved">Đã duyệt</option> <option value="rejected">Từ chối</option> </select>
        </div>
        <div class="toolbar-group" style="display: flex; gap: 8px;"><input type="date" id="dateFrom" class="toolbar-search" style="flex: 0.5;"> <input type="date" id="dateTo" class="toolbar-search" style="flex: 0.5;">
        </div><button id="refreshBtn" class="btn-refresh">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline> <path d="M20.49 15a9 9 0 11-2-8.12"></path>
         </svg></button>
       </div>
      </div>
     </div>
     <div class="content-card">
      <div class="content-card-body" style="padding: 0;">
       <table class="imports-table">
        <thead>
         <tr>
          <th>Mã phiếu nhập</th>
          <th>Ngày tạo</th>
          <th>Nhà cung cấp</th>
          <th>Kho nhập</th>
          <th>Số mặt hàng</th>
          <th>Số lượng</th>
          <th>Tổng tiền</th>
          <th>Trạng thái</th>
          <th>Người tạo</th>
          <th>Thao tác</th>
         </tr>
        </thead>
        <tbody id="importsTableBody">
         <tr>
          <td><span class="import-id">PNK-001</span></td>
          <td>20/01/2025</td>
          <td>Công ty ABC</td>
          <td>Kho Hà Nội</td>
          <td><strong>5</strong></td>
          <td><strong>150</strong></td>
          <td><strong>75,000,000 ₫</strong></td>
          <td><span class="status-badge pending">Chờ duyệt</span></td>
          <td>Nguyễn Văn A</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button> <button class="btn-action-edit" title="Sửa">✏️</button> <button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="import-id">PNK-002</span></td>
          <td>19/01/2025</td>
          <td>Công ty XYZ</td>
          <td>Kho TP.HCM</td>
          <td><strong>8</strong></td>
          <td><strong>350</strong></td>
          <td><strong>125,500,000 ₫</strong></td>
          <td><span class="status-badge approved">Đã duyệt</span></td>
          <td>Trần Thị B</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button> <button class="btn-action-edit" title="Sửa">✏️</button> <button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="import-id">PNK-003</span></td>
          <td>18/01/2025</td>
          <td>Công ty 123</td>
          <td>Kho Đà Nẵng</td>
          <td><strong>3</strong></td>
          <td><strong>75</strong></td>
          <td><strong>45,000,000 ₫</strong></td>
          <td><span class="status-badge rejected">Từ chối</span></td>
          <td>Lê Văn C</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button> <button class="btn-action-edit" title="Sửa">✏️</button> <button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="import-id">PNK-004</span></td>
          <td>17/01/2025</td>
          <td>Công ty ABC</td>
          <td>Kho TP.HCM</td>
          <td><strong>6</strong></td>
          <td><strong>200</strong></td>
          <td><strong>95,500,000 ₫</strong></td>
          <td><span class="status-badge approved">Đã duyệt</span></td>
          <td>Phạm Thị D</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button> <button class="btn-action-edit" title="Sửa">✏️</button> <button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="import-id">PNK-005</span></td>
          <td>16/01/2025</td>
          <td>Công ty XYZ</td>
          <td>Kho Hà Nội</td>
          <td><strong>4</strong></td>
          <td><strong>120</strong></td>
          <td><strong>65,000,000 ₫</strong></td>
          <td><span class="status-badge pending">Chờ duyệt</span></td>
          <td>Vũ Văn E</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button> <button class="btn-action-edit" title="Sửa">✏️</button> <button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="import-id">PNK-006</span></td>
          <td>15/01/2025</td>
          <td>Công ty 123</td>
          <td>Kho Hà Nội</td>
          <td><strong>7</strong></td>
          <td><strong>280</strong></td>
          <td><strong>155,000,000 ₫</strong></td>
          <td><span class="status-badge approved">Đã duyệt</span></td>
          <td>Hoàng Văn F</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button> <button class="btn-action-edit" title="Sửa">✏️</button> <button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div>
     <div class="pagination"><button class="pagination-btn" id="prevBtn">← Trước</button>
      <div class="pagination-info"><span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">1</strong></span>
      </div><button class="pagination-btn" id="nextBtn">Tiếp theo →</button>
     </div>
    </main><!-- CREATE IMPORT ORDER PAGE -->
    <main class="wms-content" id="importFormPage" style="display: none;">
     <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
      <div class="content-header">
       <h1 class="page-title">TẠO PHIẾU NHẬP KHO</h1>
      </div>
     </div>
     <div class="content-card" style="margin-bottom: 24px;">
      <div class="content-card-header">
       <h3 class="content-card-title">Thông tin chung</h3>
      </div>
      <div class="content-card-body">
       <form id="generalInfoForm" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group"><label for="importCode">Mã phiếu nhập <span style="color: #ef4444;">*</span></label> <input type="text" id="importCode" placeholder="VD: PNK-007" required>
        </div>
        <div class="form-group"><label for="importDate">Ngày nhập <span style="color: #ef4444;">*</span></label> <input type="date" id="importDate" required>
        </div>
        <div class="form-group"><label for="supplierSelect">Nhà cung cấp <span style="color: #ef4444;">*</span></label> <select id="supplierSelect" required> <option value="">Chọn nhà cung cấp</option> <option value="sup1">Công ty ABC</option> <option value="sup2">Công ty XYZ</option> <option value="sup3">Công ty 123</option> </select>
        </div>
        <div class="form-group"><label for="warehouseSelect">Kho nhập <span style="color: #ef4444;">*</span></label> <select id="warehouseSelect" required> <option value="">Chọn kho</option> <option value="wh1">Kho Hà Nội</option> <option value="wh2">Kho TP.HCM</option> <option value="wh3">Kho Đà Nẵng</option> </select>
        </div>
        <div class="form-group"><label for="createdBy">Người tạo</label> <input type="text" id="createdBy" placeholder="Nguyễn Văn A" disabled>
        </div>
        <div class="form-group"></div>
        <div class="form-group" style="grid-column: 1 / -1;"><label for="notes">Ghi chú</label> <textarea id="notes" placeholder="Nhập ghi chú..."></textarea>
        </div>
       </form>
      </div>
     </div>
     <div class="content-card" style="margin-bottom: 24px;">
      <div class="content-card-header">
       <h3 class="content-card-title">Danh sách sản phẩm nhập</h3><button id="addProductRowBtn" class="btn-primary" style="margin-bottom: 0;">
        <svg style="width: 16px; height: 16px;" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line> <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg> Thêm sản phẩm </button>
      </div>
      <div class="content-card-body" style="padding: 0; overflow-x: auto;">
       <table class="products-table">
        <thead>
         <tr>
          <th>Mã sản phẩm</th>
          <th>Tên sản phẩm</th>
          <th style="width: 100px;">Số lượng</th>
          <th style="width: 120px;">Giá nhập (₫)</th>
          <th style="width: 120px;">Thành tiền (₫)</th>
          <th style="width: 60px;">Xóa</th>
         </tr>
        </thead>
        <tbody id="productsTableBody">
         <tr class="product-row" data-row-id="1">
          <td><input type="text" class="product-code" placeholder="VD: SP-001" value="SP-001" style="width: 100%;"></td>
          <td><input type="text" class="product-name" placeholder="Tên sản phẩm" value="Sản phẩm mẫu 1" style="width: 100%;"></td>
          <td><input type="number" class="product-qty" placeholder="0" value="50" min="1" style="width: 100%;"></td>
          <td><input type="number" class="product-price" placeholder="0" value="1000000" min="0" style="width: 100%;"></td>
          <td><span class="product-total">50,000,000</span></td>
          <td><button class="btn-delete-row" type="button">🗑️</button></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div>
     <div class="content-card" style="margin-bottom: 24px;">
      <div class="content-card-body">
       <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        <div style="padding: 16px; background: var(--bg-light); border-radius: 8px; text-align: center;">
         <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
          Tổng số mặt hàng
         </div>
         <div style="font-size: 28px; font-weight: 700; color: var(--primary-navy);" id="totalItems">
          1
         </div>
        </div>
        <div style="padding: 16px; background: var(--bg-light); border-radius: 8px; text-align: center;">
         <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
          Tổng số lượng
         </div>
         <div style="font-size: 28px; font-weight: 700; color: var(--primary-navy);" id="totalQuantity">
          50
         </div>
        </div>
        <div style="padding: 16px; background: var(--bg-light); border-radius: 8px; text-align: center;">
         <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
          Tổng tiền
         </div>
         <div style="font-size: 28px; font-weight: 700; color: var(--accent-blue);" id="totalAmount">
          50,000,000
         </div>
        </div>
       </div>
      </div>
     </div>
     <div style="display: flex; gap: 12px; justify-content: flex-end; margin-bottom: 24px;"><button id="formCancelBtn" class="btn-secondary">Hủy</button> <button id="formSaveDraftBtn" class="btn-secondary">Lưu nháp</button> <button id="formSubmitBtn" class="btn-primary">Gửi duyệt</button>
     </div>
    </main><!-- FOOTER -->
    <footer class="wms-footer">
     <p class="footer-text" id="footerText">© 2026 Warehouse Management System — Developed for Academic Project</p>
    </footer>
   </div>
  </div>
  <script>
    // Default configuration
    const defaultConfig = {
      system_name: 'WMS',
      footer_text: '© 2026 Warehouse Management System — Developed for Academic Project',
      page_title: 'QUẢN LÝ PHIẾU NHẬP KHO',
      add_button_text: '+ Tạo phiếu nhập',
      primary_color: '#1e3a5f',
      secondary_color: '#f8fafc',
      text_color: '#1e293b',
      accent_color: '#3b82f6',
      font_family: 'Inter'
    };
    
    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange: async (config) => {
          const systemNameEl = document.getElementById('systemName');
          if (systemNameEl) {
            systemNameEl.textContent = config.system_name || defaultConfig.system_name;
          }
          
          const pageTitleEl = document.getElementById('pageTitle');
          if (pageTitleEl) {
            pageTitleEl.textContent = config.page_title || defaultConfig.page_title;
          }
          
          const addButtonTextEl = document.getElementById('addButtonText');
          if (addButtonTextEl) {
            addButtonTextEl.textContent = config.add_button_text || defaultConfig.add_button_text;
          }
          
          const footerTextEl = document.getElementById('footerText');
          if (footerTextEl) {
            footerTextEl.textContent = config.footer_text || defaultConfig.footer_text;
          }
          
          const root = document.documentElement;
          root.style.setProperty('--primary-navy', config.primary_color || defaultConfig.primary_color);
          root.style.setProperty('--bg-light', config.secondary_color || defaultConfig.secondary_color);
          root.style.setProperty('--text-primary', config.text_color || defaultConfig.text_color);
          root.style.setProperty('--accent-blue', config.accent_color || defaultConfig.accent_color);
          
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
    
    // Layout functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const userDropdown = document.getElementById('userDropdown');
    const userTrigger = document.getElementById('userTrigger');
    const navItems = document.querySelectorAll('.nav-item');
    const breadcrumbCurrent = document.getElementById('breadcrumbCurrent');
    
    let isSidebarCollapsed = false;
    let isMobile = window.innerWidth <= 768;
    
    function toggleSidebar() {
      if (isMobile) {
        sidebar.classList.toggle('mobile-open');
        mobileOverlay.classList.toggle('active');
      } else {
        isSidebarCollapsed = !isSidebarCollapsed;
        sidebar.classList.toggle('collapsed', isSidebarCollapsed);
      }
    }
    
    function closeMobileSidebar() {
      sidebar.classList.remove('mobile-open');
      mobileOverlay.classList.remove('active');
    }
    
    function toggleUserDropdown(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('open');
    }
    
    function closeUserDropdown() {
      userDropdown.classList.remove('open');
    }
    
    function handleNavClick(e) {
     
      const clickedItem = e.currentTarget;
      const pageName = clickedItem.getAttribute('data-page');
      
      navItems.forEach(item => item.classList.remove('active'));
      clickedItem.classList.add('active');
      
      const pageNames = {
        'dashboard': 'Dashboard',
        'import': 'Import Management',
        'export': 'Export Orders',
        'users': 'Users'
      };
      
      if (breadcrumbCurrent && pageNames[pageName]) {
        breadcrumbCurrent.textContent = pageNames[pageName];
      }
      
      if (isMobile) {
        closeMobileSidebar();
      }
    }
    
    function handleResize() {
      const wasMobile = isMobile;
      isMobile = window.innerWidth <= 768;
      
      if (wasMobile !== isMobile) {
        sidebar.classList.remove('collapsed', 'mobile-open');
        mobileOverlay.classList.remove('active');
        isSidebarCollapsed = false;
      }
    }
    
    sidebarToggle.addEventListener('click', toggleSidebar);
    mobileOverlay.addEventListener('click', closeMobileSidebar);
    userTrigger.addEventListener('click', toggleUserDropdown);
    
    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target)) {
        closeUserDropdown();
      }
    });
    
    navItems.forEach(item => {
      item.addEventListener('click', handleNavClick);
    });
    
    window.addEventListener('resize', handleResize);
    
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeUserDropdown();
        if (isMobile) {
          closeMobileSidebar();
        }
      }
    });
    
    handleResize();
    
    // Import Management functionality
    const importListPage = document.getElementById('importListPage');
    const importFormPage = document.getElementById('importFormPage');
    const addImportBtn = document.getElementById('addImportBtn');
    const formCancelBtn = document.getElementById('formCancelBtn');
    const formSaveDraftBtn = document.getElementById('formSaveDraftBtn');
    const formSubmitBtn = document.getElementById('formSubmitBtn');
    const addProductRowBtn = document.getElementById('addProductRowBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const searchInput = document.getElementById('searchInput');
    const productsTableBody = document.getElementById('productsTableBody');
    
    let nextRowId = 2;
    
    function switchToForm() {
      importListPage.style.display = 'none';
      importFormPage.style.display = 'block';
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('importDate').value = today;
      document.getElementById('createdBy').value = 'Nguyễn Văn A';
    }
    
    function switchToList() {
      importListPage.style.display = 'block';
      importFormPage.style.display = 'none';
    }
    
    function calculateTotal(row) {
      const qty = parseFloat(row.querySelector('.product-qty').value) || 0;
      const price = parseFloat(row.querySelector('.product-price').value) || 0;
      const total = qty * price;
      row.querySelector('.product-total').textContent = total.toLocaleString('vi-VN');
      updateSummary();
    }
    
    function updateSummary() {
      let totalItems = document.querySelectorAll('.product-row').length;
      let totalQty = 0;
      let totalAmount = 0;
      
      document.querySelectorAll('.product-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.product-qty').value) || 0;
        const price = parseFloat(row.querySelector('.product-price').value) || 0;
        totalQty += qty;
        totalAmount += qty * price;
      });
      
      document.getElementById('totalItems').textContent = totalItems;
      document.getElementById('totalQuantity').textContent = totalQty;
      document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('vi-VN');
    }
    
    function addProductRow() {
      const newRow = document.createElement('tr');
      newRow.className = 'product-row';
      newRow.setAttribute('data-row-id', nextRowId);
      newRow.innerHTML = `
        <td><input type="text" class="product-code" placeholder="VD: SP-001" style="width: 100%;"></td>
        <td><input type="text" class="product-name" placeholder="Tên sản phẩm" style="width: 100%;"></td>
        <td><input type="number" class="product-qty" placeholder="0" min="1" value="1" style="width: 100%;"></td>
        <td><input type="number" class="product-price" placeholder="0" min="0" style="width: 100%;"></td>
        <td><span class="product-total">0</span></td>
        <td><button class="btn-delete-row" type="button">🗑️</button></td>
      `;
      
      const qtyInput = newRow.querySelector('.product-qty');
      const priceInput = newRow.querySelector('.product-price');
      const deleteBtn = newRow.querySelector('.btn-delete-row');
      
      qtyInput.addEventListener('input', () => calculateTotal(newRow));
      priceInput.addEventListener('input', () => calculateTotal(newRow));
      deleteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        newRow.remove();
        updateSummary();
      });
      
      productsTableBody.appendChild(newRow);
      nextRowId++;
      updateSummary();
    }
    
    function setupProductRows() {
      document.querySelectorAll('.product-row').forEach(row => {
        const qtyInput = row.querySelector('.product-qty');
        const priceInput = row.querySelector('.product-price');
        const deleteBtn = row.querySelector('.btn-delete-row');
        
        qtyInput.addEventListener('input', () => calculateTotal(row));
        priceInput.addEventListener('input', () => calculateTotal(row));
        deleteBtn.addEventListener('click', (e) => {
          e.preventDefault();
          row.remove();
          updateSummary();
        });
      });
      
      updateSummary();
    }
    
    function setupImportTableActions() {
      document.querySelectorAll('#importsTableBody .btn-action-view').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const row = e.target.closest('tr');
          const importCode = row.querySelector('.import-id').textContent;
          alert(`Chi tiết phiếu nhập: ${importCode}`);
        });
      });
      
      document.querySelectorAll('#importsTableBody .btn-action-edit').forEach(btn => {
        btn.addEventListener('click', (e) => {
          switchToForm();
        });
      });
      
      document.querySelectorAll('#importsTableBody .btn-action-delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const row = e.target.closest('tr');
          const importCode = row.querySelector('.import-id').textContent;
          if (confirm(`Bạn chắc chắn muốn xóa phiếu "${importCode}"?`)) {
            row.style.opacity = '0.5';
            row.style.textDecoration = 'line-through';
            setTimeout(() => row.remove(), 300);
          }
        });
      });
    }
    
    addImportBtn.addEventListener('click', switchToForm);
    formCancelBtn.addEventListener('click', switchToList);
    formSaveDraftBtn.addEventListener('click', () => {
      alert('Phiếu nhập đã được lưu nháp!');
      switchToList();
    });
    formSubmitBtn.addEventListener('click', () => {
      alert('Phiếu nhập đã được gửi duyệt!');
      switchToList();
    });
    
    addProductRowBtn.addEventListener('click', addProductRow);
    
    refreshBtn.addEventListener('click', () => {
      searchInput.value = '';
      document.getElementById('supplierFilter').value = '';
      document.getElementById('warehouseFilter').value = '';
      document.getElementById('statusFilter').value = '';
      document.getElementById('dateFrom').value = '';
      document.getElementById('dateTo').value = '';
      
      document.querySelectorAll('#importsTableBody tr').forEach(row => row.style.display = '');
      
      refreshBtn.style.animation = 'spin 0.6s ease-in-out';
      setTimeout(() => {
        refreshBtn.style.animation = '';
      }, 600);
    });
    
    searchInput.addEventListener('input', (e) => {
      const searchTerm = e.target.value.toLowerCase();
      document.querySelectorAll('#importsTableBody tr').forEach(row => {
        const code = row.querySelector('.import-id').textContent.toLowerCase();
        row.style.display = code.includes(searchTerm) ? '' : 'none';
      });
    });
    
    setupProductRows();
    setupImportTableActions();
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d77c0ca66bde2fd',t:'MTc3MjY5OTM2OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>