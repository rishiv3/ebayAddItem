SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
--
-- Table structure for table `ebay_items`
--

CREATE TABLE IF NOT EXISTS `ebay_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_keyword` varchar(100) NOT NULL,
  `itemID` varchar(100) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `condition` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `startprice` int(20) NOT NULL,
  `listingtype` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `listingDuration` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

ALTER TABLE `ebay_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ebay_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

-- add more sql example
