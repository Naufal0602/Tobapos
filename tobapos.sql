-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tobapos_db
CREATE DATABASE IF NOT EXISTS `tobapos_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tobapos_db`;

-- Dumping structure for table tobapos_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.cache: ~4 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('admin1@gmail.com|127.0.0.1', 'i:1;', 1742810119),
	('admin1@gmail.com|127.0.0.1:timer', 'i:1742810119;', 1742810119),
	('adymin@gmail.com|127.0.0.1', 'i:2;', 1742810006),
	('adymin@gmail.com|127.0.0.1:timer', 'i:1742810006;', 1742810006);

-- Dumping structure for table tobapos_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table tobapos_db.company_profiles
CREATE TABLE IF NOT EXISTS `company_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_description` text COLLATE utf8mb4_unicode_ci,
  `about_description` text COLLATE utf8mb4_unicode_ci,
  `img_home` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.company_profiles: ~1 rows (approximately)
INSERT INTO `company_profiles` (`id`, `name`, `address`, `home_description`, `about_description`, `img_home`, `img_description`, `phone`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'TOBAPOS', 'Jl. Pintu Ledeng, Ciomas, Kec. Ciomas, Kabupaten Bogor, Jawa Barat 16610', 'Cobain sendiri rasa baru yang kami racik khusus buat kamu. Karena hidup itu butuh sesuatu yang beda, kan?', 'TobaPOS berdiri dengan semangat mdenghadirkan tembakau berkualitas yang memadukan tradisi dan inovasi. Sejak awal berdiri, kami telah bekerja bersama petani lokal terbaik, memastikan setiap helai tembakau diproses dengan dedikasi tinggi untuk menghasilkan produk unggulan.\r\n\r\nBerawal dari usaha kecil, kami kini tumbuh menjadi salah satu pemain utama di industri dengan berbagai pencapaian yang diakui. Komitmen kami tak hanya pada kualitas, tetapi juga pada keberlanjutan dan kesejahteraan komunitas. Bersama petani dan pelanggan, kami terus melangkah untuk menciptakan masa depan yang lebih baik.', 'company_profile/6vHYJzLSqRxnWJk3bAgkL2BISQpVuZS1fap6P44I.png', 'company_profile/UNvRBCIueC400wE7e2Fajiplme50PlllsXnRmqWc.png', '+62 812-3456-7890', 'support@tobapos.com', '2025-04-11 17:00:00', '2025-04-29 18:32:11');

-- Dumping structure for table tobapos_db.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.contacts: ~14 rows (approximately)
INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`, `updated_at`) VALUES
	(8, 'Naufal', 'a@gmail.com', 'mantap', '2025-03-27 03:02:06', '2025-03-27 03:02:06'),
	(9, 'Muhammad Naufal Abdul Malik', 'ab@gmail.com', 'enak kali lha', '2025-03-27 03:07:46', '2025-03-27 03:07:46'),
	(10, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'osoinndoi', '2025-03-27 03:09:38', '2025-03-27 03:09:38'),
	(11, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'd d dskjdv      jdddddddddddddddddddddddddd', '2025-03-27 03:11:14', '2025-03-27 03:11:14'),
	(12, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'asaaaaaaaaa', '2025-03-29 09:29:41', '2025-03-29 09:29:41'),
	(13, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'wadidaw', '2025-04-09 05:16:34', '2025-04-09 05:16:34'),
	(14, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'dadaa', '2025-04-09 05:17:28', '2025-04-09 05:17:28'),
	(15, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'lsss', '2025-04-09 18:00:18', '2025-04-09 18:00:18'),
	(16, 'Muhammad Naufal Abdul Malik', 'admin@gmail.com', 'jjjgjgjgjg', '2025-04-10 23:39:42', '2025-04-10 23:39:42'),
	(17, 'Muhammad Naufal Abdul Malik', 'naufalabdulmalik123@gmail.com', 'uiuiuiui', '2025-04-28 00:54:07', '2025-04-28 00:54:07'),
	(18, 'ka', 'naufalabdulmalik123@gmail.com', 'a', '2025-04-29 18:44:34', '2025-04-29 18:44:34'),
	(19, 'ka', 'naufalabdulmalik123@gmail.com', 'a', '2025-04-29 18:45:08', '2025-04-29 18:45:08'),
	(22, 'Fathir', 'support@tdobapos.com', 'aaaaaaaaaaaa', '2025-06-09 11:15:26', '2025-06-09 11:15:26'),
	(23, 'Fathire', 'support@tdobapos.com', 'mantap', '2025-06-09 21:29:55', '2025-06-09 21:29:55');

-- Dumping structure for table tobapos_db.expenses
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `receipt_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.expenses: ~23 rows (approximately)
INSERT INTO `expenses` (`id`, `name`, `category`, `amount`, `receipt_image`, `created_at`, `updated_at`) VALUES
	(2, 'barang', 'Toko', 12000.00, 'receipt_image/YgAy5RuPEF68EmHTnmupmJ4r3x6ENgaC1Rsq7C2B.png', '2025-02-19 08:45:23', '2025-02-19 08:45:23'),
	(3, 'barang', 'Toko', 12000.00, 'receipt_image/FZpnqUSU8ifeEoShBAUCGOduxBbJtJvZkxXbXj3p.png', '2025-02-19 08:45:54', '2025-02-19 08:45:54'),
	(4, 'barang', 'Pribadi', 1700.00, 'company_profile/tRFAWYwjMQMc3XMMLr8ECIrpXQBq0VxiD5shcBoq.png', '2025-02-19 08:46:33', '2025-02-27 19:21:21'),
	(5, 'barang', 'Pribadi', 17005.00, 'receipt_image/9zrk18T5zttqONR0bu3W9KttezSEh2SFJnkBqvIB.jpg', '2025-02-19 08:48:29', '2025-02-19 08:48:29'),
	(6, 'barang halal', 'Toko', 17005.00, 'receipt_image/A3GUodRlg2YSBpeaSqUxJyYfpbbQ16wZYatIwJln.jpg', '2025-02-19 09:25:53', '2025-02-19 09:25:53'),
	(7, 'cherry bomb', 'Toko', 12000.00, 'receipt_image/3HGDYJh3N5PMDkPPxlsLnrxpwAdyhYcxXCxPISDb.jpg', '2025-02-19 23:04:23', '2025-02-19 23:04:23'),
	(8, 'cherry', 'Toko', 13000.00, 'receipt_image/Fwds3FVQrH51IJposU4BMgvbAM04T4fKvfcX2jGq.jpg', '2025-02-21 00:01:09', '2025-02-21 00:01:09'),
	(9, 'cherry', 'Toko', 13000.00, 'receipt_image/7zeHmXDwLTMFRAhvxWgdOXCAEY3rnQwJsf2DeZcU.jpg', '2025-02-23 16:18:36', '2025-02-23 16:18:36'),
	(10, 'cherry', 'Toko', 13000.00, 'receipt_image/0Kneeq0ghHeyyaFsd4bzL5Z4pLcTnW769mTvDsSl.jpg', '2025-03-02 03:56:17', '2025-03-02 03:56:17'),
	(16, 'Naufal', 'Pribadi', 90000.00, NULL, '2025-04-27 02:02:51', '2025-04-27 02:02:51'),
	(19, 'Naufal', 'Pribadi', 200000.00, NULL, '2025-04-29 02:17:20', '2025-04-29 02:17:20'),
	(20, 'Naufal', 'Pribadi', 200000.00, NULL, '2025-04-29 02:34:38', '2025-04-29 02:34:38'),
	(21, 'Roko', 'Toko', 250000.00, 'receipt_image/nsr9AneLn017GTidyzMsj4RzDZzzsOjaLgUpj0v2.png', '2025-04-29 02:35:06', '2025-04-29 19:05:31'),
	(22, 'beli sampoerna', 'Toko', 200000.00, 'receipt_image/AnwyMIkQeTlmjb11cNShkiHY43cRj412B0wjob03.png', '2025-04-29 20:38:05', '2025-04-29 20:38:05'),
	(23, 'beli sampoerna', 'Pribadi', 10000000.00, NULL, '2025-05-29 03:20:15', '2025-05-29 03:20:15'),
	(24, 'beli sampoerna', 'Pribadi', 10000000.00, NULL, '2025-05-29 19:01:09', '2025-05-29 19:01:09'),
	(25, 'beli sampoerna', 'Pribadi', 10000000.00, NULL, '2025-05-29 19:01:32', '2025-05-29 19:01:32'),
	(27, 'admin', 'Pribadi', 10000.00, 'receipt_image/inAI8l7sYcDM7WtOg5KDdDuxIPEjmpbplwKYR2R7.jpg', '2025-06-02 08:02:28', '2025-06-02 08:02:28'),
	(28, 'admin', 'Pribadi', 10000.00, 'receipt_image/FZDdHFd7rEkSiugV6Qdgb8BjBhxBsSFGB5T50Xtb.jpg', '2025-06-02 08:21:46', '2025-06-02 08:21:46'),
	(30, 'admin', 'Pribadi', 10000.00, NULL, '2025-06-02 08:37:09', '2025-06-02 08:37:09'),
	(31, 'admin', 'Pribadi', 90000.00, NULL, '2025-06-02 08:37:41', '2025-06-02 08:37:41'),
	(33, 'kapas', 'Toko', 100000.00, 'receipt_image/XVUuOcPViHXg4UlZU50t0mZWNEQB3YQg8a2hNMnY.png', '2025-06-09 19:28:11', '2025-06-09 19:28:11'),
	(34, 'kapas', 'Pribadi', 200000.00, 'receipt_image/jusdH5niIiPhcs22eE6yMGvL1iv0VMmipBeJzW4H.jpg', '2025-06-12 15:36:02', '2025-06-12 15:36:02');

