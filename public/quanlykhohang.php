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
  <style>
    /* ========================================
       LAYOUT.CSS - WMS Admin Layout Styles
       ======================================== */
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    :root {
      --primary-navy: #1e3a5f;
      --primary-navy-dark: #152a45;
      --primary-navy-light: #2d4a6f;
      --accent-blue: #3b82f6;
      --bg-light: #f8fafc;
      --bg-white: #ffffff;
      --text-primary: #1e293b;
      --text-secondary: #64748b;
      --text-muted: #94a3b8;
      --border-color: #e2e8f0;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
      --radius: 8px;
      --sidebar-width: 260px;
      --sidebar-collapsed-width: 72px;
      --topbar-height: 64px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    html, body {
      height: 100%;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--bg-light);
      color: var(--text-primary);
      overflow: hidden;
    }
    
    /* App Container */
    .wms-app {
      display: flex;
      height: 100%;
      width: 100%;
      overflow: hidden;
    }
    
    /* ========================================
       SIDEBAR STYLES
       ======================================== */
    .wms-sidebar {
      width: var(--sidebar-width);
      height: 100%;
      background: linear-gradient(180deg, var(--primary-navy) 0%, var(--primary-navy-dark) 100%);
      display: flex;
      flex-direction: column;
      transition: var(--transition);
      position: fixed;
      left: 0;
      top: 0;
      z-index: 100;
      overflow: hidden;
    }
    
    .wms-sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }
    
    /* Sidebar Header / Logo */
    .sidebar-header {
      padding: 20px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      gap: 12px;
      min-height: 80px;
    }
    
    .sidebar-logo {
      width: 40px;
      height: 40px;
      background: var(--accent-blue);
      border-radius: var(--radius);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    
    .sidebar-logo svg {
      width: 24px;
      height: 24px;
      color: white;
    }
    
    .sidebar-brand {
      overflow: hidden;
      transition: var(--transition);
      white-space: nowrap;
    }
    
    .wms-sidebar.collapsed .sidebar-brand {
      opacity: 0;
      width: 0;
    }
    
    .sidebar-brand h1 {
      font-size: 18px;
      font-weight: 700;
      color: white;
      letter-spacing: -0.025em;
    }
    
    .sidebar-brand p {
      font-size: 11px;
      color: rgba(255, 255, 255, 0.6);
      margin-top: 2px;
    }
    
    /* Sidebar Navigation */
    .sidebar-nav {
      flex: 1;
      padding: 16px 12px;
      overflow-y: auto;
      overflow-x: hidden;
    }
    
    .sidebar-nav::-webkit-scrollbar {
      width: 4px;
    }
    
    .sidebar-nav::-webkit-scrollbar-track {
      background: transparent;
    }
    
    .sidebar-nav::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 4px;
    }
    
    .nav-section {
      margin-bottom: 24px;
    }
    
    .nav-section-title {
      font-size: 11px;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.4);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 0 12px;
      margin-bottom: 8px;
      white-space: nowrap;
      overflow: hidden;
      transition: var(--transition);
    }
    
    .wms-sidebar.collapsed .nav-section-title {
      opacity: 0;
    }
    
    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      border-radius: 6px;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: var(--transition);
      margin-bottom: 4px;
      position: relative;
      cursor: pointer;
      white-space: nowrap;
    }
    
    .nav-item:hover {
      background: rgba(255, 255, 255, 0.08);
      color: white;
    }
    
    .nav-item.active {
      background: rgba(59, 130, 246, 0.2);
      color: white;
    }
    
    .nav-item.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 3px;
      height: 24px;
      background: var(--accent-blue);
      border-radius: 0 3px 3px 0;
    }
    
    .nav-item-icon {
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    
    .nav-item-icon svg {
      width: 20px;
      height: 20px;
    }
    
    .nav-item-text {
      font-size: 14px;
      font-weight: 500;
      transition: var(--transition);
      overflow: hidden;
    }
    
    .wms-sidebar.collapsed .nav-item-text {
      opacity: 0;
      width: 0;
    }
    
    /* Sidebar Footer */
    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .sidebar-user {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px;
      border-radius: 6px;
      transition: var(--transition);
      cursor: pointer;
    }
    
    .sidebar-user:hover {
      background: rgba(255, 255, 255, 0.08);
    }
    
    .sidebar-user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--accent-blue), #60a5fa);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 14px;
      flex-shrink: 0;
    }
    
    .sidebar-user-info {
      overflow: hidden;
      transition: var(--transition);
    }
    
    .wms-sidebar.collapsed .sidebar-user-info {
      opacity: 0;
      width: 0;
    }
    
    .sidebar-user-name {
      font-size: 14px;
      font-weight: 600;
      color: white;
      white-space: nowrap;
    }
    
    .sidebar-user-role {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.5);
      white-space: nowrap;
    }
    
    /* ========================================
       MAIN CONTENT AREA
       ======================================== */
    .wms-main {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100%;
      margin-left: var(--sidebar-width);
      transition: var(--transition);
      overflow: hidden;
    }
    
    .wms-sidebar.collapsed ~ .wms-main {
      margin-left: var(--sidebar-collapsed-width);
    }
    
    /* ========================================
       TOPBAR STYLES
       ======================================== */
    .wms-topbar {
      height: var(--topbar-height);
      background: var(--bg-white);
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
      flex-shrink: 0;
      box-shadow: var(--shadow-sm);
    }
    
    .topbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    
    .sidebar-toggle {
      width: 40px;
      height: 40px;
      border: none;
      background: var(--bg-light);
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      color: var(--text-secondary);
    }
    
    .sidebar-toggle:hover {
      background: var(--border-color);
      color: var(--text-primary);
    }
    
    .sidebar-toggle svg {
      width: 20px;
      height: 20px;
    }
    
    /* Breadcrumb */
    .breadcrumb {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
    }
    
    .breadcrumb-item {
      color: var(--text-muted);
      text-decoration: none;
      transition: var(--transition);
    }
    
    .breadcrumb-item:hover {
      color: var(--text-primary);
    }
    
    .breadcrumb-item.active {
      color: var(--text-primary);
      font-weight: 500;
    }
    
    .breadcrumb-separator {
      color: var(--text-muted);
    }
    
    /* Topbar Right */
    .topbar-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    /* Search Input */
    .topbar-search {
      position: relative;
    }
    
    .topbar-search input {
      width: 220px;
      height: 40px;
      padding: 0 16px 0 40px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 14px;
      background: var(--bg-light);
      transition: var(--transition);
      font-family: inherit;
    }
    
    .topbar-search input:focus {
      outline: none;
      border-color: var(--accent-blue);
      background: var(--bg-white);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .topbar-search input::placeholder {
      color: var(--text-muted);
    }
    
    .topbar-search-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      width: 18px;
      height: 18px;
    }
    
    /* Notification Button */
    .topbar-notification {
      position: relative;
      width: 40px;
      height: 40px;
      border: none;
      background: transparent;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      color: var(--text-secondary);
    }
    
    .topbar-notification:hover {
      background: var(--bg-light);
      color: var(--text-primary);
    }
    
    .topbar-notification svg {
      width: 22px;
      height: 22px;
    }
    
    .notification-badge {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 18px;
      height: 18px;
      background: #ef4444;
      border-radius: 50%;
      font-size: 11px;
      font-weight: 600;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid var(--bg-white);
    }
    
    /* User Dropdown */
    .topbar-user {
      position: relative;
    }
    
    .topbar-user-trigger {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 6px 12px 6px 6px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      background: var(--bg-white);
      cursor: pointer;
      transition: var(--transition);
    }
    
    .topbar-user-trigger:hover {
      background: var(--bg-light);
      border-color: var(--text-muted);
    }
    
    .topbar-user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-navy), var(--accent-blue));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 13px;
    }
    
    .topbar-user-name {
      font-size: 14px;
      font-weight: 500;
      color: var(--text-primary);
    }
    
    .topbar-user-arrow {
      width: 16px;
      height: 16px;
      color: var(--text-muted);
      transition: var(--transition);
    }
    
    .topbar-user.open .topbar-user-arrow {
      transform: rotate(180deg);
    }
    
    /* User Dropdown Menu */
    .user-dropdown {
      position: absolute;
      top: calc(100% + 8px);
      right: 0;
      width: 200px;
      background: var(--bg-white);
      border: 1px solid var(--border-color);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-8px);
      transition: var(--transition);
      z-index: 200;
      overflow: hidden;
    }
    
    .topbar-user.open .user-dropdown {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .user-dropdown-header {
      padding: 12px 16px;
      border-bottom: 1px solid var(--border-color);
      background: var(--bg-light);
    }
    
    .user-dropdown-name {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
    }
    
    .user-dropdown-email {
      font-size: 12px;
      color: var(--text-muted);
      margin-top: 2px;
    }
    
    .user-dropdown-menu {
      padding: 8px;
    }
    
    .user-dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 6px;
      color: var(--text-secondary);
      text-decoration: none;
      transition: var(--transition);
      cursor: pointer;
      font-size: 14px;
    }
    
    .user-dropdown-item:hover {
      background: var(--bg-light);
      color: var(--text-primary);
    }
    
    .user-dropdown-item.danger:hover {
      background: #fef2f2;
      color: #ef4444;
    }
    
    .user-dropdown-item svg {
      width: 18px;
      height: 18px;
    }
    
    .user-dropdown-divider {
      height: 1px;
      background: var(--border-color);
      margin: 8px;
    }
    
    /* ========================================
       CONTENT AREA
       ======================================== */
    .wms-content {
      flex: 1;
      padding: 24px;
      overflow-y: auto;
      background: var(--bg-light);
    }
    
    .content-header {
      margin-bottom: 24px;
    }
    
    .page-title {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -0.025em;
    }
    
    .page-subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin-top: 4px;
    }
    
    /* ========================================
       BUTTON STYLES
       ======================================== */
    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 10px 20px;
      background: var(--primary-navy);
      color: white;
      border: none;
      border-radius: var(--radius);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      font-family: inherit;
    }
    
    .btn-primary:hover {
      background: var(--primary-navy-dark);
      box-shadow: var(--shadow-md);
    }
    
    .btn-primary:active {
      transform: scale(0.98);
    }
    
    .btn-secondary {
      padding: 10px 20px;
      background: var(--bg-light);
      color: var(--text-secondary);
      border: 1px solid var(--border-color);
      border-radius: var(--radius);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      font-family: inherit;
    }
    
    .btn-secondary:hover {
      background: var(--border-color);
      color: var(--text-primary);
    }
    
    /* ========================================
       TOOLBAR STYLES
       ======================================== */
    .toolbar {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }
    
    .toolbar-group {
      display: flex;
      align-items: center;
      gap: 12px;
      flex: 1;
      min-width: 300px;
    }
    
    .toolbar-search,
    .toolbar-select {
      padding: 10px 12px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 14px;
      background: var(--bg-white);
      color: var(--text-primary);
      transition: var(--transition);
      font-family: inherit;
      flex: 1;
    }
    
    .toolbar-search:focus,
    .toolbar-select:focus {
      outline: none;
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .toolbar-search::placeholder {
      color: var(--text-muted);
    }
    
    .btn-refresh {
      width: 40px;
      height: 40px;
      border: 1px solid var(--border-color);
      background: var(--bg-white);
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      color: var(--text-secondary);
    }
    
    .btn-refresh:hover {
      background: var(--bg-light);
      color: var(--text-primary);
      border-color: var(--accent-blue);
    }
    
    .btn-refresh svg {
      width: 20px;
      height: 20px;
    }
    
    /* ========================================
       CONTENT CARD
       ======================================== */
    .content-card {
      background: var(--bg-white);
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      overflow: hidden;
    }
    
    .content-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid var(--border-color);
    }
    
    .content-card-title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-primary);
    }
    
    .content-card-body {
      padding: 20px;
    }
    
    /* ========================================
       TABLE STYLES
       ======================================== */
    .warehouses-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .warehouses-table th,
    .warehouses-table td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }
    
    .warehouses-table th {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      background: var(--bg-light);
    }
    
    .warehouses-table td {
      font-size: 14px;
      color: var(--text-primary);
    }
    
    .warehouses-table tbody tr:last-child td {
      border-bottom: none;
    }
    
    .warehouses-table tbody tr:hover td {
      background: rgba(59, 130, 246, 0.02);
    }
    
    .warehouse-id {
      font-weight: 600;
      color: var(--accent-blue);
    }
    
    .warehouse-name {
      font-weight: 600;
      color: var(--text-primary);
    }
    
    /* ========================================
       STATUS BADGE
       ======================================== */
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 6px 12px;
      border-radius: 16px;
      font-size: 12px;
      font-weight: 600;
      white-space: nowrap;
    }
    
    .status-badge.active {
      background: #d1fae5;
      color: #059669;
    }
    
    .status-badge.inactive {
      background: #e5e7eb;
      color: #6b7280;
    }
    
    /* ========================================
       ACTION BUTTONS
       ======================================== */
    .action-buttons {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .btn-action-view,
    .btn-action-edit,
    .btn-action-delete {
      width: 32px;
      height: 32px;
      border: none;
      border-radius: 6px;
      background: var(--bg-light);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
      font-size: 16px;
    }
    
    .btn-action-view:hover {
      background: #dbeafe;
    }
    
    .btn-action-edit:hover {
      background: #fef3c7;
    }
    
    .btn-action-delete:hover {
      background: #fee2e2;
    }
    
    /* ========================================
       PAGINATION
       ======================================== */
    .pagination {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      margin-top: 24px;
      padding: 20px;
      background: var(--bg-white);
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
    }
    
    .pagination-btn {
      padding: 8px 16px;
      border: 1px solid var(--border-color);
      background: var(--bg-white);
      color: var(--text-secondary);
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      font-family: inherit;
    }
    
    .pagination-btn:hover:not(:disabled) {
      background: var(--bg-light);
      color: var(--text-primary);
      border-color: var(--accent-blue);
    }
    
    .pagination-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
    
    .pagination-info {
      font-size: 14px;
      color: var(--text-secondary);
      font-weight: 500;
    }
    
    /* ========================================
       MODAL STYLES
       ======================================== */
    .modal {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 300;
    }
    
    .modal.active {
      display: flex;
    }
    
    .modal-overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(4px);
      z-index: 310;
    }
    
    .modal-content {
      position: relative;
      background: var(--bg-white);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      max-height: 90%;
      overflow-y: auto;
      z-index: 320;
      margin: auto;
      width: 90%;
      max-width: 650px;
    }
    
    .modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px;
      border-bottom: 1px solid var(--border-color);
    }
    
    .modal-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--text-primary);
    }
    
    .modal-close {
      width: 32px;
      height: 32px;
      border: none;
      background: transparent;
      font-size: 24px;
      color: var(--text-muted);
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .modal-close:hover {
      color: var(--text-primary);
      background: var(--bg-light);
      border-radius: 6px;
    }
    
    .modal-body {
      padding: 24px;
    }
    
    .modal-footer {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 12px;
      padding: 20px;
      border-top: 1px solid var(--border-color);
    }
    
    /* ========================================
       FORM STYLES
       ======================================== */
    .warehouse-form {
      display: flex;
      flex-direction: column;
    }
    
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 16px;
    }
    
    .form-row.full {
      grid-template-columns: 1fr;
    }
    
    .form-group {
      display: flex;
      flex-direction: column;
    }
    
    .form-group label {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 6px;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: 10px 12px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 14px;
      background: var(--bg-white);
      color: var(--text-primary);
      transition: var(--transition);
      font-family: inherit;
    }
    
    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: var(--text-muted);
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-group textarea {
      resize: vertical;
      min-height: 70px;
    }
    
    .form-section-label {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-top: 16px;
      margin-bottom: 12px;
      padding-bottom: 8px;
      border-bottom: 1px solid var(--border-color);
    }
    
    /* Status Radio Group */
    .status-radio-group {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-top: 8px;
    }
    
    .radio-label {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      font-size: 14px;
      color: var(--text-primary);
    }
    
    .radio-label input[type="radio"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: var(--accent-blue);
    }
    
    .radio-label input[type="radio"]:focus {
      outline: none;
    }
    
    /* ========================================
       FOOTER
       ======================================== */
    .wms-footer {
      height: 48px;
      background: var(--bg-white);
      border-top: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 24px;
      flex-shrink: 0;
    }
    
    .footer-text {
      font-size: 13px;
      color: var(--text-muted);
      text-align: center;
    }
    
    /* ========================================
       RESPONSIVE STYLES
       ======================================== */
    @media (max-width: 1024px) {
      .toolbar-group {
        min-width: auto;
        flex: 1 1 calc(50% - 6px);
      }
    }
    
    @media (max-width: 768px) {
      .wms-sidebar {
        transform: translateX(-100%);
      }
      
      .wms-sidebar.mobile-open {
        transform: translateX(0);
      }
      
      .wms-main {
        margin-left: 0 !important;
      }
      
      .topbar-search {
        display: none;
      }
      
      .topbar-user-name {
        display: none;
      }
      
      .wms-content {
        padding: 16px;
      }
      
      .toolbar {
        flex-direction: column;
      }
      
      .toolbar-group {
        min-width: auto;
        flex: 1;
        width: 100%;
      }
      
      .warehouses-table th:nth-child(6),
      .warehouses-table td:nth-child(6) {
        display: none;
      }
      
      .warehouses-table th:nth-child(9),
      .warehouses-table td:nth-child(9) {
        display: none;
      }
      
      .modal-content {
        width: 95%;
        max-width: 95%;
      }
      
      .form-row {
        grid-template-columns: 1fr;
      }
      
      .breadcrumb {
        display: none;
      }
    }
    
    /* Mobile Overlay */
    .mobile-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 99;
    }
    
    .mobile-overlay.active {
      display: block;
    }
    
    /* Refresh Animation */
    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full">
  <div class="wms-app">
   <!-- Mobile Overlay -->
   <div class="mobile-overlay" id="mobileOverlay"></div><!-- SIDEBAR -->
   
   
   
   
   
   
   
   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?>
   
   
   
   
   
   
   
   
   
   <!-- MAIN CONTENT WRAPPER -->
   <div class="wms-main">
    <!-- TOPBAR -->
    
    <?php include __DIR__ . "/../views/Layout/header.php"; ?> 
    
    <!-- MAIN CONTENT AREA -->
    <main class="wms-content"><!-- Page Header with Add Button -->
     <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
      <div class="content-header">
       <h1 class="page-title" id="pageTitle">QUẢN LÝ KHO HÀNG</h1>
      </div><button id="addWarehouseBtn" class="btn-primary" style="margin-bottom: 0;">
       <svg style="width: 18px; height: 18px; margin-right: 6px;" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"></line> <line x1="5" y1="12" x2="19" y2="12"></line>
       </svg><span id="addButtonText">Thêm kho mới</span> </button>
     </div><!-- Toolbar - Search & Filters -->
     <div class="content-card" style="margin-bottom: 24px;">
      <div class="content-card-body" style="padding: 16px;">
       <div class="toolbar">
        <!-- Search -->
        <div class="toolbar-group">
         <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên / mã kho..." class="toolbar-search">
        </div><!-- Status Filter -->
        <div class="toolbar-group">
         <select id="statusFilter" class="toolbar-select"> <option value="">Tất cả trạng thái</option> <option value="active">Hoạt động</option> <option value="inactive">Tạm ngưng</option> </select>
        </div><!-- Refresh Button --> <button id="refreshBtn" class="btn-refresh">
         <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="23 4 23 10 17 10"></polyline> <path d="M20.49 15a9 9 0 11-2-8.12"></path>
         </svg></button>
       </div>
      </div>
     </div><!-- Warehouses Table -->
     <div class="content-card">
      <div class="content-card-body" style="padding: 0;">
       <table class="warehouses-table">
        <thead>
         <tr>
          <th>Mã kho</th>
          <th>Tên kho</th>
          <th>Địa chỉ</th>
          <th>Người quản lý</th>
          <th>Số điện thoại</th>
          <th>Sức chứa</th>
          <th>Tổng sản phẩm</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th>Thao tác</th>
         </tr>
        </thead>
        <tbody id="warehousesTableBody">
         <tr>
          <td><span class="warehouse-id">KHO-001</span></td>
          <td><span class="warehouse-name">Kho Hà Nội</span></td>
          <td>Lô D, Khu Công Nghiệp Thạch Thất, Hà Nội</td>
          <td>Nguyễn Văn A</td>
          <td>(+84) 123-456-789</td>
          <td>5000 m²</td>
          <td><strong>1,245</strong></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>15/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="warehouse-id">KHO-002</span></td>
          <td><span class="warehouse-name">Kho TP.HCM (Chi nhánh 1)</span></td>
          <td>Tân Phú, TP Hồ Chí Minh</td>
          <td>Trần Thị B</td>
          <td>(+84) 987-654-321</td>
          <td>8000 m²</td>
          <td><strong>3,562</strong></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>10/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="warehouse-id">KHO-003</span></td>
          <td><span class="warehouse-name">Kho TP.HCM (Chi nhánh 2)</span></td>
          <td>Bình Dương, TP Hồ Chí Minh</td>
          <td>Lê Văn C</td>
          <td>(+84) 345-678-901</td>
          <td>6500 m²</td>
          <td><strong>2,891</strong></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>08/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="warehouse-id">KHO-004</span></td>
          <td><span class="warehouse-name">Kho Đà Nẵng</span></td>
          <td>Hòa Vang, Đà Nẵng</td>
          <td>Phạm Thị D</td>
          <td>(+84) 234-567-890</td>
          <td>4000 m²</td>
          <td><strong>956</strong></td>
          <td><span class="status-badge inactive">Tạm ngưng</span></td>
          <td>05/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="warehouse-id">KHO-005</span></td>
          <td><span class="warehouse-name">Kho Cần Thơ</span></td>
          <td>Phong Điền, Cần Thơ</td>
          <td>Vũ Văn E</td>
          <td>(+84) 567-890-123</td>
          <td>3500 m²</td>
          <td><strong>1,723</strong></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>01/01/2025</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
         <tr>
          <td><span class="warehouse-id">KHO-006</span></td>
          <td><span class="warehouse-name">Kho Hải Phòng</span></td>
          <td>Cát Bà, Hải Phòng</td>
          <td>Hoàng Văn F</td>
          <td>(+84) 678-901-234</td>
          <td>4500 m²</td>
          <td><strong>2,134</strong></td>
          <td><span class="status-badge active">Hoạt động</span></td>
          <td>28/12/2024</td>
          <td>
           <div class="action-buttons"><button class="btn-action-view" title="Xem chi tiết">👁️</button><button class="btn-action-edit" title="Sửa">✏️</button><button class="btn-action-delete" title="Xóa">🗑️</button>
           </div></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div><!-- Pagination -->
     <div class="pagination">
      <button class="pagination-btn" id="prevBtn">← Trước</button>
      <div class="pagination-info">
       <span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">2</strong></span>
      </div><button class="pagination-btn" id="nextBtn">Tiếp theo →</button>
     </div>
    </main><!-- Add/Edit Warehouse Modal -->
    <div class="modal" id="warehouseModal">
     <div class="modal-overlay" id="modalOverlay"></div>
     <div class="modal-content">
      <div class="modal-header">
       <h2 class="modal-title" id="modalTitle">Thêm kho mới</h2><button class="modal-close" id="modalClose">×</button>
      </div>
      <div class="modal-body">
       <form id="warehouseForm" class="warehouse-form"><!-- Basic Info Section -->
        <div class="form-section-label">
         Thông tin cơ bản
        </div>
        <div class="form-row">
         <div class="form-group">
          <label for="warehouseCode">Mã kho <span style="color: #ef4444;">*</span></label> <input type="text" id="warehouseCode" placeholder="VD: KHO-001" required>
         </div>
         <div class="form-group">
          <label for="warehouseName">Tên kho <span style="color: #ef4444;">*</span></label> <input type="text" id="warehouseName" placeholder="Nhập tên kho" required>
         </div>
        </div>
        <div class="form-row">
    <div class="form-group">
        <label for="managerName">Người quản lý <span style="color: #ef4444;">*</span></label>
        <select id="managerName" name="ma_nguoi_quan_ly" class="toolbar-select" required>
            <option value="">-- Chọn người quản lý --</option>
        </select>
    </div>
    <div class="form-group">
        <label for="phoneNumber">Số điện thoại <span style="color: #ef4444;">*</span></label>
        <input type="tel" id="phoneNumber" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
    </div>
