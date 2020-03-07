-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2020 at 08:49 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `flightmv`
--

-- --------------------------------------------------------

--
-- Table structure for table `flightinfo`
--

CREATE TABLE `flightinfo` (
  `ID` int(11) NOT NULL,
  `airline_id` varchar(20) NOT NULL,
  `airline_name` varchar(255) NOT NULL,
  `flight_no` varchar(45) NOT NULL,
  `scheduled_d` date DEFAULT NULL,
  `scheduled_t` time NOT NULL,
  `estimated_t` time DEFAULT NULL,
  `status_int` varchar(45) DEFAULT NULL,
  `flight_status` varchar(45) DEFAULT NULL,
  `airline_img` varchar(255) DEFAULT NULL,
  `direction` varchar(20) NOT NULL,
  `bound` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flightinfo`
--
ALTER TABLE `flightinfo`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flightinfo`
--
ALTER TABLE `flightinfo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
