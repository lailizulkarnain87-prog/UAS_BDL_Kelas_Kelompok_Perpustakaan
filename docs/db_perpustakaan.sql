-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2026 at 02:10 PM
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
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggotas`
--

CREATE TABLE `anggotas` (
  `id_anggota` int UNSIGNED NOT NULL,
  `kode_anggota` varchar(15) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text,
  `tanggal_daftar` date NOT NULL DEFAULT (curdate()),
  `status_anggota` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bukus`
--

CREATE TABLE `bukus` (
  `id_buku` int UNSIGNED NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `id_kategori` int UNSIGNED NOT NULL,
  `id_penerbit` int UNSIGNED NOT NULL,
  `id_rak` int UNSIGNED NOT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `edisi` varchar(20) DEFAULT NULL,
  `jumlah_halaman` int DEFAULT NULL,
  `stok_total` int NOT NULL DEFAULT '1',
  `stok_tersedia` int NOT NULL DEFAULT '0',
  `bahasa` varchar(30) NOT NULL DEFAULT 'Indonesia',
  `sinopsis` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dendas`
--

CREATE TABLE `dendas` (
  `id` int UNSIGNED NOT NULL,
  `id_pengembalian` int UNSIGNED DEFAULT NULL,
  `id_anggota` int UNSIGNED NOT NULL,
  `total_denda` decimal(12,2) NOT NULL,
  `sisa_denda` decimal(12,2) NOT NULL,
  `status_denda` varchar(20) NOT NULL DEFAULT 'pending',
  `tanggal_dikenakan` date NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `alasan_denda` text,
  `created_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjamans`
--

CREATE TABLE `detail_peminjamans` (
  `id_detail` int UNSIGNED NOT NULL,
  `id_peminjaman` int UNSIGNED NOT NULL,
  `id_buku` int UNSIGNED NOT NULL,
  `status_buku` enum('dipinjam','dikembalikan','hilang') NOT NULL DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id_kategori` int UNSIGNED NOT NULL,
  `kode_kategori` varchar(10) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_kategoris_table', 1),
(5, '2024_01_01_000002_create_penerbits_table', 1),
(6, '2024_01_01_000003_create_raks_table', 1),
(7, '2024_01_01_000004_create_anggotas_table', 1),
(8, '2024_01_01_000005_create_petugas_table', 1),
(9, '2024_01_01_000006_create_bukus_table', 1),
(10, '2024_01_01_000007_create_peminjamans_table', 1),
(11, '2024_01_01_000008_create_detail_peminjamans_table', 1),
(12, '2024_01_01_000009_create_pengembalians_table', 1),
(13, '2024_01_01_000010_create_reservasis_table', 1),
(14, '2024_01_01_000011_create_dendas_table', 1),
(15, '2024_01_01_000012_create_pembayaran_dendas_table', 1),
(16, '2024_01_01_000013_create_riwayat_status_dendas_table', 1),
(17, '2026_07_06_144005_create_personal_access_tokens_table', 1),
(18, '2026_07_06_160000_add_role_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_dendas`
--

CREATE TABLE `pembayaran_dendas` (
  `id` int UNSIGNED NOT NULL,
  `id_denda` int UNSIGNED NOT NULL,
  `id_petugas` int UNSIGNED NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `tanggal_bayar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `metode_bayar` varchar(20) NOT NULL DEFAULT 'tunai',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id_peminjaman` int UNSIGNED NOT NULL,
  `kode_peminjaman` varchar(15) NOT NULL,
  `id_anggota` int UNSIGNED NOT NULL,
  `id_petugas` int UNSIGNED NOT NULL,
  `tanggal_pinjam` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_batas_kembali` date NOT NULL,
  `status_peminjaman` enum('aktif','selesai','terlambat') NOT NULL DEFAULT 'aktif',
  `total_buku` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penerbits`
--

CREATE TABLE `penerbits` (
  `id_penerbit` int UNSIGNED NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id_pengembalian` int UNSIGNED NOT NULL,
  `id_peminjaman` int UNSIGNED NOT NULL,
  `id_detail` int UNSIGNED NOT NULL,
  `id_petugas` int UNSIGNED NOT NULL,
  `tanggal_kembali` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `terlambat_hari` int NOT NULL DEFAULT '0',
  `denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `kondisi_buku` enum('baik','rusak','hilang') NOT NULL DEFAULT 'baik',
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int UNSIGNED NOT NULL,
  `kode_petugas` varchar(10) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `raks`
--

CREATE TABLE `raks` (
  `id_rak` int UNSIGNED NOT NULL,
  `kode_rak` varchar(10) NOT NULL,
  `nama_rak` varchar(50) NOT NULL,
  `lantai` int DEFAULT NULL,
  `kapasitas` int DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasis`
--

CREATE TABLE `reservasis` (
  `id_reservasi` int UNSIGNED NOT NULL,
  `id_anggota` int UNSIGNED NOT NULL,
  `id_buku` int UNSIGNED NOT NULL,
  `tanggal_reservasi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_kedaluwarsa` date NOT NULL,
  `status_reservasi` enum('menunggu','tersedia','diklaim','kedaluwarsa','batal') NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_status_dendas`
--

CREATE TABLE `riwayat_status_dendas` (
  `id` int UNSIGNED NOT NULL,
  `id_denda` int UNSIGNED NOT NULL,
  `status_sebelum` varchar(20) DEFAULT NULL,
  `status_sesudah` varchar(20) NOT NULL,
  `diubah_oleh` int UNSIGNED DEFAULT NULL,
  `alasan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'anggota',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `anggotas_kode_anggota_unique` (`kode_anggota`),
  ADD UNIQUE KEY `anggotas_email_unique` (`email`),
  ADD KEY `anggotas_nama_lengkap_index` (`nama_lengkap`);

--
-- Indexes for table `bukus`
--
ALTER TABLE `bukus`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `bukus_isbn_unique` (`isbn`),
  ADD KEY `bukus_id_kategori_foreign` (`id_kategori`),
  ADD KEY `bukus_id_penerbit_foreign` (`id_penerbit`),
  ADD KEY `bukus_id_rak_foreign` (`id_rak`),
  ADD KEY `bukus_judul_index` (`judul`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `dendas`
--
ALTER TABLE `dendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dendas_id_anggota_index` (`id_anggota`),
  ADD KEY `dendas_id_pengembalian_foreign` (`id_pengembalian`),
  ADD KEY `dendas_created_by_foreign` (`created_by`),
  ADD KEY `dendas_status_denda_index` (`status_denda`),
  ADD KEY `dendas_tanggal_dikenakan_index` (`tanggal_dikenakan`);

--
-- Indexes for table `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `uq_peminjaman_buku` (`id_peminjaman`,`id_buku`),
  ADD KEY `detail_peminjamans_id_buku_foreign` (`id_buku`),
  ADD KEY `detail_peminjamans_status_buku_index` (`status_buku`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kategoris_kode_kategori_unique` (`kode_kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayaran_dendas`
--
ALTER TABLE `pembayaran_dendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_dendas_id_denda_index` (`id_denda`),
  ADD KEY `pembayaran_dendas_id_petugas_index` (`id_petugas`),
  ADD KEY `pembayaran_dendas_tanggal_bayar_index` (`tanggal_bayar`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD UNIQUE KEY `peminjamans_kode_peminjaman_unique` (`kode_peminjaman`),
  ADD KEY `peminjamans_id_petugas_foreign` (`id_petugas`),
  ADD KEY `peminjamans_id_anggota_index` (`id_anggota`),
  ADD KEY `peminjamans_tanggal_pinjam_index` (`tanggal_pinjam`);

--
-- Indexes for table `penerbits`
--
ALTER TABLE `penerbits`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD UNIQUE KEY `pengembalians_id_detail_unique` (`id_detail`),
  ADD KEY `pengembalians_id_peminjaman_foreign` (`id_peminjaman`),
  ADD KEY `pengembalians_id_petugas_foreign` (`id_petugas`),
  ADD KEY `pengembalians_tanggal_kembali_index` (`tanggal_kembali`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `petugas_kode_petugas_unique` (`kode_petugas`),
  ADD UNIQUE KEY `petugas_username_unique` (`username`);

--
-- Indexes for table `raks`
--
ALTER TABLE `raks`
  ADD PRIMARY KEY (`id_rak`),
  ADD UNIQUE KEY `raks_kode_rak_unique` (`kode_rak`);

--
-- Indexes for table `reservasis`
--
ALTER TABLE `reservasis`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `reservasis_id_anggota_foreign` (`id_anggota`),
  ADD KEY `reservasis_id_buku_foreign` (`id_buku`);

--
-- Indexes for table `riwayat_status_dendas`
--
ALTER TABLE `riwayat_status_dendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_status_dendas_diubah_oleh_foreign` (`diubah_oleh`),
  ADD KEY `riwayat_status_dendas_id_denda_index` (`id_denda`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggotas`
--
ALTER TABLE `anggotas`
  MODIFY `id_anggota` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bukus`
--
ALTER TABLE `bukus`
  MODIFY `id_buku` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dendas`
--
ALTER TABLE `dendas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  MODIFY `id_detail` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id_kategori` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pembayaran_dendas`
--
ALTER TABLE `pembayaran_dendas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id_peminjaman` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penerbits`
--
ALTER TABLE `penerbits`
  MODIFY `id_penerbit` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id_pengembalian` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `raks`
--
ALTER TABLE `raks`
  MODIFY `id_rak` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reservasis`
--
ALTER TABLE `reservasis`
  MODIFY `id_reservasi` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_status_dendas`
--
ALTER TABLE `riwayat_status_dendas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukus`
--
ALTER TABLE `bukus`
  ADD CONSTRAINT `bukus_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategoris` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `bukus_id_penerbit_foreign` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbits` (`id_penerbit`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `bukus_id_rak_foreign` FOREIGN KEY (`id_rak`) REFERENCES `raks` (`id_rak`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `dendas`
--
ALTER TABLE `dendas`
  ADD CONSTRAINT `dendas_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dendas_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `anggotas` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `dendas_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalians` (`id_pengembalian`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  ADD CONSTRAINT `detail_peminjamans_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `bukus` (`id_buku`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_peminjamans_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjamans` (`id_peminjaman`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran_dendas`
--
ALTER TABLE `pembayaran_dendas`
  ADD CONSTRAINT `pembayaran_dendas_id_denda_foreign` FOREIGN KEY (`id_denda`) REFERENCES `dendas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_dendas_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `anggotas` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjamans_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_id_detail_foreign` FOREIGN KEY (`id_detail`) REFERENCES `detail_peminjamans` (`id_detail`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalians_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjamans` (`id_peminjaman`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalians_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `reservasis`
--
ALTER TABLE `reservasis`
  ADD CONSTRAINT `reservasis_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `anggotas` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `reservasis_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `bukus` (`id_buku`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_status_dendas`
--
ALTER TABLE `riwayat_status_dendas`
  ADD CONSTRAINT `riwayat_status_dendas_diubah_oleh_foreign` FOREIGN KEY (`diubah_oleh`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `riwayat_status_dendas_id_denda_foreign` FOREIGN KEY (`id_denda`) REFERENCES `dendas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
