-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql305.infinityfree.com
-- Generation Time: Jun 05, 2026 at 09:34 PM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41786085_fansite`
--

-- --------------------------------------------------------

--
-- Table structure for table `galeri_event`
--

CREATE DATABASE fansite1
USE fansite1

CREATE TABLE `galeri_event` (
  `id_event` INT(11) NOT NULL,
  `nama_event` VARCHAR(200) NOT NULL,
  `tipe` ENUM('Theater Show','Off Air','On Air','Event','Meet & Greet','Lainnya') NOT NULL DEFAULT 'Theater Show',
  `tanggal` DATE NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri_event`
--

INSERT INTO `galeri_event` (`id_event`, `nama_event`, `tipe`, `tanggal`, `deskripsi`, `dibuat_pada`) VALUES
(2, 'Swara Semesta Surabaya', 'Off Air', '2026-04-18', 'Surabaya mbois! Mari kumpulkan kembali momen-momen keseruan JKT48 di panggung Swara Semesta Surabaya! 🎸✨\r\nHalaman galeri ini didedikasikan khusus untuk kalian para fans yang ingin berbagi kebahagiaan. Punya foto estetik atau video fancam seru dari performance kemarin? Yuk, upload hasil karyamu di sini dan mari abadikan momen indah ini bersama-sama! 📸 crowd kalian ditunggu, ya!', '2026-05-14 14:54:43'),
(3, '2nd Anniversary Aeon Mall Deltamas', 'Off Air', '2026-04-25', 'Kemeriahan yang luar biasa di perayaan ulang tahun! 🎉 Let\'s celebrate dan kumpulkan kembali momen-momen seru serta penampilan penuh energi dari JKT48 di panggung 2nd Anniversary Aeon Mall Deltamas! 🛍️✨\r\nHalaman galeri ini didedikasikan khusus untuk kalian para fans yang ingin berbagi kebahagiaan. Punya foto estetik atau video fancam seru dari performance kemarin? Yuk, upload hasil karyamu di sini dan mari abadikan momen indah ini bersama-sama! 📸 crowd kalian ditunggu, ya!', '2026-05-14 15:09:08'),
(4, 'Spectaphoria Volume 2 : Galaxy 2026', 'Off Air', '2026-04-26', 'Menjelajahi galeri penuh bintang di Negeri Laskar Pelangi! 🌟 Menjadi saksi kemegahan panggung JKT48 yang sukses menyinari malam di Spectaphoria Volume 2: Galaxy 2026, Belitung! Mari kita kumpulkan kembali momen-momen magis dan penuh memori dari sana! 🌌✨\r\nHalaman galeri ini didedikasikan khusus untuk kalian para fans yang ingin berbagi kebahagiaan. Punya foto estetik atau video fancam seru dari performance kemarin? Yuk, upload hasil karyamu di sini dan mari abadikan momen indah ini bersama-sama! 📸 crowd kalian ditunggu, ya!', '2026-05-14 15:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `galeri_foto`
--

CREATE TABLE `galeri_foto` (
  `id_foto` INT(11) NOT NULL,
  `id_event` INT(11) NOT NULL,
  `id_member` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `tipe_file` ENUM('foto','video') NOT NULL DEFAULT 'foto',
  `caption` VARCHAR(500) DEFAULT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri_komentar`
--

CREATE TABLE `galeri_komentar` (
  `id_komentar` INT(11) NOT NULL,
  `id_foto` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `isi` TEXT NOT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` INT(11) NOT NULL,
  `tanggal_jadwal` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `waktu_jadwal` TIME DEFAULT NULL,
  `nama_acara` VARCHAR(200) NOT NULL,
  `tipe` ENUM('Theater Show','Off Air','On Air','Event','Meet & Greet','Lainnya') NOT NULL DEFAULT 'Theater Show',
  `lokasi` VARCHAR(200) NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `foto` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `tanggal_jadwal`, `waktu_jadwal`, `nama_acara`, `tipe`, `lokasi`, `deskripsi`, `foto`) VALUES
(1, '2026-04-18 12:00:00', '19:30:00', 'Swara Semesta Surabaya', 'Off Air', 'SURABAYA EXPO CENTER', NULL, 'public/images/jadwal/jadwal_69fa8f4f79dc2.jpg'),
(3, '2026-05-01 12:00:00', '21:00:00', 'Cara Meminum Ramune', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Kembalilah menikmati kesegaran dan makna mendalam di JKT48 Theater melalui setlist \"Cara Meminum Ramune\"! Pertunjukan ini bukan sekadar tentang keceriaan, tapi juga membawa pesan berharga tentang indahnya menikmati hidup selangkah demi selangkah, sama seperti seni meminum ramune yang tidak boleh terburu-buru. Setelah sempat senshuraku pada 2021 dan kembali lagi karena besarnya antusiasme kalian, setlist top-tier ini siap kembali membasuh dahaga rindu para fans dengan deretan lagu ikonik dan penuh energi. Yuk, luangkan waktu sejenak dari hiruk-pikuk kedewasaan dan bersenang-senang bersama kami! 🌊💙\r\nMember yang Tampil: Alya, Anindya, Lia, Lana, Cathy, Elin, Cynthia, Fritzy, Lili, Indah, Trisha, dan Nayla.\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nJangan sampai kelewatan momen \"segar\" ini, sampai jumpa di Theater! 💙', 'public/images/jadwal/jadwal_69fa922688375.jpg'),
(4, '2026-05-02 09:00:00', '18:00:00', 'Pajama Drive', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Saksikan awal mula perjalanan para bintang masa depan JKT48! Pajama Drive adalah panggung penuh semangat yang dibawakan khusus oleh para Trainee JKT48. Di sini, kamu bisa melihat dedikasi dan kerja keras mereka dalam menggapai impian menjadi member inti. Jangan lewatkan energi murni dan keceriaan khas yang hanya bisa kamu rasakan di setlist legendaris ini! ✨🚀\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita berikan dukungan terbaik untuk langkah pertama mereka di atas panggung! ❤️', 'public/images/jadwal/jadwal_69fa9272c53dc.jpg'),
(5, '2026-05-03 07:00:00', '16:00:00', 'Pajama Drive', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Saksikan awal mula perjalanan para bintang masa depan JKT48! Pajama Drive adalah panggung penuh semangat yang dibawakan khusus oleh para Trainee JKT48. Di sini, kamu bisa melihat dedikasi dan kerja keras mereka dalam menggapai impian menjadi member inti. Jangan lewatkan energi murni dan keceriaan khas yang hanya bisa kamu rasakan di setlist legendaris ini! ✨🚀\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita berikan dukungan terbaik untuk langkah pertama mereka di atas panggung! ❤️', 'public/images/jadwal/jadwal_69fa92a217e14.jpg'),
(6, '2026-05-03 12:00:00', '21:00:00', 'Pertaruhan Cinta', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Saksikan puncak sejarah baru JKT48 dalam Original Setlist: Pertaruhan Cinta! Setelah penantian panjang sejak tahun 2021, mahakarya yang menjadi kebanggaan kita semua ini akhirnya hadir di atas panggung Theater. Menampilkan deretan lagu pure karya orisinal JKT48 hasil kolaborasi dengan musisi ternama Indonesia seperti Andi Rianto, Bernadya, Laleilmanino, dan masih banyak lagi. 🎭✨\r\nInilah bukti nyata identitas dan kreativitas tanpa batas JKT48. Jangan lewatkan kesempatan untuk menjadi bagian dari perayaan pride terbesar ini dalam balutan performa yang emosional, jujur, dan tak terlupakan! ❤️\r\nMember yang Tampil: Anindya, Lia, Lana, Cathy, Chelsea, Oniel, Daisy, Indah, Jessi, Lyn, Kathrina, dan Lulu.\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nAyo kita dukung karya asli anak bangsa dan buat malam ini penuh dengan kebanggaan bersama JKT48! 💎🌟', 'public/images/jadwal/jadwal_69fa92d1ca043.jpg'),
(7, '2026-05-08 12:00:00', '21:00:00', 'ITADAKI♥LOVE', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Rayakan momen spesial di JKT48 Theater! Kali ini, kita akan berkumpul bersama untuk merayakan Hari Ulang Tahun Michie dalam pertunjukan spesial setlist \"ITADAKI♥LOVE\". Mari berikan energi terbaik dan kenangan tak terlupakan untuk Michie di hari istimewanya! 🎂✨\r\nMember yang Tampil: Anindya, Lia, Lana, Cathy, Elin, Cynthia, Fiony, Fritzy, Gracie, Indah, Trisha, dan Michie.\r\nCatatan Khusus:\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nSampai jumpa di Theater dan mari buat malam ini penuh cinta! ❤️', 'public/images/jadwal/jadwal_69fa930ea72fb.jpg'),
(8, '2026-05-09 07:00:00', '16:00:00', 'Pajama Drive', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Saksikan awal mula perjalanan para bintang masa depan JKT48! Pajama Drive adalah panggung penuh semangat yang dibawakan khusus oleh para Trainee JKT48. Di sini, kamu bisa melihat dedikasi dan kerja keras mereka dalam menggapai impian menjadi member inti. Jangan lewatkan energi murni dan keceriaan khas yang hanya bisa kamu rasakan di setlist legendaris ini! ✨🚀\r\nMember yang Tampil: Virgi, Rilly, Maira, Ekin, Jemima, Intan, Carissa, Fahira, Rara, Heidi, Ralyne, dan Sona.\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita berikan dukungan terbaik untuk langkah pertama mereka di atas panggung! ❤️', 'public/images/jadwal/jadwal_69fa934e911a2.jpg'),
(9, '2026-05-09 12:00:00', '22:00:00', 'Sambil Menggandeng Erat Tanganku', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Nikmati kehangatan dan persahabatan dalam setlist \"Sambil Menggandeng Erat Tanganku\"! Pertunjukan ini menghadirkan harmoni yang indah antara energi panggung yang ceria dan momen-momen emosional yang menyentuh hati. Mari kembali ke JKT48 Theater untuk menyaksikan penampilan memukau dari para member inti yang siap memberikan pengalaman teater tak terlupakan. 🤝✨\r\nMember yang Tampil: Aralie, Christy, Oniel, Danella, Daisy, Jessi, Kathrina, Lulu, Muthe, Raisha, Ribka, dan Kimmy.\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nSampai jumpa di Theater dan mari buat malam ini penuh cinta! ❤️', 'public/images/jadwal/jadwal_69fa93852acea.jpg'),
(10, '2026-05-10 09:00:00', '18:00:00', 'Dream Bakudan', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Bersiaplah untuk ledakan semangat di panggung JKT48! 💥 Sebagai bagian dari era terbaru JKT48 Fight, Team Dream hadir membawakan setlist \"Dream Bakudan\" (Bom Impian) yang penuh dengan energi dan ambisi. Jangan lewatkan perpaduan performa yang powerful dan mimpi-mimpi besar yang akan diledakkan oleh para member di atas panggung Theater! ✨🚀\r\nMember yang Tampil: Delynn, Olla, Freya, Ella, Gita, Greesel, Eli, Lyn, Marsha, Nachia, Oline, dan Nala.\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita dukung perjalanan Team Dream dalam meraih mimpi-mimpi mereka yang setinggi langit! ❤️🌟', 'public/images/jadwal/jadwal_69fa93e219518.jpg'),
(11, '2026-05-12 09:30:00', '19:00:00', 'ARISAN 48 - SPARKLING EDITION', 'Event', '+62 Coffee & Space - Lebak Bulus', 'JKT48 OFC Event akan segera hadir untuk menambah keseruan di bulan Mei bersama member Team Love, Dream dan Passion, dalam acara “ARISAN 48” yang akan mengajak kalian untuk beristirahat sejenak dari kesibukan—melepas penat dengan berkumpul dan berinteraksi sembari bermain berbagai permainan seru dan mencoba pengalaman baru: DIY (Do It Yourself) minuman ala kafe favorit kalian!', NULL),
(12, '2026-05-12 09:30:00', '19:00:00', 'ARISAN 48 - COFFEE EDITION', 'Event', '+62 Coffee & Space - Lebak Bulus', 'JKT48 OFC Event akan segera hadir untuk menambah keseruan di bulan Mei bersama member Team Love, Dream dan Passion, dalam acara “ARISAN 48” yang akan mengajak kalian untuk beristirahat sejenak dari kesibukan—melepas penat dengan berkumpul dan berinteraksi sembari bermain berbagai permainan seru dan mencoba pengalaman baru: DIY (Do It Yourself) minuman ala kafe favorit kalian!', NULL),
(13, '2026-05-12 09:30:00', '19:00:00', 'ARISAN 48 - MATCHA EDITION', 'Event', '+62 Coffee & Space - Lebak Bulus', 'JKT48 OFC Event akan segera hadir untuk menambah keseruan di bulan Mei bersama member Team Love, Dream dan Passion, dalam acara “ARISAN 48” yang akan mengajak kalian untuk beristirahat sejenak dari kesibukan—melepas penat dengan berkumpul dan berinteraksi sembari bermain berbagai permainan seru dan mencoba pengalaman baru: DIY (Do It Yourself) minuman ala kafe favorit kalian!', NULL),
(14, '2026-05-23 03:00:00', '19:00:00', 'Personal Meet and Greet Festival: LOVE DREAM PASSION, 2Shot - 23 May', 'Meet & Greet', 'Indonesia Convention Exhibition (ICE) - BSD', 'Bersiaplah untuk perayaan terbesar di era terbaru! JKT48 Personal Meet and Greet Festival: LOVE DREAM PASSION hadir sebagai titik temu perdana para fans dengan seluruh member di bawah tagline JKT48 Fight. Ini adalah kesempatan emas bagi kamu untuk berinteraksi lebih dekat, berbagi cerita, dan mengabadikan momen spesial bersama oshi kesayangan dalam satu atmosfer yang penuh semangat.\r\nMember Partisipan: Seluruh member JKT48 (Team Love, Team Dream, Team Passion, dan Trainee).\r\nRangkaian Acara:\r\n- Personal Meet & Greet: Obrolan hangat dan personal bersama member pilihanmu.\r\n- 2-Shot: Sesi foto berdua untuk kenang-kenangan yang abadi.\r\n- Mini Live Performance: Penutup manis berupa pertunjukan panggung spesial dari seluruh member di akhir acara.\r\nCatatan:\r\n- Pastikan kamu telah memiliki tiket sesuai dengan sesi dan member yang telah dipilih.\r\n- Harap datang tepat waktu sesuai jadwal sesi yang tertera pada tiket.\r\n- Patuhi protokol keamanan dan tata tertib selama berada di area Indonesia Convention Exhibition (ICE) - BSD.\r\nMari kita buat sejarah baru dan bakar semangat \"Fight\" bersama di festival ini! ❤️🔥', 'public/images/jadwal/jadwal_69fa971b60ecf.png'),
(15, '2026-05-23 03:00:00', '19:00:00', 'Personal Meet and Greet Festival: LOVE DREAM PASSION, 2Shot - 23 May', 'Meet & Greet', 'Indonesia Convention Exhibition (ICE) - BSD', 'Bersiaplah untuk perayaan terbesar di era terbaru! JKT48 Personal Meet and Greet Festival: LOVE DREAM PASSION hadir sebagai titik temu perdana para fans dengan seluruh member di bawah tagline JKT48 Fight. Ini adalah kesempatan emas bagi kamu untuk berinteraksi lebih dekat, berbagi cerita, dan mengabadikan momen spesial bersama oshi kesayangan dalam satu atmosfer yang penuh semangat.\r\nMember Partisipan: Seluruh member JKT48 (Team Love, Team Dream, Team Passion, dan Trainee).\r\nRangkaian Acara:\r\n- Personal Meet & Greet: Obrolan hangat dan personal bersama member pilihanmu.\r\n- 2-Shot: Sesi foto berdua untuk kenang-kenangan yang abadi.\r\n- Mini Live Performance: Penutup manis berupa pertunjukan panggung spesial dari seluruh member di akhir acara.\r\nCatatan:\r\n- Pastikan kamu telah memiliki tiket sesuai dengan sesi dan member yang telah dipilih.\r\n- Harap datang tepat waktu sesuai jadwal sesi yang tertera pada tiket.\r\n- Patuhi protokol keamanan dan tata tertib selama berada di area Indonesia Convention Exhibition (ICE) - BSD.\r\nMari kita buat sejarah baru dan bakar semangat \"Fight\" bersama di festival ini! ❤️🔥', 'public/images/jadwal/jadwal_69fa976be7f9c.png'),
(16, '2026-05-15 02:00:00', '21:00:00', 'ITADAKI♥LOVE', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Sambut Energi Cinta dari Team Love! 💖✨\r\nPersiapkan dirimu untuk masuk ke dalam dunia yang penuh warna dan keceriaan dalam pertunjukan ITADAKI♥LOVE. Sebagai setlist khusus yang dibawakan oleh Team Love, show ini menjanjikan atmosfer yang hangat, interaktif, dan penuh kejutan manis di setiap lagunya. Ini bukan sekadar pertunjukan teater biasa; ini adalah ruang di mana cinta dan dedikasi bertemu. Kami merayakan setiap detik kebersamaan, mulai dari tawa di atas panggung hingga momen-momen kecil yang membuat Team Love begitu spesial di hati para fans. 🎭🌈\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita balas setiap energi positif mereka dengan dukungan yang penuh kasih. Sampai jumpa di Theater dan biarkan hatimu dipenuhi oleh cinta dari Team Love! ❤️💖', 'public/images/jadwal/jadwal_6a015bde0ed2f.jpg'),
(17, '2026-05-16 02:00:00', '21:00:00', 'Pajama Drive', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Saksikan awal mula perjalanan para bintang masa depan JKT48! Pajama Drive adalah panggung penuh semangat yang dibawakan khusus oleh para Trainee JKT48. Di sini, kamu bisa melihat dedikasi dan kerja keras mereka dalam menggapai impian menjadi member inti. Jangan lewatkan energi murni dan keceriaan khas yang hanya bisa kamu rasakan di setlist legendaris ini! ✨🚀\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita berikan dukungan terbaik untuk langkah pertama mereka di atas panggung! ❤️', 'public/images/jadwal/jadwal_6a015c7800aee.jpg'),
(18, '2026-05-16 21:00:00', '16:00:00', 'Sambil Menggandeng Erat Tanganku', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Nikmati kehangatan dan persahabatan dalam setlist \"Sambil Menggandeng Erat Tanganku\"! Pertunjukan ini menghadirkan harmoni yang indah antara energi panggung yang ceria dan momen-momen emosional yang menyentuh hati. Mari kembali ke JKT48 Theater untuk menyaksikan penampilan memukau dari para member inti yang siap memberikan pengalaman teater tak terlupakan. 🤝✨\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nSampai jumpa di Theater dan mari buat malam ini penuh cinta! ❤️', 'public/images/jadwal/jadwal_6a015d5b555fd.jpg'),
(19, '2026-05-16 14:00:00', '21:00:00', 'Cara Meminum Ramune', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Kembalilah menikmati kesegaran dan makna mendalam di JKT48 Theater melalui setlist \"Cara Meminum Ramune\"! Pertunjukan ini bukan sekadar tentang keceriaan, tapi juga membawa pesan berharga tentang indahnya menikmati hidup selangkah demi selangkah, sama seperti seni meminum ramune yang tidak boleh terburu-buru. Setelah sempat senshuraku pada 2021 dan kembali lagi karena besarnya antusiasme kalian, setlist top-tier ini siap kembali membasuh dahaga rindu para fans dengan deretan lagu ikonik dan penuh energi. Yuk, luangkan waktu sejenak dari hiruk-pikuk kedewasaan dan bersenang-senang bersama kami! 🌊💙\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nJangan sampai kelewatan momen \"segar\" ini, sampai jumpa di Theater! 💙', 'public/images/jadwal/jadwal_6a015dbc672e9.jpg'),
(20, '2026-05-17 21:00:00', '16:00:00', 'Cara Meminum Ramune', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Kembalilah menikmati kesegaran dan makna mendalam di JKT48 Theater melalui setlist \"Cara Meminum Ramune\"! Pertunjukan ini bukan sekadar tentang keceriaan, tapi juga membawa pesan berharga tentang indahnya menikmati hidup selangkah demi selangkah, sama seperti seni meminum ramune yang tidak boleh terburu-buru. Setelah sempat senshuraku pada 2021 dan kembali lagi karena besarnya antusiasme kalian, setlist top-tier ini siap kembali membasuh dahaga rindu para fans dengan deretan lagu ikonik dan penuh energi. Yuk, luangkan waktu sejenak dari hiruk-pikuk kedewasaan dan bersenang-senang bersama kami! 🌊💙\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nJangan sampai kelewatan momen \"segar\" ini, sampai jumpa di Theater! 💙', 'public/images/jadwal/jadwal_6a015e10cb30f.jpg'),
(21, '2026-05-18 02:00:00', '21:00:00', 'PASSION 200%', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Bakar semangatmu lebih membara dari sebelumnya! 🔥 Menjadi bagian dari era JKT48 Fight, Team Passion siap menggebrak panggung dengan setlist \"PASSION 200%\". Pertunjukan ini menyuguhkan energi murni yang meluap, koreografi yang bertenaga, dan tekad tanpa batas yang akan membakar seluruh isi Theater. Rasakan intensitas maksimal dari para member yang siap memberikan segalanya melebihi batas 100%! ⚡️🎸\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nJangan biarkan api semangatmu padam! Mari bergabung dalam kemeriahan Team Passion dan rasakan pengalaman theater yang penuh ledakan tenaga! ❤️🔥', 'public/images/jadwal/jadwal_6a015fa0993c0.jpg'),
(22, '2026-05-20 02:00:00', '21:00:00', 'PASSION 200%', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Ruang khusus untuk berekspresi dan berbagi semangat! 🔥 Dalam rangkaian JKT48 Fight, Team Passion menghadirkan pertunjukan spesial \"Passion 200%: Ladies and Kids Night\". Malam ini, JKT48 Theater didedikasikan sepenuhnya untuk para fans perempuan dan adik-adik tercinta agar dapat menikmati energi luar biasa dari Team Passion dengan lebih nyaman, aman, dan ceria. Mari meledak bersama dalam koreografi yang powerful dan harmoni yang menginspirasi, membuktikan bahwa semangat Passion milik kita semua! ✨🎸\r\nCatatan Khusus:\r\n- Khusus Pengunjung Wanita & Anak-anak: Pertunjukan ini hanya dapat dihadiri oleh fans perempuan dan anak-anak (didampingi wali perempuan jika diperlukan).\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nSiapkan lightstick kalian dan mari buat kenangan manis yang penuh tenaga di malam yang istimewa ini! ❤️👧👩🔥', 'public/images/jadwal/jadwal_6a0160af05a60.jpg'),
(23, '2026-05-21 02:00:00', '21:00:00', 'ITADAKI♥LOVE', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Sambut Energi Cinta dari Team Love! 💖✨Persiapkan dirimu untuk masuk ke dalam dunia yang penuh warna dan keceriaan dalam pertunjukan ITADAKI♥LOVE. Sebagai setlist khusus yang dibawakan oleh Team Love, show ini menjanjikan atmosfer yang hangat, interaktif, dan penuh kejutan manis di setiap lagunya. Ini bukan sekadar pertunjukan teater biasa; ini adalah ruang di mana cinta dan dedikasi bertemu. Kami merayakan setiap detik kebersamaan, mulai dari tawa di atas panggung hingga momen-momen kecil yang membuat Team Love begitu spesial di hati para fans. 🎭🌈\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita balas setiap energi positif mereka dengan dukungan yang penuh kasih. Sampai jumpa di Theater dan biarkan hatimu dipenuhi oleh cinta dari Team Love! ❤️💖', 'public/images/jadwal/jadwal_6a016123d7c61.jpg'),
(24, '2026-05-22 02:00:00', '21:00:00', 'Dream Bakudan', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Bersiaplah untuk ledakan semangat di panggung JKT48! 💥 Sebagai bagian dari era terbaru JKT48 Fight, Team Dream hadir membawakan setlist \"Dream Bakudan\" (Bom Impian) yang penuh dengan energi dan ambisi. Jangan lewatkan perpaduan performa yang powerful dan mimpi-mimpi besar yang akan diledakkan oleh para member di atas panggung Theater! ✨🚀\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita dukung perjalanan Team Dream dalam meraih mimpi-mimpi mereka yang setinggi langit! ❤️🌟', 'public/images/jadwal/jadwal_6a01618b29645.jpg'),
(25, '2026-05-25 02:00:00', '09:00:00', 'Pajama Drive', 'Theater Show', 'JKT48 Theater - fX Sudirman (F4)', 'Saksikan awal mula perjalanan para bintang masa depan JKT48! Pajama Drive adalah panggung penuh semangat yang dibawakan khusus oleh para Trainee JKT48. Di sini, kamu bisa melihat dedikasi dan kerja keras mereka dalam menggapai impian menjadi member inti. Jangan lewatkan energi murni dan keceriaan khas yang hanya bisa kamu rasakan di setlist legendaris ini! ✨🚀\r\nMember yang Tampil: -\r\nCatatan Khusus:\r\n- Daftar member yang tampil dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.\r\n- Tiket hanya tersedia melalui pembelian resmi di website JKT48.\r\n- Mohon mematuhi seluruh protokol dan tata tertib yang berlaku di dalam JKT48 Theater.\r\nMari kita berikan dukungan terbaik untuk langkah pertama mereka di atas panggung! ❤️', 'public/images/jadwal/jadwal_6a0161d07bd7c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` INT(11) NOT NULL,
  `nama_member` VARCHAR(200) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `foto` VARCHAR(200) DEFAULT NULL,
  `foto_casual` VARCHAR(255) DEFAULT NULL,
  `gen` ENUM('Gen 1','Gen 2','Gen 3','Gen 4','Gen 5','Gen 6','Gen 7','Gen 8','Gen 9','Gen 10','Gen 11','Gen 12','Gen 13','Gen 14','Gen 1 JKT48V','Gen 2 JKT48V') NOT NULL,
  `asal` VARCHAR(200) NOT NULL,
  `deskripsi` TEXT NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

UPDATE jadwal
SET deskripsi = REPLACE(deskripsi, '????????', '') 
WHERE deskripsi LIKE '%????????%';

INSERT INTO `member` (`id_member`, `nama_member`, `tanggal_lahir`, `foto`, `foto_casual`, `gen`, `asal`, `deskripsi`) VALUES
(2, 'Angelina Christy', '2005-12-05', 'public/images/member/uploads/kabesha_69f9486647407.jpg', 'public/images/member/uploads/casual_69f9486647903.jpg', 'Gen 7', 'Jakarta', 'Peduli dan berbaik hati, siapakah dia? Christy. Begitulah salam perkenalan dari Christy, member JKT48 dari generasi 7. Gadis yang berasal dari Jakarta ini dikenal memiliki kepribadian yang cukup unik yaitu Christy sering melamun. Di luar aktivitasnya sebagai idol, Christy memiliki hobi yang cukup menarik, yaitu menari. Selain itu, ia juga sangat menyukai ikan. Dengan semangatnya yang luar biasa, ia bercita-cita untuk membahagiakan para fans bersama JKT48.'),
(3, 'Adeline Wijaya', '2007-09-01', 'public/images/member/uploads/kabesha_69f9482d58645.jpg', 'public/images/member/uploads/casual_69f9482d58cba.jpg', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(4, 'Afera Thalia', '2012-10-20', 'public/images/member/uploads/kabesha_69fdf0576b5f2.jpg', '', 'Gen 14', 'Bogor', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(5, 'Alya Amanda', '2006-08-26', 'public/images/member/uploads/kabesha_69f94844e9906.jpg', 'public/images/member/uploads/casual_69f94844e9f25.jpg', 'Gen 11', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(6, 'Anindya Ramadhani', '2005-10-18', 'public/images/member/uploads/kabesha_69f948547f93c.jpg', 'public/images/member/uploads/casual_69f948547fde3.jpg', 'Gen 11', 'Depok', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(8, 'Abigail Rachel Lie', '2008-08-06', 'public/images/member/uploads/kabesha_69f945307c2b7.jpg', 'public/images/member/uploads/casual_69fdf1c79c893.jpg', 'Gen 12', 'Jakarta', 'Seperti bunga yang mekar, aku akan membuat kamu, kamu dan kamu terbayang bayang. Aku Ara-Aralie! Mohon dukungannya semua! Begitulah salam perkenalan dari Aralie, member JKT48 dari generasi 12. Gadis yang berasal dari Jakarta ini dikenal memiliki kepribadian yang kalem. Di luar aktivitasnya sebagai idol, Aralie memiliki hobi yang cukup menarik, yaitu memasak. Selain itu, ia juga sangat menyukai Buah strawberry. Dengan semangatnya yang luar biasa, ia bercita-cita untuk bisa membahagiakan para fans bersama JKT48.'),
(9, 'Astrella Virgiananda', '2010-08-06', 'public/images/member/uploads/kabesha_69f95ef2a8576.jpg', 'public/images/member/uploads/casual_69f95ef2a9281.jpg', 'Gen 13', 'Bandung', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(10, 'Aulia Riza', '2007-07-14', 'public/images/member/uploads/kabesha_69f95f4916e44.jpg', 'public/images/member/uploads/casual_69f95f491758a.jpg', 'Gen 13', 'Surabaya', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(11, 'Aurellia', '2002-10-29', 'public/images/member/uploads/kabesha_69f960190032e.jpg', 'public/images/member/uploads/casual_69f96019009af.jpg', 'Gen 10', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(12, 'Aurhel Alana', '2006-09-14', 'public/images/member/uploads/kabesha_69fae1b0a5ea5.jpg', 'public/images/member/uploads/casual_69fae1b0a64e2.jpg', 'Gen 12', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(13, 'Cathleen Nixie', '2009-05-28', 'public/images/member/uploads/kabesha_69fae23809925.jpg', '', 'Gen 11', 'Surabaya', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(14, 'Celline Thefani', '2007-04-09', 'public/images/member/uploads/kabesha_69fae2aeed9e5.jpg', '', 'Gen 11', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(15, 'Cynthia Yaputera', '2003-11-22', 'public/images/member/uploads/kabesha_69fae31c163bd.jpg', '', 'Gen 11', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(16, 'Fiony Alveria', '2002-02-04', 'public/images/member/uploads/kabesha_69fae36914c94.jpg', '', 'Gen 8', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(17, 'Fritzy Rosmerian', '2008-07-28', 'public/images/member/uploads/kabesha_69fae3ae15ecf.jpg', '', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(18, 'Grace Octaviani', '2007-10-18', 'public/images/member/uploads/kabesha_69fae3fcdaa81.jpg', '', 'Gen 11', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(19, 'Hillary Abigail', '2007-10-19', 'public/images/member/uploads/kabesha_69fae43d93ff8.jpg', '', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(20, 'Indah Cahya', '2001-03-20', 'public/images/member/uploads/kabesha_69fae4b0795fc.jpg', '', 'Gen 9', 'Jambi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(21, 'Jazzlyn Trisha', '2011-02-16', 'public/images/member/uploads/kabesha_69fae4e2f0c55.jpg', '', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(22, 'Michelle Alexandra', '2009-04-22', 'public/images/member/uploads/kabesha_69fae517c1591.jpg', '', 'Gen 11', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(23, 'Nayla Suji', '2007-06-18', 'public/images/member/uploads/kabesha_69fae5515ce21.jpg', '', 'Gen 12', 'Kumamoto', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(24, 'Chelsea Davina', '2009-12-23', 'public/images/member/uploads/kabesha_69fae5df66833.jpg', '', 'Gen 11', 'Sydney', '[Jiko Lengkap Member]. Begitulah salam perkenalan dari [Nama Panggilan], member JKT48 dari generasi [Generasi]. Gadis yang berasal dari [Asal Kota] ini dikenal memiliki kepribadian yang [Sifat, misal: ceria/kalem]. Di luar aktivitasnya sebagai idol, [Nama Panggilan] memiliki hobi yang cukup menarik, yaitu [Hobi 1] dan [Hobi 2]. Selain itu, ia juga sangat menyukai [Makanan/Hal Favorit]. Dengan semangatnya yang luar biasa, ia bercita-cita untuk [Harapan/Quotes Member] bersama JKT48.'),
(25, 'Febriola Sinambela', '2005-04-26', 'public/images/member/uploads/kabesha_69fae630f35fa.jpg', '', 'Gen 7', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(26, 'Freya Jayawardana', '2006-02-13', 'public/images/member/uploads/kabesha_69fae66149fe7.jpg', '', 'Gen 7', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(27, 'Gabriela Abigail', '2006-08-07', 'public/images/member/uploads/kabesha_69fae6e4afdb6.jpg', '', 'Gen 10', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(28, 'Gita Sekar Andarini', '2001-06-30', 'public/images/member/uploads/kabesha_69fae73c2e773.jpg', '', 'Gen 6', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(29, 'Greesella Adhalia', '2006-01-10', 'public/images/member/uploads/kabesha_69faeb1f93e2d.jpg', '', 'Gen 11', 'Bogor', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(30, 'Helisma Putri', '2000-06-15', 'public/images/member/uploads/kabesha_69faeb5832ea5.jpg', '', 'Gen 7', 'Bandung', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(31, 'Jesslyn Elly', '2001-09-13', 'public/images/member/uploads/kabesha_69faeb85392c6.jpg', '', 'Gen 10', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(32, 'Marsha Lenathea', '2006-01-09', 'public/images/member/uploads/kabesha_69faebbba9988.jpg', '', 'Gen 9', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(33, 'Nina Tutachia', '2009-10-16', 'public/images/member/uploads/kabesha_69faebee82607.jpg', '', 'Gen 12', 'Denpasar', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(34, 'Oline Manuel', '2007-11-03', 'public/images/member/uploads/kabesha_69faec2507b0f.jpg', '', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(35, 'Shabilqis Naila', '2008-09-01', 'public/images/member/uploads/kabesha_69faec70aec7d.jpg', '', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(36, 'Catherina Vallencia', '2007-08-21', 'public/images/member/uploads/kabesha_69faecd9b5074.jpg', '', 'Gen 12', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(37, 'Cornelia Vanisa', '2002-07-26', 'public/images/member/uploads/kabesha_69faed1449d5b.jpg', '', 'Gen 8', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(38, 'Dena Natalia', '2005-12-16', 'public/images/member/uploads/kabesha_69faed4c23996.jpg', '', 'Gen 11', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(39, 'Desy Natalia', '2005-12-16', 'public/images/member/uploads/kabesha_69faed6cc4ce9.jpg', '', 'Gen 11', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(40, 'Jessica Chandra', '2005-09-23', 'public/images/member/uploads/kabesha_69faedb1b654f.jpg', '', 'Gen 7', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(41, 'Kathrina Irene', '2006-07-06', 'public/images/member/uploads/kabesha_69faee07e95d1.jpg', '', 'Gen 9', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(42, 'Lulu Salsabila', '2002-10-23', 'public/images/member/uploads/kabesha_69faee5973188.jpg', '', 'Gen 8', 'Serang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(43, 'Michelle Levia', '2009-01-24', 'public/images/member/uploads/kabesha_69faeeac75a55.jpg', '', 'Gen 12', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(44, 'Mutiara Azzahra', '2004-07-12', 'public/images/member/uploads/kabesha_69faeee1b5787.jpg', '', 'Gen 7', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(45, 'Raisha Syifa', '2007-11-11', 'public/images/member/uploads/kabesha_69faef1e51b0d.jpg', '', 'Gen 10', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(46, 'Ribka Budiman', '2009-01-13', 'public/images/member/uploads/kabesha_69faef4fa9d69.jpg', '', 'Gen 12', 'Bandung', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(47, 'Victoria Kimberly', '2009-03-08', 'public/images/member/uploads/kabesha_69faef7ee92a9.jpg', '', 'Gen 12', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(48, 'Isha Kirana', '2007-11-25', 'public/images/member/uploads/kabesha_69faf5e6654da.png', '', 'Gen 2 JKT48V', 'Dunia Virtual', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(49, 'Maura Nilambari', '2007-07-21', 'public/images/member/uploads/kabesha_69fdf0f4df8b0.png', '', 'Gen 2 JKT48V', 'Dunia Virtual', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(50, 'Pia Meraleo', '2006-07-30', 'public/images/member/uploads/kabesha_69fdf13883404.jpg', '', 'Gen 1 JKT48V', 'Dunia Virtual', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(51, 'Sami Maono', '2009-10-07', 'public/images/member/uploads/kabesha_69fdf17d9da67.png', '', 'Gen 2 JKT48V', 'Dunia Virtual', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(52, 'Tana Nona', '2005-04-22', 'public/images/member/uploads/kabesha_69fdf1733f357.jpg', '', 'Gen 1 JKT48V', 'Dunia Virtual', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(53, 'Bong Aprilli', '2010-04-01', 'public/images/member/uploads/kabesha_69fdf06bbc6e7.jpg', '', 'Gen 13', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(54, 'Hagia Sopia', '2008-07-01', 'public/images/member/uploads/kabesha_69fdf04617280.jpg', '', 'Gen 13', 'Bekasi', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(55, 'Carissa Dini', '2012-02-02', 'public/images/member/uploads/kabesha_69fdf0781be2b.jpg', '', 'Gen 14', 'Bandung', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(56, 'Christabella Bonita', '2011-03-02', 'public/images/member/uploads/kabesha_69fdf08766f73.jpg', '', 'Gen 14', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(57, 'Fahira Putri', '2012-08-13', 'public/images/member/uploads/kabesha_69fdf093639b6.jpg', '', 'Gen 14', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(58, 'Fatimah Azzahra', '2010-08-30', 'public/images/member/uploads/kabesha_69fdf0a1832f2.jpg', '', 'Gen 14', 'Depok', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(59, 'Heidi Suyangga', '2008-08-27', 'public/images/member/uploads/kabesha_69fdf0b10f40d.jpg', '', 'Gen 14', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(60, 'Humaira Ramadhani', '2011-08-13', 'public/images/member/uploads/kabesha_69fdf0be99aea.jpg', '', 'Gen 13', 'Tangerang', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(61, 'Jacqueline Immanuel', '2009-07-09', 'public/images/member/uploads/kabesha_69fdf0ce5fa35.jpg', '', 'Gen 13', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(62, 'Jemima Evodie', '2009-11-09', 'public/images/member/uploads/kabesha_69fdf0dcc8b74.jpg', '', 'Gen 13', 'Mataram', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(63, 'Maxine Faye', '2011-12-02', 'public/images/member/uploads/kabesha_69fdf1069290f.jpg', '', 'Gen 14', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(64, 'Mikaela Kusjanto', '2007-12-15', 'public/images/member/uploads/kabesha_69fdf1155081c.jpg', '', 'Gen 13', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(65, 'Nur Intan', '2006-02-24', 'public/images/member/uploads/kabesha_69fdf12483a86.jpg', '', 'Gen 13', 'Bogor', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(66, 'Putry Jazyta', '2011-03-12', 'public/images/member/uploads/kabesha_69fdf14c42596.jpg', '', 'Gen 14', 'Bogor', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(67, 'Ralyne Van Irwa', '2011-10-15', 'public/images/member/uploads/kabesha_69fdf158055c8.jpg', '', 'Gen 14', 'Medan', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨'),
(68, 'Sona Kalyana', '2011-12-01', 'public/images/member/uploads/kabesha_69fdf164343fd.jpg', '', 'Gen 14', 'Jakarta', 'Yuk, kenalan lebih dekat dengan member JKT48 yang satu ini! Profil lengkap dan keseruan seputar aktivitasnya sedang dalam proses peracikan oleh admin. Punya informasi menarik atau fakta unik tentang member ini yang belum tertulis di sini? Yuk, bantu admin melengkapinya lewat menu Kotak Saran! Mari kita bangun fansite ini bersama-sama! 🫰✨');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id_post` INT(11) NOT NULL,
  `judul` VARCHAR(200) NOT NULL,
  `isi` TEXT NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `tanggal_terbit` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `id_user` INT(11) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id_post`, `judul`, `isi`, `foto`, `tanggal_terbit`, `id_user`) VALUES
(1, 'Gracia Umumkan Lulus Dari JKT48', 'Gracia umumkan lulus dari JKT48 setelah impiannya di JKT48 tercapai. Gracia mengumumkan kelulusan dari JKT48 melalui konser \"FULL HOUSE\" pada tanggal 26 Juli 2025. Pengumuman mengejutkan di akhir acara ini mengundang banyak air mata dari para penggemar yang telah menemani perjalanan Gracia selama aktif di JKT48. Sebagai member JKT48, Gracia mengungkapkan bahwa dirinya memiliki banyak mimpi, cita-cita, dan tujuan yang ingin diraih, tetapi sebagai seorang kapten, Gracia juga sadar bahwa dirinya memikul tanggung jawab yang besar, termasuk setlist orginal. Setlist original adalah mimpi yang telah Gracia jaga selama ini untuk dirinya sendiri, penggemar, dan untuk JKT48 itu sendiri. Setlist original bertajuk Pertaruhan Cinta menjadi salah satu alasan Gracia bertahan sejauh ini di JKT48 dan akan menjadi persembahan terakhir Gracia sebagai member JKT48. Ketika dirinya sudah resmi lulus, Gracia ingin penggemar ingat bahwa dirinya juga pernah bagian dari setlist original tersebut...', 'public/images/post/post_69f998389f7d2.jpeg', '2026-05-04 08:53:52', 2),
(2, 'Pengumuman Mengenai JKT48 OFC Event “ARISAN 48”', 'JKT48 OFC Event akan segera hadir untuk menambah keseruan di bulan Mei bersama member Team Love, Dream dan Passion, dalam acara “ARISAN 48” yang akan mengajak kalian untuk beristirahat sejenak dari kesibukan—melepas penat dengan berkumpul dan berinteraksi sembari bermain berbagai permainan seru dan mencoba pengalaman baru: DIY (Do It Yourself) minuman ala kafe favorit kalian! \r\n\r\nPada kegiatan ini, kalian dan para member JKT48 juga akan mendapatkan “Beverage Workshop by +62 Coffee” untuk menambah referensi kalian dalam membuat minuman. Kalian dapat memilih minuman yang ingin kalian buat sesuai dengan preferensi, di antaranya: Coffee/Matcha/Sparkling (Soda) dengan mendaftar sesuai dengan nama pilihan minuman yang tersedia. \r\n\r\nSelain itu, acara ini akan ditutup dengan berbagai keseruan melalui undian berhadiah dan kejutan lainnya di akhir acara, jadi jangan lewatkan keseruannya ya! Tidak perlu mengeluarkan budget ngopi tambahan, karena kami sudah menyediakan makanan berat dan minuman tambahan untuk dinikmati di akhir acara.', 'public/images/post/post_69fa9a66749f8.png', '2026-05-06 01:33:26', 2),
(3, 'Pengumuman Mengenai Pre-Order JKT48 Digital Photobook “We Are Love, Dream Team, Passion On Fire!” dengan bonus Video Call with JKT48', 'Siap-siap terpesona! Digital Photobook “We Are Love, Dream Team, Passion On Fire!” hadir membawakan potret natural member JKT48 yang belum pernah kamu lihat sebelumnya. Mulai dari senyuman hangat penuh cinta, ambisi yang terpancar dari tatapan mata, sampai semangat membara yang bikin kita ikut berenergi.\r\n\r\nNggak cuma visual yang cantik, setiap pembelian seharga IDR 120.000 sudah termasuk tiket bonus Video Call with JKT48 buat ngobrol berdua langsung sama oshi kamu!\r\n\r\nOFC Pre-Order: 6 Mei 2026, 22.00 WIB\r\n\r\nGeneral Pre-Order: 7 Mei 2026, 22.00 WIB\r\n\r\nRilis: 16 Mei 2026 (via jkt48.com)\r\n\r\nCek detail selengkapnya di web resmi jkt48.com dan siapkan dirimu buat bonding bareng oshi! ❤️', 'public/images/post/post_69fa9b9f0a40b.png', '2026-05-06 01:38:39', 2),
(4, 'Inspirasi di Luar Panggung: Fiony Alveria Resmi Raih Gelar Sarjana Desain! 🎓', 'Kabar membanggakan datang dari salah satu member JKT48! Pada 7 Mei 2026, Fiony Alveria resmi menyandang gelar Sarjana Desain (S.Ds) — sebuah pencapaian yang nggak main-main, mengingat perjalanan kuliahnya dijalani bersamaan dengan padatnya jadwal sebagai member aktif JKT48.\r\nBukan rahasia lagi kalau kehidupan seorang member JKT48 itu padat. Latihan, pertunjukan, dan berbagai kegiatan grup sudah mengisi hari-hari Fiony selama bertahun-tahun. Namun di tengah semua itu, ia tetap konsisten menyelesaikan studinya di bidang Desain hingga tuntas.\r\nGelar S.Ds ini menjadi bukti bahwa karier dan pendidikan bisa berjalan beriringan — meski tentu bukan tanpa perjuangan. Selamat, Fiony Alveria, S.Ds.! Pencapaian ini patut dirayakan. 🎉', 'public/images/post/post_69fc77a6d3f4f.jpg', '2026-05-07 08:18:33', 2),
(5, 'Kabar Membanggakan! Chelsea Davina Sikat 4 Medali di Kompetisi Renang Terbaru! 🥇🏊‍♀️', 'Wah, kabar gembira datang dari salah satu member JKT48 kesayangan kita, Chelsea Davina! Gadis yang dikenal ceria ini baru saja menorehkan prestasi gemilang di bidang olahraga. Tak tanggung-tanggung, Chelsea berhasil membawa pulang empat medali dari ajang kompetisi renang!\r\n\r\nPencapaian luar biasa ini patut diacungi jempol, apalagi kalau kita ingat jadwal latihan dan kegiatan Chelsea sebagai member JKT48 yang super padat. Dari sesi latihan menari yang intens, penampilan di teater, hingga berbagai kegiatan grup lainnya, Chelsea tetap bisa menyisihkan waktu untuk mengasah kemampuannya di kolam renang. Dedikasinya benar-benar inspiratif!\r\n\r\nMedali-medali yang diraih Chelsea, termasuk dua medali emas yang membanggakan, menjadi bukti nyata dari hasil kerja keras dan semangat pantang menyerah. Ini bukan sekadar tentang medali, tapi juga tentang bagaimana Chelsea bisa membagi fokus dan meraih kesuksesan di luar panggung JKT48.\r\n\r\nKita semua tahu betapa sibuknya kehidupan seorang idol. Tapi Chelsea berhasil membuktikan bahwa dengan tekad yang kuat dan manajemen waktu yang baik, passion lain di luar dunia hiburan juga bisa dijalani dengan gemilang. Ini adalah bukti kalau bakat dan minat Chelsea nggak cuma terbatas di atas panggung.\r\n\r\nKemenangan ini tentu menjadi kado manis bagi Chelsea dan juga bagi kita para penggemarnya. Kita semua bangga melihat Chelsea terus tumbuh dan bersinar, baik di JKT48 maupun di jalur prestasi lainnya.\r\n\r\nSemangat terus, Chelsea Davina! Semoga prestasi ini menjadi awal dari pencapaian-pencapaian hebat lainnya di masa depan. Kita akan selalu ada di sini untuk mendukungmu!', 'public/images/post/post_6a008b1bb0d07.jpg', '2026-05-10 13:41:48', 2),
(6, 'Isu Keamanan Mendesak: Erine JKT48 Terima Ancaman Kekerasan Fisik Serius Jelang MnG, Fanbase Desak Tindakan Nyata Manajemen', 'Dunia fandom JKT48 tengah digemparkan oleh isu keamanan serius yang menimpa salah satu member, Erine. Jagat media sosial dihebohkan dengan beredarnya tangkapan layar dari sebuah akun yang secara terang-terangan melayangkan ancaman kekerasan fisik berupa penyiraman cairan berbahaya kepada Erine. Aksi keji tersebut direncanakan akan dilakukan pada acara Personal Meet and Greet Festival: LOVE DREAM PASSION yang dijadwalkan berlangsung Sabtu ini. <br> <br>\r\n\r\nBerdasarkan informasi yang dihimpun, motif di balik ancaman ini diduga merupakan bentuk balas dendam pribadi dari rekan seorang oknum masa lalu. Pelaku dilaporkan telah melakukan tindakan penguntitan (stalking) mendalam terhadap kehidupan pribadi Erine, termasuk melacak lokasi rumah, hingga jadwal dan kegiatan perkuliahan korban di kampus. <br> <br>\r\n\r\nMenanggapi situasi yang kian memanas di ruang publik, fanbase resmi dari Erine, Cavallery, akhirnya merilis pernyataan sikap terbuka. Dalam surat resminya, Cavallery menyatakan bahwa mereka sebenarnya telah mengendus pergerakan mencurigakan ini dan mengumpulkan bukti-bukti sejak tanggal 7 Mei lalu. Bukti-bukti tersebut diklaim telah diteruskan kepada pihak manajemen JKT48 sebagai langkah pencegahan awal. <br> <br>\r\n\r\n\"Bagi kami, pembahasan yang sudah menyentuh ancaman fisik, lingkungan kampus, aktivitas pribadi, hingga keluarga bukan lagi sesuatu yang dapat dianggap sebagai candaan ataupun dinamika fandom biasa. Situasi seperti ini seharusnya tidak perlu menunggu perhatian publik terlebih dahulu untuk dapat ditanggapi secara serius,\" tulis pernyataan resmi Cavallery. <br> <br>\r\n\r\nAwalnya, pihak fanbase memilih jalur tertutup demi menjaga kondusivitas dan kenyamanan member. Namun, melihat eskalasi ancaman yang semakin nyata dan membahayakan, mereka memilih bersikap terbuka demi mendorong pengamanan yang jauh lebih ketat. Cavallery menegaskan bahwa hak member untuk mendapatkan ruang aman dan perlindungan dari segala bentuk intimidasi di luar aktivitas idola harus menjadi prioritas utama yang konsisten di balik panggung. <br> <br>\r\n\r\nHingga berita ini diturunkan, para penggemar di media sosial terus menyuarakan tagar dukungan dan mendesak JKT48 Operation Team (JOT) untuk memperketat sistem pengamanan, serta membawa kasus penguntitan dan ancaman pembunuhan/pencederaan ini ke ranah hukum demi keselamatan Erine. <br> <br>\r\n\r\n<b>#PeduliLindungiErine #SamaSamaJagaErine</b>', 'public/images/post/post_6a0ebdbeaaed1.webp', '2026-05-20 06:25:30', 5),
(7, 'JOT Gandeng Pihak Berwajib dan Perketat Keamanan MnG Menyusul Ancaman Kekerasan Terhadap Erine', 'JKT48 Operation Team (JOT) resmi mengambil tindakan tegas guna merespons ancaman kekerasan fisik serius yang diarahkan kepada salah satu membernya, Erine. Melalui pengumuman resmi yang dirilis pada Rabu (20/5), pihak manajemen menyatakan telah bergerak bersama aparat penegak hukum demi menjamin keselamatan di area event. <br> <br>\r\n\r\n\"Menanggapi informasi terkait ancaman yang ditujukan kepada salah satu member kami, kami telah berkoordinasi dengan pihak berwajib untuk dapat segera menindaklanjuti informasi tersebut dan juga akan mengambil langkah antisipasi untuk event JKT48 Personal Meet and Greet Festival: LOVE DREAM PASSION mendatang,\" tulis pernyataan resmi JOT. <br> <br>\r\n\r\nLangkah responsif ini diambil setelah komunitas penggemar, termasuk fanbase resmi Cavallery dan sejumlah tokoh vokal di media sosial, gencar menyuarakan kekhawatiran mereka. Sebelumnya, publik sempat diresahkan oleh klaim motif pelaku yang belakangan terbukti fiktif berdasarkan investigasi mandiri fans, serta analisis hukum pidana berat yang melibatkan pelanggaran pasal KUHP baru terkait pengancaman penganiayaan. <br> <br>\r\n\r\nGuna menutup seluruh celah potensi bahaya di lokasi acara yang bertempat di Hall 9 dan 10, JOT menerapkan protokol pemeriksaan (screening) yang jauh lebih ketat dari biasanya. Salah satu poin regulasi baru yang paling disorot adalah larangan total terhadap segala jenis cairan. Pengunjung sama sekali tidak diperkenankan membawa makanan/minuman dari luar, serta cairan dalam wadah apapun seperti parfum, spray, aerosol, wadah vape, hingga hand sanitizer. <br> <br>\r\n\r\nSelain pembatasan barang bawaan, pihak penyelenggara juga dipastikan menambah personel keamanan untuk melakukan prosedur body check manual secara berkala. Pemeriksaan berlapis ini akan ditempatkan langsung di setiap jalur antrean sesaat sebelum fans memasuki bilik interaksi Personal Meet and Greet maupun sesi 2-Shot. <br> <br>\r\n\r\nManajemen menegaskan bahwa pengunjung yang melanggar ketentuan atau terindikasi mengancam keamanan bersama akan langsung diberikan tindakan hukum di tempat dan dilarang mengikuti seluruh rangkaian acara. Komunitas penggemar menyambut positif regulasi ketat ini dan berkomitmen untuk saling menjaga situasi kondusif demi keselamatan seluruh member JKT48. <br> <br>\r\n\r\nRegulasi pelarangan cairan ini benar-benar langkah preventif yang paling masuk akal buat mengunci pergerakan pelaku di lokasi besok Sabtu. Setidaknya sekarang fans bisa sedikit bernapas lega karena JOT terbukti nggak tinggal diam.', 'public/images/post/post_6a0ebd68cd0c0.webp', '2026-05-21 08:08:09', 5),
(8, 'Berakhir Damai, Protokol Keamanan Ketat JOT Sukses Amankan Event MnG JKT48 dari Ancaman Kriminal', 'Ketakutan massal yang sempat menyelimuti komunitas penggemar JKT48 akhirnya berbuah lega. Gelaran Personal Meet and Greet Festival: LOVE DREAM PASSION yang berlangsung pada Sabtu (23/5) kemarin terbukti berjalan dengan sangat aman, kondusif, dan penuh tawa, sekaligus mematahkan segala gertakan ancaman kekerasan yang sempat viral di media sosial siber belakangan ini.\r\n\r\nKondisi nihil insiden ini tidak lepas dari kesigapan JKT48 Operation Team (JOT) yang menerapkan sistem pertahanan berlapis di Hall 9 dan 10. Berdasarkan pengamatan dan kesaksian para fans di lapangan, regulasi pembersihan area dari segala bentuk cairan dan pemeriksaan tubuh (body check) manual benar-benar dieksekusi secara ketat oleh petugas keamanan sebelum fans diperbolehkan memasuki bilik interaksi.\r\n\r\nPenjagaan super ekstra juga terlihat jelas di bilik (booth) milik Erine, member yang sebelumnya menjadi target utama penguntitan dan pengancaman fisik. Fans bersaksi bahwa manajemen menempatkan hingga tiga staf pengawal sekaligus di bilik tersebut untuk memastikan ruang gerak yang aman bagi sang idola. Langkah taktis ini terbukti ampuh membuat oknum pelaku yang sempat berkoar-koar di platform X kehilangan tajinya dan gagal total melancarkan aksi nekatnya.\r\n\r\nAtmosfer di dalam venue justru dipenuhi oleh kegembiraan. Alih-alih mencekam, seluruh member JKT48 tampil interaktif, ceria, dan sangat menikmati momen tatap muka serta sesi 2-Shot bersama para penggemar setianya. Senyum yang sempat dikhawatirkan pudar oleh desakan kecemasan publik, nyatanya tetap terjaga utuh hingga akhir acara.\r\n\r\nKeberhasilan event yang berakhir dengan happy ending ini menjadi standar baru bagi manajemen dalam hal mitigasi krisis dan penanganan keamanan berskala besar. Komunitas fans memberikan apresiasi tinggi kepada langkah cepat JOT dan kerja sama solid sesama penggemar yang membuktikan bahwa ruang aman bagi para idola untuk mengejar mimpi akan selalu menjadi prioritas utama di atas segalanya.', 'public/images/post/post_6a127565a2f6d.png', '2026-05-24 03:49:58', 5),
(9, 'Gebrakan: JKT48 Resmi Umumkan Tur Teater Sementara Serta MnG di Surabaya dan Yogyakarta! 🚄✨', 'Di balik ketatnya pengamanan dan suksesnya gelaran Personal Meet and Greet Festival: LOVE DREAM PASSION akhir pekan lalu, JKT48 Operation Team (JOT) menyimpan kejutan besar di penghujung acara. Kejutan yang berhasil memicu gemuruh sorak-sorai para penggemar ini adalah pengumuman resmi kembalinya proyek Teater Sementara JKT48 di dua kota besar, yaitu Surabaya dan Yogyakarta.\r\n\r\nLangkah ini menjadi angin segar sekaligus pengobat rindu bagi para fans di luar Jakarta yang sudah mendambakan atmosfer magis pertunjukan teater reguler. Tidak tanggung-tanggung, JOT mengonfirmasi bahwa rangkaian tur luar kota ini juga akan dibersamai dengan rangkaian event interaktif yang sangat dinantikan: Personal Meet & Greet serta sesi 2-Shot! <br> <br>\r\n\r\nBagi komunitas fans di Surabaya, pengumuman ini memicu ruang nostalgia yang mendalam. Pasalnya, ini merupakan kali kedua proyek teater sementara menyambangi Kota Pahlawan setelah kesuksesan serupa pada tahun 2024 silam—momen ikonik yang kala itu menjadi kali pertama bagi banyak fans lokal untuk bisa mengabadikan foto 2-shot eksklusif bersama member idola mereka secara langsung tanpa harus terbang ke Ibu Kota. <br> <br>\r\n\r\nEkspansi event ke Surabaya dan Yogyakarta ini diprediksi akan menyedot antusiasme luar biasa dari para pengabdi teater regional. Dengan manajemen pengamanan yang terbukti semakin solid dan ketat, tur luar kota kali ini diharapkan mampu membawa energi baru yang positif, aman, dan tak terlupakan bagi para member maupun seluruh penggemar daerah.\r\n\r\nArek-arek Suroboyo dan Cah Jogja, siap-siap buat war tiket lagi!', 'public/images/post/post_6a145b95059b0.png', '2026-05-25 13:46:59', 5),
(10, 'Satu Lagi Lulusan Hebat: Febriola Sinambela Resmi Selesaikan Bangku Kuliah! 🎓', 'Kabar bahagia dan membanggakan kembali datang dari salah satu member JKT48! Febriola Sinambela, atau yang akrab kita sapa Olla, baru saja resmi menyelesaikan masa studinya di bangku perkuliahan. Sebuah pencapaian luar biasa yang patut diacungi jempol, mengingat bagaimana ia harus membagi fokusnya setiap hari.\r\n\r\nBukan hal yang mudah untuk menjalani peran ganda. Di satu sisi, kita tahu betapa padatnya jadwal seorang member JKT48—mulai dari latihan koreografi yang menguras fisik, pertunjukan teater reguler, hingga berbagai kegiatan off-air dan on-air. Namun di sisi lain, Olla membuktikan komitmennya yang kuat terhadap pendidikan dengan tetap menyelesaikan tanggung jawab akademisnya hingga tuntas.\r\n\r\nSenyum sumringah Olla dengan toga dan selempang merah jambunya menjadi bukti nyata bahwa kerja keras tidak pernah mengkhianati hasil. Momen kelulusan ini seolah menegaskan bahwa di balik karakternya yang selalu ceria dan menghibur di atas panggung, Olla adalah sosok pekerja keras yang penuh dedikasi di balik layar.\r\n\r\nDengan selesainya babak perkuliahan ini, langkah baru pun sudah menanti. Seperti kata pepatah, satu gerbang tertutup, gerbang karier yang lebih luas kini terbuka lebar—kini status full-time idol siap dijalani dengan fokus dan energi yang baru!\r\n\r\nSelamat atas kelulusannya, Febriola Sinambela! Semoga ilmu yang didapatkan bisa bermanfaat dan menjadi bekal untuk langkah-langkah hebat berikutnya. Kami semua bangga padamu!', 'public/images/post/post_6a1e7b39006e8.webp', '2026-06-02 06:42:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE `saran` (
  `id_saran` INT(11) NOT NULL,
  `nama` VARCHAR(200) NOT NULL,
  `pesan` TEXT NOT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`id_saran`, `nama`, `pesan`, `dibuat_pada`) VALUES
(1, 'izaa', 'sudah bagus banget, aku suka', '2026-05-06 11:53:55'),
(2, 'negro', 'keren jirr', '2026-05-08 15:55:00'),
(3, 'NahyeR', 'mam itu sg ada vidio di awal ancen gaiso di play ta\r\nsg flying high iku pokok e', '2026-05-08 16:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` INT(11) NOT NULL,
  `nama` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `password_pengguna` VARCHAR(200) NOT NULL,
  `ROLE` ENUM('admin','user') NOT NULL,
  `oshimen` INT(11) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password_pengguna`, `ROLE`, `oshimen`) VALUES
(1, 'Reza Habibie', 'jabieb@gmail.com', '$2y$10$FnPG/v58Gsv84MdQmVKkme3QMfi0tKRBHoU1jM2OPpLFc41IXetgi', 'user', NULL),
(2, 'aokuri', 'aokuri@gmail.com', '$2y$10$iGo5RJ2lk7T/mSGesuwiO.xY89wkVXEUFcfwhY7ph/hdSoG9xPMpS', 'admin', 8),
(3, 'Teddy', 'teddy@gmail.com', '$2y$10$uNBy9G09Iv4r.kixhZ0oRetQdaNRoqgzeaVcWqZGNa0763B1GB7VO', 'user', NULL),
(4, 'izaa', 'izaa@gmail.com', '$2y$10$C1byML/Rmsoh86w7AWJiN.GiHHnd6cq.k0tP9RxfFs3RArvl5YHfS', 'user', 8),
(5, 'maeng', 'maeng@gmail.com', '$2y$10$oZrNYyTcidW3BM2pOuKN3.oqwa2MH3mggjp4cmMqz46mphAJ/Xb/C', 'admin', 8),
(6, 'poldol', 'poldol@gmail.com', '$2y$10$ZPrXPVgHdWBp180UJ15H9utmsfwYghJr2sOkZH06rxDP7TVJKV832', 'user', 4),
(7, 'blough', 'mbut@gmail.com', '$2y$10$q23alQsmpjrhsnBS9a.DtOSDUuCygm/cwMN0jVER.ZWnF.qze7PdW', 'user', NULL),
(8, '&#039; UNION SELECT username, password FROM users --', 'blough@gmail.com', '$2y$10$VryJmFvCyuMFQfYk9j8scea4UPo6QeiK6tRp3l/ITWP6AgGGfQZFm', 'user', NULL),
(11, 'bloughh', 'bloughs@gmail.com', '$2y$10$/JwlX4ZdkDCJYE5VEyLnM.UiDfxIRIVIRKZ/CbVwOqnQpWdhIt3DC', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `galeri_event`
--
ALTER TABLE `galeri_event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `galeri_foto`
--
ALTER TABLE `galeri_foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_event` (`id_event`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `galeri_komentar`
--
ALTER TABLE `galeri_komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_foto` (`id_foto`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `saran`
--
ALTER TABLE `saran`
  ADD PRIMARY KEY (`id_saran`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `oshimen` (`oshimen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `galeri_event`
--
ALTER TABLE `galeri_event`
  MODIFY `id_event` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galeri_foto`
--
ALTER TABLE `galeri_foto`
  MODIFY `id_foto` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galeri_komentar`
--
ALTER TABLE `galeri_komentar`
  MODIFY `id_komentar` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `saran`
--
ALTER TABLE `saran`
  MODIFY `id_saran` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galeri_foto`
--
ALTER TABLE `galeri_foto`
  ADD CONSTRAINT `galeri_foto_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `galeri_event` (`id_event`) ON DELETE CASCADE,
  ADD CONSTRAINT `galeri_foto_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE,
  ADD CONSTRAINT `galeri_foto_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `galeri_komentar`
--
ALTER TABLE `galeri_komentar`
  ADD CONSTRAINT `galeri_komentar_ibfk_1` FOREIGN KEY (`id_foto`) REFERENCES `galeri_foto` (`id_foto`) ON DELETE CASCADE,
  ADD CONSTRAINT `galeri_komentar_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`oshimen`) REFERENCES `member` (`id_member`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
