<!doctype html>
<html lang="vi" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nhật Ký Đăng Nhập - Quản Lý Kho</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy: {
              50: '#f0f3f9',
              100: '#e1e7f3',
              200: '#c3cfe7',
              300: '#a5b7db',
              400: '#879fcf',
              500: '#6987c3',
              600: '#4b6fb7',
              700: '#1e3a5f',
              800: '#162c47',
              900: '#0e1e2f'
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
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    
    .app-wrapper {
      height: 100%;
      width: 100%;
      overflow: auto;
      background: #f1f5f9;
    }

    .sidebar-link:hover {
      background: rgba(255,255,255,0.1);
    }
    
    .sidebar-link.active {
      background: rgba(255,255,255,0.15);
      border-left: 3px solid #60a5fa;
    }

    .custom-scrollbar::-webkit-scrollbar {
      width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
      animation: fadeIn 0.3s ease-out;
    }

    /* Stat Card Styles */
    .stat-card {
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 20px;
      display: flex;
      align-items: flex-start;
      gap: 16px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      transition: all 0.2s;
    }

    .stat-card:hover {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-color: #d1d5db;
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .stat-icon.primary {
      background: #dbeafe;
      color: #1e3a5f;
    }

    .stat-icon.success {
      background: #dcfce7;
      color: #15803d;
    }

    .stat-icon.danger {
      background: #fee2e2;
      color: #dc2626;
    }

    .stat-icon.warning {
      background: #fef3c7;
      color: #ca8a04;
    }

    .stat-content h3 {
      font-size: 0.875rem;
      color: #6b7280;
      font-weight: 500;
      margin: 0 0 4px 0;
    }

    .stat-value {
      font-size: 1.875rem;
      font-weight: 700;
      color: #1e3a5f;
      margin: 0;
    }

    /* Table Styles */
    .logs-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.875rem;
    }

    .logs-table thead {
      background-color: #f3f4f6;
      border-bottom: 2px solid #e5e7eb;
    }

    .logs-table thead th {
      padding: 12px 16px;
      text-align: left;
      font-weight: 600;
      color: #1e3a5f;
      font-size: 0.8125rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .logs-table tbody tr {
      border-bottom: 1px solid #e5e7eb;
      transition: background-color 0.2s;
    }

    .logs-table tbody tr:hover {
      background-color: #f9fafb;
    }

    .logs-table tbody td {
      padding: 12px 16px;
      color: #374151;
    }

    .status-badge {
      display: inline-flex;
      padding: 4px 12px;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 600;
      align-items: center;
      gap: 6px;
    }

    .status-success {
      background: #dcfce7;
      color: #15803d;
    }

    .status-failed {
      background: #fee2e2;
      color: #dc2626;
    }

    .action-btn {
      color: #0284c7;
      font-weight: 600;
      font-size: 0.75rem;
      cursor: pointer;
      transition: color 0.2s;
      text-decoration: none;
      border: none;
      background: none;
      padding: 0;
    }

    .action-btn:hover {
      color: #0369a1;
    }

    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 50;
    }

    .modal-hidden {
      display: none;
    }

    .detail-row {
      display: grid;
      grid-template-columns: 200px 1fr;
      gap: 20px;
      padding: 12px 0;
      border-bottom: 1px solid #e5e7eb;
    }

    .detail-row:last-child {
      border-bottom: none;
    }

    .detail-label {
      font-weight: 600;
      color: #1e3a5f;
      font-size: 0.875rem;
    }

    .detail-value {
      color: #374151;
      font-size: 0.875rem;
    }
  </style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <style>body { box-sizing: border-box; }</style>
 </head>
 <body class="h-full font-inter bg-slate-100">
  <div class="app-wrapper flex"><!-- Sidebar -->
   <aside class="w-64 bg-navy-700 min-h-full flex-shrink-0 flex flex-col"><!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-navy-600">
     <div class="flex items-center gap-3">
      <div class="w-9 h-9 bg-blue-500 rounded-lg flex items-center justify-center">
       <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
       </svg>
      </div><span class="text-white font-semibold text-lg">KhoManager</span>
     </div>
    </div><!-- Navigation -->
    <nav class="flex-1 py-4 overflow-y-auto custom-scrollbar">
     <div class="px-4 mb-2">
      <span class="text-xs font-medium text-navy-300 uppercase tracking-wider">Menu chính</span>
     </div><a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg><span class="text-sm font-medium">Dashboard</span> </a> <a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
      </svg><span class="text-sm font-medium">Quản lý kho</span> </a> <a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
      </svg><span class="text-sm font-medium">Kiểm kê kho</span> </a> <a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg><span class="text-sm font-medium">Phiếu nhập kho</span> </a> <a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg><span class="text-sm font-medium">Phiếu xuất kho</span> </a> <a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
      </svg><span class="text-sm font-medium">Sản phẩm</span> </a>
     <div class="px-4 mt-6 mb-2">
      <span class="text-xs font-medium text-navy-300 uppercase tracking-wider">Hệ thống</span>
     </div><a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
      </svg><span class="text-sm font-medium">Người dùng</span> </a> <a href="#" class="sidebar-link active flex items-center gap-3 px-6 py-3 text-white transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg><span class="text-sm font-medium">Lịch sử đăng nhập</span> </a> <a href="#" class="sidebar-link flex items-center gap-3 px-6 py-3 text-navy-200 transition-all">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
      </svg><span class="text-sm font-medium">Cài đặt</span> </a>
    </nav><!-- User Info -->
    <div class="p-4 border-t border-navy-600">
     <div class="flex items-center gap-3">
      <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
       AD
      </div>
      <div class="flex-1 min-w-0">
       <p class="text-sm font-medium text-white truncate">Admin A</p>
       <p class="text-xs text-navy-300 truncate">admin@khomanager.vn</p>
      </div>
     </div>
    </div>
   </aside><!-- Main Content -->
   <div class="flex-1 flex flex-col min-h-full"><!-- Topbar -->
    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 flex-shrink-0">
     <div class="flex items-center gap-4"><button class="lg:hidden p-2 text-slate-500 hover:text-slate-700">
       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
       </svg></button>
      <div class="relative"><input type="text" placeholder="Tìm kiếm..." class="w-64 pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
       <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
       </svg>
      </div>
     </div>
     <div class="flex items-center gap-4"><button class="relative p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
       </svg><span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span> </button> <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
       </svg></button>
      <div class="h-8 w-px bg-slate-200"></div>
      <div class="flex items-center gap-3">
       <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium text-sm">
        AD
       </div>
       <div class="hidden md:block">
        <p class="text-sm font-medium text-slate-700">Admin A</p>
        <p class="text-xs text-slate-500">Quản trị viên</p>
       </div>
      </div>
     </div>
    </header><!-- Page Content -->
    <main class="flex-1 p-6 overflow-auto"><!-- Page Header -->
     <div class="mb-6 animate-fadeIn">
      <nav class="flex items-center gap-2 text-sm mb-4"><a href="#" class="text-slate-500 hover:text-navy-700 transition-colors">Trang chủ</a>
       <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
       </svg><a href="#" class="text-slate-500 hover:text-navy-700 transition-colors">Hệ thống</a>
       <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
       </svg><span class="text-navy-700 font-medium">Nhật ký đăng nhập</span>
      </nav>
      <div class="mb-2">
       <h1 id="page-title" class="text-4xl font-bold text-navy-800">QUẢN LÝ NHẬT KÝ ĐĂNG NHẬP</h1>
      </div>
      <p id="page-description" class="text-slate-600">Theo dõi lịch sử đăng nhập của người dùng trong hệ thống quản lý kho.</p>
     </div><!-- Stats Cards -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 animate-fadeIn" style="animation-delay: 0.1s">
      <div class="stat-card">
       <div class="stat-icon primary">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
       </div>
       <div class="stat-content">
        <h3>Đăng nhập hôm nay</h3>
        <p class="stat-value">42</p>
       </div>
      </div>
      <div class="stat-card">
       <div class="stat-icon success">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
       </div>
       <div class="stat-content">
        <h3>Thành công</h3>
        <p class="stat-value">39</p>
       </div>
      </div>
      <div class="stat-card">
       <div class="stat-icon danger">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2" />
        </svg>
       </div>
       <div class="stat-content">
        <h3>Thất bại</h3>
        <p class="stat-value">3</p>
       </div>
      </div>
      <div class="stat-card">
       <div class="stat-icon warning">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20h12v-2a4 4 0 00-8 0v2z" />
        </svg>
       </div>
       <div class="stat-content">
        <h3>Người dùng hoạt động</h3>
        <p class="stat-value">12</p>
       </div>
      </div>
     </div><!-- Filter Toolbar -->
     <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-5 mb-6 animate-fadeIn" style="animation-delay: 0.15s">
      <div class="mb-4"><label class="block text-sm font-medium text-slate-700 mb-2">Tìm kiếm nhanh</label>
       <div class="relative"><input type="text" id="search-input" placeholder="Tìm theo tên người dùng, email hoặc IP..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
       </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
       <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Người dùng</label> <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"> <option>Tất cả người dùng</option> <option>admin</option> <option>thukho_a</option> <option>thukho_b</option> <option>nv_01</option> </select>
       </div>
       <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Vai trò</label> <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"> <option>Tất cả vai trò</option> <option>Admin</option> <option>Quản lý</option> <option>Thủ kho</option> <option>Nhân viên</option> </select>
       </div>
       <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Trạng thái</label> <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"> <option>Tất cả</option> <option>Thành công</option> <option>Thất bại</option> </select>
       </div>
       <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Ngày</label> <input type="date" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
       </div>
      </div>
      <div class="flex gap-2 justify-between items-center flex-wrap">
       <div class="flex gap-2"><button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm"> Lọc dữ liệu </button> <button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-sm"> Làm mới </button>
       </div>
       <div class="flex gap-2"><button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-sm flex items-center gap-2">
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
         </svg> Xuất Excel </button> <button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-sm flex items-center gap-2">
         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
         </svg> Xuất PDF </button>
       </div>
      </div>
     </div><!-- Login Logs Table -->
     <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden animate-fadeIn" style="animation-delay: 0.2s">
      <div class="overflow-x-auto">
       <table class="logs-table">
        <thead>
         <tr>
          <th>Thời gian</th>
          <th>Tài khoản</th>
          <th>Tên người dùng</th>
          <th>Vai trò</th>
          <th>Địa chỉ IP</th>
          <th>Trình duyệt</th>
          <th>Hệ điều hành</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
         </tr>
        </thead>
        <tbody id="logs-tbody">
         <tr>
          <td>10:35, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">admin</span></td>
          <td>Nguyễn Văn A</td>
          <td>Admin</td>
          <td>192.168.1.12</td>
          <td>Chrome 121</td>
          <td>Windows 10</td>
          <td><span class="status-badge status-success">✓ Thành công</span></td>
          <td><button class="action-btn view-detail" data-id="1">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>10:22, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">thukho_a</span></td>
          <td>Trần Thị B</td>
          <td>Thủ kho</td>
          <td>192.168.1.45</td>
          <td>Firefox 121</td>
          <td>Windows 11</td>
          <td><span class="status-badge status-success">✓ Thành công</span></td>
          <td><button class="action-btn view-detail" data-id="2">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>10:15, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">nv_01</span></td>
          <td>Lê Văn C</td>
          <td>Nhân viên</td>
          <td>192.168.1.78</td>
          <td>Chrome 121</td>
          <td>MacOS</td>
          <td><span class="status-badge status-failed">✗ Thất bại</span></td>
          <td><button class="action-btn view-detail" data-id="3">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>09:50, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">admin</span></td>
          <td>Nguyễn Văn A</td>
          <td>Admin</td>
          <td>192.168.1.12</td>
          <td>Chrome 121</td>
          <td>Windows 10</td>
          <td><span class="status-badge status-success">✓ Thành công</span></td>
          <td><button class="action-btn view-detail" data-id="4">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>09:25, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">thukho_b</span></td>
          <td>Phạm Minh D</td>
          <td>Thủ kho</td>
          <td>192.168.1.56</td>
          <td>Safari</td>
          <td>iOS</td>
          <td><span class="status-badge status-success">✓ Thành công</span></td>
          <td><button class="action-btn view-detail" data-id="5">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>09:10, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">nv_02</span></td>
          <td>Vũ Thị E</td>
          <td>Nhân viên</td>
          <td>192.168.1.89</td>
          <td>Chrome 121</td>
          <td>Windows 10</td>
          <td><span class="status-badge status-failed">✗ Thất bại</span></td>
          <td><button class="action-btn view-detail" data-id="6">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>08:45, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">manager_01</span></td>
          <td>Đỗ Văn F</td>
          <td>Quản lý</td>
          <td>192.168.1.33</td>
          <td>Edge 121</td>
          <td>Windows 11</td>
          <td><span class="status-badge status-success">✓ Thành công</span></td>
          <td><button class="action-btn view-detail" data-id="7">Xem chi tiết</button></td>
         </tr>
         <tr>
          <td>08:30, 15/01/2025</td>
          <td><span class="font-mono font-medium text-blue-600">admin</span></td>
          <td>Nguyễn Văn A</td>
          <td>Admin</td>
          <td>192.168.1.12</td>
          <td>Chrome 121</td>
          <td>Windows 10</td>
          <td><span class="status-badge status-success">✓ Thành công</span></td>
          <td><button class="action-btn view-detail" data-id="8">Xem chi tiết</button></td>
         </tr>
        </tbody>
       </table>
      </div><!-- Pagination -->
      <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50">
       <span class="text-sm text-slate-600">Hiển thị 1-8 trong 128 bản ghi</span>
       <div class="flex items-center gap-2">
        <button class="px-3 py-1 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-100 transition-colors">Trước</button> <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">1</button> <button class="px-3 py-1 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-100 transition-colors">2</button> <button class="px-3 py-1 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-100 transition-colors">3</button> <button class="px-3 py-1 border border-slate-300 rounded-lg text-sm text-slate-700 hover:bg-slate-100 transition-colors">Tiếp</button>
       </div>
      </div>
     </div>
    </main>
   </div>
  </div><!-- Detail Modal -->
  <div id="detail-modal" class="modal-overlay modal-hidden">
   <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4"><!-- Modal Header -->
    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-transparent flex items-center justify-between">
     <h2 class="text-xl font-bold text-navy-800">Chi tiết đăng nhập</h2><button id="close-detail-modal" class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg></button>
    </div><!-- Modal Body -->
    <div class="p-6 max-h-96 overflow-auto">
     <div class="detail-row"><span class="detail-label">Tài khoản</span> <span class="detail-value" id="detail-account">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Tên người dùng</span> <span class="detail-value" id="detail-username">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Vai trò</span> <span class="detail-value" id="detail-role">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Thời gian đăng nhập</span> <span class="detail-value" id="detail-time">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Địa chỉ IP</span> <span class="detail-value" id="detail-ip">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Trình duyệt</span> <span class="detail-value" id="detail-browser">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Hệ điều hành</span> <span class="detail-value" id="detail-os">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Trạng thái</span> <span class="detail-value" id="detail-status">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Vị trí</span> <span class="detail-value" id="detail-location">-</span>
     </div>
     <div class="detail-row"><span class="detail-label">Ghi chú</span> <span class="detail-value" id="detail-notes">-</span>
     </div>
    </div><!-- Modal Footer -->
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
     <button id="close-detail-btn" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors font-medium"> Đóng </button>
    </div>
   </div>
  </div>
  <script>
    // Config
    const defaultConfig = {
      page_title: 'QUẢN LÝ NHẬT KÝ ĐĂNG NHẬP',
      page_description: 'Theo dõi lịch sử đăng nhập của người dùng trong hệ thống quản lý kho.'
    };

    // Sample data
    const logsData = [
      { id: 1, account: 'admin', username: 'Nguyễn Văn A', role: 'Admin', time: '10:35, 15/01/2025', ip: '192.168.1.12', browser: 'Chrome 121', os: 'Windows 10', status: 'Thành công', location: 'TP Hồ Chí Minh', notes: 'Đăng nhập từ máy tính văn phòng' },
      { id: 2, account: 'thukho_a', username: 'Trần Thị B', role: 'Thủ kho', time: '10:22, 15/01/2025', ip: '192.168.1.45', browser: 'Firefox 121', os: 'Windows 11', status: 'Thành công', location: 'TP Hồ Chí Minh', notes: '-' },
      { id: 3, account: 'nv_01', username: 'Lê Văn C', role: 'Nhân viên', time: '10:15, 15/01/2025', ip: '192.168.1.78', browser: 'Chrome 121', os: 'MacOS', status: 'Thất bại', location: 'Hà Nội', notes: 'Mật khẩu không chính xác' },
      { id: 4, account: 'admin', username: 'Nguyễn Văn A', role: 'Admin', time: '09:50, 15/01/2025', ip: '192.168.1.12', browser: 'Chrome 121', os: 'Windows 10', status: 'Thành công', location: 'TP Hồ Chí Minh', notes: '-' },
      { id: 5, account: 'thukho_b', username: 'Phạm Minh D', role: 'Thủ kho', time: '09:25, 15/01/2025', ip: '192.168.1.56', browser: 'Safari', os: 'iOS', status: 'Thành công', location: 'Đà Nẵng', notes: 'Đăng nhập từ điện thoại' },
      { id: 6, account: 'nv_02', username: 'Vũ Thị E', role: 'Nhân viên', time: '09:10, 15/01/2025', ip: '192.168.1.89', browser: 'Chrome 121', os: 'Windows 10', status: 'Thất bại', location: 'TP Hồ Chí Minh', notes: 'Tài khoản bị khóa' },
      { id: 7, account: 'manager_01', username: 'Đỗ Văn F', role: 'Quản lý', time: '08:45, 15/01/2025', ip: '192.168.1.33', browser: 'Edge 121', os: 'Windows 11', status: 'Thành công', location: 'Hà Nội', notes: '-' },
      { id: 8, account: 'admin', username: 'Nguyễn Văn A', role: 'Admin', time: '08:30, 15/01/2025', ip: '192.168.1.12', browser: 'Chrome 121', os: 'Windows 10', status: 'Thành công', location: 'TP Hồ Chí Minh', notes: '-' }
    ];

    // Modal Management
    const detailModal = document.getElementById('detail-modal');
    const closeDetailBtn = document.getElementById('close-detail-btn');
    const closeDetailModal = document.getElementById('close-detail-modal');
    const viewDetailBtns = document.querySelectorAll('.view-detail');

    viewDetailBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const logId = parseInt(btn.dataset.id);
        const log = logsData.find(l => l.id === logId);
        if (log) {
          document.getElementById('detail-account').textContent = log.account;
          document.getElementById('detail-username').textContent = log.username;
          document.getElementById('detail-role').textContent = log.role;
          document.getElementById('detail-time').textContent = log.time;
          document.getElementById('detail-ip').textContent = log.ip;
          document.getElementById('detail-browser').textContent = log.browser;
          document.getElementById('detail-os').textContent = log.os;
          document.getElementById('detail-status').innerHTML = log.status === 'Thành công' 
            ? '<span class="status-badge status-success">✓ Thành công</span>' 
            : '<span class="status-badge status-failed">✗ Thất bại</span>';
          document.getElementById('detail-location').textContent = log.location;
          document.getElementById('detail-notes').textContent = log.notes;
          detailModal.classList.remove('modal-hidden');
          document.body.style.overflow = 'hidden';
        }
      });
    });

    closeDetailBtn.addEventListener('click', () => {
      detailModal.classList.add('modal-hidden');
      document.body.style.overflow = 'auto';
    });

    closeDetailModal.addEventListener('click', () => {
      detailModal.classList.add('modal-hidden');
      document.body.style.overflow = 'auto';
    });

    detailModal.addEventListener('click', (e) => {
      if (e.target === detailModal) {
        detailModal.classList.add('modal-hidden');
        document.body.style.overflow = 'auto';
      }
    });

    // Initialize Element SDK
    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange: async (config) => {
          document.getElementById('page-title').textContent = config.page_title || defaultConfig.page_title;
          document.getElementById('page-description').textContent = config.page_description || defaultConfig.page_description;
        },
        mapToCapabilities: () => ({
          recolorables: [],
          borderables: [],
          fontEditable: undefined,
          fontSizeable: undefined
        }),
        mapToEditPanelValues: (config) => new Map([
          ['page_title', config.page_title || defaultConfig.page_title],
          ['page_description', config.page_description || defaultConfig.page_description]
        ])
      });
    }
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9db05c1784ccddbd',t:'MTc3MzI5MjkzMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>