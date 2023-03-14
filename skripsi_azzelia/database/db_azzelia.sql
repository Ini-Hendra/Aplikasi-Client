-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22 Jun 2020 pada 05.03
-- Versi Server: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_azzelia`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_customer` varchar(10) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `no_po` varchar(30) NOT NULL,
  `tgl_po` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_file`
--

CREATE TABLE `tb_file` (
  `id_file` varchar(10) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `no_po` varchar(30) NOT NULL,
  `tgl_po` date NOT NULL,
  `nama_file` varchar(50) NOT NULL,
  `file` varchar(50) NOT NULL,
  `file2` varchar(50) DEFAULT NULL,
  `file3` varchar(50) DEFAULT NULL,
  `file4` varchar(50) DEFAULT NULL,
  `file5` varchar(50) DEFAULT NULL,
  `file6` varchar(50) DEFAULT NULL,
  `file7` varchar(50) DEFAULT NULL,
  `file8` varchar(50) DEFAULT NULL,
  `file9` varchar(50) DEFAULT NULL,
  `file10` varchar(50) DEFAULT NULL,
  `spesifikasi` text,
  `kategori` varchar(20) NOT NULL,
  `tgl_upload` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_login`
--

CREATE TABLE `tb_login` (
  `id_login` varchar(10) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_login`
--

INSERT INTO `tb_login` (`id_login`, `username`, `password`, `level`) VALUES
('LOG2486315', 'admin1', 'YWRtaW4=', 'Admin'),
('LOG3529581', 'marketing', 'bWFya2V0aW5n', 'Marketing'),
('LOG5156273', 'manager', 'bWFuYWdlcg==', 'Manager');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_po`
--

CREATE TABLE `tb_po` (
  `id_po` varchar(10) NOT NULL,
  `no_po` varchar(25) NOT NULL,
  `nama_pt` varchar(50) NOT NULL,
  `keterangan` text,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tb_file`
--
ALTER TABLE `tb_file`
  ADD PRIMARY KEY (`id_file`);

--
-- Indexes for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `tb_po`
--
ALTER TABLE `tb_po`
  ADD PRIMARY KEY (`id_po`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
