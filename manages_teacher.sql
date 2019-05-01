-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2019 at 02:36 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Database: `manages_teacher`
--

-- --------------------------------------------------------

--
-- Table structure for table `position`
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
  `tai_khoan_id` int(11) DEFAULT NULL,
  `gioi_tinh` tinyint(4) DEFAULT NULL,
  `gio_nckh` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) NOT NULL,
  `ngay_tao` int(11) NOT NULL,
  `ngay_cap_nhat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
-- Đơn vị công tác

CREATE TABLE `don_vi_cong_tac` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `chi_tiet` text,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `tai_khoan` (
  `id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(100) DEFAULT NULL,
  `ho_ten` varchar(100) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `muoi` varchar(50) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `phan_quyen` tinyint(4) DEFAULT NULL,
  `ma_dang_nhap` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_het_han` int(11) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- Danh mục nghiên cứu
CREATE TABLE `danh_muc_nghien_cuu` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ten` varchar(255) DEFAULT NULL,
  `chi_tiet` text DEFAULT NULL,
  `ma` varchar(50) DEFAULT NULL,
  `thoi_gian_dinh_muc` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `RESEARCH`
-- Nghiên cứu  khoa học

CREATE TABLE `nghien_cuu` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
CREATE TABLE `sinh_vien` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ten` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ma_sv` varchar(50) DEFAULT NULL,
  `gioi_tinh` int(11) DEFAULT NULL,
  `tong_thoi_gian` int(11) DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT NULL,
  `ngay_tao` int(11) DEFAULT NULL,
  `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- học sinh nghiên cứu khoa học
CREATE TABLE `sinh_vien_nghien_cuu` (
 `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `sinh_vien_id` int(11) DEFAULT NULL,
 `nghien_cuu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Giáo viên nghiên cứu
CREATE TABLE `giao_vien_nghien_cuu` (
 `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `giao_vien_id` int(11) DEFAULT NULL,
 `nghien_cuu_id` int(11) DEFAULT NULL,
 `thoi_gian` int(11) DEFAULT NULL,
 `vai_tro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Danh mục nghiên cứu
CREATE TABLE `danh_muc_tai_lieu` (
 `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `ten` varchar(255) DEFAULT NULL,
 `chi_tiet` text DEFAULT NULL,
 `thoi_gian_dinh_muc` int(11) DEFAULT NULL,
 `trang_thai` tinyint(4) DEFAULT NULL,
 `ngay_tao` int(11) DEFAULT NULL,
 `ngay_cap_nhat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- Giáo trình , tài liệu
CREATE TABLE `tai_lieu` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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


-- Giáo viên biên soạn
CREATE TABLE `giao_vien_tai_lieu` (
`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`giao_vien_id` int(11) DEFAULT NULL,
`tai_lieu_id` int(11) DEFAULT NULL,
`vai_tro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- -- Danh mục nghiên cứu
-- CREATE TABLE `danh_muc_bai_bao` (
--  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
--  `ten` varchar(255) DEFAULT NULL,
--  `chi_tiet` text DEFAULT NULL,
--  `tong_thoi_gian` int(11) DEFAULT NULL,
--  `trang_thai` tinyint(4) DEFAULT NULL,
--  `ngay_tao` int(11) DEFAULT NULL,
--  `ngay_cap_nhat` int(11) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
--
--
-- -- Giáo trình , tài liệu
-- CREATE TABLE `bai_bao` (
--   `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
--   `ten` varchar(100) DEFAULT NULL,
--   `tom_tat` varchar(100) DEFAULT NULL,
--   `chi_tiet` varchar(255) DEFAULT NULL,
--   `thoi_gian_bat_dau` int(11) DEFAULT NULL,
--   `thoi_gian_ket_thuc` int(11) DEFAULT NULL,
--   `tong_thoi_gian` int(11) DEFAULT NULL,
--   `danh_muc_id` int(11) DEFAULT NULL,
--   `hinh_anh` varchar(255) DEFAULT NULL,
--   `tac_gia` varchar(255) DEFAULT NULL,
--   `trang_thai` tinyint(4) DEFAULT NULL,
--   `ngay_tao` int(11) DEFAULT NULL,
--   `ngay_cap_nhat` int(11) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
--
-- -- Giáo viên biên soạn
-- CREATE TABLE `giao_vien_bai_bao` (
-- `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- `giao_vien_id` int(11) DEFAULT NULL,
-- `bai_bao_id` int(11) DEFAULT NULL,
-- `vai_tro` int(11) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `position`
--
ALTER TABLE `chuc_danh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giao_vien`
--
ALTER TABLE `giao_vien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `don_vi_cong_tac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `chuc_danh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giao_vien`
--
ALTER TABLE `giao_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `don_vi_cong_tac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `tai_khoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
