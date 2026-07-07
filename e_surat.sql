-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jun 2026 pada 11.35
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_surat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id_jenis` int(11) NOT NULL,
  `nama_surat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_surat`
--

INSERT INTO `jenis_surat` (`id_jenis`, `nama_surat`) VALUES
(1, 'Surat Keterangan Aktif Kuliah'),
(2, 'Surat Keterangan Mahasiswa'),
(3, 'Surat Pengantar Magang'),
(4, 'Surat Pengantar Penelitian'),
(5, 'Surat Rekomendasi Beasiswa'),
(6, 'Surat Keterangan Lulus'),
(7, 'Surat Keterangan Cuti');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nim` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `id_user`, `nim`, `nama`, `prodi`) VALUES
(1, 4, '20260601', 'Jefri Bams', 'Teknik Informatika'),
(3, 6, '20260602', 'Nara Putri Amelia', 'Teknik Informatika'),
(4, 7, '20260603', 'Bambang Agustaf', 'Teknik Informatika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id_pengajuan` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `keperluan` text NOT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') DEFAULT 'Menunggu',
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id_pengajuan`, `id_mahasiswa`, `id_jenis`, `tanggal_pengajuan`, `keperluan`, `status`, `keterangan`) VALUES
(1, 1, 1, '2026-06-30', '\r\ntestt', 'Diproses', 'Surat sedang diproses oleh Bagian Tata Usaha.'),
(2, 4, 7, '2026-06-30', 'Cuti\r\n', 'Selesai', 'Surat telah selesai diproses. Silakan mengambil surat di Bagian Tata Usaha pada jam kerja (Senin - Jumat, 08.00 - 15.00 WIB).'),
(3, 3, 5, '2026-06-30', 'Beasiswa\r\n', 'Menunggu', 'Pengajuan surat sedang menunggu verifikasi dari Tata Usaha.'),
(4, 1, 3, '2026-06-30', '\r\nMagang', 'Ditolak', 'Pengajuan surat ditolak. Silakan menghubungi Bagian Tata Usaha untuk informasi lebih lanjut.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','tu','mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$H19jQ951nf.VgAbbTHKFeuXmngcdH.MRms/0wuCb8X4TE4UKKuJwq', 'admin'),
(2, 'tu', '$2y$10$wp7G40fNIQaB4uHWufPOO.hk0fbMSGm7rGEOt3445oX8hy6ou.URS', 'tu'),
(3, 'mahasiswa', '$2y$10$6kPG3yA1ZdIGbRzmN/RoUOiXpsdlqYjWe1GxuxM..slvm6vK4azsC', 'mahasiswa'),
(4, 'Jefri', '$2y$10$qaZF9Jfs8cY7mmFCgGd2fu9fRrabnEg1jifrK3z1KJGLHEMFTQ2bC', 'mahasiswa'),
(6, 'Nara', '$2y$10$au23wTdrIhnMVddmQeffGOXD23WI.Aq./r2oKC0eGfdX8POzSHL06', 'mahasiswa'),
(7, 'Agus', '$2y$10$tFAt22jyv7GsLHQsCRd/P.NEg/xZSvjP2sqrZbKvddO3kE.WrEnTO', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `fk_mahasiswa_user` (`id_user`);

--
-- Indeks untuk tabel `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `fk_pengajuan_mahasiswa` (`id_mahasiswa`),
  ADD KEY `fk_pengajuan_jenis` (`id_jenis`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `fk_mahasiswa_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `fk_pengajuan_jenis` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_surat` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
