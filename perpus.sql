-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2026 at 02:20 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_year` year DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `available_quantity` int NOT NULL DEFAULT '1',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ready','not_ready') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ready',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `description`, `publisher`, `publication_year`, `quantity`, `available_quantity`, `category`, `location`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Laskar Pelangi', 'Andrea Hirata', '978-9793947783', 'Novel fiksi tentang kehidupan siswa sekolah di Belitung', 'Bentang Pustaka', '2005', 8, 7, 'Fiksi Nasional', 'Rak A1', 'ready', '2026-04-22 02:22:41', '2026-04-23 19:02:38', NULL),
(2, 'Negeri 5 Menara', 'Ahmad Fuadi', '978-9790633479', 'Novel tentang perjuangan dan persahabatan di pesantren', 'Gramedia Pustaka Utama', '2009', 6, 6, 'Fiksi Nasional', 'Rak A2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(3, 'Si Anak Badai', 'Tere Liye', '978-9793947677', 'Novel petualangan yang menginspirasi', 'Gramedia', '2013', 7, 7, 'Fiksi Nasional', 'Rak A3', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(4, 'Saya Ingin Mencintai Mu dengan Sederhana', 'Iwan Setyawan', '978-6020495649', 'Kumpulan cerpen tentang cinta dan kehidupan', 'Haru', '2012', 5, 4, 'Fiksi Nasional', 'Rak A4', 'ready', '2026-04-22 02:22:41', '2026-04-23 19:01:28', NULL),
(5, 'Entrok', 'Perempuan Penulis', '978-9791007777', 'Novel tentang kehidupan perempuan Jawa', 'Gramedia', '2012', 4, 4, 'Fiksi Nasional', 'Rak A5', 'ready', '2026-04-22 02:22:41', '2026-04-22 23:44:41', NULL),
(6, 'The Great Gatsby', 'F. Scott Fitzgerald', '978-0143039982', 'Klasik literatur Amerika tentang cinta dan ambisi', 'Penguin Classics', '1925', 6, 6, 'Fiksi Internasional', 'Rak B1', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(7, 'To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 'Novel tentang keadilan dan perlindungan', 'HarperCollins', '1960', 5, 5, 'Fiksi Internasional', 'Rak B2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(8, '1984', 'George Orwell', '978-0451524935', 'Distopia tentang pemerintahan totaliter', 'Signet Classics', '1949', 4, 4, 'Fiksi Internasional', 'Rak B3', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(9, 'Pride and Prejudice', 'Jane Austen', '978-0141439518', 'Roman klasik tentang cinta dan masyarakat', 'Penguin Classics', '1913', 5, 5, 'Fiksi Internasional', 'Rak B4', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(10, 'Atomic Habits', 'James Clear', '978-0735211292', 'Panduan membangun kebiasaan yang efektif', 'Avery', '2018', 7, 7, 'Pengembangan Diri', 'Rak C1', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(11, 'Think and Grow Rich', 'Napoleon Hill', '978-1585424337', 'Kunci kesuksesan dalam hidup dan bisnis', 'Dover Publications', '1937', 5, 5, 'Pengembangan Diri', 'Rak C2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(12, 'The Lean Startup', 'Eric Ries', '978-0307887894', 'Metodologi untuk membangun startup yang sukses', 'Crown Business', '2011', 4, 4, 'Bisnis', 'Rak C3', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(13, 'Good to Great', 'Jim Collins', '978-0066620992', 'Mengubah perusahaan dari baik menjadi luar biasa', 'HarperBusiness', '2001', 3, 3, 'Bisnis', 'Rak C4', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(14, 'Clean Code', 'Robert C. Martin', '978-0132350884', 'Panduan menulis kode yang bersih dan profesional', 'Prentice Hall', '2008', 5, 5, 'Teknologi', 'Rak D1', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(15, 'The Pragmatic Programmer', 'David Thomas & Andrew Hunt', '978-0135957059', 'Panduan praktis untuk programmer profesional', 'Addison-Wesley', '2019', 4, 4, 'Teknologi', 'Rak D2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(16, 'Design Patterns', 'Gang of Four', '978-0201633610', 'Elemen yang dapat digunakan kembali dari desain OO', 'Addison-Wesley', '1994', 3, 3, 'Teknologi', 'Rak D3', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(17, 'Fundamental Algoritma dan Pemrograman', 'Budi Sutrisno', '978-9796880020', 'Buku teknis tentang algoritma dan pemrograman', 'Andi Offset', '2018', 6, 6, 'Teknologi', 'Rak D4', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(18, 'Sapiens', 'Yuval Noah Harari', '978-0062316097', 'Sejarah singkat umat manusia dari Zaman Batu hingga zaman modern', 'Harper', '2014', 6, 6, 'Sains & Sejarah', 'Rak E1', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(19, 'Cosmos', 'Carl Sagan', '978-0394504988', 'Perjalanan eksplorasi ruang angkasa dan alam semesta', 'Random House', '1980', 4, 4, 'Sains & Alam', 'Rak E2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(20, 'Habis Gelap Terbitlah Terang', 'R.A. Kartini', '978-6020495768', 'Kumpulan surat-surat R.A. Kartini yang menginspirasi', 'Balai Pustaka', '2012', 5, 5, 'Biografi', 'Rak E3', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(21, 'Educated', 'Tara Westover', '978-0399590504', 'Biografi tentang pendidikan dan pembebasan diri', 'Random House', '2018', 5, 5, 'Biografi', 'Rak E4', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(22, 'Sherlock Holmes: A Scandal in Bohemia', 'Arthur Conan Doyle', '978-0486474649', 'Petualangan detektif terkenal Sherlock Holmes', 'Dover Publications', '1902', 4, 4, 'Misteri', 'Rak F1', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(23, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', '978-0747532699', 'Petualangan penyihir muda Harry Potter', 'Bloomsbury', '1997', 7, 7, 'Fantasi', 'Rak F2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(24, 'The Lord of the Rings', 'J.R.R. Tolkien', '978-0544003415', 'Epos fantasi tentang perjalanan menyelamatkan dunia', 'Houghton Mifflin Harcourt', '1954', 5, 5, 'Fantasi', 'Rak F3', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(25, 'The Art of War', 'Sun Tzu', '978-0140455778', 'Filosofi strategi militer klasik China', 'Penguin Classics', '1901', 4, 4, 'Filsafat', 'Rak G1', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(26, 'The Ultimate Hitchhiker\'s Guide', 'Douglas Adams', '978-0517226957', 'Petualangan lucu di galaksi dengan humor absurd', 'Wings Books', '1979', 6, 6, 'Komedi', 'Rak G2', 'ready', '2026-04-22 02:22:41', '2026-04-22 02:22:41', NULL),
(27, 'harry potter', 'jk rowling', '123333', 'penyihir', 'elex', '2008', 10, 9, 'fiksi', 'a1', 'ready', '2026-04-22 23:10:59', '2026-04-23 19:01:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `borrowed_at` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `returned_at` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `borrowed_at`, `due_date`, `returned_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 9, '2026-03-29 09:22:41', '2026-04-05 09:22:41', '2026-04-17 09:22:41', 'returned', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(2, 10, 18, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(3, 16, 3, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(4, 5, 16, '2026-04-13 09:22:41', '2026-04-20 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(5, 16, 12, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(6, 13, 1, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(7, 5, 24, '2026-04-11 09:22:41', '2026-04-18 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(8, 11, 12, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(9, 6, 3, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(10, 3, 18, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(11, 5, 19, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(12, 16, 7, '2026-04-15 09:22:41', '2026-04-22 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(13, 8, 12, '2026-04-09 09:22:41', '2026-04-16 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(14, 15, 18, '2026-04-20 09:22:41', '2026-04-27 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(15, 10, 26, '2026-04-12 09:22:41', '2026-04-19 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(16, 10, 4, '2026-04-09 09:22:41', '2026-04-16 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(17, 15, 3, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(18, 4, 19, '2026-03-13 09:22:41', '2026-03-20 09:22:41', '2026-04-13 09:22:41', 'returned', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(19, 12, 6, '2026-04-11 09:22:41', '2026-04-18 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(20, 11, 13, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(21, 9, 9, '2026-04-07 09:22:41', '2026-04-14 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(22, 10, 12, '2026-03-31 09:22:41', '2026-04-07 09:22:41', '2026-04-20 09:22:41', 'returned', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(23, 7, 2, '2026-04-08 09:22:41', '2026-04-15 09:22:41', '2026-04-19 09:22:41', 'returned', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(24, 3, 26, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(25, 6, 17, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(26, 6, 21, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(27, 7, 10, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(28, 12, 5, '2026-03-24 09:22:41', '2026-03-31 09:22:41', '2026-04-21 09:22:41', 'returned', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(29, 2, 7, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(30, 11, 11, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(31, 4, 12, '2026-04-11 09:22:41', '2026-04-18 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(32, 11, 8, '2026-04-05 09:22:41', '2026-04-12 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(33, 6, 16, '2026-04-09 09:22:41', '2026-04-16 09:22:41', NULL, 'approved', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(34, 12, 24, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(35, 6, 22, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(36, 9, 24, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(37, 3, 21, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(38, 2, 5, '2026-04-22 09:28:18', '2026-04-29 00:00:00', '2026-05-01 00:00:00', 'returned', '2026-04-22 02:22:41', '2026-04-22 23:44:41'),
(39, 3, 21, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(40, 2, 22, NULL, NULL, NULL, 'pending', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(41, 13, 8, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(42, 16, 9, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(43, 11, 3, '2026-04-09 09:22:41', '2026-04-16 09:22:41', '2026-04-21 09:22:41', 'returned', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(44, 7, 10, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(45, 2, 22, NULL, NULL, NULL, 'rejected', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(46, 1, 1, '2026-04-24 02:02:38', '2026-05-08 00:00:00', NULL, 'approved', '2026-04-22 23:13:58', '2026-04-23 19:02:38'),
(48, 18, 1, NULL, NULL, NULL, 'rejected', '2026-04-23 18:58:18', '2026-04-23 19:02:17'),
(49, 18, 12, NULL, NULL, NULL, 'pending', '2026-04-23 18:58:57', '2026-04-23 18:58:57'),
(50, 18, 4, '2026-04-24 02:01:28', '2026-05-01 00:00:00', NULL, 'approved', '2026-04-23 18:59:13', '2026-04-23 19:01:28'),
(51, 18, 27, '2026-04-24 02:01:12', '2026-05-01 00:00:00', NULL, 'approved', '2026-04-23 18:59:27', '2026-04-23 19:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` bigint UNSIGNED NOT NULL,
  `borrowing_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `borrowing_id`, `user_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Denda keterlambatan peminjaman: 12 hari x Rp5.000 = Rp60.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(2, 4, 5, 'Denda keterlambatan peminjaman: 2.0000030642824 hari x Rp5.000 = Rp10.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(3, 7, 5, 'Denda keterlambatan peminjaman: 4.0000030848611 hari x Rp5.000 = Rp20.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(4, 12, 16, 'Denda keterlambatan peminjaman: 3.1127199074074E-6 hari x Rp5.000 = Rp0', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(5, 13, 8, 'Denda keterlambatan peminjaman: 6.0000031395486 hari x Rp5.000 = Rp30.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(6, 15, 10, 'Denda keterlambatan peminjaman: 3.000003160081 hari x Rp5.000 = Rp15.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(7, 16, 10, 'Denda keterlambatan peminjaman: 6.0000031781944 hari x Rp5.000 = Rp30.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(8, 18, 4, 'Denda keterlambatan peminjaman: 24 hari x Rp5.000 = Rp120.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(9, 19, 12, 'Denda keterlambatan peminjaman: 4.0000032206829 hari x Rp5.000 = Rp20.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(10, 21, 9, 'Denda keterlambatan peminjaman: 8.0000032411343 hari x Rp5.000 = Rp40.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(11, 22, 10, 'Denda keterlambatan peminjaman: 13 hari x Rp5.000 = Rp65.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(12, 23, 7, 'Denda keterlambatan peminjaman: 4 hari x Rp5.000 = Rp20.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(13, 28, 12, 'Denda keterlambatan peminjaman: 21 hari x Rp5.000 = Rp105.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(14, 31, 4, 'Denda keterlambatan peminjaman: 4.0000033203125 hari x Rp5.000 = Rp20.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(15, 32, 11, 'Denda keterlambatan peminjaman: 10.000003338576 hari x Rp5.000 = Rp50.000', 'unpaid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(16, 33, 6, 'Denda keterlambatan peminjaman: 6.000003356875 hari x Rp5.000 = Rp30.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(17, 43, 11, 'Denda keterlambatan peminjaman: 5 hari x Rp5.000 = Rp25.000', 'paid', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(19, 38, 2, 'membuat poster', 'unpaid', '2026-04-22 23:47:19', '2026-04-22 23:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_08_114818_add_role_to_users_table', 1),
(5, '2026_04_08_114827_create_books_table', 1),
(6, '2026_04_08_114828_create_borrowings_table', 1),
(7, '2026_04_08_114828_create_fines_table', 1),
(8, '2026_04_08_121534_update_borrowings_and_fines_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('g5TsJ8xuluZBDn1NZa80prp4rC35AYY0PJzvlOM3', 18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJTaGxKa3pXdnpreEpXMmI0VlV3VlMwQXdlWmNVNGpnUzFJeEN5OVU5IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDAiLCJyb3V0ZSI6bnVsbH0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxOH0=', 1776996467),
('KvPYMeLgeRfhmZLM69B0yUUi7cu9wjeLgEFL98aw', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJObjF4TFZzMGtQUG1KMnpUaElrbEVsZDA1alBuTEc3QkZBN3BRbDBXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==', 1776995324);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Perpustakaan', 'admin@perpustakaan.test', 'admin', '2026-04-22 02:22:40', '$2y$12$xcs6/juT4oLUyVt/0kf97.E4GtVy06vpW.OtSCOLfxc.XhrlAudmi', 'vlqorc78INT6Az4lIkcy3Lebhd3zcLlVqmJ8DtRdNyiqDIDv5CmrutknsODP', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(2, 'Maiya Swift', 'saige90@example.net', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'ETNxClYfRP', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(3, 'Lessie Gerhold', 'federico66@example.org', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'LEfX9R6NVe', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(4, 'Amari Hammes', 'elisa.grant@example.com', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'drs49WU1jk', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(5, 'Dr. Felton Lubowitz Jr.', 'skiles.rahsaan@example.org', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', '4askrGcPf2', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(6, 'Shirley McLaughlin', 'kaitlyn.jakubowski@example.org', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'RJShQctTE5', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(7, 'Elliott Leannon', 'carlos.jones@example.net', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'BMX5R2ZNIN', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(8, 'Zita Langworth', 'allen88@example.com', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'pfvwGEgfUm', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(9, 'Darren Brekke', 'mueller.thea@example.net', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'mpXW7iwzwH', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(10, 'Sanford Cartwright', 'morissette.duane@example.com', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'pysj8OO7Yb', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(11, 'Hilda Muller MD', 'probel@example.net', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'W6B3awJj2u', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(12, 'Jailyn Donnelly', 'everardo.homenick@example.org', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'lUysxcEFNj', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(13, 'Mr. Zakary Powlowski', 'jhermiston@example.net', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'Az7CAVAIka', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(14, 'Rashawn D\'Amore', 'regan.kuhic@example.org', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'ZypgeWWdCb', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(15, 'Maverick Purdy', 'strosin.jacky@example.com', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'HVG9PJnTE7', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(16, 'Juston Kub Jr.', 'htoy@example.net', 'user', '2026-04-22 02:22:41', '$2y$12$.3iLG.5jP.E.liu4RjOyd.jgmqsiP/mU7JWEYNmvNQsVA//gXReC6', 'CR9hDY8rOH', '2026-04-22 02:22:41', '2026-04-22 02:22:41'),
(18, 'mama', 'mama@gmail.com', 'user', NULL, '$2y$12$olxGooS.jTINn8lVd8VSmepPbd3xmnpgp1YmQVqbRQm72G2M6wzDK', 'qLYDeGTlwiSqVXSYjEpiPCwIfCH30RMrE2bIQf913Z8WME6ucwSC86RCd9Pt', '2026-04-23 18:57:20', '2026-04-23 18:57:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_isbn_unique` (`isbn`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowings_user_id_foreign` (`user_id`),
  ADD KEY `borrowings_book_id_foreign` (`book_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fines_borrowing_id_foreign` (`borrowing_id`),
  ADD KEY `fines_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fines_borrowing_id_foreign` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
