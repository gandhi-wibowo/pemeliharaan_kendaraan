-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2017 at 10:49 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_opr`
--
CREATE DATABASE IF NOT EXISTS `db_opr` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_opr`;

-- --------------------------------------------------------

--
-- Table structure for table `asuransi`
--

CREATE TABLE IF NOT EXISTS `asuransi` (
  `id_asuransi` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `berlaku_asuransi` date NOT NULL,
  `biaya_asuransi` int(8) unsigned DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` enum('history','active') NOT NULL,
  `id_fpk` int(11) NOT NULL,
  `id_master_asuransi` int(11) NOT NULL,
  PRIMARY KEY (`id_asuransi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `asuransi`
--

INSERT INTO `asuransi` (`id_asuransi`, `id_kendaraan`, `berlaku_asuransi`, `biaya_asuransi`, `tgl_input`, `tgl_pelaksanaan`, `id_user`, `keterangan`, `status`, `id_fpk`, `id_master_asuransi`) VALUES
(9, 16, '2018-02-02', 33639002, '2017-03-09 19:21:17', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0, 8),
(10, 18, '2018-02-01', 4552101, '2017-03-07 11:09:34', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
  `id_barcode` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `tgl_cari` datetime NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_barcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `barcode`
--

INSERT INTO `barcode` (`id_barcode`, `id_kendaraan`, `tgl_cari`, `id_user`, `keterangan`) VALUES
(1, 13, '2017-03-08 21:47:48', 2, ''),
(2, 16, '2017-03-08 21:58:56', 2, ''),
(3, 19, '2017-03-09 19:14:40', 3, ''),
(4, 19, '2017-03-09 19:14:50', 2, ''),
(5, 17, '2017-03-09 19:40:25', 3, ''),
(6, 15, '2017-03-09 19:40:41', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `form_pengajuan_kerja`
--

CREATE TABLE IF NOT EXISTS `form_pengajuan_kerja` (
  `id_fpk` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_persetujuan` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status_fpk` enum('pending','approve','reject') NOT NULL,
  `status_pelaksanaan` enum('active','history') NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `peruntukan` enum('asuransi','kir','pajak','service','stnk') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_fpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE IF NOT EXISTS `kendaraan` (
  `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT,
  `no_polisi` varchar(12) NOT NULL,
  `nama_stnk` varchar(35) NOT NULL,
  `merk` varchar(25) NOT NULL,
  `jenis` enum('mobil','truk','motor') NOT NULL,
  `tahun_pembuatan` year(4) NOT NULL,
  `no_rangka` varchar(35) NOT NULL,
  `no_mesin` varchar(35) NOT NULL,
  `posisi_stnk` varchar(35) NOT NULL,
  `nama_bpkb` varchar(35) NOT NULL,
  `posisi_bpkb` varchar(35) NOT NULL,
  `status_kendaraan` varchar(10) NOT NULL,
  `id_master_asuransi` tinyint(2) unsigned DEFAULT NULL,
  `id_penggunakendaraan` int(11) NOT NULL,
  PRIMARY KEY (`id_kendaraan`),
  UNIQUE KEY `no_polisi` (`no_polisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `no_polisi`, `nama_stnk`, `merk`, `jenis`, `tahun_pembuatan`, `no_rangka`, `no_mesin`, `posisi_stnk`, `nama_bpkb`, `posisi_bpkb`, `status_kendaraan`, `id_master_asuransi`, `id_penggunakendaraan`) VALUES
(13, 'BM 8721 TJ', 'PT. BANGUN GLOBALINDO PERKASA', 'MAZDA/P-UP', 'truk', 2012, 'MM6UNY0W4C0917786', 'WLAT1343536', 'MAHRUS IRFAN', 'PT. BANGUN GLOBALINDO PERKASA', 'KANTOR PEKANBARU', 'LUNAS', 0, 15),
(14, 'BM 4742 NW', 'PT. BANGUN GLOBALINDO PERKASA', 'HNDA/REVO', 'motor', 2016, 'MH1JBK31XGK136174', 'JBK3E1136016', 'SAHAT MARULI AMBARITA', 'PT. BANGUN GLOBALINDO PERKASA', 'KANTOR PEKANBARU', 'LUNAS', 0, 16),
(15, 'BM 1224 NG', 'PT. BANGUN GLOBALINDO PERKASA', 'TYTA/INNOVA', 'mobil', 2013, 'MHFXR42GXD0024063', 'MHFXR42GXD0024063', 'LIYANTI', 'PT. BANGUN GLOBALINDO PERKASA', 'KANTOR PEKANBARU', 'LUNAS', 0, 17),
(17, 'BM 8353 AK', 'PT. BANGUN GLOBALINDO PERKASA', 'MITS/P-UP', 'truk', 2001, 'MHML300DP1R276656', '4D56C-131776', 'ARIS GIARTO', 'PT. BANGUN GLOBALINDO PERKASA', 'KANTOR PEKANBARU', 'LUNAS', 0, 19),
(18, 'BM 1017 NY', 'PT.BANGUN GLOBALINDO PERKASA', 'TYTA/AVANZA VLZ', 'mobil', 2015, 'MHKM1CA4JFK093596', '3SZDFE0527', 'ENI', 'PT.BANGUN GLOBALINDO PERKASA', 'KANTOR PEKANBARU', 'LUNAS', 7, 20),
(19, 'BM 1018 NY', 'PT.BANGUN GLOBALINDO PERKASA', 'TYTA/AVANZA NW', 'mobil', 2015, 'MHKM1BA3JFJ104653', 'K3MF44721', 'ANTON', 'PT.BANGUN GLOBALINDO PERKASA', 'KKBCA', 'LUNAS', 0, 21),
(20, 'BM 5568 AQ', 'PT. BANGUN GLOBALINDO PERKASA', 'HONDA/R2', 'motor', 2000, 'MH1NFGD16YK001213', 'NFGDE-1001333', 'ABDUL MALIK', 'PT. BANGUN GLOBALINDO PERKASA', 'KANTOR PEKANBARU', 'LUNAS', 0, 23),
(21, 'BM 1658 NI', 'PAK HASAN', 'AVANZA', 'mobil', 2016, '43567890HBJNDM', '5467890OSHDB', 'PAK HASAN', 'PAK HASAN', 'UMRI', 'LUNAS', 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `kir`
--

CREATE TABLE IF NOT EXISTS `kir` (
  `id_kir` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `berlaku_kir` date NOT NULL,
  `biaya_kir` int(8) unsigned DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` enum('history','active') NOT NULL,
  `id_fpk` int(11) NOT NULL,
  PRIMARY KEY (`id_kir`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `kir`
--

INSERT INTO `kir` (`id_kir`, `id_kendaraan`, `berlaku_kir`, `biaya_kir`, `tgl_input`, `tgl_pelaksanaan`, `id_user`, `keterangan`, `status`, `id_fpk`) VALUES
(10, 13, '2017-08-22', 96000, '2017-03-07 11:02:05', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(11, 17, '2017-06-06', 85000, '2017-03-10 07:39:51', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_asuransi`
--

CREATE TABLE IF NOT EXISTS `master_asuransi` (
  `id_master_asuransi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_asuransi` varchar(35) NOT NULL,
  PRIMARY KEY (`id_master_asuransi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `master_asuransi`
--

INSERT INTO `master_asuransi` (`id_master_asuransi`, `nama_asuransi`) VALUES
(7, 'RAKSA'),
(8, 'RELIANCE'),
(9, 'SINARMAS');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT,
  `judul_notifikasi` varchar(255) NOT NULL,
  `isi_notifikasi` varchar(255) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `tgl_kirim_notifikasi` datetime NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `pemilik` enum('asuransi','kir','pajak','service','stnk') NOT NULL,
  `id_pemilik` int(11) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_notifikasi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=367 ;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `judul_notifikasi`, `isi_notifikasi`, `id_kendaraan`, `tgl_kirim_notifikasi`, `status`, `pemilik`, `id_pemilik`, `id_user`) VALUES
(201, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 07:19:11', 'success', 'service', 15, 2),
(202, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 07:19:11', 'success', 'service', 15, 3),
(233, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 07:40:04', 'success', 'service', 15, 2),
(234, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 07:40:04', 'success', 'service', 15, 3),
(235, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:01:33', 'success', 'service', 15, 2),
(236, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:01:33', 'success', 'service', 15, 3),
(237, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:02:13', 'success', 'service', 15, 2),
(238, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:02:13', 'success', 'service', 15, 3),
(239, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:03:13', 'success', 'service', 15, 2),
(240, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:03:13', 'success', 'service', 15, 3),
(241, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:04:13', 'success', 'service', 15, 2),
(242, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:04:13', 'success', 'service', 15, 3),
(243, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:05:13', 'success', 'service', 15, 2),
(244, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:05:13', 'success', 'service', 15, 3),
(245, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:06:13', 'success', 'service', 15, 2),
(246, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:06:13', 'success', 'service', 15, 3),
(247, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:07:13', 'success', 'service', 15, 2),
(248, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:07:13', 'success', 'service', 15, 3),
(249, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:08:13', 'success', 'service', 15, 2),
(250, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:08:13', 'success', 'service', 15, 3),
(251, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:09:13', 'success', 'service', 15, 2),
(252, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:09:13', 'success', 'service', 15, 3),
(253, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:10:13', 'success', 'service', 15, 2),
(254, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:10:13', 'success', 'service', 15, 3),
(255, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:11:13', 'success', 'service', 15, 2),
(256, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:11:13', 'success', 'service', 15, 3),
(257, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:12:13', 'success', 'service', 15, 2),
(258, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:12:13', 'success', 'service', 15, 3),
(259, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:13:13', 'success', 'service', 15, 2),
(260, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:13:13', 'success', 'service', 15, 3),
(261, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:14:13', 'success', 'service', 15, 2),
(262, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:14:13', 'success', 'service', 15, 3),
(263, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:15:13', 'success', 'service', 15, 2),
(264, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:15:13', 'success', 'service', 15, 3),
(265, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:16:13', 'success', 'service', 15, 2),
(266, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:16:13', 'success', 'service', 15, 3),
(267, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:17:13', 'success', 'service', 15, 2),
(268, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:17:13', 'success', 'service', 15, 3),
(269, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:18:13', 'success', 'service', 15, 2),
(270, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:18:13', 'success', 'service', 15, 3),
(271, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:19:13', 'success', 'service', 15, 2),
(272, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:19:13', 'success', 'service', 15, 3),
(273, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:20:13', 'success', 'service', 15, 2),
(274, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:20:13', 'success', 'service', 15, 3),
(275, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:21:13', 'success', 'service', 15, 2),
(276, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:21:13', 'success', 'service', 15, 3),
(277, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:22:13', 'success', 'service', 15, 2),
(278, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:22:13', 'success', 'service', 15, 3),
(279, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:23:13', 'success', 'service', 15, 2),
(280, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:23:13', 'success', 'service', 15, 3),
(281, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:24:13', 'success', 'service', 15, 2),
(282, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:24:13', 'success', 'service', 15, 3),
(283, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:25:13', 'success', 'service', 15, 2),
(284, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:25:13', 'success', 'service', 15, 3),
(285, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:26:13', 'success', 'service', 15, 2),
(286, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:26:13', 'success', 'service', 15, 3),
(287, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:27:13', 'success', 'service', 15, 2),
(288, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:27:13', 'success', 'service', 15, 3),
(289, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:28:13', 'success', 'service', 15, 2),
(290, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:28:13', 'success', 'service', 15, 3),
(291, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:29:13', 'success', 'service', 15, 2),
(292, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:29:13', 'success', 'service', 15, 3),
(293, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:30:13', 'success', 'service', 15, 2),
(294, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:30:13', 'success', 'service', 15, 3),
(295, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:31:13', 'success', 'service', 15, 2),
(296, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:31:13', 'success', 'service', 15, 3),
(297, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:32:13', 'success', 'service', 15, 2),
(298, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:32:13', 'success', 'service', 15, 3),
(299, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:33:13', 'success', 'service', 15, 2),
(300, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:33:13', 'success', 'service', 15, 3),
(301, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:34:13', 'success', 'service', 15, 2),
(302, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:34:13', 'success', 'service', 15, 3),
(303, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:35:13', 'success', 'service', 15, 2),
(304, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:35:13', 'success', 'service', 15, 3),
(305, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:36:13', 'success', 'service', 15, 2),
(306, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:36:13', 'success', 'service', 15, 3),
(307, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:37:13', 'success', 'service', 15, 2),
(308, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:37:13', 'success', 'service', 15, 3),
(309, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:38:13', 'success', 'service', 15, 2),
(310, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:38:13', 'success', 'service', 15, 3),
(311, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:39:13', 'success', 'service', 15, 2),
(312, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:39:13', 'success', 'service', 15, 3),
(313, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:40:13', 'success', 'service', 15, 2),
(314, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:40:13', 'success', 'service', 15, 3),
(315, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:41:13', 'success', 'service', 15, 2),
(316, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:41:13', 'success', 'service', 15, 3),
(317, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:42:13', 'success', 'service', 15, 2),
(318, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:42:13', 'success', 'service', 15, 3),
(319, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:43:13', 'success', 'service', 15, 2),
(320, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:43:13', 'success', 'service', 15, 3),
(321, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:44:13', 'success', 'service', 15, 2),
(322, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:44:13', 'success', 'service', 15, 3),
(323, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:45:13', 'success', 'service', 15, 2),
(324, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:45:13', 'success', 'service', 15, 3),
(325, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:46:13', 'success', 'service', 15, 2),
(326, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:46:13', 'success', 'service', 15, 3),
(327, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:47:13', 'success', 'service', 15, 2),
(328, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:47:13', 'success', 'service', 15, 3),
(329, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:48:13', 'success', 'service', 15, 2),
(330, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:48:13', 'success', 'service', 15, 3),
(331, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:49:13', 'success', 'service', 15, 2),
(332, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:49:13', 'success', 'service', 15, 3),
(333, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:50:13', 'success', 'service', 15, 2),
(334, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:50:13', 'success', 'service', 15, 3),
(335, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:51:13', 'success', 'service', 15, 2),
(336, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:51:13', 'success', 'service', 15, 3),
(337, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:52:13', 'success', 'service', 15, 2),
(338, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:52:13', 'success', 'service', 15, 3),
(339, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:53:13', 'success', 'service', 15, 2),
(340, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:53:13', 'success', 'service', 15, 3),
(341, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:54:13', 'success', 'service', 15, 2),
(342, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:54:13', 'success', 'service', 15, 3),
(343, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:55:13', 'success', 'service', 15, 2),
(344, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:55:13', 'success', 'service', 15, 3),
(345, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:56:13', 'success', 'service', 15, 2),
(346, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:56:13', 'success', 'service', 15, 3),
(347, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:57:13', 'failed', 'service', 15, 2),
(348, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:57:13', 'failed', 'service', 15, 3),
(349, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:58:13', 'failed', 'service', 15, 2),
(350, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:58:13', 'failed', 'service', 15, 3),
(351, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:59:13', 'failed', 'service', 15, 2),
(352, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 11:59:13', 'failed', 'service', 15, 3),
(353, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:00:13', 'failed', 'service', 15, 2),
(354, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:00:13', 'failed', 'service', 15, 3),
(355, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:01:13', 'failed', 'service', 15, 2),
(356, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:01:13', 'failed', 'service', 15, 3),
(357, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:02:13', 'failed', 'service', 15, 2),
(358, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:02:13', 'failed', 'service', 15, 3),
(359, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:03:13', 'failed', 'service', 15, 2),
(360, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:03:13', 'failed', 'service', 15, 3),
(361, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:04:13', 'failed', 'service', 15, 2),
(362, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:04:13', 'failed', 'service', 15, 3),
(363, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:05:13', 'failed', 'service', 15, 2),
(364, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:05:13', 'failed', 'service', 15, 3),
(365, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:06:13', 'failed', 'service', 15, 2),
(366, 'Notifikasi SERVICE', 'Masa berlaku SERVICE kendaraan BM 1018 NY akan berakhir pada 11 Mar 2017', 19, '2017-03-10 12:06:13', 'failed', 'service', 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pajak`
--

CREATE TABLE IF NOT EXISTS `pajak` (
  `id_pajak` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `berlaku_pajak` date NOT NULL,
  `biaya_pajak` int(8) unsigned DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` enum('history','active') NOT NULL,
  `id_fpk` int(11) NOT NULL,
  PRIMARY KEY (`id_pajak`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `pajak`
--

INSERT INTO `pajak` (`id_pajak`, `id_kendaraan`, `berlaku_pajak`, `biaya_pajak`, `tgl_input`, `tgl_pelaksanaan`, `id_user`, `keterangan`, `status`, `id_fpk`) VALUES
(10, 13, '2018-01-30', 4272000, '2017-03-07 11:02:05', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(11, 14, '2017-06-01', 170000, '2017-03-09 19:37:36', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(12, 15, '2017-12-20', 3466000, '2017-03-07 10:55:27', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(13, 16, '2017-12-28', 12675000, '2017-03-09 19:21:17', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(14, 17, '2018-01-15', 1355000, '2017-03-10 07:39:51', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(15, 18, '2018-02-02', 2445000, '2017-03-07 11:09:34', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(16, 19, '2018-02-02', 2288000, '2017-03-10 07:11:44', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(17, 20, '2018-01-12', 110000, '2017-03-07 11:17:01', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(18, 21, '2017-03-14', 5678, '2017-03-10 11:40:52', '2017-03-10', 1, 'SDFGYHJBN', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_kendaraan`
--

CREATE TABLE IF NOT EXISTS `pengguna_kendaraan` (
  `id_penggunakendaraan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(35) NOT NULL,
  `jabatan_pengguna` varchar(35) NOT NULL,
  `no_telp` varchar(16) NOT NULL,
  `tgl_input` date NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_penggunakendaraan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `pengguna_kendaraan`
--

INSERT INTO `pengguna_kendaraan` (`id_penggunakendaraan`, `nama_pengguna`, `jabatan_pengguna`, `no_telp`, `tgl_input`, `id_user`) VALUES
(15, 'MAHRUS IRFAN', 'DRIVER', '', '0000-00-00', 0),
(16, 'SAHAT MARULI AMBARITA', 'KEPALA GUDANG', '', '0000-00-00', 0),
(17, 'LIYANTI', 'HEAD OF EXPORT-IMPORT', '', '0000-00-00', 0),
(18, 'TONI', 'CEO', '', '0000-00-00', 0),
(19, 'ARIS GIARTO', 'DRIVER', '', '0000-00-00', 0),
(20, 'ENI', 'HEAD OF SUPPLY CHAIN', '', '0000-00-00', 0),
(21, 'ANTON', 'DRIVER', '', '0000-00-00', 0),
(22, 'DESLIANO', 'HEAD OF TECHNICAL SUPPORT', '', '0000-00-00', 0),
(23, 'ABDUL MALIK', 'SALES LUAR KOTA', '', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `berlaku_service` date NOT NULL,
  `biaya_service` int(8) unsigned DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` enum('history','active') NOT NULL,
  `id_fpk` int(11) NOT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `id_kendaraan`, `berlaku_service`, `biaya_service`, `tgl_input`, `tgl_pelaksanaan`, `id_user`, `keterangan`, `status`, `id_fpk`) VALUES
(9, 13, '2017-05-15', 817661, '2017-03-07 11:02:05', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(10, 14, '2017-03-10', 32538, '2017-03-09 19:37:36', '2017-03-07', 1, 'PERIODE AWAL', 'history', 0),
(11, 15, '2017-04-26', 663392, '2017-03-07 10:55:27', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(12, 16, '2017-03-10', 2425995, '2017-03-07 11:00:58', '2017-03-07', 1, 'PERIODE AWAL', 'history', 0),
(13, 17, '2017-06-09', 259347, '2017-03-10 07:39:51', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(14, 18, '2017-05-09', 467973, '2017-03-07 11:09:34', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(15, 19, '2017-03-11', 437923, '2017-03-10 07:11:44', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(16, 20, '2017-06-30', 65000, '2017-03-07 11:17:01', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(17, 14, '2017-09-09', 346789, '2017-03-09 20:04:49', '2017-03-09', 1, '', 'active', 4),
(18, 21, '2017-03-25', 65789, '2017-03-10 11:40:52', '2017-03-14', 1, 'DFHGJ', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stnk`
--

CREATE TABLE IF NOT EXISTS `stnk` (
  `id_stnk` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `berlaku_stnk` date NOT NULL,
  `biaya_stnk` int(8) unsigned DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_pelaksanaan` date DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` enum('history','active') NOT NULL,
  `id_fpk` int(11) NOT NULL,
  PRIMARY KEY (`id_stnk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `stnk`
--

INSERT INTO `stnk` (`id_stnk`, `id_kendaraan`, `berlaku_stnk`, `biaya_stnk`, `tgl_input`, `tgl_pelaksanaan`, `id_user`, `keterangan`, `status`, `id_fpk`) VALUES
(24, 13, '2018-03-30', 7433280, '2017-03-07 11:02:05', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(25, 14, '2021-06-01', 295800, '2017-03-09 19:37:36', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(26, 15, '2018-12-20', 6030840, '2017-03-07 10:55:27', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(27, 16, '2018-12-28', 22054500, '2017-03-09 19:21:17', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(28, 17, '2020-01-15', 2357700, '2017-03-10 07:39:51', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(29, 18, '2020-02-02', 4254300, '2017-03-07 11:09:34', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(30, 19, '2020-02-02', 3981120, '2017-03-10 07:11:44', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(31, 20, '2021-01-12', 191400, '2017-03-07 11:17:01', '2017-03-07', 1, 'PERIODE AWAL', 'active', 0),
(32, 21, '2017-03-23', 567890, '2017-03-10 11:40:52', '2017-03-10', 1, 'DXFCJHBKNL', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(35) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `password` char(40) NOT NULL,
  `tipe_user` enum('manager','admin','slapangan') NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `terakhir_login` datetime NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `namalengkap`, `password`, `tipe_user`, `no_telp`, `terakhir_login`, `token`) VALUES
(1, 'admin', 'Admin Opr', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', '+6281212121212', '2017-03-10 11:09:16', ''),
(2, 'staff', 'Staff Lapangan', '6ccb4b7c39a6e77f76ecfa935a855c6c46ad5611', 'slapangan', '+6281234343434', '2017-03-10 11:43:36', 'dRaJs0BnVXA:APA91bH4UaSAgK-aTKNKQ0JPAy0NzJx4_nGx0Hm0CBJn77DtxR0FXmTXXFGK8qQpMMlwo5CsSSjOY0B21u5mWibYHp-1Xg6L4QWpfATT_eVCUuw3K8G1NkDTDUw5j3Q7v9TU0V4ZUgNl'),
(3, 'manager', 'Manager', '1a8565a9dc72048ba03b4156be3e569f22771f23', 'manager', '+6281256565656', '2017-03-10 10:51:45', 'fJF4G4u2UWM:APA91bFET1NTdaCJCORgLc3WpzoprFGSar11Ngrbj6o6SppK74UgARZLgUcCgQRlD_NqXXTM2-gB_ti-sqwGJhLqNYAqT6cssdqlW4m35_WAd-0YZO1z5VfshZAiwAeYZKrr7OSZBr4p');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