-- Dumping structure for table tobapos_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table tobapos_db.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.jobs: ~0 rows (approximately)

-- Dumping structure for table tobapos_db.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table tobapos_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.migrations: ~14 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_01_02_143623_create_contacts_table', 1),
	(5, '2025_02_03_201206_create_company_profiles_table', 1),
	(6, '2025_02_03_211447_create_expenses_table', 1),
	(7, '2025_02_03_214332_create_products_table', 1),
	(8, '2025_02_03_215547_create_transactions_table', 1),
	(13, '2025_02_28_084019_add_size_to_products_table', 2),
	(14, '2025_04_27_075950_make_img_fields_nullable_in_company_profiles_table', 3),
	(15, '2025_04_24_100313_create_printers_table', 4),
	(16, '2025_04_28_031312_add_product_id_to_transaction_items_table', 5),
	(17, '2025_05_14_005401_add_size_to_transaction_items_table', 6),
	(18, '2025_05_31_120407_add_category_to_transaction_items_table', 7);

-- Dumping structure for table tobapos_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table tobapos_db.printers
CREATE TABLE IF NOT EXISTS `printers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_printer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.printers: ~5 rows (approximately)
INSERT INTO `printers` (`id`, `nama_printer`, `created_at`, `updated_at`) VALUES
	(1, 'POS-58', '2025-04-27 20:02:19', '2025-04-27 20:02:19'),
	(2, 'epson_naufal', '2025-04-27 23:04:57', '2025-04-27 23:04:57'),
	(3, 'POS-58D', '2025-04-28 15:40:50', '2025-04-28 15:40:50'),
	(5, 'epson_naufala', '2025-04-29 02:56:10', '2025-04-29 02:56:10'),
	(6, 'POS-58jl', '2025-06-03 07:00:49', '2025-06-03 07:00:49');

-- Dumping structure for table tobapos_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.products: ~10 rows (approximately)
INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `image`, `description`, `created_at`, `updated_at`, `size`) VALUES
	(19, 'roko', 'ice', 300000.00, 107, 'products/cBD2Z7O2MTomkQ4Kty44FFDERzYfHU9SmpfhnfGn.png', 'mmmm', '2025-04-28 15:52:26', '2025-05-31 05:15:28', '1 kg'),
	(20, 'sampoerna', 'bussa_reguler', 300000.00, 55, 'products/ei0meDFq2Z9lfgHiEWndMWP7puSiHpZMqhHnQJef.png', 'rasa pisang', '2025-04-28 18:04:04', '2025-05-31 05:15:28', '50 gram'),
	(21, 'sampoerna', 'bussa_mild', 300000.00, 1, 'products/MVdl24YVAddpTLlbGSbFAgpfRD4wexO9DM24tOLY.png', 'Enak-enak', '2025-04-29 17:20:24', '2025-06-09 17:42:03', '200 gram'),
	(22, 'berry', 'bussa_mild', 10000.00, 0, 'products/m2CoLCf1vnO44HHBivLrnts3n0lV0dzDOPsymsxG.png', 'enak', '2025-05-30 18:07:00', '2025-05-31 06:12:41', '500 gram'),
	(23, 'berry ice', 'ice', 10000.00, 10, 'products/EeBWWzotQ96iL2NMkBZ6OOiDpjxpaV1Umlf3fXei.png', 'fsll', '2025-05-31 06:16:34', '2025-06-09 17:41:16', '50 gram'),
	(24, 'berry iceo', 'menthol', 10000.00, 11, 'products/2gMTdTjNKhufE13reIgiK8c36tV7RGQ8ELPlxbFb.png', 'hyf', '2025-05-31 06:39:16', '2025-06-09 17:41:29', '50 gram'),
	(25, 'iceo', 'menthol', 10000.00, 12, 'products/1ENlau38fvCIyijsn9tbgHoOIWKtzQhTIa8mQJFx.png', 'XJJJ', '2025-05-31 06:41:34', '2025-06-09 17:40:40', '50 gram'),
	(26, 'ice berry', 'menthol', 10000.00, 11, 'products/0XGdBSNWiNDHa94NqXdGFIttEFZE7J2LhiPpltOc.png', 'JACCCCCCCCCC', '2025-05-31 06:41:52', '2025-06-09 17:40:17', '50 gram'),
	(27, 'iceoa', 'vapir', 10000.00, 1, 'products/2MTYqQqfcSBaQSnCaMWNqtHMxgnFwG1QbKcypbv0.png', 'kkkkkkkkkkk', '2025-05-31 06:42:16', '2025-06-12 15:57:54', '50 gram'),
	(28, 'bako', 'herbal', 15000.00, 13, 'products/rGFGyDuG7to65G9sHixkkwsfWVuhQ03P24osj5Ym.png', 'makan', '2025-06-01 07:43:14', '2025-06-12 23:03:05', '100 gram');

-- Dumping structure for table tobapos_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('7Jc6TUjfo4OsKgkgsUH9Xio8Khpc03WIXPA2qL17', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36 Edg/137.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1BBcXJTbzRkREttQnNNNldxYXJJTnIwbTV4TjJhV0NrcmZXWUxhMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly90b2JhcG9zLnRlc3QvZGFzaGJvYXJkL3RyYW5zYWN0aW9ucyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1749783335);

-- Dumping structure for table tobapos_db.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.transactions: ~367 rows (approximately)
INSERT INTO `transactions` (`id`, `total`, `payment_method`, `created_at`, `updated_at`) VALUES
	(50, 50000.00, 'cash', '2025-02-18 18:12:30', '2025-02-18 18:12:30'),
	(51, 10000.00, 'cash', '2025-02-18 18:40:50', '2025-02-18 18:40:50'),
	(52, 77000.00, 'cash', '2025-02-18 18:45:25', '2025-02-18 18:45:25'),
	(53, 30000.00, 'cash', '2025-02-18 18:47:04', '2025-02-18 18:47:04'),
	(54, 107000.00, 'cash', '2025-02-18 18:56:02', '2025-02-18 18:56:02'),
	(55, 308000.00, 'cash', '2025-02-18 19:17:50', '2025-02-18 19:17:50'),
	(56, 77000.00, 'dana', '2025-02-19 07:58:31', '2025-02-19 07:58:31'),
	(57, 77000.00, 'cash', '2025-02-19 08:05:06', '2025-02-19 08:05:06'),
	(58, 77000.00, 'shopee_pay', '2025-02-19 08:08:14', '2025-02-19 08:08:14'),
	(59, 164000.00, 'shopee_pay', '2025-02-19 08:11:09', '2025-02-19 08:11:09'),
	(60, 77000.00, 'cash', '2025-02-19 08:21:16', '2025-02-19 08:21:16'),
	(61, 77000.00, 'cash', '2025-02-19 08:22:26', '2025-02-19 08:22:26'),
	(62, 77000.00, 'cash', '2025-02-19 08:24:22', '2025-02-19 08:24:22'),
	(63, 77000.00, 'cash', '2025-02-19 08:32:15', '2025-02-19 08:32:15'),
	(64, 87000.00, 'cash', '2025-02-19 08:34:18', '2025-02-19 08:34:18'),
	(65, 77000.00, 'cash', '2025-02-19 08:37:25', '2025-02-19 08:37:25'),
	(66, 77000.00, 'cash', '2025-02-19 08:38:25', '2025-02-19 08:38:25'),
	(67, 10000.00, 'cash', '2025-02-19 08:40:49', '2025-02-19 08:40:49'),
	(68, 97000.00, 'cash', '2025-02-19 08:41:51', '2025-02-19 08:41:51'),
	(69, 77000.00, 'cash', '2025-02-19 08:42:26', '2025-02-19 08:42:26'),
	(70, 87000.00, 'cash', '2025-02-19 23:26:39', '2025-02-19 23:26:39'),
	(71, 1541000.00, 'cash', '2025-02-20 21:46:41', '2025-02-20 21:46:41'),
	(72, 46000.00, 'cash', '2025-02-23 16:01:05', '2025-02-23 16:01:05'),
	(73, 23000.00, 'cash', '2025-02-23 16:05:12', '2025-02-23 16:05:12'),
	(74, 192000.00, 'cash', '2025-02-23 16:16:20', '2025-02-23 16:16:20'),
	(75, 77000.00, 'dana', '2025-02-23 17:55:54', '2025-02-23 17:55:54'),
	(76, 23000.00, 'shopee_pay', '2025-02-23 17:56:33', '2025-02-23 17:56:33'),
	(77, 77000.00, 'shopee_pay', '2025-02-23 17:59:12', '2025-02-23 17:59:12'),
	(78, 23000.00, 'cash', '2025-02-23 18:49:49', '2025-02-23 18:49:49'),
	(79, 77000.00, 'cash', '2025-02-23 22:59:20', '2025-02-23 22:59:20'),
	(80, 23000.00, 'cash', '2025-02-24 19:25:57', '2025-02-24 19:25:57'),
	(81, 100000.00, 'cash', '2025-02-25 18:14:11', '2025-02-25 18:14:11'),
	(82, 308000.00, 'shopee_pay', '2025-02-25 18:17:24', '2025-02-25 18:17:24'),
	(83, 23000.00, 'shopee_pay', '2025-02-25 18:21:38', '2025-02-25 18:21:38'),
	(84, 23000.00, 'shopee_pay', '2025-02-25 18:21:55', '2025-02-25 18:21:55'),
	(85, 23000.00, 'dana', '2025-02-25 18:23:22', '2025-02-25 18:23:22'),
	(86, 23000.00, 'cash', '2025-02-25 18:23:44', '2025-02-25 18:23:44'),
	(87, 10000.00, 'shopee_pay', '2025-02-25 22:22:23', '2025-02-25 22:22:23'),
	(88, 23000.00, 'cash', '2025-02-26 21:04:05', '2025-02-26 21:04:05'),
	(89, 69000.00, 'cash', '2025-02-26 21:06:39', '2025-02-26 21:06:39'),
	(90, 69000.00, 'shopee_pay', '2025-02-26 21:33:08', '2025-02-26 21:33:08'),
	(91, 100000.00, 'cash', '2025-02-26 22:04:20', '2025-02-26 22:04:20'),
	(92, 23000.00, 'dana', '2025-02-26 22:13:43', '2025-02-26 22:13:43'),
	(93, 77000.00, 'dana', '2025-02-26 22:15:45', '2025-02-26 22:15:45'),
	(94, 23000.00, 'shopee_pay', '2025-02-26 22:18:06', '2025-02-26 22:18:06'),
	(95, 23000.00, 'cash', '2025-02-26 22:20:34', '2025-02-26 22:20:34'),
	(96, 77000.00, 'dana', '2025-02-26 22:26:15', '2025-02-26 22:26:15'),
	(97, 77000.00, 'cash', '2025-02-26 22:32:31', '2025-02-26 22:32:31'),
	(98, 77000.00, 'dana', '2025-02-26 22:33:41', '2025-02-26 22:33:41'),
	(99, 77000.00, 'dana', '2025-02-26 22:34:47', '2025-02-26 22:34:47'),
	(100, 100000.00, 'cash', '2025-02-26 22:37:38', '2025-02-26 22:37:38'),
	(101, 23000.00, 'shopee_pay', '2025-02-26 22:40:13', '2025-02-26 22:40:13'),
	(102, 23000.00, 'shopee_pay', '2025-02-26 22:41:15', '2025-02-26 22:41:15'),
	(103, 23000.00, 'shopee_pay', '2025-02-26 22:43:32', '2025-02-26 22:43:32'),
	(104, 23000.00, 'dana', '2025-02-26 22:44:29', '2025-02-26 22:44:29'),
	(105, 23000.00, 'shopee_pay', '2025-02-26 22:46:05', '2025-02-26 22:46:05'),
	(106, 253000.00, 'cash', '2025-02-27 10:42:21', '2025-02-27 10:42:21'),
	(107, 30000.00, 'cash', '2025-02-27 16:26:16', '2025-02-27 16:26:16'),
	(108, 12000.00, 'shopee_pay', '2025-02-27 20:25:12', '2025-02-27 20:25:12'),
	(109, 84000.00, 'cash', '2025-02-27 20:33:42', '2025-02-27 20:33:42'),
	(110, 84000.00, 'cash', '2025-02-27 20:34:07', '2025-02-27 20:34:07'),
	(111, 372000.00, 'cash', '2025-02-27 20:35:18', '2025-02-27 20:35:18'),
	(112, 24000.00, 'dana', '2025-02-27 20:47:45', '2025-02-27 20:47:45'),
	(113, 72000.00, 'cash', '2025-02-27 20:54:33', '2025-02-27 20:54:33'),
	(114, 84000.00, 'dana', '2025-02-27 20:58:39', '2025-02-27 20:58:39'),
	(115, 84000.00, 'cash', '2025-02-27 21:01:54', '2025-02-27 21:01:54'),
	(116, 36000.00, 'cash', '2025-02-27 22:56:21', '2025-02-27 22:56:21'),
	(117, 72000.00, 'cash', '2025-02-27 23:04:42', '2025-02-27 23:04:42'),
	(118, 36000.00, 'cash', '2025-02-27 23:06:45', '2025-02-27 23:06:45'),
	(119, 60000.00, 'cash', '2025-02-27 23:09:33', '2025-02-27 23:09:33'),
	(120, 60000.00, 'shopee_pay', '2025-02-27 23:10:30', '2025-02-27 23:10:30'),
	(121, 60000.00, 'shopee_pay', '2025-02-27 23:12:49', '2025-02-27 23:12:49'),
	(122, 60000.00, 'shopee_pay', '2025-02-27 23:13:27', '2025-02-27 23:13:27'),
	(123, 107000.00, 'shopee_pay', '2025-02-27 23:14:28', '2025-02-27 23:14:28'),
	(124, 107000.00, 'shopee_pay', '2025-02-27 23:16:51', '2025-02-27 23:16:51'),
	(125, 23000.00, 'cash', '2025-02-27 23:18:08', '2025-02-27 23:18:08'),
	(126, 23000.00, 'dana', '2025-02-27 23:20:56', '2025-02-27 23:20:56'),
	(127, 12000.00, 'shopee_pay', '2025-02-27 23:24:02', '2025-02-27 23:24:02'),
	(128, 77000.00, 'shopee_pay', '2025-02-27 23:45:59', '2025-02-27 23:45:59'),
	(129, 12000.00, 'shopee_pay', '2025-02-28 01:05:42', '2025-02-28 01:05:42'),
	(130, 12000.00, 'cash', '2025-03-02 03:55:28', '2025-03-02 03:55:28'),
	(131, 36000.00, 'cash', '2025-03-05 18:18:39', '2025-03-05 18:18:39'),
	(132, 24000.00, 'cash', '2025-03-05 18:37:23', '2025-03-05 18:37:23'),
	(133, 50000.00, 'dana', '2025-03-05 18:38:25', '2025-03-05 18:38:25'),
	(134, 10000.00, 'shopee_pay', '2025-03-05 18:39:43', '2025-03-05 18:39:43'),
	(135, 20000.00, 'shopee_pay', '2025-03-05 18:40:59', '2025-03-05 18:40:59'),
	(136, 108000.00, 'dana', '2025-03-05 18:48:06', '2025-03-05 18:48:06'),
	(137, 84000.00, 'shopee_pay', '2025-03-05 18:49:51', '2025-03-05 18:49:51'),
	(138, 240000.00, 'dana', '2025-03-05 19:19:38', '2025-03-05 19:19:38'),
	(139, 1386000.00, 'dana', '2025-03-05 19:28:46', '2025-03-05 19:28:46'),
	(140, 50000.00, 'cash', '2025-03-06 21:14:41', '2025-03-06 21:14:41'),
	(141, 700000.00, 'dana', '2025-03-06 21:17:59', '2025-03-06 21:17:59'),
	(142, 12000.00, 'cash', '2025-03-09 18:44:58', '2025-03-09 18:44:58'),
	(143, 10000.00, 'shopee_pay', '2025-03-09 18:58:50', '2025-03-09 18:58:50'),
	(144, 69000.00, 'shopee_pay', '2025-03-10 10:19:24', '2025-03-10 10:19:24'),
	(145, 23000.00, 'cash', '2025-03-10 10:29:57', '2025-03-10 10:29:57'),
	(146, 23000.00, 'shopee_pay', '2025-03-10 10:32:04', '2025-03-10 10:32:04'),
	(147, 23000.00, 'dana', '2025-03-10 10:41:27', '2025-03-10 10:41:27'),
	(148, 46000.00, 'shopee_pay', '2025-03-10 10:48:43', '2025-03-10 10:48:43'),
	(149, 40000.00, 'cash', '2025-03-15 20:20:22', '2025-03-15 20:20:22'),
	(150, 56000.00, 'shopee_pay', '2025-03-15 20:25:24', '2025-03-15 20:25:24'),
	(151, 12000.00, 'cash', '2025-03-24 03:00:38', '2025-03-24 03:00:38'),
	(152, 24000.00, 'dana', '2025-03-24 04:51:23', '2025-03-24 04:51:23'),
	(153, 12000.00, 'dana', '2025-03-24 04:59:05', '2025-03-24 04:59:05'),
	(154, 360000.00, 'shopee_pay', '2025-03-24 05:36:08', '2025-03-24 05:36:08'),
	(155, 252000.00, 'cash', '2025-03-24 05:36:41', '2025-03-24 05:36:41'),
	(156, 120000.00, 'shopee_pay', '2025-03-24 05:39:37', '2025-03-24 05:39:37'),
	(157, 612000.00, 'shopee_pay', '2025-03-24 05:44:28', '2025-03-24 05:44:28'),
	(158, 384000.00, 'shopee_pay', '2025-04-05 03:30:10', '2025-04-05 03:30:10'),
	(159, 336000.00, 'shopee_pay', '2025-04-05 03:40:14', '2025-04-05 03:40:14'),
	(160, 120000.00, 'cash', '2025-04-05 23:20:36', '2025-04-05 23:20:36'),
	(161, 144000.00, 'dana', '2025-04-05 23:31:34', '2025-04-05 23:31:34'),
	(162, 230000.00, 'cash', '2025-04-07 06:20:47', '2025-04-07 06:20:47'),
	(163, 23000.00, 'dana', '2025-04-07 06:31:10', '2025-04-07 06:31:10'),
	(164, 23000.00, 'dana', '2025-04-07 06:34:18', '2025-04-07 06:34:18'),
	(165, 23000.00, 'shopee_pay', '2025-04-07 06:37:34', '2025-04-07 06:37:34'),
	(166, 23000.00, 'shopee_pay', '2025-04-07 06:43:30', '2025-04-07 06:43:30'),
	(167, 23000.00, 'shopee_pay', '2025-04-07 06:45:49', '2025-04-07 06:45:49'),
	(168, 12000.00, 'shopee_pay', '2025-04-09 05:32:35', '2025-04-09 05:32:35'),
	(169, 12000.00, 'cash', '2025-04-09 05:53:42', '2025-04-09 05:53:42'),
	(170, 23000.00, 'dana', '2025-04-09 06:03:57', '2025-04-09 06:03:57'),
	(171, 299000.00, 'dana', '2025-04-09 06:14:14', '2025-04-09 06:14:14'),
	(172, 276000.00, 'cash', '2025-04-09 06:46:46', '2025-04-09 06:46:46'),
	(173, 24000.00, 'cash', '2025-04-09 06:52:23', '2025-04-09 06:52:23'),
	(174, 24000.00, 'shopee_pay', '2025-04-09 19:05:47', '2025-04-09 19:05:47'),
	(175, 96000.00, 'dana', '2025-04-10 06:04:01', '2025-04-10 06:04:01'),
	(176, 12000.00, 'cash', '2025-04-10 23:28:58', '2025-04-10 23:28:58'),
	(177, 12000.00, 'cash', '2025-04-10 23:31:59', '2025-04-10 23:31:59'),
	(178, 36000.00, 'cash', '2025-04-10 23:33:03', '2025-04-10 23:33:03'),
	(179, 24000.00, 'shopee_pay', '2025-04-15 09:18:45', '2025-04-15 09:18:45'),
	(180, 48000.00, 'cash', '2025-04-15 09:20:00', '2025-04-15 09:20:00'),
	(181, 24000.00, 'dana', '2025-04-16 18:39:22', '2025-04-16 18:39:22'),
	(182, 24000.00, 'shopee_pay', '2025-04-16 19:47:20', '2025-04-16 19:47:20'),
	(183, 24000.00, 'cash', '2025-04-16 20:20:24', '2025-04-16 20:20:24'),
	(184, 24000.00, 'dana', '2025-04-16 20:32:36', '2025-04-16 20:32:36'),
	(185, 24000.00, 'cash', '2025-04-16 20:38:07', '2025-04-16 20:38:07'),
	(186, 24000.00, 'shopee_pay', '2025-04-16 20:44:37', '2025-04-16 20:44:37'),
	(187, 24000.00, 'cash', '2025-04-16 20:47:17', '2025-04-16 20:47:17'),
	(188, 24000.00, 'shopee_pay', '2025-04-16 20:56:31', '2025-04-16 20:56:31'),
	(189, 12000.00, 'shopee_pay', '2025-04-16 21:06:48', '2025-04-16 21:06:48'),
	(190, 12000.00, 'shopee_pay', '2025-04-16 21:08:44', '2025-04-16 21:08:44'),
	(191, 12000.00, 'shopee_pay', '2025-04-16 21:08:59', '2025-04-16 21:08:59'),
	(192, 24000.00, 'dana', '2025-04-16 21:21:51', '2025-04-16 21:21:51'),
	(193, 24000.00, 'cash', '2025-04-16 21:25:34', '2025-04-16 21:25:34'),
	(194, 24000.00, 'shopee_pay', '2025-04-16 21:28:24', '2025-04-16 21:28:24'),
	(195, 24000.00, 'cash', '2025-04-16 21:41:38', '2025-04-16 21:41:38'),
	(196, 24000.00, 'shopee_pay', '2025-04-16 21:47:39', '2025-04-16 21:47:39'),
	(197, 24000.00, 'shopee_pay', '2025-04-16 21:48:03', '2025-04-16 21:48:03'),
	(198, 24000.00, 'shopee_pay', '2025-04-16 21:48:24', '2025-04-16 21:48:24'),
	(199, 24000.00, 'shopee_pay', '2025-04-16 21:53:31', '2025-04-16 21:53:31'),
	(200, 24000.00, 'dana', '2025-04-16 21:55:08', '2025-04-16 21:55:08'),
	(201, 24000.00, 'shopee_pay', '2025-04-16 21:58:41', '2025-04-16 21:58:41'),
	(202, 24000.00, 'shopee_pay', '2025-04-16 21:59:53', '2025-04-16 21:59:53'),
	(203, 24000.00, 'shopee_pay', '2025-04-16 22:04:46', '2025-04-16 22:04:46'),
	(204, 24000.00, 'shopee_pay', '2025-04-16 22:05:22', '2025-04-16 22:05:22'),
	(205, 24000.00, 'cash', '2025-04-16 22:15:38', '2025-04-16 22:15:38'),
	(206, 24000.00, 'cash', '2025-04-16 22:47:31', '2025-04-16 22:47:31'),
	(207, 804000.00, 'shopee_pay', '2025-04-16 22:55:02', '2025-04-16 22:55:02'),
	(208, 12000.00, 'cash', '2025-04-16 22:56:23', '2025-04-16 22:56:23'),
	(209, 24000.00, 'dana', '2025-04-16 23:04:31', '2025-04-16 23:04:31'),
	(210, 24000.00, 'cash', '2025-04-16 23:05:01', '2025-04-16 23:05:01'),
	(211, 36000.00, 'shopee_pay', '2025-04-16 23:05:56', '2025-04-16 23:05:56'),
	(212, 24000.00, 'cash', '2025-04-16 23:07:05', '2025-04-16 23:07:05'),
	(213, 24000.00, 'shopee_pay', '2025-04-16 23:07:42', '2025-04-16 23:07:42'),
	(214, 24000.00, 'cash', '2025-04-16 23:09:26', '2025-04-16 23:09:26'),
	(215, 24000.00, 'shopee_pay', '2025-04-16 23:14:38', '2025-04-16 23:14:38'),
	(216, 24000.00, 'dana', '2025-04-16 23:15:52', '2025-04-16 23:15:52'),
	(217, 24000.00, 'shopee_pay', '2025-04-16 23:21:13', '2025-04-16 23:21:13'),
	(218, 24000.00, 'shopee_pay', '2025-04-16 23:23:11', '2025-04-16 23:23:11'),
	(219, 24000.00, 'cash', '2025-04-16 23:37:04', '2025-04-16 23:37:04'),
	(220, 24000.00, 'shopee_pay', '2025-04-16 23:43:43', '2025-04-16 23:43:43'),
	(221, 24000.00, 'shopee_pay', '2025-04-16 23:50:03', '2025-04-16 23:50:03'),
	(222, 48000.00, 'shopee_pay', '2025-04-17 00:03:47', '2025-04-17 00:03:47'),
	(223, 24000.00, 'shopee_pay', '2025-04-17 00:48:23', '2025-04-17 00:48:23'),
	(224, 24000.00, 'shopee_pay', '2025-04-17 01:04:13', '2025-04-17 01:04:13'),
	(225, 24000.00, 'shopee_pay', '2025-04-17 01:23:23', '2025-04-17 01:23:23'),
	(226, 24000.00, 'shopee_pay', '2025-04-17 01:24:50', '2025-04-17 01:24:50'),
	(227, 24000.00, 'shopee_pay', '2025-04-17 01:26:58', '2025-04-17 01:26:58'),
	(228, 24000.00, 'shopee_pay', '2025-04-17 01:30:38', '2025-04-17 01:30:38'),
	(229, 24000.00, 'shopee_pay', '2025-04-17 01:38:18', '2025-04-17 01:38:18'),
	(230, 24000.00, 'shopee_pay', '2025-04-17 01:40:34', '2025-04-17 01:40:34'),
	(231, 24000.00, 'dana', '2025-04-17 01:51:07', '2025-04-17 01:51:07'),
	(232, 24000.00, 'shopee_pay', '2025-04-17 01:54:49', '2025-04-17 01:54:49'),
	(233, 24000.00, 'dana', '2025-04-17 01:56:03', '2025-04-17 01:56:03'),
	(234, 24000.00, 'shopee_pay', '2025-04-17 01:58:09', '2025-04-17 01:58:09'),
	(235, 24000.00, 'shopee_pay', '2025-04-17 02:09:20', '2025-04-17 02:09:20'),
	(236, 24000.00, 'shopee_pay', '2025-04-17 02:09:52', '2025-04-17 02:09:52'),
	(237, 24000.00, 'shopee_pay', '2025-04-17 02:18:38', '2025-04-17 02:18:38'),
	(238, 24000.00, 'shopee_pay', '2025-04-17 02:19:06', '2025-04-17 02:19:06'),
	(239, 24000.00, 'shopee_pay', '2025-04-17 02:23:45', '2025-04-17 02:23:45'),
	(240, 24000.00, 'shopee_pay', '2025-04-17 02:28:24', '2025-04-17 02:28:24'),
	(241, 24000.00, 'shopee_pay', '2025-04-17 02:31:42', '2025-04-17 02:31:42'),
	(242, 24000.00, 'shopee_pay', '2025-04-17 02:33:35', '2025-04-17 02:33:35'),
	(243, 24000.00, 'shopee_pay', '2025-04-17 02:34:20', '2025-04-17 02:34:20'),
	(244, 24000.00, 'shopee_pay', '2025-04-17 02:35:08', '2025-04-17 02:35:08'),
	(245, 24000.00, 'shopee_pay', '2025-04-17 02:35:46', '2025-04-17 02:35:46'),
	(246, 24000.00, 'dana', '2025-04-17 02:39:04', '2025-04-17 02:39:04'),
	(247, 24000.00, 'cash', '2025-04-17 02:39:25', '2025-04-17 02:39:25'),
	(248, 24000.00, 'cash', '2025-04-17 02:39:40', '2025-04-17 02:39:40'),
	(249, 24000.00, 'dana', '2025-04-17 04:29:55', '2025-04-17 04:29:55'),
	(250, 24000.00, 'shopee_pay', '2025-04-17 04:30:33', '2025-04-17 04:30:33'),
	(251, 24000.00, 'cash', '2025-04-17 04:33:20', '2025-04-17 04:33:20'),
	(252, 24000.00, 'shopee_pay', '2025-04-17 04:35:58', '2025-04-17 04:35:58'),
	(253, 24000.00, 'shopee_pay', '2025-04-17 04:37:29', '2025-04-17 04:37:29'),
	(254, 24000.00, 'shopee_pay', '2025-04-17 04:37:55', '2025-04-17 04:37:55'),
	(255, 24000.00, 'shopee_pay', '2025-04-17 04:38:24', '2025-04-17 04:38:24'),
	(256, 24000.00, 'shopee_pay', '2025-04-17 04:39:47', '2025-04-17 04:39:47'),
	(257, 24000.00, 'shopee_pay', '2025-04-17 04:41:31', '2025-04-17 04:41:31'),
	(258, 24000.00, 'shopee_pay', '2025-04-17 04:42:34', '2025-04-17 04:42:34'),
	(259, 12000.00, 'shopee_pay', '2025-04-17 04:46:46', '2025-04-17 04:46:46'),
	(260, 132000.00, 'dana', '2025-04-18 20:40:05', '2025-04-18 20:40:05'),
	(261, 24000.00, 'cash', '2025-04-19 14:29:56', '2025-04-19 14:29:56'),
	(262, 24000.00, 'shopee_pay', '2025-04-19 14:39:58', '2025-04-19 14:39:58'),
	(263, 24000.00, 'cash', '2025-04-19 14:41:48', '2025-04-19 14:41:48'),
	(264, 24000.00, 'shopee_pay', '2025-04-19 14:48:05', '2025-04-19 14:48:05'),
	(265, 24000.00, 'shopee_pay', '2025-04-19 14:50:19', '2025-04-19 14:50:19'),
	(266, 24000.00, 'shopee_pay', '2025-04-19 14:59:22', '2025-04-19 14:59:22'),
	(267, 24000.00, 'dana', '2025-04-19 15:01:55', '2025-04-19 15:01:55'),
	(268, 24000.00, 'cash', '2025-04-19 15:09:56', '2025-04-19 15:09:56'),
	(269, 24000.00, 'shopee_pay', '2025-04-19 15:11:32', '2025-04-19 15:11:32'),
	(270, 24000.00, 'shopee_pay', '2025-04-19 15:21:57', '2025-04-19 15:21:57'),
	(271, 24000.00, 'shopee_pay', '2025-04-19 15:26:43', '2025-04-19 15:26:43'),
	(272, 24000.00, 'dana', '2025-04-19 15:33:29', '2025-04-19 15:33:29'),
	(273, 24000.00, 'shopee_pay', '2025-04-19 21:08:14', '2025-04-19 21:08:14'),
	(274, 48000.00, 'shopee_pay', '2025-04-19 21:34:33', '2025-04-19 21:34:33'),
	(275, 24000.00, 'dana', '2025-04-19 21:35:39', '2025-04-19 21:35:39'),
	(276, 24000.00, 'dana', '2025-04-19 21:36:21', '2025-04-19 21:36:21'),
	(277, 24000.00, 'shopee_pay', '2025-04-19 21:37:06', '2025-04-19 21:37:06'),
	(278, 24000.00, 'shopee_pay', '2025-04-19 21:38:01', '2025-04-19 21:38:01'),
	(279, 24000.00, 'shopee_pay', '2025-04-19 22:12:49', '2025-04-19 22:12:49'),
	(280, 24000.00, 'shopee_pay', '2025-04-19 23:34:41', '2025-04-19 23:34:41'),
	(281, 24000.00, 'dana', '2025-04-19 23:37:40', '2025-04-19 23:37:40'),
	(282, 24000.00, 'cash', '2025-04-20 02:21:37', '2025-04-20 02:21:37'),
	(283, 24000.00, 'cash', '2025-04-20 02:22:42', '2025-04-20 02:22:42'),
	(284, 24000.00, 'shopee_pay', '2025-04-20 02:31:55', '2025-04-20 02:31:55'),
	(285, 24000.00, 'shopee_pay', '2025-04-20 02:34:03', '2025-04-20 02:34:03'),
	(286, 24000.00, 'cash', '2025-04-20 02:37:37', '2025-04-20 02:37:37'),
	(287, 24000.00, 'shopee_pay', '2025-04-20 03:16:49', '2025-04-20 03:16:49'),
	(288, 24000.00, 'shopee_pay', '2025-04-20 03:17:13', '2025-04-20 03:17:13'),
	(289, 24000.00, 'shopee_pay', '2025-04-20 03:19:28', '2025-04-20 03:19:28'),
	(290, 24000.00, 'shopee_pay', '2025-04-20 03:20:43', '2025-04-20 03:20:43'),
	(291, 24000.00, 'cash', '2025-04-20 03:21:59', '2025-04-20 03:21:59'),
	(292, 24000.00, 'shopee_pay', '2025-04-20 03:30:18', '2025-04-20 03:30:18'),
	(293, 72000.00, 'dana', '2025-04-20 03:34:52', '2025-04-20 03:34:52'),
	(294, 36000.00, 'shopee_pay', '2025-04-20 03:36:10', '2025-04-20 03:36:10'),
	(295, 24000.00, 'shopee_pay', '2025-04-20 03:43:56', '2025-04-20 03:43:56'),
	(296, 24000.00, 'shopee_pay', '2025-04-20 03:45:37', '2025-04-20 03:45:37'),
	(297, 24000.00, 'shopee_pay', '2025-04-20 03:51:34', '2025-04-20 03:51:34'),
	(298, 24000.00, 'dana', '2025-04-20 08:04:20', '2025-04-20 08:04:20'),
	(299, 24000.00, 'cash', '2025-04-20 08:08:31', '2025-04-20 08:08:31'),
	(300, 36000.00, 'cash', '2025-04-20 08:16:02', '2025-04-20 08:16:02'),
	(301, 48000.00, 'shopee_pay', '2025-04-20 08:23:15', '2025-04-20 08:23:15'),
	(302, 48000.00, 'cash', '2025-04-20 08:24:12', '2025-04-20 08:24:12'),
	(303, 48000.00, 'shopee_pay', '2025-04-20 08:27:31', '2025-04-20 08:27:31'),
	(304, 48000.00, 'dana', '2025-04-20 08:28:36', '2025-04-20 08:28:36'),
	(305, 24000.00, 'dana', '2025-04-20 08:31:23', '2025-04-20 08:31:23'),
	(306, 24000.00, 'shopee_pay', '2025-04-20 08:31:56', '2025-04-20 08:31:56'),
	(307, 48000.00, 'dana', '2025-04-20 08:48:50', '2025-04-20 08:48:50'),
	(308, 48000.00, 'cash', '2025-04-20 08:49:15', '2025-04-20 08:49:15'),
	(309, 142000.00, 'cash', '2025-04-20 08:51:15', '2025-04-20 08:51:15'),
	(310, 142000.00, 'shopee_pay', '2025-04-20 08:52:16', '2025-04-20 08:52:16'),
	(311, 142000.00, 'shopee_pay', '2025-04-20 08:54:03', '2025-04-20 08:54:03'),
	(312, 142000.00, 'shopee_pay', '2025-04-20 09:03:45', '2025-04-20 09:03:45'),
	(313, 142000.00, 'cash', '2025-04-20 09:05:29', '2025-04-20 09:05:29'),
	(314, 118000.00, 'dana', '2025-04-20 09:11:36', '2025-04-20 09:11:36'),
	(315, 72000.00, 'cash', '2025-04-20 09:12:44', '2025-04-20 09:12:44'),
	(316, 72000.00, 'shopee_pay', '2025-04-20 09:14:38', '2025-04-20 09:14:38'),
	(317, 264000.00, 'cash', '2025-04-20 09:58:17', '2025-04-20 09:58:17'),
	(318, 36000.00, 'shopee_pay', '2025-04-20 19:52:46', '2025-04-20 19:52:46'),
	(319, 24000.00, 'cash', '2025-04-20 19:55:44', '2025-04-20 19:55:44'),
	(320, 24000.00, 'dana', '2025-04-20 19:56:23', '2025-04-20 19:56:23'),
	(321, 72000.00, 'shopee_pay', '2025-04-20 19:59:02', '2025-04-20 19:59:02'),
	(322, 24000.00, 'shopee_pay', '2025-04-20 20:00:13', '2025-04-20 20:00:13'),
	(323, 24000.00, 'shopee_pay', '2025-04-20 20:04:20', '2025-04-20 20:04:20'),
	(324, 363000.00, 'shopee_pay', '2025-04-20 20:07:14', '2025-04-20 20:07:14'),
	(325, 156000.00, 'shopee_pay', '2025-04-21 20:58:50', '2025-04-21 20:58:50'),
	(326, 249000.00, 'dana', '2025-04-21 22:24:34', '2025-04-21 22:24:34'),
	(327, 896000.00, 'shopee_pay', '2025-04-21 22:25:24', '2025-04-21 22:25:24'),
	(328, 100000.00, 'shopee_pay', '2025-04-21 22:25:57', '2025-04-21 22:25:57'),
	(329, 158000.00, 'dana', '2025-04-21 22:46:55', '2025-04-21 22:46:55'),
	(330, 12000.00, 'shopee_pay', '2025-04-21 22:48:18', '2025-04-21 22:48:18'),
	(331, 12000.00, 'shopee_pay', '2025-04-21 22:49:10', '2025-04-21 22:49:10'),
	(332, 24000.00, 'cash', '2025-04-23 11:16:39', '2025-04-23 11:16:39'),
	(333, 12000.00, 'shopee_pay', '2025-04-23 11:24:25', '2025-04-23 11:24:25'),
	(334, 36000.00, 'shopee_pay', '2025-04-23 11:29:16', '2025-04-23 11:29:16'),
	(335, 56000.00, 'shopee_pay', '2025-04-23 11:30:34', '2025-04-23 11:30:34'),
	(336, 99000.00, 'cash', '2025-04-23 11:33:56', '2025-04-23 11:33:56'),
	(337, 12000.00, 'cash', '2025-04-23 11:34:52', '2025-04-23 11:34:52'),
	(338, 48000.00, 'shopee_pay', '2025-04-23 11:36:46', '2025-04-23 11:36:46'),
	(339, 24000.00, 'cash', '2025-04-23 11:37:37', '2025-04-23 11:37:37'),
	(340, 12000.00, 'cash', '2025-04-23 11:38:40', '2025-04-23 11:38:40'),
	(341, 71000.00, 'cash', '2025-04-23 11:45:00', '2025-04-23 11:45:00'),
	(342, 36000.00, 'cash', '2025-04-23 11:46:07', '2025-04-23 11:46:07'),
	(343, 178000.00, 'cash', '2025-04-23 11:46:50', '2025-04-23 11:46:50'),
	(344, 24000.00, 'cash', '2025-04-23 11:52:47', '2025-04-23 11:52:47'),
	(345, 136000.00, 'shopee_pay', '2025-04-23 11:53:59', '2025-04-23 11:53:59'),
	(346, 12000.00, 'shopee_pay', '2025-04-24 03:42:20', '2025-04-24 03:42:20'),
	(347, 24000.00, 'dana', '2025-04-24 03:43:10', '2025-04-24 03:43:10'),
	(348, 36000.00, 'shopee_pay', '2025-04-24 17:18:48', '2025-04-24 17:18:48'),
	(349, 36000.00, 'cash', '2025-04-24 17:19:55', '2025-04-24 17:19:55'),
	(350, 111000.00, 'cash', '2025-04-24 17:20:46', '2025-04-24 17:20:46'),
	(351, 146000.00, 'cash', '2025-04-24 17:36:50', '2025-04-24 17:36:50'),
	(352, 48000.00, 'cash', '2025-04-25 03:20:25', '2025-04-25 03:20:25'),
	(353, 12000.00, 'shopee_pay', '2025-04-25 23:09:51', '2025-04-25 23:09:51'),
	(354, 12000.00, 'shopee_pay', '2025-04-25 23:11:07', '2025-04-25 23:11:07'),
	(355, 24000.00, 'cash', '2025-04-25 23:12:05', '2025-04-25 23:12:05'),
	(356, 144000.00, 'dana', '2025-04-27 03:37:57', '2025-04-27 03:37:57'),
	(357, 12000.00, 'cash', '2025-04-27 19:34:28', '2025-04-27 19:34:28'),
	(358, 36000.00, 'shopee_pay', '2025-04-27 19:39:03', '2025-04-27 19:39:03'),
	(359, 12000.00, 'cash', '2025-04-27 20:04:03', '2025-04-27 20:04:03'),
	(360, 444000.00, 'cash', '2025-04-27 20:15:13', '2025-04-27 20:15:13'),
	(361, 48000.00, 'shopee_pay', '2025-04-27 20:15:52', '2025-04-27 20:15:52'),
	(362, 12000.00, 'shopee_pay', '2025-04-27 21:18:25', '2025-04-27 21:18:25'),
	(363, 110000.00, 'cash', '2025-04-27 21:35:37', '2025-04-27 21:35:37'),
	(364, 77000.00, 'shopee_pay', '2025-04-27 21:43:06', '2025-04-27 21:43:06'),
	(365, 132000.00, 'shopee_pay', '2025-04-27 21:44:44', '2025-04-27 21:44:44'),
	(366, 8100000.00, 'shopee_pay', '2025-04-28 17:59:05', '2025-04-28 17:59:05'),
	(367, 300000.00, 'cash', '2025-04-29 00:12:08', '2025-04-29 00:12:08'),
	(368, 300000.00, 'cash', '2025-04-29 00:12:45', '2025-04-29 00:12:45'),
	(369, 300000.00, 'cash', '2025-04-29 00:13:42', '2025-04-29 00:13:42'),
	(370, 4500000.00, 'dana', '2025-04-29 02:37:31', '2025-04-29 02:37:31'),
	(371, 900000.00, 'cash', '2025-04-29 18:23:20', '2025-04-29 18:23:20'),
	(372, 600000.00, 'cash', '2025-04-29 18:43:43', '2025-04-29 18:43:43'),
	(373, 600000.00, 'dana', '2025-04-29 19:02:57', '2025-04-29 19:02:57'),
	(374, 300000.00, 'cash', '2025-04-29 19:28:13', '2025-04-29 19:28:13'),
	(375, 900000.00, 'shopee_pay', '2025-04-29 19:29:36', '2025-04-29 19:29:36'),
	(376, 900000.00, 'dana', '2025-04-29 19:47:25', '2025-04-29 19:47:25'),
	(377, 17400000.00, 'shopee_pay', '2025-04-29 19:49:44', '2025-04-29 19:49:44'),
	(378, 900000.00, 'shopee_pay', '2025-04-29 19:50:39', '2025-04-29 19:50:39'),
	(379, 300000.00, 'cash', '2025-04-29 20:34:44', '2025-04-29 20:34:44'),
	(380, 900000.00, 'cash', '2025-04-29 20:35:51', '2025-04-29 20:35:51'),
	(381, 600000.00, 'cash', '2025-04-29 20:42:06', '2025-04-29 20:42:06'),
	(382, 300000.00, 'cash', '2025-04-29 20:45:54', '2025-04-29 20:45:54'),
	(383, 600000.00, 'shopee_pay', '2025-05-13 18:07:13', '2025-05-13 18:07:13'),
	(384, 3600000.00, 'dana', '2025-05-14 08:21:45', '2025-05-14 08:21:45'),
	(385, 900000.00, 'cash', '2025-05-14 08:53:52', '2025-05-14 08:53:52'),
	(386, 900000.00, 'shopee_pay', '2025-05-14 08:58:00', '2025-05-14 08:58:00'),
	(387, 900000.00, 'shopee_pay', '2025-05-14 08:58:34', '2025-05-14 08:58:34'),
	(388, 9600000.00, 'shopee_pay', '2025-05-14 08:59:22', '2025-05-14 08:59:22'),
	(389, 300000.00, 'shopee_pay', '2025-05-14 09:00:12', '2025-05-14 09:00:12'),
	(390, 900000.00, 'shopee_pay', '2025-05-14 09:04:47', '2025-05-14 09:04:47'),
	(391, 300000.00, 'cash', '2025-05-14 09:05:06', '2025-05-14 09:05:06'),
	(392, 600000.00, 'dana', '2025-05-14 09:05:32', '2025-05-14 09:05:32'),
	(393, 2700000.00, 'cash', '2025-05-21 18:54:19', '2025-05-21 18:54:19'),
	(394, 4800000.00, 'shopee_pay', '2025-05-29 03:00:14', '2025-05-29 03:00:14'),
	(395, 33000000.00, 'shopee_pay', '2025-05-30 17:31:19', '2025-05-30 17:31:19'),
	(396, 300000.00, 'shopee_pay', '2025-05-30 17:32:46', '2025-05-30 17:32:46'),
	(397, 600000.00, 'shopee_pay', '2025-05-30 17:33:34', '2025-05-30 17:33:34'),
	(398, 610000.00, 'cash', '2025-05-31 05:15:28', '2025-05-31 05:15:28'),
	(399, 110000.00, 'shopee_pay', '2025-05-31 06:12:41', '2025-05-31 06:12:41'),
	(400, 540000.00, 'dana', '2025-05-31 23:46:12', '2025-05-31 23:46:12'),
	(401, 10000.00, 'gopay', '2025-06-01 00:18:54', '2025-06-01 00:18:54'),
	(402, 10000.00, 'shopee_pay', '2025-06-01 00:19:16', '2025-06-01 00:19:16'),
	(403, 10000.00, 'dana', '2025-06-01 00:21:07', '2025-06-01 00:21:07'),
	(404, 10000.00, 'cash', '2025-06-01 00:21:30', '2025-06-01 00:21:30'),
	(405, 10000.00, 'gopay', '2025-06-01 00:23:58', '2025-06-01 00:23:58'),
	(406, 10000.00, 'gopay', '2025-06-01 00:52:23', '2025-06-01 00:52:23'),
	(407, 70000.00, 'shopee_pay', '2025-06-01 06:54:36', '2025-06-01 06:54:36'),
	(408, 10000.00, 'dana', '2025-06-04 17:57:25', '2025-06-04 17:57:25'),
	(409, 10000.00, 'dana', '2025-06-04 17:58:09', '2025-06-04 17:58:09'),
	(410, 20000.00, 'shopee_pay', '2025-06-08 19:44:16', '2025-06-08 19:44:16'),
	(411, 10000.00, 'shopee_pay', '2025-06-09 17:34:59', '2025-06-09 17:34:59'),
	(412, 15000.00, 'shopee_pay', '2025-06-09 19:27:01', '2025-06-09 19:27:01'),
	(413, 30000.00, 'dana', '2025-06-09 21:27:51', '2025-06-09 21:27:51'),
	(414, 55000.00, 'shopee_pay', '2025-06-12 15:45:15', '2025-06-12 15:45:15'),
	(415, 10000.00, 'shopee_pay', '2025-06-12 15:57:54', '2025-06-12 15:57:54'),
	(416, 15000.00, 'shopee_pay', '2025-06-12 23:03:05', '2025-06-12 23:03:05');

-- Dumping structure for table tobapos_db.transaction_items
CREATE TABLE IF NOT EXISTS `transaction_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_items_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_items_product_id_foreign` (`product_id`),
  CONSTRAINT `transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.transaction_items: ~79 rows (approximately)
