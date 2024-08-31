-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 14, 2023 at 07:36 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_types`
--

DROP TABLE IF EXISTS `age_types`;
CREATE TABLE IF NOT EXISTS `age_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `age_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ages` json DEFAULT NULL,
  `min_age` int DEFAULT NULL,
  `max_age` int DEFAULT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `age_types`
--

INSERT INTO `age_types` (`id`, `age_type`, `ages`, `min_age`, `max_age`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'S1', '[9, 11]', 4, 7, 'group for all', '2023-06-12 20:13:31', '2023-06-12 20:13:31'),
(4, 'Group 1', '[\"7\", \"9\", \"1\"]', 5, 9, 'Very smart', '2023-06-13 17:53:00', '2023-06-13 18:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` tinyint(1) NOT NULL DEFAULT '0',
  `question_id` bigint UNSIGNED NOT NULL,
  `child_session_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `answers_question_id_foreign` (`question_id`),
  KEY `answers_child_session_id_foreign` (`child_session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('Missions','Challenges','Child_Info','Child_Document_Challenge','User_Info','Trophies') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `type`, `created_at`, `updated_at`) VALUES
(2, 'Child_Info', '2023-06-12 19:41:59', '2023-06-12 19:41:59'),
(4, 'User_Info', '2023-06-12 20:20:56', '2023-06-12 20:20:56'),
(5, 'User_Info', '2023-06-12 20:22:57', '2023-06-12 20:22:57'),
(6, 'Missions', '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(7, 'Challenges', '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(8, 'Challenges', '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(9, 'Child_Document_Challenge', '2023-06-13 17:07:42', '2023-06-13 17:07:42'),
(10, 'Child_Info', '2023-06-13 18:34:54', '2023-06-13 18:34:54'),
(11, 'Child_Info', '2023-06-13 19:10:10', '2023-06-13 19:10:10'),
(21, 'Child_Document_Challenge', '2023-06-13 20:36:19', '2023-06-13 20:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

DROP TABLE IF EXISTS `challenges`;
CREATE TABLE IF NOT EXISTS `challenges` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` double NOT NULL,
  `is_timed` tinyint(1) NOT NULL DEFAULT '0',
  `duration_in_days` int DEFAULT NULL,
  `duration_in_hours` double(8,2) DEFAULT NULL,
  `status` enum('Active','InActive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `mission_id` bigint UNSIGNED NOT NULL,
  `attachment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `challenges_mission_id_foreign` (`mission_id`),
  KEY `challenges_attachment_id_foreign` (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `name`, `points`, `is_timed`, `duration_in_days`, `duration_in_hours`, `status`, `mission_id`, `attachment_id`, `created_at`, `updated_at`) VALUES
(1, 'challenge one', 20, 1, 0, 4.50, 'Active', 1, 7, '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(2, 'challenge two', 40, 1, 0, 4.50, 'Active', 1, 8, '2023-06-12 20:24:46', '2023-06-12 20:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `challenge_child`
--

DROP TABLE IF EXISTS `challenge_child`;
CREATE TABLE IF NOT EXISTS `challenge_child` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `progress` int NOT NULL,
  `status` enum('Not_Completed','Completed','Rejected','Pending') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `challenge_id` bigint UNSIGNED NOT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `attachment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `challenge_child_challenge_id_foreign` (`challenge_id`),
  KEY `challenge_child_child_id_foreign` (`child_id`),
  KEY `challenge_child_attachment_id_foreign` (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `challenge_child`
--

INSERT INTO `challenge_child` (`id`, `progress`, `status`, `description`, `challenge_id`, `child_id`, `attachment_id`, `created_at`, `updated_at`) VALUES
(6, 50, 'Pending', NULL, 1, 1, 21, '2023-06-13 20:00:17', '2023-06-13 20:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

DROP TABLE IF EXISTS `children`;
CREATE TABLE IF NOT EXISTS `children` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` double NOT NULL DEFAULT '0',
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED NOT NULL,
  `attachment_id` bigint UNSIGNED DEFAULT NULL,
  `position_id` bigint UNSIGNED DEFAULT NULL,
  `trip_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `children_parent_id_foreign` (`parent_id`),
  KEY `children_attachment_id_foreign` (`attachment_id`),
  KEY `children_position_id_foreign` (`position_id`),
  KEY `children_trip_id_foreign` (`trip_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `first_name`, `last_name`, `username`, `password`, `gender`, `birth_date`, `is_active`, `school_name`, `points`, `notes`, `parent_id`, `attachment_id`, `position_id`, `trip_id`, `created_at`, `updated_at`) VALUES
(1, 'elie', 'karrrra', 'sami_chgbw', '$2y$10$ksKeYbjujPNx5LGlP5cHGOoZPNvsOiv3f56VI3yZIxU9uxQQDeDTO', 'male', '2010-09-16', 1, 'amal alouroba', 0, 'note tests', 8, 2, NULL, NULL, '2023-06-12 19:41:59', '2023-06-13 21:27:56'),
(2, 'sam issauio', 'karra', 'ahmad_chUDM', '$2y$10$wEcOTOMBRp5vRH2aOKNCGeOC7/YSG2TBq9GJJZrDzR83Fwbaa.Ufi', 'male', '2010-09-16', 1, 'amal alouroba', 0, 'sdjfahlfksdjhadslkjh', 12, NULL, NULL, NULL, '2023-06-13 18:34:54', '2023-06-13 19:04:43'),
(3, 'sam issauio', 'karra', 'ahmad_chYhD', '$2y$10$SmwahJ8b7YmqpYTmxIRrieCTGuGS7J6QmE7OIuYgHFcZdm6vtW3aW', 'male', '2010-09-16', 1, 'amal alouroba', 0, 'sdjfahlfksdjhadslkjh', 13, NULL, NULL, NULL, '2023-06-13 19:10:10', '2023-06-13 19:16:21'),
(4, 'Yasser', 'Trabulsi', 'yasmine_chCOc', '$2y$10$OeAo5aprnEHatDtxbINZiOoHn96YCnhvGxNV/rsw26lk/Oz2Qp9.W', 'male', '2018-03-03', 1, 'SABIS', 0, 'Very Smartttttt......', 14, NULL, NULL, NULL, '2023-06-13 20:29:03', '2023-06-13 20:38:09');

-- --------------------------------------------------------

--
-- Table structure for table `child_group`
--

DROP TABLE IF EXISTS `child_group`;
CREATE TABLE IF NOT EXISTS `child_group` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` enum('Active','InActive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `child_group_child_id_foreign` (`child_id`),
  KEY `child_group_group_id_foreign` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `child_group`
--

INSERT INTO `child_group` (`id`, `status`, `description`, `child_id`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'any thing', 1, 1, '2023-06-12 20:28:31', '2023-06-12 20:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `child_mission`
--

DROP TABLE IF EXISTS `child_mission`;
CREATE TABLE IF NOT EXISTS `child_mission` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `progress` double NOT NULL,
  `status` enum('Done','InProgress') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mission_program_id` bigint UNSIGNED NOT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `child_mission_mission_program_id_foreign` (`mission_program_id`),
  KEY `child_mission_child_id_foreign` (`child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `child_mission`
--

INSERT INTO `child_mission` (`id`, `progress`, `status`, `mission_program_id`, `child_id`, `created_at`, `updated_at`) VALUES
(1, 0, 'InProgress', 1, 1, '2023-06-13 17:00:17', '2023-06-13 17:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `child_session`
--

DROP TABLE IF EXISTS `child_session`;
CREATE TABLE IF NOT EXISTS `child_session` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` enum('completed','not_completed','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_completed',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `child_session_child_id_foreign` (`child_id`),
  KEY `child_session_session_id_foreign` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `child_trip_checklists`
--

DROP TABLE IF EXISTS `child_trip_checklists`;
CREATE TABLE IF NOT EXISTS `child_trip_checklists` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `attendance` tinyint(1) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trip_id` bigint UNSIGNED NOT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `child_trip_checklists_trip_id_foreign` (`trip_id`),
  KEY `child_trip_checklists_child_id_foreign` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `concepts`
--

DROP TABLE IF EXISTS `concepts`;
CREATE TABLE IF NOT EXISTS `concepts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `concepts_session_id_foreign` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `concepts`
--

INSERT INTO `concepts` (`id`, `name`, `description`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 'concept one', 'description for concept one', 1, '2023-06-13 14:56:24', '2023-06-13 14:56:24'),
(2, 'concept one', 'description for concept one', 1, '2023-06-13 14:56:31', '2023-06-13 14:56:31'),
(3, 'concept one', 'description for concept one', 1, '2023-06-13 14:56:32', '2023-06-13 14:56:32'),
(4, 'concept one', 'description for concept one', 1, '2023-06-13 14:56:34', '2023-06-13 14:56:34'),
(5, 'concept one', 'description for concept one', 2, '2023-06-13 14:56:35', '2023-06-13 14:56:35'),
(6, 'concept one', 'description for concept one', 2, '2023-06-13 14:56:37', '2023-06-13 14:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `facilitator_group`
--

DROP TABLE IF EXISTS `facilitator_group`;
CREATE TABLE IF NOT EXISTS `facilitator_group` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facilitator_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `facilitator_group_facilitator_id_foreign` (`facilitator_id`),
  KEY `facilitator_group_group_id_foreign` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilitator_group`
--

INSERT INTO `facilitator_group` (`id`, `notes`, `facilitator_id`, `group_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, '2023-06-12 23:23:48', '2023-06-12 23:23:48'),
(2, NULL, 10, 1, '2023-06-12 23:23:48', '2023-06-12 23:23:48'),
(3, NULL, 10, 2, '2023-06-12 23:23:59', '2023-06-12 23:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `facilitator_trip`
--

DROP TABLE IF EXISTS `facilitator_trip`;
CREATE TABLE IF NOT EXISTS `facilitator_trip` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_of_trip` date NOT NULL,
  `type` enum('OneWay','Return') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason_of_switch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_facilitator_id` bigint UNSIGNED NOT NULL,
  `actual_facilitator_id` bigint UNSIGNED NOT NULL,
  `trip_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `facilitator_trip_expected_facilitator_id_foreign` (`expected_facilitator_id`),
  KEY `facilitator_trip_actual_facilitator_id_foreign` (`actual_facilitator_id`),
  KEY `facilitator_trip_trip_id_foreign` (`trip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('image','pdf','svg') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `attachment_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `files_attachment_id_foreign` (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `type`, `file_path`, `description`, `order`, `attachment_id`, `created_at`, `updated_at`) VALUES
(3, 'image', 'storage/child_files/2023_06_12_182426_Screenshot (9).png', 'this file for child info adn this is for test', 1, 2, '2023-06-12 19:41:59', '2023-06-12 19:41:59'),
(4, 'image', 'storage/child_files/2023_06_12_190622_Screenshot 2023-05-28 194629.png', NULL, 2, 2, '2023-06-12 19:41:59', '2023-06-12 19:41:59'),
(6, 'image', 'storage/user_files/2023_06_12_439224_Screenshot (9).png', NULL, 1, 4, '2023-06-12 20:20:56', '2023-06-12 20:20:56'),
(7, 'image', 'storage/user_files/2023_06_12_135105_Screenshot (9).png', NULL, 1, 5, '2023-06-12 20:22:57', '2023-06-12 20:22:57'),
(8, 'image', 'storage/missions_files/2023_06_12_955919_Screenshot 2023-03-10 183706.png', NULL, 1, 6, '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(9, 'image', 'storage/challenges_files/2023_06_12_972824_Screenshot 2023-03-10 183706.png', NULL, 1, 7, '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(10, 'image', 'storage/challenges_files/2023_06_12_982235_Screenshot 2023-03-10 184100.png', NULL, 1, 8, '2023-06-12 20:24:46', '2023-06-12 20:24:46'),
(11, 'image', 'storage/children_document_challenges/2023_06_13_527846_rating.png', 'rating photo', 1, 9, '2023-06-13 17:07:42', '2023-06-13 17:07:42'),
(12, 'image', 'storage/children_document_challenges/2023_06_13_996920_storage.png', 'storage', 2, 9, '2023-06-13 17:07:42', '2023-06-13 17:07:42'),
(13, 'image', 'storage/child_files/2023_06_13_102733_Screenshot (9).png', 'this file for child info adn this is for test', 1, 10, '2023-06-13 18:34:54', '2023-06-13 18:34:54'),
(14, 'image', 'storage/child_files/2023_06_13_111587_Screenshot (9).png', NULL, 2, 10, '2023-06-13 18:34:54', '2023-06-13 18:34:54'),
(15, 'image', 'storage/child_files/2023_06_13_842001_Screenshot (9).png', 'this file for child info adn this is for test', 1, 11, '2023-06-13 19:10:10', '2023-06-13 19:10:10'),
(16, 'image', 'storage/child_files/2023_06_13_849042_Screenshot (9).png', NULL, 2, 11, '2023-06-13 19:10:10', '2023-06-13 19:10:10'),
(35, 'image', 'storage/children_document_challenges/2023_06_13_921059_image0.jpg', 'This is an image', 1, 21, '2023-06-13 20:36:19', '2023-06-13 20:36:19'),
(36, 'image', 'storage/children_document_challenges/2023_06_13_930455_image1.jpg', 'This is an image', 2, 21, '2023-06-13 20:36:19', '2023-06-13 20:36:19'),
(37, 'image', 'storage/children_document_challenges/2023_06_13_934290_video.mp4', 'This is a video', 3, 21, '2023-06-13 20:36:19', '2023-06-13 20:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `children_count` int NOT NULL DEFAULT '0',
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age_type_id` bigint UNSIGNED NOT NULL,
  `program_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `groups_age_type_id_foreign` (`age_type_id`),
  KEY `groups_program_id_foreign` (`program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `children_count`, `notes`, `age_type_id`, `program_id`, `created_at`, `updated_at`) VALUES
(1, 'group 1', 10, NULL, 1, 1, '2023-06-12 20:17:28', '2023-06-12 20:17:28'),
(2, 'group 2', 10, NULL, 1, 1, '2023-06-12 20:18:55', '2023-06-12 20:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `group_schedules`
--

DROP TABLE IF EXISTS `group_schedules`;
CREATE TABLE IF NOT EXISTS `group_schedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `arrival_time` time NOT NULL,
  `departure_time` time NOT NULL,
  `day_number` enum('1','2','3','4','5','6','7') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `group_schedules_group_id_foreign` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_schedules`
--

INSERT INTO `group_schedules` (`id`, `arrival_time`, `departure_time`, `day_number`, `date`, `group_id`, `created_at`, `updated_at`) VALUES
(1, '07:00:00', '11:00:00', '1', '2023-04-11', 1, '2023-06-12 20:19:18', '2023-06-12 20:19:18'),
(2, '08:15:00', '16:00:00', '6', '2023-04-05', 1, '2023-06-12 20:19:18', '2023-06-12 20:19:18'),
(3, '07:00:00', '11:00:00', '1', '2023-04-11', 2, '2023-06-12 20:19:25', '2023-06-12 20:19:25'),
(4, '08:15:00', '16:00:00', '6', '2023-04-05', 2, '2023-06-12 20:19:25', '2023-06-12 20:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `group_session`
--

DROP TABLE IF EXISTS `group_session`;
CREATE TABLE IF NOT EXISTS `group_session` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` enum('Closed','Opened') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Opened',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_session_id` bigint UNSIGNED NOT NULL,
  `group_schedule_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `group_session_program_session_id_foreign` (`program_session_id`),
  KEY `group_session_group_schedule_id_foreign` (`group_schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_session`
--

INSERT INTO `group_session` (`id`, `status`, `description`, `program_session_id`, `group_schedule_id`, `created_at`, `updated_at`) VALUES
(1, 'Opened', '1', 1, 1, '2023-06-13 16:43:00', '2023-06-13 16:43:00'),
(2, 'Closed', NULL, 2, 1, '2023-06-13 16:43:00', '2023-06-13 16:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` enum('Active','In_Active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point_price` double NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `items_attachment_id_foreign` (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_requests`
--

DROP TABLE IF EXISTS `item_requests`;
CREATE TABLE IF NOT EXISTS `item_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` enum('Accepted','Pending','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `item_id` bigint UNSIGNED NOT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_requests_item_id_foreign` (`item_id`),
  KEY `item_requests_child_id_foreign` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_1-_11_000000_create_attachments_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_04_04_222234_create_programs_table', 1),
(7, '2023_04_04_222632_create_files_table', 1),
(8, '2023_04_04_222649_create_age_types_table', 1),
(9, '2023_04_04_222712_create_groups_table', 1),
(10, '2023_04_04_222803_create_group_schedules_table', 1),
(11, '2023_04_04_222811_create_sessions_table', 1),
(12, '2023_04_04_222818_create_concepts_table', 1),
(13, '2023_04_04_222820_create_program_session_table', 1),
(14, '2023_04_04_222827_create_group_session_table', 1),
(15, '2023_04_04_223224_create_positions_table', 1),
(16, '2023_04_04_223231_create_trips_table', 1),
(17, '2023_04_04_223247_create_children_table', 1),
(18, '2023_04_04_223356_create_child_group_table', 1),
(19, '2023_04_04_223528_create_facilitator_group_table', 1),
(20, '2023_04_04_223540_create_position_trip_table', 1),
(21, '2023_04_04_223727_create_facilitator_trip_table', 1),
(22, '2023_04_04_223740_create_child_trip_checklists_table', 1),
(23, '2023_04_04_223746_create_items_table', 1),
(24, '2023_04_04_223753_create_item_requests_table', 1),
(25, '2023_04_04_223757_create_missions_table', 1),
(26, '2023_04_04_223760_create_mission_program_table', 1),
(27, '2023_04_04_223805_create_challenges_table', 1),
(28, '2023_04_04_223827_create_challenge_child_table', 1),
(29, '2023_04_04_223832_create_surveys_table', 1),
(30, '2023_04_04_224432_create_child_mission_table', 1),
(31, '2023_04_05_095010_create_session_checklists_table', 1),
(32, '2023_05_26_111011_create_session_rates_table', 1),
(33, '2023_06_03_180750_create_questions_table', 1),
(34, '2023_06_03_180908_create_child_session_table', 1),
(35, '2023_06_03_180920_create_answers_table', 1),
(36, '2023_06_03_181035_create_suggested_answers_table', 1),
(37, '2023_06_12_194243_create_survey_user_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

DROP TABLE IF EXISTS `missions`;
CREATE TABLE IF NOT EXISTS `missions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_points` double NOT NULL,
  `number_of_challenges` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL,
  `badge_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `missions_attachment_id_foreign` (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`id`, `name`, `description`, `category`, `total_points`, `number_of_challenges`, `is_active`, `badge_url`, `badge_name`, `attachment_id`, `created_at`, `updated_at`) VALUES
(1, 'missione newhjvg', 'this is new mission', 'i am healthy', 120, 2, 1, 'storage/missions_files/2023_06_12_963045_Screenshot 2023-04-26 130817.png', 'iam healthy', 6, '2023-06-12 20:24:46', '2023-06-12 20:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `mission_program`
--

DROP TABLE IF EXISTS `mission_program`;
CREATE TABLE IF NOT EXISTS `mission_program` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_id` bigint UNSIGNED NOT NULL,
  `mission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mission_program_program_id_foreign` (`program_id`),
  KEY `mission_program_mission_id_foreign` (`mission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mission_program`
--

INSERT INTO `mission_program` (`id`, `program_id`, `mission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-06-12 23:27:26', '2023-06-12 23:27:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'masar_token_secret', '1e54bf54cb8d1fc030e7757e09f075e2c1126db14e807c1b81dd82bb9acb699c', '[\"*\"]', '2023-06-12 20:28:31', NULL, '2023-06-12 19:20:06', '2023-06-12 20:28:31'),
(2, 'App\\Models\\User', 2, 'masar_token_secret', '4ab8a7677bed222650fd6b31841aefae3518b6d42e0662bf5727d764cec20111', '[\"*\"]', '2023-06-13 15:53:54', NULL, '2023-06-13 14:56:10', '2023-06-13 15:53:54'),
(3, 'App\\Models\\User', 2, 'masar_token_secret', '773b1f362af3539d2715adacc57496ff310aed63306315b1c5b1333bb0b646a9', '[\"*\"]', '2023-06-13 20:51:58', NULL, '2023-06-13 16:28:01', '2023-06-13 20:51:58'),
(4, 'App\\Models\\Child', 1, 'masar_token_secret', '9c7d27b11042b31be03caba4ea73b90881483c03aeada21b5ebbfd79d7318a59', '[\"children\"]', '2023-06-13 21:03:59', NULL, '2023-06-13 16:41:13', '2023-06-13 21:03:59'),
(5, 'App\\Models\\User', 2, 'masar_token_secret', 'c9faaecff6a5989356be494f15d65ebd0d00ff5702e360c8a7b9af444d78fa78', '[\"*\"]', NULL, NULL, '2023-06-13 17:36:50', '2023-06-13 17:36:50'),
(6, 'App\\Models\\User', 2, 'masar_token_secret', '8f272ddb046a6837ab161e6ca86fd7c843dd8229f122489fa741b7a08d912e59', '[\"*\"]', NULL, NULL, '2023-06-13 17:40:25', '2023-06-13 17:40:25'),
(7, 'App\\Models\\User', 2, 'masar_token_secret', 'c637abe873a819e9485c3311470510b9e0e3f056b05990de9c68b02e6c1de050', '[\"*\"]', NULL, NULL, '2023-06-13 17:42:15', '2023-06-13 17:42:15'),
(8, 'App\\Models\\User', 2, 'masar_token_secret', '0f1eb7ac728b5e2381236eda519fe612386caee8f8484a5e5595cdfffb3c355c', '[\"*\"]', NULL, NULL, '2023-06-13 17:43:35', '2023-06-13 17:43:35'),
(9, 'App\\Models\\User', 2, 'masar_token_secret', '902879e55278760768993260e91d04abfcf07a8aaf4619f5397f9a520c8a64e3', '[\"*\"]', '2023-06-13 20:40:35', NULL, '2023-06-13 17:44:20', '2023-06-13 20:40:35'),
(10, 'App\\Models\\User', 13, 'masar_token_secret', '6f75a909a246b68b3261c9c896163cb596f2c393497be8e2fc323e222222ce44', '[\"*\"]', NULL, NULL, '2023-06-13 19:23:05', '2023-06-13 19:23:05'),
(11, 'App\\Models\\Child', 1, 'masar_token_secret', '4d80e786ac82010f77cd4cec6a1c2518fa7baf4356aff529183690d40da5313e', '[\"children\"]', '2023-06-13 21:27:56', NULL, '2023-06-13 19:54:52', '2023-06-13 21:27:56'),
(12, 'App\\Models\\User', 2, 'masar_token_secret', '4e830316d07d15eaec0ead799ec0f7ae82d2d7c5eafb51d21d477dc821081142', '[\"*\"]', NULL, NULL, '2023-06-13 20:43:24', '2023-06-13 20:43:24'),
(13, 'App\\Models\\User', 2, 'masar_token_secret', '4bdf34173af5a3f0fd748592376ef57e84cdb7722396f62416b6af9f8bfbdfeb', '[\"*\"]', NULL, NULL, '2023-06-13 20:43:31', '2023-06-13 20:43:31'),
(14, 'App\\Models\\User', 2, 'masar_token_secret', '7742c7f924328502267da0f47f753c89dcaf470d9e2062c4a7bf97e9769a08bc', '[\"*\"]', NULL, NULL, '2023-06-13 20:43:43', '2023-06-13 20:43:43'),
(15, 'App\\Models\\User', 2, 'masar_token_secret', 'be7ab1f2249d19494d3c428463348dc97d2cc2bd1ced70944a31f1ad0ad98376', '[\"*\"]', '2023-06-13 20:54:25', NULL, '2023-06-13 20:43:50', '2023-06-13 20:54:25'),
(16, 'App\\Models\\User', 2, 'masar_token_secret', '050d3dd174f7f0a01af7a7be77891e16bf591a8854b9a7dd12780b96bd352ded', '[\"*\"]', NULL, NULL, '2023-06-13 20:54:42', '2023-06-13 20:54:42'),
(17, 'App\\Models\\User', 2, 'masar_token_secret', '05fdf2612402ee0031ec0633c91d2095a546a4713cbdab31e933d900183e986c', '[\"*\"]', '2023-06-13 20:57:31', NULL, '2023-06-13 20:54:48', '2023-06-13 20:57:31'),
(18, 'App\\Models\\User', 2, 'masar_token_secret', '69823ed43d19e947e2c72ef819b9077219c7570c1eb13184479b5e4aeaa6345e', '[\"*\"]', '2023-06-13 21:02:20', NULL, '2023-06-13 20:58:09', '2023-06-13 21:02:20'),
(19, 'App\\Models\\Child', 1, 'masar_token_secret', '9ac26c6c9d75b16bb1bc9e988be32fcb51f69a4c4aee61ed8cfcf4b8273921cc', '[\"children\"]', '2023-06-13 21:16:41', NULL, '2023-06-13 21:12:50', '2023-06-13 21:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position_trip`
--

DROP TABLE IF EXISTS `position_trip`;
CREATE TABLE IF NOT EXISTS `position_trip` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_id` bigint UNSIGNED NOT NULL,
  `trip_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `position_trip_position_id_foreign` (`position_id`),
  KEY `position_trip_trip_id_foreign` (`trip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected','Running','Finished') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `address`, `start_date`, `end_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'program one', 'bab sharqi almanara', '2023-08-11', '2023-09-11', 'Running', NULL, '2023-06-12 20:15:48', '2023-06-12 20:15:48'),
(2, 'Program 1', 'Mazzeh', '2023-02-12', '2023-05-14', 'Pending', 'Very interesting program', '2023-06-13 18:57:14', '2023-06-13 18:57:14'),
(5, 'Program 2', 'Malki', '2023-09-09', '2024-09-09', 'Pending', 'Very Important', '2023-06-13 20:25:02', '2023-06-13 20:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `program_session`
--

DROP TABLE IF EXISTS `program_session`;
CREATE TABLE IF NOT EXISTS `program_session` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `program_session_program_id_foreign` (`program_id`),
  KEY `program_session_session_id_foreign` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_session`
--

INSERT INTO `program_session` (`id`, `program_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-06-12 23:27:36', '2023-06-12 23:27:36'),
(2, 1, 2, '2023-06-12 23:27:36', '2023-06-12 23:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('select_one','text','select_multi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `questions_session_id_foreign` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `type`, `question`, `description`, `correct_answer`, `session_id`, `created_at`, `updated_at`) VALUES
(4, 'select_multi', 'what is the best answer for helping animals?', NULL, 'list all concepts', 1, '2023-06-13 15:53:54', '2023-06-13 15:53:54'),
(5, 'select_one', 'are you happy in this session ?', NULL, 'list all concepts', 1, '2023-06-13 16:35:03', '2023-06-13 16:35:03'),
(6, 'text', 'explain why you are happy in this session?', NULL, 'list all concepts', 1, '2023-06-13 16:37:36', '2023-06-13 16:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `category`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'session one', 'fealing and learning', NULL, '2023-06-12 20:26:39', '2023-06-12 20:26:39'),
(2, 'session two', 'fealing and learning', NULL, '2023-06-12 20:26:45', '2023-06-12 20:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `session_checklists`
--

DROP TABLE IF EXISTS `session_checklists`;
CREATE TABLE IF NOT EXISTS `session_checklists` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `attendance` tinyint(1) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_id` bigint UNSIGNED NOT NULL,
  `group_schedule_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_checklists_child_id_foreign` (`child_id`),
  KEY `session_checklists_group_schedule_id_foreign` (`group_schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_rates`
--

DROP TABLE IF EXISTS `session_rates`;
CREATE TABLE IF NOT EXISTS `session_rates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rate` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `child_id` bigint UNSIGNED NOT NULL,
  `program_session_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_rates_child_id_foreign` (`child_id`),
  KEY `session_rates_program_session_id_foreign` (`program_session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session_rates`
--

INSERT INTO `session_rates` (`id`, `rate`, `child_id`, `program_session_id`, `created_at`, `updated_at`) VALUES
(1, '5', 1, 1, '2023-06-13 21:03:11', '2023-06-13 21:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `suggested_answers`
--

DROP TABLE IF EXISTS `suggested_answers`;
CREATE TABLE IF NOT EXISTS `suggested_answers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `suggested_answers_question_id_foreign` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suggested_answers`
--

INSERT INTO `suggested_answers` (`id`, `text`, `status`, `question_id`, `created_at`, `updated_at`) VALUES
(1, 'give food for animal', 1, 4, '2023-06-13 15:53:54', '2023-06-13 15:53:54'),
(2, 'kill animal', 0, 4, '2023-06-13 15:53:54', '2023-06-13 15:53:54'),
(3, 'help animal for drink water', 1, 4, '2023-06-13 15:53:54', '2023-06-13 15:53:54'),
(4, 'Yes', NULL, 5, '2023-06-13 16:35:03', '2023-06-13 16:35:03'),
(5, 'No', NULL, 5, '2023-06-13 16:35:03', '2023-06-13 16:35:03'),
(6, 'because it is very usefull', NULL, 6, '2023-06-13 16:37:36', '2023-06-13 16:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age_type_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `surveys_age_type_id_foreign` (`age_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_user`
--

DROP TABLE IF EXISTS `survey_user`;
CREATE TABLE IF NOT EXISTS `survey_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint UNSIGNED NOT NULL,
  `survey_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `survey_user_parent_id_foreign` (`parent_id`),
  KEY `survey_user_survey_id_foreign` (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
CREATE TABLE IF NOT EXISTS `trips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('Manager','Admin','Parent','Facilitator') COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `attachment_id` bigint UNSIGNED DEFAULT NULL,
  `volunteering_start_date` date DEFAULT NULL,
  `volunteering_end_date` date DEFAULT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_children` int DEFAULT NULL,
  `parent_full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  KEY `users_attachment_id_foreign` (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `phone_number`, `birth_date`, `gender`, `address`, `role`, `password`, `is_active`, `attachment_id`, `volunteering_start_date`, `volunteering_end_date`, `notes`, `number_of_children`, `parent_full_name`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'elie', 'karra 2', 'elie2', 'elie.karra.2@gmail.com', '1122334478', '2023-04-05', 'male', 'fasdfsaffd', 'Facilitator', '$2y$10$rBYiR70uM6tASPvT9ScF4eDVRrp4ZDShgCyCBUcSPWhapeMiYXYla', 1, NULL, '2023-04-14', NULL, NULL, NULL, NULL, NULL, '2023-04-23 04:51:59', '2023-05-25 16:47:56'),
(2, 'elie', 'karra 6', 'admin', 'elie.karra.32@gmail.com', '11223344789', '2023-04-05', 'male', 'fasdfsaffd', 'Admin', '$2y$10$rBYiR70uM6tASPvT9ScF4eDVRrp4ZDShgCyCBUcSPWhapeMiYXYla', 1, NULL, '2023-04-14', NULL, NULL, NULL, NULL, NULL, '2023-04-23 04:51:59', '2023-04-23 04:51:59'),
(3, 'Elie', 'Karra', 'elie_karra_faZck', 'elie.karra.38@gmail.com', '0968496028', '2000-06-15', 'male', 'jaraman sahet alRaaes fourth floor', 'Facilitator', '$2y$10$h.89IIpjdXJcc2wT7mZKT.giH5x6cd88XEHgVuu0ZJhmQuxFyHx2G', 1, NULL, '2023-04-10', NULL, NULL, NULL, NULL, NULL, '2023-04-24 04:13:28', '2023-04-24 04:13:28'),
(4, 'Elie', 'Karra', 'elie_karra_fa8U0', 'elie.karra.36@gmail.com', '0968496021', '2000-06-15', 'male', 'jaraman sahet alRaaes fourth floor', 'Facilitator', '$2y$10$Y8T8v50ffROmX90hhU5Ht.d51S0oNRSyoPcXGBu/ZHMLcBfB5y8re', 1, NULL, '2023-04-10', NULL, NULL, NULL, NULL, NULL, '2023-04-24 04:15:42', '2023-04-24 04:15:42'),
(5, 'Elie', 'Karra', 'elie_manager', 'elie.k.3@eee.com', '0987654321', '2000-05-14', 'male', 'here', 'Manager', '$2y$10$rBYiR70uM6tASPvT9ScF4eDVRrp4ZDShgCyCBUcSPWhapeMiYXYla', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-13 18:11:57', '2023-05-13 18:11:57'),
(6, 'Elie', 'Karra', 'elie_karra_farvP', 'elie.kar3r9d@gmail.com', '0968495055', '2000-06-15', 'male', 'jaraman sahet alRaaes fourth floor', 'Facilitator', '$2y$10$YAVBzRwXDZzAgPQnImj6OOt5X5/fg4Uq.xixkypOnLrQFjS.Eg3W6', 1, NULL, '2023-04-10', NULL, NULL, NULL, NULL, NULL, '2023-05-19 07:11:10', '2023-05-19 07:11:10'),
(8, 'hassan', 'issa', 'hassan_paUuO', 'hassan@gmai.com', '0968496029', NULL, 'male', 'jaramana sahet al raaes', 'Parent', '$2y$10$5xcaZIwMb6P/vh0WWLHr6e9wMYOPRIbf0vK.0hNzf83aaVyFViIXK', 1, NULL, NULL, NULL, NULL, 1, 'yaser trabulsy', NULL, '2023-06-12 19:41:59', '2023-06-12 19:41:59'),
(9, 'Elie', 'Karra', 'elie_fau5x', 'elie.kar3r9d3@gmail.com', '0968495054', '2000-06-15', 'male', 'jaraman sahet alRaaes fourth floor', 'Facilitator', '$2y$10$kn/1xAa593ZUklEjeBxWc.pBjUdtdouz/ut5IyujcE1INa2pXefGG', 1, 4, '2023-04-10', NULL, NULL, NULL, NULL, NULL, '2023-06-12 20:20:56', '2023-06-12 20:20:56'),
(10, 'Elie', 'Karra', 'elie_fazMv', 'elie.kar3r93d3@gmail.com', '0968495051', '2000-06-15', 'male', 'jaraman sahet alRaaes fourth floor', 'Facilitator', '$2y$10$QTzXvBmgLxBOCh83Cxexp.ktaxcTFxY8FvVrPvrLMKolM.DW90TiK', 1, 5, '2023-04-10', NULL, NULL, NULL, NULL, NULL, '2023-06-12 20:22:57', '2023-06-12 20:22:57'),
(12, NULL, NULL, 'mona_wasef2_pauwg', 'mona2@gmai.com', '09523396028', NULL, NULL, '1', 'Parent', '$2y$10$u73Qlww0uOAZssIoEzheWOsLapMLoxHxK1Eq1NpzRjWu2Kjb.bRkW', 1, NULL, NULL, NULL, NULL, 1, 'mona wasef2', NULL, '2023-06-13 18:34:54', '2023-06-13 19:06:10'),
(13, NULL, NULL, 'mona_wasef2_paEjO', 'mona32@gmai.com', '09523396628', NULL, NULL, '1', 'Parent', '$2y$10$hA9q2X6jJvaUpDChS1OxKOBGkmSwxnWL2xwcvhbi0g1xmPhWLeFSO', 1, NULL, NULL, NULL, NULL, 1, 'mona wasef2', NULL, '2023-06-13 19:10:10', '2023-06-13 19:16:21'),
(14, NULL, NULL, 'samira_pacv1', 'yasser123@gmail.com', '0944444444', NULL, NULL, '1', 'Parent', '$2y$10$h2r8Z0cGo5iv0ncCwPAb5e/SB9qh6aIORoYO1aCX0TrOowk63WH8m', 1, NULL, NULL, NULL, NULL, 1, 'Samira', NULL, '2023-06-13 20:29:03', '2023-06-13 20:38:09'),
(15, 'Ahmad', 'Mohsen', 'ahmad_fayT1', 'ahmad123@gmail.com', '0987444111', '2000-02-22', 'male', 'Tijara', 'Facilitator', '$2y$10$obJ99VxGL755O0N250e8WeHRoeWNawXRPXnylyNWl/FpnVZMwECwe', 1, NULL, '2023-04-04', '2024-04-20', 'Part-Time Volunteer', NULL, NULL, NULL, '2023-06-13 20:54:23', '2023-06-13 20:54:23');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_child_session_id_foreign` FOREIGN KEY (`child_session_id`) REFERENCES `child_session` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `challenges_mission_id_foreign` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `challenge_child`
--
ALTER TABLE `challenge_child`
  ADD CONSTRAINT `challenge_child_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `challenge_child_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenge_child_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `children_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `children_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `children_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`);

--
-- Constraints for table `child_group`
--
ALTER TABLE `child_group`
  ADD CONSTRAINT `child_group_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `child_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `child_mission`
--
ALTER TABLE `child_mission`
  ADD CONSTRAINT `child_mission_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `child_mission_mission_program_id_foreign` FOREIGN KEY (`mission_program_id`) REFERENCES `mission_program` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `child_session`
--
ALTER TABLE `child_session`
  ADD CONSTRAINT `child_session_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `child_session_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `child_trip_checklists`
--
ALTER TABLE `child_trip_checklists`
  ADD CONSTRAINT `child_trip_checklists_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `child_trip_checklists_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `facilitator_trip` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `concepts`
--
ALTER TABLE `concepts`
  ADD CONSTRAINT `concepts_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facilitator_group`
--
ALTER TABLE `facilitator_group`
  ADD CONSTRAINT `facilitator_group_facilitator_id_foreign` FOREIGN KEY (`facilitator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `facilitator_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facilitator_trip`
--
ALTER TABLE `facilitator_trip`
  ADD CONSTRAINT `facilitator_trip_actual_facilitator_id_foreign` FOREIGN KEY (`actual_facilitator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `facilitator_trip_expected_facilitator_id_foreign` FOREIGN KEY (`expected_facilitator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `facilitator_trip_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_age_type_id_foreign` FOREIGN KEY (`age_type_id`) REFERENCES `age_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_schedules`
--
ALTER TABLE `group_schedules`
  ADD CONSTRAINT `group_schedules_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_session`
--
ALTER TABLE `group_session`
  ADD CONSTRAINT `group_session_group_schedule_id_foreign` FOREIGN KEY (`group_schedule_id`) REFERENCES `group_schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_session_program_session_id_foreign` FOREIGN KEY (`program_session_id`) REFERENCES `program_session` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`);

--
-- Constraints for table `item_requests`
--
ALTER TABLE `item_requests`
  ADD CONSTRAINT `item_requests_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_requests_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`);

--
-- Constraints for table `mission_program`
--
ALTER TABLE `mission_program`
  ADD CONSTRAINT `mission_program_mission_id_foreign` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mission_program_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `position_trip`
--
ALTER TABLE `position_trip`
  ADD CONSTRAINT `position_trip_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `position_trip_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_session`
--
ALTER TABLE `program_session`
  ADD CONSTRAINT `program_session_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_session_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `session_checklists`
--
ALTER TABLE `session_checklists`
  ADD CONSTRAINT `session_checklists_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_checklists_group_schedule_id_foreign` FOREIGN KEY (`group_schedule_id`) REFERENCES `group_schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `session_rates`
--
ALTER TABLE `session_rates`
  ADD CONSTRAINT `session_rates_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_rates_program_session_id_foreign` FOREIGN KEY (`program_session_id`) REFERENCES `program_session` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suggested_answers`
--
ALTER TABLE `suggested_answers`
  ADD CONSTRAINT `suggested_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_age_type_id_foreign` FOREIGN KEY (`age_type_id`) REFERENCES `age_types` (`id`);

--
-- Constraints for table `survey_user`
--
ALTER TABLE `survey_user`
  ADD CONSTRAINT `survey_user_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `survey_user_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
