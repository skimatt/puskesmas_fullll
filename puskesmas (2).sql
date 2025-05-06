-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2025 pada 04.17
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puskesmas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kartu_berobat`
--

CREATE TABLE `kartu_berobat` (
  `id_kartu` int(11) NOT NULL,
  `nomor_kartu` varchar(20) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_antrian`
--

CREATE TABLE `tb_antrian` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `nomor_antrean` varchar(10) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `id_dokter` char(36) DEFAULT NULL,
  `id_bidan` char(36) DEFAULT NULL,
  `tanggal_antrian` date NOT NULL,
  `jam_antrian` time DEFAULT NULL,
  `status` enum('menunggu','selesai','batal') DEFAULT 'menunggu',
  `status_konfirmasi` enum('pending','dikonfirmasi','ditolak') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_antrian`
--

INSERT INTO `tb_antrian` (`id`, `uuid`, `nomor_antrean`, `id_pasien`, `id_dokter`, `id_bidan`, `tanggal_antrian`, `jam_antrian`, `status`, `status_konfirmasi`, `created_at`) VALUES
(6, 'ce51b978-71b5-4499-95ab-d4c38fe1b1f6', 'A001', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, '2025-05-16', NULL, 'batal', 'ditolak', '2025-05-01 18:31:53'),
(7, 'ba157f95-cb02-49c6-80d1-3f7e2d36b3d3', '', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, '2025-05-08', NULL, 'batal', 'ditolak', '2025-05-01 18:37:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bidan`
--

CREATE TABLE `tb_bidan` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_bidan`
--

INSERT INTO `tb_bidan` (`id`, `uuid`, `nama`, `no_telepon`, `created_at`) VALUES
(1, '4cbc981c-427b-4abb-b18e-9843822b6f03', 'Bidan Mary', '084261726323', '2025-05-03 14:23:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_chat`
--

CREATE TABLE `tb_chat` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `id_dokter` char(36) DEFAULT NULL,
  `id_bidan` char(36) DEFAULT NULL,
  `pesan` text NOT NULL,
  `pengirim` enum('pasien','dokter','bidan') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_chat`
--

INSERT INTO `tb_chat` (`id`, `uuid`, `id_pasien`, `id_dokter`, `id_bidan`, `pesan`, `pengirim`, `created_at`) VALUES
(1, 'b35f6540-2940-11f0-824e-7365a1f6edc2', 'ce51b978-71b5-4499-95ab-d4c38fe1b1f6', 'd123e456-7890-1234-5678-1234567890ab', NULL, 'Silakan datang jam 10:00.', 'dokter', '2025-05-04 23:37:11'),
(2, 'b35f85cd-2940-11f0-824e-7365a1f6edc2', 'ce51b978-71b5-4499-95ab-d4c38fe1b1f6', NULL, 'b123e456-7890-1234-5678-1234567890ac', 'Periksa rutin besok.', 'bidan', '2025-05-04 23:37:11'),
(3, '903729ea-e564-4501-ac46-80473277f1a6', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'Baik, terima kasih.', 'dokter', '2025-05-01 13:33:33'),
(4, '6ac64949-9c7b-423d-8734-4fa68f94296e', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'skimatt', 'dokter', '2025-05-01 13:36:21'),
(5, 'af1df2f9-b674-4225-9396-b03fdb3a6b9c', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'skimatt', 'dokter', '2025-05-01 14:05:36'),
(6, '753a6c75-7ac2-43e7-8709-d49a18300dbd', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'kaluh ka pajoh bu nyan', 'dokter', '2025-05-01 14:05:48'),
(7, '67544d81-e35a-4930-b47e-3b5d498c1dab', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'kenapa kak', 'pasien', '2025-05-01 14:18:04'),
(8, 'a01c2c5b-2b34-40cf-beff-18ac7f1f2d98', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'kaluh bu kan ?', 'dokter', '2025-05-01 15:25:01'),
(9, 'af13ea0c-7388-403a-b8c6-9a3537137cf3', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'apa masalah kamu?', 'pasien', '2025-05-01 15:30:56'),
(10, 'e16cadd5-a917-43a0-a407-cbecb48105d6', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'kaluh bu kan', 'dokter', '2025-05-01 16:01:15'),
(11, 'cda08a7d-a20a-4010-8d7e-c9ba35c8c000', '41534390-1fe6-49ac-bf8d-014d91881c53', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'jangan lupa makan', 'dokter', '2025-05-01 16:28:06'),
(12, '1910e668-4abc-4532-8cd1-33f870827034', 'ce51b978-71b5-4499-95ab-d4c38fe1b1f6', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'wwwwwwwwww', 'pasien', '2025-05-03 09:12:20'),
(13, 'e6cfe365-8c3c-4a22-909f-06d43adcf4b8', 'ce51b978-71b5-4499-95ab-d4c38fe1b1f6', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'halo', 'dokter', '2025-05-04 08:32:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dokter`
--

