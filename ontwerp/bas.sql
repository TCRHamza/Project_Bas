-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 mei 2024 om 10:14
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bas`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `artId` int(11) NOT NULL,
  `artOmschrijving` varchar(12) NOT NULL,
  `artInkoop` decimal(3,2) DEFAULT NULL,
  `artVerkoop` decimal(3,2) DEFAULT NULL,
  `artVoorraad` int(11) NOT NULL,
  `artMinVoorraad` int(11) NOT NULL,
  `artMaxVoorraad` int(11) NOT NULL,
  `artLocatie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `inkooporder`
--

CREATE TABLE `inkooporder` (
  `inkOrdId` int(11) NOT NULL,
  `levId` int(11) DEFAULT NULL,
  `artId` int(11) DEFAULT NULL,
  `inkOrdDatum` date DEFAULT NULL,
  `inkOrdBestAantal` int(11) DEFAULT NULL,
  `inkOrdStatus` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `klantId` int(11) NOT NULL,
  `klantNaam` varchar(20) DEFAULT NULL,
  `klantEmail` varchar(30) NOT NULL,
  `klantAdres` varchar(30) NOT NULL,
  `klantPostcode` varchar(6) DEFAULT NULL,
  `klantWoonplaats` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverancier`
--

CREATE TABLE `leverancier` (
  `levId` int(11) NOT NULL,
  `levNaam` varchar(15) NOT NULL,
  `levContact` varchar(20) DEFAULT NULL,
  `levEmail` varchar(30) NOT NULL,
  `levAdres` varchar(30) DEFAULT NULL,
  `levPostcode` varchar(6) DEFAULT NULL,
  `levWoonplaats` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verkooporder`
--

CREATE TABLE `verkooporder` (
  `verkOrdId` int(11) NOT NULL,
  `klantId` int(11) DEFAULT NULL,
  `artId` int(11) DEFAULT NULL,
  `verkOrdDatum` date DEFAULT NULL,
  `verkOrdBestAantal` int(11) DEFAULT NULL,
  `verkOrdStatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artId`);

--
-- Indexen voor tabel `inkooporder`
--
ALTER TABLE `inkooporder`
  ADD PRIMARY KEY (`inkOrdId`),
  ADD KEY `levId` (`levId`),
  ADD KEY `artId` (`artId`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantId`);

--
-- Indexen voor tabel `leverancier`
--
ALTER TABLE `leverancier`
  ADD PRIMARY KEY (`levId`);

--
-- Indexen voor tabel `verkooporder`
--
ALTER TABLE `verkooporder`
  ADD PRIMARY KEY (`verkOrdId`),
  ADD KEY `klantId` (`klantId`),
  ADD KEY `artId` (`artId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `inkooporder`
--
ALTER TABLE `inkooporder`
  MODIFY `inkOrdId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `leverancier`
--
ALTER TABLE `leverancier`
  MODIFY `levId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `verkooporder`
--
ALTER TABLE `verkooporder`
  MODIFY `verkOrdId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `inkooporder`
--
ALTER TABLE `inkooporder`
  ADD CONSTRAINT `inkooporder_ibfk_1` FOREIGN KEY (`levId`) REFERENCES `leverancier` (`levId`),
  ADD CONSTRAINT `inkooporder_ibfk_2` FOREIGN KEY (`artId`) REFERENCES `artikel` (`artId`);

--
-- Beperkingen voor tabel `verkooporder`
--
ALTER TABLE `verkooporder`
  ADD CONSTRAINT `verkooporder_ibfk_1` FOREIGN KEY (`klantId`) REFERENCES `klant` (`klantId`),
  ADD CONSTRAINT `verkooporder_ibfk_2` FOREIGN KEY (`artId`) REFERENCES `artikel` (`artId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
