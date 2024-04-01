-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 11:05 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmovies`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `seat_num` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `paid` varchar(150) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingid`, `id`, `movie_id`, `show_date`, `show_time`, `seat_num`, `total_price`, `booking_date`, `booking_time`, `user_id`, `paid`, `image_path`, `status`) VALUES
(2, 0, 6, '2024-02-27', '02:45:00', 35, 0, '2024-02-27', '09:04:35', 7, '', '', 'Approved'),
(3, 0, 6, '2024-02-27', '02:45:00', 22, 0, '2024-02-27', '09:09:07', 7, '', '', 'Pending'),
(4, 0, 6, '2024-02-27', '02:45:00', 33, 0, '2024-02-27', '09:12:26', 7, '', '', 'Pending'),
(5, 0, 6, '2024-02-27', '02:45:00', 34, 0, '2024-02-27', '09:12:26', 7, '', '', 'Pending'),
(6, 0, 6, '2024-02-27', '00:00:02', 31, 0, '2024-02-27', '09:18:37', 7, '', '', 'Pending'),
(7, 0, 6, '2024-02-27', '00:00:02', 32, 0, '2024-02-27', '09:18:37', 7, '', '', 'Pending'),
(8, 0, 2, '2023-07-21', '00:00:15', 34, 0, '2024-02-27', '10:45:12', 7, '', '', 'Pending'),
(9, 0, 2, '2023-07-21', '00:00:15', 35, 0, '2024-02-27', '10:45:12', 7, '', '', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catid` int(11) NOT NULL,
  `catname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catid`, `catname`) VALUES
(1, 'Hollywood'),
(2, 'Bollywood');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `classid` int(11) NOT NULL,
  `classname` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movieid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `releasedate` date NOT NULL,
  `image` varchar(1000) NOT NULL,
  `trailer` varchar(1000) NOT NULL,
  `movie` varchar(10000) NOT NULL,
  `rating` varchar(50) NOT NULL,
  `catid` int(11) NOT NULL,
  `first_date` date NOT NULL DEFAULT '1970-01-01',
  `second_date` date NOT NULL DEFAULT '1970-01-01',
  `third_date` date NOT NULL DEFAULT '1970-01-01',
  `first_show` time NOT NULL DEFAULT '00:00:00',
  `second_show` time NOT NULL DEFAULT '00:00:00',
  `third_show` time NOT NULL DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movieid`, `title`, `description`, `releasedate`, `image`, `trailer`, `movie`, `rating`, `catid`, `first_date`, `second_date`, `third_date`, `first_show`, `second_show`, `third_show`) VALUES
(2, 'ABC Bollywood Movie', 'abc movie desciption', '2023-07-20', 'download (1).jpeg', 'mov_bbb.mp4', 'mov_bbb.mp4', '', 2, '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00'),
(3, 'XYZ Bollywood movie', 'XYZ Bollywood movie', '2023-07-27', 'ghayal-once-again-movie-poster-3.jpg', 'smart phone mode.mp4', 'smart phone mode.mp4', '', 2, '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00'),
(4, 'tear of the sun', 'tear of the sun', '2023-07-27', 'download.jpeg', 'mov_bbb.mp4', 'mov_bbb.mp4', '', 1, '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00'),
(5, 'The Foreigner', 'Foreigner the chapter', '2023-07-06', 'desktop-wallpaper-hollywood-gun-action-movies-poster-hollywood-poster.jpg', 'mov_bbb.mp4', 'mov_bbb.mp4', '', 1, '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00'),
(6, 'Ant man', 'antman', '2024-02-27', 'antman.jpg', 'mov_bbb.mp4', 'smart phone mode.mp4', '', 1, '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `theaterid` int(11) NOT NULL,
  `theater_name` varchar(100) NOT NULL,
  `timing` varchar(50) NOT NULL,
  `days` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `price` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `movieid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`theaterid`, `theater_name`, `timing`, `days`, `date`, `price`, `location`, `movieid`) VALUES
(1, 'Royal Theater', '14:00', 'Monday', '2023-07-18', 1500, 'Gulshan Karachi', 5),
(2, 'Prince Theater', '15:30', 'Thursday', '2023-07-21', 3000, 'Malir Karachi', 2),
(3, 'Nepali', '02:45', 'monday', '2024-02-27', 500, 'bkt', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `roteype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `email`, `password`, `roteype`) VALUES
(1, 'admin', 'admin@gmail.com', '123', 1),
(2, 'Usman', 'usman@gmail.com', '321', 2),
(3, 'Muhammad Aqib', 'maqib1055@gmail.com', '123', 2),
(4, 'saqib', 'saqib@gmail.com', '123', 2),
(5, 'newuser', 'newuser@gmail.com', '123', 2),
(6, 'anas', 'anas@gmail.com', '123', 2),
(7, 'yasir', 'yasir@gmail.com', '123', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movieid`),
  ADD KEY `FK_movies` (`catid`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`theaterid`),
  ADD KEY `FK_theater` (`movieid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `theaterid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `FK_movies` FOREIGN KEY (`catid`) REFERENCES `categories` (`catid`);

--
-- Constraints for table `theater`
--
ALTER TABLE `theater`
  ADD CONSTRAINT `FK_theater` FOREIGN KEY (`movieid`) REFERENCES `movies` (`movieid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
