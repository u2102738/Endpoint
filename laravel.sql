-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 09:04 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_status` tinyint(1) NOT NULL,
  `user_id_affected` bigint(20) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `event_type`, `event_status`, `user_id_affected`, `description`, `created_at`, `updated_at`) VALUES
(42, 2, 'Edit User', 1, NULL, 'test has been updated.', '2023-05-19 06:18:47', NULL),
(45, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-05-19 07:50:20', NULL),
(46, 1, 'Edit User', 0, 6, 'Mcjoey Michael Enggat anak Johnny failed to be updated. Validation Error.', '2023-05-19 07:50:27', NULL),
(47, 1, 'Edit User', 1, NULL, 'test has been updated.', '2023-05-19 07:56:50', NULL),
(48, 1, 'Edit User', 0, 5, 'John Doe failed to be updated. Validation Error.', '2023-05-19 07:56:56', NULL),
(49, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-05-22 00:16:11', NULL),
(50, 1, 'Edit User', 0, 6, 'Mcjoey Michael Enggat anak Johnny failed to be updated. Validation Error.', '2023-05-22 00:16:23', NULL),
(51, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-05-22 00:16:29', NULL),
(52, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-05-22 00:17:03', NULL),
(53, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-05-22 00:17:15', NULL),
(54, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-22 00:20:02', NULL),
(55, 1, 'Add Role', 1, NULL, 'Role [ <script>alert(1);</script> ] has been added.', '2023-05-22 00:27:23', NULL),
(56, 1, 'Delete Role', 1, NULL, 'Role [ Test ] has been deleted.', '2023-05-22 00:27:38', NULL),
(57, 1, 'Delete Role', 1, NULL, 'Role [ Editor ] has been deleted.', '2023-05-22 00:28:40', NULL),
(58, 1, 'Add Role', 1, NULL, 'Role [ Editor ] has been added.', '2023-05-22 00:29:23', NULL),
(59, 1, 'Edit User', 1, 2, 'Editor has been updated.', '2023-05-22 00:30:22', NULL),
(60, 1, 'Edit User', 1, NULL, 'test has been updated.', '2023-05-22 00:30:29', NULL),
(61, 1, 'Delete Role', 1, NULL, 'Role [ Editor ] has been deleted.', '2023-05-22 00:31:49', NULL),
(62, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-22 00:31:58', NULL),
(63, 1, 'Add Role', 0, NULL, 'Role \"test2\" failed to be added. Validation Error.', '2023-05-22 00:32:04', NULL),
(64, 1, 'Add Role', 1, NULL, 'Role [ rs ] has been added.', '2023-05-22 00:32:11', NULL),
(65, 1, 'Delete Role', 1, NULL, 'Role [ Test ] has been deleted.', '2023-05-22 00:32:20', NULL),
(66, 1, 'Delete Role', 1, NULL, 'Role [ Rs ] has been deleted.', '2023-05-22 00:35:17', NULL),
(67, 1, 'Add Role', 1, NULL, 'Role [ zikri ] has been added.', '2023-05-22 00:35:32', NULL),
(68, 6, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-22 00:35:38', NULL),
(69, 1, 'Delete Role', 1, NULL, 'Role [ Zikri ] has been deleted.', '2023-05-22 00:35:43', NULL),
(70, 1, 'Delete Role', 1, NULL, 'Role [ Test ] has been deleted.', '2023-05-22 00:36:28', NULL),
(71, 1, 'Add Role', 1, NULL, 'Role [ Editor ] has been added.', '2023-05-22 00:37:29', NULL),
(72, 1, 'Add Role', 1, NULL, 'Role [ zik ] has been added.', '2023-05-22 00:37:42', NULL),
(73, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-22 00:37:47', NULL),
(74, 1, 'Delete Role', 1, NULL, 'Role [ Test ] has been deleted.', '2023-05-22 00:46:54', NULL),
(75, 1, 'Delete Role', 1, NULL, 'Role [ Editor ] has been deleted.', '2023-05-22 00:47:09', NULL),
(76, 1, 'Delete Role', 1, NULL, 'Role [ Zik ] has been deleted.', '2023-05-22 00:47:14', NULL),
(77, 1, 'Add Role', 1, NULL, 'Role [ Editor ] has been added.', '2023-05-22 00:47:31', NULL),
(78, 1, 'Edit Role', 0, NULL, 'Role [ Editor ] details failed to be updated. Validation Error.', '2023-05-22 00:47:38', NULL),
(79, 1, 'Edit Role', 1, NULL, 'Role [ Editor ] details has been updated.', '2023-05-22 00:48:48', NULL),
(80, 1, 'Edit Role', 1, NULL, 'Role [ Editor ] details has been updated.', '2023-05-22 00:48:51', NULL),
(81, 1, 'Delete User', 1, NULL, 'test has been deleted.', '2023-05-22 00:59:25', NULL),
(82, 1, 'Delete User', 1, NULL, 'Muhammad Zikri bin Roslan has been deleted.', '2023-05-22 00:59:40', NULL),
(83, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-22 01:00:53', NULL),
(84, 1, 'Add User', 1, NULL, 'testtwo has been added.', '2023-05-22 01:01:08', NULL),
(85, 1, 'Delete User', 1, NULL, 'test has been deleted.', '2023-05-22 01:02:49', NULL),
(86, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-22 03:09:36', NULL),
(87, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-22 03:14:13', NULL),
(88, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-22 03:14:44', NULL),
(89, 1, 'Edit Role', 0, NULL, 'Role [ Admin1 ] details failed to be updated. Validation Error.', '2023-05-22 03:17:48', NULL),
(90, 1, 'Edit Role', 0, NULL, 'Role [ Basic User@ ] details failed to be updated. Validation Error.', '2023-05-22 03:18:11', NULL),
(91, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-22 07:14:18', NULL),
(92, 1, 'Edit User', 1, NULL, 'tests has been updated.', '2023-05-22 07:14:28', NULL),
(93, 1, 'Delete User', 1, NULL, 'tests has been deleted.', '2023-05-22 07:14:34', NULL),
(94, 1, 'Update Profile', 1, 1, 'Admin profile has been updated.', '2023-05-22 08:16:05', NULL),
(95, 1, 'Update Password', 0, 1, ' failed to update password. Validation Error.', '2023-05-22 08:21:42', NULL),
(96, 1, 'Update Password', 0, 1, ' failed to update password. Validation Error.', '2023-05-22 08:22:35', NULL),
(97, 1, 'Update Password', 0, 1, 'Admin failed to update password. Validation Error.', '2023-05-22 08:23:11', NULL),
(98, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-22 08:33:37', NULL),
(99, 58, 'Update Profile', 1, NULL, 'tests profile has been updated.', '2023-05-22 08:33:55', NULL),
(100, 1, 'Delete User', 1, NULL, 'testtwo has been deleted.', '2023-05-22 08:36:31', NULL),
(101, 1, 'Delete User', 1, NULL, 'tests has been deleted.', '2023-05-23 00:18:04', NULL),
(102, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-23 00:56:33', NULL),
(103, 1, 'Edit User', 1, NULL, 'tests has been updated.', '2023-05-23 00:56:39', NULL),
(104, 58, 'Update Profile', 1, NULL, 'tests profile has been updated.', '2023-05-23 00:56:56', NULL),
(105, 1, 'Delete User', 1, NULL, 'tests has been deleted.', '2023-05-23 00:57:19', NULL),
(106, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-23 01:05:17', NULL),
(107, 1, 'Add Role', 1, NULL, 'Role [ testtwo ] has been added.', '2023-05-23 01:05:25', NULL),
(108, 1, 'Edit Role', 1, NULL, 'Role [ Tests ] details has been updated.', '2023-05-23 01:05:30', NULL),
(109, 1, 'Edit Role', 1, NULL, 'Role [ Tests ] permissions has been updated.', '2023-05-23 01:05:33', NULL),
(110, 1, 'Delete Role', 1, NULL, 'Role [ Tests ] has been deleted.', '2023-05-23 01:05:41', NULL),
(111, 1, 'Delete Role', 1, NULL, 'Role [ Testtwo ] has been deleted.', '2023-05-23 01:05:44', NULL),
(112, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-23 01:11:53', NULL),
(113, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-23 01:12:06', NULL),
(114, 1, 'Edit User', 1, NULL, 'test has been updated.', '2023-05-23 01:12:31', NULL),
(115, 1, 'Delete Role', 1, NULL, 'Role [ Test ] has been deleted.', '2023-05-23 01:12:37', NULL),
(116, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-05-23 01:14:43', NULL),
(117, 1, 'Edit User', 1, NULL, 'test has been updated.', '2023-05-23 01:14:52', NULL),
(118, 1, 'Delete Role', 0, NULL, 'Role [ Test ] failed to be deleted. Exists user with the role.', '2023-05-23 01:14:58', NULL),
(119, 1, 'Delete User', 1, NULL, 'test has been deleted.', '2023-05-23 01:15:32', NULL),
(120, 1, 'Delete Role', 1, NULL, 'Role [ Test ] has been deleted.', '2023-05-23 01:15:37', NULL),
(121, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-23 02:57:01', NULL),
(122, 1, 'Delete User', 1, NULL, 'test has been deleted.', '2023-05-23 02:59:09', NULL),
(123, 1, 'Add User', 1, NULL, 'test has been added.', '2023-05-23 03:00:04', NULL),
(124, 59, 'Update Profile', 1, NULL, 'tests profile has been updated.', '2023-05-23 03:00:18', NULL),
(125, 1, 'Delete User', 1, NULL, 'tests has been deleted.', '2023-05-23 03:00:36', NULL),
(126, 1, 'Add User', 1, NULL, 'zikri roslan has been added.', '2023-05-23 03:37:17', NULL),
(127, 60, 'Edit User', 1, NULL, 'muhammad zikri bin roslan has been updated.', '2023-05-23 03:37:40', NULL),
(128, 60, 'Update Profile', 1, NULL, 'muhammad zikri bin roslan profile has been updated.', '2023-05-23 03:37:52', NULL),
(129, 1, 'Delete User', 1, NULL, 'muhammad zikri bin roslan has been deleted.', '2023-05-23 03:45:53', NULL),
(130, 1, 'Delete Role', 0, NULL, 'Role [ Editor ] failed to be deleted. Exists user with the role.', '2023-05-23 03:54:41', NULL),
(131, 1, 'OS Version', 0, NULL, 'OS Version failed to be updated. Validation Error.', '2023-05-23 08:18:22', NULL),
(132, 1, 'OS Version', 0, NULL, 'OS Version failed to be updated. Validation Error.', '2023-05-23 08:18:27', NULL),
(133, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-23 08:18:53', NULL),
(134, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-23 08:19:18', NULL),
(135, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-23 08:53:05', NULL),
(136, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-23 08:54:29', NULL),
(137, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:07:12', NULL),
(138, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:07:29', NULL),
(139, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:07:44', NULL),
(140, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:07:49', NULL),
(141, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:08:13', NULL),
(142, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:08:28', NULL),
(143, 1, 'Edit Role', 1, NULL, 'Role [ Editor ] permissions has been updated.', '2023-05-24 00:36:27', NULL),
(144, 2, 'Edit User', 1, 3, 'Basic User has been updated.', '2023-05-24 00:50:29', NULL),
(145, 2, 'Edit User', 0, 3, 'Basic User failed to be updated. Validation Error.', '2023-05-24 00:50:34', NULL),
(146, 2, 'Edit User', 1, 3, 'Basic User has been updated.', '2023-05-24 00:50:46', NULL),
(147, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:54:51', NULL),
(148, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:55:03', NULL),
(149, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 00:55:33', NULL),
(150, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-24 01:02:41', NULL),
(151, 1, 'Software License', 0, NULL, '[  ] license failed to be updated. Validation Error.', '2023-05-24 06:04:00', NULL),
(152, 1, 'Software License', 0, NULL, '[  ] license failed to be updated. Validation Error.', '2023-05-24 06:06:03', NULL),
(153, 1, 'Software License', 0, NULL, '[  ] license failed to be updated. Validation Error.', '2023-05-24 06:06:27', NULL),
(154, 1, 'Software License', 0, NULL, '[  ] license failed to be updated. Validation Error.', '2023-05-24 06:06:40', NULL),
(155, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-24 06:09:26', NULL),
(156, 1, 'Software License', 1, NULL, 'Software [ Notepad++ ] license has been updated.', '2023-05-24 06:09:34', NULL),
(157, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-24 06:09:40', NULL),
(158, 1, 'Software License', 1, NULL, 'Software [ Microsoft Windows ] license has been updated.', '2023-05-24 06:09:44', NULL),
(159, 1, 'Software License', 1, NULL, 'Software [ Microsoft Windows ] license has been updated.', '2023-05-24 06:11:42', NULL),
(160, 1, 'Software License', 1, NULL, 'Software [ Microsoft Windows ] license has been updated.', '2023-05-24 06:11:47', NULL),
(161, 1, 'Software License', 1, NULL, 'Software [ Notepad++ ] license has been updated.', '2023-05-24 06:12:15', NULL),
(162, 1, 'Software License', 0, NULL, '[  ] license failed to be updated. Validation Error.', '2023-05-24 06:12:18', NULL),
(163, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-25 03:35:26', NULL),
(164, 1, 'Edit Role', 1, NULL, 'Role [ Audit log ] details has been updated.', '2023-05-25 03:39:12', NULL),
(165, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-05-25 03:39:21', NULL),
(166, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:39:43', NULL),
(167, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-25 03:42:32', NULL),
(168, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:48:45', NULL),
(169, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:49:35', NULL),
(170, 1, 'Edit User', 1, 3, 'Basic User has been updated.', '2023-05-25 03:50:01', NULL),
(171, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:51:00', NULL),
(172, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:51:05', NULL),
(173, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:51:09', NULL),
(174, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:51:14', NULL),
(175, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:51:34', NULL),
(176, 1, 'Add Role', 1, NULL, 'Role [ Audit Log ] has been added.', '2023-05-25 03:53:06', NULL),
(177, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-25 03:54:44', NULL),
(178, 1, 'Edit User', 1, 5, 'John Doe has been updated.', '2023-05-25 03:54:51', NULL),
(179, 1, 'Delete Role', 0, NULL, 'Role [ Basic User ] failed to be deleted. Exists user with the role.', '2023-05-25 03:55:15', NULL),
(180, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-25 04:13:21', NULL),
(181, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-25 04:13:33', NULL),
(182, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-26 02:59:42', NULL),
(183, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-26 03:00:12', NULL),
(184, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 00:20:59', NULL),
(185, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 00:21:06', NULL),
(186, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-29 01:02:46', NULL),
(187, 1, 'Software License', 0, NULL, 'Software [ Sublime ] license failed to be update. Error on updating data.', '2023-05-29 01:53:54', NULL),
(188, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 01:58:23', NULL),
(189, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 01:58:30', NULL),
(190, 1, 'Software License', 0, NULL, '[  ] license failed to be updated. Validation Error.', '2023-05-29 01:58:56', NULL),
(191, 1, 'Software License', 1, NULL, 'Software [ Notepad++ ] license has been updated.', '2023-05-29 01:59:03', NULL),
(192, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 02:03:18', NULL),
(193, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 02:03:26', NULL),
(194, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-29 03:32:33', NULL),
(195, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to  devices.', '2023-05-29 06:36:36', NULL),
(196, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-29 06:39:42', NULL),
(197, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 06:40:39', NULL),
(198, 1, 'OS Update Reminder', 0, NULL, 'OS Update reminder failed to be sent to 1 devices.', '2023-05-29 06:40:39', NULL),
(199, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-29 06:40:47', NULL),
(200, 1, 'OS Update Reminder', 0, NULL, 'OS Update reminder failed to be sent to 2 devices.', '2023-05-29 06:40:47', NULL),
(201, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-29 06:41:28', NULL),
(202, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 06:41:58', NULL),
(203, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 06:42:03', NULL),
(204, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 06:42:15', NULL),
(205, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 3 devices.', '2023-05-29 06:42:33', NULL),
(206, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-29 06:44:34', NULL),
(207, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 06:44:43', NULL),
(208, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 06:44:52', NULL),
(209, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-29 06:45:36', NULL),
(210, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-29 06:45:46', NULL),
(211, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-29 06:46:55', NULL),
(212, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-29 06:47:35', NULL),
(213, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 3 devices.', '2023-05-29 06:58:52', NULL),
(214, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-29 06:59:19', NULL),
(215, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-29 06:59:26', NULL),
(216, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 3 devices.', '2023-05-29 07:02:19', NULL),
(217, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 07:07:31', NULL),
(218, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-29 07:07:38', NULL),
(219, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-29 07:36:46', NULL),
(220, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-29 07:46:43', NULL),
(221, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-29 07:58:53', NULL),
(222, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-29 07:59:10', NULL),
(223, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-29 08:00:53', NULL),
(224, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-29 08:09:49', NULL),
(225, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-30 00:19:46', NULL),
(226, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:25:03', NULL),
(227, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:25:20', NULL),
(228, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:25:51', NULL),
(229, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:28:41', NULL),
(230, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:34:07', NULL),
(231, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 00:34:16', NULL),
(232, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:39:14', NULL),
(233, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:44:14', NULL),
(234, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:46:49', NULL),
(235, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:46:52', NULL),
(236, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:52:12', NULL),
(237, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:54:11', NULL),
(238, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:57:00', NULL),
(239, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 00:59:52', NULL),
(240, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:02:39', NULL),
(241, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:04:20', NULL),
(242, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:04:45', NULL),
(243, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:06:13', NULL),
(244, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:06:39', NULL),
(245, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:06:45', NULL),
(246, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:07:02', NULL),
(247, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:07:28', NULL),
(248, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:07:35', NULL),
(249, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:08:13', NULL),
(250, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:08:36', NULL),
(251, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:10:17', NULL),
(252, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:10:45', NULL),
(253, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:12:16', NULL),
(254, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:14:20', NULL),
(255, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:14:39', NULL),
(256, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-30 01:20:19', NULL),
(257, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 devices.', '2023-05-30 01:20:49', NULL),
(258, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 devices.', '2023-05-30 01:21:22', NULL),
(259, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 devices.', '2023-05-30 01:21:54', NULL),
(260, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 devices.', '2023-05-30 01:21:59', NULL),
(261, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 01:22:40', NULL),
(262, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 01:22:57', NULL),
(263, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 01:23:13', NULL),
(264, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 01:23:27', NULL),
(265, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 01:23:37', NULL),
(266, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 01:24:30', NULL),
(267, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-30 01:24:35', NULL),
(268, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 devices.', '2023-05-30 01:24:42', NULL),
(269, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-30 01:32:57', NULL),
(270, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 devices.', '2023-05-30 01:33:17', NULL),
(271, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 2 devices.', '2023-05-30 01:37:12', NULL),
(272, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 devices.', '2023-05-30 01:37:32', NULL),
(273, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 devices.', '2023-05-30 01:37:36', NULL),
(274, 1, 'Add Device', 0, NULL, 'Device [ Device 3 ] failed to be added. Error on storing data.', '2023-05-30 03:03:51', NULL),
(275, 1, 'Add Device', 1, NULL, 'Device [ Device 3 ] has been added.', '2023-05-30 03:07:48', NULL),
(276, 1, 'Add Device', 1, NULL, 'Device [ test ] has been added.', '2023-05-30 03:10:53', NULL),
(277, 1, 'Add Device', 0, NULL, 'Device [  ] failed to be added. Validation Error.', '2023-05-30 03:11:34', NULL),
(278, 1, 'Add Device', 0, NULL, 'Device [  ] failed to be added. Validation Error.', '2023-05-30 03:11:52', NULL),
(279, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 03:16:25', NULL),
(280, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 device(s).', '2023-05-30 03:16:30', NULL),
(281, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-05-30 03:17:36', NULL),
(282, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 device(s).', '2023-05-30 03:18:02', NULL),
(283, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-30 03:18:21', NULL),
(284, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-30 03:18:30', NULL),
(285, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-05-30 03:54:01', NULL),
(286, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-30 03:54:11', NULL),
(287, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-05-30 03:54:16', NULL),
(288, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-30 03:54:25', NULL),
(289, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-05-30 03:54:29', NULL),
(290, 1, 'Prohibited Software Reminder', 0, NULL, 'Prohibited Software Reminder was unsuccessful. Validation Error.', '2023-05-30 03:54:36', NULL),
(291, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 device(s).', '2023-05-30 03:54:41', NULL),
(292, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-30 06:49:42', NULL),
(293, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-30 06:50:22', NULL),
(294, 1, 'Edit Role', 0, NULL, 'Role [  ] permissions failed to be updated. Validation Error.', '2023-05-30 06:50:37', NULL),
(295, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-30 06:50:43', NULL),
(296, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-30 07:19:57', NULL),
(297, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-30 07:20:36', NULL),
(298, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-05-30 07:20:52', NULL),
(299, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-05-30 07:21:18', NULL),
(300, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-30 07:21:28', NULL),
(301, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-05-30 07:24:23', NULL),
(302, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-05-30 07:26:54', NULL),
(303, 1, 'Edit User', 1, 5, 'John Doe has been updated.', '2023-05-30 07:31:34', NULL),
(304, 1, 'Edit User', 1, 5, 'John Doe has been updated.', '2023-05-30 07:31:41', NULL),
(305, 1, 'Software License', 1, NULL, 'Software [ Notepad++ ] license has been updated.', '2023-05-30 08:15:33', NULL),
(306, 1, 'Software License', 1, NULL, 'Software [ Notepad++ ] license has been updated.', '2023-05-30 08:15:44', NULL),
(307, 1, 'Add User', 1, 61, 'Test has been added.', '2023-05-31 01:07:23', NULL),
(308, 1, 'Edit User', 1, 61, 'Test has been updated.', '2023-05-31 01:09:26', NULL),
(309, 1, 'Edit User', 1, 5, 'John Doe has been updated.', '2023-05-31 01:09:33', NULL),
(310, 1, 'Edit User', 1, 2, 'Audit Log has been updated.', '2023-05-31 01:09:39', NULL),
(311, 1, 'Add User', 1, 62, 'Muhammad Zikri has been added.', '2023-05-31 01:09:58', NULL),
(312, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-05-31 01:16:18', NULL),
(313, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-05-31 01:56:13', NULL),
(314, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:25:21', NULL),
(315, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:27:00', NULL),
(316, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:30:12', NULL),
(317, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:30:51', NULL),
(318, 1, 'Add Group', 0, NULL, 'Group [  ] failed to be added. Validation Error.', '2023-05-31 03:30:56', NULL),
(319, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 3 device(s).', '2023-05-31 03:36:05', NULL),
(320, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:40:41', NULL),
(321, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:42:03', NULL),
(322, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:44:53', NULL),
(323, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 03:47:19', NULL),
(324, 1, 'Add Group', 0, NULL, 'Group [ CSM ] failed to be added. Error on storing data.', '2023-05-31 04:15:40', NULL),
(325, 1, 'Add Group', 0, NULL, 'Group [ test ] failed to be added. Error on storing data.', '2023-05-31 05:58:31', NULL),
(326, 1, 'Add Group', 0, NULL, 'Group [ tes ] failed to be added. Error on storing data.', '2023-05-31 06:07:54', NULL),
(327, 1, 'Add Group', 0, NULL, 'Group [ test ] failed to be added. Error on storing data.', '2023-05-31 06:09:16', NULL),
(328, 1, 'Add Group', 0, NULL, 'Group [ test ] failed to be added. Error on storing data.', '2023-05-31 06:10:30', NULL),
(329, 1, 'Add Group', 1, NULL, 'Group [ CSM ] has been added.', '2023-05-31 06:11:25', NULL),
(330, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-05-31 06:15:46', NULL),
(331, 1, 'Add Group', 1, NULL, 'Group [ testa ] has been added.', '2023-05-31 07:48:59', NULL),
(332, 1, 'Add Group', 1, NULL, 'Group [ a ] has been added.', '2023-05-31 07:50:22', NULL),
(333, 1, 'Delete Device Group', 1, NULL, 'Group [ A ] has been deleted.', '2023-05-31 08:14:19', NULL),
(334, 1, 'Delete Device Group', 1, NULL, 'Group [ Testa ] has been deleted.', '2023-05-31 08:14:27', NULL),
(335, 1, 'Delete Device Group', 1, NULL, 'Group [ Test ] has been deleted.', '2023-05-31 08:14:34', NULL),
(336, 1, 'Add Group', 1, NULL, 'Group [ testte ] has been added.', '2023-05-31 08:33:07', NULL),
(337, 1, 'Add Group', 0, NULL, 'Group [ testte ] failed to be added. Validation Error.', '2023-05-31 08:33:07', NULL),
(338, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-05-31 08:33:19', NULL),
(339, 1, 'Delete Device Group', 1, NULL, 'Group [ Testte ] has been deleted.', '2023-05-31 08:33:23', NULL),
(340, 1, 'Delete Device Group', 1, NULL, 'Group [ Test ] has been deleted.', '2023-05-31 08:33:28', NULL),
(341, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-05-31 08:36:00', NULL),
(342, 1, 'Delete Device Group', 0, NULL, 'Group [ Test ] failed to be deleted. Exists device in the group. Remove the devices first!', '2023-05-31 08:36:03', NULL),
(343, 1, 'Delete Device Group', 1, NULL, 'Group [ Test ] has been deleted.', '2023-05-31 08:36:18', NULL),
(344, 1, 'Add Group', 1, NULL, 'Group [ Z ] has been added.', '2023-06-06 01:41:59', NULL),
(345, 1, 'Delete Device Group', 0, NULL, 'Group [ Z ] failed to be deleted. Exists device in the group.', '2023-06-06 02:23:32', NULL),
(346, 1, 'Edit Group Details', 1, NULL, 'Group [ Z ] details has been updated.', '2023-06-06 02:34:47', NULL),
(347, 1, 'Edit Group Details', 1, NULL, 'Group [ CSMs ] details has been updated.', '2023-06-06 02:34:57', NULL),
(348, 1, 'Edit Group Details', 0, NULL, 'Group [ CSMs1 ] details failed to be updated. Validation Error.', '2023-06-06 02:35:00', NULL),
(349, 1, 'Add Group', 1, NULL, 'Group [ t ] has been added.', '2023-06-06 04:03:00', NULL),
(350, 1, 'Edit Group Details', 1, NULL, 'Group [ Test ] details has been updated.', '2023-06-06 04:19:25', NULL),
(351, 1, 'Add Group', 0, NULL, 'Group [ test ] failed to be added. Validation Error.', '2023-06-06 07:37:48', NULL),
(352, 1, 'Add Group', 1, NULL, 'Group [ tests ] has been added.', '2023-06-06 07:37:55', NULL),
(353, 1, 'Delete Device Group', 1, NULL, 'Group [ Tests ] has been deleted.', '2023-06-06 07:40:22', NULL),
(354, 1, 'Add Group', 1, NULL, 'Group [ tests ] has been added.', '2023-06-06 07:40:35', NULL),
(355, 1, 'Add Device', 1, NULL, 'Device [ Device 2 ] has been added.', '2023-06-06 08:10:32', NULL),
(356, 1, 'Delete Device Group', 0, NULL, 'Group [ Tests ] failed to be deleted. Exists device in the group.', '2023-06-06 08:10:44', NULL),
(357, 1, 'Remove Group\'s Device', 0, NULL, 'Device [ Windows-1453-Scranton ] failed to be remove from group [ CSMs ]. Error on deleting data.', '2023-06-07 02:12:09', NULL),
(358, 1, 'Remove Group\'s Device', 0, NULL, 'Device [ Windows-1453-Scranton ] failed to be remove from group [ Tests ]. Error on deleting data.', '2023-06-07 03:50:34', NULL),
(359, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ MSI ] has been removed from group [ Tests ]', '2023-06-07 03:51:33', NULL),
(360, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ DESKTOP-3Q67JPL ] has been removed from group [ Test ]', '2023-06-07 03:52:08', NULL),
(361, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 3 ] has been removed from group [ Test ]', '2023-06-07 03:52:11', NULL),
(362, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 4 ] has been removed from group [ Test ]', '2023-06-07 03:52:14', NULL),
(363, 1, 'Delete Device Group', 1, NULL, 'Group [ Test ] has been deleted.', '2023-06-07 03:52:30', NULL),
(364, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Windows-1453-Scranton ] has been removed from group [ CSMs ]', '2023-06-07 03:59:51', NULL),
(365, 1, 'Add Group\'s Device', 0, NULL, 'Device failed to be added to group [ CSMs ]. Error on storing data.', '2023-06-07 06:48:18', NULL),
(366, 1, 'Add Group\'s Device', 0, NULL, 'Device failed to be added to group [ CSMs ]. Error on storing data.', '2023-06-07 06:51:50', NULL),
(367, 1, 'Add Group\'s Device', 0, NULL, 'Device failed to be added to group [ CSMs ]. Error on storing data.', '2023-06-07 06:52:32', NULL),
(368, 1, 'Add Group\'s Device', 1, NULL, '1 device(s)  has been added to group [ CSMs ].', '2023-06-07 06:55:08', NULL),
(369, 1, 'Add Group\'s Device', 1, NULL, '2 device(s)  has been added to group [ CSMs ].', '2023-06-07 06:55:17', NULL),
(370, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 2 ] has been removed from group [ CSMs ]', '2023-06-07 06:55:23', NULL),
(371, 1, 'Add Group\'s Device', 1, NULL, '1 device(s)  has been added to group [ CSMs ].', '2023-06-07 06:55:39', NULL),
(372, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 2 ] has been removed from group [ CSMs ]', '2023-06-07 06:55:51', NULL),
(373, 1, 'Add Group\'s Device', 1, NULL, '4 device(s)  has been added to group [ CSMs ].', '2023-06-07 06:56:07', NULL),
(374, 1, 'Add Device', 1, NULL, 'Device [ Device 1 ] has been added.', '2023-06-07 06:57:32', NULL),
(375, 1, 'Add Group\'s Device', 1, NULL, '1 device(s)  has been added to group [ CSMs ].', '2023-06-07 06:57:42', NULL),
(376, 1, 'Delete Device Group', 0, NULL, 'Group [ Tests ] failed to be deleted. Exists device in the group.', '2023-06-07 06:58:10', NULL),
(377, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ DESKTOP-3Q67JPL ] has been removed from group [ Tests ]', '2023-06-07 07:50:13', NULL),
(378, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 3 ] has been removed from group [ Tests ]', '2023-06-07 07:50:16', NULL),
(379, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 4 ] has been removed from group [ Tests ]', '2023-06-07 07:50:19', NULL),
(380, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Windows-1453-Scranton ] has been removed from group [ Tests ]', '2023-06-07 07:50:22', NULL),
(381, 1, 'Delete Device Group', 1, NULL, 'Group [ Tests ] has been deleted.', '2023-06-07 07:50:27', NULL),
(382, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ DESKTOP-3Q67JPL ] has been removed from group [ Z ]', '2023-06-07 07:50:32', NULL),
(383, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 3 ] has been removed from group [ Z ]', '2023-06-07 07:50:35', NULL),
(384, 1, 'Remove Group\'s Device', 1, NULL, 'Device [ Device 4 ] has been removed from group [ Z ]', '2023-06-07 07:50:37', NULL),
(385, 1, 'Delete Device Group', 1, NULL, 'Group [ Z ] has been deleted.', '2023-06-07 07:50:43', NULL),
(386, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-08 00:52:36', NULL),
(387, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-08 00:53:17', NULL),
(388, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-08 00:53:31', NULL),
(389, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-08 00:53:50', NULL),
(390, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-08 00:54:39', NULL),
(391, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-08 01:00:07', NULL),
(392, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices () have been removed from group [ CSMs ]', '2023-06-08 01:24:17', NULL),
(393, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices () have been removed from group [ CSMs ]', '2023-06-08 01:24:24', NULL),
(394, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices () have been removed from group [ CSMs ]', '2023-06-08 01:24:35', NULL),
(395, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices () have been removed from group [ CSMs ]', '2023-06-08 01:29:51', NULL),
(396, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices () have been removed from group [ CSMs ]', '2023-06-08 01:31:38', NULL),
(397, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices () have been removed from group [ CSMs ]', '2023-06-08 01:31:49', NULL),
(398, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices (Device 1) have been removed from group [ CSMs ]', '2023-06-08 01:38:28', NULL),
(399, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices (Windows-1453-Scranton, DESKTOP-3Q67JPL, MSI, Device 4, Device 3, Device 2) have been removed from group [ CSMs ]', '2023-06-08 01:38:34', NULL),
(400, 1, 'Add Group\'s Device', 1, NULL, '1 device(s)  has been added to group [ CSMs ].', '2023-06-08 01:38:49', NULL),
(401, 1, 'Add Group\'s Device', 1, NULL, '6 device(s)  has been added to group [ CSMs ].', '2023-06-08 01:39:05', NULL),
(402, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices (Device 2) have been removed from group [ CSMs ]', '2023-06-08 01:42:36', NULL),
(403, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices (DESKTOP-3Q67JPL, Device 3, Device 1) have been removed from group [ CSMs ]', '2023-06-08 01:44:38', NULL),
(404, 1, 'Add Group\'s Device', 1, NULL, 'Device(s) [DESKTOP-3Q67JPL] have been added to group [CSMs]', '2023-06-08 01:54:05', NULL),
(405, 1, 'Add Group\'s Device', 1, NULL, 'Devices [ Device 3, Device 2, Device 1 ] have been added to group [CSMs]', '2023-06-08 01:56:02', NULL),
(406, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices [ DESKTOP-3Q67JPL ] have been removed from group [ CSMs ]', '2023-06-08 01:57:27', NULL),
(407, 1, 'Add Group\'s Device', 1, NULL, '1 devices [ DESKTOP-3Q67JPL ] have been added to group [CSMs]', '2023-06-08 01:57:32', NULL),
(408, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices [ Windows-1453-Scranton, DESKTOP-3Q67JPL, MSI, Device 4, Device 3, Device 2, Device 1 ] have been removed from group [ CSMs ]', '2023-06-08 01:58:00', NULL),
(409, 1, 'Add Group\'s Device', 1, NULL, '3 devices [ DESKTOP-3Q67JPL, Device 2, Device 1 ] have been added to group [CSMs]', '2023-06-08 01:58:09', NULL),
(410, 1, 'Add Group\'s Device', 1, NULL, '2 devices [ Device 4, Device 3 ] have been added to group [CSMs]', '2023-06-08 01:58:34', NULL),
(411, 1, 'Add Group\'s Device', 1, NULL, '1 devices [ MSI ] have been added to group [CSMs]', '2023-06-08 02:10:10', NULL),
(412, 1, 'Add Group\'s Device', 1, NULL, '1 devices [ Windows-1453-Scranton ] have been added to group [CSMs]', '2023-06-08 02:14:28', NULL),
(413, 1, 'Add Group\'s Device', 0, NULL, 'Device failed to be added to group [ CSMs ]. Validation Error.', '2023-06-08 02:22:38', NULL),
(414, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices [ DESKTOP-3Q67JPL ] have been removed from group [ CSMs ]', '2023-06-08 02:22:50', NULL),
(415, 1, 'Add Group\'s Device', 0, NULL, 'Device failed to be added to group [ CSMs ]. Validation Error.', '2023-06-08 02:22:53', NULL),
(416, 1, 'Add Group\'s Device', 1, NULL, '1 devices [DESKTOP-3Q67JPL] have been added to group [CSMs]', '2023-06-08 02:22:57', NULL),
(417, 1, 'Remove Group\'s Devices', 1, NULL, 'Devices [ Windows-1453-Scranton, DESKTOP-3Q67JPL, MSI, Device 4, Device 2, Device 1 ] have been removed from group [ CSMs ]', '2023-06-08 02:23:47', NULL),
(418, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ Device 3 ] have been removed from group [ CSMs ]', '2023-06-08 02:24:59', NULL),
(419, 1, 'Add Group\'s Device', 1, NULL, '7 devices [Windows-1453-Scranton, DESKTOP-3Q67JPL, MSI, Device 4, Device 3, Device 2, Device 1] have been added to group [CSMs]', '2023-06-08 02:25:10', NULL),
(420, 1, 'Remove Group\'s Devices', 1, NULL, '7 devices [ Windows-1453-Scranton, DESKTOP-3Q67JPL, MSI, Device 4, Device 3, Device 2, Device 1 ] have been removed from group [ CSMs ]', '2023-06-08 02:25:24', NULL),
(421, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-06-08 02:28:49', NULL),
(422, 1, 'Software Authorization', 1, NULL, 'Software [ Sublime ] authorization has been updated.', '2023-06-08 02:28:54', NULL),
(423, 1, 'Add Group\'s Device', 1, NULL, '1 devices [DESKTOP-3Q67JPL] have been added to group [CSMs]', '2023-06-08 02:29:17', NULL),
(424, 1, 'Add Group\'s Device', 1, NULL, '3 devices [Device 4, Device 2, Device 1] have been added to group [CSMs]', '2023-06-08 02:29:26', NULL),
(425, 1, 'Remove Group\'s Devices', 1, NULL, '3 devices [ Device 4, Device 2, Device 1 ] have been removed from group [ CSMs ]', '2023-06-08 02:29:35', NULL),
(426, 1, 'Delete Device Group', 0, NULL, 'Group [ CSMs ] failed to be deleted. Exists device in the group.', '2023-06-08 02:30:26', NULL),
(427, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ DESKTOP-3Q67JPL ] have been removed from group [ CSMs ]', '2023-06-08 02:30:33', NULL),
(428, 1, 'Delete Device Group', 1, NULL, 'Group [ CSMs ] has been deleted.', '2023-06-08 02:30:38', NULL),
(429, 1, 'Add Group', 1, NULL, 'Group [ CSM ] has been added.', '2023-06-08 02:30:48', NULL),
(430, 1, 'Add Group\'s Device', 1, NULL, '3 devices [DESKTOP-3Q67JPL, Device 2, Device 1] have been added to group [CSM]', '2023-06-08 02:30:57', NULL),
(431, 1, 'Remove Group\'s Devices', 1, NULL, '2 devices [ DESKTOP-3Q67JPL, Device 2 ] have been removed from group [ CSM ]', '2023-06-08 02:31:09', NULL),
(432, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ Device 1 ] have been removed from group [ CSM ]', '2023-06-08 02:31:57', NULL),
(433, 1, 'Delete Device Group', 1, NULL, 'Group [ CSM ] has been deleted.', '2023-06-08 02:32:02', NULL),
(434, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 4 device(s).', '2023-06-08 02:41:54', NULL),
(435, 1, 'Add Group', 1, NULL, 'Group [ CSM ] has been added.', '2023-06-08 06:32:51', NULL),
(436, 1, 'Add Group\'s Device', 1, NULL, '2 devices [DESKTOP-3Q67JPL, Device 1] have been added to group [CSM]', '2023-06-08 06:33:06', NULL),
(437, 1, 'Remove Group\'s Devices', 1, NULL, '2 devices [ DESKTOP-3Q67JPL, Device 1 ] have been removed from group [ CSM ]', '2023-06-08 06:33:25', NULL),
(438, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 4 device(s).', '2023-06-08 06:33:57', NULL),
(439, 1, 'Add Group\'s Device', 1, NULL, '1 devices [DESKTOP-3Q67JPL] have been added to group [CSM]', '2023-06-08 06:38:11', NULL),
(440, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-06-09 01:51:43', NULL),
(441, 1, 'Add User', 1, 63, 'Testdata has been added.', '2023-06-09 01:53:46', NULL),
(442, 1, 'Edit User', 1, 63, 'Testdata has been updated.', '2023-06-09 01:57:45', NULL),
(443, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 device(s).', '2023-06-09 02:03:54', NULL),
(444, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-06-09 02:05:13', NULL),
(445, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 4 device(s).', '2023-06-09 02:06:05', NULL),
(446, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 4 device(s).', '2023-06-09 02:21:39', NULL),
(447, 1, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-09 02:28:20', NULL),
(448, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-06-09 02:38:45', NULL),
(450, 1, 'OS Update Reminder', 0, NULL, 'OS Update reminder failed to be sent to 1 device(s).', '2023-06-09 02:38:59', NULL),
(452, 1, 'OS Update Reminder', 0, NULL, 'OS Update reminder failed to be sent to 1 device(s).', '2023-06-09 02:39:32', NULL),
(453, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-06-09 02:40:13', NULL),
(454, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-06-09 02:41:32', NULL),
(455, 1, 'Add Group', 1, NULL, 'Group [ t ] has been added.', '2023-06-09 02:51:50', NULL),
(457, 1, 'Delete Device Group', 0, NULL, 'Group [ T ] failed to be deleted. Error on deleting data.', '2023-06-09 02:52:11', NULL),
(459, 1, 'Delete Device Group', 1, NULL, 'Group [ T ] has been deleted.', '2023-06-09 02:52:57', NULL),
(464, 1, 'Add Group\'s Device', 0, NULL, 'Device failed to be added to group [ Test ]. Validation Error.', '2023-06-09 03:33:08', NULL),
(468, 1, 'Add Group\'s Device', 1, NULL, '1 devices [Device 1] have been added to group [CSM]', '2023-06-09 03:51:03', NULL),
(469, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-09 03:54:46', NULL),
(470, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-09 06:21:47', NULL),
(471, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 12 device(s).', '2023-06-09 06:23:04', NULL),
(472, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ DESKTOP-3Q67JPL ] have been removed from group [ Test ]', '2023-06-09 06:26:25', NULL),
(473, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-06-09 06:26:36', NULL),
(474, 1, 'Delete Device Group', 1, NULL, 'Group [ Test ] has been deleted.', '2023-06-09 06:26:48', NULL),
(475, 1, 'Edit Role', 1, NULL, 'Role [ Audit Log ] permissions has been updated.', '2023-06-09 07:43:28', NULL),
(476, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-06-09 07:50:57', NULL),
(477, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-09 07:56:31', NULL),
(478, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-09 07:56:54', NULL),
(479, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-09 08:15:28', NULL),
(480, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-09 08:15:37', NULL),
(481, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-06-10 03:56:22', NULL),
(482, 1, 'Add Group\'s Device', 1, NULL, '1 devices [Device 2] have been added to group [CSM]', '2023-06-10 03:56:47', NULL),
(483, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-10 03:57:01', NULL),
(484, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ Device 1 ] have been removed from group [ CSM ]', '2023-06-10 04:14:56', NULL),
(485, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-10 04:27:24', NULL),
(486, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-10 04:27:35', NULL);
INSERT INTO `activity_log` (`id`, `user_id`, `event_type`, `event_status`, `user_id_affected`, `description`, `created_at`, `updated_at`) VALUES
(487, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-10 04:38:20', NULL),
(488, 1, 'OS Version', 1, NULL, 'OS Version has been updated.', '2023-06-10 04:58:16', NULL),
(489, 6, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-06-10 05:03:21', NULL),
(490, 6, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-10 05:03:23', NULL),
(491, 6, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-10 05:06:30', NULL),
(492, 6, 'OS Update Reminder', 0, NULL, 'OS Update Reminder was unsuccessful. Validation Error.', '2023-06-10 05:06:39', NULL),
(493, 6, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 4 device(s).', '2023-06-10 05:06:44', NULL),
(494, 1, 'OS Version', 1, NULL, 'OS Version has been updated to 5.5', '2023-06-10 05:15:02', NULL),
(495, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.4', '2023-06-10 05:15:15', NULL),
(496, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.5', '2023-06-10 06:17:09', NULL),
(497, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.5!', '2023-06-10 06:17:28', NULL),
(498, 1, 'Add User', 0, NULL, '< failed to be added. Validation Error.', '2023-06-10 06:17:53', NULL),
(499, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] details has been updated.', '2023-06-10 06:18:44', NULL),
(500, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-10 06:41:42', NULL),
(501, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-10 06:42:58', NULL),
(502, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-10 06:43:47', NULL),
(503, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-06-10 06:46:57', NULL),
(504, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-06-10 06:48:57', NULL),
(505, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-10 06:49:06', NULL),
(506, 1, 'Edit Role', 1, NULL, 'Role [ Admin ] permissions has been updated.', '2023-06-10 06:50:11', NULL),
(507, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-10 06:50:32', NULL),
(508, 1, 'Remove Group\'s Devices', 1, NULL, '2 devices [ DESKTOP-3Q67JPL, Device 2 ] have been removed from group [ CSM ]', '2023-06-10 06:51:10', NULL),
(509, 1, 'Add Group\'s Device', 1, NULL, '2 devices [DESKTOP-3Q67JPL, Device 1] have been added to group [CSM]', '2023-06-10 06:51:16', NULL),
(510, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-06-11 13:43:29', NULL),
(511, 1, 'Add Group\'s Device', 1, NULL, '1 devices [DESKTOP-3Q67JPL] have been added to group [Test]', '2023-06-11 13:43:37', NULL),
(512, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ DESKTOP-3Q67JPL ] have been removed from group [ Test ]', '2023-06-11 13:43:41', NULL),
(513, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 6 device(s).', '2023-06-11 13:43:57', NULL),
(514, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 device(s).', '2023-06-11 13:44:14', NULL),
(515, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 device(s).', '2023-06-11 13:44:35', NULL),
(516, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-06-11 13:45:34', NULL),
(517, 1, 'Edit User', 1, 6, 'Mcjoey Michael Enggat anak Johnny has been updated.', '2023-06-11 13:45:39', NULL),
(518, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-11 13:45:57', NULL),
(519, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.5', '2023-06-11 13:46:07', NULL),
(520, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.6', '2023-06-12 02:16:35', NULL),
(521, 1, 'Delete Device Group', 1, NULL, 'Group [ Test ] has been deleted.', '2023-06-12 03:47:54', NULL),
(522, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 1 device(s).', '2023-06-13 00:41:51', NULL),
(523, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 device(s).', '2023-06-13 00:43:34', NULL),
(524, 1, 'Add Device', 1, NULL, 'Device [ Device 5 ] has been added.', '2023-06-13 01:19:14', NULL),
(525, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.5', '2023-06-13 02:07:46', NULL),
(526, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.4', '2023-06-13 02:08:19', NULL),
(527, 1, 'Software Authorization', 1, NULL, 'Software [ Notepad++ ] authorization has been updated.', '2023-06-13 02:22:59', NULL),
(528, 1, 'Software Authorization', 1, NULL, 'Software [ Notepad++ ] authorization has been updated.', '2023-06-13 02:23:03', NULL),
(529, 1, 'Software Restriction', 1, NULL, 'Software [ Sublime ] restriction has been updated.', '2023-06-13 02:43:58', NULL),
(530, 1, 'Software Restriction', 1, NULL, 'Software [ Sublime ] restriction has been updated.', '2023-06-13 02:44:12', NULL),
(531, 1, 'Software Restriction', 1, NULL, 'Software [ Sublime ] restriction has been updated.', '2023-06-13 02:44:16', NULL),
(532, 1, 'OS Version', 1, NULL, 'Recommended OS Version has been updated to 5.45', '2023-06-13 03:07:29', NULL),
(533, 1, 'Add Role', 1, NULL, 'Role [ test ] has been added.', '2023-06-13 03:07:43', NULL),
(534, 1, 'Edit Role', 1, NULL, 'Role [ Tests ] details has been updated.', '2023-06-13 03:07:50', NULL),
(535, 1, 'Edit Role', 1, NULL, 'Role [ Tests ] permissions has been updated.', '2023-06-13 03:07:53', NULL),
(536, 1, 'Add User', 1, NULL, 'testing has been added.', '2023-06-13 03:08:13', NULL),
(537, 1, 'Edit User', 1, NULL, 'testings has been updated.', '2023-06-13 03:08:23', NULL),
(538, 1, 'Delete User', 1, NULL, 'testings has been deleted.', '2023-06-13 03:08:27', NULL),
(539, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 1 device(s).', '2023-06-13 03:08:39', NULL),
(540, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-06-13 03:09:01', NULL),
(541, 1, 'Software Restriction', 1, NULL, 'Software [ Notepad++ ] restriction has been updated.', '2023-06-13 03:09:16', NULL),
(542, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-06-13 03:09:30', NULL),
(543, 1, 'Edit Group Details', 1, NULL, 'Group [ Tests ] details has been updated.', '2023-06-13 03:09:37', NULL),
(544, 1, 'Add Group\'s Device', 1, NULL, '1 devices [DESKTOP-3Q67JPL] have been added to group [Tests]', '2023-06-13 03:09:42', NULL),
(545, 1, 'Remove Group\'s Devices', 1, NULL, '1 devices [ DESKTOP-3Q67JPL ] have been removed from group [ Tests ]', '2023-06-13 03:09:45', NULL),
(546, 1, 'Delete Device Group', 1, NULL, 'Group [ Tests ] has been deleted.', '2023-06-13 03:09:50', NULL),
(547, 1, 'Delete Role', 1, NULL, 'Role [ Tests ] has been deleted.', '2023-06-13 03:09:56', NULL),
(548, 1, 'Software Restriction', 1, NULL, 'Software [ Notepad++ ] restriction has been updated.', '2023-06-13 03:11:58', NULL),
(549, 1, 'Prohibited Software Reminder', 1, NULL, 'Prohibited Software reminder successfully sent to 2 device(s).', '2023-06-13 03:12:09', NULL),
(550, 1, 'Software License', 1, NULL, 'Software [ Sublime ] license has been updated.', '2023-06-13 03:12:20', NULL),
(551, 1, 'Add Group', 1, NULL, 'Group [ test ] has been added.', '2023-06-13 06:51:49', NULL),
(552, 1, 'Edit Role', 1, NULL, 'Role [ Software Editor ] permissions has been updated.', '2023-06-13 06:52:01', NULL),
(553, 1, 'OS Update Reminder', 1, NULL, 'OS Update reminder successfully sent to 3 device(s).', '2023-06-13 06:58:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `all_software`
--

CREATE TABLE `all_software` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `restriction` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `all_software`
--

INSERT INTO `all_software` (`id`, `name`, `version`, `type`, `created_at`, `updated_at`, `restriction`) VALUES
(1, 'Notepad++', '8.5.2', 1, NULL, '2023-06-13 03:11:58', 0),
(2, 'Microsoft Windows', '11', 1, NULL, '2023-05-23 22:11:47', 1),
(3, 'Sublime', '5.2', 0, NULL, '2023-06-13 03:12:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auth_log`
--

