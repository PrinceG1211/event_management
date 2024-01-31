-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 10:20 AM
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
-- Database: `event_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_tb`
--

CREATE TABLE `area_tb` (
  `areaID` int(11) NOT NULL,
  `cityID` varchar(255) DEFAULT NULL,
  `areaName` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tb`
--

CREATE TABLE `auth_tb` (
  `authID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city_tb`
--

CREATE TABLE `city_tb` (
  `cityID` int(11) NOT NULL,
  `cityName` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_tb`
--

CREATE TABLE `customer_tb` (
  `customerID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_event_tb`
--

CREATE TABLE `employee_event_tb` (
  `employeeEventID` int(11) NOT NULL,
  `employeeID` int(11) DEFAULT NULL,
  `eventID` int(11) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_tb`
--

CREATE TABLE `employee_tb` (
  `employeeID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `doj` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_booking_tb`
--

CREATE TABLE `event_booking_tb` (
  `bookingID` int(11) NOT NULL,
  `bookingType` varchar(255) DEFAULT NULL,
  `customerID` int(11) DEFAULT NULL,
  `bookingDate` varchar(255) DEFAULT NULL,
  `bookingStartDate` varchar(255) DEFAULT NULL,
  `bookingEndDate` varchar(255) DEFAULT NULL,
  `bookingStatus` varchar(255) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `noOfGuest` varchar(255) DEFAULT NULL,
  `subTotal` varchar(255) DEFAULT NULL,
  `totalCost` varchar(255) DEFAULT NULL,
  `packageID` int(11) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_detail_tb`
--

CREATE TABLE `event_detail_tb` (
  `eventDetailID` int(11) NOT NULL,
  `eventID` int(11) DEFAULT NULL,
  `vendorID` int(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_tb`
--

CREATE TABLE `hotel_tb` (
  `hotelID` int(11) NOT NULL,
  `packageID` varchar(255) DEFAULT NULL,
  `hotelName` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_tb`
--

CREATE TABLE `image_tb` (
  `imageID` int(11) NOT NULL,
  `productID` int(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_tb`
--

CREATE TABLE `inquiry_tb` (
  `inquiryID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `discription` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_tb`
--

CREATE TABLE `package_tb` (
  `packageID` int(11) NOT NULL,
  `packageName` varchar(255) DEFAULT NULL,
  `packageDiscription` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_category_tb`
--

CREATE TABLE `vendor_category_tb` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL,
  `parentID` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_tb`
--

CREATE TABLE `vendor_tb` (
  `vendorID` int(11) NOT NULL,
  `bname` varchar(255) DEFAULT NULL,
  `vendorName` varchar(255) DEFAULT NULL,
  `contactPerson` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactNo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `packageID` int(11) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venue_tb`
--

CREATE TABLE `venue_tb` (
  `venueID` int(11) NOT NULL,
  `venueName` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `contactPerson` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `packageID` int(11) DEFAULT NULL,
  `addedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_tb`
--
ALTER TABLE `area_tb`
  ADD PRIMARY KEY (`areaID`);

--
-- Indexes for table `auth_tb`
--
ALTER TABLE `auth_tb`
  ADD PRIMARY KEY (`authID`);

--
-- Indexes for table `city_tb`
--
ALTER TABLE `city_tb`
  ADD PRIMARY KEY (`cityID`);

--
-- Indexes for table `customer_tb`
--
ALTER TABLE `customer_tb`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `employee_event_tb`
--
ALTER TABLE `employee_event_tb`
  ADD PRIMARY KEY (`employeeEventID`);

--
-- Indexes for table `employee_tb`
--
ALTER TABLE `employee_tb`
  ADD PRIMARY KEY (`employeeID`);

--
-- Indexes for table `event_booking_tb`
--
ALTER TABLE `event_booking_tb`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `event_detail_tb`
--
ALTER TABLE `event_detail_tb`
  ADD PRIMARY KEY (`eventDetailID`);

--
-- Indexes for table `hotel_tb`
--
ALTER TABLE `hotel_tb`
  ADD PRIMARY KEY (`hotelID`);

--
-- Indexes for table `image_tb`
--
ALTER TABLE `image_tb`
  ADD PRIMARY KEY (`imageID`);

--
-- Indexes for table `inquiry_tb`
--
ALTER TABLE `inquiry_tb`
  ADD PRIMARY KEY (`inquiryID`);

--
-- Indexes for table `package_tb`
--
ALTER TABLE `package_tb`
  ADD PRIMARY KEY (`packageID`);

--
-- Indexes for table `vendor_category_tb`
--
ALTER TABLE `vendor_category_tb`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `vendor_tb`
--
ALTER TABLE `vendor_tb`
  ADD PRIMARY KEY (`vendorID`);

--
-- Indexes for table `venue_tb`
--
ALTER TABLE `venue_tb`
  ADD PRIMARY KEY (`venueID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_tb`
--
ALTER TABLE `area_tb`
  MODIFY `areaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tb`
--
ALTER TABLE `auth_tb`
  MODIFY `authID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city_tb`
--
ALTER TABLE `city_tb`
  MODIFY `cityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_tb`
--
ALTER TABLE `customer_tb`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_event_tb`
--
ALTER TABLE `employee_event_tb`
  MODIFY `employeeEventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_tb`
--
ALTER TABLE `employee_tb`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_booking_tb`
--
ALTER TABLE `event_booking_tb`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_detail_tb`
--
ALTER TABLE `event_detail_tb`
  MODIFY `eventDetailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_tb`
--
ALTER TABLE `hotel_tb`
  MODIFY `hotelID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_tb`
--
ALTER TABLE `image_tb`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiry_tb`
--
ALTER TABLE `inquiry_tb`
  MODIFY `inquiryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_tb`
--
ALTER TABLE `package_tb`
  MODIFY `packageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_category_tb`
--
ALTER TABLE `vendor_category_tb`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_tb`
--
ALTER TABLE `vendor_tb`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `venue_tb`
--
ALTER TABLE `venue_tb`
  MODIFY `venueID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
