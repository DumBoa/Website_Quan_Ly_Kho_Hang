<?php
session_start();

if (!isset($_SESSION["ma_nguoi_dung"])) {
  header("Location: /Project_QuanLyKhoHang/public/login.php");
  exit;
}

// Lấy thông tin người dùng
$ma_nguoi_dung = $_SESSION["ma_nguoi_dung"];
$ten = $_SESSION["ho_ten"];
$role = $_SESSION["vai_tro"];
$username = $_SESSION["ten_dang_nhap"];
?>

<!doctype html>
<html lang="en" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WMS - Quản lý phiếu nhập</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/CSS/phieunhap.css">
  <style>
    /* Thêm một số style bổ sung */
    .loading {
      opacity: 0.5;
      pointer-events: none;
      position: relative;
    }

    .loading::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 30px;
      height: 30px;
      margin: -15px 0 0 -15px;
      border: 3px solid #f3f3f3;
      border-top: 3px solid var(--accent-blue);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 24px;
      border-radius: 8px;
      color: white;
      z-index: 1000;
      animation: slideIn 0.3s ease;
    }

    .toast.success {
      background: #10b981;
    }

    .toast.error {
      background: #ef4444;
    }

    .toast.warning {
      background: #f59e0b;
    }

    .toast.info {
      background: #3b82f6;
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }

      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
  </style>
</head>

<body class="h-full">
  <div class="wms-app">
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- SIDEBAR -->
    <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="wms-main">
      <!-- TOPBAR -->
      <?php include __DIR__ . "/../views/Layout/header.php"; ?>

      <!-- MAIN CONTENT AREA - DANH SÁCH PHIẾU NHẬP -->
      <main class="wms-content" id="importListPage">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
          <div class="content-header">
            <h1 class="page-title" id="pageTitle">QUẢN LÝ PHIẾU NHẬP KHO</h1>
          </div>
          <button id="addImportBtn" class="btn-primary" style="margin-bottom: 0;">
            <svg style="width: 18px; height: 18px; margin-right: 6px;" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span id="addButtonText">Tạo phiếu nhập</span>
          </button>
        </div>

        <!-- Bộ lọc -->
        <div class="content-card" style="margin-bottom: 24px;">
          <div class="content-card-body" style="padding: 16px;">
            <div class="toolbar">
              <div class="toolbar-group">
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo mã phiếu..." class="toolbar-search">
              </div>
              <div class="toolbar-group">
                <select id="supplierFilter" class="toolbar-select">
                  <option value="">Tất cả nhà cung cấp</option>
                </select>
              </div>
              <div class="toolbar-group">
                <select id="warehouseFilter" class="toolbar-select">
                  <option value="">Tất cả kho</option>
                </select>
              </div>
              <div class="toolbar-group">
                <select id="statusFilter" class="toolbar-select">
                  <option value="">Tất cả trạng thái</option>
                  <option value="0">Chờ duyệt</option>
                  <option value="1">Đã duyệt</option>
                  <option value="2">Từ chối</option>
                </select>
              </div>
              <div class="toolbar-group" style="display: flex; gap: 8px;">
                <input type="date" id="dateFrom" class="toolbar-search" style="flex: 0.5;">
                <input type="date" id="dateTo" class="toolbar-search" style="flex: 0.5;">
              </div>
              <button id="refreshBtn" class="btn-refresh">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="23 4 23 10 17 10"></polyline>
                  <path d="M20.49 15a9 9 0 11-2-8.12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Bảng danh sách phiếu nhập -->
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
                  <td colspan="10" style="text-align:center; padding:40px; color:#666;">
                    Đang tải dữ liệu...
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Phân trang -->
        <div class="pagination">
          <button class="pagination-btn" id="prevBtn" disabled>← Trước</button>
          <div class="pagination-info">
            <span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">1</strong></span>
          </div>
          <button class="pagination-btn" id="nextBtn" disabled>Tiếp theo →</button>
        </div>
      </main>

      <!-- FORM TẠO PHIẾU NHẬP -->
      <main class="wms-content" id="importFormPage" style="display: none;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
          <div class="content-header">
            <h1 class="page-title">TẠO PHIẾU NHẬP KHO</h1>
          </div>
        </div>

        <!-- Thông tin chung -->
        <div class="content-card" style="margin-bottom: 24px;">
          <div class="content-card-header">
            <h3 class="content-card-title">Thông tin chung</h3>
          </div>
          <div class="content-card-body">
            <form id="generalInfoForm" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div class="form-group">
                <label for="warehouseSelect">Kho nhập <span style="color: #ef4444;">*</span></label>
                <select id="warehouseSelect" required>
                  <option value="">Chọn kho</option>
                </select>
              </div>
              <div class="form-group">
                <label for="supplierSelect">Nhà cung cấp <span style="color: #ef4444;">*</span></label>
                <select id="supplierSelect" required>
                  <option value="">Chọn nhà cung cấp</option>
                </select>
              </div>
              <div class="form-group">
                <label for="createdBy">Người tạo</label>
                <input type="text" id="createdBy" value="<?php echo $ten; ?>" disabled>
              </div>
              <div class="form-group">
                <label for="createdDate">Ngày tạo</label>
                <input type="text" id="createdDate" value="<?php echo date('d/m/Y'); ?>" disabled>
              </div>
              <div class="form-group" style="grid-column: 1 / -1;">
                <label for="notes">Ghi chú</label>
                <textarea id="notes" placeholder="Nhập ghi chú..."></textarea>
              </div>
            </form>
          </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <!-- Danh sách sản phẩm để chọn -->
        <!-- Danh sách sản phẩm nhập -->
<div class="content-card" style="margin-bottom: 24px;">
    <div class="content-card-header">
        <h3 class="content-card-title">Danh sách sản phẩm nhập</h3>
        <button id="addProductRowBtn" class="btn-primary" style="margin-bottom: 0;">
            <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Thêm dòng trống
        </button>
    </div>
    <div class="content-card-body" style="padding: 0; overflow-x: auto; max-height: 300px; overflow-y: auto;">
        <table class="products-table" id="selectedProductsTable" style="min-width: 100%;">
            <thead style="position: sticky; top: 0; background: white; z-index: 10;">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th style="width: 100px;">Số lượng</th>
                    <th style="width: 120px;">Giá nhập (₫)</th>
                    <th style="width: 120px;">Thành tiền (₫)</th>
                    <th style="width: 60px;">Xóa</th>
                </tr>
            </thead>
            <tbody id="selectedProductsBody">
                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
            </tbody>
        </table>
    </div>
    <div class="content-card-footer" style="padding: 8px 16px; border-top: 1px solid var(--border-color); background: var(--bg-light); display: flex; justify-content: space-between; align-items: center;">
        <div style="color: var(--text-secondary); font-size: 13px;">
            Tổng số: <span id="selectedTotalRows">0</span> sản phẩm
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="pagination-btn" id="selectedPrevBtn" disabled>←</button>
            <span style="font-size: 13px; padding: 0 8px;"><span id="selectedCurrentPage">1</span>/<span id="selectedTotalPages">1</span></span>
            <button class="pagination-btn" id="selectedNextBtn" disabled>→</button>
        </div>
    </div>
