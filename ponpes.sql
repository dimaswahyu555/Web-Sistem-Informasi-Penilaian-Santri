-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2025 at 02:58 PM
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
-- Database: `ponpes`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_santri` int NOT NULL,
  `id_guru` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_ke` tinyint NOT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `id_matapelajaran` int DEFAULT NULL,
  `status_kehadiran` enum('Hadir','Izin','Sakit','Alpa') NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_santri`, `id_guru`, `tanggal`, `jam_ke`, `kelas`, `id_matapelajaran`, `status_kehadiran`, `keterangan`) VALUES
(34, 34, 10, '2025-06-01', 1, NULL, 4, 'Hadir', NULL),
(35, 35, 10, '2025-06-01', 1, NULL, 4, 'Hadir', NULL),
(36, 33, 10, '2025-06-02', 2, NULL, 4, 'Hadir', NULL),
(37, 34, 10, '2025-06-03', 2, NULL, 4, 'Hadir', NULL),
(38, 35, 10, '2025-06-03', 2, NULL, 4, 'Hadir', NULL),
(39, 22, 10, '2025-06-02', 3, NULL, 4, 'Hadir', NULL),
(40, 26, 10, '2025-06-02', 3, NULL, 4, 'Hadir', NULL),
(41, 31, 10, '2025-06-02', 3, NULL, 4, 'Hadir', NULL),
(42, 33, 10, '2025-06-07', 3, NULL, 1, 'Hadir', NULL),
(43, 33, 10, '2025-06-07', 2, NULL, 5, 'Hadir', NULL),
(44, 33, 10, '2025-06-07', 1, NULL, 4, 'Hadir', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `email`, `no_hp`, `foto`, `tanggal_dibuat`) VALUES
(1, 'Ahmad Fauzi', 'ahmad.fauzi@example.com', '081234567890', 'foto1.jpg', '2025-05-12 06:39:57'),
(2, 'Siti Nurhaliza', 'siti.nurhaliza@example.com', '082345678901', 'foto2.jpg', '2025-05-12 06:39:57'),
(3, 'Budi Santoso', 'budi.santoso@example.com', '083456789012', 'foto3.jpg', '2025-05-12 06:39:57'),
(4, 'Dewi Lestari', 'dewi.lestari@example.com', '084567890123', 'foto4.jpg', '2025-05-12 06:39:57'),
(5, 'Andi Pratama', 'andi.pratama@example.com', '085678901234', 'foto5.jpg', '2025-05-12 06:39:57');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mata_pelajaran` varchar(100) DEFAULT NULL,
  `pendidikan_terakhir` varchar(50) DEFAULT NULL,
  `status_aktif` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `tanggal_bergabung` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_hp`, `email`, `mata_pelajaran`, `pendidikan_terakhir`, `status_aktif`, `tanggal_bergabung`) VALUES
(4, 'Halim Syahputra', '1988123456789', 'Yogyakarta', '1988-04-15', 'Laki-laki', 'Jl. Anggrek No. 5, Sleman', '081234567890', 'halim.syahputra@example.com', 'Matematika', 'S1 Pendidikan Matematika', 'Aktif', '2025-03-26 19:36:39'),
(5, 'Aisyah Ramadhani', '1990234567890', 'Bandung', '1990-07-12', 'Perempuan', 'Jl. Mawar No. 10, Bantul', '082134567890', 'aisyah.ramadhani@example.com', 'Bahasa Inggris', 'S2 Pendidikan Bahasa Inggris', 'Aktif', '2025-03-26 19:36:39'),
(6, 'Muhammad Ilham', '1975123456789', 'Jakarta', '1975-09-30', 'Laki-laki', 'Jl. Melati No. 8, Yogyakarta', '085678901234', 'muhammad.ilham@example.com', 'Fisika', 'S1 Fisika', 'Aktif', '2025-03-26 19:36:39'),
(7, 'Zahra Amalia', '1989123456789', 'Surabaya', '1989-01-20', 'Perempuan', 'Jl. Dahlia No. 5, Sleman', '087654321098', 'zahra.amalia@example.com', 'Kimia', 'S1 Kimia', 'Aktif', '2025-03-26 19:36:39'),
(8, 'Imran Hakim', '1980023456789', 'Medan', '1980-11-25', 'Laki-laki', 'Jl. Tanjung No. 2, Yogyakarta', '081345678901', 'imran.hakim@example.com', 'Sejarah', 'S2 Sejarah', 'Aktif', '2025-03-26 19:36:39'),
(9, 'Hana Pratiwi', '1993123456789', 'Semarang', '1993-06-14', 'Perempuan', 'Jl. Flamboyan No. 6, Kulon Progo', '083456789012', 'hana.pratiwi@example.com', 'Geografi', 'S1 Geografi', 'Aktif', '2025-03-26 19:36:39'),
(10, 'Rizki Fadilah', '1985123456789', 'Malang', '1985-03-05', 'Laki-laki', 'Jl. Cempaka No. 9, Bantul', '085678902345', 'rizki.fadilah@example.com', 'Bahasa Arab', 'S1 Pendidikan Bahasa Arab', 'Aktif', '2025-03-26 19:36:39'),
(11, 'Nurul Aini', '1990123456789', 'Makassar', '1990-08-20', 'Perempuan', 'Jl. Kenanga No. 15, Gunungkidul', '087678903456', 'nurul.aini@example.com', 'Akhlak dan Fiqih', 'S1 Ilmu Fiqih', 'Aktif', '2025-03-26 19:36:39'),
(12, 'Ahmad Fauzan', '1987034567890', 'Bogor', '1987-04-10', 'Laki-laki', 'Jl. Mawar No. 3, Sleman', '082345678123', 'ahmad.fauzan@example.com', 'Tahfidzul Qur\'an', 'S1 Ilmu Al-Qur\'an', 'Aktif', '2025-03-26 19:36:39'),
(13, 'Farah Syifa', '1995123456789', 'Palembang', '1995-02-01', 'Perempuan', 'Jl. Sakura No. 6, Kulon Progo', '081678904567', 'farah.syifa@example.com', 'Bahasa Indonesia', 'S1 Pendidikan Bahasa Indonesia', 'Aktif', '2025-03-26 19:36:39'),
(14, 'Arif Maulana', '1984123456789', 'Pekanbaru', '1984-09-15', 'Laki-laki', 'Jl. Jati No. 10, Yogyakarta', '083789012345', 'arif.maulana@example.com', 'Ekonomi', 'S1 Ekonomi', 'Aktif', '2025-03-26 19:36:39'),
(15, 'Lina Andini', '1986123456789', 'Solo', '1986-10-05', 'Perempuan', 'Jl. Akasia No. 12, Bantul', '085678901345', 'lina.andini@example.com', 'Pendidikan Agama Islam', 'S1 Pendidikan Agama Islam', 'Aktif', '2025-03-26 19:36:39'),
(16, 'Hamzah Rizwan', '1977123456789', 'Depok', '1977-05-27', 'Laki-laki', 'Jl. Cemara No. 8, Sleman', '087654321567', 'hamzah.rizwan@example.com', 'Fisika', 'S2 Fisika', 'Aktif', '2025-03-26 19:36:39'),
(17, 'Nabila Azhar', '1994123456789', 'Mataram', '1994-03-15', 'Perempuan', 'Jl. Tanjung No. 4, Gunungkidul', '081678903456', 'nabila.azhar@example.com', 'Matematika', 'S1 Matematika', 'Aktif', '2025-03-26 19:36:39'),
(18, 'Faisal Lutfi', '1989034567890', 'Tangerang', '1989-07-22', 'Laki-laki', 'Jl. Anggrek No. 7, Yogyakarta', '082345678345', 'faisal.lutfi@example.com', 'Bahasa Arab', 'S1 Pendidikan Bahasa Arab', 'Aktif', '2025-03-26 19:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pelajaran`
--

