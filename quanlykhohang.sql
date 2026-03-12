-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 12, 2026 lúc 09:41 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlykhohang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_kiem_ke`
--

CREATE TABLE `chi_tiet_kiem_ke` (
  `ma_chi_tiet` int(11) NOT NULL,
  `ma_phieu_kiem_ke` int(11) DEFAULT NULL,
  `ma_hang_hoa` int(11) DEFAULT NULL,
  `so_luong_he_thong` int(11) DEFAULT NULL COMMENT 'so luong tren he thong',
  `so_luong_thuc_te` int(11) DEFAULT NULL COMMENT 'so luong thuc te',
  `chenh_lech` int(11) DEFAULT NULL COMMENT 'so luong chenh lech'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_kiem_ke`
--

INSERT INTO `chi_tiet_kiem_ke` (`ma_chi_tiet`, `ma_phieu_kiem_ke`, `ma_hang_hoa`, `so_luong_he_thong`, `so_luong_thuc_te`, `chenh_lech`) VALUES
(27, 3, 1, 45, 45, 0),
(28, 3, 2, 32, 32, 0),
(29, 3, 3, 18, 18, 0),
(30, 3, 6, 88, 88, 0),
(31, 3, 8, 15, 15, 0),
(32, 3, 10, 200, 200, 0),
(33, 3, 11, 0, 0, 0),
(34, 3, 12, 300, 300, 0),
(35, 3, 4, 1, 1, 0),
(36, 3, 42, 100, 100, 0),
(37, 3, 38, 9, 9, 0),
(38, 3, 5, 1, 9, 0),
(39, 3, 45, 100, 100, 0),
(53, 5, 7, 22, 22, 0),
(54, 6, 1, 45, 45, 0),
(55, 6, 2, 32, 32, 0),
(56, 6, 3, 18, 18, 0),
(57, 6, 6, 88, 88, 0),
(58, 6, 8, 15, 15, 0),
(59, 6, 10, 200, 200, 0),
(60, 6, 11, 0, 0, 0),
(61, 6, 12, 300, 300, 0),
(62, 6, 4, 1, 1, 0),
(63, 6, 42, 100, 100, 0),
(64, 6, 38, 9, 9, 0),
(65, 6, 5, 1, 1, 0),
(66, 6, 45, 100, 100, 0),
(67, 7, 1, 45, 45, 0),
(68, 7, 2, 32, 32, 0),
(69, 7, 3, 18, 18, 0),
(70, 7, 6, 88, 88, 0),
(71, 7, 8, 15, 15, 0),
(72, 7, 10, 200, 200, 0),
(73, 7, 11, 0, 0, 0),
(74, 7, 12, 300, 300, 0),
(75, 7, 4, 1, 1, 0),
(76, 7, 42, 100, 100, 0),
(77, 7, 38, 9, 9, 0),
(78, 7, 5, 1, 1, 0),
(79, 7, 45, 100, 100, 0),
(80, 8, 1, 45, 45, 0),
(81, 8, 2, 32, 32, 0),
(82, 8, 3, 18, 18, 0),
(83, 8, 6, 88, 88, 0),
(84, 8, 8, 15, 15, 0),
(85, 8, 10, 200, 200, 0),
(86, 8, 11, 0, 0, 0),
(87, 8, 12, 300, 300, 0),
(88, 8, 4, 1, 1, 0),
(89, 8, 42, 100, 100, 0),
(90, 8, 38, 9, 9, 0),
(91, 8, 5, 1, 1, 0),
(92, 8, 45, 100, 100, 0),
(93, 9, 17, 20, 20, 0),
(94, 10, 1, 45, 45, 0),
(95, 10, 2, 32, 32, 0),
(96, 10, 3, 18, 18, 0),
(97, 10, 6, 88, 88, 0),
(98, 10, 8, 15, 15, 0),
(99, 10, 10, 200, 200, 0),
(100, 10, 11, 0, 0, 0),
(101, 10, 12, 300, 300, 0),
(102, 10, 4, 1, 1, 0),
(103, 10, 42, 100, 100, 0),
(104, 10, 38, 9, 9, 0),
(105, 10, 5, 1, 1, 0),
(106, 10, 45, 100, 100, 0),
(107, 11, 1, 45, 45, 0),
(108, 11, 2, 32, 32, 0),
(109, 11, 3, 18, 18, 0),
(110, 11, 6, 88, 88, 0),
(111, 11, 8, 15, 15, 0),
(112, 11, 10, 200, 200, 0),
(113, 11, 11, 0, 0, 0),
(114, 11, 12, 300, 300, 0),
(115, 11, 4, 1, 1, 0),
(116, 11, 42, 100, 100, 0),
(117, 11, 38, 9, 9, 0),
(118, 11, 5, 1, 1, 0),
(119, 11, 45, 100, 100, 0),
(120, 12, 1, 45, 45, 0),
(121, 12, 2, 32, 32, 0),
(122, 12, 3, 18, 18, 0),
(123, 12, 6, 88, 88, 0),
(124, 12, 8, 15, 15, 0),
(125, 12, 10, 200, 200, 0),
(126, 12, 11, 0, 0, 0),
(127, 12, 12, 300, 300, 0),
(128, 12, 4, 1, 1, 0),
(129, 12, 42, 100, 100, 0),
(130, 12, 38, 9, 9, 0),
(131, 12, 5, 1, 1, 0),
(132, 12, 45, 100, 100, 0),
(133, 13, 1, 45, 45, 0),
(134, 13, 2, 32, 32, 0),
(135, 13, 3, 18, 18, 0),
(136, 13, 6, 88, 88, 0),
(137, 13, 8, 15, 15, 0),
(138, 13, 10, 200, 200, 0),
(139, 13, 11, 0, 0, 0),
(140, 13, 12, 300, 300, 0),
(141, 13, 4, 1, 1, 0),
(142, 13, 42, 100, 100, 0),
(143, 13, 38, 9, 9, 0),
(144, 13, 5, 1, 1, 0),
(145, 13, 45, 100, 100, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_phieu_nhap`
--

CREATE TABLE `chi_tiet_phieu_nhap` (
  `ma_chi_tiet` int(11) NOT NULL,
  `ma_phieu_nhap` int(11) DEFAULT NULL,
  `ma_hang_hoa` int(11) DEFAULT NULL,
  `so_luong` int(11) NOT NULL,
  `gia_nhap` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_phieu_nhap`
--

INSERT INTO `chi_tiet_phieu_nhap` (`ma_chi_tiet`, `ma_phieu_nhap`, `ma_hang_hoa`, `so_luong`, `gia_nhap`) VALUES
(1, 1, 1, 30, 21000000.00),
(2, 1, 3, 15, 13200000.00),
(3, 1, 6, 50, 750000.00),
(4, 2, 4, 100, 850000.00),
(5, 2, 5, 40, 1800000.00),
(6, 2, 10, 150, 550000.00),
(10, 6, 5, 1, 1850000.00),
(11, 6, 10, 1, 580000.00),
(12, 6, 8, 1, 1450000.00),
(13, 6, 9, 1, 450000.00),
(14, 6, 7, 1, 3200000.00),
(15, 6, 12, 1, 100000000.00),
(16, 6, 4, 19, 890000.00),
(17, 6, 4, 19, 890000.00),
(18, 7, 12, 7, 100000000.00),
(19, 7, 4, 3, 890000.00),
(20, 7, 6, 1, 790000.00),
(21, 7, 1, 3, 21500000.00),
(22, 7, 9, 2, 450000.00),
(23, 7, 8, 17, 1450000.00),
(24, 7, 7, 5, 3200000.00),
(25, 7, 2, 2, 18990000.00),
(26, 7, 10, 1, 580000.00),
(27, 7, 10, 1, 580000.00),
(29, 9, 5, 1, 1850000.00),
(30, 10, 17, 1, 10500000.00),
(31, 11, 15, 1, 6200000.00),
(32, 12, 5, 1, 1850000.00),
(33, 13, 5, 5, 1850000.00),
(34, 14, 42, 1, 1850000.00),
(35, 15, 38, 10, 2450000.00),
(36, 16, 5, 1, 1850000.00),
(37, 17, 5, 1, 1850000.00),
(38, 18, 5, 4, 1850000.00),
(39, 19, 6, 5, 790000.00),
(40, 19, 6, 5, 790000.00),
(41, 20, 4, 9, 890000.00),
(42, 21, 12, 100, 100000000.00),
(43, 22, 17, 20, 10500000.00),
(44, 23, 15, 10, 6200000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_phieu_xuat`
--

CREATE TABLE `chi_tiet_phieu_xuat` (
  `ma_chi_tiet` int(11) NOT NULL,
  `ma_phieu_xuat` int(11) DEFAULT NULL,
  `ma_hang_hoa` int(11) DEFAULT NULL,
  `so_luong` int(11) NOT NULL,
  `gia_xuat` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_phieu_xuat`
--

INSERT INTO `chi_tiet_phieu_xuat` (`ma_chi_tiet`, `ma_phieu_xuat`, `ma_hang_hoa`, `so_luong`, `gia_xuat`) VALUES
(1, 1, 5, 1, 2490000.00),
(2, 2, 5, 4, 2490000.00),
(3, 3, 5, 1, 2490000.00),
(4, 4, 38, 1, 3190000.00),
(5, 5, 4, 20, 1190000.00),
(6, 6, 6, 20, 990000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc`
--

CREATE TABLE `danh_muc` (
  `ma_danh_muc` int(11) NOT NULL,
  `ten_danh_muc` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `trang_thai` tinyint(4) DEFAULT 1 COMMENT '1 hoat dong, 0 ngung hoat dong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc`
--

INSERT INTO `danh_muc` (`ma_danh_muc`, `ten_danh_muc`, `mo_ta`, `ngay_tao`, `trang_thai`) VALUES
(1, 'Điện thoại & Máy tính bảng', 'Các sản phẩm di động và tablet', '2026-03-02 13:18:10', 1),
(2, 'Máy tính & Laptop', 'Máy tính để bàn, laptop các loại', '2026-03-02 13:18:10', 1),
(3, 'Phụ kiện máy tính', 'Chuột, bàn phím, tai nghe, cáp...', '2026-03-02 13:18:10', 1),
(4, 'Đồ gia dụng thông minh', 'Máy lọc không khí, đèn thông minh', '2026-03-02 13:18:10', 1),
(5, 'Thiết bị mạng', 'Router, switch, access point', '2026-03-02 13:18:10', 1),
(6, 'Camera & An ninh', 'Camera IP, chuông cửa, cảm biến', '2026-03-02 13:18:10', 1),
(7, 'Thiết bị văn phòng', 'Máy in, máy scan, giấy in', '2026-03-02 13:18:10', 1),
(8, 'Dụng cụ cầm tay', 'Khoan, mài, cưa, tua vít...', '2026-03-02 13:18:10', 1),
(9, 'Vật tư tiêu hao', 'Pin, bóng đèn, mực in', '2026-03-02 13:18:10', 1),
(10, 'Sản phẩm khác', 'Hàng hóa linh tinh không phân loại', '2026-03-02 13:18:10', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hang_hoa`
--

CREATE TABLE `hang_hoa` (
  `ma_hang_hoa` int(11) NOT NULL,
  `ma_san_pham` varchar(50) NOT NULL,
  `ten_hang_hoa` varchar(150) NOT NULL,
  `ma_danh_muc` int(11) DEFAULT NULL,
  `ma_nha_cung_cap` int(11) DEFAULT NULL,
  `don_vi_tinh` varchar(50) DEFAULT NULL,
  `gia_nhap` decimal(15,2) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT 1 COMMENT '1 dang kinh doanh, 0 ngung kinh doanh',
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gia_ban` int(11) NOT NULL DEFAULT 0,
  `ton_toi_thieu` int(11) DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hang_hoa`
--

INSERT INTO `hang_hoa` (`ma_hang_hoa`, `ma_san_pham`, `ten_hang_hoa`, `ma_danh_muc`, `ma_nha_cung_cap`, `don_vi_tinh`, `gia_nhap`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`, `gia_ban`, `ton_toi_thieu`) VALUES
(1, 'SP001', 'iPhone 14 Pro 128GB', 1, 1, 'Chiếc', 21500000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 25990000, 5),
(2, 'SP002', 'Samsung Galaxy S23 Ultra', 1, 2, 'Chiếc', 18990000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 21990000, 5),
(3, 'SP003', 'Laptop Dell Inspiron 15 3520', 2, 4, 'Chiếc', 13500000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 15990000, 5),
(4, 'SP004', 'Chuột Logitech G304 Lightspeed', 3, 3, 'Cái', 890000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 1190000, 5),
(5, 'SP005', 'Bàn phím cơ Keychron K8', 3, 5, 'Cái', 1850000.00, 0, '2026-03-02 13:18:10', '2026-03-08 16:38:46', 2490000, 5),
(6, 'SP006', 'Camera IP Xiaomi 360 2K', 6, 5, 'Chiếc', 790000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 990000, 5),
(7, 'SP007', 'Máy in HP LaserJet Pro MFP M28w', 7, 7, 'Chiếc', 3200000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 3990000, 5),
(8, 'SP008', 'Máy khoan cầm tay Bosch GSB 550', 8, 9, 'Chiếc', 1450000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 1890000, 5),
(9, 'SP009', 'Mực in Canon 2900/3000', 9, 8, 'Hộp', 450000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 590000, 5),
(10, 'SP010', 'Pin dự phòng Xiaomi 20000mAh', 3, 5, 'Cái', 580000.00, 1, '2026-03-02 13:18:10', '2026-03-08 11:17:10', 790000, 5),
(11, 'SP-0011', 'Sản Phẩm Test', 3, NULL, NULL, 1020000.00, 0, '2026-03-06 12:40:45', '2026-03-08 11:17:10', 1200000, 5),
(12, 'SP-11', 'I Phân 20', 1, NULL, NULL, 100000000.00, 1, '2026-03-06 18:21:42', '2026-03-08 11:17:10', 120000000, 5),
(13, 'SP000012', 'Điện thoại iPhone 16 128GB', 8, 2, 'Chiếc', 18500000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 22990000, 5),
(14, 'SP000013', 'Điện thoại Samsung Galaxy S25 Ultra', 8, 7, 'Chiếc', 28500000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 34990000, 5),
(15, 'SP000014', 'Tai nghe True Wireless AirPods Pro 2', 8, 1, 'Chiếc', 6200000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 7990000, 5),
(16, 'SP000015', 'Tai nghe Bluetooth Sony WH-1000XM5', 8, 5, 'Chiếc', 8500000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 9990000, 5),
(17, 'SP000016', 'Smartwatch Apple Watch Series 10', 8, 3, 'Chiếc', 10500000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 12990000, 5),
(18, 'SP000017', 'Đồng hồ thông minh Samsung Galaxy Watch 7', 8, 8, 'Chiếc', 7200000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 8990000, 5),
(19, 'SP000018', 'Máy tính bảng iPad Air M2 11 inch', 8, 4, 'Chiếc', 14800000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 17990000, 5),
(20, 'SP000019', 'Laptop Asus Vivobook 15 OLED', 8, 6, 'Chiếc', 13500000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 16990000, 5),
(21, 'SP000020', 'Pin sạc dự phòng Xiaomi 20000mAh 33W', 8, 9, 'Chiếc', 450000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 690000, 5),
(22, 'SP000021', 'Cáp sạc nhanh Type-C 100W Baseus', 8, 10, 'Chiếc', 280000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 390000, 5),
(23, 'SP000022', 'Ốp lưng iPhone 16 Pro Max Spigen', 8, 2, 'Chiếc', 450000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 590000, 5),
(24, 'SP000023', 'Kính cường lực Samsung Galaxy S25', 8, 7, 'Chiếc', 180000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 249000, 5),
(25, 'SP000024', 'Robot hút bụi Xiaomi Mi Robot Vacuum X20+', 9, 1, 'Chiếc', 10500000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 13990000, 5),
(26, 'SP000025', 'Máy lọc không khí Xiaomi Air Purifier 4', 9, 5, 'Chiếc', 3800000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 4990000, 5),
(27, 'SP000026', 'Nồi chiên không dầu Philips HD9270 6.2L', 9, 3, 'Chiếc', 3200000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 3990000, 5),
(28, 'SP000027', 'Máy xay sinh tố đa năng Bear 1.5L', 9, 8, 'Chiếc', 850000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 1190000, 5),
(29, 'SP000028', 'Bếp từ đôi Sunhouse SHB9108MT', 9, 4, 'Chiếc', 2450000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 2990000, 5),
(30, 'SP000029', 'Máy giặt cửa trên LG 10kg Inverter', 9, 6, 'Chiếc', 7800000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 9490000, 5),
(31, 'SP000030', 'Tủ lạnh Toshiba Inverter 180L', 9, 9, 'Chiếc', 6200000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 7990000, 5),
(32, 'SP000031', 'Quạt điều hòa Midea 120W', 9, 10, 'Chiếc', 3800000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 4990000, 5),
(33, 'SP000032', 'Đèn LED thông minh Philips Hue', 9, 2, 'Bộ 3 bóng', 2850000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 3790000, 5),
(34, 'SP000033', 'Công tắc thông minh Lumi không dây', 9, 7, 'Chiếc', 450000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 590000, 5),
(35, 'SP000034', 'Camera an ninh Xiaomi 360° 2K', 9, 1, 'Chiếc', 850000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 1090000, 5),
(36, 'SP000035', 'Loa Bluetooth JBL Flip 6', 8, 5, 'Chiếc', 2800000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 3490000, 5),
(37, 'SP000036', 'Tai nghe gaming Razer BlackShark V2', 8, 3, 'Chiếc', 1850000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 2390000, 5),
(38, 'SP000037', 'Bàn phím cơ Keychron K8 Pro', 8, 8, 'Chiếc', 2450000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 3190000, 5),
(39, 'SP000038', 'Chuột không dây Logitech MX Master 3S', 8, 4, 'Chiếc', 2800000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 3490000, 5),
(40, 'SP000039', 'Máy in Brother DCP-T720DW', 8, 6, 'Chiếc', 5200000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 6490000, 5),
(41, 'SP000040', 'Ổ cứng SSD Samsung 990 PRO 1TB', 8, 9, 'Chiếc', 2850000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 3490000, 5),
(42, 'SP000041', 'RAM Laptop Kingston 16GB DDR5 4800MHz', 8, 10, 'Thanh', 1850000.00, 1, '2026-03-07 21:44:43', '2026-03-08 11:17:10', 2390000, 5),
(45, 'SP-11111111', 'RAM L', 8, NULL, NULL, 20124.00, 1, '2026-03-09 14:25:32', '2026-03-09 14:28:50', 0, 5);

--
-- Bẫy `hang_hoa`
--
DELIMITER $$
CREATE TRIGGER `after_delete_hang_hoa` AFTER DELETE ON `hang_hoa` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc)
    VALUES (
        user_id,
        'Xóa sản phẩm',
        'hang_hoa',
        OLD.ma_hang_hoa,
        CONCAT('Xóa sản phẩm: ', OLD.ten_hang_hoa, ' (', OLD.ma_san_pham, ')'),
        user_ip,
        JSON_OBJECT('ma_san_pham', OLD.ma_san_pham, 'ten', OLD.ten_hang_hoa, 'gia_nhap', OLD.gia_nhap)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_hang_hoa` AFTER INSERT ON `hang_hoa` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_sau)
    VALUES (
        user_id,
        'Thêm sản phẩm',
        'hang_hoa',
        NEW.ma_hang_hoa,
        CONCAT('Thêm sản phẩm mới: ', NEW.ten_hang_hoa, ' (', NEW.ma_san_pham, ')'),
        user_ip,
        JSON_OBJECT('ma_san_pham', NEW.ma_san_pham, 'ten', NEW.ten_hang_hoa, 'gia_nhap', NEW.gia_nhap)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_hang_hoa` AFTER UPDATE ON `hang_hoa` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc, du_lieu_sau)
    VALUES (
        user_id,
        'Cập nhật sản phẩm',
        'hang_hoa',
        NEW.ma_hang_hoa,
        CONCAT('Cập nhật sản phẩm: ', NEW.ten_hang_hoa),
        user_ip,
        JSON_OBJECT('ten', OLD.ten_hang_hoa, 'gia_nhap', OLD.gia_nhap, 'trang_thai', OLD.trang_thai),
        JSON_OBJECT('ten', NEW.ten_hang_hoa, 'gia_nhap', NEW.gia_nhap, 'trang_thai', NEW.trang_thai)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho`
--

CREATE TABLE `kho` (
  `ma_kho` int(11) NOT NULL,
  `ten_kho` varchar(150) NOT NULL,
  `dia_chi` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `nguoi_quan_ly` int(11) DEFAULT NULL COMMENT 'ma nguoi dung quan ly kho',
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `suc_chua` int(11) DEFAULT NULL COMMENT 'suc chua toi da',
  `tong_san_pham` int(11) DEFAULT 0 COMMENT 'tong san pham hien co',
  `trang_thai` tinyint(4) DEFAULT 1 COMMENT '1 hoat dong, 0 ngung hoat dong',
  `mo_ta` text DEFAULT NULL COMMENT 'mo ta chi tiet ve kho'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `kho`
--

INSERT INTO `kho` (`ma_kho`, `ten_kho`, `dia_chi`, `ngay_tao`, `nguoi_quan_ly`, `so_dien_thoai`, `suc_chua`, `tong_san_pham`, `trang_thai`, `mo_ta`) VALUES
(1, 'Kho chính Hà Nội', 'KCN Bắc Thăng Long, Đông Anh, Hà Nội', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(2, 'Kho TP.HCM', 'KCN Tân Bình, TP.HCM', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(3, 'Kho Đà Nẵng', 'KCN Hòa Khánh, Đà Nẵng', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(4, 'Kho dự trữ phụ kiện', 'Cầu Giấy, Hà Nội', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(5, 'Kho hàng gia dụng', 'Q.7, TP.HCM', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(6, 'Kho thiết bị văn phòng', 'Hoàng Mai, Hà Nội', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(7, 'Kho linh kiện cũ', 'Bắc Ninh', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(8, 'Kho tạm nhập', 'Long Biên, Hà Nội', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(9, 'Kho xuất khẩu', 'Bình Dương', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(10, 'Kho kiểm kê', 'Thanh Xuân, Hà Nội', '2026-03-02 13:18:10', NULL, NULL, NULL, 0, 1, NULL),
(11, 'Kho test', 'HA NOI', '2026-03-06 21:21:51', 0, '451787321214', 5000, 0, 1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lich_su_he_thong`
--

CREATE TABLE `lich_su_he_thong` (
  `ma_lich_su` int(11) NOT NULL,
  `ma_nguoi_dung` int(11) DEFAULT NULL,
  `hanh_dong` varchar(255) NOT NULL,
  `doi_tuong` varchar(100) DEFAULT NULL,
  `ma_doi_tuong` varchar(50) DEFAULT NULL,
  `chi_tiet` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `trang_thai` varchar(20) DEFAULT 'success',
  `du_lieu_truoc` longtext DEFAULT NULL,
  `du_lieu_sau` longtext DEFAULT NULL,
  `thoi_gian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lich_su_he_thong`
--

INSERT INTO `lich_su_he_thong` (`ma_lich_su`, `ma_nguoi_dung`, `hanh_dong`, `doi_tuong`, `ma_doi_tuong`, `chi_tiet`, `ip`, `trang_thai`, `du_lieu_truoc`, `du_lieu_sau`, `thoi_gian`) VALUES
(4, NULL, 'Thêm sản phẩm', 'hang_hoa', '45', 'Thêm sản phẩm mới: RAM L (SP-11111111)', '::1', 'success', NULL, '{\"ma_san_pham\": \"SP-11111111\", \"ten\": \"RAM L\", \"gia_nhap\": 100.00}', '2026-03-09 14:25:32'),
(5, NULL, 'Cập nhật sản phẩm', 'hang_hoa', '45', 'Cập nhật sản phẩm: RAM L', '::1', 'success', '{\"ten\": \"RAM L\", \"gia_nhap\": 100.00, \"trang_thai\": 1}', '{\"ten\": \"RAM L\", \"gia_nhap\": 100.00, \"trang_thai\": 1}', '2026-03-09 14:25:54'),
(6, NULL, 'Cập nhật tồn kho', 'ton_kho', '17', 'Cập nhật tồn kho: +80 sản phẩm (Mã kho: 1, Mã hàng: 45)', '::1', 'success', '{\"so_luong_cu\": 20}', '{\"so_luong_moi\": 100, \"chenh_lech\": \"80\"}', '2026-03-09 14:25:54'),
(7, NULL, 'Cập nhật sản phẩm', 'hang_hoa', '45', 'Cập nhật sản phẩm: RAM L', '::1', 'success', '{\"ten\": \"RAM L\", \"gia_nhap\": 100.00, \"trang_thai\": 1}', '{\"ten\": \"RAM L\", \"gia_nhap\": 20124.00, \"trang_thai\": 1}', '2026-03-09 14:28:50'),
(8, NULL, 'Cập nhật sản phẩm', 'hang_hoa', '45', 'Cập nhật sản phẩm: RAM L', '::1', 'success', '{\"ten\": \"RAM L\", \"gia_nhap\": 20124.00, \"trang_thai\": 1}', '{\"ten\": \"RAM L\", \"gia_nhap\": 20124.00, \"trang_thai\": 1}', '2026-03-09 14:29:41'),
(9, 11, 'Cập nhật người dùng', 'nguoi_dung', '11', 'Cập nhật thông tin người dùng: Đào Huy Hoàng', '::1', 'success', '{\"ho_ten\": \"Đào Huy Hoàng\", \"email\": \"hoanglc645@gmail.com\", \"trang_thai\": 1}', '{\"ho_ten\": \"Đào Huy Hoàng\", \"email\": \"hoanglc645@gmail.com\", \"trang_thai\": 1}', '2026-03-09 18:51:12'),
(10, 11, 'Cập nhật hồ sơ cá nhân', 'nguoi_dung', '11', 'Cập nhật thông tin cá nhân', '::1', 'success', NULL, NULL, '2026-03-09 18:51:12'),
(11, 11, 'Cập nhật người dùng', 'nguoi_dung', '11', 'Cập nhật thông tin người dùng: Đào Huy Hoàng', '::1', 'success', '{\"ho_ten\": \"Đào Huy Hoàng\", \"email\": \"hoanglc645@gmail.com\", \"trang_thai\": 1}', '{\"ho_ten\": \"Đào Huy Hoàng\", \"email\": \"hoanglc645@gmail.com\", \"trang_thai\": 1}', '2026-03-09 18:51:29'),
(12, 11, 'Cập nhật hồ sơ cá nhân', 'nguoi_dung', '11', 'Cập nhật thông tin cá nhân', '::1', 'success', NULL, NULL, '2026-03-09 18:51:29'),
(13, 11, 'Cập nhật người dùng', 'nguoi_dung', '11', 'Cập nhật thông tin người dùng: Đào Huy Hoàng', '::1', 'success', '{\"ho_ten\": \"Đào Huy Hoàng\", \"email\": \"hoanglc645@gmail.com\", \"trang_thai\": 1}', '{\"ho_ten\": \"Đào Huy Hoàng\", \"email\": \"hoanglc645@gmail.com\", \"trang_thai\": 1}', '2026-03-09 21:23:35'),
(14, NULL, 'Cập nhật sản phẩm', 'hang_hoa', '45', 'Cập nhật sản phẩm: RAM L', '::1', 'success', '{\"ten\": \"RAM L\", \"gia_nhap\": 20124.00, \"trang_thai\": 1}', '{\"ten\": \"RAM L\", \"gia_nhap\": 20124.00, \"trang_thai\": 1}', '2026-03-09 21:24:01'),
(15, 11, 'Tạo phiếu xuất', 'phieu_xuat', '5', 'Tạo phiếu xuất: PX005 - 1 mặt hàng, tổng: 23800000.00', '::1', 'success', NULL, '{\"ma_kho\": 2, \"tong_so_luong\": 20, \"tong_gia_tri\": 23800000.00}', '2026-03-09 21:46:37'),
(16, 11, 'Cập nhật tồn kho', 'ton_kho', '4', 'Cập nhật tồn kho: -20 sản phẩm (Mã kho: 2, Mã hàng: 4)', '::1', 'success', '{\"so_luong_cu\": 120}', '{\"so_luong_moi\": 100, \"chenh_lech\": \"-20\"}', '2026-03-09 21:46:37'),
(17, 11, 'Cập nhật trạng thái phiếu xuất: Đã duyệt', 'phieu_xuat', '5', 'Phiếu xuất PX005 chuyển từ trạng thái 0 sang 1', '::1', 'success', '{\"trang_thai_cu\": 0}', '{\"trang_thai_moi\": 1}', '2026-03-09 21:47:01'),
(18, 11, 'Tạo phiếu nhập', 'phieu_nhap', '20', 'Tạo phiếu nhập: PN020 - 1 mặt hàng, tổng: 8010000.00', '::1', 'success', NULL, '{\"ma_kho\": 2, \"tong_so_luong\": 9, \"tong_tien\": 8010000.00}', '2026-03-09 22:00:04'),
(19, 11, 'Cập nhật tồn kho', 'ton_kho', '4', 'Cập nhật tồn kho: +9 sản phẩm (Mã kho: 2, Mã hàng: 4)', '::1', 'success', '{\"so_luong_cu\": 100}', '{\"so_luong_moi\": 109, \"chenh_lech\": \"9\"}', '2026-03-09 22:00:22'),
(20, 11, 'Cập nhật trạng thái phiếu nhập: Đã duyệt', 'phieu_nhap', '20', 'Phiếu nhập PN020 chuyển từ trạng thái 0 sang 1', '::1', 'success', '{\"trang_thai_cu\": 0}', '{\"trang_thai_moi\": 1}', '2026-03-09 22:00:22'),
(21, 11, 'Tạo phiếu nhập', 'phieu_nhap', '21', 'Tạo phiếu nhập: PN021 - 1 mặt hàng, tổng: 10000000000.00', '::1', 'success', NULL, '{\"ma_kho\": 1, \"tong_so_luong\": 100, \"tong_tien\": 10000000000.00}', '2026-03-09 22:03:58'),
(22, 11, 'Cập nhật tồn kho', 'ton_kho', '12', 'Cập nhật tồn kho: +100 sản phẩm (Mã kho: 1, Mã hàng: 12)', '::1', 'success', '{\"so_luong_cu\": 200}', '{\"so_luong_moi\": 300, \"chenh_lech\": \"100\"}', '2026-03-09 22:04:10'),
(23, 11, 'Cập nhật trạng thái phiếu nhập: Đã duyệt', 'phieu_nhap', '21', 'Phiếu nhập PN021 chuyển từ trạng thái 0 sang 1', '::1', 'success', '{\"trang_thai_cu\": 0}', '{\"trang_thai_moi\": 1}', '2026-03-09 22:04:10'),
(24, 11, 'Tạo phiếu nhập', 'phieu_nhap', '22', 'Tạo phiếu nhập: PN022 - 1 mặt hàng, tổng: 210000000.00', '::1', 'success', NULL, '{\"ma_kho\": 11, \"tong_so_luong\": 20, \"tong_tien\": 210000000.00}', '2026-03-10 07:40:53'),
(25, 11, 'Cập nhật trạng thái phiếu nhập: Đã duyệt', 'phieu_nhap', '22', 'Phiếu nhập PN022 chuyển từ trạng thái 0 sang 1', '::1', 'success', '{\"trang_thai_cu\": 0}', '{\"trang_thai_moi\": 1}', '2026-03-10 07:41:13'),
(26, 11, 'Cập nhật người dùng', 'nguoi_dung', '2', 'Cập nhật thông tin người dùng: Hoàng Thủ Kho', '::1', 'success', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 0}', '2026-03-10 07:59:54'),
(27, 11, 'Cập nhật người dùng', 'nguoi_dung', '2', 'Cập nhật thông tin người dùng: Hoàng Thủ Kho', '::1', 'success', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 0}', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '2026-03-10 08:00:01'),
(28, NULL, 'Cập nhật người dùng', 'nguoi_dung', '2', 'Cập nhật thông tin người dùng: Hoàng Thủ Kho', NULL, 'success', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '2026-03-10 08:01:55'),
(29, NULL, 'Cập nhật người dùng', 'nguoi_dung', '2', 'Cập nhật thông tin người dùng: Hoàng Thủ Kho', '::1', 'success', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '2026-03-10 08:21:22'),
(30, 11, 'Tạo phiếu nhập', 'phieu_nhap', '23', 'Tạo phiếu nhập: PN023 - 1 mặt hàng, tổng: 62000000.00', '::1', 'success', NULL, '{\"ma_kho\": 10, \"tong_so_luong\": 10, \"tong_tien\": 62000000.00}', '2026-03-10 09:06:56'),
(31, 11, 'Cập nhật trạng thái phiếu nhập: Đã duyệt', 'phieu_nhap', '23', 'Phiếu nhập PN023 chuyển từ trạng thái 0 sang 1', '::1', 'success', '{\"trang_thai_cu\": 0}', '{\"trang_thai_moi\": 1}', '2026-03-10 09:07:09'),
(32, 11, 'Xóa người dùng', 'nguoi_dung', '8', 'Xóa người dùng: Ngô Văn Long (nhanvien03)', '::1', 'success', '{\"ho_ten\": \"Ngô Văn Long\", \"ten_dang_nhap\": \"nhanvien03\", \"email\": \"nv03@company.vn\"}', NULL, '2026-03-10 09:45:37'),
(33, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '1', 'Tạo phiếu kiểm kê KK-001', '::1', 'success', NULL, NULL, '2026-03-10 11:08:29'),
(34, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '2', 'Tạo phiếu kiểm kê KK-002', '::1', 'success', NULL, NULL, '2026-03-10 11:09:22'),
(35, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '3', 'Tạo phiếu kiểm kê KK-003', '::1', 'success', NULL, NULL, '2026-03-10 11:11:25'),
(36, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '4', 'Tạo phiếu kiểm kê KK-004', '::1', 'success', NULL, NULL, '2026-03-10 11:11:30'),
(37, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '5', 'Tạo phiếu kiểm kê KK-005', '::1', 'success', NULL, NULL, '2026-03-10 11:11:50'),
(38, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '6', 'Tạo phiếu kiểm kê KK-006', '::1', 'success', NULL, NULL, '2026-03-10 11:14:45'),
(39, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '7', 'Tạo phiếu kiểm kê KK-007', '::1', 'success', NULL, NULL, '2026-03-10 11:22:54'),
(40, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '8', 'Tạo phiếu kiểm kê KK-008', '::1', 'success', NULL, NULL, '2026-03-10 11:23:38'),
(41, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '9', 'Tạo phiếu kiểm kê KK-009', '::1', 'success', NULL, NULL, '2026-03-10 11:25:34'),
(42, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '10', 'Tạo phiếu kiểm kê KK-010', '::1', 'success', NULL, NULL, '2026-03-10 11:27:07'),
(43, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '11', 'Tạo phiếu kiểm kê KK-011', '::1', 'success', NULL, NULL, '2026-03-10 11:27:27'),
(44, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '12', 'Tạo phiếu kiểm kê KK-012', '::1', 'success', NULL, NULL, '2026-03-10 11:31:09'),
(45, 11, 'Tạo phiếu kiểm kê', 'phieu_kiem_ke', '13', 'Tạo phiếu kiểm kê KK-013', '::1', 'success', NULL, NULL, '2026-03-10 11:31:44'),
(46, 11, 'Tạo phiếu xuất', 'phieu_xuat', '6', 'Tạo phiếu xuất: PX006 - 1 mặt hàng, tổng: 19800000.00', '::1', 'success', NULL, '{\"ma_kho\": 1, \"tong_so_luong\": 20, \"tong_gia_tri\": 19800000.00}', '2026-03-10 16:38:37'),
(47, 11, 'Cập nhật tồn kho', 'ton_kho', '6', 'Cập nhật tồn kho: -20 sản phẩm (Mã kho: 1, Mã hàng: 6)', '::1', 'success', '{\"so_luong_cu\": 88}', '{\"so_luong_moi\": 68, \"chenh_lech\": \"-20\"}', '2026-03-10 16:38:37'),
(48, 11, 'Cập nhật trạng thái phiếu xuất: Đã duyệt', 'phieu_xuat', '6', 'Phiếu xuất PX006 chuyển từ trạng thái 0 sang 1', '::1', 'success', '{\"trang_thai_cu\": 0}', '{\"trang_thai_moi\": 1}', '2026-03-10 16:38:43'),
(49, 2, 'Cập nhật người dùng', 'nguoi_dung', '2', 'Cập nhật thông tin người dùng: Hoàng Thủ Kho', '::1', 'success', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '{\"ho_ten\": \"Hoàng Thủ Kho\", \"email\": \"thukho01@company.vn\", \"trang_thai\": 1}', '2026-03-10 17:21:40'),
(50, 2, 'Cập nhật hồ sơ cá nhân', 'nguoi_dung', '2', 'Cập nhật thông tin cá nhân', '::1', 'success', NULL, NULL, '2026-03-10 17:21:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `ma_nguoi_dung` int(11) NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ho_ten` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `ma_vai_tro` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT 1 COMMENT '1 hoat dong, 0 bi khoa',
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `anh_dai_dien` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`ma_nguoi_dung`, `ten_dang_nhap`, `mat_khau`, `ho_ten`, `email`, `so_dien_thoai`, `ma_vai_tro`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`, `anh_dai_dien`) VALUES
(1, 'admin01', '123456', 'Admin Kho', 'admin@company.vn', '0912345678', 1, 1, '2026-03-02 13:18:10', '2026-03-09 11:29:29', '1773030542_69ae4c8e8822b.jpg'),
(2, 'thukho01', '$2y$10$M13/an6z9MqBH77TLOawOe9a2/e4HEahRNsZkdGV8A6G4kSFcdIXu', 'Hoàng Thủ Kho', 'thukho01@company.vn', '0923456789', 2, 1, '2026-03-02 13:18:10', '2026-03-10 17:21:40', '1773138100_69aff0b4c52d6.jpg'),
(3, 'thukho02', '123456', 'Lê Văn Kho', 'thukho02@company.vn', '0934567890', 2, 0, '2026-03-02 13:18:10', '2026-03-09 11:31:38', '0'),
(4, 'quanly01', '123456', 'Quản Lý Kho', 'quanly01@company.vn', '0945678901', 3, 1, '2026-03-02 13:18:10', '2026-03-09 11:30:54', '1773030654_69ae4cfec7238.jpg'),
(5, 'quanly02', '123456', 'Hoàng Thị Lan', 'quanly02@company.vn', '0956789012', 3, 0, '2026-03-02 13:18:10', '2026-03-09 11:31:47', '0'),
(6, 'nhanvien01', '123456', 'Nhân Viên Kho', 'nv01@company.vn', '0967890123', 4, 1, '2026-03-02 13:18:10', '2026-03-09 11:31:16', '1773030676_69ae4d1493775.jpg'),
(7, 'nhanvien02', '123456', 'Vũ Thị Hương', 'nv02@company.vn', '0978901234', 4, 0, '2026-03-02 13:18:10', '2026-03-09 11:31:50', '0'),
(11, 'Owner', '$2y$10$7l4SDeqMkkvYZHbGxcTMyetCXofLas3uilTyGjGkcEo3aXGiOkwj2', 'Đào Huy Hoàng', 'hoanglc645@gmail.com', '0999999999', 1, 1, '2026-03-09 11:14:40', '2026-03-09 21:23:35', '1773066215_69aed7e72ea84.jpg');

--
-- Bẫy `nguoi_dung`
--
DELIMITER $$
CREATE TRIGGER `after_delete_nguoi_dung` AFTER DELETE ON `nguoi_dung` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc)
    VALUES (
        user_id,
        'Xóa người dùng',
        'nguoi_dung',
        OLD.ma_nguoi_dung,
        CONCAT('Xóa người dùng: ', OLD.ho_ten, ' (', OLD.ten_dang_nhap, ')'),
        user_ip,
        JSON_OBJECT('ho_ten', OLD.ho_ten, 'ten_dang_nhap', OLD.ten_dang_nhap, 'email', OLD.email)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_nguoi_dung` AFTER INSERT ON `nguoi_dung` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_sau)
    VALUES (
        user_id,
        'Thêm người dùng',
        'nguoi_dung',
        NEW.ma_nguoi_dung,
        CONCAT('Thêm người dùng mới: ', NEW.ho_ten, ' (', NEW.ten_dang_nhap, ')'),
        user_ip,
        JSON_OBJECT('ho_ten', NEW.ho_ten, 'ten_dang_nhap', NEW.ten_dang_nhap, 'email', NEW.email, 'vai_tro', NEW.ma_vai_tro)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_nguoi_dung` AFTER UPDATE ON `nguoi_dung` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc, du_lieu_sau)
    VALUES (
        user_id,
        'Cập nhật người dùng',
        'nguoi_dung',
        NEW.ma_nguoi_dung,
        CONCAT('Cập nhật thông tin người dùng: ', NEW.ho_ten),
        user_ip,
        JSON_OBJECT('ho_ten', OLD.ho_ten, 'email', OLD.email, 'trang_thai', OLD.trang_thai),
        JSON_OBJECT('ho_ten', NEW.ho_ten, 'email', NEW.email, 'trang_thai', NEW.trang_thai)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `ma_nha_cung_cap` int(11) NOT NULL,
  `ten_nha_cung_cap` varchar(150) NOT NULL,
  `nguoi_lien_he` varchar(100) DEFAULT NULL COMMENT 'Tên người liên hệ chính',
  `dia_chi` text DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Đang hợp tác, 0 = Ngừng hợp tác',
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`ma_nha_cung_cap`, `ten_nha_cung_cap`, `nguoi_lien_he`, `dia_chi`, `so_dien_thoai`, `email`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Công ty FPT Shop', 'Anh Huy Hoàng', 'Số 17 Duy Tân, Cầu Giấy, Hà Nội', '19006600', 'fptshop@fpt.com.vn', 1, '2026-03-02 13:18:10'),
(2, 'Thế Giới Di Động', 'Đào Huy Hoàng', '128 Trần Quang Khải, Q.1, TP.HCM', '18001060', 'cskh@thegioididong.com', 0, '2026-03-02 13:18:10'),
(3, 'CellphoneS', 'Đào Huy Hoàng', '209 Xã Đàn, Đống Đa, Hà Nội', '18002098', 'hotro@cellphones.com.vn', 1, '2026-03-02 13:18:10'),
(4, 'Công ty An Phát PC', NULL, 'Số 49 Thái Hà, Đống Đa, Hà Nội', '19002142', 'contact@anphatpc.com.vn', 1, '2026-03-02 13:18:10'),
(5, 'Nhà phân phối Xiaomi Việt Nam', NULL, 'Tầng 5, Tòa nhà VCCI, Hà Nội', '02437838888', 'support@xiaomi.vn', 1, '2026-03-02 13:18:10'),
(6, 'Công ty Tân Doanh', NULL, 'Q.7, TP.HCM', '02854123567', 'tandoanh@gmail.com', 1, '2026-03-02 13:18:10'),
(7, 'Điện máy Xanh', NULL, '128 Trần Quang Khải, Q.1, TP.HCM', '18001060', 'dienmayxanh@thegioididong.com', 1, '2026-03-02 13:18:10'),
(8, 'Công ty Việt Tiến', NULL, 'Bình Dương', '02743891234', 'viettien@viettien.com.vn', 1, '2026-03-02 13:18:10'),
(9, 'Nhà cung cấp linh kiện ABC', NULL, 'KCN Quang Minh, Hà Nội', '0987654321', 'abc.linhkien@gmail.com', 1, '2026-03-02 13:18:10'),
(10, 'Công ty Minh Anh', NULL, 'Hà Đông, Hà Nội', '0912345678', 'minhanh.supply@gmail.com', 1, '2026-03-02 13:18:10'),
(11, 'Nhà Cung Cấp Test', 'TEST', 'HÀ NỘI', '0992122222222', 'hoanglc645@gmail.com', 0, '2026-03-06 19:58:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_kiem_ke`
--

CREATE TABLE `phieu_kiem_ke` (
  `ma_phieu_kiem_ke` int(11) NOT NULL,
  `ma_kho` int(11) DEFAULT NULL,
  `ma_nguoi_tao` int(11) DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_hoan_thanh` datetime DEFAULT NULL,
  `trang_thai` varchar(20) NOT NULL DEFAULT 'dang_kiem_ke' COMMENT 'dang_kiem_ke, hoan_thanh, da_dieu_chinh'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieu_kiem_ke`
--

INSERT INTO `phieu_kiem_ke` (`ma_phieu_kiem_ke`, `ma_kho`, `ma_nguoi_tao`, `ghi_chu`, `ngay_tao`, `ngay_hoan_thanh`, `trang_thai`) VALUES
(3, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:13:36', 'hoan_thanh'),
(5, 3, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:14:07', 'hoan_thanh'),
(6, 1, 11, '', '2026-03-09 00:00:00', '2026-03-10 11:14:48', 'hoan_thanh'),
(7, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:23:15', 'hoan_thanh'),
(8, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:23:46', 'hoan_thanh'),
(9, 11, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:25:58', 'hoan_thanh'),
(10, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:27:13', 'hoan_thanh'),
(11, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:27:35', 'hoan_thanh'),
(12, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:31:20', 'hoan_thanh'),
(13, 1, 11, '', '2026-03-10 00:00:00', '2026-03-10 11:32:00', 'hoan_thanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `ma_phieu_nhap` int(11) NOT NULL,
  `ma_kho` int(11) DEFAULT NULL,
  `ma_nguoi_tao` int(11) DEFAULT NULL,
  `ma_nha_cung_cap` int(11) DEFAULT NULL,
  `so_mat_hang` int(11) DEFAULT 0,
  `tong_so_luong` int(11) DEFAULT 0,
  `tong_tien` decimal(15,2) DEFAULT 0.00,
  `ma_nguoi_duyet` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT 0 COMMENT '0 cho duyet, 1 da duyet, 2 tu choi',
  `ghi_chu` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_duyet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieu_nhap`
--

INSERT INTO `phieu_nhap` (`ma_phieu_nhap`, `ma_kho`, `ma_nguoi_tao`, `ma_nha_cung_cap`, `so_mat_hang`, `tong_so_luong`, `tong_tien`, `ma_nguoi_duyet`, `trang_thai`, `ghi_chu`, `ngay_tao`, `ngay_duyet`) VALUES
(1, 1, 2, NULL, 0, 0, 0.00, 4, 1, 'Nhập lô hàng tháng 3/2026', '2026-03-02 13:18:10', NULL),
(2, 2, 3, NULL, 0, 0, 0.00, 5, 1, 'Nhập phụ kiện từ CellphoneS', '2026-03-02 13:18:10', NULL),
(6, 1, 1, 4, 8, 26, 125230000.00, NULL, 1, '', '2026-03-07 21:04:43', NULL),
(7, 1, 1, 7, 10, 56, 863370000.00, NULL, 1, '', '2026-03-07 21:26:31', NULL),
(9, 1, 1, 4, 1, 1, 1850000.00, NULL, 1, 'Test phiếu duyệt', '2026-03-07 21:36:02', NULL),
(10, 1, 1, 4, 1, 1, 10500000.00, NULL, 1, '', '2026-03-07 21:46:24', NULL),
(11, 3, 1, 1, 1, 1, 6200000.00, 1, 2, '', '2026-03-07 21:48:47', '2026-03-07 21:48:52'),
(12, 5, 1, 3, 1, 1, 1850000.00, NULL, 1, '', '2026-03-07 21:50:19', NULL),
(13, 2, 1, 6, 1, 5, 9250000.00, NULL, 1, '', '2026-03-08 14:39:47', NULL),
(14, 1, 1, 4, 1, 1, 1850000.00, NULL, 1, '', '2026-03-08 14:45:26', NULL),
(15, 1, 1, 4, 1, 10, 24500000.00, NULL, 1, '', '2026-03-08 14:48:03', NULL),
(16, 2, 1, 1, 1, 1, 1850000.00, NULL, 1, '', '2026-03-08 14:49:45', NULL),
(17, 1, 1, 6, 1, 1, 1850000.00, NULL, 1, '', '2026-03-08 15:03:40', NULL),
(18, 2, 1, 4, 1, 4, 7400000.00, NULL, 1, NULL, '2026-03-08 16:26:46', NULL),
(19, 1, 1, 3, 2, 30, 75200000.00, 4, 2, '\nLý do từ chối: Phiếu test', '2026-03-08 17:42:22', '2026-03-08 17:53:52'),
(20, 2, 11, 4, 1, 9, 8010000.00, 11, 1, '', '2026-03-09 22:00:04', '2026-03-09 22:00:22'),
(21, 1, 11, 1, 1, 100, 10000000000.00, 11, 1, '', '2026-03-09 22:03:58', '2026-03-09 22:04:10'),
(22, 11, 11, 7, 1, 20, 210000000.00, 11, 1, '', '2026-03-10 07:40:53', '2026-03-10 07:41:13'),
(23, 10, 11, 3, 1, 10, 62000000.00, 11, 1, '', '2026-03-10 09:06:56', '2026-03-10 09:07:09');

--
-- Bẫy `phieu_nhap`
--
DELIMITER $$
CREATE TRIGGER `after_insert_phieu_nhap` AFTER INSERT ON `phieu_nhap` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_sau)
    VALUES (
        NEW.ma_nguoi_tao,
        'Tạo phiếu nhập',
        'phieu_nhap',
        NEW.ma_phieu_nhap,
        CONCAT('Tạo phiếu nhập: PN', LPAD(NEW.ma_phieu_nhap, 3, '0'), ' - ', NEW.so_mat_hang, ' mặt hàng, tổng: ', NEW.tong_tien),
        user_ip,
        JSON_OBJECT('ma_kho', NEW.ma_kho, 'tong_so_luong', NEW.tong_so_luong, 'tong_tien', NEW.tong_tien)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_phieu_nhap_status` AFTER UPDATE ON `phieu_nhap` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    DECLARE trang_thai_text VARCHAR(50);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    IF OLD.trang_thai != NEW.trang_thai THEN
        CASE NEW.trang_thai
            WHEN 0 THEN SET trang_thai_text = 'Chờ duyệt';
            WHEN 1 THEN SET trang_thai_text = 'Đã duyệt';
            WHEN 2 THEN SET trang_thai_text = 'Từ chối';
            ELSE SET trang_thai_text = 'Không xác định';
        END CASE;
        
        INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc, du_lieu_sau)
        VALUES (
            NEW.ma_nguoi_duyet,
            CONCAT('Cập nhật trạng thái phiếu nhập: ', trang_thai_text),
            'phieu_nhap',
            NEW.ma_phieu_nhap,
            CONCAT('Phiếu nhập PN', LPAD(NEW.ma_phieu_nhap, 3, '0'), ' chuyển từ trạng thái ', OLD.trang_thai, ' sang ', NEW.trang_thai),
            user_ip,
            JSON_OBJECT('trang_thai_cu', OLD.trang_thai),
            JSON_OBJECT('trang_thai_moi', NEW.trang_thai)
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_xuat`
--

CREATE TABLE `phieu_xuat` (
  `ma_phieu_xuat` int(11) NOT NULL,
  `ma_kho` int(11) DEFAULT NULL,
  `bo_phan_nguoi_nhan` varchar(150) DEFAULT NULL,
  `so_mat_hang` int(11) DEFAULT 0,
  `tong_so_luong` int(11) DEFAULT 0,
  `tong_gia_tri` decimal(15,2) DEFAULT 0.00,
  `ma_nguoi_tao` int(11) DEFAULT NULL,
  `ma_nguoi_duyet` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT 0 COMMENT '0 cho duyet, 1 da duyet, 2 tu choi',
  `ghi_chu` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_duyet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieu_xuat`
--

INSERT INTO `phieu_xuat` (`ma_phieu_xuat`, `ma_kho`, `bo_phan_nguoi_nhan`, `so_mat_hang`, `tong_so_luong`, `tong_gia_tri`, `ma_nguoi_tao`, `ma_nguoi_duyet`, `trang_thai`, `ghi_chu`, `ngay_tao`, `ngay_duyet`) VALUES
(1, 2, 'Hoàng|Kinh doanh', 1, 1, 2490000.00, 1, NULL, 0, '', '2026-03-08 14:37:38', NULL),
(2, 2, 'Huy Hoàng|Kinh doanh', 1, 4, 9960000.00, 1, NULL, 0, '', '2026-03-08 14:39:11', NULL),
(3, 2, 'hoàng huy', 1, 1, 2490000.00, 1, 1, 2, '\nLý do từ chối: Test', '2026-03-08 16:15:05', '2026-03-08 18:50:34'),
(4, 1, 'Huy Hoàng|Kỹ thuật', 1, 1, 3190000.00, 1, 2, 1, '', '2026-03-08 16:56:55', NULL),
(5, 2, 'Huy Hoàng|Sản xuất', 1, 20, 23800000.00, 11, 11, 1, '', '2026-03-09 21:46:37', '2026-03-09 21:47:01'),
(6, 1, 'Huy Hoàng|Kinh doanh', 1, 20, 19800000.00, 11, 11, 1, '', '2026-03-10 16:38:37', '2026-03-10 16:38:43');

--
-- Bẫy `phieu_xuat`
--
DELIMITER $$
CREATE TRIGGER `after_insert_phieu_xuat` AFTER INSERT ON `phieu_xuat` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_sau)
    VALUES (
        NEW.ma_nguoi_tao,
        'Tạo phiếu xuất',
        'phieu_xuat',
        NEW.ma_phieu_xuat,
        CONCAT('Tạo phiếu xuất: PX', LPAD(NEW.ma_phieu_xuat, 3, '0'), ' - ', NEW.so_mat_hang, ' mặt hàng, tổng: ', NEW.tong_gia_tri),
        user_ip,
        JSON_OBJECT('ma_kho', NEW.ma_kho, 'tong_so_luong', NEW.tong_so_luong, 'tong_gia_tri', NEW.tong_gia_tri)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_phieu_xuat_status` AFTER UPDATE ON `phieu_xuat` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    DECLARE trang_thai_text VARCHAR(50);
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    
    IF OLD.trang_thai != NEW.trang_thai THEN
        CASE NEW.trang_thai
            WHEN 0 THEN SET trang_thai_text = 'Chờ duyệt';
            WHEN 1 THEN SET trang_thai_text = 'Đã duyệt';
            WHEN 2 THEN SET trang_thai_text = 'Từ chối';
            ELSE SET trang_thai_text = 'Không xác định';
        END CASE;
        
        INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc, du_lieu_sau)
        VALUES (
            NEW.ma_nguoi_duyet,
            CONCAT('Cập nhật trạng thái phiếu xuất: ', trang_thai_text),
            'phieu_xuat',
            NEW.ma_phieu_xuat,
            CONCAT('Phiếu xuất PX', LPAD(NEW.ma_phieu_xuat, 3, '0'), ' chuyển từ trạng thái ', OLD.trang_thai, ' sang ', NEW.trang_thai),
            user_ip,
            JSON_OBJECT('trang_thai_cu', OLD.trang_thai),
            JSON_OBJECT('trang_thai_moi', NEW.trang_thai)
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ton_kho`
--

CREATE TABLE `ton_kho` (
  `ma_ton_kho` int(11) NOT NULL,
  `ma_kho` int(11) DEFAULT NULL,
  `ma_hang_hoa` int(11) DEFAULT NULL,
  `so_luong` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ton_kho`
--

INSERT INTO `ton_kho` (`ma_ton_kho`, `ma_kho`, `ma_hang_hoa`, `so_luong`) VALUES
(1, 1, 1, 45),
(2, 1, 2, 32),
(3, 1, 3, 18),
(4, 2, 4, 109),
(5, 2, 5, 60),
(6, 1, 6, 68),
(7, 3, 7, 22),
(8, 1, 8, 15),
(9, 2, 9, 450),
(10, 1, 10, 200),
(11, 1, 11, 0),
(12, 1, 12, 300),
(13, 1, 4, 1),
(14, 1, 42, 100),
(15, 1, 38, 9),
(16, 1, 5, 1),
(17, 1, 45, 100),
(18, 11, 17, 20),
(19, 10, 15, 10);

--
-- Bẫy `ton_kho`
--
DELIMITER $$
CREATE TRIGGER `after_update_ton_kho` AFTER UPDATE ON `ton_kho` FOR EACH ROW BEGIN
    DECLARE user_id INT;
    DECLARE user_ip VARCHAR(45);
    DECLARE chenh_lech INT;
    
    SET user_id = NULLIF(@current_user_id, 0);
    SET user_ip = @current_ip;
    SET chenh_lech = NEW.so_luong - OLD.so_luong;
    
    IF OLD.so_luong != NEW.so_luong THEN
        INSERT INTO lich_su_he_thong (ma_nguoi_dung, hanh_dong, doi_tuong, ma_doi_tuong, chi_tiet, ip, du_lieu_truoc, du_lieu_sau)
        VALUES (
            user_id,
            'Cập nhật tồn kho',
            'ton_kho',
            NEW.ma_ton_kho,
            CONCAT('Cập nhật tồn kho: ', IF(chenh_lech > 0, '+', ''), chenh_lech, ' sản phẩm (Mã kho: ', NEW.ma_kho, ', Mã hàng: ', NEW.ma_hang_hoa, ')'),
            user_ip,
            JSON_OBJECT('so_luong_cu', OLD.so_luong),
            JSON_OBJECT('so_luong_moi', NEW.so_luong, 'chenh_lech', chenh_lech)
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vai_tro`
--

CREATE TABLE `vai_tro` (
  `ma_vai_tro` int(11) NOT NULL,
  `ten_vai_tro` varchar(50) NOT NULL COMMENT 'ADMIN, THU_KHO, QUAN_LY, NHAN_VIEN',
  `mo_ta` text DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT 1 COMMENT '1 hoạt động, 0 ngừng sử dụng',
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vai_tro`
--

INSERT INTO `vai_tro` (`ma_vai_tro`, `ten_vai_tro`, `mo_ta`, `trang_thai`, `ngay_tao`) VALUES
(1, 'ADMIN', NULL, 1, '2026-03-09 12:54:16'),
(2, 'THU_KHO', NULL, 1, '2026-03-09 12:54:16'),
(3, 'QUAN_LY', NULL, 1, '2026-03-09 12:54:16'),
(4, 'NHAN_VIEN', NULL, 1, '2026-03-09 12:54:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vai_tro_quyen`
--

CREATE TABLE `vai_tro_quyen` (
  `ma_quyen` int(11) NOT NULL,
  `ma_vai_tro` int(11) NOT NULL,
  `chuc_nang` varchar(50) NOT NULL COMMENT 'products, categories, suppliers,...',
  `hanh_dong` varchar(20) NOT NULL COMMENT 'view, create, edit, delete, approve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_tiet_kiem_ke`
--
ALTER TABLE `chi_tiet_kiem_ke`
  ADD PRIMARY KEY (`ma_chi_tiet`),
  ADD KEY `ma_phieu_kiem_ke` (`ma_phieu_kiem_ke`),
  ADD KEY `ma_hang_hoa` (`ma_hang_hoa`);

--
-- Chỉ mục cho bảng `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD PRIMARY KEY (`ma_chi_tiet`),
  ADD KEY `ma_phieu_nhap` (`ma_phieu_nhap`),
  ADD KEY `ma_hang_hoa` (`ma_hang_hoa`);

--
-- Chỉ mục cho bảng `chi_tiet_phieu_xuat`
--
ALTER TABLE `chi_tiet_phieu_xuat`
  ADD PRIMARY KEY (`ma_chi_tiet`),
  ADD KEY `ma_phieu_xuat` (`ma_phieu_xuat`),
  ADD KEY `ma_hang_hoa` (`ma_hang_hoa`);

--
-- Chỉ mục cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`ma_danh_muc`);

--
-- Chỉ mục cho bảng `hang_hoa`
--
ALTER TABLE `hang_hoa`
  ADD PRIMARY KEY (`ma_hang_hoa`),
  ADD UNIQUE KEY `ma_san_pham` (`ma_san_pham`),
  ADD KEY `ma_danh_muc` (`ma_danh_muc`),
  ADD KEY `ma_nha_cung_cap` (`ma_nha_cung_cap`);

--
-- Chỉ mục cho bảng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`ma_kho`);

--
-- Chỉ mục cho bảng `lich_su_he_thong`
--
ALTER TABLE `lich_su_he_thong`
  ADD PRIMARY KEY (`ma_lich_su`),
  ADD KEY `idx_thoi_gian` (`thoi_gian`),
  ADD KEY `lich_su_he_thong_ibfk_1` (`ma_nguoi_dung`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`ma_nguoi_dung`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  ADD KEY `ma_vai_tro` (`ma_vai_tro`);

--
-- Chỉ mục cho bảng `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`ma_nha_cung_cap`);

--
-- Chỉ mục cho bảng `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  ADD PRIMARY KEY (`ma_phieu_kiem_ke`),
  ADD KEY `ma_kho` (`ma_kho`),
  ADD KEY `ma_nguoi_tao` (`ma_nguoi_tao`);

--
-- Chỉ mục cho bảng `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`ma_phieu_nhap`),
  ADD KEY `ma_kho` (`ma_kho`),
  ADD KEY `ma_nguoi_tao` (`ma_nguoi_tao`),
  ADD KEY `ma_nguoi_duyet` (`ma_nguoi_duyet`),
  ADD KEY `fk_phieu_nhap_nhacungcap` (`ma_nha_cung_cap`);

--
-- Chỉ mục cho bảng `phieu_xuat`
--
ALTER TABLE `phieu_xuat`
  ADD PRIMARY KEY (`ma_phieu_xuat`),
  ADD KEY `ma_kho` (`ma_kho`),
  ADD KEY `ma_nguoi_tao` (`ma_nguoi_tao`),
  ADD KEY `ma_nguoi_duyet` (`ma_nguoi_duyet`);

--
-- Chỉ mục cho bảng `ton_kho`
--
ALTER TABLE `ton_kho`
  ADD PRIMARY KEY (`ma_ton_kho`),
  ADD UNIQUE KEY `ma_kho` (`ma_kho`,`ma_hang_hoa`),
  ADD KEY `ma_hang_hoa` (`ma_hang_hoa`);

--
-- Chỉ mục cho bảng `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`ma_vai_tro`),
  ADD UNIQUE KEY `ten_vai_tro` (`ten_vai_tro`);

--
-- Chỉ mục cho bảng `vai_tro_quyen`
--
ALTER TABLE `vai_tro_quyen`
  ADD PRIMARY KEY (`ma_quyen`),
  ADD UNIQUE KEY `unique_permission` (`ma_vai_tro`,`chuc_nang`,`hanh_dong`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_tiet_kiem_ke`
--
ALTER TABLE `chi_tiet_kiem_ke`
  MODIFY `ma_chi_tiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  MODIFY `ma_chi_tiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_phieu_xuat`
--
ALTER TABLE `chi_tiet_phieu_xuat`
  MODIFY `ma_chi_tiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `ma_danh_muc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `hang_hoa`
--
ALTER TABLE `hang_hoa`
  MODIFY `ma_hang_hoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `kho`
--
ALTER TABLE `kho`
  MODIFY `ma_kho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `lich_su_he_thong`
--
ALTER TABLE `lich_su_he_thong`
  MODIFY `ma_lich_su` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `ma_nguoi_dung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `ma_nha_cung_cap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  MODIFY `ma_phieu_kiem_ke` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `ma_phieu_nhap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `phieu_xuat`
--
ALTER TABLE `phieu_xuat`
  MODIFY `ma_phieu_xuat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ton_kho`
--
ALTER TABLE `ton_kho`
  MODIFY `ma_ton_kho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `vai_tro`
--
ALTER TABLE `vai_tro`
  MODIFY `ma_vai_tro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `vai_tro_quyen`
--
ALTER TABLE `vai_tro_quyen`
  MODIFY `ma_quyen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_kiem_ke`
--
ALTER TABLE `chi_tiet_kiem_ke`
  ADD CONSTRAINT `chi_tiet_kiem_ke_ibfk_1` FOREIGN KEY (`ma_phieu_kiem_ke`) REFERENCES `phieu_kiem_ke` (`ma_phieu_kiem_ke`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_kiem_ke_ibfk_2` FOREIGN KEY (`ma_hang_hoa`) REFERENCES `hang_hoa` (`ma_hang_hoa`);

--
-- Các ràng buộc cho bảng `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD CONSTRAINT `chi_tiet_phieu_nhap_ibfk_1` FOREIGN KEY (`ma_phieu_nhap`) REFERENCES `phieu_nhap` (`ma_phieu_nhap`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_phieu_nhap_ibfk_2` FOREIGN KEY (`ma_hang_hoa`) REFERENCES `hang_hoa` (`ma_hang_hoa`);

--
-- Các ràng buộc cho bảng `chi_tiet_phieu_xuat`
--
ALTER TABLE `chi_tiet_phieu_xuat`
  ADD CONSTRAINT `chi_tiet_phieu_xuat_ibfk_1` FOREIGN KEY (`ma_phieu_xuat`) REFERENCES `phieu_xuat` (`ma_phieu_xuat`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_phieu_xuat_ibfk_2` FOREIGN KEY (`ma_hang_hoa`) REFERENCES `hang_hoa` (`ma_hang_hoa`);

--
-- Các ràng buộc cho bảng `hang_hoa`
--
ALTER TABLE `hang_hoa`
  ADD CONSTRAINT `hang_hoa_ibfk_1` FOREIGN KEY (`ma_danh_muc`) REFERENCES `danh_muc` (`ma_danh_muc`),
  ADD CONSTRAINT `hang_hoa_ibfk_2` FOREIGN KEY (`ma_nha_cung_cap`) REFERENCES `nha_cung_cap` (`ma_nha_cung_cap`);

--
-- Các ràng buộc cho bảng `lich_su_he_thong`
--
ALTER TABLE `lich_su_he_thong`
  ADD CONSTRAINT `lich_su_he_thong_ibfk_1` FOREIGN KEY (`ma_nguoi_dung`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `nguoi_dung_ibfk_1` FOREIGN KEY (`ma_vai_tro`) REFERENCES `vai_tro` (`ma_vai_tro`);

--
-- Các ràng buộc cho bảng `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  ADD CONSTRAINT `phieu_kiem_ke_ibfk_1` FOREIGN KEY (`ma_kho`) REFERENCES `kho` (`ma_kho`),
  ADD CONSTRAINT `phieu_kiem_ke_ibfk_2` FOREIGN KEY (`ma_nguoi_tao`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`);

--
-- Các ràng buộc cho bảng `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD CONSTRAINT `fk_phieu_nhap_nhacungcap` FOREIGN KEY (`ma_nha_cung_cap`) REFERENCES `nha_cung_cap` (`ma_nha_cung_cap`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `phieu_nhap_ibfk_1` FOREIGN KEY (`ma_kho`) REFERENCES `kho` (`ma_kho`),
  ADD CONSTRAINT `phieu_nhap_ibfk_2` FOREIGN KEY (`ma_nguoi_tao`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`),
  ADD CONSTRAINT `phieu_nhap_ibfk_3` FOREIGN KEY (`ma_nguoi_duyet`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`);

--
-- Các ràng buộc cho bảng `phieu_xuat`
--
ALTER TABLE `phieu_xuat`
  ADD CONSTRAINT `phieu_xuat_ibfk_1` FOREIGN KEY (`ma_kho`) REFERENCES `kho` (`ma_kho`),
  ADD CONSTRAINT `phieu_xuat_ibfk_2` FOREIGN KEY (`ma_nguoi_tao`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`),
  ADD CONSTRAINT `phieu_xuat_ibfk_3` FOREIGN KEY (`ma_nguoi_duyet`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`);

--
-- Các ràng buộc cho bảng `ton_kho`
--
ALTER TABLE `ton_kho`
  ADD CONSTRAINT `ton_kho_ibfk_1` FOREIGN KEY (`ma_kho`) REFERENCES `kho` (`ma_kho`),
  ADD CONSTRAINT `ton_kho_ibfk_2` FOREIGN KEY (`ma_hang_hoa`) REFERENCES `hang_hoa` (`ma_hang_hoa`);

--
-- Các ràng buộc cho bảng `vai_tro_quyen`
--
ALTER TABLE `vai_tro_quyen`
  ADD CONSTRAINT `vai_tro_quyen_ibfk_1` FOREIGN KEY (`ma_vai_tro`) REFERENCES `vai_tro` (`ma_vai_tro`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