</div>

<!-- Danh sách sản phẩm để chọn -->
<div class="content-card" style="margin-bottom: 24px;">
    <div class="content-card-header">
        <h3 class="content-card-title">Danh sách sản phẩm</h3>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="searchProductInput" placeholder="Tìm kiếm sản phẩm..."
                style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px; width: 300px;">
            <button id="searchProductBtn" class="btn-primary" style="padding: 8px 16px;">
                <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                Tìm
            </button>
        </div>
    </div>
    <div class="content-card-body" style="padding: 0; overflow-x: auto; max-height: 400px; overflow-y: auto;">
        <table class="products-table" style="min-width: 100%;">
            <thead style="position: sticky; top: 0; background: white; z-index: 10;">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Kho</th>
                    <th>Tồn kho</th>
                    <th>Giá nhập</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="productChooseBody">
                <tr>
                    <td colspan="8" style="text-align:center; padding:40px; color:#666;">
                        Đang tải dữ liệu...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="content-card-footer" style="padding: 8px 16px; border-top: 1px solid var(--border-color); background: var(--bg-light); display: flex; justify-content: space-between; align-items: center;">
        <div style="color: var(--text-secondary); font-size: 13px;">
            Hiển thị <span id="productDisplayStart">0</span>-<span id="productDisplayEnd">0</span> / <span id="productTotalRows">0</span> sản phẩm
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="pagination-btn" id="productPrevBtn" disabled>←</button>
            <span style="font-size: 13px; padding: 0 8px;"><span id="productCurrentPage">1</span>/<span id="productTotalPages">1</span></span>
            <button class="pagination-btn" id="productNextBtn" disabled>→</button>
        </div>
    </div>
</div>
        <!-- Tổng kết -->
        <div class="content-card" style="margin-bottom: 24px;">
          <div class="content-card-body">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
              <div style="padding: 16px; background: var(--bg-light); border-radius: 8px; text-align: center;">
                <div
                  style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
                  Tổng số mặt hàng
                </div>
                <div style="font-size: 28px; font-weight: 700; color: var(--primary-navy);" id="totalItems">0</div>
              </div>
              <div style="padding: 16px; background: var(--bg-light); border-radius: 8px; text-align: center;">
                <div
                  style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
                  Tổng số lượng
                </div>
                <div style="font-size: 28px; font-weight: 700; color: var(--primary-navy);" id="totalQuantity">0</div>
              </div>
              <div style="padding: 16px; background: var(--bg-light); border-radius: 8px; text-align: center;">
                <div
                  style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
                  Tổng tiền
                </div>
                <div style="font-size: 28px; font-weight: 700; color: var(--accent-blue);" id="totalAmount">0</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Nút hành động -->
        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-bottom: 24px;">
          <button id="formCancelBtn" class="btn-secondary">Hủy</button>
          <button id="formSaveDraftBtn" class="btn-primary">Lưu</button>
          <!-- <button id="formSubmitBtn" class="btn-primary">Gửi duyệt</button> -->
        </div>
      </main>

      <!-- FORM XEM CHI TIẾT -->
      <main class="wms-content" id="importDetailPage" style="display: none;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
          <div class="content-header">
            <h1 class="page-title" id="detailTitle">CHI TIẾT PHIẾU NHẬP</h1>
          </div>
          <button id="backToListBtn" class="btn-secondary">
            <svg style="width: 18px; height: 18px; margin-right: 6px;" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2">
              <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Quay lại
          </button>
        </div>

        <!-- Thông tin phiếu -->
        <div class="content-card" style="margin-bottom: 24px;">
          <div class="content-card-header">
            <h3 class="content-card-title">Thông tin phiếu nhập</h3>
            <div id="detailStatus"></div>
          </div>
          <div class="content-card-body">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Mã phiếu</div>
                <div style="font-size: 16px; font-weight: 600;" id="detailCode">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Ngày tạo</div>
                <div style="font-size: 16px;" id="detailDate">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Kho nhập</div>
                <div style="font-size: 16px;" id="detailWarehouse">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Nhà cung cấp</div>
                <div style="font-size: 16px;" id="detailSupplier">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Người tạo</div>
                <div style="font-size: 16px;" id="detailCreator">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Người duyệt</div>
                <div style="font-size: 16px;" id="detailApprover">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Ngày duyệt</div>
                <div style="font-size: 16px;" id="detailApproveDate">-</div>
              </div>
              <div>
                <div style="font-size: 12px; color: var(--text-muted);">Ghi chú</div>
                <div style="font-size: 16px;" id="detailNote">-</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="content-card" style="margin-bottom: 24px;">
          <div class="content-card-header">
            <h3 class="content-card-title">Danh sách sản phẩm</h3>
          </div>
          <div class="content-card-body" style="padding: 0;">
            <table class="products-table">
              <thead>
                <tr>
                  <th>Mã SP</th>
                  <th>Tên sản phẩm</th>
                  <th>Số lượng</th>
                  <th>Giá nhập</th>
                  <th>Thành tiền</th>
                </tr>
              </thead>
              <tbody id="detailProductsBody">
                <tr>
                  <td colspan="5" style="text-align:center; padding:20px;">Đang tải...</td>
                </tr>
              </tbody>
              <tfoot>
                <tr style="background: var(--bg-light); font-weight: 600;">
                  <td colspan="2" style="text-align: right;">Tổng cộng:</td>
                  <td id="detailTotalQty">0</td>
                  <td></td>
                  <td id="detailTotalAmount">0</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- Nút duyệt/từ chối (chỉ hiện với phiếu chờ duyệt) -->
        <div id="approvalButtons" style="display: flex; gap: 12px; justify-content: flex-end; margin-bottom: 24px;">
          <button id="approveBtn" class="btn-primary" style="background: #10b981;">Duyệt phiếu</button>
          <button id="rejectBtn" class="btn-secondary" style="border-color: #ef4444; color: #ef4444;">Từ chối</button>
        </div>
      </main>

      <!-- FOOTER -->
      <footer class="wms-footer">
        <p class="footer-text" id="footerText">© 2026 Warehouse Management System — Developed for Academic Project</p>
      </footer>
    </div>
  </div>

  <!-- Toast container -->
  <div id="toastContainer"></div>

  <script>
    // Cấu hình
    const currentUser = {
      ma_nguoi_dung: <?php echo $ma_nguoi_dung; ?>,
      ho_ten: '<?php echo $ten; ?>'
    };

    // Biến toàn cục
    let currentPage = 1;
    let totalPages = 1;
    let importList = [];
    let suppliers = [];
    let warehouses = [];
    let products = [];
    let currentDetailId = null;

    // ==================== UTILITY FUNCTIONS ====================
    function showToast(message, type = 'info') {
      const toast = document.createElement('div');
      toast.className = `toast ${type}`;
      toast.textContent = message;
      document.getElementById('toastContainer').appendChild(toast);

      setTimeout(() => {
        toast.remove();
      }, 3000);
    }

    function formatCurrency(amount) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }

    function formatDate(dateString) {
      if (!dateString) return '-';
      const date = new Date(dateString);
      return date.toLocaleDateString('vi-VN');
    }

    function getStatusBadge(status) {
      switch (status) {
        case 0: return '<span class="status-badge pending">Chờ duyệt</span>';
        case 1: return '<span class="status-badge approved">Đã duyệt</span>';
        case 2: return '<span class="status-badge rejected">Từ chối</span>';
        default: return '<span class="status-badge">Không xác định</span>';
      }
    }
