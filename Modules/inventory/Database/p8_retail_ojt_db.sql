-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 09:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p8_aisms_retail__ojt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batch_numbers`
--

CREATE TABLE `tbl_batch_numbers` (
  `id` int(11) NOT NULL,
  `retail_product_id` int(11) DEFAULT NULL COMMENT 'Retail Product ID',
  `batch_number` int(11) DEFAULT NULL COMMENT 'Batch Number',
  `expiry_date` datetime DEFAULT NULL COMMENT 'Product Expiration Date',
  `quantity` int(11) DEFAULT NULL COMMENT 'Received Quantity'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_batch_numbers`
--

INSERT INTO `tbl_batch_numbers` (`id`, `retail_product_id`, `batch_number`, `expiry_date`, `quantity`) VALUES
(1, 13, 1, '2023-05-19 15:41:23', 10),
(2, 1, 2, '2023-05-19 15:41:23', 10),
(3, 12, 3, '2023-05-19 15:43:29', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batch_number_issues`
--

CREATE TABLE `tbl_batch_number_issues` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) DEFAULT NULL COMMENT 'Issue Id',
  `batch_id` int(11) DEFAULT NULL COMMENT 'Batch Number Id',
  `quantity` int(11) DEFAULT NULL COMMENT 'Quantity'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_issue_labels`
--

CREATE TABLE `tbl_issue_labels` (
  `id` int(11) NOT NULL,
  `issue_name` varchar(255) DEFAULT NULL COMMENT 'Issue Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_issue_labels`
--

INSERT INTO `tbl_issue_labels` (`id`, `issue_name`) VALUES
(1, 'Damage Product'),
(2, 'Loss Product'),
(4, 'Invalid Product'),
(5, 'Expired Product'),
(8, 'Nearing Expiry'),
(9, 'Low Stock'),
(10, 'Expired'),
(11, 'Damage'),
(12, 'Broken'),
(13, 'Fail'),
(14, 'Delete_Test_1'),
(15, 'Delete_Test_2'),
(16, 'Delete_Test_3'),
(17, 'Delete_Test_4'),
(18, 'Delete_Test_5');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Name',
  `description` varchar(255) DEFAULT NULL COMMENT 'Description',
  `img` varchar(255) DEFAULT NULL COMMENT 'Path to IMG',
  `brand_id` int(11) DEFAULT NULL COMMENT 'Brand ID',
  `category_id` int(11) DEFAULT NULL COMMENT 'Category ID',
  `item_code` varchar(255) DEFAULT NULL COMMENT 'Item Code',
  `sku` varchar(255) DEFAULT NULL COMMENT 'SKU',
  `tag_id` int(11) DEFAULT NULL COMMENT 'Tag ID',
  `unit_of_measure` tinyint(1) DEFAULT NULL COMMENT '1-Piece|2-Centimeter|3-Inch|4-Foot|5-Yard|6-Meter|7-Miligram|8-Gram|9-Kilogram|10-Mililiter|11-Liter|12-Galon',
  `barcode` varchar(255) DEFAULT NULL COMMENT 'Barcode',
  `mpn` varchar(255) DEFAULT NULL COMMENT 'Manufacturer Part Number',
  `ean` varchar(255) DEFAULT NULL COMMENT 'European Article Number',
  `isbn` varchar(255) DEFAULT NULL COMMENT 'International Standard Book Number',
  `enable_serial_number` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-false,1-true',
  `enable_batch_tracking` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-false,1-true',
  `date_added` datetime NOT NULL COMMENT 'Date Added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `name`, `description`, `img`, `brand_id`, `category_id`, `item_code`, `sku`, `tag_id`, `unit_of_measure`, `barcode`, `mpn`, `ean`, `isbn`, `enable_serial_number`, `enable_batch_tracking`, `date_added`) VALUES
(2, 'Acer Nitro 5', 'Acer Gaming Laptop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-05-05 04:26:56'),
(3, 'Realme 5 Pro', 'Realme Budget Phone', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-05-05 04:27:23'),
(6, 'Logitech Extended Mouse Pad', 'Mouse Pad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2023-05-05 04:28:28'),
(7, 'RGB Red Light', 'its a Red Light but RGB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2023-05-13 14:31:01'),
(8, 'HBW Eraser', 'its an eraser but HBW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-05-13 14:31:01'),
(9, 'Laptop Stand', 'a Stand for a Laptop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2023-05-13 14:31:01'),
(10, 'Nike Airmax', 'cool Nike Airmax ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-05-13 14:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_variant_combinations`
--

CREATE TABLE `tbl_product_variant_combinations` (
  `id` int(11) NOT NULL,
  `option_1_id` int(11) DEFAULT NULL COMMENT 'Option ID(for product that has first variant)',
  `option_2_id` int(11) DEFAULT NULL COMMENT 'Option ID(for product that has variant)',
  `sku` varchar(255) DEFAULT NULL COMMENT 'SKU',
  `barcode` varchar(255) DEFAULT NULL COMMENT 'Barcode'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_variant_labels`
--

CREATE TABLE `tbl_product_variant_labels` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'Product ID',
  `label` varchar(255) NOT NULL COMMENT 'Label'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_variant_label_options`
--

CREATE TABLE `tbl_product_variant_label_options` (
  `id` int(11) NOT NULL,
  `label_id` int(11) NOT NULL COMMENT 'Variant Label ID',
  `option` varchar(255) NOT NULL COMMENT 'Option Value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reported_issues`
--

CREATE TABLE `tbl_reported_issues` (
  `id` int(11) NOT NULL,
  `retail_product_id` int(11) DEFAULT NULL COMMENT 'Retail Product Id',
  `request_id` int(11) DEFAULT NULL COMMENT 'Request Id',
  `quantity` int(11) DEFAULT NULL COMMENT 'Reported Issue Quantity',
  `issue_label_id` int(11) DEFAULT NULL COMMENT 'Issue Label Id',
  `action` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reported_issues`
--

INSERT INTO `tbl_reported_issues` (`id`, `retail_product_id`, `request_id`, `quantity`, `issue_label_id`, `action`) VALUES
(1, 1, 1, 100, 9, 1),
(9, 1, 25, 1, 1, 1),
(10, 1, 25, 1, 1, NULL),
(12, NULL, NULL, 1, 1, NULL),
(13, 10, NULL, 1, 1, NULL),
(14, 10, NULL, 1, 1, NULL),
(15, 10, NULL, 1, 1, NULL),
(16, 10, NULL, 1, 1, NULL),
(17, 10, NULL, 1, 1, NULL),
(18, 10, NULL, 1, 1, NULL),
(19, 10, NULL, 1, 1, NULL),
(20, 10, NULL, 1, 1, NULL),
(21, 10, NULL, 1, 1, NULL),
(22, 10, NULL, 1, 1, NULL),
(23, 10, NULL, 1, 1, NULL),
(24, 10, NULL, 1, 1, NULL),
(25, 10, NULL, 1, 1, NULL),
(26, 10, NULL, 1, 1, NULL),
(27, 10, NULL, 1, 1, NULL),
(28, 10, NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retail_products`
--

CREATE TABLE `tbl_retail_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL COMMENT 'Product Id(if product doesnt have variant)',
  `variant_id` int(11) DEFAULT NULL COMMENT 'Variant Id(if product have variant)',
  `store_id` int(11) DEFAULT NULL COMMENT 'Retail Store Id',
  `quantity` int(11) DEFAULT NULL COMMENT 'Product Quantity',
  `level` tinyint(4) DEFAULT NULL COMMENT '0-per batch,1-per item'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_retail_products`
--

INSERT INTO `tbl_retail_products` (`id`, `product_id`, `variant_id`, `store_id`, `quantity`, `level`) VALUES
(1, 7, NULL, 3, 600, NULL),
(2, 8, NULL, 5, 500, NULL),
(9, 10, NULL, 4, 100, NULL),
(10, 2, NULL, 2, 10, NULL),
(12, 9, NULL, 2, 10, NULL),
(13, 6, NULL, 4, 10, NULL),
(14, 3, NULL, 5, 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retail_stores`
--

CREATE TABLE `tbl_retail_stores` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Store Name',
  `email_address` varchar(255) DEFAULT NULL COMMENT 'Email Address',
  `phone_number` varchar(255) DEFAULT NULL COMMENT 'Phone Number',
  `province` varchar(255) DEFAULT NULL COMMENT 'Province',
  `city` varchar(255) DEFAULT NULL COMMENT 'City',
  `barangay` varchar(255) DEFAULT NULL COMMENT 'Barangay',
  `street` varchar(255) DEFAULT NULL COMMENT 'Street',
  `postal_code` tinyint(4) DEFAULT NULL COMMENT 'Postal Code',
  `latitude` float DEFAULT NULL COMMENT 'Latitude',
  `longitude` float DEFAULT NULL COMMENT 'Longitude',
  `store_manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_retail_stores`
--

INSERT INTO `tbl_retail_stores` (`id`, `name`, `email_address`, `phone_number`, `province`, `city`, `barangay`, `street`, `postal_code`, `latitude`, `longitude`, `store_manager_id`) VALUES
(1, 'Supplier', 'Supplier@gmail.com', '00001', 'Main Province', 'Main City', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Store_2', 'store2@gmail.com', '000002', 'Calamba', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Store_3', 'store3@gmail.com', '000003', 'Calamba', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Store_4', 'store4@gmail.com', '000004', 'Calamba', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Store_5', 'store5@gmail.com', '000005', 'Calamba', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Store_name_6', 'StoreName6@gmail.com', '0000006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_serial_numbers`
--

CREATE TABLE `tbl_serial_numbers` (
  `id` int(11) NOT NULL,
  `retail_product_id` int(11) DEFAULT NULL COMMENT 'Retail Product Id',
  `serial_number` varchar(255) NOT NULL COMMENT 'Serial Number'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_serial_numbers`
--

INSERT INTO `tbl_serial_numbers` (`id`, `retail_product_id`, `serial_number`) VALUES
(1, 10, '5345SDVREWRTG'),
(2, 14, '967GDFGTRHKITY'),
(3, 2, '5673SFGRTHSWQA'),
(4, 9, '6324SDFRTHDFGTU');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_serial_number_issues`
--

CREATE TABLE `tbl_serial_number_issues` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) DEFAULT NULL COMMENT 'Issue Id',
  `serial_number_id` int(11) DEFAULT NULL COMMENT 'Serial Number Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_serial_number_issues`
--

INSERT INTO `tbl_serial_number_issues` (`id`, `issue_id`, `serial_number_id`) VALUES
(1, 13, 1),
(2, 14, 1),
(3, 15, 1),
(4, 16, 1),
(5, 17, 1),
(6, 18, 1),
(7, 19, 1),
(8, 20, 1),
(9, 21, 1),
(10, 22, 1),
(11, 23, 1),
(12, 24, 1),
(13, 25, 1),
(14, 26, 1),
(15, 27, 1),
(16, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer_requests`
--

CREATE TABLE `tbl_transfer_requests` (
  `id` int(11) NOT NULL,
  `requesting_store_id` int(11) DEFAULT NULL COMMENT 'Requesting Store Id',
  `accepting_store_id` int(11) DEFAULT NULL COMMENT 'Accepting Store Id',
  `date_requested` datetime DEFAULT NULL COMMENT 'Date and Time Requested',
  `message` varchar(255) DEFAULT NULL COMMENT 'Message',
  `status` tinyint(4) DEFAULT NULL COMMENT '0-pending, 1-accepted, 2-cancel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_transfer_requests`
--

INSERT INTO `tbl_transfer_requests` (`id`, `requesting_store_id`, `accepting_store_id`, `date_requested`, `message`, `status`) VALUES
(1, 3, 3, '2023-05-14 10:22:40', 'I would like to not request for restock from your store and deliver here ASAP', 2),
(4, 3, NULL, NULL, 'I would like to request for restock from your store and deliver here ASAP', 0),
(25, 3, NULL, NULL, 'a I would like to not request for restock from your store and deliver here ASAP', 0),
(46, 3, NULL, NULL, 'I would like to request for restock from your store and deliver here ASAP', 0),
(47, 3, NULL, NULL, 'I would like to request for restock from your store and deliver here ASAP', 0),
(401, 3, NULL, NULL, 'I would like to request for restock from your store and deliver here ASAP', 0),
(402, 3, NULL, NULL, 'I would like to request for restock from your store and deliver here ASAP', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer_request_products`
--

CREATE TABLE `tbl_transfer_request_products` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL COMMENT 'Transfer Request Id',
  `retail_product_id` int(11) DEFAULT NULL COMMENT 'Retail Product Id',
  `quantity` int(11) DEFAULT NULL COMMENT 'Product Request Quantity',
  `status` tinyint(4) DEFAULT NULL COMMENT '0-pending,1-accepted,2-cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_transfer_request_products`
--

INSERT INTO `tbl_transfer_request_products` (`id`, `request_id`, `retail_product_id`, `quantity`, `status`) VALUES
(22, 1, 1, 100, 2),
(33, 46, 1, 600, 0),
(34, 47, 1, 600, 0),
(35, 4, 1, 600, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_batch_numbers`
--
ALTER TABLE `tbl_batch_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_batch_numbers_fk_1` (`retail_product_id`);

--
-- Indexes for table `tbl_batch_number_issues`
--
ALTER TABLE `tbl_batch_number_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_batch_number_issues_fk_1` (`batch_id`),
  ADD KEY `tbl_batch_number_issues_fk_2` (`issue_id`);

--
-- Indexes for table `tbl_issue_labels`
--
ALTER TABLE `tbl_issue_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_variant_combinations`
--
ALTER TABLE `tbl_product_variant_combinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_variant_combinations_fk_1` (`option_1_id`),
  ADD KEY `tbl_product_variant_combinations_fk_2` (`option_2_id`);

--
-- Indexes for table `tbl_product_variant_labels`
--
ALTER TABLE `tbl_product_variant_labels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_variant_labels_fk_1` (`product_id`);

--
-- Indexes for table `tbl_product_variant_label_options`
--
ALTER TABLE `tbl_product_variant_label_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_variant_label_options_fk_1` (`label_id`);

--
-- Indexes for table `tbl_reported_issues`
--
ALTER TABLE `tbl_reported_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_reported_issues_fk_1` (`retail_product_id`),
  ADD KEY `tbl_reported_issues_fk_2` (`issue_label_id`),
  ADD KEY `tbl_reported_issues_fk_3` (`request_id`);

--
-- Indexes for table `tbl_retail_products`
--
ALTER TABLE `tbl_retail_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_retail_products_fk_1` (`variant_id`),
  ADD KEY `tbl_retail_products_fk_2` (`product_id`),
  ADD KEY `tbl_retail_products_fk_3` (`store_id`);

--
-- Indexes for table `tbl_retail_stores`
--
ALTER TABLE `tbl_retail_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_serial_numbers`
--
ALTER TABLE `tbl_serial_numbers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`) USING BTREE,
  ADD KEY `tbl_serial_numbers_fk_1` (`retail_product_id`);

--
-- Indexes for table `tbl_serial_number_issues`
--
ALTER TABLE `tbl_serial_number_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_serial_number_issues_fk_1` (`serial_number_id`),
  ADD KEY `tbl_serial_number_issues_fk_2` (`issue_id`);

--
-- Indexes for table `tbl_transfer_requests`
--
ALTER TABLE `tbl_transfer_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_transfer_requests_fk_1` (`requesting_store_id`),
  ADD KEY `tbl_transfer_requests_fk_2` (`accepting_store_id`);

--
-- Indexes for table `tbl_transfer_request_products`
--
ALTER TABLE `tbl_transfer_request_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_transfer_request_products_fk_1` (`request_id`),
  ADD KEY `tbl_transfer_request_products_fk_2` (`retail_product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_batch_numbers`
--
ALTER TABLE `tbl_batch_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_batch_number_issues`
--
ALTER TABLE `tbl_batch_number_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_issue_labels`
--
ALTER TABLE `tbl_issue_labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_product_variant_combinations`
--
ALTER TABLE `tbl_product_variant_combinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_variant_labels`
--
ALTER TABLE `tbl_product_variant_labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_variant_label_options`
--
ALTER TABLE `tbl_product_variant_label_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reported_issues`
--
ALTER TABLE `tbl_reported_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_retail_products`
--
ALTER TABLE `tbl_retail_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_retail_stores`
--
ALTER TABLE `tbl_retail_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_serial_numbers`
--
ALTER TABLE `tbl_serial_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_serial_number_issues`
--
ALTER TABLE `tbl_serial_number_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_transfer_requests`
--
ALTER TABLE `tbl_transfer_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;

--
-- AUTO_INCREMENT for table `tbl_transfer_request_products`
--
ALTER TABLE `tbl_transfer_request_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_batch_numbers`
--
ALTER TABLE `tbl_batch_numbers`
  ADD CONSTRAINT `tbl_batch_numbers_fk_1` FOREIGN KEY (`retail_product_id`) REFERENCES `tbl_retail_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_batch_number_issues`
--
ALTER TABLE `tbl_batch_number_issues`
  ADD CONSTRAINT `tbl_batch_number_issues_fk_1` FOREIGN KEY (`batch_id`) REFERENCES `tbl_batch_numbers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_batch_number_issues_fk_2` FOREIGN KEY (`issue_id`) REFERENCES `tbl_reported_issues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_product_variant_combinations`
--
ALTER TABLE `tbl_product_variant_combinations`
  ADD CONSTRAINT `tbl_product_variant_combinations_fk_1` FOREIGN KEY (`option_1_id`) REFERENCES `tbl_product_variant_label_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_product_variant_combinations_fk_2` FOREIGN KEY (`option_2_id`) REFERENCES `tbl_product_variant_label_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_product_variant_labels`
--
ALTER TABLE `tbl_product_variant_labels`
  ADD CONSTRAINT `tbl_product_variant_labels_fk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_product_variant_label_options`
--
ALTER TABLE `tbl_product_variant_label_options`
  ADD CONSTRAINT `tbl_product_variant_label_options_fk_1` FOREIGN KEY (`label_id`) REFERENCES `tbl_product_variant_labels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_reported_issues`
--
ALTER TABLE `tbl_reported_issues`
  ADD CONSTRAINT `tbl_reported_issues_fk_1` FOREIGN KEY (`retail_product_id`) REFERENCES `tbl_retail_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_reported_issues_fk_2` FOREIGN KEY (`issue_label_id`) REFERENCES `tbl_issue_labels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_reported_issues_fk_3` FOREIGN KEY (`request_id`) REFERENCES `tbl_transfer_requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_retail_products`
--
ALTER TABLE `tbl_retail_products`
  ADD CONSTRAINT `tbl_retail_products_fk_1` FOREIGN KEY (`variant_id`) REFERENCES `tbl_product_variant_combinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_retail_products_fk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_retail_products_fk_3` FOREIGN KEY (`store_id`) REFERENCES `tbl_retail_stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_serial_numbers`
--
ALTER TABLE `tbl_serial_numbers`
  ADD CONSTRAINT `tbl_serial_numbers_fk_1` FOREIGN KEY (`retail_product_id`) REFERENCES `tbl_retail_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_serial_number_issues`
--
ALTER TABLE `tbl_serial_number_issues`
  ADD CONSTRAINT `tbl_serial_number_issues_fk_1` FOREIGN KEY (`serial_number_id`) REFERENCES `tbl_serial_numbers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_serial_number_issues_fk_2` FOREIGN KEY (`issue_id`) REFERENCES `tbl_reported_issues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_transfer_requests`
--
ALTER TABLE `tbl_transfer_requests`
  ADD CONSTRAINT `tbl_transfer_requests_fk_1` FOREIGN KEY (`requesting_store_id`) REFERENCES `tbl_retail_stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transfer_requests_fk_2` FOREIGN KEY (`accepting_store_id`) REFERENCES `tbl_retail_stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_transfer_request_products`
--
ALTER TABLE `tbl_transfer_request_products`
  ADD CONSTRAINT `tbl_transfer_request_products_fk_1` FOREIGN KEY (`request_id`) REFERENCES `tbl_transfer_requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transfer_request_products_fk_2` FOREIGN KEY (`retail_product_id`) REFERENCES `tbl_retail_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
