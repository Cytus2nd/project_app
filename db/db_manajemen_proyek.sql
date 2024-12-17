-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2024 at 08:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_manajemen_proyek`
--

-- --------------------------------------------------------

--
-- Table structure for table `fase`
--

CREATE TABLE `fase` (
  `id` int NOT NULL,
  `id_proyek` int DEFAULT NULL,
  `nama_fase` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fase`
--

INSERT INTO `fase` (`id`, `id_proyek`, `nama_fase`) VALUES
(1, 1, 'Fase Awal'),
(2, 1, 'Fase Proses'),
(3, 1, 'Fase Akhir');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int NOT NULL,
  `id_fase` int DEFAULT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tanggal_mulai_kegiatan` date DEFAULT NULL,
  `tanggal_selesai_kegiatan` date NOT NULL,
  `biaya` int DEFAULT '0',
  `keterangan` text,
  `id_tenaga_ahli` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `id_fase`, `nama_kegiatan`, `tanggal_mulai_kegiatan`, `tanggal_selesai_kegiatan`, `biaya`, `keterangan`, `id_tenaga_ahli`) VALUES
(1, 1, 'Membuat Surat Kontrak', '2024-09-27', '2024-09-30', 200000, 'Membuat Surat Kontrak Kerja', 1),
(2, 1, 'Mengumpulkan Data', '2024-10-01', '2024-10-07', 200000, 'Melakukan Wawancara dan Observasi', 1),
(3, 1, 'Merancang WBS, Jadwal dan Est. Biaya', '2024-10-08', '2024-10-14', 350000, 'Membuat WBS dan lainnya', 1),
(4, 1, 'Merancang RAB dan Risk Management', '2024-10-15', '2024-10-16', 300000, 'Membuat RAB dan Tabel Resiko Pekerjaan', 1),
(5, 2, 'Pengembangan Tahapan Design', '2024-10-17', '2024-10-23', 6000000, 'Design UI/UX', 2),
(6, 2, 'Pengembangan Tahapan Coding', '2024-10-24', '2024-11-06', 8000000, 'Melakukan Pembuatan Sistem/Implementasi', 1),
(7, 2, 'Testing', '2024-11-07', '2024-11-14', 3000000, 'Melakukan Testing dengan Blackbox dan User Testing', 2),
(8, 2, 'Perbaikan Bug dan Maintenance', '2024-11-15', '2024-11-21', 3000000, 'Melakukan Perbaikan setelah testing dilakukan', 1),
(9, 2, 'Memberikan Pelatihan Kepada Pengguna', '2024-11-22', '2024-11-25', 4000000, 'Pelatihan kepada pengguna dan pemilik usaha/tempat', 2),
(10, 3, 'Menyusun Laporan ', '2024-11-26', '2024-11-26', 1000000, 'Menyusun Laporan akhir selesai Kegiatan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `proyek`
--

CREATE TABLE `proyek` (
  `id` int NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `deskripsi` text,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `id_user` int NOT NULL,
  `rab` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `proyek`
--

INSERT INTO `proyek` (`id`, `nama_proyek`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `id_user`, `rab`) VALUES
(1, 'Pengembangan App. Absensi Karyawan Pada Gajah Mart', 'Project Aplikasi Absensi Karyawan', '2024-09-27', '2024-11-27', 1, 30000000);

-- --------------------------------------------------------

--
-- Table structure for table `tenaga_ahli`
--

CREATE TABLE `tenaga_ahli` (
  `id` int NOT NULL,
  `nama_tenaga_ahli` varchar(255) NOT NULL,
  `keahlian` varchar(255) DEFAULT NULL,
  `id_user` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tenaga_ahli`
--

INSERT INTO `tenaga_ahli` (`id`, `nama_tenaga_ahli`, `keahlian`, `id_user`, `status`) VALUES
(1, 'Hendri', 'Permodelan Sistem, Pemograman ', 1, 1),
(2, 'Rio Febryan', 'Permodelan Sistem, UI/UX', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Hendri', 'hendri', '$2y$10$o179G29XGoSkZqtjeJDL3.tWbmaufUb0SmXNZ478lHhf/HPr1Pimi', '2024-12-17 15:11:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fase`
--
ALTER TABLE `fase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proyek` (`id_proyek`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fase` (`id_fase`);

--
-- Indexes for table `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tenaga_ahli`
--
ALTER TABLE `tenaga_ahli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fase`
--
ALTER TABLE `fase`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `proyek`
--
ALTER TABLE `proyek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenaga_ahli`
--
ALTER TABLE `tenaga_ahli`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fase`
--
ALTER TABLE `fase`
  ADD CONSTRAINT `fase_ibfk_1` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id`);

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`id_fase`) REFERENCES `fase` (`id`);

--
-- Constraints for table `proyek`
--
ALTER TABLE `proyek`
  ADD CONSTRAINT `proyek_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
