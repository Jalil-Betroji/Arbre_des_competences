-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 09:56 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arbre_comptences`
--

-- --------------------------------------------------------

--
-- Table structure for table `personne`
--

CREATE TABLE `personne` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `CNE` varchar(50) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Ville_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personne`
--

INSERT INTO `personne` (`Id`, `Nom`, `CNE`, `Type`, `Ville_Id`) VALUES
(1, 'Jalil Betroji', 'P123456789', 'stagiare', 1),
(2, 'Hamid Achauo', 'P123456791', 'stagiare', 1),
(3, 'Amine Lamchatab', 'P123456792', 'personne', 1),
(4, 'Adnane Benasar', 'P123456793', 'stagiare', 1),
(5, 'Mohamed-Amine Bkhit', 'P123456794', 'stagiare', 1),
(6, 'Imrane Sarsri', 'P123456795', 'personne', 1),
(7, 'Amina Assaid', 'P123456796', 'stagiare', 1),
(8, 'Yassmine Daifane', 'P123456801', 'personne', 3),
(9, 'Hussein Bouik', 'P123456799', 'stagiare', 3),
(10, 'Adnane Lharrak', 'P123456798', 'stagiare', 3),
(11, 'Hamza zaani', 'P123456797', 'stagiare', 3),
(12, 'Mohamed Baqqali', 'P123456803', 'stagiare', 6),
(13, 'Soufian Boukhal', 'P123456804', 'personne', 2),
(34, 'Mohamed Ayman', 'P354541452', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ville`
--

CREATE TABLE `ville` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ville`
--

INSERT INTO `ville` (`Id`, `Nom`) VALUES
(1, 'Tetouan'),
(2, 'Tanger'),
(3, 'Casablanca'),
(4, 'Rabat'),
(5, 'Larache'),
(6, 'Khouribga'),
(7, 'El Kelaa des Sraghna'),
(8, 'Khenifra'),
(9, 'Beni Mellal'),
(10, 'Tiznit'),
(11, 'Errachidia'),
(12, 'Taroudant'),
(13, 'Ouarzazate'),
(14, 'Safi'),
(15, 'Lahraouyine'),
(16, 'Berrechid'),
(17, 'Fkih Ben Salah'),
(18, 'Taourirt'),
(19, 'Sefrou'),
(20, 'Youssoufia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_Ville` (`Ville_Id`);

--
-- Indexes for table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `personne`
--
ALTER TABLE `personne`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ville`
--
ALTER TABLE `ville`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `fk_Ville` FOREIGN KEY (`Ville_Id`) REFERENCES `ville` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