// ==================== PHÂN TRANG CHO BẢNG SẢN PHẨM CHỌN ====================
let allProducts = [];
let currentProductPage = 1;
const productsPerPage = 10;

// Cập nhật hàm loadProductListForChoose
async function loadProductListForChoose(search = '') {
    try {
        let url = '../actions/QuanLyPhieuNhap/lay_danh_sach_hang_hoa.php';
        if (search) {
            url += `?search=${encodeURIComponent(search)}`;
        }

        const response = await fetch(url);
        const result = await response.json();

        if (result.success) {
            allProducts = result.data;
            currentProductPage = 1;
            renderProductChooseTable();
            updateProductPagination();
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error loading products:', error);
        showToast('Lỗi tải danh sách sản phẩm', 'error');
    }
}

// Render bảng sản phẩm để chọn có phân trang
function renderProductChooseTable() {
    const tbody = document.getElementById('productChooseBody');
    
    if (allProducts.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px;">Không có sản phẩm nào</td></tr>';
        return;
    }

    // Tính toán phân trang
    const start = (currentProductPage - 1) * productsPerPage;
    const end = Math.min(start + productsPerPage, allProducts.length);
    const paginatedProducts = allProducts.slice(start, end);

    tbody.innerHTML = paginatedProducts.map(product => {
        const stockClass = getStockClass(product.ton_kho);

        return `
        <tr class="product-choose-row" 
            data-id="${product.ma_hang_hoa}"
            data-code="${product.ma_san_pham}"
            data-name="${product.ten_hang_hoa}"
            data-price="${product.gia_nhap}"
            onclick="selectProductFromTable(this)">
            <td><strong>${product.ma_san_pham}</strong></td>
            <td>${product.ten_hang_hoa}</td>
            <td>${product.ten_danh_muc}</td>
            <td>${product.ten_kho}</td>
            <td><span class="stock-badge ${stockClass}">${product.ton_kho}</span></td>
            <td>${formatCurrency(product.gia_nhap)}</td>
            <td>
                <span class="status-badge ${product.trang_thai == 1 ? 'approved' : 'rejected'}">
                    ${product.trang_thai == 1 ? 'Đang bán' : 'Ngừng bán'}
                </span>
            </td>
            <td>
                <button class="btn-action-add" onclick="addToImportList(event, this)" 
                        title="Thêm vào phiếu nhập">
                    <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </td>
        </tr>
    `}).join('');

    updateProductPagination();
}

// Cập nhật phân trang cho bảng sản phẩm chọn
function updateProductPagination() {
    const totalPages = Math.ceil(allProducts.length / productsPerPage);
    const start = (currentProductPage - 1) * productsPerPage + 1;
    const end = Math.min(currentProductPage * productsPerPage, allProducts.length);

    document.getElementById('productDisplayStart').textContent = allProducts.length > 0 ? start : 0;
    document.getElementById('productDisplayEnd').textContent = end;
    document.getElementById('productTotalRows').textContent = allProducts.length;
    document.getElementById('productCurrentPage').textContent = currentProductPage;
    document.getElementById('productTotalPages').textContent = totalPages || 1;

    document.getElementById('productPrevBtn').disabled = currentProductPage <= 1;
    document.getElementById('productNextBtn').disabled = currentProductPage >= totalPages;
}

// Xử lý chuyển trang cho bảng sản phẩm chọn
document.getElementById('productPrevBtn').addEventListener('click', () => {
    if (currentProductPage > 1) {
        currentProductPage--;
        renderProductChooseTable();
    }
});

document.getElementById('productNextBtn').addEventListener('click', () => {
    const totalPages = Math.ceil(allProducts.length / productsPerPage);
    if (currentProductPage < totalPages) {
        currentProductPage++;
        renderProductChooseTable();
    }
});

// ==================== PHÂN TRANG CHO BẢNG SẢN PHẨM NHẬP ====================
let currentSelectedPage = 1;
const selectedPerPage = 5;

// Hàm render bảng sản phẩm nhập có phân trang
function renderSelectedProductsTable() {
    const allRows = Array.from(document.querySelectorAll('#selectedProductsBody .product-row'));
    const totalRows = allRows.length;
    const totalPages = Math.ceil(totalRows / selectedPerPage);

    // Điều chỉnh current page nếu cần
    if (currentSelectedPage > totalPages) {
        currentSelectedPage = totalPages || 1;
    }

    // Ẩn tất cả rows
    allRows.forEach(row => row.style.display = 'none');

    // Hiển thị rows của trang hiện tại
    const start = (currentSelectedPage - 1) * selectedPerPage;
    const end = Math.min(start + selectedPerPage, totalRows);
    
    for (let i = start; i < end; i++) {
        if (allRows[i]) {
            allRows[i].style.display = '';
        }
    }

    // Cập nhật thông tin phân trang
    document.getElementById('selectedTotalRows').textContent = totalRows;
    document.getElementById('selectedCurrentPage').textContent = currentSelectedPage;
    document.getElementById('selectedTotalPages').textContent = totalPages || 1;

    document.getElementById('selectedPrevBtn').disabled = currentSelectedPage <= 1;
    document.getElementById('selectedNextBtn').disabled = currentSelectedPage >= totalPages;
}

// Cập nhật các hàm liên quan để gọi renderSelectedProductsTable()

// Cập nhật hàm addProductToImportTable
function addProductToImportTable(product) {
    // Kiểm tra sản phẩm đã có trong bảng nhập chưa
    const existingRows = document.querySelectorAll('#selectedProductsBody .product-row');
    for (let row of existingRows) {
        const productId = row.querySelector('.product-id').value;
        if (productId == product.ma_hang_hoa) {
            // Nếu đã có, tăng số lượng lên 1
            const qtyInput = row.querySelector('.product-qty');
            qtyInput.value = parseInt(qtyInput.value) + 1;
            calculateRowTotal(row);
            updateSummary();
            
            // Highlight dòng trong bảng nhập
            row.style.backgroundColor = '#f0f9ff';
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 500);
            
            renderSelectedProductsTable();
            return;
        }
    }

    // Nếu chưa có, thêm dòng mới
    const newRow = document.createElement('tr');
    newRow.className = 'product-row';
    newRow.setAttribute('data-row-id', Date.now());
    newRow.style.display = 'none'; // Ẩn ban đầu, sẽ hiển thị qua phân trang
    newRow.innerHTML = `
        <td>
            <input type="text" class="product-code" value="${product.ma_san_pham}" style="width: 100%;" readonly>
            <input type="hidden" class="product-id" value="${product.ma_hang_hoa}">
        </td>
        <td>
            <input type="text" class="product-name" value="${product.ten_hang_hoa}" style="width: 100%;" readonly>
        </td>
        <td><input type="number" class="product-qty" placeholder="0" value="1" min="1" style="width: 100%;"></td>
        <td><input type="number" class="product-price" placeholder="0" value="${product.gia_nhap}" min="0" style="width: 100%;"></td>
        <td><span class="product-total">${formatCurrency(product.gia_nhap).replace('₫', '').trim()}</span></td>
        <td><button class="btn-delete-row" type="button">🗑️</button></td>
    `;

    document.getElementById('selectedProductsBody').appendChild(newRow);
    setupProductRowEvents(newRow);
    updateSummary();
    
    // Chuyển đến trang cuối để thấy sản phẩm mới
    const totalRows = document.querySelectorAll('#selectedProductsBody .product-row').length;
    currentSelectedPage = Math.ceil(totalRows / selectedPerPage);
    renderSelectedProductsTable();
    
    // Animation cho dòng mới
    newRow.style.animation = 'highlightNew 1s ease';
}

