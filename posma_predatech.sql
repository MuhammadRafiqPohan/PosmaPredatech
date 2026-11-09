-- Database: posma_predatech
-- SISTEM INFORMASI REPOSITORY DAN MANAJEMEN ALUMNI (POSMA) PREDATECH

CREATE DATABASE IF NOT EXISTS `posma_predatech` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `posma_predatech`;

-- 1. Tabel User
DROP TABLE IF EXISTS `karya`;
DROP TABLE IF EXISTS `anggota`;
DROP TABLE IF EXISTS `kategori`;
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_user` VARCHAR(50) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `level` ENUM('Admin', 'Operator', 'Anggota') NOT NULL DEFAULT 'Anggota',
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel Kategori
CREATE TABLE `kategori` (
  `id_kategori` INT(11) NOT NULL AUTO_INCREMENT,
  `kategori` VARCHAR(50) NOT NULL,
  `icon_karya` VARCHAR(100) NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Data Anggota
CREATE TABLE `anggota` (
  `id_anggota` BIGINT(20) NOT NULL, -- NIM UIN
  `id_user` INT(11) NULL,
  `nama_anggota` VARCHAR(100) NOT NULL,
  `nomor_anggota` VARCHAR(25) NOT NULL,
  `grup_puzzle` INT(11) NULL DEFAULT 1,
  `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL DEFAULT 'Laki-laki',
  `program_studi` VARCHAR(25) NOT NULL DEFAULT 'TIF', -- TIF, TIN, SIF, MAT, TEL
  `angkatan` VARCHAR(4) NOT NULL DEFAULT '2017',
  `tahun_masuk_predatech` VARCHAR(4) NOT NULL DEFAULT '2018',
  `email_aktif` VARCHAR(100) NOT NULL,
  `no_hp` VARCHAR(20) NOT NULL,
  `kota_domisili` VARCHAR(50) NOT NULL,
  `alamat_domisili` TEXT NULL,
  `link_linkedin` TEXT NULL,
  `link_scopus` TEXT NULL,
  `link_scholar` TEXT NULL,
  `link_instagram` VARCHAR(100) NULL,
  `status_keanggotaan` ENUM('Dosen', 'Alumni', 'Mahasiswa') NOT NULL DEFAULT 'Mahasiswa',
  `status_perkawinan` ENUM('Kawin', 'Belum Kawin') NOT NULL DEFAULT 'Belum Kawin',
  `bidang_riset` VARCHAR(100) NOT NULL DEFAULT 'Data Mining',
  `foto_anggota` VARCHAR(255) NULL,
  `motto` TEXT NULL,
  `tahun_lulus` VARCHAR(4) NULL,
  `pendidikan_sekarang` VARCHAR(20) NOT NULL DEFAULT 'S1', -- S1, S2, S3
  `pekerjaan_pertama` VARCHAR(100) NULL,
  `tahun_kerja_pertama` VARCHAR(4) NULL,
  `pekerjaan_saat_ini` VARCHAR(100) NULL,
  `mulai_bekerja` VARCHAR(4) NULL,
  `instansi_perusahaan` VARCHAR(100) NULL,
  `jabatan_pekerjaan` VARCHAR(100) NULL,
  `website_instansi` VARCHAR(150) NULL,
  `profil_instansi` TEXT NULL,
  `tanggal_update` VARCHAR(50) NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_anggota`),
  CONSTRAINT `fk_anggota_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Karya
