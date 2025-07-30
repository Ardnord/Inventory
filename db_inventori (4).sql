-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jul 2025 pada 07.33
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventori`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `nama_barang` varchar(80) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `harga` bigint(20) NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `stok`, `harga`, `satuan`, `image`) VALUES
(3, 'BRG-001', 'Sekrup Gipsum 6x1', 3, 150, 'pcs', '4e53ebc302f120ac6cb90d16ca7a6923.jpg'),
(4, 'BRG-002', 'Keran Air Tembok', 12, 25000, 'buah', '17bd43145746eef4ba24d784942e540f.jpg'),
(5, 'BRG-003', 'Mesin Bor Tangan 10mm', 15, 280000, 'unit', 'fa3daced91ca44bf12adc2831045080a.jpg'),
(6, 'BRG-004', 'Set Kunci Sok 24pcs', 15, 850000, 'set', 'd87d6fef6d9beb000a123b49a1559868.jpg'),
(7, 'BRG-005', 'Pipa PVC 1/2 inch', 15, 10000, 'meter', '11a143f8877dbcb72bd722338c056816.jpg'),
(8, 'BRG-006', 'Keramik Lantai 40x40 Putih Polos', 15, 55000, 'meter', 'e292c8cb2f74225f3ecd3467f07ee71f.jpg'),
(9, 'BRG-007', 'Pasir Cor', 101, 250000, 'zak', 'ec0400e8a1f72a4b84ae7fe9732e7a54.jpg'),
(10, 'BRG-008', 'Kawat Bendrat', 15, 20000, 'kg', '811cf403118605fb3bd13828dc63e6a0.jpg'),
(11, 'BRG-009', 'Batu Pondasi', 15, 200000, 'ton', '224de6c4f490df14bc843f2e2a41dabf.jpg'),
(12, 'BRG-010', 'Semen Portland 40kg', 15, 62000, 'zak', '43d6ea44fa7c5a93ca377012ac0b23d7.jpg'),
(13, 'BRG-011', 'Batu Kerikil Hias', 15, 35000, 'karung', 'a74597e1a2c91fe08c4ee4e9bf84b516.jpg'),
(14, 'BRG-012', 'Thinner A Special', 15, 25000, 'liter', 'ab313e7b6aa1bd430fca4cd798f9c458.jpg'),
(15, 'BRG-013', 'Cat Tembok Interior 5kg', 15, 150000, 'kaleng', 'a7175c30d635209ba6c1bdd186867e59.jpg'),
(16, 'BRG-014', 'Aspal Cair / Emulsi', 16, 2500000, 'drum', 'eb4bfc55dfbf1a236d4097a6bcc82d7a.jpg'),
(17, 'BRG-015', 'Besi Beton 10mm Polos', 15, 65000, 'batang', '9ad9ca91e886d108cd3b86c01a1b2649.jpg'),
(18, 'BRG-016', 'Pipa Tembaga 5/8 inch', 19, 406000, 'batang', '68131724f3d8d51643afa14d7cfa14f6.jpg'),
(19, 'BRG-017', 'Kabel Listrik NYM 2x1.5mm', 15, 550000, 'rol', '0dbbcd5d3049d8995f797c22c8c16ef2.jpg'),
(20, 'BRG-018', 'Kawat Las Listrik', 15, 150000, 'coil', '3eadfa142929598bfa74e746fe94856c.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(80) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `kode`, `nama`, `email`, `telepon`, `alamat`) VALUES
(2, 'CST2', 'Siti Aminah', 'sitiaminah.work@mail.com', '087890123456', 'Apartemen Taman Anggrek, Tower 3, Lantai 22 Unit F, Grogol Petamburan, Jakarta Barat'),
(3, 'CST3', 'Agus Wijaya', 'agus.wijaya88@ymail.com', '085788889999', 'Jalan Arjuna Selatan No. 7, RT.05/RW.09, Kebon Jeruk, Jakarta Barat'),
(4, 'CST4', 'Dewi Lestari', 'dewi.lestari.official@gmail.co.id', '081311223344', 'Perumahan Puri Indah, Blok A5 No. 12, Kembangan Selatan, Kembangan, Jakarta Barat'),
(6, 'CST224', 'mentari', 'aaaaaa@gmail.com', '0813495845698', 'cideng');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_toko`
--