INSERT INTO `transaction_items` (`id`, `transaction_id`, `quantity`, `price`, `size`, `created_at`, `updated_at`, `product_id`, `category`) VALUES
	(10, 366, 7, 300000.00, NULL, '2025-04-28 17:59:05', '2025-04-28 17:59:05', 19, NULL),
	(11, 367, 1, 300000.00, NULL, '2025-04-29 00:12:08', '2025-04-29 00:12:08', 20, NULL),
	(12, 368, 1, 300000.00, NULL, '2025-04-29 00:12:45', '2025-04-29 00:12:45', 20, NULL),
	(13, 369, 1, 300000.00, NULL, '2025-04-29 00:13:42', '2025-04-29 00:13:42', 20, NULL),
	(15, 371, 1, 300000.00, NULL, '2025-04-29 18:23:20', '2025-04-29 18:23:20', 21, NULL),
	(16, 371, 1, 300000.00, NULL, '2025-04-29 18:23:20', '2025-04-29 18:23:20', 20, NULL),
	(17, 371, 1, 300000.00, NULL, '2025-04-29 18:23:20', '2025-04-29 18:23:20', 19, NULL),
	(18, 372, 1, 300000.00, NULL, '2025-04-29 18:43:43', '2025-04-29 18:43:43', 21, NULL),
	(19, 372, 1, 300000.00, NULL, '2025-04-29 18:43:43', '2025-04-29 18:43:43', 20, NULL),
	(20, 373, 2, 300000.00, NULL, '2025-04-29 19:02:57', '2025-04-29 19:02:57', 19, NULL),
	(21, 374, 1, 300000.00, NULL, '2025-04-29 19:28:13', '2025-04-29 19:28:13', 21, NULL),
	(22, 375, 1, 300000.00, NULL, '2025-04-29 19:29:36', '2025-04-29 19:29:36', 21, NULL),
	(23, 375, 1, 300000.00, NULL, '2025-04-29 19:29:36', '2025-04-29 19:29:36', 20, NULL),
	(24, 375, 1, 300000.00, NULL, '2025-04-29 19:29:36', '2025-04-29 19:29:36', 19, NULL),
	(25, 376, 1, 300000.00, NULL, '2025-04-29 19:47:25', '2025-04-29 19:47:25', 19, NULL),
	(26, 376, 2, 300000.00, NULL, '2025-04-29 19:47:25', '2025-04-29 19:47:25', 20, NULL),
	(27, 377, 43, 300000.00, NULL, '2025-04-29 19:49:44', '2025-04-29 19:49:44', 19, NULL),
	(28, 377, 15, 300000.00, NULL, '2025-04-29 19:49:44', '2025-04-29 19:49:44', 20, NULL),
	(29, 378, 1, 300000.00, NULL, '2025-04-29 19:50:39', '2025-04-29 19:50:39', 21, NULL),
	(30, 378, 1, 300000.00, NULL, '2025-04-29 19:50:39', '2025-04-29 19:50:39', 20, NULL),
	(31, 378, 1, 300000.00, NULL, '2025-04-29 19:50:39', '2025-04-29 19:50:39', 19, NULL),
	(32, 379, 1, 300000.00, NULL, '2025-04-29 20:34:44', '2025-04-29 20:34:44', 21, NULL),
	(33, 380, 1, 300000.00, NULL, '2025-04-29 20:35:51', '2025-04-29 20:35:51', 21, NULL),
	(34, 380, 1, 300000.00, NULL, '2025-04-29 20:35:51', '2025-04-29 20:35:51', 20, NULL),
	(35, 380, 1, 300000.00, NULL, '2025-04-29 20:35:51', '2025-04-29 20:35:51', 19, NULL),
	(36, 381, 2, 300000.00, NULL, '2025-04-29 20:42:07', '2025-04-29 20:42:07', 21, NULL),
	(37, 382, 1, 300000.00, NULL, '2025-04-29 20:45:54', '2025-04-29 20:45:54', 21, NULL),
	(38, 383, 2, 300000.00, NULL, '2025-05-13 18:07:13', '2025-05-13 18:07:13', 21, NULL),
	(39, 384, 12, 300000.00, NULL, '2025-05-14 08:21:45', '2025-05-14 08:21:45', 21, NULL),
	(40, 385, 1, 300000.00, NULL, '2025-05-14 08:53:52', '2025-05-14 08:53:52', 21, NULL),
	(41, 385, 1, 300000.00, NULL, '2025-05-14 08:53:52', '2025-05-14 08:53:52', 20, NULL),
	(42, 385, 1, 300000.00, NULL, '2025-05-14 08:53:52', '2025-05-14 08:53:52', 19, NULL),
	(43, 386, 1, 300000.00, NULL, '2025-05-14 08:58:00', '2025-05-14 08:58:00', 21, NULL),
	(44, 386, 1, 300000.00, NULL, '2025-05-14 08:58:00', '2025-05-14 08:58:00', 20, NULL),
	(45, 386, 1, 300000.00, NULL, '2025-05-14 08:58:00', '2025-05-14 08:58:00', 19, NULL),
	(46, 387, 1, 300000.00, NULL, '2025-05-14 08:58:34', '2025-05-14 08:58:34', 21, NULL),
	(47, 387, 1, 300000.00, NULL, '2025-05-14 08:58:34', '2025-05-14 08:58:34', 20, NULL),
	(48, 387, 1, 300000.00, NULL, '2025-05-14 08:58:34', '2025-05-14 08:58:34', 19, NULL),
	(49, 388, 1, 300000.00, NULL, '2025-05-14 08:59:22', '2025-05-14 08:59:22', 21, NULL),
	(50, 388, 1, 300000.00, NULL, '2025-05-14 08:59:22', '2025-05-14 08:59:22', 20, NULL),
	(51, 388, 30, 300000.00, NULL, '2025-05-14 08:59:22', '2025-05-14 08:59:22', 19, NULL),
	(52, 389, 1, 300000.00, NULL, '2025-05-14 09:00:12', '2025-05-14 09:00:12', 21, NULL),
	(53, 390, 1, 300000.00, NULL, '2025-05-14 09:04:47', '2025-05-14 09:04:47', 21, NULL),
	(54, 390, 1, 300000.00, NULL, '2025-05-14 09:04:47', '2025-05-14 09:04:47', 20, NULL),
	(55, 390, 1, 300000.00, NULL, '2025-05-14 09:04:47', '2025-05-14 09:04:47', 19, NULL),
	(56, 391, 1, 300000.00, NULL, '2025-05-14 09:05:06', '2025-05-14 09:05:06', 21, NULL),
	(57, 392, 1, 300000.00, NULL, '2025-05-14 09:05:32', '2025-05-14 09:05:32', 20, NULL),
	(58, 392, 1, 300000.00, NULL, '2025-05-14 09:05:32', '2025-05-14 09:05:32', 19, NULL),
	(59, 393, 9, 300000.00, NULL, '2025-05-21 18:54:19', '2025-05-21 18:54:19', 21, NULL),
	(60, 394, 16, 300000.00, NULL, '2025-05-29 03:00:14', '2025-05-29 03:00:14', 21, NULL),
	(61, 395, 110, 300000.00, NULL, '2025-05-30 17:31:19', '2025-05-30 17:31:19', 20, NULL),
	(62, 396, 1, 300000.00, NULL, '2025-05-30 17:32:46', '2025-05-30 17:32:46', 20, NULL),
	(63, 397, 2, 300000.00, NULL, '2025-05-30 17:33:34', '2025-05-30 17:33:34', 20, NULL),
	(64, 398, 1, 10000.00, NULL, '2025-05-31 05:15:28', '2025-05-31 05:15:28', 22, NULL),
	(65, 398, 1, 300000.00, NULL, '2025-05-31 05:15:28', '2025-05-31 05:15:28', 20, NULL),
	(66, 398, 1, 300000.00, NULL, '2025-05-31 05:15:28', '2025-05-31 05:15:28', 19, NULL),
	(67, 399, 11, 10000.00, NULL, '2025-05-31 06:12:41', '2025-05-31 06:12:41', 22, NULL),
	(68, 400, 12, 10000.00, NULL, '2025-05-31 23:46:13', '2025-05-31 23:46:13', 27, NULL),
	(69, 400, 12, 10000.00, NULL, '2025-05-31 23:46:13', '2025-05-31 23:46:13', 23, NULL),
	(70, 400, 1, 300000.00, NULL, '2025-05-31 23:46:13', '2025-05-31 23:46:13', 19, NULL),
	(71, 401, 1, 10000.00, NULL, '2025-06-01 00:18:54', '2025-06-01 00:18:54', 27, NULL),
	(72, 402, 1, 10000.00, NULL, '2025-06-01 00:19:16', '2025-06-01 00:19:16', 27, NULL),
	(73, 403, 1, 10000.00, NULL, '2025-06-01 00:21:07', '2025-06-01 00:21:07', 27, NULL),
	(74, 404, 1, 10000.00, NULL, '2025-06-01 00:21:30', '2025-06-01 00:21:30', 27, NULL),
	(75, 405, 1, 10000.00, NULL, '2025-06-01 00:23:58', '2025-06-01 00:23:58', 26, NULL),
	(76, 406, 1, 10000.00, NULL, '2025-06-01 00:52:23', '2025-06-01 00:52:23', 26, NULL),
	(77, 407, 1, 10000.00, NULL, '2025-06-01 06:54:36', '2025-06-01 06:54:36', 26, NULL),
	(78, 407, 6, 10000.00, NULL, '2025-06-01 06:54:37', '2025-06-01 06:54:37', 27, NULL),
	(79, 408, 1, 10000.00, NULL, '2025-06-04 17:57:25', '2025-06-04 17:57:25', 23, NULL),
	(80, 409, 1, 10000.00, NULL, '2025-06-04 17:58:09', '2025-06-04 17:58:09', 27, NULL),
	(81, 410, 1, 10000.00, NULL, '2025-06-08 19:44:16', '2025-06-08 19:44:16', 23, NULL),
	(82, 410, 1, 10000.00, NULL, '2025-06-08 19:44:16', '2025-06-08 19:44:16', 24, NULL),
	(83, 411, 1, 10000.00, NULL, '2025-06-09 17:34:59', '2025-06-09 17:34:59', 27, NULL),
	(84, 412, 1, 15000.00, NULL, '2025-06-09 19:27:01', '2025-06-09 19:27:01', 28, NULL),
	(85, 413, 2, 15000.00, NULL, '2025-06-09 21:27:51', '2025-06-09 21:27:51', 28, NULL),
	(86, 414, 1, 10000.00, NULL, '2025-06-12 15:45:15', '2025-06-12 15:45:15', 27, NULL),
	(87, 414, 3, 15000.00, NULL, '2025-06-12 15:45:15', '2025-06-12 15:45:15', 28, NULL),
	(88, 415, 1, 10000.00, NULL, '2025-06-12 15:57:54', '2025-06-12 15:57:54', 27, NULL),
	(89, 416, 1, 15000.00, NULL, '2025-06-12 23:03:05', '2025-06-12 23:03:05', 28, NULL);