CREATE TABLE `karya` (
  `id_karya` INT(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` BIGINT(20) NOT NULL,
  `jenis_karya` VARCHAR(50) NOT NULL, -- Prosiding, Jurnal, HKI, Buku, Sistem dan Aplikasi
  `level_karya` VARCHAR(25) NOT NULL, -- Lokal, Nasional, Internasional
  `id_kategori` INT(11) NOT NULL,
  `judul_karya` TEXT NOT NULL,
  `penulis_pertama` VARCHAR(100) NOT NULL,
  `penulis_semua` TEXT NULL,
  `nama_terbitan` TEXT NULL,
  `penerbit` VARCHAR(150) NULL,
  `volume` VARCHAR(20) NULL,
  `nomor` VARCHAR(20) NULL,
  `tahun_terbit` VARCHAR(4) NOT NULL,
  `link_karya` VARCHAR(255) NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_karya`),
  CONSTRAINT `fk_karya_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_karya_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Categories
INSERT INTO `kategori` (`id_kategori`, `kategori`, `icon_karya`) VALUES
(1, 'Sinta 1', 'fa-award'),
(2, 'Sinta 2', 'fa-certificate'),
(3, 'Sinta 3', 'fa-scroll'),
(4, 'Sinta 4', 'fa-file-lines'),
(5, 'Sinta 5', 'fa-file-lines'),
(6, 'Sinta 6', 'fa-file-lines'),
(7, 'Scopus Q1', 'fa-globe'),
(8, 'Scopus Q2', 'fa-globe'),
(9, 'Scopus Q3', 'fa-globe'),
(10, 'Scopus Q4', 'fa-globe'),
(11, 'International Conferences', 'fa-users-line'),
(12, 'Seminar Nasional', 'fa-chalkboard-user'),
(13, 'HKI & Paten', 'fa-shield-halved'),
(14, 'Buku & Monograf', 'fa-book'),
(15, 'Sistem dan Aplikasi', 'fa-laptop-code');

-- Initial Users (Password: admin123, operator123, nurul123)
-- Admin
INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `level`) VALUES
(1, 'Administrator POSMA', 'admin', '$2y$10$yObFLJtrK9MTW/du6uEb/.yhIRLih3LWqaKbdx20Adp8jGssr6kCm', 'Admin'),
(2, 'Operator Predatech', 'operator', '$2y$10$qxJTl7Y5lonoNN8QWZ2ScOo5uoQ.b8s/r0N4ikXp.Sm67iuxgvijq', 'Operator'),
(3, 'Nurul Gayatri Indah Reza', 'nurulgayatri', '$2y$10$B28CkHvjIgcg4XYKy98LlOPo04yW5P0PvbMbV8678BKKRNjmlUFt2', 'Anggota'),
(4, 'Delvi Nurul Aini', 'delvinurul', '$2y$10$B28CkHvjIgcg4XYKy98LlOPo04yW5P0PvbMbV8678BKKRNjmlUFt2', 'Anggota'),
(5, 'Nurul Putri Andani', 'nurulputri', '$2y$10$B28CkHvjIgcg4XYKy98LlOPo04yW5P0PvbMbV8678BKKRNjmlUFt2', 'Anggota'),
(6, 'Fitriana Nurul Puspasari', 'fitriananurul', '$2y$10$B28CkHvjIgcg4XYKy98LlOPo04yW5P0PvbMbV8678BKKRNjmlUFt2', 'Anggota');

-- Initial Anggota matching PDF Examples (Page 3 & 4)
INSERT INTO `anggota` (
  `id_anggota`, `id_user`, `nama_anggota`, `nomor_anggota`, `grup_puzzle`,
  `jenis_kelamin`, `program_studi`, `angkatan`, `tahun_masuk_predatech`, `email_aktif`,
  `no_hp`, `kota_domisili`, `alamat_domisili`, `link_linkedin`, `link_scopus`,
  `link_scholar`, `link_instagram`, `status_keanggotaan`, `status_perkawinan`,
  `bidang_riset`, `foto_anggota`, `motto`, `tahun_lulus`, `pendidikan_sekarang`,
  `pekerjaan_pertama`, `tahun_kerja_pertama`, `pekerjaan_saat_ini`, `mulai_bekerja`,
  `instansi_perusahaan`, `jabatan_pekerjaan`, `website_instansi`, `profil_instansi`, `tanggal_update`
) VALUES
(
  1106722092, 3, 'Nurul Gayatri Indah Reza, S.Kom., MGR.', '1106722092', 1,
  'Perempuan', 'TIF', '2017', '2018', 'nurul.gayatri@predatech.uin-suska.ac.id',
  '081234567890', 'Kota Pekanbaru', 'Jl. Garuda Sakti KM 2, Pekanbaru', 'https://linkedin.com/in/nurulgayatri', 'https://scopus.com/authid/detail.uri?authorId=572000000',
  'https://scholar.google.com/citations?user=sample1', 'https://instagram.com/nurulgayatri', 'Alumni', 'Belum Kawin',
  'Data Mining & IoT', 'avatar_female.svg', 'Belajar tanpa batas, berkarya untuk bangsa dan almamater tercinta', '2019', 'S2',
  'Dinas Perkebunan Provinsi Riau', '2019', 'Data Scientist & AI Engineer', '2021',
  'Perusahaan Negara Malaysia', 'Senior Data Scientist', 'https://www.petronas.com', 'Perusahaan multi-nasional energi dan teknologi data analitik terkemuka di Asia Tenggara.', '27-01-2025'
),
(
  11751101234, 4, 'Delvi Nurul Aini, S.Kom.', '11751101234', 2,
  'Perempuan', 'SIF', '2017', '2018', 'delvi.nurul@predatech.uin-suska.ac.id',
  '081398765432', 'Kabupaten Kampar', 'Bangkinang Kota, Kampar, Riau', 'https://linkedin.com/in/delvinurul', '',
  'https://scholar.google.com/citations?user=sample2', 'https://instagram.com/delvinurul', 'Alumni', 'Belum Kawin',
  'Machine Learning', 'avatar_female2.svg', 'Integritas dan dedikasi mengawali setiap kesuksesan', '2021', 'S1',
  'PT. Indomarco Prismatama', '2021', 'Systems Analyst', '2022',
  'APRIL Group (PT. RAPP)', 'Business Analyst Specialist', 'https://www.aprilasia.com', 'Produsen serat, pulp dan kertas berkelanjutan terkemuka di Indonesia.', '28-01-2025'
),
(
  11851102345, 5, 'Nurul Putri Andani, S.Kom.', '11851102345', 1,
  'Perempuan', 'TIF', '2018', '2019', 'nurul.putri@predatech.uin-suska.ac.id',
  '082176543210', 'Kota Pekanbaru', 'Jl. HR Soebrantas Panam, Pekanbaru', 'https://linkedin.com/in/nurulputri', '',
  'https://scholar.google.com/citations?user=sample3', '', 'Alumni', 'Belum Kawin',
  'Natural Language Processing', 'avatar_female.svg', 'Terus berkontribusi dan menebar manfaat', '2022', 'S1',
  'Startup Edutech Riau', '2022', 'Fullstack Web Developer', '2023',
  'PT Telkom Indonesia', 'Software Engineer', 'https://telkom.co.id', 'BUMN penyedia jasa dan jaringan telekomunikasi terbesar di Indonesia.', '29-01-2025'
),
(
  11951103456, 6, 'Fitriana Nurul Puspasari, S.Kom.', '11951103456', 3,
  'Perempuan', 'TIN', '2019', '2020', 'fitriana.nurul@predatech.uin-suska.ac.id',
  '085211223344', 'Kabupaten Siak', 'Perawang, Kab. Siak, Riau', 'https://linkedin.com/in/fitriananurul', '',
  '', '', 'Alumni', 'Belum Kawin',
  'Supply Chain Data Mining', 'avatar_female2.svg', 'Kerja cerdas dengan basis data yang akurat', '2023', 'S1',
  'PT Indah Kiat Pulp & Paper', '2023', 'Logistics Analyst', '2023',
  'PT Indah Kiat Pulp & Paper', 'Data Operations Lead', 'https://asiapulppaper.com', 'Pabrik bubur kertas dan kertas terintegrasi modern di Riau.', '30-01-2025'
),
(
  11651100001, 1, 'Prof. Dr. Okfalisa, S.T., M.Sc.', '11651100001', 1,
  'Perempuan', 'TIF', '2010', '2015', 'okfalisa@uin-suska.ac.id',
  '08117500001', 'Kota Pekanbaru', 'Komp. Dosen UIN Suska Riau, Simpang Baru, Tampan', 'https://linkedin.com/in/okfalisa', 'https://scopus.com/authid/detail.uri?authorId=56027814700',
  'https://scholar.google.com/citations?user=okfalisa', 'https://instagram.com/okfalisa', 'Dosen', 'Kawin',
  'Knowledge Management & Data Mining', 'avatar_female.svg', 'Leading Research, Building Future Generation', '2010', 'S3',
  'Universitas Islam Negeri Sultan Syarif Kasim Riau', '2005', 'Guru Besar / Dosen Tetap', '2005',
  'UIN Sultan Syarif Kasim Riau', 'Head of Predatech Research Group', 'https://uin-suska.ac.id', 'Perguruan Tinggi Keagamaan Islam Negeri unggulan di Riau.', '25-01-2025'
);

-- Initial Karya matching PDF Examples (Page 4 & 5)
INSERT INTO `karya` (
  `id_karya`, `id_anggota`, `jenis_karya`, `level_karya`, `id_kategori`,
  `judul_karya`, `penulis_pertama`, `penulis_semua`, `nama_terbitan`,
  `penerbit`, `volume`, `nomor`, `tahun_terbit`, `link_karya`
) VALUES
(
  1, 1106722092, 'Jurnal', 'Nasional', 2,
  'Perancangan Sistem Monitoring Cerdas Berbasis Internet of Things (IoT) dengan Algoritma Random Forest Regression untuk Deteksi Ketinggian pada Tanaman Tomat Cherry',
  'Nurul Gayatri Indah Reza, S.Kom., MGR.',
  'Nurul Gayatri Indah Reza, Okfalisa, Inggih Permana',
  'Jurnal RESTI (Rekayasa Sistem dan Teknologi Informasi)',
  'IAII (Ikatan Ahli Informatika Indonesia)',
  '4', '2', '2018',
  'https://jurnal.iaii.or.id/index.php/RESTI/article/view/123'
),
(
  2, 1106722092, 'Jurnal', 'Internasional', 9,
  'Automation of Mikrotik Router Setting Configuration Backup Using Ansible with Network DevOps Method',
  'Nurul Gayatri Indah Reza, S.Kom., MGR.',
  'Nurul Gayatri Indah Reza, Surya Ramadhan, Ahmad Fadhil',
  'International Journal of Advanced Trends in Computer Science and Engineering',
  'WARSE Publications',
  '8', '3', '2019',
  'https://doi.org/10.30534/ijatcse/2019/12832019'
),
(
  3, 1106722092, 'Prosiding', 'Internasional', 11,
  'Optimization of Electric Energy Usage for Household Customers Based on Machine Learning and Internet of Things',
  'Nurul Gayatri Indah Reza, S.Kom., MGR.',
  'Nurul Gayatri Indah Reza, Okfalisa, Mustakim',
  '2020 8th International Conference on Cyber and IT Service Management (CITSM)',
  'IEEE Xplore',
  '1', '1', '2020',
  'https://ieeexplore.ieee.org/document/9262100'
),
(
  4, 1106722092, 'Jurnal', 'Nasional', 3,
  'Otomasi Backup Konfigurasi Settingan Router Mikrotik Menggunakan Ansible dengan Naïve Bayes Classifier',
  'Nurul Gayatri Indah Reza, S.Kom., MGR.',
  'Nurul Gayatri Indah Reza, Okfalisa, Inggih Permana',
  'Indonesian Journal of Computing',
  'Universitas Indonesia',
  '5', '1', '2020',
  'https://socj.telkomuniversity.ac.id/indojc/article/view/2020'
),
(
  5, 11751101234, 'Jurnal', 'Nasional', 4,
  'Rapid Application Development (RAD) berbasis Klasifikasi Naïve Bayes dalam Pengembangan Aplikasi E-Commerce Berbasis Mobile',
  'Delvi Nurul Aini, S.Kom.',
  'Delvi Nurul Aini, Okfalisa, Farkhana',
  'Jurnal CoreIT: Jurnal Hasil Penelitian Ilmu Komputer dan Teknologi Informasi',
  'UIN Suska Riau',
  '7', '2', '2021',
  'http://ejournal.uin-suska.ac.id/index.php/coreit/article/view/9921'
),
(
  6, 11851102345, 'Jurnal', 'Nasional', 3,
  'Implementasi Logika Fuzzy Tsukamoto dan Naïve Bayes Classifier untuk Optimasi Jumlah Produksi Es Batu Kemasan',
  'Nurul Putri Andani, S.Kom.',
  'Nurul Putri Andani, Mustakim, Zientha Nelza',
  'Seminar Nasional Teknologi Informasi, Komunikasi dan Industri (SNTIKI)',
  'Fakultas Sains dan Teknologi UIN Suska Riau',
  '12', '1', '2022',
  'http://ejournal.uin-suska.ac.id/index.php/SNTIKI/article/view/14321'
),
(
  7, 11651100001, 'Jurnal', 'Internasional', 7,
  'Knowledge Management Strategy Formulation in Higher Education: A Hybrid Soft Computing Analytical Hierarchy Process Approach',
  'Prof. Dr. Okfalisa, S.T., M.Sc.',
  'Okfalisa, Yoga Disastro, Afif Fatin, Inggih Permana',
  'Journal of King Saud University - Computer and Information Sciences',
  'Elsevier',
  '34', '8', '2022',
  'https://doi.org/10.1016/j.jksuci.2022.08.012'
),
(
  8, 1106722092, 'HKI', 'Nasional', 13,
  'Sistem Monitoring Cerdas Suhu dan Kelembaban Green House Berbasis IoT dan Android',
  'Nurul Gayatri Indah Reza, S.Kom., MGR.',
  'Nurul Gayatri Indah Reza, Okfalisa',
  'Surat Pencatatan Ciptaan DJKI Kemenkumham RI',
  'Kementerian Hukum dan Hak Asasi Manusia Republik Indonesia',
  '1', '0', '2021',
  'https://e-hakcipta.dgip.go.id/index.php/c?code=000281921'
);