// Cập nhật hàm xóa dòng
function setupProductRowEvents(row) {
    // ... code hiện tại ...

    deleteBtn.addEventListener('click', () => {
        const allRows = document.querySelectorAll('#selectedProductsBody .product-row');
        if (allRows.length > 1) {
            row.remove();
            updateSummary();
            renderSelectedProductsTable();
        } else {
            // Nếu chỉ còn 1 dòng, clear dữ liệu thay vì xóa
            row.querySelector('.product-code').value = '';
            row.querySelector('.product-id').value = '';
            row.querySelector('.product-name').value = '';
            row.querySelector('.product-qty').value = '1';
            row.querySelector('.product-price').value = '0';
            row.querySelector('.product-total').textContent = '0';
            updateSummary();
            showToast('Không thể xóa dòng cuối cùng', 'warning');
        }
    });
}

// Cập nhật hàm switchToForm
function switchToForm() {
    document.getElementById('importListPage').style.display = 'none';
    document.getElementById('importFormPage').style.display = 'block';
    document.getElementById('importDetailPage').style.display = 'none';

    // Reset form
    document.getElementById('warehouseSelect').value = '';
    document.getElementById('supplierSelect').value = '';
    document.getElementById('notes').value = '';

    // Reset products
    const tbody = document.getElementById('selectedProductsBody');
    tbody.innerHTML = `
        <tr class="product-row" data-row-id="1">
            <td>
                <input type="text" class="product-code" placeholder="Nhập mã SP" style="width: 100%;">
                <input type="hidden" class="product-id">
            </td>
            <td><input type="text" class="product-name" placeholder="Tên sản phẩm" style="width: 100%;" readonly></td>
            <td><input type="number" class="product-qty" placeholder="0" value="1" min="1" style="width: 100%;"></td>
            <td><input type="number" class="product-price" placeholder="0" value="0" min="0" style="width: 100%;"></td>
            <td><span class="product-total">0</span></td>
            <td><button class="btn-delete-row" type="button">🗑️</button></td>
        </tr>
    `;

    // Setup events cho dòng mới
    const firstRow = document.querySelector('#selectedProductsBody .product-row');
    if (firstRow) {
        setupProductRowEvents(firstRow);
    }
    
    currentSelectedPage = 1;
    renderSelectedProductsTable();
    updateSummary();
    loadProductListForChoose();
}

// Thêm event listeners cho phân trang
document.getElementById('selectedPrevBtn').addEventListener('click', () => {
    if (currentSelectedPage > 1) {
        currentSelectedPage--;
        renderSelectedProductsTable();
    }
});

