-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2019 at 04:09 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manages`
--

-- --------------------------------------------------------

--
-- Table structure for table `chuc_danh`
--

CREATE TABLE `chuc_danh` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `chi_tiet` text,
  `thoi_gian_dinh_muc` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) NOT NULL DEFAULT '0',
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chuc_danh`
--

INSERT INTO `chuc_danh` (`id`, `ten`, `chi_tiet`, `thoi_gian_dinh_muc`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Trá»£ giáº£ng', 'Trá»£ giáº£ng', 400, 1, 1556718301, 1556722171),
(2, 'Giáº£ng viÃªn', 'Giáº£ng viÃªn', 500, 1, 1556718270, 1556719795),
(3, 'Giáº£ng viÃªn chÃ­nh', 'Giáº£ng viÃªn chÃ­nh', 550, 1, 1556718400, 1556720794),
(4, 'PhÃ³ giÃ¡o sÆ°', 'PhÃ³ giÃ¡o sÆ°', 600, 1, 1556721042, NULL),
(6, 'GiÃ¡o sÆ°', 'GiÃ¡o sÆ°', 700, 1, 1556722827, 1556725399);

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_nghien_cuu`
--

CREATE TABLE `danh_muc_nghien_cuu` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `chi_tiet` text,
  `ma` varchar(50) DEFAULT NULL,
  `thoi_gian_dinh_muc` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `danh_muc_nghien_cuu`
--

INSERT INTO `danh_muc_nghien_cuu` (`id`, `ten`, `chi_tiet`, `ma`, `thoi_gian_dinh_muc`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Äá» TÃ i, dá»¥ Ã¡n NCKH - Cáº¥p trÆ°á»ng', '', 'NC-112', 1400, 1, 1556988136, NULL),
(2, 'Äá» TÃ i, dá»¥ Ã¡n NCKH - Cáº¥p tá»‰nh', '', 'NC-113', 1800, 1, 1556988277, NULL),
(3, 'Äá» TÃ i, dá»¥ Ã¡n NCKH - Cáº¥p nhÃ  nÆ°á»›c', '', 'NC-114', 2600, 1, 1556988309, NULL),
(4, 'HÆ°á»›ng dáº«n SV nghiÃªn cá»©u - cáº¥p trÆ°á»ng', '', 'NC-011', 60, 1, 1556988372, 1556988387),
(5, 'HÆ°á»›ng dáº«n SV nghiÃªn cá»©u - cáº¥p Bá»™', '', 'NC-012', 80, 1, 1556988410, NULL),
(6, 'SÃ¡ng kiáº¿n, cáº£i tiáº¿n ná»™i dung phÆ°Æ¡ng phÃ¡p dáº­y há»c', '', 'NC-021', 250, 1, 1557022731, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_tai_lieu`
--

CREATE TABLE `danh_muc_tai_lieu` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `chi_tiet` text,
  `thoi_gian_dinh_muc` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `don_vi_cong_tac`
--

CREATE TABLE `don_vi_cong_tac` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `chi_tiet` text,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `don_vi_cong_tac`
--

INSERT INTO `don_vi_cong_tac` (`id`, `ten`, `chi_tiet`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Äáº¡i há»c Quá»‘c Gia', 'Äáº¡i há»c Quá»‘c Gia', 1, 1556724044, 1556794565),
(2, 'Äáº¡i há»c Ngoáº¡i ThÆ°Æ¡ng', 'Äáº¡i há»c Ngoáº¡i ThÆ°Æ¡ng', 1, 1556724082, 1556724311),
(3, 'Äáº¡i há»c BÃ¡ch Khoa', '', 1, 1556724329, NULL),
(5, 'Äáº¡i há»c sÆ° pháº¡m', '', 1, 1556794673, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `giao_vien`
--

CREATE TABLE `giao_vien` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `don_vi_id` int(11) DEFAULT NULL,
  `chuc_vu_id` int(11) DEFAULT NULL,
  `tai_khoan_id` varchar(20) DEFAULT NULL,
  `gioi_tinh` tinyint(4) DEFAULT NULL,
  `tong_thoi_gian` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) NOT NULL,
  `ngay_tao` int(11) NOT NULL,
  `ngay_cap_nhat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `giao_vien`
--

INSERT INTO `giao_vien` (`id`, `ten`, `email`, `don_vi_id`, `chuc_vu_id`, `tai_khoan_id`, `gioi_tinh`, `tong_thoi_gian`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Nguyá»…n VÄƒn C', 'nguyenvanc@gmail.com', 5, 6, 'BsB7dbcQ', 0, 611, 1, 1556725100, 1557065232),
(2, 'XuÃ¢n HÃ¹ng', 'xuanhung2401@gmail.com', 2, 3, NULL, 1, 794, 1, 1556725226, 0),
(3, 'Nguyá»…n VÄƒn A', 'nguyenvana@gmail.com', 1, 1, NULL, 2, 499, 1, 1556797127, 1556804742),
(5, 'Äá»— VÄƒn Q', 'dovanq@gmail.com', 3, 6, '0', 1, 49, 1, 1557041316, 0),
(6, 'Tran Thá»‹ D', 'tranthib@gmail.com', 2, 2, '0', 0, 0, 1, 1557042377, 0),
(7, 'LÃª VÄƒn Q', 'levanq@gmail.com', 1, 1, 'L9AdMFF7', 1, NULL, 1, 1557042685, 0),
(8, 'Thu Tháº£o', 'thuthao@gmail.com', 3, 4, '8aXEPXCF', 0, NULL, 1, 1557044647, 1557052920),
(9, 'Pháº¡m thu HÆ°Æ¡ng', 'huongpt@gmail.com', 2, 4, 'aBDwQgdW', 0, NULL, 1, 1557048049, 1557053630),
(10, 'Nguyá»…n TrÃ¢n Trá»ng', 'trongnt@gmail.com', 1, 3, 'T7WxN96B', 1, NULL, 1, 1557048241, 1557053646),
(11, 'Cá»±c cÃ¬ cá»¥c', 'cuccc@gmail.com', 5, 1, 'rHPZgIew', 1, 0, 1, 1557048541, 1557052863),
(12, 'Pháº¡m PhÆ°Æ¡ng Linh', 'linhpp@gmail.com', 5, 3, 'VfSveWIt', 0, NULL, 1, 1557049057, 1557052845),
(13, 'Nguyá»…n Minh Chiáº¿n', 'chiennm@gmail.com', 2, 6, 'sGve7bsu', 1, 0, 1, 1557049201, 1557052790);

-- --------------------------------------------------------

--
-- Table structure for table `giao_vien_nghien_cuu`
--

CREATE TABLE `giao_vien_nghien_cuu` (
  `id` int(11) NOT NULL,
  `giao_vien_id` int(11) DEFAULT NULL,
  `nghien_cuu_id` varchar(20) DEFAULT NULL,
  `thoi_gian` int(11) DEFAULT NULL,
  `vai_tro` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `giao_vien_nghien_cuu`
--

INSERT INTO `giao_vien_nghien_cuu` (`id`, `giao_vien_id`, `nghien_cuu_id`, `thoi_gian`, `vai_tro`) VALUES
(1, 3, '', 30, '0'),
(2, 3, 'Jl4SAi0E', 36, 'HÆ°á»›ng dáº«n chÃ­nh'),
(3, 2, '1', 18, 'HÆ°á»›ng dáº«n chÃ­nh'),
(4, 1, '1', 23, 'HÆ°á»›ng dáº«n chÃ­nh'),
(10, 2, 'FNqIK6bv', 96, 'Chá»§ Ä‘á» tÃ i'),
(11, 3, 'FNqIK6bv', 48, 'ThÃ nh viÃªn'),
(12, 1, 'FNqIK6bv', 72, 'ThÃ nh viÃªn'),
(13, 1, 'eHbIAzJH', 48, 'ThÃ nh viÃªn'),
(14, 2, 'eHbIAzJH', 78, 'Chá»§ nghiÃªn cá»©u'),
(15, 2, 'uP6wLdRv', 120, 'Chá»§ nghiÃªn cá»©u'),
(16, 3, 'uP6wLdRv', 32, 'ThÃ nh viÃªn'),
(17, 3, 'ubXFZ4zA', 36, 'HÆ°á»›ng dáº«n chÃ­nh'),
(18, 1, 'pOW6ctcB', 24, 'HÆ°á»›ng dáº«n chÃ­nh'),
(19, 3, 'i1zb319A', 18, 'HÆ°á»›ng dáº«n chÃ­nh'),
(20, 1, '88BsevEA', 360, 'ThÃ nh viÃªn'),
(21, 2, '88BsevEA', 450, 'Chá»§ nghiÃªn cá»©u'),
(22, 3, '88BsevEA', 250, 'ThÃ nh viÃªn'),
(23, 1, 'Pvy2yUZI', 24, 'HÆ°á»›ng dáº«n chÃ­nh'),
(24, 1, 'tG6L8P7D', 24, 'HÆ°á»›ng dáº«n chÃ­nh'),
(25, 3, 'Z3rTEVVT', 49, 'HÆ°á»›ng dáº«n chÃ­nh'),
(26, 1, 'Ix6X708p', 24, 'HÆ°á»›ng dáº«n chÃ­nh'),
(27, 2, 'Z3rTEVVT', 32, 'ThÃ nh viÃªn'),
(28, 1, 'Z3rTEVVT', 12, 'ThÃ nh viÃªn'),
(29, 6, 'Z3rTEVVT', 12, 'ThÃ nh viÃªn');

-- --------------------------------------------------------

--
-- Table structure for table `giao_vien_tai_lieu`
--

CREATE TABLE `giao_vien_tai_lieu` (
  `id` int(11) NOT NULL,
  `giao_vien_id` int(11) DEFAULT NULL,
  `tai_lieu_id` int(11) DEFAULT NULL,
  `vai_tro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nghien_cuu`
--

CREATE TABLE `nghien_cuu` (
  `id` varchar(20) NOT NULL,
  `ten` varchar(100) DEFAULT NULL,
  `chi_tiet` varchar(255) DEFAULT NULL,
  `thoi_gian_bat_dau` int(11) DEFAULT NULL,
  `thoi_gian_ket_thuc` int(11) DEFAULT NULL,
  `tong_thoi_gian` int(11) DEFAULT NULL,
  `danh_muc_id` int(11) DEFAULT NULL,
  `minh_chung` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nghien_cuu`
--

INSERT INTO `nghien_cuu` (`id`, `ten`, `chi_tiet`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`, `tong_thoi_gian`, `danh_muc_id`, `minh_chung`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
('1', 'HÆ°á»Ÿng dáº«n nghiÃªn cá»©u má»‘i quan há»‡ sáº¥m vÃ  phá»¥ ná»¯', '', 11111111, 22222222, 101, 4, 'e1c8628b2316da50f2d12dad8dc891f376ab2123-photo2.png', 1, 1556988667, 1557036277),
('88BsevEA', 'NghiÃªn cá»©u hiá»‡n tÆ°á»£ng hÆ°á»›ng xuáº¥t hiá»‡n cá»§a cáº§u vá»“ng', '12', 333333, 32222222, 1060, 2, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557025862, 1557065016),
('eHbIAzJH', 'Cáº£i tiáº¿n cÃ¡ch di chuyá»ƒn trÃªn xe bus', '', 123, 321, NULL, 6, '', 1, 1557024796, NULL),
('FNqIK6bv', 'Cáº£i tiáº¿n cÃ¡ch viáº¿t pháº¥n trÃªn báº£ng', '', 1233, 21212, NULL, 6, NULL, 1, 1557023155, NULL),
('i1zb319A', 'HÆ°á»›ng dáº«n nghiÃªn cá»©u chÃ³ Ä‘áº» vÃ  phá»¥ ná»¯', '123', 45555, 445555, NULL, 4, '146d62948890f878f06b487835ef06fb4f3ebc28-56162371_1182293551947511_7453549712210132992_n.jpg', 1, 1557025622, NULL),
('Ix6X708p', 'NghiÃªn cá»©u tá»‘c Ä‘á»™ xe mÃ¡y Ä‘á»ƒ dáº£m báº£o an toÃ n', '', 123, 4312, NULL, 5, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557026090, NULL),
('Jl4SAi0E', 'HÆ°á»Ÿng dáº«n nghiÃªn cá»©u hÃ¬nh thá»©c Ä‘i sÄƒn cá»§a loÃ i lá»£n á»‰n', '', 123, 321, NULL, 5, NULL, 1, 1556988894, 1556989645),
('pOW6ctcB', 'HÆ°á»›ng dáº«n nghiÃªn cá»©u cáº£i táº¡i káº¿t quáº£ thi', '', 123, 321, NULL, 4, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557025505, NULL),
('Pvy2yUZI', 'NghiÃªn cá»©u tá»‘c Ä‘á»™ xe mÃ¡y Ä‘á»ƒ dáº£m báº£o an toÃ n', '', 123, 4312, NULL, 5, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557025993, NULL),
('tG6L8P7D', 'NghiÃªn cá»©u tá»‘c Ä‘á»™ xe mÃ¡y Ä‘á»ƒ dáº£m báº£o an toÃ n', '', 123, 4312, NULL, 5, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557026036, NULL),
('ubXFZ4zA', 'NghiÃªn cá»©u phÃ¡t triá»ƒn há»‡ thá»‘ng thÃ´ng giÃ³ trong trÆ°á»ng há»c', '', 4444444, 33333333, NULL, 4, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557025353, NULL),
('uP6wLdRv', 'Cáº£i tiáº¿n cÃ¡ch nÃ³i chuyá»‡n trong trÆ°á»ng há»c', '', 1234444, 43212, NULL, 6, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557025120, NULL),
('Z3rTEVVT', 'NghiÃªn cá»©u tá»‘c Ä‘á»™ xe mÃ¡y Ä‘á»ƒ dáº£m báº£o an toÃ n', '', 123, 4312, 171, 5, '8349568bb1381fae5fb8e078a5cdba482fab8549-demo.pdf', 1, 1557026065, 1557062637);

-- --------------------------------------------------------

--
-- Table structure for table `sinh_vien`
--

CREATE TABLE `sinh_vien` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ma_sv` varchar(50) DEFAULT NULL,
  `gioi_tinh` int(11) DEFAULT NULL,
  `tong_thoi_gian` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sinh_vien`
--

INSERT INTO `sinh_vien` (`id`, `ten`, `email`, `ma_sv`, `gioi_tinh`, `tong_thoi_gian`, `trang_thai`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Minh Anh', 'minhanh@gmail.com', 'A1110', 0, 202, 1, 1556806914, 1556990076),
(2, 'Quyáº¿n', 'vquyenaaa@gmail.com', 'Q1112', 1, 248, 1, 1556990054, NULL),
(3, 'PhÆ°Æ¡ng Tháº£o', 'thaop@gmail.com', 'T2233', 0, 200, 1, 1556990125, NULL),
(4, 'LÃª Thá»‹ Há»“ng', 'honglt@gmail.com', 'T-1132', 0, 0, 1, 1557053077, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sinh_vien_nghien_cuu`
--

CREATE TABLE `sinh_vien_nghien_cuu` (
  `id` int(11) NOT NULL,
  `sinh_vien_id` int(11) DEFAULT NULL,
  `nghien_cuu_id` varchar(20) DEFAULT NULL,
  `thoi_gian` int(11) DEFAULT NULL,
  `vai_tro` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sinh_vien_nghien_cuu`
--

INSERT INTO `sinh_vien_nghien_cuu` (`id`, `sinh_vien_id`, `nghien_cuu_id`, `thoi_gian`, `vai_tro`) VALUES
(2, 1, 'Jl4SAi0E', 40, 'ThÃ nh viÃªn'),
(3, 2, '1', 10, 'ThÃ nh viÃªn'),
(5, 3, '1', 20, 'ThÃ nh viÃªn'),
(6, 1, '1', 30, 'ThÃ nh viÃªn'),
(38, 2, 'ubXFZ4zA', 20, 'ThÃ nh viÃªn'),
(39, 3, 'ubXFZ4zA', 30, 'ThÃ nh viÃªn'),
(40, 2, 'pOW6ctcB', 42, 'ThÃ nh viÃªn'),
(41, 1, 'pOW6ctcB', 12, 'ThÃ nh viÃªn'),
(42, 3, 'i1zb319A', 24, 'ThÃ nh viÃªn'),
(43, 2, 'i1zb319A', 32, 'ThÃ nh viÃªn'),
(44, 2, 'Pvy2yUZI', 36, 'ThÃ nh viÃªn'),
(45, 3, 'Pvy2yUZI', 36, 'ThÃ nh viÃªn'),
(46, 1, 'Pvy2yUZI', 36, 'ThÃ nh viÃªn'),
(47, 2, 'tG6L8P7D', 36, 'ThÃ nh viÃªn'),
(48, 3, 'tG6L8P7D', 36, 'ThÃ nh viÃªn'),
(49, 1, 'tG6L8P7D', 36, 'ThÃ nh viÃªn'),
(50, 2, 'Z3rTEVVT', 36, 'ThÃ nh viÃªn'),
(51, 3, 'Z3rTEVVT', 18, 'ThÃ nh viÃªn'),
(52, 1, 'Z3rTEVVT', 12, 'ThÃ nh viÃªn'),
(53, 2, 'Ix6X708p', 36, 'ThÃ nh viÃªn'),
(54, 3, 'Ix6X708p', 36, 'ThÃ nh viÃªn'),
(55, 1, 'Ix6X708p', 36, 'ThÃ nh viÃªn');

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `id` varchar(20) NOT NULL,
  `ten_dang_nhap` varchar(100) DEFAULT NULL,
  `ho_ten` varchar(100) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `muoi` varchar(50) DEFAULT NULL,
  `phan_quyen` tinyint(4) DEFAULT NULL,
  `ma_dang_nhap` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_het_han` int(11) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tai_khoan`
--

INSERT INTO `tai_khoan` (`id`, `ten_dang_nhap`, `ho_ten`, `hinh_anh`, `mat_khau`, `muoi`, `phan_quyen`, `ma_dang_nhap`, `trang_thai`, `ngay_het_han`, `ngay_tao`, `ngay_cap_nhat`) VALUES
('1', 'user', 'Nguyá»…n Minh Chiáº¿n', NULL, 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 1, NULL, 127, NULL, 1556709261, 1557051862),
('2', 'thaop', 'Nguyá»…n Minh Chiáº¿n', NULL, 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 1, 'deHPkrcTQfmojbU48gzzZpnGnYYtnCqDoItGGj96BUlqNSf3ZDSo1ckZy1BcNVXJ', 127, 1556892308, 1556709357, 1557051862),
('3', 'admin', 'Admin', 'a6fc7fdb8392702dda2941a18fa2a5265131eb3e-user1.jpg', 'ac7a38ba757a4b2c205ce7efab7bd279', 'DipJe', 1, '9B4UwKw2W3Fs9p4tUAqFvDUJiJYBpVDXdYGG3pQ0u4aZ2iDvBfLdYR2QQyk1FR7C', 1, 1557142314, 1556709707, 1557055897),
('8aXEPXCF', 'thaot', 'Thu Tháº£o', 'e3308cbae04fa732c47df9b7a4ff62e13d21ac76-user3.jpg', 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, 'SIUhIAM2VWTbjjxmfkSOxK35iO8QBTlG3h0kuJph01ECmbGxRkh2UW4hleqJVKQZ', 1, 1557131062, 1557044647, 1557052920),
('aBDwQgdW', 'huongpt', 'Pháº¡m thu HÆ°Æ¡ng', '087b65be77226d709180a8fc5cd10afffa0e3608-photo1.png', 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, NULL, 1, NULL, 1557048049, 1557053630),
('BsB7dbcQ', 'nguyenvanc', 'Nguyá»…n VÄƒn C', '98764e968dd1f5b7a92a15494d5cc377e113e2fe-avatar3.png', '40e75f86ad707efd9c9f2520f90d1ebe', 'vXlsn', NULL, NULL, NULL, NULL, NULL, NULL),
('L9AdMFF7', 'chiennm', 'Nguyá»…n Minh Chiáº¿n', NULL, 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, NULL, 1, NULL, 1557042685, 1557051862),
('rHPZgIew', 'cuccc', 'Cá»±c cÃ¬ cá»¥c', 'c295afd4311682807535e1a02a4c90007da00a28-avatar4.png', 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, NULL, 1, NULL, 1557048541, 1557052863),
('sGve7bsu', 'chiennm', 'Nguyá»…n Minh Chiáº¿n', '087b65be77226d709180a8fc5cd10afffa0e3608-photo1.png', 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, NULL, 1, NULL, 1557049201, 1557052790),
('T7WxN96B', 'trongnt', 'Nguyá»…n TrÃ¢n Trá»ng', 'fa772ed110e7ea98f927884bc61c118fc3fd77a8-avatar.png', 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, NULL, 1, NULL, 1557048241, 1557053646),
('VfSveWIt', 'linhpp', 'Pháº¡m PhÆ°Æ¡ng Linh', '221bffc125e97decada22541605793c6e57c6466-avatar2.png', 'dea02fd82a40d08c94da192b5de6eda1', 'yZxVa', 2, NULL, 1, NULL, 1557049057, 1557052845);

-- --------------------------------------------------------

--
-- Table structure for table `tai_lieu`
--

CREATE TABLE `tai_lieu` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) DEFAULT NULL,
  `chi_tiet` varchar(255) DEFAULT NULL,
  `thoi_gian_bat_dau` int(11) DEFAULT NULL,
  `thoi_gian_ket_thuc` int(11) DEFAULT NULL,
  `tong_thoi_gian` int(11) DEFAULT NULL,
  `danh_muc_id` int(11) DEFAULT NULL,
  `minh_chung` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chuc_danh`
--
ALTER TABLE `chuc_danh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danh_muc_nghien_cuu`
--
ALTER TABLE `danh_muc_nghien_cuu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danh_muc_tai_lieu`
--
ALTER TABLE `danh_muc_tai_lieu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `don_vi_cong_tac`
--
ALTER TABLE `don_vi_cong_tac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giao_vien`
--
ALTER TABLE `giao_vien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giao_vien_nghien_cuu`
--
ALTER TABLE `giao_vien_nghien_cuu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giao_vien_tai_lieu`
--
ALTER TABLE `giao_vien_tai_lieu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nghien_cuu`
--
ALTER TABLE `nghien_cuu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sinh_vien`
--
ALTER TABLE `sinh_vien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sinh_vien_nghien_cuu`
--
ALTER TABLE `sinh_vien_nghien_cuu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chuc_danh`
--
ALTER TABLE `chuc_danh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `danh_muc_nghien_cuu`
--
ALTER TABLE `danh_muc_nghien_cuu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `danh_muc_tai_lieu`
--
ALTER TABLE `danh_muc_tai_lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `don_vi_cong_tac`
--
ALTER TABLE `don_vi_cong_tac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `giao_vien`
--
ALTER TABLE `giao_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `giao_vien_nghien_cuu`
--
ALTER TABLE `giao_vien_nghien_cuu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `giao_vien_tai_lieu`
--
ALTER TABLE `giao_vien_tai_lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sinh_vien`
--
ALTER TABLE `sinh_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sinh_vien_nghien_cuu`
--
ALTER TABLE `sinh_vien_nghien_cuu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tai_lieu`
--
ALTER TABLE `tai_lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
