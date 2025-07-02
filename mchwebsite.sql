-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 05:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mchwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`id`, `admin_name`, `admin_pass`) VALUES
(1, 'admin', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'pending, booked, cancelled, refunded',
  `trans_id` int(200) DEFAULT NULL,
  `trans_amount` int(11) NOT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `room_no` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `trans_id`, `trans_amount`, `datentime`, `room_no`) VALUES
(25, 2, 10, '2025-07-04', '2025-07-07', 0, NULL, 'booked', 0, 900, '2025-07-02 13:34:30', '101'),
(26, 2, 12, '2025-07-05', '2025-07-13', 0, NULL, 'booked', 0, 116536, '2025-07-02 13:43:29', '102'),
(27, 2, 12, '2025-07-02', '2025-07-05', 0, NULL, 'refunded', 0, 43701, '2025-07-02 13:44:24', NULL),
(28, 2, 10, '2025-07-10', '2025-07-12', 0, NULL, 'booked', 0, 600, '2025-07-02 13:49:34', '103'),
(29, 2, 10, '2025-07-04', '2025-07-05', 0, NULL, 'booked', 0, 300, '2025-07-02 13:51:06', '104'),
(30, 2, 10, '2025-07-04', '2025-07-06', 0, NULL, 'booked', 0, 600, '2025-07-02 13:53:40', '105'),
(31, 2, 10, '2025-07-04', '2025-07-05', 0, 0, 'cancelled', 0, 300, '2025-07-02 15:22:08', NULL),
(32, 2, 13, '2025-07-13', '2025-07-16', 0, NULL, 'pending', 0, 900, '2025-07-02 22:25:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `image`) VALUES
(2, 'IMG_64714.png'),
(3, 'IMG_59498.png'),
(4, 'IMG_83524.png'),
(6, 'IMG_89848.png'),
(7, 'IMG_48235.png'),
(8, 'IMG_49981.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint(20) NOT NULL,
  `pn2` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'Camp John Hay', 'https://maps.app.goo.gl/4HxMM4y6mCdzY9Ke8', 639205623654, 639205627013, 'mchhotel@gmail.com', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://www.twitter.com/', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d42816.25834275395!2d120.5935167!3d16.4171261!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a13655555555:0x9975ae781a94f70b!2sCamp John Hay!5e1!3m2!1sen!2sph!4v1749287011427!5m2!1sen!2sph');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(5, 'IMG_43382.svg', ' Spa', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.'),
(9, 'IMG_19269.svg', 'Wifi', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.'),
(12, 'IMG_88376.svg', 'Air Conditioner', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.'),
(13, 'IMG_25853.svg', 'TV', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.'),
(14, 'IMG_65788.svg', 'geyser', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.'),
(15, 'IMG_14175.svg', 'room heater', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(2, '2 rooms'),
(3, '1 bathroom'),
(4, '1 balcony'),
(5, '1 Bedroom'),
(6, '2 Single Beds'),
(7, '1 Queen Bed, 2 Single Beds');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(6, 'ghj', 2, 4, 54, 34, 46, 'xcgsf', 0, 1),
(7, 'xcv', 1, 3, 5, 2, 3, 'sdf', 1, 1),
(8, 'xcv', 245, 534, 65, 6, 13, 'dfgfdgdf', 0, 1),
(9, 'vbcvb', 3, 23, 3, 235, 35, 'dthjrjrg', 1, 1),
(10, 'Standard Rooms', 300, 300, 32, 6, 12, 'A well-appointed room designed for comfort and simplicity. It features a cozy double bed, modern bathroom, and essential amenities like air conditioning and free Wi-Fi. Ideal for solo travelers or couples looking for an affordable stay without compromising quality.', 1, 0),
(11, 'Luxury Suit', 700, 2000, 30, 19, 16, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Facere.', 1, 1),
(12, 'luxury suite', 608, 14567, 67, 34, 64, 'Upgrade your experience with this spacious and elegantly designed room. It includes a plush king-sized bed, stylish décor, and a private balcony (in selected units). Enjoy modern comforts like a mini-fridge, smart TV, and complimentary bottled water.', 1, 0),
(13, 'Family Suite', 400, 300, 20, 12, 14, 'Spacious and inviting, the Family Suite offers comfort for up to four guests. It includes a queen bed and two twin beds, a shared seating area, and plenty of room to relax. With entertainment options and ample space, it’s ideal for a stress-free family getaway.', 1, 0),
(14, 'Simple Room', 600, 70, 4, 4, 3, 'this is about our website Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Face', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`id`, `room_id`, `facilities_id`) VALUES
(25, 10, 5),
(26, 10, 9),
(27, 12, 5),
(28, 12, 9),
(29, 12, 13),
(30, 12, 15),
(35, 13, 5),
(36, 13, 9),
(37, 13, 12),
(38, 13, 13),
(39, 14, 9),
(40, 14, 13),
(41, 14, 15);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`id`, `room_id`, `features_id`) VALUES
(16, 10, 3),
(17, 10, 4),
(18, 12, 4),
(19, 12, 6),
(23, 13, 4),
(24, 13, 6),
(25, 14, 2),
(26, 14, 3),
(27, 14, 6);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`id`, `room_id`, `image`, `thumb`) VALUES
(3, 10, 'IMG_83229.jpg', 0),
(4, 10, 'IMG_53275.png', 1),
(5, 10, 'IMG_74174.png', 0),
(6, 10, 'IMG_40481.png', 0),
(9, 10, 'IMG_93173.png', 0),
(10, 10, 'IMG_64503.png', 0),
(12, 13, 'IMG_31941.png', 1),
(14, 12, 'IMG_11202.png', 0),
(15, 12, 'IMG_90152.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_no`
--

CREATE TABLE `room_no` (
  `id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `room_type` enum('Standard','Deluxe','Suite','Presidential') NOT NULL,
  `status` enum('Available','Occupied','Unavailable') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_no`
--

INSERT INTO `room_no` (`id`, `room_number`, `room_type`, `status`) VALUES
(1, 101, 'Standard', 'Occupied'),
(2, 102, 'Standard', 'Occupied'),
(3, 103, 'Standard', 'Occupied'),
(4, 104, 'Standard', 'Occupied'),
(5, 105, 'Standard', 'Available'),
(6, 106, 'Standard', 'Available'),
(7, 107, 'Standard', 'Available'),
(8, 108, 'Standard', 'Available'),
(9, 109, 'Standard', 'Available'),
(10, 110, 'Standard', 'Available'),
(11, 111, 'Standard', 'Available'),
(12, 112, 'Standard', 'Available'),
(13, 113, 'Standard', 'Available'),
(14, 114, 'Standard', 'Available'),
(15, 115, 'Standard', 'Available'),
(16, 116, 'Standard', 'Available'),
(17, 117, 'Standard', 'Available'),
(18, 118, 'Standard', 'Available'),
(19, 119, 'Standard', 'Available'),
(20, 120, 'Standard', 'Available'),
(21, 121, 'Standard', 'Available'),
(22, 122, 'Standard', 'Available'),
(23, 123, 'Standard', 'Available'),
(24, 124, 'Standard', 'Available'),
(25, 125, 'Standard', 'Available'),
(26, 126, 'Standard', 'Available'),
(27, 127, 'Standard', 'Available'),
(28, 128, 'Standard', 'Available'),
(29, 129, 'Standard', 'Available'),
(30, 130, 'Standard', 'Available'),
(31, 131, 'Standard', 'Available'),
(32, 132, 'Standard', 'Available'),
(33, 133, 'Standard', 'Available'),
(34, 134, 'Standard', 'Available'),
(35, 135, 'Standard', 'Available'),
(36, 136, 'Standard', 'Available'),
(37, 137, 'Standard', 'Available'),
(38, 138, 'Standard', 'Available'),
(39, 139, 'Standard', 'Available'),
(40, 140, 'Standard', 'Available'),
(41, 141, 'Standard', 'Available'),
(42, 142, 'Standard', 'Available'),
(43, 143, 'Standard', 'Available'),
(44, 144, 'Standard', 'Available'),
(45, 145, 'Standard', 'Available'),
(46, 146, 'Standard', 'Available'),
(47, 147, 'Standard', 'Available'),
(48, 148, 'Standard', 'Available'),
(49, 149, 'Standard', 'Available'),
(50, 150, 'Standard', 'Available'),
(51, 151, 'Standard', 'Available'),
(52, 152, 'Standard', 'Available'),
(53, 153, 'Standard', 'Available'),
(54, 154, 'Standard', 'Available'),
(55, 155, 'Standard', 'Available'),
(56, 156, 'Standard', 'Available'),
(57, 157, 'Standard', 'Available'),
(58, 158, 'Standard', 'Available'),
(59, 159, 'Standard', 'Available'),
(60, 160, 'Standard', 'Available'),
(61, 161, 'Deluxe', 'Available'),
(62, 162, 'Deluxe', 'Available'),
(63, 163, 'Deluxe', 'Available'),
(64, 164, 'Deluxe', 'Available'),
(65, 165, 'Deluxe', 'Available'),
(66, 166, 'Deluxe', 'Available'),
(67, 167, 'Deluxe', 'Available'),
(68, 168, 'Deluxe', 'Available'),
(69, 169, 'Deluxe', 'Available'),
(70, 170, 'Deluxe', 'Available'),
(71, 171, 'Deluxe', 'Available'),
(72, 172, 'Deluxe', 'Available'),
(73, 173, 'Deluxe', 'Available'),
(74, 174, 'Deluxe', 'Available'),
(75, 175, 'Deluxe', 'Available'),
(76, 176, 'Deluxe', 'Available'),
(77, 177, 'Deluxe', 'Available'),
(78, 178, 'Deluxe', 'Available'),
(79, 179, 'Deluxe', 'Available'),
(80, 180, 'Deluxe', 'Available'),
(81, 181, 'Deluxe', 'Available'),
(82, 182, 'Deluxe', 'Available'),
(83, 183, 'Deluxe', 'Available'),
(84, 184, 'Deluxe', 'Available'),
(85, 185, 'Deluxe', 'Available'),
(86, 186, 'Deluxe', 'Available'),
(87, 187, 'Deluxe', 'Available'),
(88, 188, 'Deluxe', 'Available'),
(89, 189, 'Deluxe', 'Available'),
(90, 190, 'Deluxe', 'Available'),
(91, 191, 'Deluxe', 'Available'),
(92, 192, 'Deluxe', 'Available'),
(93, 193, 'Deluxe', 'Available'),
(94, 194, 'Deluxe', 'Available'),
(95, 195, 'Deluxe', 'Available'),
(96, 196, 'Deluxe', 'Available'),
(97, 197, 'Deluxe', 'Available'),
(98, 198, 'Deluxe', 'Available'),
(99, 199, 'Deluxe', 'Available'),
(100, 200, 'Deluxe', 'Available'),
(101, 201, 'Deluxe', 'Available'),
(102, 202, 'Deluxe', 'Available'),
(103, 203, 'Deluxe', 'Available'),
(104, 204, 'Deluxe', 'Available'),
(105, 205, 'Deluxe', 'Available'),
(106, 206, 'Deluxe', 'Available'),
(107, 207, 'Deluxe', 'Available'),
(108, 208, 'Deluxe', 'Available'),
(109, 209, 'Deluxe', 'Available'),
(110, 210, 'Deluxe', 'Available'),
(111, 211, 'Deluxe', 'Available'),
(112, 212, 'Deluxe', 'Available'),
(113, 213, 'Deluxe', 'Available'),
(114, 214, 'Deluxe', 'Available'),
(115, 215, 'Deluxe', 'Available'),
(116, 216, 'Deluxe', 'Available'),
(117, 217, 'Deluxe', 'Available'),
(118, 218, 'Deluxe', 'Available'),
(119, 219, 'Deluxe', 'Available'),
(120, 220, 'Deluxe', 'Available'),
(121, 221, 'Suite', 'Available'),
(122, 222, 'Suite', 'Available'),
(123, 223, 'Suite', 'Available'),
(124, 224, 'Suite', 'Available'),
(125, 225, 'Suite', 'Available'),
(126, 226, 'Suite', 'Available'),
(127, 227, 'Suite', 'Available'),
(128, 228, 'Suite', 'Available'),
(129, 229, 'Suite', 'Available'),
(130, 230, 'Suite', 'Available'),
(131, 231, 'Suite', 'Available'),
(132, 232, 'Suite', 'Available'),
(133, 233, 'Suite', 'Available'),
(134, 234, 'Suite', 'Available'),
(135, 235, 'Suite', 'Available'),
(136, 236, 'Suite', 'Available'),
(137, 237, 'Suite', 'Available'),
(138, 238, 'Suite', 'Available'),
(139, 239, 'Suite', 'Available'),
(140, 240, 'Suite', 'Available'),
(141, 241, 'Suite', 'Available'),
(142, 242, 'Suite', 'Available'),
(143, 243, 'Suite', 'Available'),
(144, 244, 'Suite', 'Available'),
(145, 245, 'Suite', 'Available'),
(146, 246, 'Suite', 'Available'),
(147, 247, 'Suite', 'Available'),
(148, 248, 'Suite', 'Available'),
(149, 249, 'Suite', 'Available'),
(150, 250, 'Suite', 'Available'),
(151, 251, 'Suite', 'Available'),
(152, 252, 'Suite', 'Available'),
(153, 253, 'Suite', 'Available'),
(154, 254, 'Suite', 'Available'),
(155, 255, 'Suite', 'Available'),
(156, 256, 'Suite', 'Available'),
(157, 257, 'Suite', 'Available'),
(158, 258, 'Suite', 'Available'),
(159, 259, 'Suite', 'Available'),
(160, 260, 'Suite', 'Available'),
(161, 261, 'Suite', 'Available'),
(162, 262, 'Suite', 'Available'),
(163, 263, 'Suite', 'Available'),
(164, 264, 'Suite', 'Available'),
(165, 265, 'Suite', 'Available'),
(166, 266, 'Suite', 'Available'),
(167, 267, 'Suite', 'Available'),
(168, 268, 'Suite', 'Available'),
(169, 269, 'Suite', 'Available'),
(170, 270, 'Suite', 'Available'),
(171, 271, 'Suite', 'Available'),
(172, 272, 'Suite', 'Available'),
(173, 273, 'Suite', 'Available'),
(174, 274, 'Suite', 'Available'),
(175, 275, 'Suite', 'Available'),
(176, 276, 'Suite', 'Available'),
(177, 277, 'Suite', 'Available'),
(178, 278, 'Suite', 'Available'),
(179, 279, 'Suite', 'Available'),
(180, 280, 'Suite', 'Available'),
(181, 281, 'Presidential', 'Available'),
(182, 282, 'Presidential', 'Available'),
(183, 283, 'Presidential', 'Available'),
(184, 284, 'Presidential', 'Available'),
(185, 285, 'Presidential', 'Available'),
(186, 286, 'Presidential', 'Available'),
(187, 287, 'Presidential', 'Available'),
(188, 288, 'Presidential', 'Available'),
(189, 289, 'Presidential', 'Available'),
(190, 290, 'Presidential', 'Available'),
(191, 291, 'Presidential', 'Available'),
(192, 292, 'Presidential', 'Available'),
(193, 293, 'Presidential', 'Available'),
(194, 294, 'Presidential', 'Available'),
(195, 295, 'Presidential', 'Available'),
(196, 296, 'Presidential', 'Available'),
(197, 297, 'Presidential', 'Available'),
(198, 298, 'Presidential', 'Available'),
(199, 299, 'Presidential', 'Available'),
(200, 300, 'Presidential', 'Available'),
(201, 301, 'Presidential', 'Available'),
(202, 302, 'Presidential', 'Available'),
(203, 303, 'Presidential', 'Available'),
(204, 304, 'Presidential', 'Available'),
(205, 305, 'Presidential', 'Available'),
(206, 306, 'Presidential', 'Available'),
(207, 307, 'Presidential', 'Available'),
(208, 308, 'Presidential', 'Available'),
(209, 309, 'Presidential', 'Available'),
(210, 310, 'Presidential', 'Available'),
(211, 311, 'Presidential', 'Available'),
(212, 312, 'Presidential', 'Available'),
(213, 313, 'Presidential', 'Available'),
(214, 314, 'Presidential', 'Available'),
(215, 315, 'Presidential', 'Available'),
(216, 316, 'Presidential', 'Available'),
(217, 317, 'Presidential', 'Available'),
(218, 318, 'Presidential', 'Available'),
(219, 319, 'Presidential', 'Available'),
(220, 320, 'Presidential', 'Available'),
(221, 321, 'Presidential', 'Available'),
(222, 322, 'Presidential', 'Available'),
(223, 323, 'Presidential', 'Available'),
(224, 324, 'Presidential', 'Available'),
(225, 325, 'Presidential', 'Available'),
(226, 326, 'Presidential', 'Available'),
(227, 327, 'Presidential', 'Available'),
(228, 328, 'Presidential', 'Available'),
(229, 329, 'Presidential', 'Available'),
(230, 330, 'Presidential', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'MCH HOTEL', 'this is about our website Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit perspiciatis sed vero beatae corrupti quas, veritatis ullam repellat distinctio quos aliquam nisi adipisci delectus obcaecati, quidem eligendi, neque quam! Face', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`id`, `name`, `picture`) VALUES
(6, 'Terry', 'IMG_20895.jpg'),
(7, 'Sophia', 'IMG_66070.jpg'),
(8, 'Dianne', 'IMG_84805.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(130) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(120) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `status`, `datentime`) VALUES
(2, 'alice', 'sdx@gmail.com', 'Camp John Hay', '09205623654', 2564, '2004-03-20', 'IMG_72037.jpeg', '$2y$10$eDNj26FW433zPqbMiSOw9O.b2ZR6sa0uE3uVYylMKtdqjCxjK7GNq', 1, '2025-06-25 13:32:32'),
(10, 'Rasul', 'pundogarraz@gmail.com', 'Camp John Hay', '09387569219', 1234, '2020-01-07', 'IMG_84883.jpeg', '$2y$10$lrVS1snuM92iq3ks5zAZk.IxPKBCzuXiWVFP9IwKhNUVAlOQnCbku', 1, '2025-06-30 14:48:59'),
(11, 'anne', 'anne@gmail.com', 'Paris, Italy', '09387569232', 3145, '1998-05-21', 'IMG_41774.jpeg', '$2y$10$Sf8zhlSUKQUVJ4yLTjJ1oOjsHAGMj9xbWT6ywt1ZU9nZVr2a/KQ1K', 1, '2025-07-02 23:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`id`, `name`, `email`, `subject`, `message`, `date`, `seen`) VALUES
(6, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(7, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(8, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(9, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(10, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(11, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(12, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 0),
(13, 'cfvbgrg', 'cvbd@fmfm.cmm', 'fhjryhxf', 'urthfxghxrth', '2025-06-22', 1),
(15, 'test', 'pundogarraz@gmail.com', 'test', 'test booking', '2025-06-30', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room id` (`room_id`),
  ADD KEY `facilities id` (`facilities_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms id` (`room_id`),
  ADD KEY `features id` (`features_id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `room_no`
--
ALTER TABLE `room_no`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `room_no`
--
ALTER TABLE `room_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rooms id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