-- Dumping structure for table tobapos_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tobapos_db.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$SYXeRBSe9qXeNaReycA.zenzXy/xh46xDPnVPu7i8UXkP0OBpVxRC', NULL, '2025-02-04 00:13:28', '2025-05-30 00:15:18'),
	(2, 'addmin', 'addmin@gmail.com', NULL, '$2y$12$sBIfqo2Uw28p.oONu9xbpeiPMNjbtCt/sv6SI/yMRocLPlIZTkDji', NULL, '2025-03-24 02:59:29', '2025-03-24 02:59:29'),
	(3, 'naufal', 'naufalabdulmalik123@gmail.com', NULL, '$2y$12$LMMZzmCpJvrUd4cQs2N.Uuqv4TelQbOLU/om13MJPKEZpd9QYTvpi', 'K9o4NdNqART8DstT8yZhBCNGsydWgWwfCGSRN1nNPfc2YHlvKBiQUezEQlVI', '2025-04-25 16:58:51', '2025-04-28 17:57:13'),
	(4, 'naufal', 'mnaufalmalik123@gmail.com', NULL, '$2y$12$NoB9VT3yesav0eHg7q5A0utgmgKPUDtxUioUkjKaYIzzb4knPbQW6', 'jI1iCfaK2PlFiB7NZEHWCmfRuoTDPYDMlj7zPhoLVZxWPtnEAIyofXHApgVu', '2025-04-25 17:12:06', '2025-04-26 19:39:20');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
