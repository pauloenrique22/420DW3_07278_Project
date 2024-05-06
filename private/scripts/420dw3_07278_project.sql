-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 11:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `420dw3_07278_project`
--
CREATE DATABASE IF NOT EXISTS `420dw3_07278_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `420dw3_07278_project`;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_key` varchar(30) NOT NULL,
  `permission_name` varchar(30) DEFAULT NULL,
  `permission_description` varchar(70) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_key` (`permission_key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_key`, `permission_name`, `permission_description`, `created_at`, `updated_at`) VALUES
(1, 'LOGIN_ALLOWED', 'Login Access', 'Allows users to log-in to the system.', '2024-03-27 15:03:34', '2024-03-27 15:03:34'),
(2, 'CREATE_PERMISSIONS', 'Create Permissions', 'Allows creating new permission entities.', '2024-03-27 15:04:12', '2024-05-06 00:02:10'),
(3, 'UPDATE_PERMISSIONS', 'Update Permissions', 'Allows updating existing permission entities.', '2024-03-27 15:06:22', '2024-05-06 00:02:35'),
(4, 'DELETE_PERMISSIONS', 'Delete Permissions', 'Allows deletion of permission entities.', '2024-03-27 15:07:33', '2024-05-06 00:02:48'),
(5, 'CREATE_USERGROUPS', 'Create User Groups', 'Allows creating new user group entities.', '2024-03-27 15:08:12', '2024-05-06 00:02:55'),
(6, 'UPDATE_USERGROUPS', 'Update User Groups', 'Allows updating existing user group entities.', '2024-03-27 15:09:01', '2024-05-06 00:03:05'),
(7, 'DELETE_USERGROUPS', 'Delete User Groups', 'Allows deletion of user group entities.', '2024-03-27 15:10:23', '2024-05-06 00:03:14'),
(8, 'CREATE_USERS', 'Create Users', 'Allows creating new user entities.', '2024-03-27 15:11:12', '2024-05-06 00:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

DROP TABLE IF EXISTS `usergroups`;
CREATE TABLE IF NOT EXISTS `usergroups` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `group_description` varchar(70) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`user_group_id`, `group_name`, `group_description`, `date_created`, `date_modified`, `is_deleted`) VALUES
(1, 'Administrators', 'Group with full access to all management features.', '2024-03-27 21:12:52', '2024-03-27 21:12:52', 0),
(2, 'Managers', 'Group with access to user and group management features.', '2024-03-27 21:12:52', '2024-03-27 21:12:52', 0),
(3, 'Editors', 'Group with access to create and update features.', '2024-03-27 21:12:52', '2024-03-27 21:12:52', 0),
(4, 'Deleters', 'Group with access to delete records.', '2024-03-27 21:12:52', '2024-03-27 21:12:52', 0),
(5, 'Users', 'Basic access group for standard users.', '2024-03-27 21:34:39', '2024-03-27 21:34:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(85) NOT NULL,
  `email` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `date_created`, `updated_at`, `is_deleted`) VALUES
(1, 'scott', '$2y$10$dIq/JhlTdgEypTUVY7cvY.tRmYVnMKuUbVaSmaz9jJV4xAMXXKFRm', 'scott@email.com', '2024-04-01 02:04:19', '2024-04-21 10:23:09', 0),
(2, 'tintin', '$2y$10$dIq/JhlTdgEypTUVY7cvY.tRmYVnMKuUbVaSmaz9jJV4xAMXXKFRm', 'tintin@email.com', '2024-04-01 02:04:19', '2024-04-21 10:23:09', 0),
(3, 'milou', '$2y$10$dIq/JhlTdgEypTUVY7cvY.tRmYVnMKuUbVaSmaz9jJV4xAMXXKFRm', 'milou@email.com', '2024-04-01 02:04:19', '2024-04-29 10:23:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permissions`
--

DROP TABLE IF EXISTS `user_group_permissions`;
CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `user_group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`user_group_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_group_permissions`
--

INSERT INTO `user_group_permissions` (`user_group_id`, `permission_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 8),
(3, 6),
(4, 7),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`user_id`, `permission_id`) VALUES
(1, 1),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_usergroup`
--

DROP TABLE IF EXISTS `user_usergroup`;
CREATE TABLE IF NOT EXISTS `user_usergroup` (
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`),
  KEY `user_group_id` (`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_usergroup`
--

INSERT INTO `user_usergroup` (`user_id`, `user_group_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 2),
(3, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD CONSTRAINT `user_group_permissions_ibfk_1` FOREIGN KEY (`user_group_id`) REFERENCES `usergroups` (`user_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_group_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_usergroup`
--
ALTER TABLE `user_usergroup`
  ADD CONSTRAINT `user_usergroup_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_usergroup_ibfk_2` FOREIGN KEY (`user_group_id`) REFERENCES `usergroups` (`user_group_id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
