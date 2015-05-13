-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 22, 2015 at 08:44 PM
-- Server version: 5.6.23
-- PHP Version: 5.5.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nsumedia2`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(4) NOT NULL,
  `make` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `hardcase` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(5) NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `createdate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `make`, `model`, `hardcase`, `status`, `notes`, `tags`, `category`, `description`, `createdate`) VALUES
(1, 'Canon', '100D and 18-55mm Lens', 'Y', 'In Stock', NULL, 'DSLR, Canon, Camera', 2, 'DSLR camera with zoom - Photo & Video', '2015-03-04'),
(2, 'Canon', '100D and 18-55mm Lens', 'Y', 'In Stock', NULL, 'DSLR, Canon, Camera', 2, 'DSLR camera with zoom - Photo & Video', '2015-03-04'),
(3, 'Panasonic', 'Lumix DMC-FZ38', 'Y', 'In Stock', NULL, 'Lumix, Hybrid, Bridge', 2, 'Bridge camera - Photo & Video', '2015-03-04'),
(4, 'Panasonic', 'Lumix DMC-FZ38', 'Y', 'In Stock', NULL, 'Lumix, Hybrid, Bridge', 2, 'Bridge camera - Photo & Video', '2015-03-04'),
(5, 'Kodak', 'Zx1 HD', 'Y', 'In Stock', NULL, 'Kodak, Handheld, 60fps, showerproof', 3, 'HD Handheld video camera', '2015-03-04'),
(6, 'Qumox', 'SJ4000 and Waterproof Cover', 'N', 'In Stock', NULL, 'GoPro, Action cam, video, waterproof', 3, 'BLUE - HD Action camera', '2015-03-04'),
(7, 'Qumox', 'SJ4000 and Waterproof Cover', 'N', 'In Stock', NULL, 'GoPro, Action cam, video, waterproof', 3, 'BLUE - HD Action camera', '2015-03-04'),
(8, 'Qumox', 'SJ4000 and Waterproof Cover', 'N', 'In Stock', NULL, 'GoPro, Action cam, video, waterproof', 3, 'SILVER - HD Action camera', '2015-03-04'),
(9, 'Qumox', 'SJ4000 and Waterproof Cover', 'N', 'In Stock', NULL, 'GoPro, Action cam, video, waterproof', 3, 'SILVER - HD Action camera', '2015-03-04'),
(10, 'Canon', 'Legria HFR180', 'N', 'In Stock', NULL, 'AV Cam, Handheld, video', 3, 'BLACK - AVHD CMOS 20x Optical Zoon', '2015-03-04'),
(11, 'Canon', 'Legria HFR200', 'N', 'In Stock', NULL, 'AV Cam, Handheld, video', 3, 'BLACK - AVHD CMOS 15x Optical Zoon', '2015-03-04'),
(12, 'Canon', 'Legria FS306', 'N', 'In Stock', NULL, 'AV Cam, Handheld, video', 3, 'SILVER - AV Cam 200x Digital Zoom', '2015-03-04'),
(13, 'Canon', 'XA10 HD and Audio Kit', 'N', 'In Stock', NULL, 'Video Camera, Audio Camera, Live Stream', 3, 'AVHD Camera with full audio control // 64GB Built in', '2015-03-04'),
(14, 'Canon', 'XA10 HD and Audio Kit', 'N', 'In Stock', NULL, 'Video Camera, Audio Camera, Live Stream', 3, 'AVHD Camera with full audio control // 64GB Built in', '2015-03-04'),
(15, 'Neewer', 'TT520 Speedlite GN33', 'Y', 'In Stock', NULL, 'Camera Flash Gun, Acessories', 4, 'Camera Flash Gun with difuser', '2015-03-04'),
(16, 'Neewer', 'TT520 Speedlite GN33', 'Y', 'In Stock', NULL, 'Camera Flash Gun, Acessories', 4, 'Camera Flash Gun with difuser', '2015-03-04'),
(17, 'Neewer', 'CN-76 LED Video Lighting', 'N', 'In Stock', NULL, 'Video Lighting, Accessories', 4, 'Battery LED Light  w/ Diffuser box & Temp Gels - Hotshoe ', '2015-03-04'),
(18, 'Neewer', 'CN-76 LED Video Lighting', 'N', 'In Stock', NULL, 'Video Lighting, Accessories', 4, 'Battery LED Light  w/ Diffuser box & Temp Gels - Hotshoe ', '2015-03-04'),
(19, 'Tascam', 'DR-05 PCM Recorder', 'N', 'In Stock', NULL, 'Audio, field recorder', 1, 'Handheld stereo feild recorder', '2015-03-04'),
(20, 'Ravelli', 'APLT4 Tripod', 'N', 'In Stock', NULL, 'Tripod, mount', 5, 'Camera/Video Tripod', '2015-03-04'),
(21, 'Ravelli', 'APLT4 Tripod', 'N', 'In Stock', NULL, 'Tripod, mount', 5, 'Camera/Video Tripod', '2015-03-04'),
(22, 'Bolum', 'WR-601 Wireless Mic Kit', 'N', 'In Stock', NULL, 'Wireless Audio, mic, sound', 1, 'Wireless Mic kit w/ clip on mic', '2015-03-04'),
(23, 'Bolum', 'WR-601 Wireless Mic Kit', 'N', 'In Stock', NULL, 'Wireless Audio, mic, sound', 1, 'Wireless Mic kit w/ clip on mic', '2015-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `assettotag`
--

CREATE TABLE IF NOT EXISTS `assettotag` (
  `ID` int(3) NOT NULL,
  `tagID` int(3) NOT NULL,
  `assetID` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assettotag`
--

INSERT INTO `assettotag` (`ID`, `tagID`, `assetID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 1, 2),
(5, 2, 2),
(6, 3, 2),
(7, 4, 3),
(8, 5, 3),
(9, 6, 3),
(10, 4, 4),
(11, 5, 4),
(12, 6, 4),
(13, 7, 5),
(14, 8, 5),
(15, 9, 5),
(16, 10, 5),
(17, 11, 6),
(18, 12, 6),
(19, 13, 6),
(20, 14, 6),
(21, 11, 7),
(22, 12, 7),
(23, 13, 7),
(24, 14, 7),
(25, 11, 8),
(26, 12, 8),
(27, 13, 8),
(28, 14, 8),
(29, 11, 9),
(30, 12, 9),
(31, 13, 9),
(32, 14, 9),
(33, 15, 10),
(34, 8, 10),
(35, 13, 10),
(36, 15, 11),
(37, 8, 11),
(38, 13, 11),
(39, 15, 12),
(40, 8, 12),
(41, 13, 12),
(42, 16, 13),
(43, 17, 13),
(44, 18, 13),
(45, 16, 14),
(46, 17, 14),
(47, 18, 14),
(48, 19, 15),
(49, 20, 15),
(50, 19, 16),
(51, 20, 16),
(52, 21, 17),
(53, 20, 17),
(54, 21, 18),
(55, 20, 18),
(56, 22, 19),
(57, 23, 19),
(58, 24, 20),
(59, 25, 20),
(60, 24, 21),
(61, 25, 21),
(62, 26, 22),
(63, 27, 22),
(64, 28, 22),
(65, 26, 23),
(66, 27, 23),
(67, 28, 23);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(5) NOT NULL,
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Audio'),
(2, 'Camera'),
(3, 'Video Camera'),
(4, 'Lighting'),
(5, 'Mounts');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `loanNumber` int(10) NOT NULL,
  `count` int(3) NOT NULL,
  `plannedStart` date NOT NULL,
  `plannedEnd` date NOT NULL,
  `UID` int(5) NOT NULL,
  `overdue` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `damaged` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approver` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actualStart` date DEFAULT NULL,
  `actualEnd` date DEFAULT NULL,
  `notes` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loanNumber`, `count`, `plannedStart`, `plannedEnd`, `UID`, `overdue`, `damaged`, `approved`, `approver`, `actualStart`, `actualEnd`, `notes`) VALUES
(1, 1, '2015-03-12', '2015-03-16', 2, NULL, '', 'Y', '2', '2015-04-16', '2015-04-16', ' '),
(2, 1, '2015-02-15', '2015-02-18', 2, NULL, '', 'Y', '2', '2015-04-16', '2015-04-16', ' '),
(3, 1, '2015-02-15', '2015-02-18', 2, NULL, '', 'Y', '2', '2015-04-16', '2015-04-16', ' '),
(4, 3, '0100-04-29', '0100-04-30', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 4, '0100-04-29', '0100-04-30', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 4, '0100-05-03', '0100-05-05', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 4, '0100-05-03', '0100-05-05', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loantoasset`
--

CREATE TABLE IF NOT EXISTS `loantoasset` (
  `id` int(6) NOT NULL,
  `loanNumber` int(10) DEFAULT NULL,
  `barcode` int(128) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loantoasset`
--

INSERT INTO `loantoasset` (`id`, `loanNumber`, `barcode`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 4, 2),
(6, 5, 1),
(7, 5, 2),
(8, 6, 1),
(9, 6, 2),
(10, 7, 1),
(11, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `barcode` int(128) NOT NULL,
  `original` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `normalised` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `phonetic` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tagID` int(3) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagID`, `tag`) VALUES
(1, 'DSLR'),
(2, 'Canon'),
(3, 'Camera'),
(4, 'Lumix'),
(5, 'Hybrid'),
(6, 'Bridge'),
(7, 'Kodak'),
(8, 'Handheld'),
(9, '60fps'),
(10, 'Showerproof'),
(11, 'GoPro'),
(12, 'Action cam'),
(13, 'Video'),
(14, 'Waterproof'),
(15, 'AV cam'),
(16, 'Video Camera'),
(17, 'Audio Camera'),
(18, 'Live Stream'),
(19, 'Camera Flash Gun'),
(20, 'Accessories'),
(21, 'Video Lighting'),
(22, 'Audio'),
(23, 'Field Recorder'),
(24, 'Tripod'),
(25, 'Mount'),
(26, 'Wireless Audio'),
(27, 'Mic'),
(28, 'Sound');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UID` int(5) NOT NULL,
  `username` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `token` char(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UID`, `username`, `firstname`, `surname`, `email`, `password`, `access`, `token`) VALUES
(1, 'marcusr', 'Marcus', 'Rowland', 'marcus.rowland@northumbria.ac.uk', '$2y$10$uK2ZOBpl9RKw8lT9CV0Yn.gO0Ciu9Ubn7oWRjL41tYTLqnQAO6.oO', 'S', ''),
(2, 'admin', 'Admin', 'User', 'admin@test.com', '$2y$10$eg/0hHid.HW3KAJraMnN3.Stm4gIEg2hqXUgGSajbQvmc0kRqe9U2', 'A', ''),
(15, 'contrib', 'Contributor', 'Tester', 'contrib@test.com', '$2y$10$s6GFq8iiRd11ak0uLO2Bou9cGVxzcjgCX5xuibBTEPsLA/Opec25C', 'C', NULL),
(16, 'enduser', 'User', 'End', 'enduser@test.com', '$2y$10$Hzpqwa31XZMTJhyJ2.AJh.W/e9Dc9icaazxhVaReOwkYnLVqoGnpK', 'U', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`), ADD KEY `category` (`category`), ADD FULLTEXT KEY `make` (`make`,`model`,`description`,`tags`);

--
-- Indexes for table `assettotag`
--
ALTER TABLE `assettotag`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loanNumber`), ADD KEY `UID` (`UID`), ADD KEY `barcode` (`count`);

--
-- Indexes for table `loantoasset`
--
ALTER TABLE `loantoasset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`barcode`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`), ADD KEY `username` (`username`,`firstname`,`surname`), ADD FULLTEXT KEY `username_2` (`username`), ADD FULLTEXT KEY `username_3` (`username`), ADD FULLTEXT KEY `firstname` (`firstname`), ADD FULLTEXT KEY `surname` (`surname`), ADD FULLTEXT KEY `username_4` (`username`), ADD FULLTEXT KEY `search_index` (`firstname`,`surname`,`username`), ADD FULLTEXT KEY `firstname_2` (`firstname`,`surname`,`username`), ADD FULLTEXT KEY `firstname_3` (`firstname`,`surname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `assettotag`
--
ALTER TABLE `assettotag`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loanNumber` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `loantoasset`
--
ALTER TABLE `loantoasset`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tagID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
