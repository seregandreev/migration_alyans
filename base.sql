-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: 10.100.24.78:3306
-- Время создания: Окт 27 2026 г., 12:51
-- Версия сервера: 10.1.48-MariaDB
-- Версия PHP: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `alyans-db`
--
CREATE DATABASE IF NOT EXISTS `alyans-db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `alyans-db`;

-- --------------------------------------------------------

--
-- Структура таблицы `acts`
--

CREATE TABLE `acts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL,
  `work_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sign_inspector` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stamp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `alarms`
--

CREATE TABLE `alarms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_alarm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '5',
  `is_reading` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `abbr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_facility` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gov_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `components`
--

CREATE TABLE `components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `work_location_id` bigint(20) UNSIGNED NOT NULL,
  `tape_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `inspector_id` bigint(20) DEFAULT NULL,
  `date_start_expluatation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pressure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id_update` bigint(20) DEFAULT NULL,
  `date_update` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `conclusions`
--

CREATE TABLE `conclusions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `propan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vik_result` text COLLATE utf8mb4_unicode_ci,
  `vik_comment` text COLLATE utf8mb4_unicode_ci,
  `measure_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uzt_result` text COLLATE utf8mb4_unicode_ci,
  `area_deffects` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deffects_size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mk_result` text COLLATE utf8mb4_unicode_ci,
  `graph` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gi_result` text COLLATE utf8mb4_unicode_ci,
  `uzk_result` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coefficient` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calibration_pressure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diameter_plashki` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inspector_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport` tinyint(1) NOT NULL DEFAULT '0',
  `repair` tinyint(1) NOT NULL DEFAULT '0',
  `no_passportization` tinyint(1) NOT NULL DEFAULT '0',
  `installing_tape` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `temperature` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measure_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_6` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_7` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_8` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_9` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_10` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_next_verification` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signReady` mediumtext COLLATE utf8mb4_unicode_ci,
  `user_id_update` bigint(20) DEFAULT NULL,
  `date_update` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_vik` int(11) DEFAULT NULL,
  `check_uzt` int(11) DEFAULT NULL,
  `check_mk` int(11) DEFAULT NULL,
  `check_gi` int(11) DEFAULT NULL,
  `check_uzk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `conclusion_params`
--

CREATE TABLE `conclusion_params` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `inspector_id` bigint(20) NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_next_verification` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_vu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_vu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vu_validity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pers_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gos_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsible_id` bigint(20) DEFAULT NULL,
  `garante` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `inspectors`
--

CREATE TABLE `inspectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_validity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `control_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `instructions`
--

CREATE TABLE `instructions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `instruments`
--

CREATE TABLE `instruments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `control_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci,
  `sertificate_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_date` text COLLATE utf8mb4_unicode_ci,
  `next_verification_date` text COLLATE utf8mb4_unicode_ci,
  `inventory_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meter_limit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yes_instrument` tinyint(1) NOT NULL DEFAULT '0',
  `scan_passport` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_sertificate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `responsible_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Не обработана',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_conclusions`
--

CREATE TABLE `order_conclusions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `conclusion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `qr_conclusions`
--

CREATE TABLE `qr_conclusions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `number_qr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_exp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `transports`
--

CREATE TABLE `transports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vin_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gos_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mileage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_sts` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_pts` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_service` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_inspection` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_insurance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `make_year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_avto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_sulder` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `garage_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pressure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `life_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tape_length` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature_mode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature_mode1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_non_typical_type` tinyint(1) DEFAULT NULL,
  `abbr_name_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measure_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_6` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_7` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_8` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_9` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure_10` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crimping_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crimping_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crimping_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crimping_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crimping_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crimping_6` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `act_6` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_6` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_on_register` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Пользователь',
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inspector_id` int(11) DEFAULT NULL,
  `bases_list` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocking` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `waybills`
--

CREATE TABLE `waybills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` int(11) NOT NULL,
  `transport_id` int(11) NOT NULL,
  `type_waybill` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_name_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_name_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_medical_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_medical_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_check_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_medical_check_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_medical_check_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transport_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transport_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_transport_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transport_check_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_transport_check_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transport_inspector_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transport_inspector_check_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transport_meliage_before` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disposition_organization_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_departure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transport_departure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_transport_departure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_transport_return` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_transport_return` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_marks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispetcher_id` int(11) DEFAULT NULL,
  `mechanic_id` int(11) DEFAULT NULL,
  `transport_meliage_after` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sulder_issued` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sulder_departure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sulder_return` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_sulder_norm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_sulder_fact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overspending` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id_return` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `work_locations`
--

CREATE TABLE `work_locations` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `work_locations1`
--

CREATE TABLE `work_locations1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `acts`
--
ALTER TABLE `acts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acts_company_id_foreign` (`company_id`),
  ADD KEY `acts_facility_id_foreign` (`facility_id`),
  ADD KEY `acts_work_location_id_foreign` (`work_location_id`);

--
-- Индексы таблицы `alarms`
--
ALTER TABLE `alarms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `components_facility_id_foreign` (`facility_id`),
  ADD KEY `components_company_id_foreign` (`company_id`) USING BTREE,
  ADD KEY `components_work_location_id_foreign` (`work_location_id`) USING BTREE,
  ADD KEY `components_type_id_foreign` (`type_id`);

--
-- Индексы таблицы `conclusions`
--
ALTER TABLE `conclusions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conclusions_inspector_id_foreign` (`inspector_id`),
  ADD KEY `conclusions_component_id_foreign` (`component_id`) USING BTREE;

--
-- Индексы таблицы `conclusion_params`
--
ALTER TABLE `conclusion_params`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `conclusion_params_user_id_foreign` (`user_id`),
  ADD KEY `id_2` (`id`);

--
-- Индексы таблицы `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facilities_company_id_foreign` (`company_id`) USING BTREE;

--
-- Индексы таблицы `inspectors`
--
ALTER TABLE `inspectors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_conclusions`
--
ALTER TABLE `order_conclusions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `qr_conclusions`
--
ALTER TABLE `qr_conclusions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- Индексы таблицы `waybills`
--
ALTER TABLE `waybills`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `work_locations`
--
ALTER TABLE `work_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_locations_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `acts`
--
ALTER TABLE `acts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `alarms`
--
ALTER TABLE `alarms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `components`
--
ALTER TABLE `components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `conclusions`
--
ALTER TABLE `conclusions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `conclusion_params`
--
ALTER TABLE `conclusion_params`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inspectors`
--
ALTER TABLE `inspectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `instructions`
--
ALTER TABLE `instructions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `instruments`
--
ALTER TABLE `instruments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_conclusions`
--
ALTER TABLE `order_conclusions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `qr_conclusions`
--
ALTER TABLE `qr_conclusions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `transports`
--
ALTER TABLE `transports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `waybills`
--
ALTER TABLE `waybills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `work_locations`
--
ALTER TABLE `work_locations`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `acts`
--
ALTER TABLE `acts`
  ADD CONSTRAINT `company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `facility_id` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `work_location_id` FOREIGN KEY (`work_location_id`) REFERENCES `work_locations` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `components_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `components_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `components_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `components_work_location_id_foreign` FOREIGN KEY (`work_location_id`) REFERENCES `work_locations` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `conclusions`
--
ALTER TABLE `conclusions`
  ADD CONSTRAINT `conclusions_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `conclusions_inspector_id_foreign` FOREIGN KEY (`inspector_id`) REFERENCES `inspectors` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `work_locations`
--
ALTER TABLE `work_locations`
  ADD CONSTRAINT `work_locations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
