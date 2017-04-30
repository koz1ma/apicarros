-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2017 at 12:21 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carros`
--

-- --------------------------------------------------------

--
-- Table structure for table `acessorio`
--

CREATE TABLE `acessorio` (
  `idacessorio` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `status` char(1) DEFAULT 'F' COMMENT 'O se for opicional\nF se for fabrica'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acessorio`
--

INSERT INTO `acessorio` (`idacessorio`, `nome`, `status`) VALUES
(1, 'AIRBAG', 'O');

-- --------------------------------------------------------

--
-- Table structure for table `modelo`
--

CREATE TABLE `modelo` (
  `idmodelo` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `ano` year(4) DEFAULT NULL,
  `aro` decimal(2,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `modelo_acessorio`
--

CREATE TABLE `modelo_acessorio` (
  `modelo_idmodelo` int(11) NOT NULL,
  `acessorio_idacessorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acessorio`
--
ALTER TABLE `acessorio`
  ADD PRIMARY KEY (`idacessorio`);

--
-- Indexes for table `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`idmodelo`);

--
-- Indexes for table `modelo_acessorio`
--
ALTER TABLE `modelo_acessorio`
  ADD PRIMARY KEY (`modelo_idmodelo`,`acessorio_idacessorio`),
  ADD KEY `fk_modelo_has_acessorio_acessorio1_idx` (`acessorio_idacessorio`),
  ADD KEY `fk_modelo_has_acessorio_modelo_idx` (`modelo_idmodelo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acessorio`
--
ALTER TABLE `acessorio`
  MODIFY `idacessorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `modelo`
--
ALTER TABLE `modelo`
  MODIFY `idmodelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `modelo_acessorio`
--
ALTER TABLE `modelo_acessorio`
  ADD CONSTRAINT `fk_modelo_has_acessorio_acessorio1` FOREIGN KEY (`acessorio_idacessorio`) REFERENCES `acessorio` (`idacessorio`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modelo_has_acessorio_modelo` FOREIGN KEY (`modelo_idmodelo`) REFERENCES `modelo` (`idmodelo`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
