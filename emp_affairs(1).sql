-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03 فبراير 2026 الساعة 10:16
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emp_affairs`
--

-- --------------------------------------------------------

--
-- بنية الجدول `attendance_deductions`
--

CREATE TABLE `attendance_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `lateness_deduction` decimal(8,2) NOT NULL DEFAULT 0.00,
  `early_leave_deduction` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_deduction` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `fingerprint_device_id` bigint(20) UNSIGNED NOT NULL,
  `print_id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `type` enum('in','out') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `emp_data_id`, `fingerprint_device_id`, `print_id`, `log_date`, `log_time`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '2026-02-01', '08:26:11', 'in', NULL, NULL, NULL),
(2, 1, 1, 2, '2026-02-01', '16:26:43', 'out', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `description`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'الموارد البشرية', 'قسم الموارد البشرية', 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(2, 'الشؤون المالية', 'قسم الشؤون المالية والمحاسبة', 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(3, 'تكنولوجيا المعلومات', 'قسم تكنولوجيا المعلومات والدعم الفني', 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(4, 'الإنتاج', 'قسم الإنتاج والعمليات', 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19');

-- --------------------------------------------------------

--
-- بنية الجدول `employee_shift`
--

CREATE TABLE `employee_shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `work_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`work_days`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employee_shift`
--

INSERT INTO `employee_shift` (`id`, `emp_data_id`, `shift_id`, `from_date`, `to_date`, `work_days`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2015-01-01', '2030-01-01', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Saturday\",\"Sunday\"]', NULL, '2026-02-02 16:05:57', '2026-02-02 16:06:02');

-- --------------------------------------------------------

--
-- بنية الجدول `employment_data`
--

CREATE TABLE `employment_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `insured` tinyint(1) NOT NULL DEFAULT 0,
  `insurance_date` date DEFAULT NULL,
  `insurance_rate` decimal(5,2) DEFAULT NULL,
  `insurance_amount` decimal(10,2) DEFAULT NULL,
  `insurance_number` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employment_data`
--

INSERT INTO `employment_data` (`id`, `emp_id`, `basic_salary`, `insured`, `insurance_date`, `insurance_rate`, `insurance_amount`, `insurance_number`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 6021.00, 1, '2023-01-29', 1.00, 1971.00, 'INS8899', 'Admin', NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(2, 2, 11832.00, 1, '2024-01-29', 10.00, 892.00, 'INS5518', 'Admin', NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20');

-- --------------------------------------------------------

--
-- بنية الجدول `emp_allowances`
--

CREATE TABLE `emp_allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allowance_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `month_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `emp_allowances`
--

INSERT INTO `emp_allowances` (`id`, `allowance_name`, `description`, `year_id`, `month_id`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'عام جديد', NULL, 1, 1, 'Admin', NULL, '2026-01-29 21:29:55', '2026-01-29 21:29:55'),
(2, '2', NULL, 1, 1, 'Admin', NULL, '2026-01-29 22:37:16', '2026-01-29 22:37:16');

-- --------------------------------------------------------

--
-- بنية الجدول `emp_attachments`
--

CREATE TABLE `emp_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `emp_datas`
--

CREATE TABLE `emp_datas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `emp_number` bigint(20) UNSIGNED NOT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `children_count` int(11) NOT NULL DEFAULT 0,
  `national_id` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status_service` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'غير نشط',
  `notes` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `print_id` int(11) NOT NULL,
  `english_name` varchar(255) DEFAULT NULL,
  `computer_skills` varchar(255) DEFAULT NULL,
  `english_proficiency` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `emp_datas`
--

INSERT INTO `emp_datas` (`id`, `full_name`, `emp_number`, `birth_date`, `birth_place`, `gender`, `nationality`, `marital_status`, `children_count`, `national_id`, `phone`, `address`, `status_service`, `experience`, `certificate`, `hire_date`, `department_id`, `job_id`, `status`, `notes`, `profile_image`, `created_by`, `print_id`, `english_name`, `computer_skills`, `english_proficiency`, `religion`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'أحمد محمد علي', 1, '1990-05-12', NULL, 'ذكر', 'مصري', 'متزوج', 2, '29005123456789', '01012345678', 'القاهرة', 'معفى', 'خبرة 5 سنوات', 'بكالوريوس', '2015-03-01', 1, 8, 'نشط', 'موظف ممتاز', NULL, 'Admin', 1, 'Ahmed Mohamed Ali', 'متقدم', 'متوسط', 'مسلم', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(2, 'منى أحمد سعيد', 2, '1992-08-20', NULL, 'أنثى', 'مصري', 'أعزب', 0, '29208203456789', '01123456789', 'الجيزة', 'معفاة', 'خبرة 3 سنوات', 'ماجستير', '2018-07-15', 4, 9, 'نشط', '', NULL, 'Admin', 2, 'Mona Ahmed Said', 'متوسط', 'جيد', 'مسلمة', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19');

-- --------------------------------------------------------

--
-- بنية الجدول `emp_data_fingerprint_device`
--

CREATE TABLE `emp_data_fingerprint_device` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `fingerprint_device_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `emp_data_fingerprint_device`
--

INSERT INTO `emp_data_fingerprint_device` (`id`, `emp_data_id`, `fingerprint_device_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, NULL, NULL),
(2, 2, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `emp_deductions`
--

CREATE TABLE `emp_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `month_id` bigint(20) UNSIGNED NOT NULL,
  `deduction_type` varchar(255) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `emp_deductions`
--

INSERT INTO `emp_deductions` (`id`, `emp_data_id`, `year_id`, `month_id`, `deduction_type`, `quantity`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '0', 10.00, 'Admin', '2026-01-29 21:30:42', '2026-01-29 21:30:42', NULL),
(2, 1, 3, 2, 'تأخير', 100.00, '1', '2026-02-02 16:06:49', '2026-02-02 16:06:49', NULL),
(3, 1, 3, 2, 'غياب', 1.00, '1', '2026-02-02 16:06:49', '2026-02-02 16:06:49', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `emp_permissions`
--

CREATE TABLE `emp_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_data_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `month_id` bigint(20) UNSIGNED NOT NULL,
  `permission_date` date NOT NULL,
  `from_datetime` datetime NOT NULL,
  `to_datetime` datetime NOT NULL,
  `permission_type` tinyint(4) NOT NULL,
  `with_deduction` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `emp_salaries`
--

CREATE TABLE `emp_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `month_id` bigint(20) UNSIGNED NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `working_days` int(11) NOT NULL DEFAULT 30,
  `daily_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `hourly_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `insurance_status` tinyint(4) NOT NULL DEFAULT 0,
  `insurance_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `absence_days` int(11) NOT NULL DEFAULT 0,
  `delay_hours` decimal(10,2) NOT NULL DEFAULT 0.00,
  `penalties` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_allowances` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `emp_salaries`
--

INSERT INTO `emp_salaries` (`id`, `emp_id`, `year_id`, `month_id`, `basic_salary`, `working_days`, `daily_rate`, `hourly_rate`, `advance`, `insurance_status`, `insurance_amount`, `absence_days`, `delay_hours`, `penalties`, `total_deductions`, `total_allowances`, `net_salary`, `payment_number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 0.00, 30, 0.00, 0.00, 0.00, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL),
(3, 1, 1, 1, 6021.00, 30, 200.70, 25.09, 0.00, 0, 0.00, 10, 0.00, 0.00, 2007.00, 0.00, 4014.00, NULL, '2026-01-29 22:13:06', '2026-01-29 22:13:06', NULL),
(4, 1, 1, 1, 6021.00, 30, 200.70, 25.09, 0.00, 0, 0.00, 10, 0.00, 0.00, 2007.00, 0.00, 4014.00, NULL, '2026-01-29 22:20:15', '2026-01-29 22:20:15', NULL),
(5, 1, 1, 1, 6021.00, 30, 200.70, 25.09, 0.00, 1, 1971.00, 10, 0.00, 0.00, 3978.00, 0.00, 2043.00, NULL, '2026-01-29 22:21:48', '2026-01-29 22:21:48', NULL),
(6, 1, 1, 1, 6021.00, 30, 200.70, 25.09, 0.00, 1, 1971.00, 10, 0.00, 0.00, 3978.00, 100.00, 2143.00, NULL, '2026-01-29 22:23:34', '2026-01-29 22:24:55', '2026-01-29 22:24:55'),
(7, 1, 1, 1, 6021.00, 30, 200.70, 25.09, 0.00, 1, 1971.00, 10, 0.00, 0.00, 3978.00, 100.00, 2143.00, NULL, '2026-01-29 22:24:09', '2026-01-29 22:24:24', '2026-01-29 22:24:24'),
(8, 2, 1, 1, 11832.00, 30, 394.40, 49.30, 0.00, 1, 892.00, 1, 0.00, 0.00, 1286.40, 0.00, 10545.60, NULL, '2026-01-29 22:37:46', '2026-01-29 22:45:23', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
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
-- بنية الجدول `fingerprint_devices`
--

CREATE TABLE `fingerprint_devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `port` int(11) NOT NULL DEFAULT 4370,
  `type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `fingerprint_devices`
--

INSERT INTO `fingerprint_devices` (`id`, `ip_address`, `port`, `type`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '192.168.97.201', 4370, '1', 1, '2026-02-02 12:26:01', '2026-02-02 12:26:01', NULL),
(2, '192.168.97.202', 4370, '2', 1, '2026-02-02 13:12:18', '2026-02-02 14:18:15', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `description`, `department_id`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'موظف توظيف', 'موظف توظيف في قسم الموارد البشرية', 1, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(2, 'مسؤول شؤون موظفين', 'مسؤول شؤون موظفين في قسم الموارد البشرية', 1, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(3, 'مدير الموارد البشرية', 'مدير الموارد البشرية في قسم الموارد البشرية', 1, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(4, 'محاسب', 'محاسب في قسم الشؤون المالية', 2, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(5, 'محاسب أول', 'محاسب أول في قسم الشؤون المالية', 2, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(6, 'مدير مالي', 'مدير مالي في قسم الشؤون المالية', 2, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(7, 'مبرمج', 'مبرمج في قسم تكنولوجيا المعلومات', 3, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(8, 'مدير نظم', 'مدير نظم في قسم تكنولوجيا المعلومات', 3, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(9, 'فني دعم', 'فني دعم في قسم تكنولوجيا المعلومات', 3, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(10, 'مشرف إنتاج', 'مشرف إنتاج في قسم الإنتاج', 4, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(11, 'عامل إنتاج', 'عامل إنتاج في قسم الإنتاج', 4, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(12, 'مدير إنتاج', 'مدير إنتاج في قسم الإنتاج', 4, 'Admin', NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19');

-- --------------------------------------------------------

--
-- بنية الجدول `lateness_rules`
--

CREATE TABLE `lateness_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_minutes` int(11) NOT NULL,
  `to_minutes` int(11) NOT NULL,
  `deduction_type` enum('fixed','percentage','day') NOT NULL,
  `deduction_value` decimal(8,2) NOT NULL,
  `early_leave_type` enum('fixed','percentage','day') DEFAULT NULL,
  `early_leave_value` decimal(8,2) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `lateness_rules`
--

INSERT INTO `lateness_rules` (`id`, `from_minutes`, `to_minutes`, `deduction_type`, `deduction_value`, `early_leave_type`, `early_leave_value`, `notes`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 10, 100, 'fixed', 100.00, 'fixed', 10.00, NULL, 1, '2026-02-02 13:25:31', '2026-02-02 13:25:31', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_03_194439_create_departments_table', 1),
(6, '2026_01_03_194731_create_jobs_table', 1),
(7, '2026_01_04_155836_create_permission_tables', 1),
(8, '2026_01_04_163916_laratrust_setup_tables', 1),
(9, '2026_01_07_122048_create_emp_datas_table', 1),
(10, '2026_01_07_175755_create_emp_attachments_table', 1),
(11, '2026_01_09_155650_create_emp_employments_table', 1),
(12, '2026_01_14_142916_create_years_table', 1),
(13, '2026_01_14_143006_create_months_table', 1),
(14, '2026_01_14_143340_create_emp_deductions_table', 1),
(15, '2026_01_14_144159_create_emp_allowances_table', 1),
(16, '2026_01_20_124753_create_emp_permissions_table', 1),
(17, '2026_01_20_190700_create_notifications_table', 1),
(18, '2026_01_22_140736_create_organizations_table', 1),
(19, '2026_01_23_180800_create_fingerprint_devices_table', 1),
(20, '2026_01_23_182318_create_emp_data_fingerprint_device_table', 1),
(21, '2026_01_23_182849_create_attendance_logs_table', 1),
(22, '2026_01_24_182849_create_attendance_deductions_table', 1),
(23, '2026_01_25_205618_create_shifts_table', 1),
(24, '2026_01_25_210219_create_employee_shift_table', 1),
(25, '2026_01_25_210219_create_lateness_rules_table', 1),
(26, '2026_01_27_142251_create_emp_salaries_table', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- بنية الجدول `months`
--

CREATE TABLE `months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `month_name` varchar(255) NOT NULL,
  `month_number` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `months`
--

INSERT INTO `months` (`id`, `year_id`, `month_name`, `month_number`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(2, 1, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(3, 1, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(4, 1, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(5, 1, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(6, 1, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(7, 1, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(8, 1, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(9, 1, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(10, 1, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(11, 1, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(12, 1, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(13, 2, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(14, 2, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(15, 2, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(16, 2, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(17, 2, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(18, 2, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(19, 2, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(20, 2, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(21, 2, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(22, 2, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(23, 2, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(24, 2, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(25, 3, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(26, 3, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(27, 3, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(28, 3, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(29, 3, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(30, 3, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(31, 3, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(32, 3, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(33, 3, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(34, 3, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(35, 3, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(36, 3, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(37, 4, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(38, 4, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(39, 4, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(40, 4, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(41, 4, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(42, 4, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(43, 4, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(44, 4, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(45, 4, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(46, 4, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(47, 4, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(48, 4, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(49, 5, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(50, 5, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(51, 5, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(52, 5, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(53, 5, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(54, 5, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(55, 5, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(56, 5, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(57, 5, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(58, 5, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(59, 5, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(60, 5, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(61, 6, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(62, 6, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(63, 6, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(64, 6, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(65, 6, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(66, 6, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(67, 6, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(68, 6, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(69, 6, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(70, 6, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(71, 6, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(72, 6, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(73, 7, 'يناير', 1, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(74, 7, 'فبراير', 2, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(75, 7, 'مارس', 3, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(76, 7, 'ابريل', 4, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(77, 7, 'مايو', 5, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(78, 7, 'يونيو', 6, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(79, 7, 'يوليو', 7, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(80, 7, 'اغسطس', 8, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(81, 7, 'سبتمبر', 9, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(82, 7, 'اكتوبر', 10, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(83, 7, 'نوفمبر', 11, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(84, 7, 'ديسمبر', 12, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(85, 8, 'يناير', 1, NULL, '2026-01-29 23:32:31', '2026-01-29 23:32:31');

-- --------------------------------------------------------

--
-- بنية الجدول `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('13a1beaa-2684-4290-b451-60dfe1026221', 'App\\Notifications\\DeductionNotification', 'App\\Models\\User', 2, '{\"type\":\"deduction\",\"title\":\"\\u062a\\u0645 \\u0625\\u0636\\u0627\\u0641\\u0629 \\u062e\\u0635\\u0645 \\u062c\\u062f\\u064a\\u062f\",\"employee_name\":\"\\u0623\\u062d\\u0645\\u062f \\u0645\\u062d\\u0645\\u062f \\u0639\\u0644\\u064a\",\"quantity\":\"10\"}', NULL, '2026-01-29 21:30:42', '2026-01-29 21:30:42'),
('1b937483-1f04-4863-a6db-af5138e9a639', 'App\\Notifications\\DeductionNotification', 'App\\Models\\User', 1, '{\"type\":\"deduction\",\"title\":\"\\u062a\\u0645 \\u0625\\u0636\\u0627\\u0641\\u0629 \\u062e\\u0635\\u0645 \\u062c\\u062f\\u064a\\u062f\",\"employee_name\":\"\\u0623\\u062d\\u0645\\u062f \\u0645\\u062d\\u0645\\u062f \\u0639\\u0644\\u064a\",\"quantity\":\"10\"}', '2026-01-29 21:43:09', '2026-01-29 21:30:42', '2026-01-29 21:43:09');

-- --------------------------------------------------------

--
-- بنية الجدول `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `english_name` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `commercial_register` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `english_name`, `tax_number`, `commercial_register`, `phone`, `email`, `website`, `address`, `description`, `logo`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'الشركة المثال', 'Example Company', '123456789', '987654321', '+201234567890', 'info@example.com', 'https://example.com', 'القاهرة، مصر', 'هذه شركة نموذجية للتوضيح.', 'logos/zXiodNVrLvVR872NErgxzLWmpz07gFfzMrDcxG9n.png', 'admin', '2026-01-29 21:09:20', '2026-02-02 14:55:48', NULL),
(2, 'الشركة المثال', 'Example Company', '123456789', '987654321', '+201234567890', 'info@example.com', 'https://example.com', 'القاهرة، مصر', 'هذه شركة نموذجية للتوضيح.', 'logos/example_logo.png', 'admin', '2026-01-29 22:56:01', '2026-01-29 22:56:01', NULL),
(3, 'الشركة المثال', 'Example Company', '123456789', '987654321', '+201234567890', 'info@example.com', 'https://example.com', 'القاهرة، مصر', 'هذه شركة نموذجية للتوضيح.', 'logos/example_logo.png', 'admin', '2026-01-29 23:08:10', '2026-01-29 23:08:10', NULL),
(4, 'الشركة المثال', 'Example Company', '123456789', '987654321', '+201234567890', 'info@example.com', 'https://example.com', 'القاهرة، مصر', 'هذه شركة نموذجية للتوضيح.', 'logos/example_logo.png', 'admin', '2026-01-29 23:17:59', '2026-01-29 23:17:59', NULL),
(5, 'الشركة المثال', 'Example Company', '123456789', '987654321', '+201234567890', 'info@example.com', 'https://example.com', 'القاهرة، مصر', 'هذه شركة نموذجية للتوضيح.', 'logos/example_logo.png', 'admin', '2026-01-29 23:21:21', '2026-01-29 23:21:21', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'عرض إعدادات النظام', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(2, 'تعديل إعدادات النظام', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(3, 'نظرة عامة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(4, 'عرض صلاحية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(5, 'اضافة صلاحية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(6, 'تعديل صلاحية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(7, 'حذف صلاحية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(8, 'عرض مستخدم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(9, 'اضافة مستخدم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(10, 'تعديل مستخدم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(11, 'حذف مستخدم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(12, 'الهيكل الإداري', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(13, 'عرض الإدارات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(14, 'اضافة إدارة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(15, 'تعديل إدارة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(16, 'حذف إدارة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(17, 'عرض الوظائف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(18, 'اضافة وظيفة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(19, 'تعديل وظيفة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(20, 'حذف وظيفة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(21, 'الموظفون', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(22, 'عرض الموظفين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(23, 'اضافة موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(24, 'تعديل موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(25, 'حذف موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(26, 'عرض معلومات الموظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(27, 'طباعة بطاقة الموظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(28, 'تصدير اكسيل موظفين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(29, 'استيراد اكسيل موظفين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(30, 'عرض مرفق موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(31, 'اضافة مرفق موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(32, 'حذف مرفق موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(33, 'تحميل مرفق موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(34, 'عرض بيانات التوظيف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(35, 'اضافة بيانات التوظيف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(36, 'تعديل بيانات التوظيف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(37, 'حذف بيانات التوظيف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(38, 'عرض حالات الموظفين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(39, 'اضافة حالة موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(40, 'تعديل حالة موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(41, 'حذف حالة موظف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(42, 'الحضور والانصراف', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(43, 'عرض الحضور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(44, 'اضافة حضور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(45, 'تعديل حضور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(46, 'حذف حضور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(47, 'عرض الورديات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(48, 'اضافة وردية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(49, 'تعديل وردية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(50, 'حذف وردية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(51, 'عرض الأذونات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(52, 'اضافة إذن', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(53, 'تعديل إذن', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(54, 'حذف إذن', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(55, 'عرض العمل الإضافي', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(56, 'اضافة عمل إضافي', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(57, 'تعديل عمل إضافي', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(58, 'حذف عمل إضافي', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(59, 'الرواتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(60, 'عرض الرواتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(61, 'انشاء راتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(62, 'تعديل راتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(63, 'حذف راتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(64, 'اعتماد راتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(65, 'عرض كشف المرتبات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(66, 'اضافة كشف مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(67, 'تعديل كشف مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(68, 'حذف كشف مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(69, 'عرض البدلات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(70, 'اضافة بدل', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(71, 'تعديل بدل', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(72, 'حذف بدل', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(73, 'عرض الخصومات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(74, 'اضافة خصم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(75, 'تعديل خصم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(76, 'حذف خصم', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(77, 'عرض مرفق مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(78, 'اضافة مرفق مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(79, 'حذف مرفق مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(80, 'تحميل مرفق مرتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(81, 'التقارير', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(82, 'تقرير الحضور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(83, 'تقرير الموظفين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(84, 'تقرير البدلات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(85, 'تقرير الخصومات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(86, 'تقرير الرواتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(87, 'تقرير كشف المرتبات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(88, 'إعدادات الوقت', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(89, 'عرض السنين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(90, 'اضافة سنة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(91, 'تعديل سنة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(92, 'حذف سنة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(93, 'عرض الشهور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(94, 'اضافة شهر', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(95, 'تعديل شهر', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(96, 'حذف شهر', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(97, 'عرض التقارير', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(98, 'تقارير الموظفين', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(99, 'تقارير الحضور', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(100, 'تقارير الرواتب', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(101, 'تقارير البدلات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(102, 'تقارير الخصومات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(103, 'تفاصيل المنشأة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(104, 'تعديل منشأة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(105, 'القاعدة العامة', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(106, 'اضافة قاعدة تأخير', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(107, 'تعديل قاعدة تأخير', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(108, 'حذف قاعدة تأخير', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(109, 'إعدادات النظام المالي', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(110, 'تعديل إعدادات المرتبات', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(111, 'اعتماد كشوف الرواتب النهائية', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(112, 'الأجهزة والطابعات', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(113, 'عرض الأجهزة', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(114, 'اضافة جهاز', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(115, 'تعديل جهاز', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(116, 'حذف جهاز', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(117, 'اختبار اتصال الجهاز', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(118, 'سحب بيانات الجهاز', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(119, 'ربط الموظفين بالأجهزة', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(120, 'عرض مرفقات الحضور', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(121, 'اضافة مرفق حضور', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(122, 'حذف مرفق حضور', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(123, 'تحميل مرفق حضور', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(124, 'عرض الملاحظات', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(125, 'اضافة ملاحظة', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(126, 'تعديل ملاحظة', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(127, 'حذف ملاحظة', 'web', '2026-01-29 23:08:10', '2026-01-29 23:08:10'),
(128, 'أجهزة البصمة', 'web', '2026-01-29 23:17:59', '2026-01-29 23:17:59'),
(129, 'حساب الخصومات اليومية', 'web', '2026-01-29 23:17:59', '2026-01-29 23:17:59'),
(130, 'سجلات الحضور', 'web', '2026-01-29 23:17:59', '2026-01-29 23:17:59'),
(131, 'الورديات', 'web', '2026-01-29 23:17:59', '2026-01-29 23:17:59'),
(132, 'ربط الموظفين بالورديات', 'web', '2026-01-29 23:17:59', '2026-01-29 23:17:59'),
(133, 'عرض أجهزة البصمة', 'web', '2026-01-29 23:21:21', '2026-01-29 23:21:21'),
(134, 'ربط الأجهزة بالموظفين', 'web', '2026-01-29 23:21:21', '2026-01-29 23:21:21'),
(135, 'سحب بيانات البصمة', 'web', '2026-01-29 23:21:21', '2026-01-29 23:21:21');

-- --------------------------------------------------------

--
-- بنية الجدول `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `personal_access_tokens`
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

-- --------------------------------------------------------

--
-- بنية الجدول `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(2, 'User', 'web', '2026-01-29 21:09:19', '2026-01-29 21:09:19');

-- --------------------------------------------------------

--
-- بنية الجدول `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(8, 2),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `salary_allowances`
--

CREATE TABLE `salary_allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_salary_id` bigint(20) UNSIGNED NOT NULL,
  `allowance_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `salary_allowances`
--

INSERT INTO `salary_allowances` (`id`, `emp_salary_id`, `allowance_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 100.00, '2026-01-29 22:23:34', '2026-01-29 22:23:34'),
(2, 7, 1, 100.00, '2026-01-29 22:24:09', '2026-01-29 22:24:09');

-- --------------------------------------------------------

--
-- بنية الجدول `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `shifts`
--

INSERT INTO `shifts` (`id`, `name`, `start_time`, `end_time`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'الاساسية', '08:00:00', '14:00:00', NULL, '2026-02-02 16:04:54', '2026-02-02 16:04:54', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `roles_name` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roles_name`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@itd-eg.com', NULL, '$2y$10$MRORjSXe6.dRyunjKWJhNukAc78rkODwB98ogYDPOfWRDG9VS146a', 'Admin', 'ftI5GKOH6vhfGm5bGkwoGPgwS2LEuGSCozWuQfQFXyiDxOtaapG0mSW9VJyK', '2026-01-29 21:09:19', '2026-01-29 21:09:19'),
(2, 'Normal User', 'user@itd-eg.com', NULL, '$2y$10$QRe5n0s37TBydcCrOPD2OedPYAb4/7STU0NgsRM/ptQ7wDMspf7m.', NULL, NULL, '2026-01-29 21:09:19', '2026-01-29 21:09:19');

-- --------------------------------------------------------

--
-- بنية الجدول `years`
--

CREATE TABLE `years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `years`
--

INSERT INTO `years` (`id`, `year`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2024, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(2, 2025, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(3, 2026, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(4, 2027, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(5, 2028, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(6, 2029, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(7, 2030, NULL, '2026-01-29 21:09:20', '2026-01-29 21:09:20'),
(8, 2031, NULL, '2026-01-29 23:25:07', '2026-01-29 23:25:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_deductions`
--
ALTER TABLE `attendance_deductions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_deductions_emp_data_id_date_unique` (`emp_data_id`,`date`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_unique_idx` (`emp_data_id`,`fingerprint_device_id`,`print_id`),
  ADD KEY `attendance_logs_fingerprint_device_id_foreign` (`fingerprint_device_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_shift`
--
ALTER TABLE `employee_shift`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_shift_emp_data_id_shift_id_from_date_to_date_unique` (`emp_data_id`,`shift_id`,`from_date`,`to_date`),
  ADD KEY `employee_shift_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `employment_data`
--
ALTER TABLE `employment_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employment_data_emp_id_foreign` (`emp_id`);

--
-- Indexes for table `emp_allowances`
--
ALTER TABLE `emp_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_allowances_year_id_foreign` (`year_id`),
  ADD KEY `emp_allowances_month_id_foreign` (`month_id`);

--
-- Indexes for table `emp_attachments`
--
ALTER TABLE `emp_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_attachments_emp_data_id_foreign` (`emp_data_id`);

--
-- Indexes for table `emp_datas`
--
ALTER TABLE `emp_datas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_datas_national_id_unique` (`national_id`),
  ADD KEY `emp_datas_department_id_foreign` (`department_id`),
  ADD KEY `emp_datas_job_id_foreign` (`job_id`);

--
-- Indexes for table `emp_data_fingerprint_device`
--
ALTER TABLE `emp_data_fingerprint_device`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_data_fingerprint_device_emp_data_id_foreign` (`emp_data_id`),
  ADD KEY `emp_data_fingerprint_device_fingerprint_device_id_foreign` (`fingerprint_device_id`);

--
-- Indexes for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_deductions_emp_data_id_foreign` (`emp_data_id`),
  ADD KEY `emp_deductions_year_id_foreign` (`year_id`),
  ADD KEY `emp_deductions_month_id_foreign` (`month_id`);

--
-- Indexes for table `emp_permissions`
--
ALTER TABLE `emp_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_permissions_emp_data_id_foreign` (`emp_data_id`),
  ADD KEY `emp_permissions_year_id_foreign` (`year_id`),
  ADD KEY `emp_permissions_month_id_foreign` (`month_id`);

--
-- Indexes for table `emp_salaries`
--
ALTER TABLE `emp_salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_salaries_emp_id_foreign` (`emp_id`),
  ADD KEY `emp_salaries_year_id_foreign` (`year_id`),
  ADD KEY `emp_salaries_month_id_foreign` (`month_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fingerprint_devices`
--
ALTER TABLE `fingerprint_devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_department_id_foreign` (`department_id`);

--
-- Indexes for table `lateness_rules`
--
ALTER TABLE `lateness_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`),
  ADD KEY `months_year_id_foreign` (`year_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_allowances`
--
ALTER TABLE `salary_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_allowances_emp_salary_id_foreign` (`emp_salary_id`),
  ADD KEY `salary_allowances_allowance_id_foreign` (`allowance_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `years_year_unique` (`year`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_deductions`
--
ALTER TABLE `attendance_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_shift`
--
ALTER TABLE `employee_shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employment_data`
--
ALTER TABLE `employment_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_allowances`
--
ALTER TABLE `emp_allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_attachments`
--
ALTER TABLE `emp_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_datas`
--
ALTER TABLE `emp_datas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_data_fingerprint_device`
--
ALTER TABLE `emp_data_fingerprint_device`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emp_permissions`
--
ALTER TABLE `emp_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salaries`
--
ALTER TABLE `emp_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fingerprint_devices`
--
ALTER TABLE `fingerprint_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lateness_rules`
--
ALTER TABLE `lateness_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salary_allowances`
--
ALTER TABLE `salary_allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `attendance_deductions`
--
ALTER TABLE `attendance_deductions`
  ADD CONSTRAINT `attendance_deductions_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD CONSTRAINT `attendance_logs_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_logs_fingerprint_device_id_foreign` FOREIGN KEY (`fingerprint_device_id`) REFERENCES `fingerprint_devices` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `employee_shift`
--
ALTER TABLE `employee_shift`
  ADD CONSTRAINT `employee_shift_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_shift_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `employment_data`
--
ALTER TABLE `employment_data`
  ADD CONSTRAINT `employment_data_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `emp_allowances`
--
ALTER TABLE `emp_allowances`
  ADD CONSTRAINT `emp_allowances_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_allowances_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `emp_attachments`
--
ALTER TABLE `emp_attachments`
  ADD CONSTRAINT `emp_attachments_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `emp_datas`
--
ALTER TABLE `emp_datas`
  ADD CONSTRAINT `emp_datas_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `emp_datas_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL;

--
-- قيود الجداول `emp_data_fingerprint_device`
--
ALTER TABLE `emp_data_fingerprint_device`
  ADD CONSTRAINT `emp_data_fingerprint_device_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`),
  ADD CONSTRAINT `emp_data_fingerprint_device_fingerprint_device_id_foreign` FOREIGN KEY (`fingerprint_device_id`) REFERENCES `fingerprint_devices` (`id`);

--
-- قيود الجداول `emp_deductions`
--
ALTER TABLE `emp_deductions`
  ADD CONSTRAINT `emp_deductions_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_deductions_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_deductions_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `emp_permissions`
--
ALTER TABLE `emp_permissions`
  ADD CONSTRAINT `emp_permissions_emp_data_id_foreign` FOREIGN KEY (`emp_data_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_permissions_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_permissions_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `emp_salaries`
--
ALTER TABLE `emp_salaries`
  ADD CONSTRAINT `emp_salaries_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `emp_datas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_salaries_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emp_salaries_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `months`
--
ALTER TABLE `months`
  ADD CONSTRAINT `months_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `salary_allowances`
--
ALTER TABLE `salary_allowances`
  ADD CONSTRAINT `salary_allowances_allowance_id_foreign` FOREIGN KEY (`allowance_id`) REFERENCES `emp_allowances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salary_allowances_emp_salary_id_foreign` FOREIGN KEY (`emp_salary_id`) REFERENCES `emp_salaries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