CREATE TABLE `tb_dokter` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `spesialisasi` varchar(255) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_dokter`
--

INSERT INTO `tb_dokter` (`id`, `uuid`, `nama`, `email`, `spesialisasi`, `no_telepon`, `created_at`) VALUES
(1, 'd123e456-7890-1234-5678-1234567890ab', 'Dr. Smith', NULL, 'Umum', NULL, '2025-05-04 23:17:28'),
(6, '3bb6120f-079a-46ce-9562-e57c8cb26283', 'dokter rahmat', NULL, 'otak', '082239434989', '2025-05-01 18:24:22'),
(7, '836f3602-cf32-4eba-b05b-2f850b933c3e', 'skimatt', NULL, 'jantung', '082239434989', '2025-05-05 02:28:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dokumen_medis`
--

CREATE TABLE `tb_dokumen_medis` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `keterangan` text,
  `tanggal_upload` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jadwal_praktik`
--

CREATE TABLE `tb_jadwal_praktik` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_dokter` char(36) DEFAULT NULL,
  `id_bidan` char(36) DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_jadwal_praktik`
--

INSERT INTO `tb_jadwal_praktik` (`id`, `uuid`, `id_dokter`, `id_bidan`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES
(1, 'f2470fef-293d-11f0-824e-7365a1f6edc2', 'd123e456-7890-1234-5678-1234567890ab', NULL, 'Senin', '08:00:00', '12:00:00', '2025-05-04 23:17:28'),
(2, 'f2471e85-293d-11f0-824e-7365a1f6edc2', 'd123e456-7890-1234-5678-1234567890ab', NULL, 'Selasa', '08:00:00', '12:00:00', '2025-05-04 23:17:28'),
(3, 'f24eecad-293d-11f0-824e-7365a1f6edc2', NULL, 'b123e456-7890-1234-5678-1234567890ac', 'Senin', '13:00:00', '17:00:00', '2025-05-04 23:17:28'),
(4, '18efad81-6bd7-42fc-bcf6-60d750ab6abc', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'Senin', '13:00:00', '17:00:00', '2025-05-01 21:01:57'),
(5, '6e916323-682c-4d0c-8af8-03cf7fb49042', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'Selasa', '04:15:00', '04:16:00', '2025-05-01 21:13:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_notifikasi`
--

CREATE TABLE `tb_notifikasi` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `id_dokter` char(36) DEFAULT NULL,
  `pesan` text NOT NULL,
  `status` enum('belum_dibaca','dibaca') DEFAULT 'belum_dibaca',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_notifikasi`
--

INSERT INTO `tb_notifikasi` (`id`, `uuid`, `id_pasien`, `id_dokter`, `pesan`, `status`, `created_at`) VALUES
(4, '47ad13f2-fece-4172-8fa4-3b5d7bc483db', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', NULL, 'Janji temu Anda pada 2025-05-16 telah dikonfirmasi oleh dokter.', 'dibaca', '2025-05-01 14:03:53'),
(5, 'aa4ec4ad-482c-4a1b-92e1-c0739336f6c5', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', NULL, 'Janji temu Anda pada 2025-05-08 telah ditolak oleh dokter.', 'dibaca', '2025-05-01 14:03:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_obat`
--

CREATE TABLE `tb_obat` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `jenis_obat` varchar(255) NOT NULL,
  `stok` int(11) DEFAULT '0',
  `harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_obat`
--

