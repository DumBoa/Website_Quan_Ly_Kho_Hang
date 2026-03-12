<?php
session_start();

if(!isset($_SESSION["ma_nguoi_dung"])){
    header("Location: /Project_QuanLyKhoHang/public/login.php");
    exit;
}

$ten = $_SESSION["ho_ten"] ?? '';
$role = $_SESSION["vai_tro"] ?? '';
$username = $_SESSION["ten_dang_nhap"] ?? '';
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
    
    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 24px;
    }
    
    .stat-card {
      background: var(--bg-white);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      transition: var(--transition);
    }
    
    .stat-card:hover {
      box-shadow: var(--shadow-md);
      transform: translateY(-2px);
    }
    
    .stat-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 12px;
    }
    
    .stat-card-icon {
      width: 44px;
      height: 44px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .stat-card-icon svg {
      width: 24px;
      height: 24px;
      color: white;
    }
    
    .stat-card-icon.blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .stat-card-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-card-icon.purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .stat-card-icon.orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    
    .stat-card-change {
      font-size: 12px;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 4px;
    }
    
    .stat-card-change.up {
      background: #ecfdf5;
      color: #10b981;
    }
    
    .stat-card-change.down {
      background: #fef2f2;
      color: #ef4444;
    }
    
    .stat-card-value {
      font-size: 28px;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -0.025em;
    }
    
    .stat-card-label {
      font-size: 13px;
      color: var(--text-muted);
      margin-top: 4px;
    }
    
    /* Content Cards Grid */
    /* Charts Grid */
    .charts-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 24px;
    }
    
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
    
    .chart-container canvas {
      max-width: 100%;
    }
    
    /* Tables Grid */
    .tables-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
    
    .content-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }
    
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
    
    .content-card-action {
      font-size: 13px;
      color: var(--accent-blue);
      text-decoration: none;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
    }
    
    .content-card-action:hover {
      color: var(--primary-navy);
    }
    
    .content-card-body {
      padding: 20px;
    }
    
    /* Recent Orders Table */
    .orders-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .orders-table th,
    .orders-table td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }
    
    .orders-table th {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      background: var(--bg-light);
    }
    
    .orders-table td {
      font-size: 14px;
      color: var(--text-primary);
    }
    
    .orders-table tr:last-child td {
      border-bottom: none;
    }
    
    .orders-table tr:hover td {
      background: var(--bg-light);
    }
    
    .order-id {
      font-weight: 600;
      color: var(--accent-blue);
    }
    
    /* Data Table Styles */
    .data-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .data-table th,
    .data-table td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }
    
    .data-table th {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      background: var(--bg-light);
    }
    
    .data-table td {
      font-size: 14px;
      color: var(--text-primary);
    }
    
    .data-table tr:last-child td {
      border-bottom: none;
    }
    
    .data-table tr:hover td {
      background: rgba(59, 130, 246, 0.02);
    }
    
    .table-id {
      font-weight: 600;
      color: var(--accent-blue);
    }
    
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }
    
    .status-badge.pending {
      background: #fef3c7;
      color: #d97706;
    }
    
    .status-badge.completed {
      background: #d1fae5;
      color: #059669;
    }
    
    .status-badge.processing {
      background: #dbeafe;
      color: #2563eb;
    }
    
    /* Activity List */
    .activity-list {
      display: flex;
      flex-direction: column;
    }
    
    .activity-item {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--border-color);
    }
    
    .activity-item:last-child {
      border-bottom: none;
    }
    
    .activity-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    
    .activity-icon svg {
      width: 18px;
      height: 18px;
    }
    
    .activity-icon.import {
      background: #dbeafe;
      color: #2563eb;
    }
    
    .activity-icon.export {
      background: #d1fae5;
      color: #059669;
    }
    
    .activity-icon.alert {
      background: #fee2e2;
      color: #dc2626;
    }
    
    .activity-icon.user {
      background: #f3e8ff;
      color: #7c3aed;
    }
    
    .activity-content {
      flex: 1;
    }
    
    .activity-text {
      font-size: 14px;
      color: var(--text-primary);
      line-height: 1.4;
    }
    
    .activity-text strong {
      font-weight: 600;
    }
    
    .activity-time {
      font-size: 12px;
      color: var(--text-muted);
      margin-top: 4px;
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
    @media (max-width: 1200px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .charts-grid {
        grid-template-columns: 1fr;
      }
      
      .tables-grid {
        grid-template-columns: 1fr;
      }
      
      .content-grid {
        grid-template-columns: 1fr;
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
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
      
      .breadcrumb {
        display: none;
      }
      
      .wms-content {
        padding: 16px;
      }
      
      .orders-table th:nth-child(3),
      .orders-table td:nth-child(3) {
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
    
    /* ========================================
       PRODUCT MANAGEMENT STYLES
       ======================================== */
    
    /* Primary Button */
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
    
    /* Secondary Button */
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
    
    /* Toolbar Styles */
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
    
    /* Products Table */
    .products-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .products-table th,
    .products-table td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }
    
    .products-table th {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      background: var(--bg-light);
    }
    
    .products-table td {
      font-size: 14px;
      color: var(--text-primary);
    }
    
    .products-table tbody tr:last-child td {
      border-bottom: none;
    }
    
    .products-table tbody tr:hover td {
      background: rgba(59, 130, 246, 0.02);
    }
    
    .product-id {
      font-weight: 600;
      color: var(--accent-blue);
    }
    
    .product-thumbnail {
      width: 36px;
      height: 36px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 600;
      color: white;
    }
    
    /* Status Badges */
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 6px 12px;
      border-radius: 16px;
      font-size: 12px;
      font-weight: 600;
      white-space: nowrap;
    }
    
    .status-badge.in-stock {
      background: #d1fae5;
      color: #059669;
    }
    
    .status-badge.low-stock {
      background: #fed7aa;
      color: #d97706;
    }
    
    .status-badge.out-of-stock {
      background: #fee2e2;
      color: #dc2626;
    }
    
    .status-badge.completed {
      background: #d1fae5;
      color: #059669;
    }
    
    .status-badge.processing {
      background: #dbeafe;
      color: #2563eb;
    }
    
    .status-badge.pending {
      background: #fef3c7;
      color: #d97706;
    }
    
    /* Action Buttons */
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
    
    /* Pagination */
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
    
    /* Modal Styles */
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
      max-width: 600px;
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
    
    /* Form Styles */
    .product-form {
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
    
    .form-group.full-width {
      grid-column: 1 / -1;
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
      min-height: 60px;
    }
    
    /* Responsive Product Management */
    @media (max-width: 1024px) {
      .toolbar-group {
        min-width: auto;
        flex: 1 1 calc(50% - 6px);
      }
    }
    
    @media (max-width: 768px) {
      .toolbar {
        flex-direction: column;
      }
      
      .toolbar-group {
        min-width: auto;
        flex: 1;
        width: 100%;
      }
      
      .products-table th:nth-child(7),
      .products-table td:nth-child(7) {
        display: none;
      }
      
      .products-table th:nth-child(8),
      .products-table td:nth-child(8) {
        display: none;
      }
      
      .modal-content {
        width: 95%;
        max-height: 95%;
      }
      
      .form-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full">
  <div class="wms-app">
   <!-- Mobile Overlay -->
   <div class="mobile-overlay" id="mobileOverlay"></div>

   <?php include __DIR__ . "/../views/Layout/sidebar.php"; ?> 

   <div class="wms-main">
      <?php include __DIR__ . "/../views/Layout/header.php"; ?>

      <main class="wms-content">
        <!-- Page Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
          <div class="content-header">
            <h1 class="page-title" id="pageTitle">QUẢN LÝ SẢN PHẨM</h1>
          </div>
          <button id="addProductBtn" class="btn-primary" style="margin-bottom: 0;">
            <svg style="width: 18px; height: 18px; margin-right: 6px;" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="5" x2="12" y2="19"></line> 
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span id="addButtonText">Thêm sản phẩm</span> 
          </button>
        </div>

        <!-- Toolbar - Search & Filters -->
        <div class="content-card" style="margin-bottom: 24px;">
          <div class="content-card-body" style="padding: 16px;">
            <div class="toolbar">
              <!-- Search -->
              <div class="toolbar-group">
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên/mã sản phẩm..." class="toolbar-search">
              </div>
              <!-- Filters -->
              <div class="toolbar-group">
                <select id="categoryFilter" class="toolbar-select">
                  <option value="">Tất cả danh mục</option>
                </select>
                <select id="warehouseFilter" class="toolbar-select">
                  <option value="">Tất cả kho</option>
                </select>
                <select id="statusFilter" class="toolbar-select">
                  <option value="">Tất cả trạng thái</option>
                  <option value="in-stock">Còn hàng</option>
                  <option value="low-stock">Sắp hết</option>
                  <option value="out-of-stock">Hết hàng</option>
                </select>
              </div>
              <!-- Refresh Button -->
              <button id="refreshBtn" class="btn-refresh">
                <svg viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="23 4 23 10 17 10"></polyline> 
                  <path d="M20.49 15a9 9 0 11-2-8.12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Products Table -->
        <div class="content-card">
          <div class="content-card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
              <table class="products-table">
                <thead>
                  <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Kho</th>
                    <th>Số lượng</th>
                    <th>Giá nhập</th>
                    <th>Giá bán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody id="productsTableBody">
                  <!-- Dữ liệu sẽ được load bằng JavaScript -->
                  <tr>
                    <td colspan="10" style="text-align:center; padding:40px; color:#666;">
                      Đang tải dữ liệu...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div class="pagination">
          <button class="pagination-btn" id="prevBtn" disabled>← Trước</button>
          <div class="pagination-info">
            <span>Trang <strong id="currentPage">1</strong> / <strong id="totalPages">1</strong></span>
          </div>
          <button class="pagination-btn" id="nextBtn" disabled>Tiếp theo →</button>
        </div>
      </main>

      <!-- Add/Edit Product Modal -->
      <div class="modal" id="productModal">
        <div class="modal-overlay" id="modalOverlay"></div>
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Thêm sản phẩm mới</h2>
            <button class="modal-close" id="modalClose">×</button>
          </div>
          <div class="modal-body">
            <form id="productForm" class="product-form">
              <input type="hidden" id="productId" name="ma_hang_hoa">
              
              <div class="form-row">
                <div class="form-group">
                  <label for="productCode">Mã sản phẩm *</label>
                  <input type="text" id="productCode" name="ma_san_pham" placeholder="VD: SP-001" required>
                </div>
                <div class="form-group">
                  <label for="productName">Tên sản phẩm *</label>
                  <input type="text" id="productName" name="ten_hang_hoa" placeholder="Nhập tên sản phẩm" required>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="productCategory">Danh mục *</label>
                  <select id="productCategory" name="ma_danh_muc" required>
                    <option value="">Đang tải...</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="productWarehouse">Kho *</label>
                  <select id="productWarehouse" name="ma_kho" required>
                    <option value="">Đang tải...</option>
                  </select>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="productImportPrice">Giá nhập (đ) *</label>
                  <input type="text" id="productImportPrice" name="gia_nhap" placeholder="0" required>
                </div>
                <div class="form-group">
                  <label for="productSalePrice">Giá bán (đ) *</label>
                  <input type="text" id="productSalePrice" name="gia_ban" placeholder="0" required>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="productQuantity">Số lượng *</label>
                  <input type="number" id="productQuantity" name="so_luong" placeholder="0" min="0" required>
                </div>
                <div class="form-group">
                  <label for="productDescription">Mô tả</label>
                  <textarea id="productDescription" name="mo_ta" placeholder="Nhập mô tả sản phẩm" rows="2"></textarea>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn-secondary" id="modalCancel">Hủy</button>
            <button class="btn-primary" id="modalSave">Lưu</button>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="wms-footer">
        <p class="footer-text" id="footerText">© 2026 Warehouse Management System — Developed for Academic Project</p>
      </footer>
   </div>
  </div>

  <!-- JavaScript - VIẾT LẠI HOÀN TOÀN -->
  <script>
    // ========================================
    // QUẢN LÝ SẢN PHẨM - JAVASCRIPT MỚI
    // ========================================
    
    // DOM Elements
    const productModal = document.getElementById('productModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalClose = document.getElementById('modalClose');
    const modalCancel = document.getElementById('modalCancel');
    const modalSave = document.getElementById('modalSave');
    const productForm = document.getElementById('productForm');
    const addProductBtn = document.getElementById('addProductBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const warehouseFilter = document.getElementById('warehouseFilter');
    const statusFilter = document.getElementById('statusFilter');
    const productsTableBody = document.getElementById('productsTableBody');
    
    // State
    let products = [];
    let filteredProducts = [];
    let categories = [];
    let warehouses = [];
    let currentPage = 1;
    const itemsPerPage = 10;
    let isEditing = false;
    let currentEditId = null;

    // ========================================
    // KHỞI TẠO DỮ LIỆU
    // ========================================
    
    // Load danh mục
    // Load danh mục
async function loadCategories() {
  try {
    console.log('Đang load danh mục...');
    const response = await fetch('../actions/QuanLyHangHoa/lay_danh_muc.php');
    const data = await response.json();
    console.log('Kết quả danh mục:', data);
    
    if (data.success) {
      categories = data.data || [];
      
      // Fill category filter
      const filterSelect = document.getElementById('categoryFilter');
      filterSelect.innerHTML = '<option value="">Tất cả danh mục</option>';
      
      // Fill modal select
      const modalSelect = document.getElementById('productCategory');
      modalSelect.innerHTML = '<option value="">Chọn danh mục</option>';
      
      if (categories.length > 0) {
        categories.forEach(cat => {
          filterSelect.innerHTML += `<option value="${cat.ma_danh_muc}">${cat.ten_danh_muc}</option>`;
          modalSelect.innerHTML += `<option value="${cat.ma_danh_muc}">${cat.ten_danh_muc}</option>`;
        });
      } else {
        modalSelect.innerHTML = '<option value="">Không có danh mục</option>';
      }
    } else {
      console.error('Lỗi load danh mục:', data.message);
    }
  } catch (error) {
    console.error('Lỗi load danh mục:', error);
  }
}

// Load kho
async function loadWarehouses() {
  try {
    console.log('Đang load kho...');
    const response = await fetch('../actions/QuanLyHangHoa/lay_kho.php');
    const data = await response.json();
    console.log('Kết quả kho:', data);
    
    if (data.success) {
      warehouses = data.data || [];
      
      // Fill warehouse filter
      const filterSelect = document.getElementById('warehouseFilter');
      filterSelect.innerHTML = '<option value="">Tất cả kho</option>';
      
      // Fill modal select
      const modalSelect = document.getElementById('productWarehouse');
      modalSelect.innerHTML = '<option value="">Chọn kho</option>';
      
      if (warehouses.length > 0) {
        warehouses.forEach(warehouse => {
          filterSelect.innerHTML += `<option value="${warehouse.ma_kho}">${warehouse.ten_kho}</option>`;
          modalSelect.innerHTML += `<option value="${warehouse.ma_kho}">${warehouse.ten_kho}</option>`;
        });
      } else {
        modalSelect.innerHTML = '<option value="">Không có kho</option>';
      }
    } else {
      console.error('Lỗi load kho:', data.message);
    }
  } catch (error) {
    console.error('Lỗi load kho:', error);
  }
}

// Load sản phẩm
async function loadProducts() {
  try {
    productsTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px;">Đang tải dữ liệu...</td></tr>';
    
    console.log('Đang load sản phẩm...');
    const response = await fetch('../actions/QuanLyHangHoa/lay_danh_sach.php');
    const data = await response.json();
    console.log('Kết quả sản phẩm:', data);
    
    if (data.success) {
      products = data.data || [];
      filteredProducts = [...products];
      renderTable();
    } else {
      productsTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#f00;">Lỗi: ' + (data.message || 'Không xác định') + '</td></tr>';
    }
  } catch (error) {
    console.error('Lỗi load sản phẩm:', error);
    productsTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#f00;">Lỗi kết nối server: ' + error.message + '</td></tr>';
  }
}

    // ========================================
    // HIỂN THỊ BẢNG
    // ========================================
    
    function renderTable() {
      if (filteredProducts.length === 0) {
        productsTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#666;">Không có sản phẩm nào</td></tr>';
        return;
      }

      const start = (currentPage - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const pageData = filteredProducts.slice(start, end);
      
      let html = '';
      
      pageData.forEach(product => {
        const thumbnailColor = product.ma_san_pham ? '#' + md5(product.ma_san_pham).substring(0, 6) : '#ccc';
        
        html += `
          <tr data-id="${product.ma_san_pham}">
            <td><span class="product-id">${escapeHtml(product.ma_san_pham)}</span></td>
            <td><strong>${escapeHtml(product.ten_hang_hoa)}</strong></td>
            <td>
              <div class="product-thumbnail" style="background: ${thumbnailColor};"></div>
            </td>
            <td>${escapeHtml(product.ten_danh_muc || 'Chưa phân loại')}</td>
            <td>${escapeHtml(product.ten_kho || '-')}</td>
            <td>${formatNumber(product.so_luong)}</td>
            <td>${formatNumber(product.gia_nhap)} đ</td>
            <td>${formatNumber(product.gia_ban)} đ</td>
            <td>
              <span class="status-badge ${product.trang_thai_class}">
                ${product.trang_thai_text}
              </span>
            </td>
            <td>
              <div class="action-buttons">
                <button class="btn-action-view" title="Xem" onclick="viewProduct('${product.ma_san_pham}')">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>                
                </button>
                <button class="btn-action-edit" title="Sửa" onclick="editProduct('${product.ma_san_pham}')">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                </button>
                <button class="btn-action-delete" title="Xóa" onclick="deleteProduct('${product.ma_san_pham}')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                </button>
              </div>
            </td>
          </tr>
        `;
      });
      
      productsTableBody.innerHTML = html;
      updatePagination();
    }

    // Helper functions
    function escapeHtml(text) {
      if (!text) return '';
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    function formatNumber(num) {
      if (!num && num !== 0) return '0';
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function md5(string) {
      // Simple hash function for colors - không phải MD5 thật
      let hash = 0;
      for (let i = 0; i < string.length; i++) {
        hash = ((hash << 5) - hash) + string.charCodeAt(i);
        hash |= 0;
      }
      return Math.abs(hash).toString(16);
    }


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
    // PHÂN TRANG
    // ========================================
    
    function updatePagination() {
      const totalPages = Math.ceil(filteredProducts.length / itemsPerPage) || 1;
      document.getElementById('currentPage').textContent = currentPage;
      document.getElementById('totalPages').textContent = totalPages;
      
      document.getElementById('prevBtn').disabled = currentPage === 1;
      document.getElementById('nextBtn').disabled = currentPage === totalPages;
    }

    document.getElementById('prevBtn').addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        renderTable();
      }
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
      const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
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
      const categoryId = categoryFilter.value;
      const warehouseId = warehouseFilter.value;
      const status = statusFilter.value;
      
      filteredProducts = products.filter(product => {
        // Search
        if (searchTerm) {
          const matchCode = product.ma_san_pham.toLowerCase().includes(searchTerm);
          const matchName = product.ten_hang_hoa.toLowerCase().includes(searchTerm);
          if (!matchCode && !matchName) return false;
        }
        
        // Category
        if (categoryId && product.ma_danh_muc != categoryId) return false;
        
        // Warehouse
        if (warehouseId && product.ma_kho != warehouseId) return false;
        
        // Status
        if (status && product.trang_thai_class !== status) return false;
        
        return true;
      });
      
      currentPage = 1;
      renderTable();
    }

    searchInput.addEventListener('input', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    warehouseFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

    refreshBtn.addEventListener('click', () => {
      searchInput.value = '';
      categoryFilter.value = '';
      warehouseFilter.value = '';
      statusFilter.value = '';
      applyFilters();
      
      refreshBtn.style.animation = 'spin 0.6s ease-in-out';
      setTimeout(() => {
        refreshBtn.style.animation = '';
      }, 600);
    });

    // ========================================
    // MODAL FUNCTIONS
    // ========================================
    
    function openModal() {
      productModal.classList.add('active');
    }
    
    function closeModal() {
      productModal.classList.remove('active');
      productForm.reset();
      document.getElementById('productCode').readOnly = false;
      isEditing = false;
      currentEditId = null;
    }
    
    addProductBtn.addEventListener('click', () => {
      document.getElementById('modalTitle').textContent = 'Thêm sản phẩm mới';
      modalSave.textContent = 'Thêm';
      openModal();
    });
    
    modalClose.addEventListener('click', closeModal);
    modalCancel.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', closeModal);

    // ========================================
    // XEM SẢN PHẨM
    // ========================================
    
    window.viewProduct = function(maSanPham) {
      const product = products.find(p => p.ma_san_pham === maSanPham);
      if (product) {
        alert(`Xem chi tiết sản phẩm:\nMã: ${product.ma_san_pham}\nTên: ${product.ten_hang_hoa}\nSố lượng: ${product.so_luong}`);
      }
    }

    // ========================================
    // SỬA SẢN PHẨM
    // ========================================
    
    window.editProduct = function(maSanPham) {
      const product = products.find(p => p.ma_san_pham === maSanPham);
      if (!product) return;
      
      // Fill form
      document.getElementById('productCode').value = product.ma_san_pham;
      document.getElementById('productCode').readOnly = true;
      document.getElementById('productName').value = product.ten_hang_hoa;
      document.getElementById('productCategory').value = product.ma_danh_muc || '';
      document.getElementById('productWarehouse').value = product.ma_kho || '';
      document.getElementById('productImportPrice').value = product.gia_nhap || '';
      document.getElementById('productSalePrice').value = product.gia_ban || '';
      document.getElementById('productQuantity').value = product.so_luong || '';
      document.getElementById('productDescription').value = product.mo_ta || '';
      
      document.getElementById('modalTitle').textContent = 'Chỉnh sửa sản phẩm';
      modalSave.textContent = 'Cập nhật';
      isEditing = true;
      currentEditId = maSanPham;
      
      openModal();
    }

    // ========================================
    // XÓA SẢN PHẨM
    // ========================================
    
    window.deleteProduct = async function(maSanPham) {
      if (!confirm('Bạn chắc chắn muốn xóa sản phẩm này?')) return;
      
      try {
        const response = await fetch('../actions/QuanLyHangHoa/xoa_hang_hoa.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `ma_san_pham=${encodeURIComponent(maSanPham)}`
        });
        
        const data = await response.json();
        
        if (data.success) {
          alert('Xóa thành công!');
          loadProducts(); // Reload danh sách
        } else {
          alert('Lỗi: ' + (data.message || 'Xóa thất bại'));
        }
      } catch (error) {
        alert('Lỗi kết nối: ' + error.message);
      }
    }

    // ========================================
    // LƯU (THÊM/SỬA)
    // ========================================
    
    // ========================================
// LƯU (THÊM/SỬA)
// ========================================

modalSave.addEventListener('click', async () => {
  try {
    // Validate
    const productCode = document.getElementById('productCode').value.trim();
    const productName = document.getElementById('productName').value.trim();
    const category = document.getElementById('productCategory').value;
    const warehouse = document.getElementById('productWarehouse').value;
    
    if (!productCode) {
      alert('Vui lòng nhập mã sản phẩm!');
      return;
    }
    if (!productName) {
      alert('Vui lòng nhập tên sản phẩm!');
      return;
    }
    if (!category) {
      alert('Vui lòng chọn danh mục!');
      return;
    }
    if (!warehouse) {
      alert('Vui lòng chọn kho!');
      return;
    }
    
    // Format prices
    const importPrice = document.getElementById('productImportPrice');
    const salePrice = document.getElementById('productSalePrice');
    
    // Lưu giá trị gốc để gửi lên server
    const importPriceValue = importPrice.value.replace(/,/g, '');
    const salePriceValue = salePrice.value.replace(/,/g, '');
    
    const url = isEditing 
      ? '../actions/QuanLyHangHoa/sua_hang_hoa.php' 
      : '../actions/QuanLyHangHoa/them_hang_hoa.php';
    
    // Tạo FormData và thêm dữ liệu
    const formData = new FormData();
    formData.append('ma_san_pham', productCode);
    formData.append('ten_hang_hoa', productName);
    formData.append('ma_danh_muc', category);
    formData.append('ma_kho', warehouse);
    formData.append('gia_nhap', importPriceValue);
    formData.append('gia_ban', salePriceValue);
    formData.append('so_luong', document.getElementById('productQuantity').value);
    formData.append('mo_ta', document.getElementById('productDescription').value);
    
    console.log('Đang gửi request đến:', url);
    console.log('Dữ liệu gửi đi:', Object.fromEntries(formData));
    
    const response = await fetch(url, {
      method: 'POST',
      body: formData
    });
    
    const responseText = await response.text();
    console.log('Response text:', responseText);
    
    // Thử parse JSON
    let data;
    try {
      data = JSON.parse(responseText);
    } catch (e) {
      console.error('Không thể parse JSON:', responseText);
      throw new Error('Server trả về dữ liệu không hợp lệ. Vui lòng kiểm tra console để biết thêm chi tiết.');
    }
    
    if (data.success) {
      alert(data.message);
      closeModal();
      loadProducts(); // Reload danh sách
    } else {
      alert('Lỗi: ' + (data.message || 'Không xác định'));
    }
  } catch (error) {
    console.error('Chi tiết lỗi:', error);
    alert('Lỗi: ' + error.message);
  }
});

    // ========================================
    // FORMAT GIÁ KHI NHẬP
    // ========================================
    
    document.getElementById('productImportPrice').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value) {
        e.target.value = formatNumber(value);
      }
    });
    
    document.getElementById('productSalePrice').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value) {
        e.target.value = formatNumber(value);
      }
    });

    // ========================================
    // KHỞI TẠO
    // ========================================
    
    document.addEventListener('DOMContentLoaded', () => {
      loadCategories();
      loadWarehouses();
      loadProducts();
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

</script>
  <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d67602fd746039f',t:'MTc3MjUyNzYzOS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>
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