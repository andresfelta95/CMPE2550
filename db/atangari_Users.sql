-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2022 at 10:35 AM
-- Server version: 5.7.40
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atangari_Users`
--

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserId` mediumint(9) NOT NULL,
  `UserName` varchar(40) NOT NULL,
  `LName` varchar(40) NOT NULL,
  `FName` varchar(40) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UsersRole`
--

CREATE TABLE `UsersRole` (
  `UserId` mediumint(9) NOT NULL,
  `UserName` varchar(40) NOT NULL,
  `RoleId` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `RoleId` mediumint(9) NOT NULL,
  `RoleName` varchar(40) NOT NULL,
  `RoleDescription` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--  --------------------------------------------------------

--
-- Table structure for table `UsersMessage`
--

CREATE TABLE `UsersMessage` (
  `UserId` mediumint(9) NOT NULL,
  `MessageId` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--  --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `MessageId` mediumint(9) NOT NULL,
  `UserName` varchar(40) NOT NULL,
  `Message` varchar(200) NOT NULL,
  `MessageDate` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `UsersRole`
--
ALTER TABLE `UsersRole`
  ADD PRIMARY KEY (`UserId`,`RoleId`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`RoleId`);

--
-- Indexes for table `UsersMessage`
--
ALTER TABLE `UsersMessage`
  ADD PRIMARY KEY (`UserId`,`MessageId`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`MessageId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserId` mediumint(9) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `MessageId` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `UsersRole`
--
ALTER TABLE `UsersRole`
  ADD CONSTRAINT `UsersRole_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`),
  ADD CONSTRAINT `UsersRole_ibfk_2` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`RoleId`);
COMMIT;

--
-- Constraints for table `UsersMessage`
--
ALTER TABLE `UsersMessage`
  ADD CONSTRAINT `UsersMessage_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`),
  ADD CONSTRAINT `UsersMessage_ibfk_2` FOREIGN KEY (`MessageId`) REFERENCES `Messages` (`MessageId`);

--
-- Dumping data for table `Users`
--

--
-- Dumping data for table `UsersRole`
--

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`RoleId`, `RoleName`, `RoleDescription`) VALUES
(1, 'Root', 'User that can access anything and modify all'),
(2, 'Admin', 'User that can access anything but they cannot modify the Root role'),
(3, 'User', 'User that can only access their own data');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
