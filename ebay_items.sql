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

CREATE TABLE `content` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(20) NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(20) NOT NULL DEFAULT 0,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_catid` (`catid`);

ALTER TABLE `content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
