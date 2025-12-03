-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jun 2025 pada 09.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logistik_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin', '2025-06-05 15:44:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pelabuhan`
--

CREATE TABLE `jadwal_pelabuhan` (
  `id` int(11) NOT NULL,
  `id_kapal` int(11) NOT NULL,
  `pelabuhan_awal` varchar(255) NOT NULL,
  `pelabuhan_tujuan` varchar(255) NOT NULL,
  `waktu_keberangkatan` datetime NOT NULL,
  `estimasi_waktu_tiba` datetime DEFAULT NULL,
  `status_jadwal` enum('Terjadwal','Berangkat','Tiba','Dibatalkan') NOT NULL DEFAULT 'Terjadwal',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kapal`
--

CREATE TABLE `kapal` (
  `id` int(11) NOT NULL,
  `nama_kapal` varchar(255) NOT NULL,
  `jenis_kapal` varchar(255) DEFAULT NULL,
  `tahun_dibangun` int(11) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `gambar_kapal` varchar(255) DEFAULT NULL,
  `jadwal_keberangkatan` datetime DEFAULT NULL,
  `pelabuhan_asal` varchar(100) DEFAULT NULL,
  `pelabuhan_tujuan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kapal`
--

INSERT INTO `kapal` (`id`, `nama_kapal`, `jenis_kapal`, `tahun_dibangun`, `kapasitas`, `gambar_kapal`, `jadwal_keberangkatan`, `pelabuhan_asal`, `pelabuhan_tujuan`) VALUES
(2, 'Xpress Pearl', 'Kapal Kargo', 2015, 100, 'assets/6842f148d662a_1749217608.jpg', NULL, NULL, NULL),
(3, ' Martin Klingsick', 'Kapal Kargo', 2016, 500, 'assets/6842f185dc4a7_1749217669.jpg', NULL, NULL, NULL),
(4, 'HEROS - IMO 6508315', 'Kapal Kargo', 2017, 900, 'assets/6842f1adb5d69_1749217709.jpg', NULL, NULL, NULL),
(5, 'MARCO POLO - IMO 6417097', 'Kapal Kargo', 2000, 100, 'assets/6842f1d6db43a_1749217750.jpg', NULL, NULL, NULL),
(6, 'VLADIMIR TIMOFEYEV - IMO 7310636', 'Kapal Kargo', 2011, 200, 'assets/6842f29ebc800_1749217950.jpg', NULL, NULL, NULL),
(7, 'TELSTAR - IMO 5001114', 'Kapal Kargo', 2012, 200, 'assets/6842f5079d157_1749218567.jpg', NULL, NULL, NULL),
(8, 'THEKLA - IMO 5358220', 'Kapal Kargo', 2009, 300, 'assets/6842f59f13c24_1749218719.jpg', NULL, NULL, NULL),
(9, 'CORAL ACROPORA - IMO 9601730', 'Kapal Penumpang', 2007, 300, 'assets/6842f5f41524e_1749218804.jpg', NULL, NULL, NULL),
(10, 'MSC Rita V - IMO 9313929', 'Kapal Tanker', 2001, 450, 'assets/6842f66dc09c7_1749218925.jpg', NULL, NULL, NULL),
(11, 'FJORDKYST ', 'Kapal Pesiar', 2004, 300, 'assets/6842f6d335162_1749219027.jpg', NULL, NULL, NULL),
(15, 'Ferry', 'Kapal Penumpang', 2010, 100, 'assets/6848104542a06_1749553221.jpg', '2025-06-13 14:26:00', 'Batam Center', 'Kijang'),
(16, 'Mystogan', 'Kapal Pesiar', 2025, 10, 'assets/684bd750b64fa_1749800784.jpg', '2025-06-13 14:45:00', 'Sunda Kelapa Jakarta', 'Tanjung Uban');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_pengguna`
--

CREATE TABLE `ulasan_pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ulasan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan_pengguna`
--

INSERT INTO `ulasan_pengguna` (`id`, `nama`, `email`, `ulasan`, `created_at`) VALUES
(1, 'akulahsangprabu', 'ariadimasm2004@gmail.com', 'hai aria, terima kasih', '2025-06-06 18:51:04'),
(2, 'Iyan', 'iyanzeldian@gmail.com', 'sangat gg', '2025-06-06 18:51:47'),
(3, 'risky', 'rsiky@gmail', '123', '2025-06-10 11:02:38'),
(4, 'aku', 'aku@gmail.com', 'aku', '2025-06-13 07:54:53');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_pelabuhan`
--
ALTER TABLE `jadwal_pelabuhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kapal` (`id_kapal`);

--
-- Indeks untuk tabel `kapal`
--
ALTER TABLE `kapal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ulasan_pengguna`
--
ALTER TABLE `ulasan_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jadwal_pelabuhan`
--
ALTER TABLE `jadwal_pelabuhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kapal`
--
ALTER TABLE `kapal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `ulasan_pengguna`
--
ALTER TABLE `ulasan_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_pelabuhan`
--
ALTER TABLE `jadwal_pelabuhan`
  ADD CONSTRAINT `jadwal_pelabuhan_ibfk_1` FOREIGN KEY (`id_kapal`) REFERENCES `kapal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
