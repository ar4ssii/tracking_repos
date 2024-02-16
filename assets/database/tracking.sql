-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 08:14 PM
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
-- Database: `tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deliver`
--

CREATE TABLE `tbl_deliver` (
  `deliverID` int(11) NOT NULL,
  `transactionNumber` varchar(200) NOT NULL,
  `senderID` int(11) NOT NULL,
  `recipientID` int(11) NOT NULL,
  `ItemName` varchar(200) NOT NULL,
  `ItemSize` int(11) NOT NULL,
  `ItemFragile` int(11) NOT NULL,
  `ItemValue` int(11) NOT NULL,
  `PaymentType` int(11) NOT NULL,
  `PaymentStatus` varchar(100) NOT NULL,
  `sender_payServiceFee` int(11) NOT NULL,
  `BookedDate` timestamp NULL DEFAULT NULL,
  `EstimatedDeliveryDate` date NOT NULL,
  `DeliveryStatus` varchar(200) NOT NULL,
  `fromPostLocationID` int(11) NOT NULL,
  `receivedByPostLocationID` int(11) NOT NULL,
  `DateApproved` timestamp NULL DEFAULT NULL,
  `DateReapproved` timestamp NULL DEFAULT NULL,
  `DateDroppedOff` timestamp NULL DEFAULT NULL,
  `DateShippedOut` timestamp NULL DEFAULT NULL,
  `DateReceived` timestamp NULL DEFAULT NULL,
  `DateOutForDelivery` datetime DEFAULT NULL,
  `DateDelivered` timestamp NULL DEFAULT NULL,
  `DateDeclined` timestamp NULL DEFAULT NULL,
  `ReasonDeclined` text DEFAULT NULL,
  `staffID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_postal_codes`
--

CREATE TABLE `tbl_postal_codes` (
  `postalID` int(11) NOT NULL,
  `postalCode` varchar(4) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Province` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_postal_codes`
--

INSERT INTO `tbl_postal_codes` (`postalID`, `postalCode`, `City`, `Province`) VALUES
(1, '2012', 'ARAYAT', 'PAMPANGA'),
(2, '2021', 'MEXICO', 'PAMPANGA'),
(3, '2022', 'STA ANA', 'PAMPANGA');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_postlocations`
--

CREATE TABLE `tbl_postlocations` (
  `postLocationID` int(11) NOT NULL,
  `OtherLocationDetails` varchar(200) NOT NULL,
  `Barangay` varchar(200) NOT NULL,
  `postalID` int(11) NOT NULL,
  `postLocationName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_postlocations`
--

INSERT INTO `tbl_postlocations` (`postLocationID`, `OtherLocationDetails`, `Barangay`, `postalID`, `postLocationName`) VALUES
(1, '123 BC Building', 'Plazang Luma', 1, 'Arayat Hub'),
(2, 'Maningning Street 1st floor, NONO s Commercial Building', 'Sto Domingo', 2, 'Mexico Hub'),
(3, '55 Sampaguita St', 'Sta Lucia', 3, 'Sta Lucia Hub');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recipient`
--

CREATE TABLE `tbl_recipient` (
  `recipientID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `FName` varchar(200) NOT NULL,
  `MName` varchar(200) NOT NULL,
  `LName` varchar(200) NOT NULL,
  `Street` varchar(200) NOT NULL,
  `Barangay` varchar(200) NOT NULL,
  `postalID` int(10) NOT NULL,
  `OtherLocationDetails` varchar(200) NOT NULL,
  `ContactNumber` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sender`
--

CREATE TABLE `tbl_sender` (
  `senderID` int(11) NOT NULL,
  `Username` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `FName` varchar(100) NOT NULL,
  `MName` varchar(100) NOT NULL,
  `LName` varchar(100) NOT NULL,
  `Street` varchar(100) NOT NULL,
  `Barangay` varchar(100) NOT NULL,
  `postalID` int(10) NOT NULL,
  `OtherLocationDetails` varchar(100) NOT NULL,
  `ContactNumber` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staffID` int(11) NOT NULL,
  `FName` varchar(500) DEFAULT NULL,
  `MName` varchar(100) NOT NULL,
  `LName` varchar(500) DEFAULT NULL,
  `Birthdate` date NOT NULL,
  `Username` varchar(500) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `Role` tinyint(11) NOT NULL DEFAULT 0,
  `ContactNumber` varchar(11) NOT NULL,
  `postLocationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`staffID`, `FName`, `MName`, `LName`, `Birthdate`, `Username`, `Password`, `Role`, `ContactNumber`, `postLocationID`) VALUES
(1, 'Admin', '', '', '0000-00-00', 'admin@staff', '123', 1, '', 1),
(2, 'Juan', '', 'Dela Cruz', '2003-02-06', 'staff@staff', '1andOnly', 0, '', 1),
(3, 'Pedro', 'Mallari', 'Dizon', '2003-02-04', 'rider1@staff', 'rider1', 0, '', 1),
(5, 'JULIANA', 'ADMIN', 'STA ANA', '2004-02-01', 'adminStaAna@staff', 'adminStaAna', 1, '09471026007', 3),
(6, 'TAYLOR', 'MAPANAQUIT', 'SWIFT', '2002-05-08', 'taylorStaff@staff', 'taylorStaff', 0, '09471026008', 3),
(7, 'HARRY', 'BOLDY', 'POTTER', '2024-01-30', 'hpotterStaff@staff', 'hpotterStaff', 0, '09471026008', 3),
(8, 'JUNGKOOK', 'JIMIN', 'V', '2024-01-28', 'taeminkook@staff', 'taeminkook', 1, '09471026008', 3),
(9, 'mexico', '', 'm', '0000-00-00', 'mexicoAdmin@staff', 'mexicoAdmin', 1, '09784546461', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_deliver`
--
ALTER TABLE `tbl_deliver`
  ADD PRIMARY KEY (`deliverID`);

--
-- Indexes for table `tbl_postal_codes`
--
ALTER TABLE `tbl_postal_codes`
  ADD PRIMARY KEY (`postalID`);

--
-- Indexes for table `tbl_postlocations`
--
ALTER TABLE `tbl_postlocations`
  ADD PRIMARY KEY (`postLocationID`);

--
-- Indexes for table `tbl_recipient`
--
ALTER TABLE `tbl_recipient`
  ADD PRIMARY KEY (`recipientID`);

--
-- Indexes for table `tbl_sender`
--
ALTER TABLE `tbl_sender`
  ADD PRIMARY KEY (`senderID`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_deliver`
--
ALTER TABLE `tbl_deliver`
  MODIFY `deliverID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_postal_codes`
--
ALTER TABLE `tbl_postal_codes`
  MODIFY `postalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_postlocations`
--
ALTER TABLE `tbl_postlocations`
  MODIFY `postLocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_recipient`
--
ALTER TABLE `tbl_recipient`
  MODIFY `recipientID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sender`
--
ALTER TABLE `tbl_sender`
  MODIFY `senderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