document.getElementById('selectedNextBtn').addEventListener('click', () => {
    const totalRows = document.querySelectorAll('#selectedProductsBody .product-row').length;
    const totalPages = Math.ceil(totalRows / selectedPerPage);
    if (currentSelectedPage < totalPages) {
        currentSelectedPage++;
        renderSelectedProductsTable();
    }
});
    // ==================== API CALLS ====================
    async function loadImportList() {
      try {
        const response = await fetch('../actions/QuanLyPhieuNhap/lay_danh_sach.php');
        const result = await response.json();

        if (result.success) {
          importList = result.data;
          renderImportList();
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error loading import list:', error);
        showToast('Lỗi tải danh sách phiếu nhập', 'error');
      }
    }

    async function loadSuppliers() {
      try {
        const response = await fetch('../actions/QuanLyPhieuNhap/lay_danh_sach_nha_cung_cap.php');
        const result = await response.json();

        if (result.success) {
          suppliers = result.data;
          renderSupplierOptions();
        }
      } catch (error) {
        console.error('Error loading suppliers:', error);
      }
    }

    // SỬA LẠI hàm loadWarehouses
    async function loadWarehouses() {
      try {
        // Sửa đường dẫn API - cần tạo file lay_danh_sach_kho.php riêng
        const response = await fetch('../actions/QuanLyPhieuNhap/lay_danh_sach_kho.php');
        const result = await response.json();

        if (result.success) {
          warehouses = result.data;
          renderWarehouseOptions();
        } else {
          console.error('Không thể tải danh sách kho:', result.message);
        }
      } catch (error) {
        console.error('Error loading warehouses:', error);
        showToast('Lỗi tải danh sách kho', 'error');
      }
    }

    async function loadProducts(search = '') {
      try {
        let url = '../actions/QuanLyPhieuNhap/lay_danh_sach_hang_hoa.php';
        if (search) {
          url += `?search=${encodeURIComponent(search)}`;
        }

        const response = await fetch(url);
        const result = await response.json();

        if (result.success) {
          products = result.data;
        }
      } catch (error) {
        console.error('Error loading products:', error);
      }
    }

    async function loadImportDetail(id) {
      try {
        const response = await fetch(`../actions/QuanLyPhieuNhap/chi_tiet_phieu_nhap.php?ma_phieu_nhap=${id}`);
        const result = await response.json();

        if (result.success) {
          renderImportDetail(result.data);
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error loading import detail:', error);
        showToast('Lỗi tải chi tiết phiếu nhập', 'error');
      }
    }

    async function deleteImport(id) {
      const formData = new FormData();
      formData.append('ma_phieu_nhap', id);

      try {
        const response = await fetch('../actions/QuanLyPhieuNhap/xoa_phieu_nhap.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          showToast(result.message, 'success');
          loadImportList();
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error deleting import:', error);
        showToast('Lỗi xóa phiếu nhập', 'error');
      }
    }

    async function updateImportStatus(id, status) {
      const formData = new FormData();
      formData.append('ma_phieu_nhap', id);
      formData.append('trang_thai', status);

      try {
        const response = await fetch('../actions/QuanLyPhieuNhap/cap_nhat_trang_thai.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          showToast(result.message, 'success');
          loadImportList();
          switchToList();
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error updating status:', error);
        showToast('Lỗi cập nhật trạng thái', 'error');
      }
    }

    // Sửa hàm saveImport - bỏ comment
async function saveImport(status) {
    // status = 0: Lưu nháp
    // status = 1: Gửi duyệt (chờ duyệt)
    
    // Validate
    const warehouseId = document.getElementById('warehouseSelect').value;
    const supplierId = document.getElementById('supplierSelect').value;
    const notes = document.getElementById('notes').value;

    if (!warehouseId) {
        showToast('Vui lòng chọn kho nhập', 'warning');
        return;
    }
    if (!supplierId) {
        showToast('Vui lòng chọn nhà cung cấp', 'warning');
        return;
    }

    // Lấy danh sách sản phẩm
    const rows = document.querySelectorAll('#selectedProductsBody .product-row');
    const products = [];
    let hasValidProduct = false;

    rows.forEach(row => {
        const productId = row.querySelector('.product-id').value;
        const productCode = row.querySelector('.product-code').value;
        const productName = row.querySelector('.product-name').value;
        const quantity = parseInt(row.querySelector('.product-qty').value) || 0;
        const price = parseFloat(row.querySelector('.product-price').value) || 0;

        if (productCode && quantity > 0 && price > 0) {
            hasValidProduct = true;
            products.push({
                ma_hang_hoa: productId || 0,
                ma_san_pham: productCode,
                ten_hang_hoa: productName,
                so_luong: quantity,
                gia_nhap: price
            });
        }
    });

    if (!hasValidProduct) {
        showToast('Vui lòng thêm ít nhất một sản phẩm hợp lệ', 'warning');
        return;
    }

    // Gửi request
    const formData = new FormData();
    formData.append('ma_kho', warehouseId);
    formData.append('ma_nha_cung_cap', supplierId);
    formData.append('ghi_chu', notes);
    formData.append('trang_thai', status); // status = 0 hoặc 1
    formData.append('san_phams', JSON.stringify(products));

    try {
        const response = await fetch('../actions/QuanLyPhieuNhap/them_phieu_nhap.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            showToast(result.message, 'success');
            switchToList();
            loadImportList();
        } else {
            showToast(result.message, 'error');
        }
    } catch (error) {
        console.error('Error saving import:', error);
        showToast('Lỗi lưu phiếu nhập', 'error');
    }
}

    // ==================== RENDER FUNCTIONS ====================
    function renderImportList() {
      const tbody = document.getElementById('importsTableBody');

      if (importList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px;">Không có dữ liệu</td></tr>';
        return;
      }

      tbody.innerHTML = importList.map(item => `
                <tr data-id="${item.ma_phieu_nhap}">
                    <td><span class="import-id">${item.ma_phieu}</span></td>
                    <td>${formatDate(item.ngay_tao)}</td>
                    <td>${item.ten_nha_cung_cap}</td>
                    <td>${item.ten_kho}</td>
                    <td><strong>${item.so_mat_hang}</strong></td>
                    <td><strong>${item.tong_so_luong}</strong></td>
                    <td><strong>${formatCurrency(item.tong_tien)}</strong></td>
                    <td>${getStatusBadge(item.trang_thai)}</td>
                    <td>${item.nguoi_tao}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action-view" title="Xem chi tiết" onclick="viewImportDetail(${item.ma_phieu_nhap})"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg></button>
                            ${item.trang_thai === 0 ? `
                                <button class="btn-action-edit" title="Sửa" onclick="editImport(${item.ma_phieu_nhap})">✏️</button>
                                <button class="btn-action-delete" title="Xóa" onclick="confirmDelete(${item.ma_phieu_nhap})">🗑️</button>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `).join('');
    }

    function renderSupplierOptions() {
      const selects = ['supplierFilter', 'supplierSelect'];

      selects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (!select) return;

        const currentValue = select.value;
        const options = suppliers.map(s =>
          `<option value="${s.ma_nha_cung_cap}" ${s.ma_nha_cung_cap == currentValue ? 'selected' : ''}>${s.ten_nha_cung_cap}</option>`
        ).join('');

        // Giữ lại option đầu tiên
        select.innerHTML = selectId === 'supplierFilter'
          ? `<option value="">Tất cả nhà cung cấp</option>${options}`
          : `<option value="">Chọn nhà cung cấp</option>${options}`;
      });
    }

    function renderWarehouseOptions() {
      const selects = ['warehouseFilter', 'warehouseSelect'];

      selects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (!select) return;

        const currentValue = select.value;
        const options = warehouses.map(w =>
          `<option value="${w.ma_kho}" ${w.ma_kho == currentValue ? 'selected' : ''}>${w.ten_kho}</option>`
        ).join('');

        select.innerHTML = selectId === 'warehouseFilter'
          ? `<option value="">Tất cả kho</option>${options}`
          : `<option value="">Chọn kho</option>${options}`;
      });
    }

    function renderImportDetail(data) {
      document.getElementById('detailCode').textContent = data.ma_phieu;
      document.getElementById('detailDate').textContent = formatDate(data.ngay_tao);
      document.getElementById('detailWarehouse').textContent = data.ten_kho;
      document.getElementById('detailSupplier').textContent = data.ten_nha_cung_cap;
      document.getElementById('detailCreator').textContent = data.nguoi_tao;
      document.getElementById('detailApprover').textContent = data.nguoi_duyet || '-';
      document.getElementById('detailApproveDate').textContent = data.ngay_duyet ? formatDate(data.ngay_duyet) : '-';
      document.getElementById('detailNote').textContent = data.ghi_chu || '-';
      document.getElementById('detailStatus').innerHTML = getStatusBadge(data.trang_thai);

      // Hiển thị sản phẩm
      const tbody = document.getElementById('detailProductsBody');
      if (data.san_phams && data.san_phams.length > 0) {
        tbody.innerHTML = data.san_phams.map(sp => `
                    <tr>
                        <td>${sp.ma_san_pham}</td>
                        <td>${sp.ten_hang_hoa}</td>
                        <td>${sp.so_luong}</td>
                        <td>${formatCurrency(sp.gia_nhap)}</td>
                        <td>${formatCurrency(sp.thanh_tien)}</td>
                    </tr>
                `).join('');

        document.getElementById('detailTotalQty').textContent = data.tong_so_luong;
        document.getElementById('detailTotalAmount').textContent = formatCurrency(data.tong_tien);
      } else {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Không có sản phẩm</td></tr>';
      }

      // Hiển thị nút duyệt nếu phiếu đang chờ duyệt
      const approvalDiv = document.getElementById('approvalButtons');
      if (data.trang_thai === 0) {
        approvalDiv.style.display = 'flex';
      } else {
        approvalDiv.style.display = 'none';
      }

      currentDetailId = data.ma_phieu_nhap;
    }

    // ==================== PRODUCT ROW FUNCTIONS ====================
    function addProductRow() {
      const newRow = document.createElement('tr');
      newRow.className = 'product-row';
      newRow.setAttribute('data-row-id', Date.now());
      newRow.innerHTML = `
        <td>
            <input type="text" class="product-code" placeholder="Nhập mã SP" style="width: 100%;">
            <input type="hidden" class="product-id">
        </td>
        <td><input type="text" class="product-name" placeholder="Tên sản phẩm" style="width: 100%;" readonly></td>
        <td><input type="number" class="product-qty" placeholder="0" value="1" min="1" style="width: 100%;"></td>
        <td><input type="number" class="product-price" placeholder="0" value="0" min="0" style="width: 100%;"></td>
        <td><span class="product-total">0</span></td>
        <td><button class="btn-delete-row" type="button">🗑️</button></td>
    `;

      document.getElementById('selectedProductsBody').appendChild(newRow);
      setupProductRowEvents(newRow);
    }

    function setupProductRowEvents(row) {
      const codeInput = row.querySelector('.product-code');
      const qtyInput = row.querySelector('.product-qty');
      const priceInput = row.querySelector('.product-price');
      const deleteBtn = row.querySelector('.btn-delete-row');

      // Tìm sản phẩm khi nhập mã
      let searchTimeout;
      codeInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          const code = codeInput.value.trim();
          if (code) {
            findProductByCode(code, row);
          } else {
            row.querySelector('.product-name').value = '';
            row.querySelector('.product-id').value = '';
          }
        }, 500);
      });

      // Tính tổng khi thay đổi số lượng/giá
      qtyInput.addEventListener('input', () => calculateRowTotal(row));
      priceInput.addEventListener('input', () => calculateRowTotal(row));

      // Xóa dòng
      deleteBtn.addEventListener('click', () => {
        if (document.querySelectorAll('.product-row').length > 1) {
          row.remove();
          updateSummary();
        } else {
          showToast('Phải có ít nhất một sản phẩm', 'warning');
        }
      });
    }

    function findProductByCode(code, row) {
      const product = products.find(p =>
        p.ma_san_pham.toLowerCase().includes(code.toLowerCase()) ||
        p.ten_hang_hoa.toLowerCase().includes(code.toLowerCase())
      );

      if (product) {
        row.querySelector('.product-id').value = product.ma_hang_hoa;
        row.querySelector('.product-code').value = product.ma_san_pham;
        row.querySelector('.product-name').value = product.ten_hang_hoa;
        row.querySelector('.product-price').value = product.gia_nhap;
        calculateRowTotal(row);
      }
    }

    function calculateRowTotal(row) {
      const qty = parseFloat(row.querySelector('.product-qty').value) || 0;
      const price = parseFloat(row.querySelector('.product-price').value) || 0;
      const total = qty * price;
      row.querySelector('.product-total').textContent = formatCurrency(total).replace('₫', '').trim();
      updateSummary();
    }

    function updateSummary() {
      let totalItems = 0;
      let totalQty = 0;
      let totalAmount = 0;

      document.querySelectorAll('#selectedProductsBody .product-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.product-qty').value) || 0;
        const price = parseFloat(row.querySelector('.product-price').value) || 0;

        // Chỉ tính nếu có mã sản phẩm
        const productCode = row.querySelector('.product-code').value;
        if (productCode && qty > 0 && price > 0) {
          totalItems++;
          totalQty += qty;
          totalAmount += qty * price;
        }
      });

      document.getElementById('totalItems').textContent = totalItems;
      document.getElementById('totalQuantity').textContent = totalQty;
      document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
    }

    // ==================== PAGE NAVIGATION ====================
    function switchToList() {
      document.getElementById('importListPage').style.display = 'block';
      document.getElementById('importFormPage').style.display = 'none';
      document.getElementById('importDetailPage').style.display = 'none';
      loadImportList();
    }

    function switchToForm() {
      document.getElementById('importListPage').style.display = 'none';
      document.getElementById('importFormPage').style.display = 'block';
      document.getElementById('importDetailPage').style.display = 'none';

      // Reset form
      document.getElementById('warehouseSelect').value = '';
      document.getElementById('supplierSelect').value = '';
      document.getElementById('notes').value = '';

      // Reset products - sửa ID thành selectedProductsBody
      const tbody = document.getElementById('selectedProductsBody');
      tbody.innerHTML = `
        <tr class="product-row" data-row-id="1">
            <td>
                <input type="text" class="product-code" placeholder="Nhập mã SP" style="width: 100%;">
                <input type="hidden" class="product-id">
            </td>
            <td><input type="text" class="product-name" placeholder="Tên sản phẩm" style="width: 100%;" readonly></td>
            <td><input type="number" class="product-qty" placeholder="0" value="1" min="1" style="width: 100%;"></td>
            <td><input type="number" class="product-price" placeholder="0" value="0" min="0" style="width: 100%;"></td>
            <td><span class="product-total">0</span></td>
            <td><button class="btn-delete-row" type="button">🗑️</button></td>
        </tr>
    `;

      // Setup events cho dòng mới
      setupProductRowEvents(document.querySelector('#selectedProductsBody .product-row'));
      updateSummary();

      // Load lại danh sách sản phẩm
      loadProductListForChoose();
    }
    function switchToDetail() {
      document.getElementById('importListPage').style.display = 'none';
      document.getElementById('importFormPage').style.display = 'none';
      document.getElementById('importDetailPage').style.display = 'block';
    }

    // ==================== EVENT HANDLERS ====================
    function viewImportDetail(id) {
      switchToDetail();
      loadImportDetail(id);
    }

    function editImport(id) {
      showToast('Tính năng đang phát triển', 'info');
    }

    function confirmDelete(id) {
      if (confirm('Bạn chắc chắn muốn xóa phiếu nhập này?')) {
        deleteImport(id);
      }
    }

    // Filter functions
    function applyFilters() {
      const search = document.getElementById('searchInput').value.toLowerCase();
      const supplier = document.getElementById('supplierFilter').value;
      const warehouse = document.getElementById('warehouseFilter').value;
      const status = document.getElementById('statusFilter').value;
      const dateFrom = document.getElementById('dateFrom').value;
      const dateTo = document.getElementById('dateTo').value;

      const filtered = importList.filter(item => {
        // Search
        if (search && !item.ma_phieu.toLowerCase().includes(search)) {
          return false;
        }
        // Supplier
        if (supplier && item.ma_nha_cung_cap != supplier) {
          return false;
        }
        // Warehouse
        if (warehouse && item.ma_kho != warehouse) {
          return false;
        }
        // Status
        if (status !== '' && item.trang_thai != status) {
          return false;
        }
        // Date
        if (dateFrom && new Date(item.ngay_tao) < new Date(dateFrom)) {
          return false;
        }
        if (dateTo) {
          const toDate = new Date(dateTo);
          toDate.setHours(23, 59, 59);
          if (new Date(item.ngay_tao) > toDate) {
            return false;
          }
        }
        return true;
      });

      // Hiển thị kết quả lọc
      const tbody = document.getElementById('importsTableBody');
      if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px;">Không tìm thấy kết quả</td></tr>';
      } else {
        tbody.innerHTML = filtered.map(item => `
                    <tr data-id="${item.ma_phieu_nhap}">
                        <td><span class="import-id">${item.ma_phieu}</span></td>
                        <td>${formatDate(item.ngay_tao)}</td>
                        <td>${item.ten_nha_cung_cap}</td>
                        <td>${item.ten_kho}</td>
                        <td><strong>${item.so_mat_hang}</strong></td>
                        <td><strong>${item.tong_so_luong}</strong></td>
                        <td><strong>${formatCurrency(item.tong_tien)}</strong></td>
                        <td>${getStatusBadge(item.trang_thai)}</td>
                        <td>${item.nguoi_tao}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action-view" title="Xem chi tiết" onclick="viewImportDetail(${item.ma_phieu_nhap})">👁️</button>
                                ${item.trang_thai === 0 ? `
                                    <button class="btn-action-edit" title="Sửa" onclick="editImport(${item.ma_phieu_nhap})">✏️</button>
                                    <button class="btn-action-delete" title="Xóa" onclick="confirmDelete(${item.ma_phieu_nhap})">🗑️</button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `).join('');
      }
    }
    // ==================== XỬ LÝ CLICK VÀO BẢNG SẢN PHẨM ====================
    // Hàm load danh sách sản phẩm cho bảng products-table-choose
    async function loadProductListForChoose(search = '') {
      try {
        let url = '../actions/QuanLyPhieuNhap/lay_danh_sach_hang_hoa.php';
        if (search) {
          url += `?search=${encodeURIComponent(search)}`;
        }

        const response = await fetch(url);
        const result = await response.json();

        if (result.success) {
          renderProductChooseTable(result.data);
        } else {
          showToast(result.message, 'error');
        }
      } catch (error) {
        console.error('Error loading products:', error);
        showToast('Lỗi tải danh sách sản phẩm', 'error');
      }
    }

    // Render bảng sản phẩm để chọn (không có hình ảnh và giá bán)
    // Render bảng sản phẩm để chọn
    function renderProductChooseTable(products) {
      const tbody = document.getElementById('productChooseBody'); // Đổi ID ở đây

      if (products.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px;">Không có sản phẩm nào</td></tr>';
        return;
      }

      tbody.innerHTML = products.map(product => {
        const stockClass = getStockClass(product.ton_kho);

        return `
        <tr class="product-choose-row" 
            data-id="${product.ma_hang_hoa}"
            data-code="${product.ma_san_pham}"
            data-name="${product.ten_hang_hoa}"
            data-price="${product.gia_nhap}"
            onclick="selectProductFromTable(this)">
            <td><strong>${product.ma_san_pham}</strong></td>
            <td>${product.ten_hang_hoa}</td>
            <td>${product.ten_danh_muc}</td>
            <td>${product.ten_kho}</td>
            <td><span class="stock-badge ${stockClass}">${product.ton_kho}</span></td>
            <td>${formatCurrency(product.gia_nhap)}</td>
            <td>
                <span class="status-badge ${product.trang_thai == 1 ? 'approved' : 'rejected'}">
                    ${product.trang_thai == 1 ? 'Đang bán' : 'Ngừng bán'}
                </span>
            </td>
            <td>
                <button class="btn-action-add" onclick="addToImportList(event, this)" 
                        title="Thêm vào phiếu nhập">
                    <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </td>
        </tr>
    `}).join('');
    }

    // Hàm xác định class cho tồn kho
    function getStockClass(quantity) {
      if (quantity <= 0) return 'stock-low';
      if (quantity < 10) return 'stock-low';
      if (quantity < 50) return 'stock-medium';
      return 'stock-high';
    }

    // Hàm xử lý khi click vào dòng sản phẩm
    function selectProductFromTable(row) {
      const productId = row.dataset.id;
      const productCode = row.dataset.code;
      const productName = row.dataset.name;
      const productPrice = row.dataset.price;

      // Thêm sản phẩm vào bảng nhập
      addProductToImportTable({
        ma_hang_hoa: productId,
        ma_san_pham: productCode,
        ten_hang_hoa: productName,
        gia_nhap: parseFloat(productPrice)
      });

      // Highlight dòng được chọn
      document.querySelectorAll('.product-choose-row').forEach(r => {
        r.classList.remove('selected-row');
      });
      row.classList.add('selected-row');

      showToast(`Đã thêm ${productName} vào phiếu nhập`, 'success');
    }

    // Hàm xử lý khi click vào nút thêm
    function addToImportList(event, button) {
      event.stopPropagation(); // Ngăn không cho sự kiện click lan lên dòng
      const row = button.closest('tr');
      selectProductFromTable(row);
    }

    // Hàm thêm sản phẩm vào bảng nhập
    function addProductToImportTable(product) {
      // Kiểm tra sản phẩm đã có trong bảng nhập chưa
      const existingRows = document.querySelectorAll('#selectedProductsBody .product-row');
      for (let row of existingRows) {
        const productId = row.querySelector('.product-id').value;
        if (productId == product.ma_hang_hoa) {
          // Nếu đã có, tăng số lượng lên 1
          const qtyInput = row.querySelector('.product-qty');
          qtyInput.value = parseInt(qtyInput.value) + 1;
          calculateRowTotal(row);
          updateSummary();

          // Highlight dòng trong bảng nhập
          row.style.backgroundColor = '#f0f9ff';
          setTimeout(() => {
            row.style.backgroundColor = '';
          }, 500);

          return;
        }
      }

      // Nếu chưa có, thêm dòng mới
      const newRow = document.createElement('tr');
      newRow.className = 'product-row';
      newRow.setAttribute('data-row-id', Date.now());
      newRow.innerHTML = `
        <td>
            <input type="text" class="product-code" value="${product.ma_san_pham}" style="width: 100%;" readonly>
            <input type="hidden" class="product-id" value="${product.ma_hang_hoa}">
        </td>
        <td>
            <input type="text" class="product-name" value="${product.ten_hang_hoa}" style="width: 100%;" readonly>
        </td>
        <td><input type="number" class="product-qty" placeholder="0" value="1" min="1" style="width: 100%;"></td>
        <td><input type="number" class="product-price" placeholder="0" value="${product.gia_nhap}" min="0" style="width: 100%;"></td>
        <td><span class="product-total">${formatCurrency(product.gia_nhap).replace('₫', '').trim()}</span></td>
        <td><button class="btn-delete-row" type="button">🗑️</button></td>
    `;

      document.getElementById('selectedProductsBody').appendChild(newRow);
      setupProductRowEvents(newRow);
      updateSummary();

      // Animation cho dòng mới
      newRow.style.animation = 'highlightNew 1s ease';
    }

    
    // Thêm style cho các hiệu ứng
    const style = document.createElement('style');
    style.textContent = `
    .product-choose-row {
        cursor: pointer;
        transition: all 0.2s;
    }
    .product-choose-row:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    .product-choose-row.selected-row {
        background-color: rgba(59, 130, 246, 0.1);
        border-left: 3px solid var(--accent-blue);
    }
    .btn-action-add {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        background: var(--success-green);
        color: white;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-action-add:hover {
        background: #0d9488;
        transform: scale(1.05);
    }
    .stock-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    .stock-low {
        background: #fee2e2;
        color: #dc2626;
    }
    .stock-medium {
        background: #fef3c7;
        color: #d97706;
    }
    .stock-high {
        background: #d1fae5;
        color: #059669;
    }
    @keyframes highlightNew {
        0% { background-color: #f0f9ff; }
        100% { background-color: transparent; }
    }
`;
    document.head.appendChild(style);
    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
      // Load initial data
      loadImportList();
      loadSuppliers();
      loadWarehouses();
      loadProducts();
      loadProductListForChoose();

      // Setup event listeners
      document.getElementById('addImportBtn').addEventListener('click', () => {
        switchToForm();
        loadProductListForChoose(); // Load lại danh sách sản phẩm
      });
      document.getElementById('formCancelBtn').addEventListener('click', switchToList);
      document.getElementById('backToListBtn').addEventListener('click', switchToList);

      document.getElementById('formSaveDraftBtn').addEventListener('click', () => saveImport(0));
      document.getElementById('formSubmitBtn').addEventListener('click', () => saveImport(1));

      document.getElementById('addProductRowBtn').addEventListener('click', addProductRow);
      document.getElementById('refreshBtn').addEventListener('click', loadImportList);

      document.getElementById('approveBtn').addEventListener('click', () => {
        if (currentDetailId) {
          updateImportStatus(currentDetailId, 1);
        }
      });

      document.getElementById('rejectBtn').addEventListener('click', () => {
        if (currentDetailId) {
          updateImportStatus(currentDetailId, 2);
        }
      });

      // Filter events
      document.getElementById('searchInput').addEventListener('input', applyFilters);
      document.getElementById('supplierFilter').addEventListener('change', applyFilters);
      document.getElementById('warehouseFilter').addEventListener('change', applyFilters);
      document.getElementById('statusFilter').addEventListener('change', applyFilters);
      document.getElementById('dateFrom').addEventListener('change', applyFilters);
      document.getElementById('dateTo').addEventListener('change', applyFilters);

      // Tìm kiếm sản phẩm
      let searchTimeout;
      document.getElementById('searchProductInput').addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          const searchTerm = this.value.trim();
          loadProductListForChoose(searchTerm);
        }, 500);
      });

      document.getElementById('searchProductBtn').addEventListener('click', function () {
        const searchTerm = document.getElementById('searchProductInput').value.trim();
        loadProductListForChoose(searchTerm);
      });
      // Setup initial product row
      setupProductRowEvents(document.querySelector('.product-row'));
    });

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
//////////////////////////////// side bar toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
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
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeUserDropdown();
        if (isMobile) {
          closeMobileSidebar();
        }
      }
    });

  </script>
  <script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'9d77c0ca66bde2fd',t:'MTc3MjY5OTM2OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script>
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