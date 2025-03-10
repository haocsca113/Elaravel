-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 07, 2025 lúc 10:00 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `elaravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_18_011537_create_tbl_admin_table', 1),
(5, '2025_02_18_070430_create_tbl_category_product_table', 2),
(6, '2025_02_19_060658_create_tbl_brand_product', 3),
(7, '2025_02_19_062458_create_tbl_brand_product_table', 4),
(8, '2025_02_20_001905_create_tbl_product_table', 5),
(9, '2025_02_24_011856_create_tbl_customer_table', 6),
(10, '2025_02_24_021311_create_tbl_shipping_table', 7),
(11, '2025_02_25_005649_create_tbl_payment_table', 8),
(12, '2025_02_25_005722_create_tbl_order_table', 8),
(13, '2025_02_25_005751_create_tbl_order_details_table', 8),
(14, '2025_03_02_120003_create_tbl_social_table', 9),
(15, '2025_03_05_015808_create_tbl_vnpay_table', 10),
(16, '2025_03_05_074013_create_tbl_momo_table', 11),
(17, '2025_03_06_123217_create_tbl_coupon_table', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Xyex8BGSief4YoFDcUghuSYKmfro6M6W90fMZ2aH', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSzhNUWlzUFVCUGRHUzA2VW91a3VTTzFWWnl0bUI1U3U4V2FOd1RpcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MC9sYXJhdmVsL3dlYmJhbmhhbmdfdHV0b3JpYWwvcHVibGljL2dpby1oYW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMDoiYWRtaW5fbmFtZSI7czo2OiJQb2doYW8iO3M6ODoiYWRtaW5faWQiO2k6MTtzOjQ6ImNhcnQiO2E6Mjp7aTowO2E6Njp7czoxMDoic2Vzc2lvbl9pZCI7czo1OiI0ODRiZiI7czoxMDoicHJvZHVjdF9pZCI7czoyOiIxMSI7czoxMjoicHJvZHVjdF9uYW1lIjtzOjE4OiJUYXkgQ+G6p20gWGJveCAzNjAiO3M6MTM6InByb2R1Y3RfaW1hZ2UiO3M6MTM6InhvYngzNjAxMy5qcGciO3M6MTM6InByb2R1Y3RfcHJpY2UiO3M6NjoiNDc5MDAwIjtzOjExOiJwcm9kdWN0X3F0eSI7czoxOiIxIjt9aToxO2E6Njp7czoxMDoic2Vzc2lvbl9pZCI7czo1OiI2MzcwMSI7czoxMDoicHJvZHVjdF9pZCI7czoyOiIxMCI7czoxMjoicHJvZHVjdF9uYW1lIjtzOjI4OiJUYXkgQ+G6p20gWGJveCBPbmUgUyBDxakgMk5EIjtzOjEzOiJwcm9kdWN0X2ltYWdlIjtzOjE3OiJ4Ym94b25lczJuZDUyLmpwZyI7czoxMzoicHJvZHVjdF9wcmljZSI7czo2OiI2OTkwMDAiO3M6MTE6InByb2R1Y3RfcXR5IjtzOjE6IjEiO319fQ==', 1741336781);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_email`, `admin_password`, `admin_name`, `admin_phone`, `created_at`, `updated_at`) VALUES
(1, 'poghao@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Poghao', '0988820943', '2025-02-18 01:27:04', NULL),
(11, 'haocsca113@gmail.com', '', 'Hào Trương Huỳnh', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand_product`
--

CREATE TABLE `tbl_brand_product` (
  `brand_id` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_desc` text NOT NULL,
  `brand_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand_product`
--

INSERT INTO `tbl_brand_product` (`brand_id`, `brand_name`, `brand_desc`, `brand_status`, `created_at`, `updated_at`) VALUES
(1, 'Dell', 'Dell', 1, NULL, NULL),
(2, 'Samsung', 'Samsung', 1, NULL, NULL),
(3, 'Apple', 'Apple', 1, NULL, NULL),
(4, 'Oppo', 'Oppo', 1, NULL, NULL),
(6, 'Sony', 'Sony là thương hiệu nổi tiếng gồm các tay cầm như ps4, ps5,...', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category_product`
--

CREATE TABLE `tbl_category_product` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_desc` text NOT NULL,
  `category_status` int(11) NOT NULL,
  `meta_keywords` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category_product`
--

INSERT INTO `tbl_category_product` (`category_id`, `category_name`, `category_desc`, `category_status`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'PS4', 'Tay cầm PS4', 1, 'ps4, tay cam ps4, tay cam choi game', NULL, NULL),
(2, 'Xbox one', 'Tay cầm Xbox one', 1, 'xbox, xbox one, tay cam xbox', NULL, NULL),
(3, 'Xbox 360', 'Tay cầm Xbox 360', 1, 'xbox, xbox one, tay cam xbox 360', NULL, NULL),
(4, 'PS5', 'Tay cầm PS5', 1, 'ps5, tay cam ps5', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `coupon_id` int(10) UNSIGNED NOT NULL,
  `coupon_name` varchar(255) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_time` int(11) NOT NULL,
  `coupon_condition` int(11) NOT NULL,
  `coupon_number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`coupon_id`, `coupon_name`, `coupon_code`, `coupon_time`, `coupon_condition`, `coupon_number`, `created_at`, `updated_at`) VALUES
(1, 'Giảm giá 30/4', 'VN30T4', 10, 1, 10, NULL, NULL),
(2, 'Giảm giá Aniversary 2025', 'ANI2025', 5, 2, 100000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `customer_name`, `customer_email`, `customer_password`, `customer_phone`, `created_at`, `updated_at`) VALUES
(1, 'Hào Trương Huỳnh', 'hth@gmail.com', '123456789', '0111111111', NULL, NULL),
(3, 'heisenberg', 'heisenberg@gmail.com', '123456789', '0222222222', NULL, NULL),
(4, 'xavierpena', 'pena@gmail.com', '25f9e794323b453885f5181f1b624d0b', '123456789', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_momo`
--

CREATE TABLE `tbl_momo` (
  `momo_id` int(10) UNSIGNED NOT NULL,
  `partner_code` varchar(255) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `order_info` varchar(255) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `trans_id` varchar(100) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_momo`
--

INSERT INTO `tbl_momo` (`momo_id`, `partner_code`, `order_id`, `amount`, `order_info`, `order_type`, `trans_id`, `pay_type`, `created_at`, `updated_at`) VALUES
(1, 'MOMOBKUN20180529', '1741160898', '1468950', 'Thanh toán qua ATM MoMo', 'momo_wallet', '4360126790', 'napas', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipping_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `order_total` varchar(50) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order`
--

INSERT INTO `tbl_order` (`order_id`, `customer_id`, `shipping_id`, `payment_id`, `order_total`, `order_status`, `created_at`, `updated_at`) VALUES
(6, 4, 3, 11, '726.000 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(7, 4, 4, 12, '1.725.900 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(9, 4, 5, 14, '768.900 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(10, 4, 7, 15, '1.144.500 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(11, 4, 7, 16, '1.144.500 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(12, 4, 7, 17, '1.144.500 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(13, 4, 8, 18, '1.005.900 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(14, 4, 9, 19, '1.468.950 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(15, 4, 10, 20, '838.950 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(16, 4, 10, 21, '838.950 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(17, 4, 11, 22, '1.468.950 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(18, 4, 11, 23, '1.468.950 VNĐ', 'Đang chờ xử lý', NULL, NULL),
(19, 4, 11, 24, '1.468.950 VNĐ', 'Đang chờ xử lý', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `order_details_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` double NOT NULL,
  `product_sales_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`order_details_id`, `order_id`, `product_id`, `product_name`, `product_price`, `product_sales_quantity`, `created_at`, `updated_at`) VALUES
(3, 2, 5, 'Sản phẩm 3', 299999, 2, NULL, NULL),
(4, 2, 9, 'Sản phẩm 4', 220000, 3, NULL, NULL),
(5, 3, 5, 'Sản phẩm 3', 299999, 2, NULL, NULL),
(6, 3, 9, 'Sản phẩm 4', 220000, 3, NULL, NULL),
(7, 4, 5, 'Sản phẩm 3', 299999, 2, NULL, NULL),
(8, 4, 9, 'Sản phẩm 4', 220000, 3, NULL, NULL),
(9, 5, 5, 'Sản phẩm 3', 299999, 2, NULL, NULL),
(10, 5, 9, 'Sản phẩm 4', 220000, 3, NULL, NULL),
(11, 6, 7, 'Sản phẩm 1', 660000, 1, NULL, NULL),
(12, 7, 11, 'Tay Cầm Xbox 360', 479000, 1, NULL, NULL),
(13, 7, 5, 'Tay Cầm Xbox One X', 1090000, 1, NULL, NULL),
(14, 9, 10, 'Tay Cầm Xbox One S Cũ 2ND', 699000, 1, NULL, NULL),
(15, 10, 5, 'Tay Cầm Xbox One X', 1090000, 1, NULL, NULL),
(16, 11, 5, 'Tay Cầm Xbox One X', 1090000, 1, NULL, NULL),
(17, 12, 5, 'Tay Cầm Xbox One X', 1090000, 1, NULL, NULL),
(18, 13, 11, 'Tay Cầm Xbox 360', 479000, 2, NULL, NULL),
(19, 14, 9, 'Tay Cầm Sony DualSense 5 PS5', 1399000, 1, NULL, NULL),
(20, 15, 6, 'Tay Cầm Sony DualShock 4 PS4', 799000, 1, NULL, NULL),
(21, 16, 6, 'Tay Cầm Sony DualShock 4 PS4', 799000, 1, NULL, NULL),
(22, 17, 9, 'Tay Cầm Sony DualSense 5 PS5', 1399000, 1, NULL, NULL),
(23, 18, 9, 'Tay Cầm Sony DualSense 5 PS5', 1399000, 1, NULL, NULL),
(24, 19, 9, 'Tay Cầm Sony DualSense 5 PS5', 1399000, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_id` int(10) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_payment`
--

INSERT INTO `tbl_payment` (`payment_id`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(7, '1', 'Đang chờ xử lý', NULL, NULL),
(8, '2', 'Đang chờ xử lý', NULL, NULL),
(9, '1', 'Đang chờ xử lý', NULL, NULL),
(10, '2', 'Đang chờ xử lý', NULL, NULL),
(11, '2', 'Đang chờ xử lý', NULL, NULL),
(12, '2', 'Đang chờ xử lý', NULL, NULL),
(13, '2', 'Đang chờ xử lý', NULL, NULL),
(14, '2', 'Đang chờ xử lý', NULL, NULL),
(15, '1', 'Đang chờ xử lý', NULL, NULL),
(16, '1', 'Đang chờ xử lý', NULL, NULL),
(17, '1', 'Đang chờ xử lý', NULL, NULL),
(18, '2', 'Đang chờ xử lý', NULL, NULL),
(19, '3', 'Đang chờ xử lý', NULL, NULL),
(20, '3', 'Đang chờ xử lý', NULL, NULL),
(21, '3', 'Đang chờ xử lý', NULL, NULL),
(22, '4', 'Đang chờ xử lý', NULL, NULL),
(23, '4', 'Đang chờ xử lý', NULL, NULL),
(24, '4', 'Đang chờ xử lý', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_desc` text NOT NULL,
  `product_content` text NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_status` int(11) NOT NULL,
  `meta_keywords` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_desc`, `product_content`, `product_price`, `product_image`, `product_status`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(5, 2, 1, 'Tay Cầm Xbox One X', 'Tay Cầm Xbox One X / Xbox Seri X Chính Hãng Đen Carbon Black + Tặng Kèm Cáp Cable USB Chơi Game Tối Ưu Cho FO4 / FIFA / PC', 'Tay Cầm Xbox One X / Xbox Seri X Chính Hãng Đen Carbon Black + Tặng Kèm Cáp Cable USB Chơi Game Tối Ưu Cho FO4 / FIFA / PC', '1090000', 'xboxonex42.jpg', 1, 'tay cam, tay cam xbox, xbox one, xbox one x', NULL, NULL),
(6, 1, 6, 'Tay Cầm Sony DualShock 4 PS4', 'Tay Cầm Sony DualShock 4 PS4 Cũ 2nd + Kèm Cáp USB Chơi Game Tối Ưu Cho PC / FO4 / FIFA | HÀNG MỚI VỀ', 'Tay Cầm Sony DualShock 4 PS4 Cũ 2nd + Kèm Cáp USB Chơi Game Tối Ưu Cho PC / FO4 / FIFA | HÀNG MỚI VỀ', '799000', 'ps42nd98.jpeg', 1, 'ps4, tay cam ps4, ps4 2nd, ps4 mau den', NULL, NULL),
(7, 4, 6, 'Tay Cầm PS5 30th Anniversary', 'Tay Cầm PS5 30th Anniversary Controller Chĩnh Hãng Chơi Game Cho PC / FCO / FIFA / PS5 | HÀNG NHẬP KHẨU', 'Tay Cầm PS5 30th Anniversary Controller Chĩnh Hãng Chơi Game Cho PC / FCO / FIFA / PS5 | HÀNG NHẬP KHẨU', '3050000', 'ps530thanniversary60.jpg', 1, 'ps5, tay cam ps5, ps5 ki niem 30 nam', NULL, NULL),
(9, 4, 6, 'Tay Cầm Sony DualSense 5 PS5', 'Tay Cầm Sony DualSense 5 PS5 Chính Hãng + Top Gamepad Chơi Game Tối Ưu Cho PC / FO4 / FIFA | HÀNG NHẬP KHẨU', 'Tay Cầm Sony DualSense 5 PS5 Chính Hãng + Top Gamepad Chơi Game Tối Ưu Cho PC / FO4 / FIFA | HÀNG NHẬP KHẨU', '1399000', 'ps5trang47.jpg', 1, 'ps5, tay cam ps5, ps5 chinh hang', NULL, NULL),
(10, 2, 1, 'Tay Cầm Xbox One S Cũ 2ND', 'Tay Cầm Xbox One S Cũ 2ND + Cáp Cable USB Chơi Game Tối Ưu Cho FC ONLINE / FIFA / PC / LAPTOP | NOBOX – MÀU TRẮNG', 'Tay Cầm Xbox One S Cũ 2ND + Cáp Cable USB Chơi Game Tối Ưu Cho FC ONLINE / FIFA / PC / LAPTOP | NOBOX – MÀU TRẮNG', '699000', 'xboxones2nd52.jpg', 1, 'tay cam, tay cam xbox, xbox one s', NULL, NULL),
(11, 3, 1, 'Tay Cầm Xbox 360', 'Tay Cầm Xbox 360 C&oacute; D&acirc;y Chĩnh H&atilde;ng Chơi Game Tối Ưu Cho PC / FO3 / FO4 | TOP B&Aacute;N CHẠY', 'Tay Cầm Xbox 360 C&oacute; D&acirc;y Chĩnh H&atilde;ng Chơi Game Tối Ưu Cho PC / FO3 / FO4 | TOP B&Aacute;N CHẠY', '479000', 'xobx36013.jpg', 1, 'xbox, xbox 360, tay cam choi game', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_shipping`
--

CREATE TABLE `tbl_shipping` (
  `shipping_id` int(10) UNSIGNED NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_email` varchar(255) NOT NULL,
  `shipping_note` text NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_shipping`
--

INSERT INTO `tbl_shipping` (`shipping_id`, `shipping_name`, `shipping_email`, `shipping_note`, `shipping_address`, `shipping_phone`, `created_at`, `updated_at`) VALUES
(1, 'Hào', 'haoth@gmail.com', 'Giao cẩn thận', 'Phú Yên', '0988820943', NULL, NULL),
(2, 'paulo escobar', 'paulo@gmail.com', 'hàng đặc biệt', 'Mexico', '123456789', NULL, NULL),
(3, 'Hào', 'haoth@gmail.com', 'abcxyzkasd', 'Phú Yên', '0988820943', NULL, NULL),
(4, 'Xavier Pena', 'pena@gmail.com', 'Ship Carefully', 'Mexico', '123456789', NULL, NULL),
(5, 'Xavier Pena', 'pena@gmail.com', 'abc', 'Phú Yên', '0988820943', NULL, NULL),
(6, 'Hào', 'haoth@gmail.com', 'vnpay', 'Phú Yên', '0988820943', NULL, NULL),
(7, 'Xavier Pena', 'pena@gmail.com', 'Be carefull', 'New Mexico', '123456789', NULL, NULL),
(8, 'Xavier Pena', 'pena@gmail.com', 'Carefully', 'New Mexico', '987654321', NULL, NULL),
(9, 'Xavier Pena', 'pena@gmail.com', 'carefully', 'New Mexico', '0988820943', NULL, NULL),
(10, 'Xavier Pena', 'pena@gmail.com', 'dat tay cam ps4 9h04 5/3/2025', 'New Mexico', '987654321', NULL, NULL),
(11, 'Xavier Pena', 'pena@gmail.com', 'Tay cam ps5 14h17 5/3/2025', 'New Mexico', '0988820943', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_social`
--

CREATE TABLE `tbl_social` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider_user_id` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_social`
--

INSERT INTO `tbl_social` (`user_id`, `provider_user_id`, `provider`, `user`, `created_at`, `updated_at`) VALUES
(9, '115868358498485712861', 'GOOGLE', 11, NULL, NULL),
(10, '3023444524484885', 'facebook', 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_vnpay`
--

CREATE TABLE `tbl_vnpay` (
  `vnpay_id` int(10) UNSIGNED NOT NULL,
  `vnp_amount` varchar(255) NOT NULL,
  `vnp_bankcode` varchar(255) NOT NULL,
  `vnp_banktranno` varchar(255) NOT NULL,
  `vnp_cardtype` varchar(255) NOT NULL,
  `vnp_orderinfo` varchar(255) NOT NULL,
  `vnp_paydate` varchar(255) NOT NULL,
  `vnp_tmncode` varchar(255) NOT NULL,
  `vnp_transactionno` varchar(255) NOT NULL,
  `code_cart` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_vnpay`
--

INSERT INTO `tbl_vnpay` (`vnpay_id`, `vnp_amount`, `vnp_bankcode`, `vnp_banktranno`, `vnp_cardtype`, `vnp_orderinfo`, `vnp_paydate`, `vnp_tmncode`, `vnp_transactionno`, `code_cart`, `created_at`, `updated_at`) VALUES
(1, '83895000', 'NCB', 'VNP14830689', 'ATM', 'Thanh toán đơn hàng test', '20250305091636', 'FY58L6R9', '14830689', '1374', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_brand_product`
--
ALTER TABLE `tbl_brand_product`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Chỉ mục cho bảng `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Chỉ mục cho bảng `tbl_momo`
--
ALTER TABLE `tbl_momo`
  ADD PRIMARY KEY (`momo_id`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`order_details_id`);

--
-- Chỉ mục cho bảng `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Chỉ mục cho bảng `tbl_social`
--
ALTER TABLE `tbl_social`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  ADD PRIMARY KEY (`vnpay_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_brand_product`
--
ALTER TABLE `tbl_brand_product`
  MODIFY `brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `coupon_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_momo`
--
ALTER TABLE `tbl_momo`
  MODIFY `momo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `order_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `payment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  MODIFY `shipping_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_social`
--
ALTER TABLE `tbl_social`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `tbl_vnpay`
--
ALTER TABLE `tbl_vnpay`
  MODIFY `vnpay_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
