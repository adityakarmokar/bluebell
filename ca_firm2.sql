-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 10:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ca_firm2`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `about_us` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `about_us`, `created_at`, `updated_at`) VALUES
(1, '[{\"title\":\"test\",\"paragraph\":\"test\"}]', '2025-02-17 14:58:52', '2025-02-17 14:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` bigint(20) UNSIGNED DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role`, `fullname`, `mobile`, `email`, `password`, `image`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 100, 'Mohd Kurban Ali', '9811461935', 'tushar@corewave.io', '$2y$10$Krr7heacbsJk3MevmHdb7Odr7aKkAkDzkKkbAul/GeqAI1Ofo9g.y', NULL, NULL, NULL, '2025-02-15 15:02:53', '2025-02-15 15:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `email`, `phone`, `whatsapp`, `created_at`, `updated_at`) VALUES
(1, 'test@example.com', '1234567890', '1234567890', '2025-02-17 10:28:18', '2025-02-17 10:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2014_10_12_000000_create_users_table', 1),
(22, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(25, '2024_10_28_094235_create_admins_table', 1),
(26, '2024_10_28_114357_create_user_bank_account_details_table', 1),
(27, '2024_10_29_084504_create_user_documents_table', 1),
(28, '2024_11_04_063908_create_services_table', 1),
(29, '2024_11_04_070516_create_service_documents_table', 1),
(30, '2024_11_04_120735_create_tokens_table', 1),
(31, '2024_11_06_141350_create_token_documents_table', 1),
(32, '2024_12_04_185529_create_about_us_table', 1),
(33, '2024_12_10_130229_create_contact_us_table', 1),
(34, '2024_12_10_132220_create_privacy_policies_table', 1),
(35, '2024_12_10_152028_create_terms_and_conditions_table', 1),
(36, '2024_12_11_173312_create_token_statuses_table', 1),
(37, '2024_12_18_144052_create_teams_table', 1),
(38, '2024_12_18_175628_create_permissions_table', 1),
(39, '2024_12_20_144854_create_user_addresses_table', 1),
(40, '2024_12_31_120306_create_payments_table', 1),
(41, '2025_02_18_183735_create_notifications_table', 2),
(42, '2025_03_20_151549_add_details_to_tokens', 3),
(43, '2025_03_21_140907_add_details_to_payments', 4),
(44, '2025_03_21_145412_add_details_to_services', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `token_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL COMMENT 'By Online, By Cash',
  `order_id` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `gateway_response` longtext DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `refund_status` varchar(255) NOT NULL DEFAULT 'not_requested',
  `refund_date` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `token_id`, `payment_type`, `order_id`, `transaction_id`, `payment_method`, `currency`, `amount`, `status`, `gateway_response`, `payment_date`, `refund_status`, `refund_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 22, 4, 'By Online', 'receipt_123', 'txn_00000000000002', 'UPI', 'INR', '5000', '1', NULL, '2025-03-21 08:47:44', 'not_requested', NULL, NULL, '2025-03-21 09:00:37', '2025-03-21 09:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dashboard2` tinyint(4) NOT NULL DEFAULT 0,
  `search_client` tinyint(4) NOT NULL DEFAULT 0,
  `services` tinyint(4) NOT NULL DEFAULT 0,
  `search_token` tinyint(4) NOT NULL DEFAULT 0,
  `payments` tinyint(4) NOT NULL DEFAULT 0,
  `reports` tinyint(4) NOT NULL DEFAULT 0,
  `announcements` tinyint(4) NOT NULL DEFAULT 0,
  `team_users` tinyint(4) NOT NULL DEFAULT 0,
  `cms` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `team_id`, `dashboard2`, `search_client`, `services`, `search_token`, `payments`, `reports`, `announcements`, `team_users`, `cms`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 0, NULL, '2025-02-17 12:40:23', '2025-03-21 07:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'WebToken', '04e51f3fef5f86093dec983fad2bf36a31de11604e3528a7ae02ee6c8f7801d6', '[\"*\"]', NULL, NULL, '2025-02-15 15:11:02', '2025-02-15 15:11:02'),
(2, 'App\\Models\\User', 1, 'WebToken', '0d0607574bdd55c6d4fde3d3c92e6db9a6cf22a1d8c75cdf65bc00745005ea02', '[\"*\"]', NULL, NULL, '2025-02-15 15:11:41', '2025-02-15 15:11:41'),
(3, 'App\\Models\\User', 1, 'WebToken', 'c37e201524de17521f8f8bbb9cad68516a4bbb987df275e36a0e148d9d7a0b7f', '[\"*\"]', NULL, NULL, '2025-02-15 15:12:24', '2025-02-15 15:12:24'),
(4, 'App\\Models\\User', 3, 'WebToken', 'f6be3d34ad321aabaa2f52b20ba212059ef2708fd72caa320705bc8926ef8cf7', '[\"*\"]', NULL, NULL, '2025-02-15 15:30:39', '2025-02-15 15:30:39'),
(5, 'App\\Models\\User', 3, 'WebToken', '9a525aff0124d66f954b7f5af2dd21e732e4c5d7ee90845885c5096120c2cc5e', '[\"*\"]', NULL, NULL, '2025-02-15 15:30:42', '2025-02-15 15:30:42'),
(6, 'App\\Models\\User', 4, 'WebToken', 'c567ad92e644492820f8d188496048b62e5c75dfed73e69de74fe97b05f1ee62', '[\"*\"]', NULL, NULL, '2025-02-15 15:58:27', '2025-02-15 15:58:27'),
(7, 'App\\Models\\User', 4, 'WebToken', 'd424f4bf07f2e744144ac5f9ad97e04fa09deb0a6e3bb95c5af9f87e1d659362', '[\"*\"]', NULL, NULL, '2025-02-15 15:58:33', '2025-02-15 15:58:33'),
(8, 'App\\Models\\User', 4, 'WebToken', '0e8b24386991812b789eac51741d88f447e28054d3e9e4764974645b84c67ca4', '[\"*\"]', NULL, NULL, '2025-02-15 15:58:40', '2025-02-15 15:58:40'),
(9, 'App\\Models\\User', 5, 'WebToken', 'a75385df3560b207e6b68ff9e95b458818defb7b50adb02a07bab44ca74107b3', '[\"*\"]', NULL, NULL, '2025-02-15 16:05:56', '2025-02-15 16:05:56'),
(10, 'App\\Models\\User', 5, 'WebToken', 'f8565480fe59a01e9cc0ea7964384331ba3242f47fc2ce22f3bddb1323fc0b74', '[\"*\"]', NULL, NULL, '2025-02-15 16:06:04', '2025-02-15 16:06:04'),
(11, 'App\\Models\\User', 5, 'WebToken', '29552dca1ba8c6d56355cb75a2e53e051a72f9c5d95071a5d838e97dddcb4d61', '[\"*\"]', NULL, NULL, '2025-02-15 16:06:18', '2025-02-15 16:06:18'),
(12, 'App\\Models\\User', 6, 'WebToken', '2d1df8e32fd162ed283dd5cb152c0c9fedf3865560e1303817f09493f4db8a32', '[\"*\"]', NULL, NULL, '2025-02-15 16:11:42', '2025-02-15 16:11:42'),
(13, 'App\\Models\\User', 6, 'WebToken', '19fad59bb6a2f7224ba6d5451357278a0b7dc4e7fc7fe5885373521af0fd2411', '[\"*\"]', NULL, NULL, '2025-02-15 16:11:48', '2025-02-15 16:11:48'),
(14, 'App\\Models\\User', 6, 'WebToken', 'c88685baa3617c2f37cb5e282f6a9a8b58c574667dab80d74864fd6f5b8ef640', '[\"*\"]', NULL, NULL, '2025-02-15 16:11:52', '2025-02-15 16:11:52'),
(15, 'App\\Models\\User', 7, 'WebToken', 'fda3e7a1f7afef18d5c5c4e62f322f67f941c9f1c8b3b9657ab435a0422e8694', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:23', '2025-02-15 16:16:23'),
(16, 'App\\Models\\User', 7, 'WebToken', '30608798ef9d48b2399adc8381d80b22df7d2ac1280066e7b0ca92a53b4e3cc9', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:26', '2025-02-15 16:16:26'),
(17, 'App\\Models\\User', 7, 'WebToken', '47d8486fd6b63c48fa3daf5fbfe796839af083b20c9a4907c63ff8c2bd94a032', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:26', '2025-02-15 16:16:26'),
(18, 'App\\Models\\User', 7, 'WebToken', '3a1a088fee88dea967dc800eca3042cc1efa8e0d24a9f8f8be4ab1935b5a393e', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:27', '2025-02-15 16:16:27'),
(19, 'App\\Models\\User', 7, 'WebToken', 'd119a1f2267335a27b9254e77d162086f023f66d61b13a81585584b6c265c446', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:28', '2025-02-15 16:16:28'),
(20, 'App\\Models\\User', 7, 'WebToken', '00bcd175283992eee4867405064f709016a7c73200cc14c94de80260281f3656', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:28', '2025-02-15 16:16:28'),
(21, 'App\\Models\\User', 7, 'WebToken', 'cc1c7659fb1b591dd86f1abf649a67b0812cf3a6f7823e2261979a37e5c9066b', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:28', '2025-02-15 16:16:28'),
(22, 'App\\Models\\User', 7, 'WebToken', 'a31c785f97a880c1897cdfc50d1accb6217bee3d36fdd5a73cccbe8b29d7f6d8', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(23, 'App\\Models\\User', 7, 'WebToken', '2fe81220a69faeb382e255744952b8a6ca24c75496b566f0b3ce071656ca1895', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(24, 'App\\Models\\User', 7, 'WebToken', 'a6c886ceb9225b0245e38b4496d5ad80dbef2d09a9692f3b0c75d878ac9ad0d1', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(25, 'App\\Models\\User', 7, 'WebToken', 'a5c7fc2aa482f1a1dd700d5a9cc93734d2095d44b542b024453f4f7b73a27f49', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(26, 'App\\Models\\User', 7, 'WebToken', 'f756118e0e87c57f5148e0ce12f2aeb421e91a5c94e03357dc4705a7de4d74ce', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(27, 'App\\Models\\User', 7, 'WebToken', '3945c6c0a17c2bba28de195060a6f2af1028aa13e66c13dafb2c936c081ba5c2', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(28, 'App\\Models\\User', 7, 'WebToken', '3fdc0de534f6d86cc18a20e556d2478258c0392540e9b31eebcacf5d66b3b294', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:29', '2025-02-15 16:16:29'),
(29, 'App\\Models\\User', 7, 'WebToken', 'c541dce29ee028bfd6ba5ba61742d6265f9588cdfa6a1bb8faba0ac3a1d2ac0f', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:30', '2025-02-15 16:16:30'),
(30, 'App\\Models\\User', 7, 'WebToken', '7bd9a39fd79e29ea8b2107f66a8a03be83d49d44640b1d48732c5e2635c5a9fb', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:30', '2025-02-15 16:16:30'),
(31, 'App\\Models\\User', 7, 'WebToken', '6aaa34925058ed5dff9c7e72fd549c060ad7aa75e940552d8a6efc8fd8cf80c9', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:30', '2025-02-15 16:16:30'),
(32, 'App\\Models\\User', 7, 'WebToken', '7b26854c19c6a607d205296ac929a275a90450293409d7e1a676c303a9150a4e', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:30', '2025-02-15 16:16:30'),
(33, 'App\\Models\\User', 7, 'WebToken', 'ac13338750cb77cfe834d55715671302c42dc7ea3d8fc7f1a155bb7c83db0eee', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:30', '2025-02-15 16:16:30'),
(34, 'App\\Models\\User', 7, 'WebToken', 'e89901431418790474ba0ef666441d1ff0265293b30d7a35c19622933f0d6b0c', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:31', '2025-02-15 16:16:31'),
(35, 'App\\Models\\User', 7, 'WebToken', 'feb9f7dfe421e13af976eb5466fc0eaa6ccd786b8a33692f7cb6b6f02fe54f23', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:31', '2025-02-15 16:16:31'),
(36, 'App\\Models\\User', 7, 'WebToken', '9b6e579c7030befa75a7dd19b19a9a0c66b74075bf02030bbb61e4bf788026cf', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:31', '2025-02-15 16:16:31'),
(37, 'App\\Models\\User', 7, 'WebToken', '36403f97286baf248dcced9007991e8734cc8b784d3ac6bd90564a79dcef99e9', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:31', '2025-02-15 16:16:31'),
(38, 'App\\Models\\User', 7, 'WebToken', '0eca56321bee174f0e75ab835e6aeb8666ea822fff0f19bcc70f685a157d9171', '[\"*\"]', NULL, NULL, '2025-02-15 16:16:32', '2025-02-15 16:16:32'),
(39, 'App\\Models\\User', 7, 'WebToken', '7a13328fd468f7bd223e20a8673aa1fc4a0115ed65a11968d9a0723bef1504f1', '[\"*\"]', NULL, NULL, '2025-02-15 16:17:04', '2025-02-15 16:17:04'),
(40, 'App\\Models\\User', 7, 'WebToken', 'a8af6aca0709a6a2cc0a9de4c1d50e44ad2cddd54edaec1dc2e6bcbeb8f32c29', '[\"*\"]', NULL, NULL, '2025-02-15 16:17:06', '2025-02-15 16:17:06'),
(41, 'App\\Models\\User', 7, 'WebToken', '128d1de57658b112d0711cc5ff4e83fa2c1de78e6cc0cb7fb56056b6c278d934', '[\"*\"]', NULL, NULL, '2025-02-15 16:17:08', '2025-02-15 16:17:08'),
(42, 'App\\Models\\User', 7, 'WebToken', '5dc71337e9e97b232e8d3be1a9681bf8657bdc71c812942ebe692f3ac1056477', '[\"*\"]', NULL, NULL, '2025-02-15 16:17:57', '2025-02-15 16:17:57'),
(43, 'App\\Models\\User', 7, 'WebToken', '38fcaaedb388869af55328c1654a5049cf02498e30cb0ffebd9317679bf0503f', '[\"*\"]', NULL, NULL, '2025-02-15 16:18:46', '2025-02-15 16:18:46'),
(44, 'App\\Models\\User', 7, 'WebToken', '178e56fd882fa0f2e1a2b60bb7a7075d48297e33694b53740b1cb4e19f53b346', '[\"*\"]', NULL, NULL, '2025-02-15 16:19:11', '2025-02-15 16:19:11'),
(45, 'App\\Models\\User', 7, 'WebToken', '3599b9832e67ce88a962d067f476d869cc2770acb3a348c01d3a4c181f275124', '[\"*\"]', NULL, NULL, '2025-02-15 16:19:23', '2025-02-15 16:19:23'),
(46, 'App\\Models\\User', 7, 'WebToken', '8b6602b76b64d28fd02ed17718caf4594abf4f12f299702a8d195e4fd1850381', '[\"*\"]', NULL, NULL, '2025-02-15 16:19:37', '2025-02-15 16:19:37'),
(47, 'App\\Models\\User', 8, 'WebToken', 'ced3789690f81aa94d62c7f9dc5956570d18639562950ef766fef3d5dcda98f6', '[\"*\"]', NULL, NULL, '2025-02-15 16:20:01', '2025-02-15 16:20:01'),
(48, 'App\\Models\\User', 9, 'WebToken', 'a14b4cae7d381c7627e8f2dd0a10799f5657d6562e7f5aa753bf9e72653ebb01', '[\"*\"]', NULL, NULL, '2025-02-15 16:21:12', '2025-02-15 16:21:12'),
(49, 'App\\Models\\User', 9, 'WebToken', '001023f7201b19b3e6243a83552583c943759b50359aed87b70ce54acb7800eb', '[\"*\"]', NULL, NULL, '2025-02-15 16:23:00', '2025-02-15 16:23:00'),
(50, 'App\\Models\\User', 9, 'WebToken', '1a52f99b92999a7804598e9f95588fbe6e085c35c4c42fc661f9b76b9c17f741', '[\"*\"]', NULL, NULL, '2025-02-15 16:23:39', '2025-02-15 16:23:39'),
(51, 'App\\Models\\User', 9, 'WebToken', '3c0fb486fa3490b2d49e3bba0214c1fc567c67b046b958212d28aed45398a772', '[\"*\"]', NULL, NULL, '2025-02-15 16:24:07', '2025-02-15 16:24:07'),
(52, 'App\\Models\\User', 11, 'WebToken', '5a31fb5b60aeedcccb6c9f5a4caf0a3648dc8c5bd0133faeb8bd45c2727ba943', '[\"*\"]', NULL, NULL, '2025-02-15 16:25:01', '2025-02-15 16:25:01'),
(53, 'App\\Models\\User', 11, 'WebToken', '40f3374aedb1988a18b5e05b44901967b4fb6dd5fe8637e871dd7479da959ca4', '[\"*\"]', NULL, NULL, '2025-02-15 16:25:17', '2025-02-15 16:25:17'),
(54, 'App\\Models\\User', 11, 'WebToken', '2e448081eae0e9581420ca150076512e6e00d5fe20072f8b7f5e6a91bf0f8df4', '[\"*\"]', NULL, NULL, '2025-02-15 16:25:29', '2025-02-15 16:25:29'),
(55, 'App\\Models\\User', 11, 'WebToken', '42640c819652084730b53548dbb7e7ff3020a54d20df499463111d738a514be2', '[\"*\"]', NULL, NULL, '2025-02-15 16:25:37', '2025-02-15 16:25:37'),
(56, 'App\\Models\\User', 11, 'WebToken', 'a36d9545b79dbf8ccac8dd8cf4949dee7ca50c0e80f7d4bf2bb48f24f7e19c05', '[\"*\"]', NULL, NULL, '2025-02-15 16:26:24', '2025-02-15 16:26:24'),
(57, 'App\\Models\\User', 11, 'WebToken', 'f9f9f10087df4fcd824634efb2f3920768f08e34c3652a3b19dac34c45ddeeab', '[\"*\"]', NULL, NULL, '2025-02-15 16:26:50', '2025-02-15 16:26:50'),
(58, 'App\\Models\\User', 13, 'WebToken', 'f1c18ecd253a9c593361e127db48b298da6f7d46e23bf67a9b6f5283f5ce8493', '[\"*\"]', NULL, NULL, '2025-02-15 16:28:15', '2025-02-15 16:28:15'),
(59, 'App\\Models\\User', 13, 'WebToken', 'd93ffc49368e6747fa5a1996bba7425141b32967bf6f9f964f8c6321a0c9b994', '[\"*\"]', NULL, NULL, '2025-02-15 16:29:31', '2025-02-15 16:29:31'),
(60, 'App\\Models\\User', 14, 'WebToken', 'd9f040111e1ee350045c8ccb8aa8dbe7e3ba742f75d7eb9b0fff6df5cecfc571', '[\"*\"]', NULL, NULL, '2025-02-15 16:30:04', '2025-02-15 16:30:04'),
(61, 'App\\Models\\User', 14, 'WebToken', '8cd5dc51b2007a8892a2ef9b6d6b72b7cb5e38627585474441e5558434e49cfd', '[\"*\"]', NULL, NULL, '2025-02-15 16:34:24', '2025-02-15 16:34:24'),
(62, 'App\\Models\\User', 14, 'WebToken', '192b1e64832f85f90cd747095b72e96cdb0f403318f7fa1a44591a1ab3d8823d', '[\"*\"]', NULL, NULL, '2025-02-15 16:34:32', '2025-02-15 16:34:32'),
(63, 'App\\Models\\User', 14, 'WebToken', 'ce5b1b4930345e6c4765eff35bccb57873b44626b5c16cb772849e804c000ac3', '[\"*\"]', NULL, NULL, '2025-02-15 16:35:09', '2025-02-15 16:35:09'),
(64, 'App\\Models\\User', 1, 'WebToken', 'e49678ffb82759b2b08cc5b0c7cd7d3dbe0bbafaaca8e33578be12d831c430ad', '[\"*\"]', NULL, NULL, '2025-02-15 16:37:23', '2025-02-15 16:37:23'),
(65, 'App\\Models\\User', 1, 'WebToken', 'ee136c584a452a42478b665367adbe48beec0391b08f8176d6f4903ede1e52a4', '[\"*\"]', NULL, NULL, '2025-02-15 16:37:30', '2025-02-15 16:37:30'),
(66, 'App\\Models\\User', 1, 'WebToken', '000e2ea25d78c54885d8fc652a9a4056aa65bb4a72e103874cc9e363114d842d', '[\"*\"]', NULL, NULL, '2025-02-15 16:37:56', '2025-02-15 16:37:56'),
(67, 'App\\Models\\User', 1, 'WebToken', 'ffbb1f4b2539fe237fe1e747bdb65c663213a2ddcc5f2f07fd75c6c581dd0303', '[\"*\"]', NULL, NULL, '2025-02-15 16:38:02', '2025-02-15 16:38:02'),
(68, 'App\\Models\\User', 1, 'WebToken', '2c644ed179934155fe58384dba314c583f4d0e90dd68a578e8665968b64b5412', '[\"*\"]', NULL, NULL, '2025-02-15 16:42:27', '2025-02-15 16:42:27'),
(69, 'App\\Models\\User', 7, 'WebToken', '801acd3b5329a36d795b1ccf34bc5792fee03fa030eaf6f71ebd04dd59e01c03', '[\"*\"]', NULL, NULL, '2025-02-15 16:43:59', '2025-02-15 16:43:59'),
(70, 'App\\Models\\User', 15, 'WebToken', 'ea9b43f16aa5e7d750485236dd373ac8521a7ebd7d1d690fd76cc5527040eba4', '[\"*\"]', NULL, NULL, '2025-02-15 16:54:44', '2025-02-15 16:54:44'),
(71, 'App\\Models\\User', 15, 'WebToken', '4670a9c4b3b960a9d3cf211868bb1500f8d30460ca050997d2a7b93b5b8cb69a', '[\"*\"]', NULL, NULL, '2025-02-15 16:56:41', '2025-02-15 16:56:41'),
(72, 'App\\Models\\User', 16, 'WebToken', 'a2f5380d9563f8d325dd294b3bbfefd39f807487e1899ed125d31f8605f15d24', '[\"*\"]', NULL, NULL, '2025-02-15 17:03:50', '2025-02-15 17:03:50'),
(73, 'App\\Models\\User', 16, 'WebToken', '3edd14fbfb3a407053799fa0c534b9d3302c16abf95a5e61bf80881f14a83af9', '[\"*\"]', NULL, NULL, '2025-02-15 17:05:32', '2025-02-15 17:05:32'),
(74, 'App\\Models\\User', 7, 'WebToken', 'b7a8dc3888eeb874dfe2951150572b385aebad0dc3f431a8ae31861c16722860', '[\"*\"]', NULL, NULL, '2025-02-15 17:13:35', '2025-02-15 17:13:35'),
(75, 'App\\Models\\User', 16, 'WebToken', '02624be7ce86e1305d7772cd21e388826e7bff2a7c0c33d6d69118962ad37dac', '[\"*\"]', NULL, NULL, '2025-02-15 17:17:00', '2025-02-15 17:17:00'),
(76, 'App\\Models\\User', 16, 'WebToken', '48c555e6da01795575f8cc4534159175d05d0a5026c3c976e4f54f546123b355', '[\"*\"]', NULL, NULL, '2025-02-15 17:18:41', '2025-02-15 17:18:41'),
(77, 'App\\Models\\User', 16, 'WebToken', '1e678fc8e691aace0e014927c5b30ca1d1d61dfd7ea049ff2daf2750f82fc940', '[\"*\"]', NULL, NULL, '2025-02-15 17:22:55', '2025-02-15 17:22:55'),
(78, 'App\\Models\\User', 15, 'WebToken', '7903601ccda300945f7aafe70159407d1ba521dd70c6336a22d2309ab578217c', '[\"*\"]', NULL, NULL, '2025-02-15 17:26:17', '2025-02-15 17:26:17'),
(79, 'App\\Models\\User', 15, 'WebToken', 'afc83971356e3788c1db3dbeda6dbba23ed79ce3a5e93f6a868c50bdc0435c6b', '[\"*\"]', NULL, NULL, '2025-02-15 17:29:20', '2025-02-15 17:29:20'),
(80, 'App\\Models\\User', 15, 'WebToken', '6a57972a02afee6cbc7b5cc263530d2a3e9d2a43c5914f1200b0ae1bfdcc7772', '[\"*\"]', NULL, NULL, '2025-02-15 17:31:01', '2025-02-15 17:31:01'),
(81, 'App\\Models\\User', 16, 'WebToken', '94f943e8a6a0b553f41aaafc46e702b9d4324f4821f78dcc4d293948fbca5975', '[\"*\"]', NULL, NULL, '2025-02-15 17:32:44', '2025-02-15 17:32:44'),
(82, 'App\\Models\\User', 17, 'WebToken', 'c5067844b107ac2414921aa69bbadd24d0ee72960046de3df6e843712bab84cd', '[\"*\"]', NULL, NULL, '2025-02-15 17:37:23', '2025-02-15 17:37:23'),
(83, 'App\\Models\\User', 17, 'WebToken', 'b97394b0c4a9d7cc9aaa4338cd3cafd973efd1dde7e0d45d24cc8ede16f12040', '[\"*\"]', NULL, NULL, '2025-02-15 17:37:35', '2025-02-15 17:37:35'),
(84, 'App\\Models\\User', 17, 'WebToken', 'fdbff5d54d1056198c4f849a77a3225cc452888f79469b9a150914e444004294', '[\"*\"]', NULL, NULL, '2025-02-15 17:38:07', '2025-02-15 17:38:07'),
(85, 'App\\Models\\User', 17, 'WebToken', 'f8b4d986a7e4e30f47fa15230475ae897a5716794a5614b56d6582d5642863fb', '[\"*\"]', NULL, NULL, '2025-02-15 17:43:38', '2025-02-15 17:43:38'),
(86, 'App\\Models\\User', 17, 'WebToken', '09f840ed2533d9b7255c46ed598941020add0d3d70bcccf75e872ed3922714cf', '[\"*\"]', NULL, NULL, '2025-02-15 17:43:52', '2025-02-15 17:43:52'),
(87, 'App\\Models\\User', 17, 'WebToken', '9318b4b5144296ec802e1483c23e50bb7561abb7d74b9e24e82ed674bb36f206', '[\"*\"]', NULL, NULL, '2025-02-15 17:48:06', '2025-02-15 17:48:06'),
(88, 'App\\Models\\User', 17, 'WebToken', '14f3084969cf26ec319694f71329e1fa3c8e8fc5d2b35200d070c4d18475fadb', '[\"*\"]', NULL, NULL, '2025-02-15 17:48:23', '2025-02-15 17:48:23'),
(89, 'App\\Models\\User', 17, 'WebToken', '58c1e2faf1968b8e3abf0b1697067afef5f3e3fc636a2543e063b43a6c03bc2d', '[\"*\"]', NULL, NULL, '2025-02-15 17:48:40', '2025-02-15 17:48:40'),
(90, 'App\\Models\\User', 17, 'WebToken', '9595e7c07f836c7041ff7d58eb74aaafcbeb8d96b530a326d62bcc3c8ee35ec1', '[\"*\"]', NULL, NULL, '2025-02-15 17:48:50', '2025-02-15 17:48:50'),
(91, 'App\\Models\\User', 17, 'WebToken', '8bd3ee56b32013e6c6202e4f9bd344ea020139f48107c1c8e5050b44c580eeec', '[\"*\"]', NULL, NULL, '2025-02-15 17:49:08', '2025-02-15 17:49:08'),
(92, 'App\\Models\\User', 17, 'WebToken', '2c7c9766742ea52deaece0a950896afbfdcc62fa614a4262980d2b3384c4d73c', '[\"*\"]', NULL, NULL, '2025-02-15 17:49:16', '2025-02-15 17:49:16'),
(93, 'App\\Models\\User', 17, 'WebToken', '4d2c2cc97e913175821e8cd68bd0263ed43e4ddd85adcf8355c847d02ecb388b', '[\"*\"]', NULL, NULL, '2025-02-15 17:49:30', '2025-02-15 17:49:30'),
(94, 'App\\Models\\User', 17, 'WebToken', '6a99d40951ebaa20031e3c9d6e07ae7b0fccbfb9141ab8e91afdad4357f7c342', '[\"*\"]', NULL, NULL, '2025-02-15 17:49:43', '2025-02-15 17:49:43'),
(95, 'App\\Models\\User', 17, 'WebToken', 'c8d31af12ee78f1797b2242221c88565ace4f4bdcf235689b26bdfdce53b4df2', '[\"*\"]', NULL, NULL, '2025-02-15 17:49:46', '2025-02-15 17:49:46'),
(96, 'App\\Models\\User', 17, 'WebToken', 'f945622ee7a8d04be0c1fc0cf402a4b269ec2043e8a52c0ee2a72601c34b38b7', '[\"*\"]', NULL, NULL, '2025-02-15 17:50:07', '2025-02-15 17:50:07'),
(97, 'App\\Models\\User', 17, 'WebToken', 'eef17f4a894e83d77b45fb0ae23d37cef864f4b5e3255c30fdf0f4e1e0ee9b08', '[\"*\"]', NULL, NULL, '2025-02-15 17:50:52', '2025-02-15 17:50:52'),
(98, 'App\\Models\\User', 17, 'WebToken', '1dc5f0772eb0345edd2c15201cc89f0e3cc42c3b5ebbc9b9aa8fe3ea3d2a5d7a', '[\"*\"]', NULL, NULL, '2025-02-15 17:51:18', '2025-02-15 17:51:18'),
(99, 'App\\Models\\User', 17, 'WebToken', 'e8429ddca81483caf5293654ff2a27e7b3eae4f93d2749884c15689cee48fbdd', '[\"*\"]', NULL, NULL, '2025-02-15 17:52:10', '2025-02-15 17:52:10'),
(100, 'App\\Models\\User', 17, 'WebToken', 'cac32d903b91b274bdf1c10382d2c2b912a61df17617701554442fb24d0430a3', '[\"*\"]', NULL, NULL, '2025-02-15 17:55:18', '2025-02-15 17:55:18'),
(101, 'App\\Models\\User', 17, 'WebToken', '4281fbe1c35a9e85aa20508be7800f321db11293b8132f4609a5e05d2f0c19c3', '[\"*\"]', NULL, NULL, '2025-02-15 17:55:33', '2025-02-15 17:55:33'),
(102, 'App\\Models\\User', 17, 'WebToken', '454c81623d2b943ff1f74848d08374429174ccae469ad3dc2766bb0d10ebbe38', '[\"*\"]', NULL, NULL, '2025-02-15 17:56:29', '2025-02-15 17:56:29'),
(103, 'App\\Models\\User', 17, 'WebToken', '91e45cbd91959c5b3a7d7d967113f3add96e686fda6db033bc8434951089f43c', '[\"*\"]', NULL, NULL, '2025-02-15 17:58:21', '2025-02-15 17:58:21'),
(104, 'App\\Models\\User', 17, 'WebToken', 'b678f7624c31f627470145b5782d91cd9d0f2c604fc52daa661aaa04a298bfa0', '[\"*\"]', NULL, NULL, '2025-02-15 17:58:43', '2025-02-15 17:58:43'),
(105, 'App\\Models\\User', 17, 'WebToken', '5a5acd3d7e046735f6c562bd04704a307b38436828a01d7e8bdca93705662676', '[\"*\"]', NULL, NULL, '2025-02-15 17:59:05', '2025-02-15 17:59:05'),
(106, 'App\\Models\\User', 17, 'WebToken', '5b1bd70ef9f8a6176e71e3610e14ef746c8f402d6a9b84864aaf3d9b2d6ca747', '[\"*\"]', NULL, NULL, '2025-02-15 17:59:12', '2025-02-15 17:59:12'),
(107, 'App\\Models\\User', 17, 'WebToken', 'd5a4fa15961ddb3a6bac2d0de28ece7f8bd4e7e1a44a4ac7c5f9f289a03fafc7', '[\"*\"]', NULL, NULL, '2025-02-15 17:59:16', '2025-02-15 17:59:16'),
(108, 'App\\Models\\User', 17, 'WebToken', 'd5c35afcf7800c920cccad9c9d1e6dad197265ccc15781d366020411f2b82c97', '[\"*\"]', NULL, NULL, '2025-02-15 17:59:37', '2025-02-15 17:59:37'),
(109, 'App\\Models\\User', 17, 'WebToken', 'bd8fad412518689f6b270ed5f249cf7897a8b481ff1d7c631e2754df3889751a', '[\"*\"]', NULL, NULL, '2025-02-15 18:00:03', '2025-02-15 18:00:03'),
(110, 'App\\Models\\User', 17, 'WebToken', '7fa9f2ef7bb13d229813930cbbb7e81279eef787a24f043331bceb510dd712f0', '[\"*\"]', NULL, NULL, '2025-02-15 18:00:10', '2025-02-15 18:00:10'),
(111, 'App\\Models\\User', 17, 'WebToken', '2d1c25f9f5c005433a8ee73de51c359859d461d3dafa9778bb87e993af8aadf7', '[\"*\"]', NULL, NULL, '2025-02-15 18:00:10', '2025-02-15 18:00:10'),
(112, 'App\\Models\\User', 17, 'WebToken', '43a2863228da98fc63a05145c81560982b2be2a4ac42e2bdd75a7065bd4dad2e', '[\"*\"]', NULL, NULL, '2025-02-15 18:00:24', '2025-02-15 18:00:24'),
(113, 'App\\Models\\User', 17, 'WebToken', '59b1e6bfdfd2506b4b88ba3657d34f8ad239f0c4a3a3c86c43c11ebad78ffa80', '[\"*\"]', NULL, NULL, '2025-02-15 18:00:49', '2025-02-15 18:00:49'),
(114, 'App\\Models\\User', 17, 'WebToken', '59929a129a00d65f2012d80af7b1a2851706f0be403d180ad1a040228b3bc935', '[\"*\"]', NULL, NULL, '2025-02-15 18:01:04', '2025-02-15 18:01:04'),
(115, 'App\\Models\\User', 17, 'WebToken', 'c9559e3673724cf9369e3f285424b6e68abdc91e346188cb408256095de0a7df', '[\"*\"]', NULL, NULL, '2025-02-15 18:05:06', '2025-02-15 18:05:06'),
(116, 'App\\Models\\User', 17, 'WebToken', 'a277de7a1d63289c520f0ace4f027442caa39bdec126ac55772ad839bd8dc356', '[\"*\"]', NULL, NULL, '2025-02-15 18:08:08', '2025-02-15 18:08:08'),
(117, 'App\\Models\\User', 17, 'WebToken', 'ae73ccd34dd24f12d8e8da6cf1cd93366bed18b25e1bc74e18a1430bad299526', '[\"*\"]', NULL, NULL, '2025-02-15 18:10:00', '2025-02-15 18:10:00'),
(118, 'App\\Models\\User', 17, 'WebToken', '152bde86e3b6c80a8f84a3517f8b53e8ed7c9c182904076995daab1a66d196fe', '[\"*\"]', NULL, NULL, '2025-02-15 18:10:21', '2025-02-15 18:10:21'),
(119, 'App\\Models\\User', 17, 'WebToken', '1f1c59e2d5d228d87caea35d551df524666df6248ebcb4b75670a77d90ab6efe', '[\"*\"]', NULL, NULL, '2025-02-15 18:11:47', '2025-02-15 18:11:47'),
(120, 'App\\Models\\User', 17, 'WebToken', '8e2b4f8642ef59f2cb5f911ae1254003b9588e893372af5334bc7f29661e0a37', '[\"*\"]', NULL, NULL, '2025-02-15 18:14:48', '2025-02-15 18:14:48'),
(121, 'App\\Models\\User', 17, 'WebToken', '3940149f98be901c7f24ea54577ff1b63de15375924396cd93bd397f68d462f5', '[\"*\"]', NULL, NULL, '2025-02-15 18:15:10', '2025-02-15 18:15:10'),
(122, 'App\\Models\\User', 17, 'WebToken', 'a2a86e39865ac4fd11c3aeef8a20ff3cf94d07c25264d461d246b48f33d448ba', '[\"*\"]', NULL, NULL, '2025-02-15 18:24:10', '2025-02-15 18:24:10'),
(123, 'App\\Models\\User', 17, 'WebToken', '5ed6ecef9a9cdaa87a4d1466457c3d8315ea45bbe953a2bf2033d1c5df7095fa', '[\"*\"]', NULL, NULL, '2025-02-15 18:27:36', '2025-02-15 18:27:36'),
(124, 'App\\Models\\User', 17, 'WebToken', '7ed7767e8f6965ffe922de2c8859cc1f161e4270a32e600ce2922a0700edefea', '[\"*\"]', NULL, NULL, '2025-02-15 18:28:13', '2025-02-15 18:28:13'),
(125, 'App\\Models\\User', 17, 'WebToken', 'ec2723739e220b43c92d03f1c984eb4bad84e52f56976f4af07bf42fd61513f2', '[\"*\"]', NULL, NULL, '2025-02-15 18:28:15', '2025-02-15 18:28:15'),
(126, 'App\\Models\\User', 17, 'WebToken', '1926ff6660ac86153eae60e49f9cf62a3f84534be5b50186095d21d49787fc90', '[\"*\"]', NULL, NULL, '2025-02-15 18:28:32', '2025-02-15 18:28:32'),
(127, 'App\\Models\\User', 17, 'WebToken', '556f44d6af3bf982233e137e5349f67e13376127c5bc7c7681fa044a90fd0b6b', '[\"*\"]', NULL, NULL, '2025-02-15 18:28:43', '2025-02-15 18:28:43'),
(128, 'App\\Models\\User', 15, 'WebToken', '6c790882b827e1023523e47b77da9714949396ddb3e45cf340670d0a6535dddf', '[\"*\"]', NULL, NULL, '2025-02-15 18:36:07', '2025-02-15 18:36:07'),
(129, 'App\\Models\\User', 17, 'WebToken', 'de7a36d347e3691591a560d65255fa02daaae1d391a1431cb91cf31761e8bf8d', '[\"*\"]', NULL, NULL, '2025-02-15 18:37:45', '2025-02-15 18:37:45'),
(130, 'App\\Models\\User', 19, 'WebToken', '8eaeb5e86306981e6f658109603375303345d38530999d701321dfbcee139535', '[\"*\"]', NULL, NULL, '2025-02-15 18:38:39', '2025-02-15 18:38:39'),
(131, 'App\\Models\\User', 20, 'WebToken', '41f61b79ad65f9b5f85055bc6829772f74a46d9c33b23e6b2cd50ac1fa03d8dd', '[\"*\"]', '2025-02-17 10:22:51', NULL, '2025-02-17 10:14:18', '2025-02-17 10:22:51'),
(132, 'App\\Models\\User', 17, 'WebToken', '7d67fd137cc0d8e0a4eee2f7f0769209338beae0a057b08c13ba0bd32c6f6304', '[\"*\"]', '2025-02-17 12:16:37', NULL, '2025-02-17 10:20:14', '2025-02-17 12:16:37'),
(133, 'App\\Models\\User', 17, 'WebToken', 'daa62b7f106d38a0a40f2c299fe7eceff3431d240681ae9bbb5901879e9621e0', '[\"*\"]', NULL, NULL, '2025-02-17 11:03:56', '2025-02-17 11:03:56'),
(134, 'App\\Models\\User', 17, 'WebToken', 'cce73d9cebb17863ad2840a4ceea1f4946fa761e0667c049a79dc805fb908794', '[\"*\"]', NULL, NULL, '2025-02-17 11:42:08', '2025-02-17 11:42:08'),
(135, 'App\\Models\\User', 17, 'WebToken', '9801814a06c83873115d9b47f8ca5cfc174ce010df265a0595054e445646aa83', '[\"*\"]', NULL, NULL, '2025-02-17 12:00:16', '2025-02-17 12:00:16'),
(136, 'App\\Models\\User', 17, 'WebToken', '62adfb25231f8af161be4c1878da0f1be21603d795fe60f91ab030907ee297dc', '[\"*\"]', NULL, NULL, '2025-02-17 12:07:07', '2025-02-17 12:07:07'),
(137, 'App\\Models\\User', 17, 'WebToken', '9cbac34cac57a53a74c7118834d25ffde5a77ba46fe0985a3c9cafefeb2ced8f', '[\"*\"]', NULL, NULL, '2025-02-17 12:12:42', '2025-02-17 12:12:42'),
(138, 'App\\Models\\User', 17, 'WebToken', '0f35bc62ecc31ce45d50e8114ea9c2a39bf01e9e9587f86bd82da5d2f8973763', '[\"*\"]', '2025-02-17 15:24:20', NULL, '2025-02-17 12:14:54', '2025-02-17 15:24:20'),
(139, 'App\\Models\\User', 17, 'WebToken', 'f5e21ca64195c416922c42f96d78367e9ddd6626ff5819d6ff1e58ecfa5ee43d', '[\"*\"]', NULL, NULL, '2025-02-17 12:22:56', '2025-02-17 12:22:56'),
(140, 'App\\Models\\User', 17, 'WebToken', '86397cf94a8afb66efe32da623b690ed8e4b858344f01b18e5c013e5680e17f4', '[\"*\"]', NULL, NULL, '2025-02-17 12:26:44', '2025-02-17 12:26:44'),
(141, 'App\\Models\\User', 17, 'WebToken', 'be90b3135240693b07e5a641cdc8ace318e0f2247d0b8a550bd1ee1c5f0e6e06', '[\"*\"]', NULL, NULL, '2025-02-17 12:30:25', '2025-02-17 12:30:25'),
(142, 'App\\Models\\User', 17, 'WebToken', '4f86bd0b033dd2517b87d093cc797f59c3f52d2f84426e3170daabbe02034ff0', '[\"*\"]', NULL, NULL, '2025-02-17 12:39:00', '2025-02-17 12:39:00'),
(143, 'App\\Models\\User', 17, 'WebToken', '487a1b735c3b34fd52c7c32afd32a091ee904b07ea47b36b4ec498a34329e885', '[\"*\"]', '2025-02-17 12:41:43', NULL, '2025-02-17 12:41:43', '2025-02-17 12:41:43'),
(144, 'App\\Models\\User', 17, 'WebToken', '82d7353694ba751d781aa064a72f21b54bbfdeeefd2bdc0e424c6c2374944e4b', '[\"*\"]', '2025-02-17 15:38:19', NULL, '2025-02-17 12:54:43', '2025-02-17 15:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `privacy_policy` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policies`
--

INSERT INTO `privacy_policies` (`id`, `privacy_policy`, `created_at`, `updated_at`) VALUES
(1, '[{\"title\":\"test\",\"paragraph\":\"test\"}]', '2025-02-17 14:58:34', '2025-02-17 14:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `service_price` double DEFAULT NULL,
  `service_icons` varchar(255) DEFAULT NULL,
  `service_banner` varchar(255) DEFAULT NULL,
  `service_details` varchar(255) DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `service_price`, `service_icons`, `service_banner`, `service_details`, `action_by`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'GST Filing', 5000, 'service/Service_1679471380.png', 'service/Service_1488354378.jpg', '<p>Annual Return</p><p>&nbsp;</p>', 'Admin', 1, NULL, '2025-02-17 10:27:32', '2025-02-18 05:55:20'),
(2, 'ITR Filling', 3500, 'service/Service_1655764595.svg', 'service/Service_80993466.jpg', 'Ragister', 'Admin', 1, NULL, '2025-02-17 11:38:22', '2025-02-18 05:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `service_documents`
--

CREATE TABLE `service_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `doc_icon` varchar(255) DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_documents`
--

INSERT INTO `service_documents` (`id`, `service_id`, `doc_icon`, `doc_name`, `action_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'service/Service_436294994.jpeg', 'dfffrfrf', 'Admin', NULL, '2025-02-17 10:27:32', '2025-02-18 05:55:20'),
(2, 1, 'service/Service_611586380.jpeg', 'Document', 'Admin', NULL, '2025-02-17 10:27:32', '2025-02-18 05:55:20'),
(3, 2, 'service/Service_813487200.jpg', 'Ragister', 'Admin', NULL, '2025-02-17 11:38:22', '2025-02-18 05:53:32'),
(4, 2, 'service/Service_2128989641.jpg', 'Ragister', 'Admin', NULL, '2025-02-17 11:38:22', '2025-02-18 05:53:32'),
(5, 2, 'service/Service_1630447545.jpg', 'test', 'Admin', NULL, '2025-02-18 05:53:32', '2025-02-18 05:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `member_details` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `username`, `email`, `phone`, `password`, `member_details`, `image`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'kurbanali', 'test@example.com', '9811461935', '1234', 'fsdf', 'user/team_1739796022.png', 1, NULL, '2025-02-17 12:40:23', '2025-02-17 12:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `t_c` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_and_conditions`
--

INSERT INTO `terms_and_conditions` (`id`, `t_c`, `created_at`, `updated_at`) VALUES
(1, '[{\"title\":\"test\",\"paragraph\":\"test\"}]', '2025-02-17 14:56:36', '2025-02-17 14:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(255) DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `filed_document` varchar(255) DEFAULT NULL,
  `refund_amount` double DEFAULT NULL,
  `payable_amount` double DEFAULT NULL,
  `consultency_fees` double DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `service_id`, `user_id`, `token`, `is_active`, `status`, `action_by`, `payment`, `filed_document`, `refund_amount`, `payable_amount`, `consultency_fees`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 21, 'K0217202505151', 1, 'Document Uploaded', 'Admin', 'Cash', 'user_document/filed1739962183.png', 10, 20, 30, NULL, '2025-02-17 11:26:55', '2025-03-20 10:52:24'),
(2, 1, 21, 'GF0217202505152', 1, 'Document Uploaded', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-17 12:18:25', '2025-02-17 12:19:54'),
(3, 1, 21, 'GF0225202505153', 1, 'Document Uploaded', 'Admin', 'Cash', NULL, NULL, NULL, NULL, NULL, '2025-02-25 10:42:16', '2025-03-20 11:01:25'),
(4, 1, 22, 'GF0320202505154', 1, 'Token Generated', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 09:38:49', '2025-03-20 09:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `token_documents`
--

CREATE TABLE `token_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `token_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `doc_type` varchar(255) DEFAULT NULL,
  `form_16_a` text DEFAULT NULL,
  `annex_use` text DEFAULT NULL,
  `form_16_parantal` text DEFAULT NULL,
  `inv_lic_mf` text DEFAULT NULL,
  `intrest_certificate` text DEFAULT NULL,
  `public_investment` text DEFAULT NULL,
  `bank_statement` text DEFAULT NULL,
  `sales_purchase` text DEFAULT NULL,
  `additional_documents` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `token_documents`
--

INSERT INTO `token_documents` (`id`, `user_id`, `token_id`, `service_id`, `year`, `doc_type`, `form_16_a`, `annex_use`, `form_16_parantal`, `inv_lic_mf`, `intrest_certificate`, `public_investment`, `bank_statement`, `sales_purchase`, `additional_documents`, `comment`, `action_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 21, 1, 1, '2025', 'salaried', NULL, '[\"user_document\\/1739791748_cKH1mI9bC4.jpeg\"]', '[\"user_document\\/1739791748_10R8WpUakf.png\"]', '[\"user_document\\/1739791748_fpmhncs7wt.jpeg\"]', 'user_document/1739791748_EjaWVtWHl5.jpg', '[\"user_document\\/1739791748_kj3JWI3nWB.jpeg\"]', NULL, NULL, '{\"dfffrfrf\":[\"user_document\\/1739791748_1z2K01iOY4.jpg\"],\"Document\":[\"user_document\\/1739791748_ZsueXrCamS.jpeg\"]}', 'x klcncnsklmklskebdcm;lsndfh', 'Admin', NULL, '2025-02-17 11:29:08', '2025-02-17 11:29:08'),
(2, 21, 2, 1, '2025', 'salaried', NULL, '[\"user_document\\/1739794794_690xLw3xqb.png\"]', '[\"user_document\\/1739794794_uy8TmZalRE.jpg\"]', '[\"user_document\\/1739794794_1IQBdFQZP5.jpeg\"]', 'user_document/1739794794_bzsCouef0X.jpeg', '[\"user_document\\/1739794794_mAfWyVcNrk.jpeg\"]', NULL, NULL, '{\"dfffrfrf\":[\"user_document\\/1739794794_Enxb6Tf2OF.jpeg\"],\"Document\":[\"user_document\\/1739794794_50bWBZYIXO.png\"]}', 'edvfs dsmkl dsl dknl  djanjk', 'Admin', NULL, '2025-02-17 12:19:54', '2025-02-17 12:19:54'),
(3, 21, 3, 1, '2025', 'salaried', NULL, '[\"user_document\\/1740480205_0n0rb65Y6f.jpg\",\"user_document\\/1740480205_ZtqxLaxby9.jpeg\"]', '[\"user_document\\/1740480205_aTmdsPiNHx.jpeg\",\"user_document\\/1740480205_0ot0gYEQn7.jpg\"]', '[\"user_document\\/1740480205_kaZfEPZkxQ.jpeg\",\"user_document\\/1740480205_qZTLj0xKiH.jpeg\"]', 'user_document/1740480205_4XmvHXA6pu.jpg', '[\"user_document\\/1740480205_OBOUoUXd7U.jpeg\",\"user_document\\/1740480205_ifMVJx6uVV.jpeg\"]', NULL, NULL, '{\"dfffrfrf\":[\"user_document\\/1740480205_jQrCsz77Kc.png\"],\"Document\":[\"user_document\\/1740480205_0odUpN42Yg.png\"]}', 'sdjkdnbvjk', 'Admin', NULL, '2025-02-25 10:43:25', '2025-02-25 10:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `token_statuses`
--

CREATE TABLE `token_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT '1=Token Generated, 2=Data Validation, 3=Return Not Filed / Not Finalized, 4=Return Not Filed / Finalized / Payments Pending, 5=Payments Completed / Ready to file, 6=Returns Filed - Not Verified, 7=Return Filed -Verified, 8=Documents Delivered',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `token_statuses`
--

INSERT INTO `token_statuses` (`id`, `token_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '1', NULL, '2025-02-17 11:26:55', '2025-02-17 11:26:55'),
(2, 2, '1', NULL, '2025-02-17 12:18:25', '2025-02-17 12:18:25'),
(21, 3, '1', NULL, '2025-02-25 10:42:16', '2025-02-25 10:42:16'),
(22, 1, '5', NULL, '2025-03-20 09:16:37', '2025-03-20 09:16:37'),
(23, 4, '1', NULL, '2025-03-20 09:38:50', '2025-03-20 09:38:50'),
(24, 1, '2', NULL, '2025-03-20 10:43:53', '2025-03-20 10:43:53'),
(25, 1, '3', NULL, '2025-03-20 10:48:44', '2025-03-20 10:48:44'),
(26, 1, '4', NULL, '2025-03-20 10:52:24', '2025-03-20 10:52:24'),
(27, 3, '5', NULL, '2025-03-20 11:01:25', '2025-03-20 11:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `f_fname` varchar(255) DEFAULT NULL,
  `f_mname` varchar(255) DEFAULT NULL,
  `f_lname` varchar(255) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `pan_no` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `adhar_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `user_token` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `mname`, `lname`, `f_fname`, `f_mname`, `f_lname`, `phone`, `mobile`, `phone_verified_at`, `email`, `email_verified_at`, `pan_no`, `dob`, `adhar_number`, `address`, `image`, `otp`, `otp_expires_at`, `user_token`, `password`, `action_by`, `status`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(21, 'test', 'd', 'sdfds', NULL, NULL, 'sdfds', 9811461935, NULL, NULL, 'admin@gmail.com', NULL, 'AD45678JKT', '1990-02-07', '123456789012', NULL, NULL, NULL, NULL, NULL, NULL, 'Admin', 1, NULL, NULL, '2025-02-17 11:22:16', '2025-02-17 11:22:16'),
(22, NULL, NULL, 'test1', NULL, NULL, 'ftest1', 9999999999, 9999999998, NULL, 'M4mahi.singh@gmail.com', NULL, 'dmsfdlk245', '1999-05-14', '123456789017', NULL, NULL, NULL, NULL, NULL, NULL, 'Admin', 1, NULL, NULL, '2025-02-25 11:08:33', '2025-02-25 11:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `house_no` varchar(255) DEFAULT NULL,
  `house_name` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `office_check` tinyint(4) NOT NULL DEFAULT 0,
  `office_house_no` varchar(255) DEFAULT NULL,
  `office_house_name` varchar(255) DEFAULT NULL,
  `office_street` varchar(255) DEFAULT NULL,
  `office_area` varchar(255) DEFAULT NULL,
  `office_city` varchar(255) DEFAULT NULL,
  `office_state` varchar(255) DEFAULT NULL,
  `office_country` varchar(255) DEFAULT NULL,
  `office_pin_code` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `house_no`, `house_name`, `street`, `area`, `city`, `state`, `country`, `pin_code`, `office_check`, `office_house_no`, `office_house_name`, `office_street`, `office_area`, `office_city`, `office_state`, `office_country`, `office_pin_code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 21, 'test', 'test', 'test', 'test', 'test', 'test', 'India', '110048', 1, 'test', 'test', 'test', 'test', 'test', 'test', 'India', '110048', NULL, '2025-02-17 11:22:16', '2025-02-17 11:22:16'),
(2, 22, 'test', 'test', 'test', 'test', 'delhi', 'test', 'India', '110048', 1, 'test', 'test', 'test', 'test', 'delhi', 'test', 'India', '110048', NULL, '2025-02-25 11:08:33', '2025-02-25 11:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_account_details`
--

CREATE TABLE `user_bank_account_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `income_tax_password` varchar(255) DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_bank_account_details`
--

INSERT INTO `user_bank_account_details` (`id`, `user_id`, `account_type`, `bank_name`, `account_no`, `ifsc`, `branch`, `income_tax_password`, `action_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 21, 'Savings Account', 'HDFCC', '12345678909876', 'HDFC003', 'DELHI', '1234', 'Admin', NULL, '2025-02-17 11:22:16', '2025-02-17 11:22:16'),
(2, 22, 'Savings Account', 'HDFC', '12345678909876', 'HDFC003', 'DELHI', '1234', 'Admin', '2025-02-25 11:08:50', '2025-02-25 11:08:34', '2025-02-25 11:08:50'),
(3, 22, 'Savings Account', 'HDFC', '12345678909876', 'HDFC003', 'DELHI', '1234', 'Admin', NULL, '2025-02-25 11:08:50', '2025-02-25 11:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doc_type` varchar(255) DEFAULT NULL,
  `form_16_a` text DEFAULT NULL,
  `annex_use` text DEFAULT NULL,
  `form_16_parantal` text DEFAULT NULL,
  `inv_lic_mf` text DEFAULT NULL,
  `intrest_certificate` text DEFAULT NULL,
  `public_investment` text DEFAULT NULL,
  `bank_statement` text DEFAULT NULL,
  `sales_purchase` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_order_id_unique` (`order_id`),
  ADD KEY `payments_token_id_foreign` (`token_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_documents`
--
ALTER TABLE `service_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_documents`
--
ALTER TABLE `token_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_statuses`
--
ALTER TABLE `token_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_bank_account_details`
--
ALTER TABLE `user_bank_account_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_bank_account_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_documents_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_documents`
--
ALTER TABLE `service_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `token_documents`
--
ALTER TABLE `token_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `token_statuses`
--
ALTER TABLE `token_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_bank_account_details`
--
ALTER TABLE `user_bank_account_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_token_id_foreign` FOREIGN KEY (`token_id`) REFERENCES `tokens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_bank_account_details`
--
ALTER TABLE `user_bank_account_details`
  ADD CONSTRAINT `user_bank_account_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
