# 📦 Warehouse Management System (WMS)

Hệ thống **WMS** là ứng dụng web hỗ trợ quản lý kho hàng, cho phép theo dõi và kiểm soát các hoạt động **nhập kho – xuất kho – tồn kho**.
Mục tiêu của hệ thống là giúp quản lý dữ liệu kho tập trung, giảm sai sót trong quá trình vận hành và hỗ trợ theo dõi lịch sử hoạt động trong kho.

---

# 🌳 Chức năng hệ thống

```
Warehouse Management System
│
├── BangDieuKhien
│   ├── lay_hoat_dong_7_ngay.php
│   ├── lay_phan_bo_danh_muc.php
│   ├── lay_phieu_nhap_gan_day.php
│   ├── lay_phieu_xuat_gan_day.php
│   ├── lay_san_pham_sap_het.php
│   ├── lay_thong_ke_theo_quyen.php
│   └── lay_thong_ke_tong_quan.php
│
├── BaoCaoThongKe
│   ├── lay_bao_cao_nhap_xuat_ton.php
│   ├── lay_bao_cao_nha_cung_cap.php
│   ├── lay_bao_cao_phieu_nhap.php
│   ├── lay_bao_cao_phieu_xuat.php
│   ├── lay_bao_cao_san_pham.php
│   ├── lay_bao_cao_ton_kho.php
│   ├── lay_danh_sach_kho.php
│   ├── lay_danh_sach_muc.php
│   ├── lay_danh_sach_nha_cung_cap.php
│   ├── lay_thong_ke_tong_quan.php
│   └── xuat_bao_cao_excel.php
│
├── DuyetPhieuNhap
│   ├── cap_nhat_trang_thai.php
│   ├── chi_tiet_phieu_nhap.php
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_kho.php
│   └── lay_danh_sach_nha_cung_cap.php
│
├── DuyetPhieuXuat
│   ├── cap_nhat_trang_thai.php
│   ├── chi_tiet_phieu_xuat.php
│   ├── kiem_tra_ton_kho.php
│   ├── lay_danh_sach.php
│   └── lay_danh_sach_kho.php
│
├── KiemKeKho
│   ├── cap_nhat_so_luong_thuc_te.php
│   ├── hoan_thanh_kiem_ke.php
│   ├── lay_chi_tiet_phieu_kiem_ke.php
│   ├── lay_danh_sach_kho.php
│   ├── lay_danh_sach_phieu_kiem_ke.php
│   ├── lay_san_pham_theo_kho.php
│   ├── them_phieu_kiem_ke.php
│   └── xoa_phieu_kiem_ke.php
│
├── LichSuHeThong
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_hanh_dong.php
│   ├── lay_danh_sach_nguoi_dung.php
│   ├── them_lich_su.php
│   └── xoa_lich_su_cu.php
│
├── Profile
│   ├── cap_nhat_thong_tin.php
│   ├── doi_mat_khau.php
│   ├── lay_thong_tin.php
│   └── xoa_avatar.php
│
├── QuanLyDangNhap
│   ├── login_action.php
│   └── logout.php
│
├── QuanLyDanhMuc
│   ├── lay_danh_sach.php
│   ├── sua_danh_muc.php
│   ├── them_danh_muc.php
│   └── xoa_danh_muc.php
│
├── QuanLyHangHoa
│   ├── lay_danh_muc.php
│   ├── lay_danh_sach.php
│   ├── lay_kho.php
│   ├── sua_hang_hoa.php
│   ├── them_hang_hoa.php
│   └── xoa_hang_hoa.php
│
├── QuanLyKho
│   ├── chi_tiet_kho.php
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_quan_ly.php
│   ├── sua_kho.php
│   ├── them_kho.php
│   └── xoa_kho.php
│
├── QuanLyNguoiDung
│   ├── cap_nhat_nguoi_dung.php
│   ├── cap_nhat_trang_thai.php
│   ├── chi_tiet_nguoi_dung.php
│   ├── doi_mat_khau.php
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_vai_tro.php
│   ├── them_nguoi_dung.php
│   └── xoa_nguoi_dung.php
│
├── QuanLyNhaCungCap
│   ├── chi_tiet_nha_cung_cap.php
│   ├── kiem_tra_ton_tai.php
│   ├── lay_danh_sach.php
│   ├── sua_nha_cung_cap.php
│   ├── them_nha_cung_cap.php
│   └── xoa_nha_cung_cap.php
│
├── QuanLyPhieuNhap
│   ├── cap_nhat_trang_thai.php
│   ├── chi_tiet_phieu_nhap.php
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_hang_hoa.php
│   ├── lay_danh_sach_kho.php
│   ├── lay_danh_sach_nha_cung_cap.php
│   ├── them_phieu_nhap.php
│   └── xoa_phieu_nhap.php
│
├── QuanLyPhieuXuat
│   ├── cap_nhat_trang_thai.php
│   ├── chi_tiet_phieu_xuat.php
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_hang_hoa.php
│   ├── lay_danh_sach_kho.php
│   └── them_phieu_xuat.php
│
├── QuanLyVaiTro
│   ├── cap_nhat_trang_thai.php
│   ├── cap_nhat_vai_tro.php
│   ├── chi_tiet_vai_tro.php
│   ├── lay_danh_sach.php
│   ├── lay_danh_sach_quyen.php
│   ├── them_vai_tro.php
│   └── xoa_vai_tro.php
│
└── TonKho
    ├── cap_nhat_ton_toi_thieu.php
    ├── chi_tiet_ton_kho.php
    ├── lay_danh_sach.php
    ├── lay_danh_sach_kho.php
    ├── lay_danh_sach_muc.php
    └── xuat_bao_cao.php
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
