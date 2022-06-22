-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2022 at 10:04 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `flightmv`
--

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`ID`, `group_name`, `group_roles`) VALUES
(1, 'Developer', 'MNG_GROUPS:MNG_USERS:MNG_ROLES:MNG_FLIGHTS'),
(2, 'Administrator', NULL),
(3, 'Example 1', NULL),
(4, 'Example 2', NULL);

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`ID`, `code`, `description`) VALUES
(1, 'MNG_GROUPS', 'Manage Groups'),
(2, 'MNG_USERS', 'Manage Users'),
(3, 'MNG_ROLES', 'Manage Roles'),
(4, 'MNG_FLIGHTS', 'Manage Flights');

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`ID`, `field`, `value`, `category`) VALUES
(1, 'email_is_on', 'TRUE', 'email'),
(2, 'from_address', 'helpdesk@localhost', 'email'),
(3, 'from_name', 'ICT Helpdesk', 'email'),
(4, 'outgoing_server', '10.2.2.53', 'email'),
(5, 'incoming_server', 'exchange.localhost', 'email'),
(6, 'auth_username', 'helpdesk@localhost', 'email'),
(7, 'auth_password', 'abc1234', 'email'),
(8, 'ssl_port', '465', 'email'),
(9, 'tls_port', '587', 'email'),
(10, 'hr_to_name', 'Ahmed Shan', 'email'),
(11, 'hr_to_email', 'ahmed.shan@localhost', 'email'),
(12, 'run_date_time', '16 01:34', 'run_time');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `display_name`, `email`, `contact_no`, `password`, `salt`, `first_loggedIn`, `last_loggedIn`, `group_id`, `isActive`, `isVerified`, `verify_code`, `joined_dt`) VALUES
(1, 'ahmed.shan', 'Ahmed Shan', 'ahmed@shan.mv', '9991947', 'af0821fa4011be71ad7277a558d825b87e7a360aa22155bc17ebc54d2c643b64', '5e4af0607acb41c383cd30b7c298ab50293adfecb7b18', '2019-10-20 01:30:50', '2022-06-23 01:13:22', 1, 1, 1, 'hrejrf', '2019-10-20 01:30:28'),
(2, 'test.author', 'Test Author', 'test1@example.com', '', 'af0821fa4011be71ad7277a558d825b87e7a360aa22155bc17ebc54d2c643b64', '5e4af0607acb41c383cd30b7c298ab50293adfecb7b18', NULL, '2020-02-18 00:58:58', 4, 1, 1, '', '2020-02-13 03:08:55'),
(3, 'test2', 'Test 2', 'test2example.com', '', '', '', '2020-02-26 22:19:43', '2020-02-26 22:19:43', 1, 0, 0, '', '2020-02-15 01:29:12'),
(4, 'test3', 'Test 3', 'test3@example.com', '', '', '', '2020-03-03 11:01:38', '2020-03-03 11:01:38', 1, 0, 0, '', '2020-02-15 01:30:17'),
(5, 'test.author1', 'Test Author', 'test.author@example.com', NULL, 'ead72ea846846c800e038c8a9abb79d3405d7a5f631fbd83ffa168ed8ded0e8f', '5e5051b4740411c383cd30b7c298ab50293adfecb7b18', NULL, NULL, 4, 0, 0, '', '2020-02-15 01:30:17'),
(6, 'test.editor', 'Test Editor', 'test.editor@example.com', NULL, 'fc54d8662bd25df2813ad338fe91e0f6836c231075c57e97e07491a9f88d8e10', '5e50534d2447d1c383cd30b7c298ab50293adfecb7b18', NULL, NULL, 3, 0, 0, '5e50534d244ab', '2020-02-15 01:30:17');

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`user_id`, `bg_image`, `dv_name`, `dv_bio`, `en_bio`, `social_media`) VALUES
(1, 'background.jpg', 'އަހުމަދު ޝާން', 'ަދަސދަސ', 'asdasdasd', 'http://www.twitter.com/thaanu16'),
(2, 'background.jpg', 'ޓެސްޓް އޯރތާރ', 'ދިވެހި ވަންތަ', 'Molhu liyun', ''),
(3, 'background.jpg', '', '', '', ''),
(4, 'background.jpg', '', '', '', ''),
(5, 'background.jpg', '', '', '', ''),
(6, 'background.jpg', '', '', '', '');
