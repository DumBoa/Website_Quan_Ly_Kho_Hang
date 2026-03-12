# 📦 Warehouse Management System (WMS)

Hệ thống **WMS** là ứng dụng web hỗ trợ quản lý kho hàng, cho phép theo dõi và kiểm soát các hoạt động **nhập kho – xuất kho – tồn kho**.
Mục tiêu của hệ thống là giúp quản lý dữ liệu kho tập trung, giảm sai sót trong quá trình vận hành và hỗ trợ theo dõi lịch sử hoạt động trong kho.

---

# 🌳 Chức năng hệ thống

```
Warehouse Management System
│
├── Dashboard
│   ├── Thống kê sản phẩm
│   ├── Thống kê phiếu nhập
│   ├── Thống kê phiếu xuất
│   └── Hoạt động gần đây
│
├── Quản lý danh mục
│   ├── Thêm danh mục
│   ├── Cập nhật danh mục
│   ├── Xóa danh mục
│   └── Danh sách danh mục
│
├── Quản lý sản phẩm
│   ├── Thêm sản phẩm
│   ├── Cập nhật sản phẩm
│   ├── Xóa sản phẩm
│   └── Danh sách sản phẩm
│
├── Quản lý nhà cung cấp
│   ├── Thêm nhà cung cấp
│   ├── Cập nhật nhà cung cấp
│   ├── Xóa nhà cung cấp
│   └── Danh sách nhà cung cấp
│
├── Quản lý phiếu nhập
│   ├── Tạo phiếu nhập
│   ├── Duyệt phiếu nhập
│   ├── Chi tiết phiếu nhập
│   └── Danh sách phiếu nhập
│
├── Quản lý phiếu xuất
│   ├── Tạo phiếu xuất
│   ├── Duyệt phiếu xuất
│   ├── Chi tiết phiếu xuất
│   └── Danh sách phiếu xuất
│
├── Kiểm kê kho
│   ├── Tạo phiếu kiểm kê
│   ├── So sánh tồn kho
│   └── Cập nhật chênh lệch
│
└── Lịch sử hệ thống
    ├── Ghi nhận hoạt động
    └── Theo dõi thay đổi dữ liệu
```

---

# 🧑‍💻 Phân quyền người dùng

```
Người dùng hệ thống
│
├── Administrator
│   ├── Quản lý toàn bộ hệ thống
│   ├── Quản lý người dùng
│   ├── Duyệt phiếu nhập
│   ├── Duyệt phiếu xuất
│   └── Theo dõi lịch sử hệ thống
│
└── User
    ├── Tạo phiếu nhập
    ├── Tạo phiếu xuất
    ├── Xem tồn kho
    └── Xem danh sách sản phẩm
```

---

# 🧱 Công nghệ sử dụng

```
Technology Stack
│
├── Backend
│   └── PHP
│
├── Database
│   └── Mysql
│
├── Frontend
│   ├── HTML
│   ├── CSS
│   └── JavaScript
│
└── Architecture
    └── Structure by Feature + Action-based
```

---

# 📁 Cấu trúc mã nguồn

```
project-root
│
├── actions
│   ├── DanhMuc
│   ├── SanPham
│   ├── NhaCungCap
│   ├── PhieuNhap
│   ├── PhieuXuat
│   └── BangDieuKhien
│
├── views
│   ├── DanhMuc
│   ├── SanPham
│   ├── NhaCungCap
│   ├── PhieuNhap
│   ├── PhieuXuat
│   └── Dashboard
│
├── assets
│   ├── css
│   ├── js
│   └── images
│
├── config
│   └── database.php
│
└── index.php
```

---

# 🎯 Mục tiêu hệ thống

```
Mục tiêu
│
├── Quản lý dữ liệu kho tập trung
├── Kiểm soát nhập xuất hàng hóa
├── Giảm sai sót trong quản lý thủ công
└── Theo dõi lịch sử hoạt động rõ ràng
```
