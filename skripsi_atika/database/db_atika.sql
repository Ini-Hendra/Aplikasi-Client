-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2021 at 02:26 AM
-- Server version: 10.1.25-MariaDB
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
-- Database: `db_atika`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(10) NOT NULL,
  `posting` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `username`, `password`, `level`, `posting`) VALUES
('ADM3119567', 'Siti Atikah Salia', 'rw', 'cnc=', 'RW', '2021-01-10 19:41:30'),
('ADM6289121', 'Siti Atikah Salia', '02', 'MDI=', 'RT', '2021-01-10 19:40:26'),
('ADM7569812', 'Siti Atikah Salia', '01', 'MDE=', 'RT', '2021-01-10 19:40:39'),
('ADM9573262', 'Siti Atikah Salia', '03', 'MDM=', 'RT', '2021-01-10 19:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_berita`
--

CREATE TABLE `tb_berita` (
  `id_berita` varchar(10) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(20) DEFAULT NULL,
  `author` varchar(15) DEFAULT NULL,
  `posting` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_berita`
--

INSERT INTO `tb_berita` (`id_berita`, `judul`, `isi`, `gambar`, `author`, `posting`) VALUES
('5479736', 'Suntik Vaksin Warga', 'Seiring berkembangnya teknologi yang semakin cepat tentu menyebabkan perubahan yang signifikan di berbagai aspek kehidupan terutama di lingkungan akademik. Aplikasi akademik memiliki peranan penting bagi setiap mahasiswa, dosen maupun staf akademik lainnya. Kebutuhan akan adanya informasi tentu sangat penting bagi kalangan mahasiswa supaya tidak ketinggalan informasi terbaru. Selain itu sistem akademik harus sepenuhnya memberikan pelayanan yang optimal guna menunjang kualitas dan kinerja suatu lembaga perkuliahan.\r\n\r\nSeiring berkembangnya teknologi yang semakin cepat tentu menyebabkan perubahan yang signifikan di berbagai aspek kehidupan terutama di lingkungan akademik. Aplikasi akademik memiliki peranan penting bagi setiap mahasiswa, dosen maupun staf akademik lainnya. Kebutuhan akan adanya informasi tentu sangat penting bagi kalangan mahasiswa supaya tidak ketinggalan informasi terbaru. Selain itu sistem akademik harus sepenuhnya memberikan pelayanan yang optimal guna menunjang kualitas dan kinerja suatu lembaga perkuliahan.', '5479736.jpg', 'admin', '2021-01-02 02:01:24'),
('9147542', 'Kegiatan Gotong Royong', 'Seiring berkembangnya teknologi yang semakin cepat tentu menyebabkan perubahan yang signifikan di berbagai aspek kehidupan terutama di lingkungan akademik. Aplikasi akademik memiliki peranan penting bagi setiap mahasiswa, dosen maupun staf akademik lainnya. Kebutuhan akan adanya informasi tentu sangat penting bagi kalangan mahasiswa supaya tidak ketinggalan informasi terbaru. Selain itu sistem akademik harus sepenuhnya memberikan pelayanan yang optimal guna menunjang kualitas dan kinerja suatu lembaga perkuliahan.', '9147542.jpg', 'admin', '2021-01-02 02:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `tb_comment`
--

CREATE TABLE `tb_comment` (
  `id_comment` varchar(15) NOT NULL,
  `id_berita` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `id_jenis` int(5) NOT NULL,
  `surat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`id_jenis`, `surat`) VALUES
(1, 'KTP Baru / Perpanjang'),
(2, 'Kartu Keluarga'),
(3, 'Kelahiran Baru / Lama'),
(4, 'Kematian / Keterangan Waris'),
(5, 'Pindah Keluar / Masuk'),
(6, 'Ijin Keramaian'),
(7, 'Keterangan Keluarga / Ekonomi Lemah'),
(8, 'Ijin Usaha / IMB'),
(9, 'Keterangan Tempat Tinggal / Domisili'),
(10, 'Nikah / Talak / Rujuk / Cerai'),
(11, 'Keterangan Belum Menikah'),
(12, 'Pensiunan / Taspen / Astek'),
(13, 'Keterangan Belum Mempunyai Rumah'),
(14, 'Keterangan Kelakuan Baik / SKCK'),
(15, 'Wesel Paket Berharga'),
(16, 'KIDS / KIPEM / KIK'),
(17, 'Akta Tanah / Pertanahan / SPPT / PBB');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keluhan`
--

CREATE TABLE `tb_keluhan` (
  `id_keluhan` varchar(10) NOT NULL,
  `username` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kategori_rt` varchar(3) NOT NULL,
  `keluhan` text NOT NULL,
  `tanggapan` text,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengurus`
--

CREATE TABLE `tb_pengurus` (
  `id_pengurus` varchar(10) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `kategori` varchar(2) NOT NULL,
  `nomor` varchar(3) DEFAULT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_surat`
--

CREATE TABLE `tb_surat` (
  `id_surat` varchar(10) NOT NULL,
  `username` varchar(15) NOT NULL,
  `kategori_rt` varchar(3) DEFAULT NULL,
  `kategori_rw` varchar(3) DEFAULT NULL,
  `jenis_surat` varchar(100) NOT NULL,
  `lampiran` varchar(20) DEFAULT NULL,
  `status_rt` varchar(10) DEFAULT NULL,
  `status_rw` varchar(10) DEFAULT NULL,
  `tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_temp`
--

CREATE TABLE `tb_temp` (
  `id_temp` int(5) NOT NULL,
  `id_berita` varchar(10) NOT NULL,
  `username` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_warga`
--

CREATE TABLE `tb_warga` (
  `id_warga` varchar(10) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_ktp` varchar(20) NOT NULL,
  `no_kk` varchar(20) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(15) NOT NULL,
  `pendidikan` varchar(30) NOT NULL,
  `jenis_pekerjaan` varchar(50) NOT NULL,
  `status_perkawinan` varchar(15) NOT NULL,
  `status_hubungan` varchar(20) NOT NULL,
  `kewarganegaraan` varchar(3) NOT NULL,
  `no_paspor` varchar(20) DEFAULT NULL,
  `no_kitap` varchar(20) DEFAULT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kategori_rt` varchar(3) DEFAULT NULL,
  `kategori_rw` varchar(3) DEFAULT NULL,
  `foto` varchar(15) DEFAULT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_berita`
--
ALTER TABLE `tb_berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `tb_comment`
--
ALTER TABLE `tb_comment`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_keluhan`
--
ALTER TABLE `tb_keluhan`
  ADD PRIMARY KEY (`id_keluhan`);

--
-- Indexes for table `tb_pengurus`
--
ALTER TABLE `tb_pengurus`
  ADD PRIMARY KEY (`id_pengurus`);

--
-- Indexes for table `tb_surat`
--
ALTER TABLE `tb_surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tb_temp`
--
ALTER TABLE `tb_temp`
  ADD PRIMARY KEY (`id_temp`);

--
-- Indexes for table `tb_warga`
--
ALTER TABLE `tb_warga`
  ADD PRIMARY KEY (`id_warga`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `id_jenis` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tb_temp`
--
ALTER TABLE `tb_temp`
  MODIFY `id_temp` int(5) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
