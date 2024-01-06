-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 11:59 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p8_dts_ojt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE `tbl_documents` (
  `id` int(11) NOT NULL,
  `rfid` varchar(255) NOT NULL COMMENT 'RFID',
  `document_type_id` int(11) NOT NULL COMMENT 'Document Type Id',
  `document_purpose_id` int(11) NOT NULL COMMENT 'Document Purpose Id',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Status',
  `update_method` tinyint(4) DEFAULT NULL COMMENT 'Status (0=SMS ; 1=Email)',
  `verify_method` tinyint(4) DEFAULT NULL,
  `document_location` varchar(255) DEFAULT NULL COMMENT 'Document Location'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_documents`
--

INSERT INTO `tbl_documents` (`id`, `rfid`, `document_type_id`, `document_purpose_id`, `status`, `update_method`, `verify_method`, `document_location`) VALUES
(1, 'HG03J2KA2', 1, 1, 1, 1, 1, 'NCR'),
(2, 'KBBNAHEF02', 2, 2, 2, 2, 2, 'CALABARZON');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_histories`
--

CREATE TABLE `tbl_document_histories` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL COMMENT 'Document Id',
  `staff_id` int(11) NOT NULL COMMENT 'LGU Staff',
  `activity_date` datetime NOT NULL COMMENT 'Activity Date',
  `history_log` varchar(255) NOT NULL COMMENT 'History Logs',
  `note` text DEFAULT NULL COMMENT 'Document Notes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_document_histories`
--

INSERT INTO `tbl_document_histories` (`id`, `document_id`, `staff_id`, `activity_date`, `history_log`, `note`) VALUES
(1, 1, 1, '2023-05-29 09:46:31', 'JK16J2190', 'Fill up the address information');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_purposes`
--

CREATE TABLE `tbl_document_purposes` (
  `id` int(11) NOT NULL,
  `document_purpose` varchar(255) DEFAULT NULL COMMENT 'Document Purpose'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_document_purposes`
--

INSERT INTO `tbl_document_purposes` (`id`, `document_purpose`) VALUES
(1, 'Something form'),
(2, 'Application form');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_types`
--

CREATE TABLE `tbl_document_types` (
  `id` int(11) NOT NULL,
  `document_type` varchar(255) NOT NULL COMMENT 'Document Type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_document_types`
--

INSERT INTO `tbl_document_types` (`id`, `document_type`) VALUES
(1, 'Government'),
(2, 'School');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_escalate_documents`
--

CREATE TABLE `tbl_escalate_documents` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL COMMENT 'Document Id',
  `escalation_level` varchar(255) NOT NULL COMMENT 'Escalation Level',
  `note` text DEFAULT NULL COMMENT 'Additional Information',
  `email` varchar(255) NOT NULL COMMENT 'Email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_escalate_documents`
--

INSERT INTO `tbl_escalate_documents` (`id`, `document_id`, `escalation_level`, `note`, `email`) VALUES
(1, 1, 'Level 1 - Low Priority', 'Fill up the address information', 'example@email.com'),
(2, 2, 'Level 1 - Low Priority', 'Fill up the address information', 'example@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_management`
--

CREATE TABLE `tbl_user_management` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL COMMENT 'Account Id',
  `level` tinyint(4) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `last_name` varchar(255) NOT NULL COMMENT 'Last Name',
  `first_name` varchar(255) NOT NULL COMMENT 'First Name',
  `middle_name` varchar(255) DEFAULT NULL COMMENT 'Middle Name',
  `suffix_name` varchar(255) DEFAULT NULL COMMENT 'Suffix Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_management`
--

INSERT INTO `tbl_user_management` (`id`, `account_id`, `level`, `role`, `last_name`, `first_name`, `middle_name`, `suffix_name`) VALUES
(1, 1, 1, 1, 'Zakyr', 'Ramon', 'Kyle', 'Jr.'),
(2, 2, 2, 2, 'Vomerine', 'Andrei', 'Rich', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_documents_fk_1` (`document_purpose_id`),
  ADD KEY `tbl_documents_fk_2` (`document_type_id`);

--
-- Indexes for table `tbl_document_histories`
--
ALTER TABLE `tbl_document_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_document_histories_fk_1` (`document_id`),
  ADD KEY `tbl_document_histories_fk_2` (`staff_id`);

--
-- Indexes for table `tbl_document_purposes`
--
ALTER TABLE `tbl_document_purposes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_document_types`
--
ALTER TABLE `tbl_document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_escalate_documents`
--
ALTER TABLE `tbl_escalate_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_escalate_documents_fk_1` (`document_id`);

--
-- Indexes for table `tbl_user_management`
--
ALTER TABLE `tbl_user_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_document_histories`
--
ALTER TABLE `tbl_document_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_document_purposes`
--
ALTER TABLE `tbl_document_purposes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_escalate_documents`
--
ALTER TABLE `tbl_escalate_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_user_management`
--
ALTER TABLE `tbl_user_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD CONSTRAINT `tbl_documents_fk_1` FOREIGN KEY (`document_purpose_id`) REFERENCES `tbl_document_purposes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_documents_fk_2` FOREIGN KEY (`document_type_id`) REFERENCES `tbl_document_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_document_histories`
--
ALTER TABLE `tbl_document_histories`
  ADD CONSTRAINT `tbl_document_histories_fk_1` FOREIGN KEY (`document_id`) REFERENCES `tbl_documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_document_histories_fk_2` FOREIGN KEY (`staff_id`) REFERENCES `tbl_user_management` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_escalate_documents`
--
ALTER TABLE `tbl_escalate_documents`
  ADD CONSTRAINT `tbl_escalate_documents_fk_1` FOREIGN KEY (`document_id`) REFERENCES `tbl_documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