CREATE TABLE `data_toko` (
  `id` int(11) NOT NULL,
  `nama_toko` varchar(80) DEFAULT NULL,
  `nama_pemilik` varchar(80) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_toko`
--

INSERT INTO `data_toko` (`id`, `nama_toko`, `nama_pemilik`, `no_telepon`, `alamat`) VALUES
(1, 'Toko SIAP ( Solusi Istana Anda Prima )', 'Wardana', '081299764535', 'Jakarta Barat\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_keluar`
--

CREATE TABLE `detail_keluar` (
  `no_keluar` varchar(25) DEFAULT NULL,
  `nama_barang` varchar(80) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga` bigint(20) NOT NULL,
  `sub_total` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_keluar`
--

INSERT INTO `detail_keluar` (`no_keluar`, `nama_barang`, `jumlah`, `satuan`, `harga`, `sub_total`) VALUES
('KL-1750792794', 'Thinner A Special', 8, 'liter', 25000, 200000),
('KL-1750792794', 'Besi Beton 10mm Polos', 10, 'batang', 65000, 650000),
('KL-1750792814', 'Batu Pondasi', 6, 'ton', 200000, 1200000),
('KL-1750792814', 'Mesin Bor Tangan 10mm', 1, 'unit', 280000, 280000),
('KL-1750792814', 'Pipa Tembaga 5/8 inch', 7, 'batang', 406000, 2842000),
('KL-1752652951', 'Sekrup Gipsum 6x1', 6, 'pcs', 150, 900),
('KL-1752652951', 'Sekrup Gipsum 6x1', 2, 'pcs', 150, 300),
('KL-1752710296', 'Sekrup Gipsum 6x1', 1, 'pcs', 150, 150),
('KL-1752719500', 'Sekrup Gipsum 6x1', 7, 'pcs', 150, 1050),
('KL-1752721211', 'Sekrup Gipsum 6x1', 1, 'pcs', 150, 150),
('KL-1752721245', 'Sekrup Gipsum 6x1', 3, 'pcs', 150, 450),
('KL-1752721939', 'Sekrup Gipsum 6x1', 5, 'pcs', 150, 750),
('KL-1752721980', 'Sekrup Gipsum 6x1', 8, 'pcs', 150, 1200);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_terima`
--

CREATE TABLE `detail_terima` (
  `no_terima` varchar(25) DEFAULT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(80) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_terima`
--

INSERT INTO `detail_terima` (`no_terima`, `kode_barang`, `nama_barang`, `jumlah`, `satuan`) VALUES
('TR1584538872', '', 'Keyboard', 1, 'pcs'),
('TR1584538872', '', 'Mouse', 1, 'pcs'),
('TR1584539271', '', 'Keyboard', 4, 'pcs'),
('TR1750208326', '', 'Mouse', 1, 'pcs'),
('TR1750532917', '', 'Mesin Bor Tangan 10mm', 2, 'unit'),
('TR1750532917', '', 'Mesin Bor Tangan 10mm', 2, 'unit'),
('TR1750532917', '', 'Mesin Bor Tangan 10mm', 2, 'unit'),
('TR1750535358', 'BRG-007', 'Pasir Cor', 1, 'm³'),
('TR1750535516', 'BRG-014', 'Aspal Cair / Emulsi', 1, 'drum'),
('TR1752634310', 'BRG-016', 'Pipa Tembaga 5/8 inch', 4, 'batang'),
('TR1752652837', 'BRG-001', 'Sekrup Gipsum 6x1', 3, 'pcs');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerimaan`
--

CREATE TABLE `penerimaan` (
  `id` int(11) NOT NULL,
  `no_terima` varchar(25) DEFAULT NULL,
  `tgl_terima` date NOT NULL,
  `jam_terima` varchar(10) DEFAULT NULL,
  `kode_supplier` varchar(50) NOT NULL,
  `nama_petugas` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penerimaan`
--

INSERT INTO `penerimaan` (`id`, `no_terima`, `tgl_terima`, `jam_terima`, `kode_supplier`, `nama_petugas`) VALUES
(12, 'TR1752634310', '2025-07-16', '09:51:50', 'SPL641', 'Admin'),
(13, 'TR1752652837', '2025-07-16', '15:00:37', 'SPL641', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `no_keluar` varchar(25) DEFAULT NULL,
  `tgl_keluar` date NOT NULL,
  `jam_keluar` varchar(10) DEFAULT NULL,
  `nama_customer` varchar(80) DEFAULT NULL,
  `nama_petugas` varchar(80) DEFAULT NULL,
  `total_keluar` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `no_keluar`, `tgl_keluar`, `jam_keluar`, `nama_customer`, `nama_petugas`, `total_keluar`) VALUES
(14, 'KL-1750792794', '2025-06-25', '02:19:54', 'Agus Wijaya', 'Admin', 850000),
(15, 'KL-1750792814', '2025-06-25', '02:20:14', 'Siti Aminah', 'Admin', 4322000),
(17, 'KL-1752652951', '2025-07-16', '15:02:31', 'Siti Aminah', 'Andi', 1200),
(19, 'KL-1752710296', '2025-07-17', '06:58:16', 'Siti Aminah', 'Andi', 150),
(20, 'KL-1752719500', '2025-07-17', '09:31:40', 'Agus Wijaya', 'Andi', 1050),
(21, 'KL-1752721211', '2025-07-17', '10:00:11', 'Siti Aminah', 'Andi', 150),
(22, 'KL-1752721245', '2025-07-17', '10:00:45', 'Agus Wijaya', 'Admin', 450),
(23, 'KL-1752721939', '2025-07-17', '10:12:19', 'Dewi Lestari', 'Admin', 750),
(24, 'KL-1752721980', '2025-07-17', '10:13:00', 'Agus Wijaya', 'Andi', 1200);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `kode`, `nama`, `username`, `password`) VALUES
(1, 'PGN17', 'Admin', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id`, `kode`, `nama`, `username`, `password`) VALUES
(1, 'PETUGAS - 1', 'Rina', 'PTGS1', '123456');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(80) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `kode`, `nama`, `email`, `telepon`, `alamat`) VALUES
(1, 'SPL641', 'Bangun Jaya', 'BangunJayaCorp@web.com', '087814256738', 'Jakarta Barat');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_toko`
--
ALTER TABLE `data_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_terima` (`no_terima`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_keluar` (`no_keluar`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `data_toko`
--
ALTER TABLE `data_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penerimaan`
--
ALTER TABLE `penerimaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
