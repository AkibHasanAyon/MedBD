-- MedBD v2 Migration
-- Adds: tbl_customer, tbl_cart, tbl_wishlist, tbl_review
-- Alters: tbl_order, tbl_product

-- --------------------------------------------------------
-- Table structure for table `tbl_customer`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT '',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for table `tbl_cart`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for table `tbl_wishlist`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tbl_wishlist` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_wishlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for table `tbl_review`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tbl_review` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review_text` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `tbl_review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_review_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Alter tbl_order: add customer_id, payment_method, payment_status, prescription_image
-- --------------------------------------------------------

ALTER TABLE `tbl_order`
  ADD COLUMN IF NOT EXISTS `customer_id` int(10) UNSIGNED DEFAULT NULL AFTER `id`,
  ADD COLUMN IF NOT EXISTS `payment_method` varchar(50) DEFAULT 'Cash on Delivery' AFTER `status`,
  ADD COLUMN IF NOT EXISTS `payment_status` varchar(50) DEFAULT 'Pending' AFTER `payment_method`,
  ADD COLUMN IF NOT EXISTS `prescription_image` varchar(255) DEFAULT '' AFTER `payment_status`;

-- --------------------------------------------------------
-- Alter tbl_product: add requires_prescription
-- --------------------------------------------------------

ALTER TABLE `tbl_product`
  ADD COLUMN IF NOT EXISTS `requires_prescription` varchar(10) DEFAULT 'No' AFTER `active`;