INSERT INTO `tb_obat` (`id`, `uuid`, `nama_obat`, `jenis_obat`, `stok`, `harga`, `created_at`) VALUES
(3, '04ca57e6-1edf-4cda-935c-4da54668087e', 'bodrex', 'untuk tubuh', 300, '20000.00', '2025-05-01 18:28:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pasien`
--

CREATE TABLE `tb_pasien` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text,
  `no_telepon` varchar(20) DEFAULT NULL,
  `no_kk` varchar(16) NOT NULL,
  `no_ktp` varchar(16) NOT NULL,
  `nomor_bpjs` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `golongan_darah` enum('A','B','AB','O') DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `status_perkawinan` enum('Belum Menikah','Menikah','Duda','Janda') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pasien`
--

INSERT INTO `tb_pasien` (`id`, `uuid`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_telepon`, `no_kk`, `no_ktp`, `nomor_bpjs`, `profile_picture`, `golongan_darah`, `agama`, `pekerjaan`, `status_perkawinan`, `created_at`) VALUES
(4, '947e50a4-c06f-465f-b88f-6f30d040d9be', 'Rahmat Mulia', '2025-05-08', 'L', '', '082239434989', '1111111111111111', '1234567890123456', '3456789087657', '947e50a4-c06f-465f-b88f-6f30d040d9be_1746495004.png', 'B', 'islam', 'Model', '', '2025-05-05 01:56:51'),
(5, 'cb4ae0ec-f0be-46bf-8e51-0bcbdc2f7fc1', 'Rahmat Mulia', '2025-05-08', 'L', NULL, '082239434989', '1111111111111111', '1234567890123456', '3456789087657', NULL, '', 'islam', 'Model', NULL, '2025-05-06 01:36:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_tagihan` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('tunai','transfer_bank','kartu_kredit','kartu_debit','bpjs','lainnya') NOT NULL,
  `status` enum('pending','dikonfirmasi','ditolak') DEFAULT 'pending',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id`, `uuid`, `id_tagihan`, `id_pasien`, `tanggal_pembayaran`, `jumlah`, `metode_pembayaran`, `status`, `bukti_pembayaran`, `keterangan`, `created_at`) VALUES
(1, 'pembayaran-uuid-123', 'tagihan-uuid-123', 'pasien-uuid-123', '2025-05-03 20:13:50', '150000.00', 'transfer_bank', 'pending', NULL, NULL, '2025-05-03 13:13:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rekam_medis`
--

CREATE TABLE `tb_rekam_medis` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `id_dokter` char(36) DEFAULT NULL,
  `id_bidan` char(36) DEFAULT NULL,
  `diagnosa` text,
  `tindakan` text,
  `obat` text,
  `tanggal_kunjungan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_rekam_medis`
--

INSERT INTO `tb_rekam_medis` (`id`, `uuid`, `id_pasien`, `id_dokter`, `id_bidan`, `diagnosa`, `tindakan`, `obat`, `tanggal_kunjungan`, `created_at`) VALUES
(1, 'f9271280-9d14-4c6d-a6a2-eba67ce50eb2', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'otak meletus', 'jaga pola tidur', 'minum sekali setahun', '2025-05-01 13:27:20', '2025-05-01 18:27:20'),
(2, 'rekam-uuid-123', 'pasien-uuid-123', NULL, NULL, 'Flu', 'Istirahat', NULL, '2025-05-03 13:13:50', '2025-05-03 13:13:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_resep`
--

CREATE TABLE `tb_resep` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_rekam_medis` char(36) NOT NULL,
  `id_obat` char(36) NOT NULL,
  `jumlah` int(11) DEFAULT '1',
  `aturan_pakai` varchar(255) DEFAULT NULL,
  `status_ambil` enum('belum','sudah') DEFAULT 'belum',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_resep`
--

INSERT INTO `tb_resep` (`id`, `uuid`, `id_rekam_medis`, `id_obat`, `jumlah`, `aturan_pakai`, `status_ambil`, `created_at`) VALUES
(1, '3cde06cf-3032-42d4-876c-27baf461ee04', 'f9271280-9d14-4c6d-a6a2-eba67ce50eb2', '04ca57e6-1edf-4cda-935c-4da54668087e', 2, 'minum 1', 'belum', '2025-05-01 18:30:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_riwayat`
--

CREATE TABLE `tb_riwayat` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `id_dokter` char(36) DEFAULT NULL,
  `id_bidan` char(36) DEFAULT NULL,
  `jenis_pelayanan` varchar(255) NOT NULL,
  `tanggal_kunjungan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('selesai','dirujuk') DEFAULT 'selesai',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diagnosa` text,
  `tindakan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_riwayat`
--

INSERT INTO `tb_riwayat` (`id`, `uuid`, `id_pasien`, `id_dokter`, `id_bidan`, `jenis_pelayanan`, `tanggal_kunjungan`, `status`, `created_at`, `diagnosa`, `tindakan`) VALUES
(2, '7cfc741a-c8f8-427c-a159-c3597db1ccd8', 'b7b5c17a-5003-4af7-9b5f-f648125c3ca0', '3bb6120f-079a-46ce-9562-e57c8cb26283', NULL, 'otak', '2025-05-13 17:00:00', 'selesai', '2025-05-01 18:26:30', 'diare', 'error orang nya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tagihan`
--

CREATE TABLE `tb_tagihan` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `id_pasien` char(36) NOT NULL,
  `id_rekam_medis` char(36) DEFAULT NULL,
  `tanggal_tagihan` date NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `status` enum('belum_dibayar','dibayar','kadaluarsa') DEFAULT 'belum_dibayar',
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_tagihan`
--

INSERT INTO `tb_tagihan` (`id`, `uuid`, `id_pasien`, `id_rekam_medis`, `tanggal_tagihan`, `tanggal_kunjungan`, `jumlah`, `status`, `keterangan`, `created_at`) VALUES
(1, 'tagihan-uuid-123', 'pasien-uuid-123', 'rekam-uuid-123', '2025-05-03', '2025-05-01', '150000.00', 'belum_dibayar', NULL, '2025-05-03 13:13:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `uuid` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `no_ktp` varchar(16) NOT NULL,
  `role` enum('admin','dokter','pasien','bidan') NOT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `uuid`, `email`, `password`, `nama`, `no_kk`, `no_ktp`, `role`, `is_active`, `verification_token`, `reset_token`, `created_at`) VALUES
(19, 'admin-uuid-1', 'admin@puskesmas.com', '$2y$12$3MYFjT.FhQEDyCP3v..Tr.adbnFnhqdGM7V8Hr6yFTALFU76fRqrK', 'Admin', '0000000000000000', '0000000000000000', 'admin', 1, NULL, NULL, '2025-05-01 13:06:13'),
(25, '3bb6120f-079a-46ce-9562-e57c8cb26283', 'rahmatzkk10@gmail.com', '$2y$10$ymrJopW/aNogNSr6lIT9TOjlcleSZerTZ5oF2Zv9sMqFQxCJWHJcW', 'dokter rahmat', '0000000000000000', '0000000000000000', 'dokter', 1, NULL, NULL, '2025-05-01 18:24:22'),
(32, '4cbc981c-427b-4abb-b18e-9843822b6f03', 'dokter@gmail.com', '$2y$10$eXn/mGqRWJrRUP6J5x9QsuYpd26Es6s6rMi18wIrLqHmxBIjf//XS', 'zulkifli', '0000000000000000', '0000000000000000', 'bidan', 1, NULL, NULL, '2025-05-03 14:23:15'),
(35, '836f3602-cf32-4eba-b05b-2f850b933c3e', 'anjay@gmail.com', '$2y$10$v0YFLkuXk65C6aj3idsRHeB0oHlDqfb.KauyT6csODDZf2N4D3pgO', 'skimatt', '0000000000000000', '0000000000000000', 'dokter', 1, NULL, NULL, '2025-05-05 02:28:59'),
(36, 'cb4ae0ec-f0be-46bf-8e51-0bcbdc2f7fc1', 'rahmatmulia.11@icloud.com', '$2y$10$LZCLYJJMahQ9fuy.1aqmMOVBzI5t4EBTT5Z8.s3pLqWVMHWb77tX.', 'Rahmat Mulia', '1111111111111111', '1234567890123456', 'pasien', 1, NULL, NULL, '2025-05-06 01:36:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kartu_berobat`
--
ALTER TABLE `kartu_berobat`
  ADD PRIMARY KEY (`id_kartu`),
  ADD UNIQUE KEY `nomor_kartu` (`nomor_kartu`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `tb_antrian`
--
ALTER TABLE `tb_antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_bidan`
--
ALTER TABLE `tb_bidan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_dokumen_medis`
--
ALTER TABLE `tb_dokumen_medis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `tb_jadwal_praktik`
--
ALTER TABLE `tb_jadwal_praktik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_obat`
--
ALTER TABLE `tb_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tagihan` (`id_tagihan`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `tb_rekam_medis`
--
ALTER TABLE `tb_rekam_medis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indeks untuk tabel `tb_resep`
--
ALTER TABLE `tb_resep`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_rekam_medis` (`id_rekam_medis`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kartu_berobat`
--
ALTER TABLE `kartu_berobat`
  MODIFY `id_kartu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_antrian`
--
ALTER TABLE `tb_antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_bidan`
--
ALTER TABLE `tb_bidan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_dokumen_medis`
--
ALTER TABLE `tb_dokumen_medis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jadwal_praktik`
--
ALTER TABLE `tb_jadwal_praktik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_obat`
--
ALTER TABLE `tb_obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_rekam_medis`
--
ALTER TABLE `tb_rekam_medis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_resep`
--
ALTER TABLE `tb_resep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kartu_berobat`
--
ALTER TABLE `kartu_berobat`
  ADD CONSTRAINT `kartu_berobat_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dokumen_medis`
--
ALTER TABLE `tb_dokumen_medis`
  ADD CONSTRAINT `tb_dokumen_medis_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