CREATE TABLE `jadwal_pelajaran` (
  `id_jadwal` int NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_pelajaran` varchar(50) NOT NULL,
  `id_matapelajaran` int NOT NULL,
  `id_guru` int NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `ruangan` varchar(50) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `tanggal_input` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_pelajaran`
--

INSERT INTO `jadwal_pelajaran` (`id_jadwal`, `hari`, `jam_pelajaran`, `id_matapelajaran`, `id_guru`, `kelas`, `ruangan`, `tahun_ajaran`, `semester`, `tanggal_input`) VALUES
(1, 'Senin', '07.00-09.30', 4, 10, 'kelas4', 'R.003', '2024/2025', 'Ganjil', '2025-05-15 12:55:48'),
(2, 'Senin', '13:30', 4, 10, '3b', 'R.005', '2024/2025', 'Ganjil', '2025-05-23 06:02:26'),
(4, 'Senin', '09.30-11.00', 4, 10, 'kelas3', 'R.001', '2024/2025', 'Ganjil', '2025-06-07 06:19:37'),
(5, 'Selasa', '07.00-09.30', 5, 8, 'kelas3', 'R.201', '2024/2025', 'Ganjil', '2025-06-07 06:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `matapelajaran`
--

CREATE TABLE `matapelajaran` (
  `id_matapelajaran` int NOT NULL,
  `kode_matapelajaran` varchar(10) NOT NULL,
  `nama_matapelajaran` varchar(100) NOT NULL,
  `deskripsi` text,
  `tingkat_kelas` varchar(10) DEFAULT NULL,
  `program_pendidikan` varchar(50) DEFAULT NULL,
  `semester` enum('Ganjil','Genap') DEFAULT NULL,
  `jumlah_jam` int DEFAULT NULL,
  `id_guru` int DEFAULT NULL,
  `nama_guru` varchar(100) DEFAULT NULL,
  `status_aktif` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `matapelajaran`
--

INSERT INTO `matapelajaran` (`id_matapelajaran`, `kode_matapelajaran`, `nama_matapelajaran`, `deskripsi`, `tingkat_kelas`, `program_pendidikan`, `semester`, `jumlah_jam`, `id_guru`, `nama_guru`, `status_aktif`) VALUES
(1, 'PAI01', 'Pendidikan Agama Islam', 'Materi fiqih, aqidah, dan akhlak untuk santri tingkat dasar', 'VII', 'Pondok', 'Ganjil', 4, 15, 'Lina Andini', 'Aktif'),
(3, 'TQ01', 'Tahfidzul Qur\'an', 'Hafalan Al-Qur\'an juz 1–30', 'VII', 'Pondok', 'Ganjil', 6, 12, 'Ahmad Fauzan', 'Aktif'),
(4, 'ARAB01', 'Bahasa Arab', 'Pengantar Bahasa Arab dasar hingga percakapan', 'VII', 'Pondok', 'Genap', 3, 10, 'Rizki Fadilah', 'Aktif'),
(5, 'SKI01', 'Sejarah Kebudayaan Islam', 'Sejarah perkembangan Islam sejak Nabi Muhammad SAW', 'VIII', 'Pondok', 'Genap', 2, 8, 'Imran Hakim', 'Aktif'),
(6, 'BIND01', 'Bahasa Indonesia', 'Pengembangan kemampuan berbahasa Indonesia', 'VII', 'Pondok', 'Ganjil', 2, 13, 'Farah Syifa', 'Aktif'),
(7, 'BING01', 'Bahasa Inggris', 'Dasar-dasar bahasa Inggris dan percakapan ringan', 'VIII', 'Pondok', 'Ganjil', 2, 5, 'Aisyah Ramadhani', 'Aktif'),
(9, 'FIS01', 'Fisika', 'Ilmu fisika dasar untuk tingkat menengah', 'IX', 'Pondok', 'Ganjil', 3, 16, 'Hamzah Rizwan', 'Aktif'),
(14, 'PAI02', 'Agama Islam', 'Pelajaran agama Islam adalah mata pelajaran yang mengajarkan tentang ajaran Islam, meliputi aspek akidah, syariah (fiqh), dan akhlak. ', 'VII', 'Formal', 'Ganjil', 2, 15, NULL, 'Aktif'),
(15, 'TQ02', 'Tahfidzul Qur\'an', 'Pelajaran Tahfidzul Qur\'an adalah proses pembelajaran untuk menghafal dan menjaga kemurnian Al-Qur\'an. Tujuannya adalah agar umat Islam memiliki hafalan Al-Qur\'an yang benar dan bisa melestarikannya. ', 'VIII', 'Formal', 'Ganjil', 2, 12, NULL, 'Aktif'),
(16, 'TH01', 'Tauhid', 'Mata pelajaran tauhid merupakan cabang ilmu pengetahuan yang mempelajari tentang keesaan Allah SWT. ', 'VII', 'Tahfidz', 'Ganjil', 2, 4, 'Halim Syahputra', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int NOT NULL,
  `id_santri` int NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `nilai_tugas` decimal(5,2) DEFAULT NULL,
  `nilai_uts` decimal(5,2) DEFAULT NULL,
  `nilai_uas` decimal(5,2) DEFAULT NULL,
  `nilai_hafalan` decimal(5,2) DEFAULT NULL,
  `nilai_akhir` decimal(5,2) GENERATED ALWAYS AS (round(((((ifnull(`nilai_tugas`,0) * 0.2) + (ifnull(`nilai_uts`,0) * 0.25)) + (ifnull(`nilai_uas`,0) * 0.35)) + (ifnull(`nilai_hafalan`,0) * 0.2)),2)) STORED,
  `keterangan` varchar(100) GENERATED ALWAYS AS ((case when (`nilai_akhir` >= 85) then _utf8mb4'Sangat Baik' when (`nilai_akhir` >= 70) then _utf8mb4'Baik' when (`nilai_akhir` >= 55) then _utf8mb4'Cukup' else _utf8mb4'Kurang' end)) STORED,
  `tanggal_input` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_santri`, `mapel`, `semester`, `tahun_ajaran`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_hafalan`, `tanggal_input`) VALUES
(1, 30, 'fisika', 'Ganjil', '2024/2025', '71.00', '75.00', '80.00', '77.00', '2025-05-14 06:07:20'),
(3, 21, 'fisika', 'Ganjil', '2024/2025', '90.00', '90.00', '90.00', '90.00', '2025-05-14 06:19:40'),
(4, 26, 'fisika', 'Ganjil', '2024/2025', '70.00', '80.00', '80.00', '70.00', '2025-05-21 18:24:00'),
(5, 26, 'Bahasa Arab', 'Ganjil', '2024/2025', '80.00', '80.00', '80.00', '80.00', '2025-05-21 18:24:53'),
(7, 33, 'Bahasa Arab', 'Ganjil', '2024/2025', '70.00', '65.00', '77.00', '60.00', '2025-05-28 09:48:30'),
(8, 33, 'fisika', 'Ganjil', '2024/2025', '70.00', '80.00', '85.00', '90.00', '2025-05-29 19:48:30'),
(10, 22, 'Bahasa Arab', 'Ganjil', '2024/2025', '50.00', '50.00', '70.00', '80.00', '2025-06-10 17:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id_santri` int NOT NULL,
  `nama_santri` varchar(100) NOT NULL,
  `nisn` varchar(15) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `no_telepon_wali` varchar(15) DEFAULT NULL,
  `nama_wali_santri` varchar(100) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `program_pendidikan` varchar(50) DEFAULT NULL,
  `status_santri` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id_santri`, `nama_santri`, `nisn`, `tanggal_lahir`, `alamat`, `jenis_kelamin`, `no_telepon_wali`, `nama_wali_santri`, `kelas`, `program_pendidikan`, `status_santri`, `foto`, `tanggal_daftar`) VALUES
(19, 'Siti Zulaikha', '2345678901234', '2011-05-14', 'Jl. Mawar No. 8, Sleman', 'Perempuan', '082134567890', 'Halimah Zulaikha', 'VI', 'Kitab Kuning', 'Aktif', 'foto2.jpg', '2025-03-26 19:34:51'),
(21, 'Aisyah Putri', '4567890123456', '2010-03-18', 'Jl. Dahlia No. 12, Kulon Progo', 'Perempuan', '087654321098', 'Aminah Putri', 'VII', 'Bahasa Arab', 'Aktif', 'foto4.jpg', '2025-03-26 19:34:51'),
(22, 'Zaid Fakhri', '5678901234567', '2008-11-05', 'Jl. Cempaka No. 9, Gunungkidul', 'Laki-laki', '081234560987', 'Fahmi Fakhri', 'IX', 'Tahfidzul Qur’an', 'Aktif', 'foto5.jpg', '2025-03-26 19:34:51'),
(23, 'Fatimah Zahra', '6789012345678', '2009-08-11', 'Jl. Kenanga No. 15, Yogyakarta', 'Perempuan', '083456789012', 'Zainab Zahra', 'VIII', 'Kitab Kuning', 'Aktif', 'foto6.jpg', '2025-03-26 19:34:51'),
(24, 'Rifqi Al-Fattah', '7890123456789', '2011-07-07', 'Jl. Teratai No. 20, Sleman', 'Laki-laki', '085678902345', 'Hamzah Al-Fattah', 'VI', 'Bahasa Arab', 'Aktif', 'foto7.jpg', '2025-03-26 19:34:51'),
(25, 'Maryam Husna', '8901234567890', '2010-06-06', 'Jl. Flamboyan No. 14, Bantul', 'Perempuan', '087678903456', 'Hafizah Husna', 'VII', 'Fiqih Islam', 'Aktif', 'foto8.jpg', '2025-03-26 19:34:51'),
(26, 'Bilal Hakim', '9012345678901', '2008-04-15', 'Jl. Tanjung No. 7, Gunungkidul', 'Laki-laki', '082345678123', 'Imran Hakim', 'IX', 'Tahfidzul Qur’an', 'Aktif', 'foto9.jpg', '2025-03-26 19:34:51'),
(27, 'Zainab Fatimah', '0123456789012', '2009-10-09', 'Jl. Sakura No. 6, Kulon Progo', 'Perempuan', '081678904567', 'Khadijah Fatimah', 'VIII', 'Kitab Kuning', 'Aktif', 'foto10.jpg', '2025-03-26 19:34:51'),
(28, 'Hasan Basri', '1231231231231', '2011-12-01', 'Jl. Mawar No. 17, Yogyakarta', 'Laki-laki', '083789012345', 'Basri Hakim', 'VI', 'Bahasa Arab', 'Aktif', 'foto11.jpg', '2025-03-26 19:34:51'),
(29, 'Ammar Mukhtar', '2342342342342', '2010-03-20', 'Jl. Jati No. 22, Sleman', 'Laki-laki', '085678901345', 'Mukhtar Ali', 'VII', 'Fiqih Islam', 'Aktif', 'foto12.jpg', '2025-03-26 19:34:51'),
(30, 'Laila Nur', '3453453453453', '2009-11-25', 'Jl. Cemara No. 10, Bantul', 'Perempuan', '087654321567', 'Nur Hayati', 'VIII', 'Tahfidzul Qur’an', 'Aktif', 'foto13.jpg', '2025-03-26 19:34:51'),
(31, 'Imran Syukri', '4564564564564', '2008-01-14', 'Jl. Sawo No. 5, Gunungkidul', 'Laki-laki', '081678903456', 'Syukri Abdullah', 'IX', 'Kitab Kuning', 'Aktif', 'foto14.jpg', '2025-03-26 19:34:51'),
(32, 'Aisha Rahma', '5675675675675', '2011-02-28', 'Jl. Akasia No. 30, Kulon Progo', 'Perempuan', '082345678345', 'Rahma Zahra', 'VI', 'Bahasa Arab', 'Aktif', 'foto15.jpg', '2025-03-26 19:34:51'),
(33, 'dimas wahyu prasetyo', '1234567890', '2003-07-25', 'yogyakarta', 'Laki-laki', '088834567890', 'yanto', 'kelas3', 'tafizh', 'Aktif', 'santri_33_1748631354.png', '2025-05-22 19:37:25'),
(34, 'dimaspras', '1111222223333', '2004-07-26', 'yogyakartacity', 'Laki-laki', '081234567890', 'yantoo', 'kelas4', 'tafizh', NULL, 'gambar gua.png', '2025-05-30 18:50:28'),
(35, 'Risky putri', '12345555666', '2001-10-20', 'bojonegoro', 'Perempuan', '08674567460000', 'Bandono', 'kelas4', 'tafizh', 'Aktif', 'santri_35_1749561130.jpg', '2025-05-31 12:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','santri') NOT NULL,
  `id_admin` int DEFAULT NULL,
  `id_guru` int DEFAULT NULL,
  `id_santri` int DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`, `id_admin`, `id_guru`, `id_santri`, `status`, `created_at`) VALUES
(1, 'budisanto', '$2y$10$lNzV8EM9fKAktdilAKV82.eyUsMQPzV/puHDtAkwuUeBHkzcFPV4i', 'admin', 3, NULL, NULL, 'Aktif', '2025-05-12 07:01:26'),
(3, 'andipratama', '$2y$10$qrlvMuhckoHbFX/ZNWNeHuaQxMDnemK56zV1GGmXCCMz8rLWeQ/1K', 'admin', 5, NULL, NULL, 'Aktif', '2025-05-12 07:08:09'),
(4, 'imranhakim', '$2y$10$gdOMMl221X3XysbrLxMPP.CjhvZBBADxm6QXWtFV7QL0mwZyiXtoC', 'guru', NULL, 8, NULL, 'Aktif', '2025-05-12 07:13:58'),
(5, 'faisallut', '$2y$10$A2pd4tEAJoPoRD31DvMZhefKo5LKgCZzDBmBNgSpa8eCEwfkjKZl6', 'guru', NULL, 18, NULL, 'Aktif', '2025-05-13 05:35:37'),
(6, 'nurulaini', '$2y$10$ZcQia54qx7HYcBZFL2ERveX0c9av7716KV0IfxHnpO9zAgS2HVBMS', 'guru', NULL, 11, NULL, 'Aktif', '2025-05-13 06:04:55'),
(7, 'bilal', '$2y$10$eBj3LhR3NjCouakcx2FQkuSfRd.dS995Hd69O8KQmwFeb4RKV4ofy', 'santri', NULL, NULL, 26, 'Aktif', '2025-05-20 15:55:27'),
(8, 'fadilah', '$2y$10$G4tVnsnqeXTzTXG7ossnc.yX0Mz9DzhRE/NBgumZl/Vz.JG86n6g2', 'guru', NULL, 10, NULL, 'Aktif', '2025-05-21 18:38:03'),
(9, 'dimas123', '$2y$10$tpyNF85OszYAo1Lk7Lx1sufZMREgRYxCWWe/hjvsRnf5SI0qLlPJG', 'santri', NULL, NULL, 33, 'Aktif', '2025-05-22 19:38:14'),
(10, 'putry', '$2y$10$RpmRvWGf4.KRj4B3QWk8GODQMb2i8qCmPXtxhooOwhggHQN6JGGfu', 'santri', NULL, NULL, 35, 'Aktif', '2025-06-10 13:11:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_matapelajaran` (`id_matapelajaran`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `matapelajaran`
--
ALTER TABLE `matapelajaran`
  ADD PRIMARY KEY (`id_matapelajaran`),
  ADD UNIQUE KEY `kode_matapelajaran` (`kode_matapelajaran`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `fk_nilai_santri` (`id_santri`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id_santri`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_santri` (`id_santri`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `matapelajaran`
--
ALTER TABLE `matapelajaran`
  MODIFY `id_matapelajaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id_santri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  ADD CONSTRAINT `jadwal_pelajaran_ibfk_1` FOREIGN KEY (`id_matapelajaran`) REFERENCES `matapelajaran` (`id_matapelajaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_pelajaran_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE;

--
-- Constraints for table `matapelajaran`
--
ALTER TABLE `matapelajaran`
  ADD CONSTRAINT `matapelajaran_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_nilai_santri` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
