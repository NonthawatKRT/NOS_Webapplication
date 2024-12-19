-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2024 at 06:35 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE nos_db;
USE nos_db;

--
--
--

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `ClaimID` int(11) NOT NULL,
  `ClaimDate` date DEFAULT NULL,
  `ClaimAmount` decimal(15,2) DEFAULT NULL,
  `Status` enum('Pending','Approved','Denied') DEFAULT NULL,
  `Description` text,
  `PolicyID` int(11) DEFAULT NULL,
  `CustomerID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` varchar(255) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `NationID` varchar(13) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Ethnicity` varchar(255) DEFAULT NULL,
  `Nationality` varchar(255) DEFAULT NULL,
  `DoB` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `District` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PostalCode` int(11) DEFAULT NULL,
  `Occupation` varchar(255) DEFAULT NULL,
  `Salary` int(11) DEFAULT NULL,
  `Workplace` varchar(255) DEFAULT NULL,
  `JoinDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `LastLogin` timestamp NULL DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Healthhistory` varchar(255) DEFAULT NULL,
  `Medicalhistory` varchar(255) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customerpolicy`
--

CREATE TABLE `customerpolicy` (
  `PolicyID` int(11) NOT NULL,
  `CustomerID` varchar(255) NOT NULL,
  `Created_At` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated_At` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Paymentstatus` enum('Pending','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pending',
  `EnrollmentDate` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employeepolicy`
--

CREATE TABLE `employeepolicy` (
  `PolicyID` int(11) NOT NULL,
  `EmployeeID` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Created_At` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated_At` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Paymentstatus` enum('Pending','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pending',
  `EnrollmentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeID` varchar(255) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `NationID` varchar(13) DEFAULT NULL,
  `Gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Ethnicity` varchar(255) DEFAULT NULL,
  `Nationality` varchar(255) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `Province` varchar(255) DEFAULT NULL,
  `PostalCode` int(11) DEFAULT NULL,
  `Occupation` varchar(255) DEFAULT NULL,
  `Salary` varchar(255) DEFAULT NULL,
  `Workplace` varchar(255) DEFAULT NULL,
  `PolicyID` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `HireDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Position` varchar(50) DEFAULT NULL,
  `Status` enum('Active','Inactive') DEFAULT NULL,
  `TotalSales` decimal(15,2) DEFAULT NULL,
  `CommissionRate` decimal(5,2) DEFAULT NULL,
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LastLogin` timestamp NULL DEFAULT NULL,
  `Healthhistory` varchar(255) DEFAULT NULL,
  `Medicalhistory` varchar(255) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logincredentials`
--

CREATE TABLE `logincredentials` (
  `UserID` varchar(255) NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PasswordHash` varchar(255) DEFAULT NULL,
  `Verification_Token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `OTP` varchar(6) DEFAULT NULL,
  `OTP_expires_at` datetime DEFAULT NULL,
  `Status` enum('Active','waiting for verify','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy`
--

CREATE TABLE `policy` (
  `PolicyID` int(11) NOT NULL,
  `PolicyName` varchar(100) DEFAULT NULL,
  `PolicyType` enum('Life','Health','Auto','Home','Other') DEFAULT NULL,
  `CoverageAmount` decimal(15,2) DEFAULT NULL,
  `Premium` decimal(10,2) DEFAULT NULL,
  `TermLength` int(11) DEFAULT NULL,
  `Description` text,
  `ImageName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `SalesID` varchar(255) NOT NULL,
  `EmployeeID` varchar(255) DEFAULT NULL,
  `Role` enum('SalesRep','Manager') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salescustomer`
--

CREATE TABLE `salescustomer` (
  `SalesCustomerID` varchar(255) NOT NULL,
  `SalesID` varchar(255) NOT NULL,
  `CustomerID` varchar(255) NOT NULL,
  `PolicyID` int(11) NOT NULL,
  `RelationshipStart` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` varchar(255) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `UserRole` enum('Guest','Customer','Employee','Admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`ClaimID`),
  ADD KEY `PolicyID` (`PolicyID`),
  ADD KEY `fk_claims_customerID` (`CustomerID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `NationID` (`NationID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `customerpolicy`
--
ALTER TABLE `customerpolicy`
  ADD PRIMARY KEY (`PolicyID`,`CustomerID`),
  ADD KEY `fk_customerpolicy_customerID` (`CustomerID`);

--
-- Indexes for table `employeepolicy`
--
ALTER TABLE `employeepolicy`
  ADD PRIMARY KEY (`PolicyID`),
  ADD KEY `fk_employeepolicy` (`EmployeeID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `logincredentials`
--
ALTER TABLE `logincredentials`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `policy`
--
ALTER TABLE `policy`
  ADD PRIMARY KEY (`PolicyID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`SalesID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `salescustomer`
--
ALTER TABLE `salescustomer`
  ADD PRIMARY KEY (`SalesCustomerID`),
  ADD KEY `SalesID` (`SalesID`),
  ADD KEY `fk_salescustomer_customerID` (`CustomerID`),
  ADD KEY `fk_policyID` (`PolicyID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `ClaimID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy`
--
ALTER TABLE `policy`
  MODIFY `PolicyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claims`
--
ALTER TABLE `claims`
  ADD CONSTRAINT `claims_ibfk_1` FOREIGN KEY (`PolicyID`) REFERENCES `policy` (`PolicyID`),
  ADD CONSTRAINT `fk_claims_customerID` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);

--
-- Constraints for table `customerpolicy`
--
ALTER TABLE `customerpolicy`
  ADD CONSTRAINT `customerpolicy_ibfk_1` FOREIGN KEY (`PolicyID`) REFERENCES `policy` (`PolicyID`),
  ADD CONSTRAINT `fk_customerpolicy_customerID` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);

--
-- Constraints for table `employeepolicy`
--
ALTER TABLE `employeepolicy`
  ADD CONSTRAINT `fk_employeepolicy` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `logincredentials`
--
ALTER TABLE `logincredentials`
  ADD CONSTRAINT `logincredentials_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `salescustomer`
--
ALTER TABLE `salescustomer`
  ADD CONSTRAINT `fk_policyID` FOREIGN KEY (`PolicyID`) REFERENCES `policy` (`PolicyID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_salescustomer_customerID` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `salescustomer_fk` FOREIGN KEY (`SalesID`) REFERENCES `sales` (`SalesID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