CREATE TABLE `auth_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_log`
--

INSERT INTO `auth_log` (`id`, `user_id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, NULL, 0, 'Wrong Credentials', '2023-05-20 16:00:00', NULL),
(3, NULL, 0, 'Wrong Credentials.', '2023-05-22 02:28:05', NULL),
(4, 1, 1, NULL, '2023-05-22 02:31:15', NULL),
(5, NULL, 0, 'Wrong Credentials.', '2023-05-22 02:31:30', NULL),
(6, 6, 1, NULL, '2023-05-22 02:31:41', NULL),
(7, 1, 1, NULL, '2023-05-22 02:35:29', NULL),
(8, NULL, 0, 'Wrong Credentials.', '2023-05-22 03:02:28', NULL),
(9, 1, 1, NULL, '2023-05-22 03:02:33', NULL),
(10, NULL, 0, 'Wrong Credentials.', '2023-05-22 03:02:52', NULL),
(11, NULL, 0, 'Wrong Credentials.', '2023-05-22 03:02:57', NULL),
(12, 1, 1, NULL, '2023-05-22 03:03:02', NULL),
(13, 2, 1, NULL, '2023-05-22 03:03:24', NULL),
(14, 1, 1, NULL, '2023-05-22 03:03:40', NULL),
(15, 6, 1, NULL, '2023-05-22 03:16:09', NULL),
(16, 2, 1, NULL, '2023-05-22 03:16:25', NULL),
(17, 1, 1, NULL, '2023-05-22 03:17:10', NULL),
(18, 1, 1, NULL, '2023-05-22 05:44:09', NULL),
(19, 1, 1, NULL, '2023-05-22 07:39:28', NULL),
(20, 55, 1, NULL, '2023-05-22 08:33:48', NULL),
(21, NULL, 0, 'Wrong Credentials.', '2023-05-22 08:34:03', NULL),
(22, NULL, 0, 'Wrong Credentials.', '2023-05-22 08:34:08', NULL),
(23, NULL, 0, 'Wrong Credentials.', '2023-05-22 08:34:15', NULL),
(24, NULL, 0, 'Wrong Credentials.', '2023-05-22 08:34:21', NULL),
(25, 6, 1, NULL, '2023-05-22 08:34:51', NULL),
(26, 1, 1, NULL, '2023-05-22 08:35:07', NULL),
(27, 1, 1, NULL, '2023-05-23 00:01:33', NULL),
(28, 1, 1, NULL, '2023-05-23 00:46:34', NULL),
(29, 60, 1, NULL, '2023-05-23 00:56:49', NULL),
(30, 1, 1, NULL, '2023-05-23 00:57:04', NULL),
(31, 1, 1, NULL, '2023-05-23 02:59:53', NULL),
(32, 59, 1, NULL, '2023-05-23 03:00:13', NULL),
(33, 1, 1, NULL, '2023-05-23 03:00:25', NULL),
(34, 60, 1, NULL, '2023-05-23 03:37:23', NULL),
(35, 1, 1, NULL, '2023-05-23 03:37:59', NULL),
(36, 2, 1, NULL, '2023-05-23 08:23:06', NULL),
(37, 1, 1, NULL, '2023-05-23 08:23:17', NULL),
(38, 1, 1, NULL, '2023-05-24 00:06:40', NULL),
(39, 2, 1, NULL, '2023-05-24 00:27:34', NULL),
(40, 1, 1, NULL, '2023-05-24 00:27:44', NULL),
(41, 2, 1, NULL, '2023-05-24 00:28:00', NULL),
(42, 2, 1, NULL, '2023-05-24 00:29:27', NULL),
(43, 1, 1, NULL, '2023-05-24 00:36:11', NULL),
(44, 2, 1, NULL, '2023-05-24 00:36:35', NULL),
(45, 1, 1, NULL, '2023-05-24 00:46:05', NULL),
(46, 2, 1, NULL, '2023-05-24 00:46:16', NULL),
(47, 3, 1, NULL, '2023-05-24 00:50:53', NULL),
(48, 1, 1, NULL, '2023-05-24 00:51:10', NULL),
(49, 1, 1, NULL, '2023-05-24 00:51:41', NULL),
(50, 2, 1, NULL, '2023-05-24 00:51:49', NULL),
(51, 1, 1, NULL, '2023-05-24 00:52:16', NULL),
(52, 1, 1, NULL, '2023-05-25 00:00:35', NULL),
(53, 2, 1, NULL, '2023-05-25 03:37:07', NULL),
(54, 2, 1, NULL, '2023-05-25 03:37:18', NULL),
(55, 1, 1, NULL, '2023-05-25 03:37:36', NULL),
(56, 2, 1, NULL, '2023-05-25 03:39:55', NULL),
(57, 1, 1, NULL, '2023-05-25 03:40:17', NULL),
(58, NULL, 0, 'Wrong Credentials.', '2023-05-25 04:20:25', NULL),
(59, 1, 1, NULL, '2023-05-25 04:20:30', NULL),
(60, 1, 1, NULL, '2023-05-26 00:05:24', NULL),
(61, 1, 1, NULL, '2023-05-26 06:19:50', NULL),
(62, 1, 1, NULL, '2023-05-28 23:42:23', NULL),
(63, NULL, 0, 'Wrong Credentials.', '2023-05-30 00:01:04', NULL),
(64, 1, 1, NULL, '2023-05-30 00:01:12', NULL),
(65, 6, 1, NULL, '2023-05-30 00:10:25', NULL),
(66, 1, 1, NULL, '2023-05-30 00:10:50', NULL),
(67, NULL, 0, 'Validation Error.', '2023-05-30 03:47:07', NULL),
(68, NULL, 0, 'Wrong Credentials.', '2023-05-30 03:47:16', NULL),
(69, NULL, 0, 'Wrong Credentials.', '2023-05-30 03:47:23', NULL),
(70, 1, 1, NULL, '2023-05-30 03:47:29', NULL),
(71, NULL, 0, 'Validation Error.', '2023-05-30 03:47:39', NULL),
(72, 2, 1, NULL, '2023-05-30 03:47:46', NULL),
(73, 1, 1, NULL, '2023-05-30 03:51:18', NULL),
(74, NULL, 0, 'Validation Error.', '2023-05-30 06:57:05', NULL),
(75, NULL, 0, 'Wrong Credentials.', '2023-05-30 07:13:46', NULL),
(76, NULL, 0, 'Validation Error.', '2023-05-30 07:13:58', NULL),
(77, NULL, 0, 'Validation Error.', '2023-05-30 07:14:12', NULL),
(78, NULL, 0, 'Validation Error.', '2023-05-30 07:14:29', NULL),
(79, NULL, 0, 'Wrong Credentials.', '2023-05-30 07:14:50', NULL),
(80, NULL, 0, 'Validation Error.', '2023-05-30 07:15:01', NULL),
(81, 1, 1, NULL, '2023-05-30 07:15:12', NULL),
(82, 1, 1, NULL, '2023-05-30 07:15:44', NULL),
(83, NULL, 0, 'Validation Error.', '2023-05-30 07:17:15', NULL),
(84, 6, 1, NULL, '2023-05-30 07:17:55', NULL),
(85, 1, 1, NULL, '2023-05-30 07:18:15', NULL),
(86, 1, 1, NULL, '2023-05-30 23:58:49', NULL),
(87, 1, 1, NULL, '2023-06-06 00:00:51', NULL),
(88, 1, 1, NULL, '2023-06-07 00:04:03', NULL),
(89, 1, 1, NULL, '2023-06-07 06:35:35', NULL),
(90, 1, 1, NULL, '2023-06-08 00:19:54', NULL),
(91, 1, 1, NULL, '2023-06-08 06:25:31', NULL),
(92, 1, 1, NULL, '2023-06-09 00:08:11', NULL),
(93, 1, 1, NULL, '2023-06-09 06:21:32', NULL),
(94, 1, 1, NULL, '2023-06-10 03:28:15', NULL),
(95, 6, 1, NULL, '2023-06-10 05:01:53', NULL),
(96, 1, 1, NULL, '2023-06-10 05:08:12', NULL),
(97, 63, 1, NULL, '2023-06-10 06:15:00', NULL),
(98, 1, 1, NULL, '2023-06-10 06:15:13', NULL),
(99, 1, 1, NULL, '2023-06-10 06:26:48', NULL),
(100, 6, 1, NULL, '2023-06-10 06:38:07', NULL),
(101, 6, 1, NULL, '2023-06-10 06:39:16', NULL),
(102, 1, 1, NULL, '2023-06-10 06:41:29', NULL),
(103, 1, 1, NULL, '2023-06-10 06:41:48', NULL),
(104, 6, 1, NULL, '2023-06-10 06:41:56', NULL),
(105, 1, 1, NULL, '2023-06-10 06:42:39', NULL),
(106, 6, 1, NULL, '2023-06-10 06:43:04', NULL),
(107, 1, 1, NULL, '2023-06-10 06:43:34', NULL),
(108, 6, 1, NULL, '2023-06-10 06:43:54', NULL),
(109, 1, 1, NULL, '2023-06-10 06:46:46', NULL),
(110, 1, 1, NULL, '2023-06-11 13:43:13', NULL),
(111, 1, 1, NULL, '2023-06-12 00:21:18', NULL),
(112, 1, 1, NULL, '2023-06-12 12:56:17', NULL),
(113, 6, 1, NULL, '2023-06-12 14:04:28', NULL),
(114, 1, 1, NULL, '2023-06-12 14:07:01', NULL),
(115, 1, 1, NULL, '2023-06-13 00:23:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `device_owner` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `name`, `status`, `device_owner`, `created_at`, `updated_at`) VALUES
(1, 'Windows-1453-Scranton', 1, 'Muhammad Zikri bin Roslan', '2023-05-17 02:12:00', NULL),
(2, 'DESKTOP-3Q67JPL', 0, 'Mcjoey Michael Enggat', '2023-05-16 02:10:41', NULL),
(3, 'MSI', 1, 'Lily', '2023-05-16 02:18:16', NULL),
(4, 'Device 4', 1, 'Zikri', '2023-05-29 02:05:42', NULL),
(9, 'Device 3', 0, 'Ali', '2023-03-29 19:07:48', '2023-05-29 19:07:48'),
(11, 'Device 2', 1, 'zek', '2023-06-06 00:10:32', '2023-06-06 00:10:32'),
(12, 'Device 1', 1, 'Test', '2023-06-06 22:57:32', '2023-06-06 22:57:32'),
(13, 'Device 5', 1, 'Test', '2023-07-13 01:19:14', '2023-06-13 01:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `device_group`
--

CREATE TABLE `device_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `device_group`
--

INSERT INTO `device_group` (`id`, `group_id`, `device_id`, `created_at`, `updated_at`) VALUES
(75, 24, 2, NULL, NULL),
(76, 24, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_software`
--

CREATE TABLE `device_software` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `all_software_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `device_software`
--

INSERT INTO `device_software` (`id`, `device_id`, `all_software_id`, `created_at`, `updated_at`) VALUES
(4, 1, 2, NULL, NULL),
(6, 3, 3, NULL, NULL),
(7, 4, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_state`
--

CREATE TABLE `device_state` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `uptime` varchar(255) DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `device_state`
--

INSERT INTO `device_state` (`id`, `device_id`, `uptime`, `state`, `created_at`, `updated_at`) VALUES
(2, 3, '7 Hours 20 minutes', 1, NULL, NULL),
(3, 1, '', 0, NULL, NULL),
(4, 4, '', 1, NULL, NULL),
(5, 9, NULL, 0, '2023-05-29 19:07:48', '2023-05-29 19:07:48'),
(7, 11, NULL, 0, '2023-06-06 00:10:32', '2023-06-06 00:10:32'),
(8, 12, NULL, 1, '2023-06-06 22:57:32', '2023-06-06 22:57:32'),
(9, 13, NULL, 1, '2023-06-13 01:19:14', '2023-06-13 01:19:14');

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
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(24, 'CSM', 'CSM', '2023-06-07 22:32:51', '2023-06-07 22:32:51'),
(30, 'Test', 'test', '2023-06-13 06:51:49', '2023-06-13 06:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `hardware`
--

CREATE TABLE `hardware` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `OS_Version` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `system_family` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hardware`
--

INSERT INTO `hardware` (`id`, `device_id`, `name`, `OS_Version`, `vendor`, `serial_number`, `domain`, `system_family`, `version`, `created_at`, `updated_at`) VALUES
(1, 1, 'Windows-1453-Scranton', '4.4', '', 'BITT-YEHE-DDFF-7HHA-YUYT', 'WORKGROUP', '', 'Latitude 3490', NULL, NULL),
(2, 3, 'MSI', '4.4.8', '', '', '', '', '', NULL, NULL),
(4, 4, 'Device 4', '5', '-', '-', '-', '-', '5.0', NULL, NULL),
(9, 9, 'Device 3', '5.5', '-', '-', '-', '-', '-', '2023-05-29 19:07:48', '2023-05-29 19:07:48'),
(11, 11, 'Device 2', '5.5', '-', '-', '-', '-', '-', '2023-06-06 00:10:32', '2023-06-06 00:10:32'),
(12, 12, 'Device 1', '5.4', '-', '-', '-', '-', '-', '2023-06-06 22:57:32', '2023-06-06 22:57:32'),
(13, 13, 'Device 5', '5.5', '-', '-', '-', '-', '-', '2023-06-13 01:19:14', '2023-06-13 01:19:14');

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
(7, '2014_10_12_000000_create_users_table', 1),
(8, '2014_10_12_100000_create_password_resets_table', 1),
(9, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(11, '2022_03_04_111631_create_customer_table', 1),
(12, '2023_05_10_003054_create_devices_table', 2),
(13, '2023_05_16_004209_create_hardware_table', 3),
(14, '2023_05_16_004653_create_device_state_table', 4),
(15, '2023_05_16_004835_create_all_software_table', 5),
(16, '2023_05_16_004756_create_device_software_table', 6),
(17, '2023_05_19_004007_create_auth_log_table', 7),
(18, '2023_05_19_004203_create_activity_log_table', 8),
(19, '2023_05_19_013659_create_activity_log_table', 9),
(20, '2023_05_23_021601_add_deleted_at_to_users_table', 10),
(21, '2023_05_23_074022_create_settings_table', 11),
(22, '2023_05_29_023205_add_authorization_to_all_software', 12),
(23, '2023_05_31_024756_create_groups_table', 13),
(24, '2023_05_31_025314_create_groups_table', 14),
(25, '2023_05_31_025343_create_device_group_table', 15),
(26, '2023_06_09_011656_create_notification_log_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `notification_log`
--

CREATE TABLE `notification_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_log`
--

INSERT INTO `notification_log` (`id`, `user_id`, `activity_id`, `is_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 1, 475, 1, '2023-06-09 07:43:28', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(23, 6, 475, 1, '2023-06-09 07:43:28', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(24, 1, 476, 1, '2023-06-09 07:50:57', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(25, 6, 476, 1, '2023-06-09 07:50:57', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(26, 63, 476, 0, '2023-06-09 07:50:57', NULL, NULL),
(27, 1, 477, 1, '2023-06-09 07:56:31', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(28, 6, 477, 1, '2023-06-09 07:56:31', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(29, 1, 478, 1, '2023-06-09 07:56:54', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(30, 6, 478, 1, '2023-06-09 07:56:54', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(31, 1, 479, 1, '2023-06-09 08:15:28', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(32, 6, 479, 1, '2023-06-09 08:15:28', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(33, 1, 480, 1, '2023-06-07 16:00:00', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(34, 6, 480, 1, '2023-06-08 08:15:37', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(35, 1, 481, 1, '2023-06-10 03:56:22', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(36, 1, 482, 1, '2023-06-10 03:56:47', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(37, 6, 482, 1, '2023-06-10 03:56:47', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(38, 63, 482, 0, '2023-06-10 03:56:47', NULL, NULL),
(39, 1, 483, 1, '2023-06-10 03:57:01', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(40, 1, 484, 1, '2023-06-10 04:14:56', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(41, 6, 484, 1, '2023-06-10 04:14:56', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(42, 63, 484, 0, '2023-06-10 04:14:56', NULL, NULL),
(43, 1, 485, 1, '2023-06-10 04:27:24', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(44, 1, 486, 1, '2023-06-10 04:27:35', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(45, 1, 487, 1, '2023-06-10 04:38:20', '2023-06-10 04:46:11', '2023-06-10 04:46:11'),
(46, 1, 488, 1, '2023-06-10 04:58:16', '2023-06-10 06:14:08', '2023-06-10 06:14:08'),
(47, 1, 489, 0, '2023-06-10 05:03:21', '2023-06-10 06:14:08', '2023-06-10 06:14:08'),
(48, 6, 489, 1, '2023-06-10 05:03:21', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(49, 63, 489, 0, '2023-06-10 05:03:21', NULL, NULL),
(50, 1, 490, 0, '2023-06-10 05:03:23', '2023-06-10 06:14:08', '2023-06-10 06:14:08'),
(51, 6, 490, 1, '2023-06-10 05:03:23', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(52, 63, 490, 0, '2023-06-10 05:03:23', NULL, NULL),
(53, 1, 493, 0, '2023-06-10 05:06:44', '2023-06-10 06:14:08', '2023-06-10 06:14:08'),
(54, 6, 493, 0, '2023-06-10 05:06:44', '2023-06-10 06:39:32', '2023-06-10 06:39:32'),
(55, 63, 493, 0, '2023-06-10 05:06:44', NULL, NULL),
(56, 1, 494, 0, '2023-06-10 05:15:02', '2023-06-10 06:14:08', '2023-06-10 06:14:08'),
(57, 1, 495, 0, '2023-06-10 05:15:15', '2023-06-10 06:14:08', '2023-06-10 06:14:08'),
(58, 1, 496, 1, '2023-06-10 06:17:09', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(59, 1, 497, 1, '2023-06-10 06:17:28', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(60, 1, 499, 1, '2023-06-10 06:18:44', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(61, 1, 500, 1, '2023-06-10 06:41:42', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(62, 1, 501, 1, '2023-06-10 06:42:58', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(63, 1, 502, 1, '2023-06-10 06:43:47', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(64, 1, 503, 1, '2023-06-10 06:46:57', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(65, 1, 504, 1, '2023-06-10 06:48:57', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(66, 1, 505, 1, '2023-06-10 06:49:06', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(67, 1, 506, 1, '2023-06-10 06:50:11', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(68, 1, 507, 1, '2023-06-10 06:50:32', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(69, 1, 508, 1, '2023-06-10 06:51:10', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(70, 1, 509, 1, '2023-06-10 06:51:16', '2023-06-10 06:51:29', '2023-06-10 06:51:29'),
(71, 1, 510, 1, '2023-06-11 13:43:29', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(72, 1, 511, 1, '2023-06-11 13:43:37', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(73, 1, 512, 1, '2023-06-11 13:43:41', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(74, 1, 513, 1, '2023-06-11 13:43:57', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(75, 6, 513, 0, '2023-06-11 13:43:57', NULL, NULL),
(76, 63, 513, 0, '2023-06-11 13:43:57', NULL, NULL),
(77, 1, 516, 1, '2023-06-11 13:45:34', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(78, 1, 517, 1, '2023-06-11 13:45:39', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(79, 1, 518, 1, '2023-06-11 13:45:57', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(80, 1, 519, 1, '2023-06-11 13:46:07', '2023-06-12 00:21:32', '2023-06-12 00:21:32'),
(81, 1, 520, 0, '2023-06-12 02:16:35', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(82, 1, 521, 0, '2023-06-12 03:47:54', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(83, 1, 523, 0, '2023-06-13 00:43:34', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(84, 6, 523, 0, '2023-06-13 00:43:34', NULL, NULL),
(85, 63, 523, 0, '2023-06-13 00:43:34', NULL, NULL),
(86, 1, 524, 0, '2023-06-13 01:19:14', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(87, 1, 525, 0, '2023-06-13 02:07:46', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(88, 1, 526, 0, '2023-06-13 02:08:19', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(89, 1, 527, 0, '2023-06-13 02:22:59', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(90, 6, 527, 0, '2023-06-13 02:22:59', NULL, NULL),
(91, 63, 527, 0, '2023-06-13 02:22:59', NULL, NULL),
(92, 1, 528, 0, '2023-06-13 02:23:03', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(93, 6, 528, 0, '2023-06-13 02:23:03', NULL, NULL),
(94, 63, 528, 0, '2023-06-13 02:23:03', NULL, NULL),
(95, 1, 529, 0, '2023-06-13 02:43:58', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(96, 6, 529, 0, '2023-06-13 02:43:58', NULL, NULL),
(97, 63, 529, 0, '2023-06-13 02:43:58', NULL, NULL),
(98, 1, 530, 0, '2023-06-13 02:44:12', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(99, 6, 530, 0, '2023-06-13 02:44:12', NULL, NULL),
(100, 63, 530, 0, '2023-06-13 02:44:12', NULL, NULL),
(101, 1, 531, 0, '2023-06-13 02:44:16', '2023-06-13 03:07:20', '2023-06-13 03:07:20'),
(102, 6, 531, 0, '2023-06-13 02:44:16', NULL, NULL),
(103, 63, 531, 0, '2023-06-13 02:44:16', NULL, NULL),
(104, 1, 532, 1, '2023-06-13 03:07:29', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(105, 1, 533, 1, '2023-06-13 03:07:43', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(106, 1, 534, 1, '2023-06-13 03:07:50', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(107, 1, 535, 1, '2023-06-13 03:07:53', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(108, 1, 536, 1, '2023-06-13 03:08:13', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(109, 1, 537, 1, '2023-06-13 03:08:23', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(110, 1, 538, 1, '2023-06-13 03:08:27', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(111, 1, 539, 1, '2023-06-13 03:08:39', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(112, 6, 539, 0, '2023-06-13 03:08:39', NULL, NULL),
(113, 63, 539, 0, '2023-06-13 03:08:39', NULL, NULL),
(114, 1, 540, 1, '2023-06-13 03:09:01', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(115, 6, 540, 0, '2023-06-13 03:09:01', NULL, NULL),
(116, 63, 540, 0, '2023-06-13 03:09:01', NULL, NULL),
(117, 1, 541, 1, '2023-06-13 03:09:16', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(118, 6, 541, 0, '2023-06-13 03:09:16', NULL, NULL),
(119, 63, 541, 0, '2023-06-13 03:09:16', NULL, NULL),
(120, 1, 542, 1, '2023-06-13 03:09:30', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(121, 1, 543, 1, '2023-06-13 03:09:37', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(122, 1, 544, 1, '2023-06-13 03:09:42', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(123, 1, 545, 1, '2023-06-13 03:09:45', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(124, 1, 546, 1, '2023-06-13 03:09:50', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(125, 1, 547, 1, '2023-06-13 03:09:56', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(126, 1, 548, 1, '2023-06-13 03:11:58', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(127, 6, 548, 0, '2023-06-13 03:11:58', NULL, NULL),
(128, 63, 548, 0, '2023-06-13 03:11:58', NULL, NULL),
(129, 1, 549, 1, '2023-06-13 03:12:09', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(130, 6, 549, 0, '2023-06-13 03:12:09', NULL, NULL),
(131, 63, 549, 0, '2023-06-13 03:12:09', NULL, NULL),
(132, 1, 550, 1, '2023-06-13 03:12:20', '2023-06-13 06:51:40', '2023-06-13 06:51:40'),
(133, 6, 550, 0, '2023-06-13 03:12:20', NULL, NULL),
(134, 63, 550, 0, '2023-06-13 03:12:20', NULL, NULL),
(135, 1, 551, 1, '2023-06-13 06:51:49', '2023-06-13 06:52:33', '2023-06-13 06:52:33'),
(136, 1, 552, 1, '2023-06-13 06:52:01', '2023-06-13 06:52:33', '2023-06-13 06:52:33'),
(137, 1, 553, 1, '2023-06-13 06:58:42', '2023-06-13 06:58:53', '2023-06-13 06:58:53'),
(138, 6, 553, 0, '2023-06-13 06:58:42', NULL, NULL),
(139, 63, 553, 0, '2023-06-13 06:58:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'computer_device', 'Can manage computer devices', NULL, NULL),
(2, 'computer_device_detail', 'Can view detail of devices', NULL, NULL),
(3, 'computer_group', 'Can manage device groups', NULL, NULL),
(4, 'software_osupdate', 'Can manage OS Update', NULL, NULL),
(5, 'software_licensedSoftware', 'Can manage software license', NULL, NULL),
(6, 'software_prohibitedSoftware', 'Can manage software allowed/prohibited', NULL, NULL),
(7, 'log_auth', 'Can view auth log', NULL, NULL),
(8, 'log_activity', 'Can view activity log', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(164, 1, 1, NULL, NULL),
(165, 2, 1, NULL, NULL),
(166, 3, 1, NULL, NULL),
(167, 8, 1, NULL, NULL),
(168, 7, 1, NULL, NULL),
(169, 5, 1, NULL, NULL),
(170, 4, 1, NULL, NULL),
(171, 6, 1, NULL, NULL),
(172, 8, 53, NULL, NULL),
(173, 5, 53, NULL, NULL),
(174, 4, 53, NULL, NULL),
(175, 6, 53, NULL, NULL),
(176, 7, 53, NULL, NULL);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'This role have access to all features.', NULL, '2023-05-11 00:38:21'),
(3, 'Basic User', 'This is the default role.', NULL, NULL),
(53, 'Software Editor', 'Able to access to audit logs', '2023-05-24 19:53:06', '2023-06-10 06:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'OSVersion', '5.45', 1, NULL, '2023-06-13 03:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phonenumber` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phonenumber`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@email.com', NULL, '0123456780', '$2y$10$vZATkdtYL7Ml9DUwwR1PGuXBBw/mxhs4ezs9uXqyS2Huv9oxvn0Pu', 1, NULL, '2023-04-26 16:37:02', '2023-05-22 00:16:05', NULL),
(2, 'Audit Log', 'auditlog@email.com', NULL, '0123456765', '$2y$10$uGyeI/G3VTtt4I6.q7IJNuhNgFJifBz5fTfZPbl7mYBuMBJoPx3li', 3, NULL, '2023-04-26 16:42:54', '2023-05-30 17:09:39', NULL),
(3, 'Basic User', 'basicuser@email.com', NULL, '0123454362', '$2y$10$iMVjDuR8gf689XCwkDRDyOig73S/rxCbAJ1b8iDoHyh/98xf/A6CO', 3, NULL, '2023-04-26 16:43:21', '2023-05-23 16:50:46', NULL),
(5, 'John Doe', 'johndoe@email.com', NULL, '0127584921', '$2y$10$oRtonY91Umx2iejUEZW3KOeWwLEZXzWQclZ41IVRueoTk.JOZX1EW', 3, NULL, '2023-04-26 23:01:11', '2023-05-30 17:09:33', NULL),
(6, 'Mcjoey Michael Enggat anak Johnny', 'mcjoey@email.com', NULL, '0123456789', '$2y$10$7IM7j.jOZHrjwc.H/hh2.eudLW4KKC7c9Ft0jVzXuvW6UycUeuyqG', 53, NULL, '2023-05-01 23:36:56', '2023-06-11 13:45:39', NULL),
(58, 'test', NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-22 18:57:01', '2023-05-22 18:59:09', '2023-05-22 18:59:09'),
(59, 'tests', NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-22 19:00:04', '2023-05-22 19:00:36', '2023-05-22 19:00:36'),
(60, 'muhammad zikri bin roslan', NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-22 19:37:17', '2023-05-22 19:45:53', '2023-05-22 19:45:53'),
(61, 'Test', 'test@email.com', NULL, '5213131', '$2y$10$pZ9PMxPWPGWLH0fpGzGJVO7IGZhWt62Ei3FG/gtxh1fodkM4hB7cK', 3, NULL, '2023-05-30 17:07:23', '2023-05-30 17:09:26', NULL),
(62, 'Muhammad Zikri', 'zikri@email.com', NULL, '652131321', '$2y$10$SdF/b11g7fWsGe9u1z1DFuwYkP2RFD7UYzo/IdguQMmx5OJR3wRMC', 3, NULL, '2023-05-30 17:09:58', '2023-05-30 17:09:58', NULL),
(63, 'Testdata', 'testdata@email.com', NULL, '31231321', '$2y$10$ozUbzbHqJXWi8k4IqnWIQOj.YAx4oX4Z7rOhhwCNo17ZRn02fnqrq', 53, NULL, '2023-06-08 17:53:46', '2023-06-08 17:57:45', NULL),
(64, 'testings', NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-13 03:08:13', '2023-06-13 03:08:27', '2023-06-13 03:08:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_user_id_foreign` (`user_id`),
  ADD KEY `activity_log_user_id_affected_foreign` (`user_id_affected`);

--
-- Indexes for table `all_software`
--
ALTER TABLE `all_software`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_log`
--
ALTER TABLE `auth_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_log_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_group`
--
ALTER TABLE `device_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_group_group_id_foreign` (`group_id`),
  ADD KEY `device_group_device_id_foreign` (`device_id`);

--
-- Indexes for table `device_software`
--
ALTER TABLE `device_software`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_software_device_id_foreign` (`device_id`),
  ADD KEY `device_software_all_software_id_foreign` (`all_software_id`);

--
-- Indexes for table `device_state`
--
ALTER TABLE `device_state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_state_device_id_foreign` (`device_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hardware_device_id_foreign` (`device_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_log`
--
ALTER TABLE `notification_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_log_user_id_foreign` (`user_id`),
  ADD KEY `notification_log_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;

--
-- AUTO_INCREMENT for table `all_software`
--
ALTER TABLE `all_software`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auth_log`
--
ALTER TABLE `auth_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `device_group`
--
ALTER TABLE `device_group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `device_software`
--
ALTER TABLE `device_software`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `device_state`
--
ALTER TABLE `device_state`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `hardware`
--
ALTER TABLE `hardware`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notification_log`
--
ALTER TABLE `notification_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_user_id_affected_foreign` FOREIGN KEY (`user_id_affected`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `activity_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `auth_log`
--
ALTER TABLE `auth_log`
  ADD CONSTRAINT `auth_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `device_group`
--
ALTER TABLE `device_group`
  ADD CONSTRAINT `device_group_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `device_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `device_software`
--
ALTER TABLE `device_software`
  ADD CONSTRAINT `device_software_all_software_id_foreign` FOREIGN KEY (`all_software_id`) REFERENCES `all_software` (`id`),
  ADD CONSTRAINT `device_software_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`);

--
-- Constraints for table `device_state`
--
ALTER TABLE `device_state`
  ADD CONSTRAINT `device_state_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`);

--
-- Constraints for table `hardware`
--
ALTER TABLE `hardware`
  ADD CONSTRAINT `hardware_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`);

--
-- Constraints for table `notification_log`
--
ALTER TABLE `notification_log`
  ADD CONSTRAINT `notification_log_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activity_log` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
