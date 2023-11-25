-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2023 at 01:21 PM
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
-- Database: `be20_cr5_animal_adoption_schnurer`
--
CREATE DATABASE IF NOT EXISTS `be20_cr5_animal_adoption_schnurer` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be20_cr5_animal_adoption_schnurer`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Available',
  `vaccinated` varchar(50) NOT NULL DEFAULT 'no',
  `name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `size` int(10) NOT NULL,
  `age` int(10) NOT NULL,
  `breed` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `status`, `vaccinated`, `name`, `address`, `size`, `age`, `breed`, `description`, `picture`) VALUES
(1, 'Available', 'yes', 'Furry1', 'city1 street1', 25, 5, 'Dog', 'crazy and aggressive', 'default.png'),
(2, 'Available', 'no', 'Furry2', 'city2 street2', 30, 4, 'Cat', 'scratches everything', 'default.png'),
(3, 'Available', 'yes', 'Furry3', 'city3 street3', 125, 5, 'Horse', 'tramples', 'default.png'),
(4, 'Available', 'yes', 'Furry4', 'city4 street4', 23, 50, 'Squirrel', 'fast', 'default.png'),
(5, 'Available', 'yes', 'Furry5', 'city1 street5', 35, 25, 'Spider', 'poisonous', 'default.png'),
(6, 'Available', 'yes', 'Furry6', 'city3 street5', 45, 9, 'Sheep', 'relaxed', 'default.png'),
(7, 'Available', 'yes', 'Furry7', 'city9 street7', 155, 11, 'Bison', 'majestic', 'default.png'),
(8, 'Available', 'no', 'Furry8', 'city10 street1', 35, 34, 'Snake', 'wiggles', 'default.png'),
(9, 'Available', 'yes', 'Furry9', 'city6 street11', 65, 55, 'Grasshopper', 'crazy and aggressive', 'default.png'),
(10, 'Available', 'yes', 'Furry10', 'city88 street23', 75, 65, 'Bird', 'vertigo', 'default.png'),
(11, 'Available', 'yes', 'Furry11', 'city22 street12', 85, 2, 'Dog', 'lazy', 'default.png'),
(12, 'Available', 'yes', 'Furry12', 'city5 street8', 95, 3, 'Cat', 'vindictive', 'default.png'),
(13, 'Available', 'no', 'Furry13', 'city9 street11', 5, 8, 'Sheep', 'adventureous', 'default.png'),
(14, 'Available', 'yes', 'Furry14', 'city10 street15', 15, 7, 'Snake', 'smart', 'default.png'),
(15, 'Available', 'yes', 'Furry15', 'city43 street22', 75, 4, 'Spider', 'lonley', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `adoption_date` date NOT NULL,
  `fk_userid` int(11) NOT NULL,
  `fk_animalid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'user',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `status`, `first_name`, `last_name`, `phone_number`, `address`, `picture`) VALUES
(1, 'admin@admin.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'adm', 'Very', 'Important', '0676123456', 'City Street', 'avatar.png'),
(2, 'furry@furry.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user', 'Furry', 'Furrington', '0676123456', 'City Street2', 'avatar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userid` (`fk_userid`),
  ADD KEY `fk_animalid` (`fk_animalid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`fk_animalid`) REFERENCES `animals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
