-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 06:30 AM
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
-- Database: `be22_exam5_animal_adoption_mahran`
--
CREATE DATABASE IF NOT EXISTS `be22_exam5_animal_adoption_mahran` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be22_exam5_animal_adoption_mahran`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `pet_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `size` enum('small','medium','large') DEFAULT 'medium',
  `age` int(11) NOT NULL,
  `vaccine` enum('vaccinated','not vaccinated') DEFAULT 'not vaccinated',
  `breed` varchar(255) NOT NULL,
  `status` enum('adopted','available') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`pet_id`, `name`, `photo`, `location`, `description`, `size`, `age`, `vaccine`, `breed`, `status`) VALUES
(14, 'simba', 'dog.jpg', 'wien', 'King of the jungle', 'large', 28, 'not vaccinated', 'lion', 'available'),
(15, 'Buddy', '66ad292a0c5dc.webp', 'wien', 'siamie', 'small', 12, 'vaccinated', 'cat', 'available'),
(16, 'Nemo', '66ad2971b808c.jpeg', 'wien', 'stinky', 'medium', 55, 'not vaccinated', 'fish', 'available'),
(17, 'Dobbie', '66ad29dcc02c1.webp', 'my heart', 'My doggo', 'large', 9, 'vaccinated', 'Dobermann', 'adopted'),
(19, 'Maja', 'dog.jpg', 'Wien', 'Hungry all the time', 'large', 11, 'vaccinated', 'some breed of dogs', 'available'),
(20, 'Amigo', '66ad2deb829ee.jpg', 'wien', 'Hungry all the time', 'medium', 4, 'vaccinated', 'american staffordshire terrier', 'adopted'),
(21, 'Tomato', 'dog.jpg', 'wien', 'A ripe and firm tomato', 'small', 4, 'not vaccinated', 'cat', 'available'),
(22, 'Banana', 'dog.jpg', 'wien', 'Hungry all the time', 'large', 12, 'vaccinated', 'horse', 'available'),
(23, 'Apple', 'dog.jpg', 'Wien', 'Hungry all the time', 'medium', 8, 'vaccinated', 'dog', 'available'),
(24, 'julie', 'dog.jpg', 'wien', 'very small cute dog with small ears', 'small', 10, 'vaccinated', 'small dog with big ears', 'available'),
(25, 'another animal', 'dog.jpg', 'wien', 'test description', 'large', 8, 'not vaccinated', 'animal', 'adopted');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `adopted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`user_id`, `pet_id`, `adopted_at`) VALUES
(3, 25, '2024-08-03 06:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(40) NOT NULL,
  `address` varchar(150) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('user','adm') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `photo`, `password`, `status`) VALUES
(2, 'Mohamed', 'Mahran', 'mu_mahran@icloud.com', '06601125269', 'Am Krautgarten 30/2/1', '66ad0a9a14ea4.jpeg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'adm'),
(3, 'User', 'Usertest', 'user@mail.com', '655489889898', 'Erzherzog-Karl-Straße 194a', '66ad2eb05429d.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`user_id`,`pet_id`),
  ADD KEY `pet_id` (`pet_id`);

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
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `animals` (`pet_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