</div><!-- Location Info Section -->
        <div class="form-section-label">
         Thông tin vị trí
        </div>
        <div class="form-row full">
         <div class="form-group">
          <label for="address">Địa chỉ <span style="color: #ef4444;">*</span></label> <input type="text" id="address" placeholder="Nhập địa chỉ kho" required>
         </div>
        </div>
        <div class="form-row">
         <div class="form-group">
          <label for="province">Tỉnh/Thành phố <span style="color: #ef4444;">*</span></label> <select id="province" required> <option value="">Chọn Tỉnh/Thành phố</option> <option value="hanoi">Hà Nội</option> <option value="hcm">TP. Hồ Chí Minh</option> <option value="danang">Đà Nẵng</option> <option value="cantho">Cần Thơ</option> <option value="haiphong">Hải Phòng</option> <option value="binh-duong">Bình Dương</option> <option value="dong-nai">Đồng Nai</option> </select>
         </div>
         <div class="form-group">
          <label for="district">Quận/Huyện <span style="color: #ef4444;">*</span></label> <select id="district" required> <option value="">Chọn Quận/Huyện</option> <option value="district1">Quận 1</option> <option value="district2">Quận 2</option> <option value="district3">Quận 3</option> <option value="thanh-xuan">Thanh Xuân</option> <option value="dong-da">Đống Đa</option> </select>
         </div>
        </div><!-- Additional Info Section -->
        <div class="form-section-label">
         Thông tin bổ sung
        </div>
        <div class="form-row">
         <div class="form-group">
          <label for="capacity">Sức chứa (m²)</label> <input type="number" id="capacity" placeholder="VD: 5000" min="0">
         </div>
         <div class="form-group">
          <label for="status">Trạng thái <span style="color: #ef4444;">*</span></label>
          <div class="status-radio-group"><label class="radio-label"> <input type="radio" name="warehouseStatus" value="active" checked> <span>Hoạt động</span> </label> <label class="radio-label"> <input type="radio" name="warehouseStatus" value="inactive"> <span>Tạm ngưng</span> </label>
          </div>
         </div>
        </div>
        <div class="form-row full">
         <div class="form-group">
          <label for="description">Mô tả</label> <textarea id="description" placeholder="Nhập mô tả kho..."></textarea>
         </div>
        </div>
       </form>
      </div>
      <div class="modal-footer">
       <button class="btn-secondary" id="modalCancel">Hủy</button> <button class="btn-primary" id="modalSave">Lưu</button>
      </div>
     </div>
    </div><!-- FOOTER -->
    <footer class="wms-footer">
     <p class="footer-text" id="footerText">© 2026 Warehouse Management System — Developed for Academic Project</p>
    </footer>
   </div>
  </div><!-- LAYOUT JAVASCRIPT -->
  <script>
    // Default configuration
    const defaultConfig = {
      system_name: 'WMS',
      footer_text: '© 2026 Warehouse Management System — Developed for Academic Project',
      page_title: 'QUẢN LÝ KHO HÀNG',
      add_button_text: '+ Thêm kho mới',
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
    
    
    
    // ========================================
// WAREHOUSE MANAGEMENT JAVASCRIPT
// ========================================

// Modal Elements
const warehouseModal = document.getElementById('warehouseModal');
const modalOverlay = document.getElementById('modalOverlay');
const modalClose = document.getElementById('modalClose');
const modalCancel = document.getElementById('modalCancel');
const modalSave = document.getElementById('modalSave');
const warehouseForm = document.getElementById('warehouseForm');
const addWarehouseBtn = document.getElementById('addWarehouseBtn');
const refreshBtn = document.getElementById('refreshBtn');

// Toolbar Elements
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');

// Pagination Elements
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Table Body
const warehousesTableBody = document.getElementById('warehousesTableBody');

// State
let warehouses = [];
let filteredWarehouses = [];
let currentPage = 1;
const itemsPerPage = 10;
let isEditing = false;
let currentEditId = null;

// ========================================
// LOAD DỮ LIỆU
// ========================================

async function loadWarehouses() {
    try {
        warehousesTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px;">Đang tải dữ liệu...</td></tr>';

        const response = await fetch('../actions/QuanLyKho/lay_danh_sach.php');
        const data = await response.json();

        if (data.success) {
            warehouses = data.data || [];
            filteredWarehouses = [...warehouses];
            renderTable();
        } else {
            warehousesTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#f00;">Lỗi: ' + (data.message || 'Không xác định') + '</td></tr>';
        }
    } catch (error) {
        console.error('Lỗi load kho:', error);
        warehousesTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#f00;">Lỗi kết nối server</td></tr>';
    }
}

// ========================================
// HIỂN THỊ BẢNG
// ========================================

function renderTable() {
    if (filteredWarehouses.length === 0) {
        warehousesTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#666;">Không có kho nào</td></tr>';
        return;
    }

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = filteredWarehouses.slice(start, end);

    let html = '';

    pageData.forEach(warehouse => {
        const statusClass = warehouse.trang_thai == 1 ? 'active' : 'inactive';
        const statusText = warehouse.trang_thai == 1 ? 'Hoạt động' : 'Tạm ngưng';
        const ngayTao = warehouse.ngay_tao ? new Date(warehouse.ngay_tao).toLocaleDateString('vi-VN') : '';
        const sucChua = warehouse.suc_chua ? warehouse.suc_chua.toLocaleString() + ' m²' : '—';

        html += `
            <tr data-id="${warehouse.ma_kho}">
                <td><span class="warehouse-id">KHO-${String(warehouse.ma_kho).padStart(3, '0')}</span></td>
                <td><span class="warehouse-name">${escapeHtml(warehouse.ten_kho)}</span></td>
                <td>${escapeHtml(warehouse.dia_chi || '—')}</td>
                <td>${escapeHtml(warehouse.nguoi_quan_ly || '—')}</td>
                <td>${escapeHtml(warehouse.so_dien_thoai || '—')}</td>
                <td>${sucChua}</td>
                <td><strong>${warehouse.tong_san_pham.toLocaleString()}</strong></td>
                <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                <td>${ngayTao}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-action-view" title="Xem chi tiết" onclick="viewWarehouse(${warehouse.ma_kho})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="btn-action-edit" title="Sửa" onclick="editWarehouse(${warehouse.ma_kho})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                        </button>
                        <button class="btn-action-delete" title="Xóa" onclick="deleteWarehouse(${warehouse.ma_kho})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    warehousesTableBody.innerHTML = html;
    updatePagination();
}

function escapeHtml(text) {
    if (!text && text !== 0) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// ========================================
// PHÂN TRANG
// ========================================

function updatePagination() {
    const totalPages = Math.ceil(filteredWarehouses.length / itemsPerPage) || 1;
    document.getElementById('currentPage').textContent = currentPage;
    document.getElementById('totalPages').textContent = totalPages;

    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages;
}

prevBtn.addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
});

nextBtn.addEventListener('click', () => {
    const totalPages = Math.ceil(filteredWarehouses.length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
    }
});

// ========================================
// TÌM KIẾM VÀ LỌC
// ========================================

function applyFilters() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const status = statusFilter.value;

    filteredWarehouses = warehouses.filter(warehouse => {
        // Search
        if (searchTerm) {
            const matchCode = `KHO-${String(warehouse.ma_kho).padStart(3, '0')}`.toLowerCase().includes(searchTerm);
            const matchName = (warehouse.ten_kho || '').toLowerCase().includes(searchTerm);
            
            if (!matchCode && !matchName) return false;
        }

        // Status filter
        if (status !== '') {
            const statusValue = status === 'active' ? 1 : 0;
            if (warehouse.trang_thai !== statusValue) return false;
        }

        return true;
    });

    currentPage = 1;
    renderTable();
}

searchInput.addEventListener('input', applyFilters);
statusFilter.addEventListener('change', applyFilters);

refreshBtn.addEventListener('click', () => {
    searchInput.value = '';
    statusFilter.value = '';
    applyFilters();
    loadWarehouses();

    refreshBtn.style.animation = 'spin 0.6s ease-in-out';
    setTimeout(() => {
        refreshBtn.style.animation = '';
    }, 600);
});

// ========================================
// MODAL FUNCTIONS
// ========================================

function openModal() {
    warehouseModal.classList.add('active');
}

function closeModal() {
    warehouseModal.classList.remove('active');
    warehouseForm.reset();
    document.getElementById('warehouseCode').value = '';
    document.querySelector('input[name="warehouseStatus"][value="active"]').checked = true;
    isEditing = false;
    currentEditId = null;
}

addWarehouseBtn.addEventListener('click', () => {
    document.getElementById('modalTitle').textContent = 'Thêm kho mới';
    modalSave.textContent = 'Lưu';
    document.getElementById('warehouseCode').value = 'Tự động';
    openModal();
});

modalClose.addEventListener('click', closeModal);
modalCancel.addEventListener('click', closeModal);
modalOverlay.addEventListener('click', closeModal);

// ========================================
// XEM CHI TIẾT
// ========================================

window.viewWarehouse = async function(maKho) {
    try {
        const response = await fetch(`../actions/QuanLyKho/chi_tiet_kho.php?ma_kho=${maKho}`);
        const data = await response.json();

        if (data.success) {
            const warehouse = data.data.warehouse;
            const products = data.data.products;

            let productHtml = products.length > 0 
                ? products.map(p => `- ${p.ma_san_pham}: ${p.ten_hang_hoa} (${p.so_luong} sản phẩm)`).join('\n')
                : 'Không có sản phẩm nào trong kho';

            alert(`CHI TIẾT KHO HÀNG\n\n` +
                  `Mã kho: KHO-${String(warehouse.ma_kho).padStart(3, '0')}\n` +
                  `Tên kho: ${warehouse.ten_kho}\n` +
                  `Địa chỉ: ${warehouse.dia_chi || '—'}\n` +
                  `Người quản lý: ${warehouse.nguoi_quan_ly || '—'}\n` +
                  `SĐT: ${warehouse.so_dien_thoai || '—'}\n` +
                  `Sức chứa: ${warehouse.suc_chua ? warehouse.suc_chua.toLocaleString() + ' m²' : '—'}\n` +
                  `Mô tả: ${warehouse.mo_ta || '—'}\n` +
                  `Trạng thái: ${warehouse.trang_thai == 1 ? 'Hoạt động' : 'Tạm ngưng'}\n` +
                  `Ngày tạo: ${new Date(warehouse.ngay_tao).toLocaleDateString('vi-VN')}\n` +
                  `Tổng sản phẩm: ${warehouse.tong_san_pham.toLocaleString()}\n\n` +
                  `SẢN PHẨM TRONG KHO:\n${productHtml}`);
        } else {
            alert('Lỗi: ' + (data.message || 'Không thể tải chi tiết'));
        }
    } catch (error) {
        alert('Lỗi kết nối: ' + error.message);
    }
};

// ========================================
// SỬA KHO
// ========================================

window.editWarehouse = function(maKho) {
    const warehouse = warehouses.find(w => w.ma_kho == maKho);
    if (!warehouse) return;

    document.getElementById('warehouseCode').value = `KHO-${String(warehouse.ma_kho).padStart(3, '0')}`;
    document.getElementById('warehouseName').value = warehouse.ten_kho || '';
    document.getElementById('address').value = warehouse.dia_chi || '';
    document.getElementById('managerName').value = warehouse.nguoi_quan_ly || '';
    document.getElementById('phoneNumber').value = warehouse.so_dien_thoai || '';
    document.getElementById('capacity').value = warehouse.suc_chua || '';
    document.getElementById('description').value = warehouse.mo_ta || '';

    if (warehouse.trang_thai == 1) {
        document.querySelector('input[name="warehouseStatus"][value="active"]').checked = true;
    } else {
        document.querySelector('input[name="warehouseStatus"][value="inactive"]').checked = true;
    }

    document.getElementById('modalTitle').textContent = 'Chỉnh sửa kho';
    modalSave.textContent = 'Cập nhật';
    isEditing = true;
    currentEditId = maKho;

    openModal();
};

// ========================================
// XÓA KHO
// ========================================

window.deleteWarehouse = async function(maKho) {
    if (!confirm('Bạn chắc chắn muốn xóa kho này?')) return;

    try {
        const response = await fetch('../actions/QuanLyKho/xoa_kho.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `ma_kho=${maKho}`
        });

        const data = await response.json();

        if (data.success) {
            alert('Xóa thành công!');
            loadWarehouses();
        } else {
            alert('Lỗi: ' + (data.message || 'Xóa thất bại'));
        }
    } catch (error) {
        alert('Lỗi kết nối: ' + error.message);
    }
};

// ========================================
// LƯU (THÊM/SỬA)
// ========================================

modalSave.addEventListener('click', async () => {
    // Lấy giá trị từ form để kiểm tra
    const warehouseName = document.getElementById('warehouseName').value.trim();
    const address = document.getElementById('address').value.trim();
    const managerName = document.getElementById('managerName').value.trim();
    const phoneNumber = document.getElementById('phoneNumber').value.trim();

    console.log('Giá trị form:', {
        ten_kho: warehouseName,
        dia_chi: address,
        nguoi_quan_ly: managerName,
        so_dien_thoai: phoneNumber
    });

    if (!warehouseName) {
        alert('Vui lòng nhập tên kho!');
        document.getElementById('warehouseName').focus();
        return;
    }

    if (!address) {
        alert('Vui lòng nhập địa chỉ!');
        document.getElementById('address').focus();
        return;
    }

    if (!managerName) {
        alert('Vui lòng nhập tên người quản lý!');
        document.getElementById('managerName').focus();
        return;
    }

    if (!phoneNumber) {
        alert('Vui lòng nhập số điện thoại!');
        document.getElementById('phoneNumber').focus();
        return;
    }

    const url = isEditing
        ? '../actions/QuanLyKho/sua_kho.php'
        : '../actions/QuanLyKho/them_kho.php';

    // Tạo FormData và thêm dữ liệu thủ công để đảm bảo
    const formData = new FormData();
    formData.append('ten_kho', warehouseName);
    formData.append('dia_chi', address);
    formData.append('nguoi_quan_ly', managerName);
    formData.append('so_dien_thoai', phoneNumber);
    
    const capacity = document.getElementById('capacity').value;
    if (capacity) {
        formData.append('suc_chua', capacity);
    }
    
    const description = document.getElementById('description').value;
    if (description) {
        formData.append('mo_ta', description);
    }
    
    // Lấy giá trị radio button
    const trangThai = document.querySelector('input[name="trang_thai"]:checked')?.value || '1';
    formData.append('trang_thai', trangThai);
    
    // Thêm ma_kho nếu đang sửa
    if (isEditing) {
        formData.append('ma_kho', currentEditId);
    }

    // Debug: xem dữ liệu gửi đi
    console.log('Dữ liệu gửi đi:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const responseText = await response.text();
        console.log('Response text:', responseText);

        let data;
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            console.error('Lỗi parse JSON:', e);
            alert('Lỗi: Server trả về dữ liệu không hợp lệ. Xem console để biết chi tiết.');
            return;
        }

        if (data.success) {
            alert(data.message);
            closeModal();
            loadWarehouses();
        } else {
            alert('Lỗi: ' + (data.message || 'Không xác định'));
        }
    } catch (error) {
        console.error('Lỗi fetch:', error);
        alert('Lỗi kết nối server: ' + error.message);
    }
});
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
    
// ========================================
// KHỞI TẠO
// ========================================

document.addEventListener('DOMContentLoaded', () => {
    loadWarehouses();
});
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d6791c4d280039f',t:'MTc3MjUyOTY3MC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
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