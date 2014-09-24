-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 12 jun 2014 om 09:18
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `pizzashop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikels`
--

CREATE TABLE IF NOT EXISTS `artikels` (
  `artikelnummer` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(18) NOT NULL,
  `omschrijving` text NOT NULL,
  `image_locatie` varchar(125) NOT NULL,
  `prijs` decimal(10,2) NOT NULL DEFAULT '0.00',
  `korting` decimal(10,2) NOT NULL DEFAULT '0.00',
  `categorieid` int(11) NOT NULL,
  PRIMARY KEY (`artikelnummer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden geëxporteerd voor tabel `artikels`
--

INSERT INTO `artikels` (`artikelnummer`, `naam`, `omschrijving`, `image_locatie`, `prijs`, `korting`, `categorieid`) VALUES
(1, 'coca-cola', '', 'images/cola.jpg', '1.30', '0.00', 1),
(3, 'fanta', '', 'images/fanta.jpg', '1.30', '0.00', 1),
(4, 'Sprite', '', 'images/sprite.jpg', '1.30', '0.00', 1),
(5, 'Ice Tea', '', 'images/IceTea.jpg', '1.50', '0.00', 1),
(7, 'PIZZA PEPPI LARGE', 'pepperoni', 'images/pizza.jpg', '14.95', '0.00', 2),
(8, 'PIZZA PEPPI MEDIUM', 'pepperoni', 'images/pizza.jpg', '10.95', '2.25', 2),
(9, 'PIZZA PEPPI SMALL', 'pepperoni', 'images/pizza.jpg', '8.95', '0.00', 2),
(10, 'PIZZA SPICY LARGE', 'kruidige gehaktballetjes, provencaalse kruiden', 'images/pizza.jpg', '14.95', '0.00', 2),
(11, 'PIZZA SPICY MEDIUM', 'kruidige gehaktballetjes, provencaalse kruiden', 'images/pizza.jpg', '10.95', '0.00', 2),
(12, 'PIZZA SPICY SMALL', 'kruidige gehaktballetjes, provencaalse kruiden', 'images/pizza.jpg', '8.95', '0.00', 2),
(13, 'Extra kaas', '', 'images/kaas.jpg', '1.00', '0.00', 3),
(14, 'Extra olijven', '', 'images/olijven.jpg', '1.25', '0.00', 3),
(15, 'Extra ansjovis', '', 'images/ansjovis_0.jpg', '1.50', '0.00', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellijnen`
--

CREATE TABLE IF NOT EXISTS `bestellijnen` (
  `bestellingsid` int(11) NOT NULL,
  `bestellijnid` int(11) NOT NULL AUTO_INCREMENT,
  `artikelnummer` int(11) NOT NULL,
  `aantal` int(4) NOT NULL,
  `prijs` decimal(10,2) NOT NULL,
  PRIMARY KEY (`bestellijnid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden geëxporteerd voor tabel `bestellijnen`
--

INSERT INTO `bestellijnen` (`bestellingsid`, `bestellijnid`, `artikelnummer`, `aantal`, `prijs`) VALUES
(1, 1, 3, 1, '1.30'),
(2, 2, 5, 1, '1.50'),
(2, 3, 7, 1, '17.20'),
(2, 4, 8, 1, '11.20'),
(3, 5, 3, 2, '2.60'),
(3, 6, 1, 1, '1.30'),
(3, 7, 4, 1, '1.30'),
(3, 8, 7, 1, '14.95'),
(3, 9, 8, 1, '11.20'),
(3, 10, 7, 1, '17.20'),
(4, 11, 1, 1, '1.30'),
(4, 12, 3, 1, '1.30'),
(5, 13, 7, 1, '17.45'),
(5, 14, 3, 4, '5.20'),
(5, 15, 10, 1, '16.20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE IF NOT EXISTS `bestellingen` (
  `bestellingsid` int(11) NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prijs` decimal(10,2) NOT NULL,
  `gebruikersnummer` int(11) NOT NULL,
  `bestellingstype` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`bestellingsid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden geëxporteerd voor tabel `bestellingen`
--

INSERT INTO `bestellingen` (`bestellingsid`, `datum`, `prijs`, `gebruikersnummer`, `bestellingstype`, `status`) VALUES
(1, '2014-05-22 15:37:43', '1.30', 1, 1, 0),
(2, '2014-05-22 15:37:58', '29.90', 1, 1, 0),
(3, '2014-05-22 15:38:24', '48.55', 1, 1, 3),
(4, '2014-05-22 15:44:06', '2.60', 2, 0, 0),
(5, '2014-05-23 10:00:52', '38.85', 10, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorieen`
--

CREATE TABLE IF NOT EXISTS `categorieen` (
  `categorieid` int(11) NOT NULL AUTO_INCREMENT,
  `omschrijving` text NOT NULL,
  PRIMARY KEY (`categorieid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden geëxporteerd voor tabel `categorieen`
--

INSERT INTO `categorieen` (`categorieid`, `omschrijving`) VALUES
(1, 'Frisdranken'),
(2, 'Pizza&#39;s'),
(3, 'Extra');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `extrabestellijnen`
--

CREATE TABLE IF NOT EXISTS `extrabestellijnen` (
  `bestellijnid` int(11) NOT NULL,
  `extraid` int(11) NOT NULL,
  PRIMARY KEY (`bestellijnid`,`extraid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `extrabestellijnen`
--

INSERT INTO `extrabestellijnen` (`bestellijnid`, `extraid`) VALUES
(3, 13),
(3, 14),
(4, 13),
(4, 15),
(9, 13),
(9, 15),
(10, 13),
(10, 14),
(13, 13),
(13, 15),
(15, 14);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gastenboek`
--

CREATE TABLE IF NOT EXISTS `gastenboek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gebruikersnaam` varchar(18) NOT NULL,
  `titel` varchar(18) NOT NULL,
  `boodschap` varchar(125) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden geëxporteerd voor tabel `gastenboek`
--

INSERT INTO `gastenboek` (`id`, `gebruikersnaam`, `titel`, `boodschap`) VALUES
(3, 'Test', 'test', 'testboodschap'),
(6, 'bert', 'NOMNOM', 'NOMNOMNOMNOMNOMNOM !'),
(10, 'Thomas', 'Review', 'Verder ziet het er heel goed uit !');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `gebruikersnummer` int(11) NOT NULL AUTO_INCREMENT,
  `gebruikersnaam` varchar(18) NOT NULL,
  `wachtwoord` varchar(512) NOT NULL,
  `emailadres` varchar(1024) NOT NULL,
  `recovery_string` varchar(35) NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `voornaam` varchar(18) NOT NULL,
  `achternaam` varchar(18) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `gemeente` varchar(18) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `telefoonnummer` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `leverwijze` varchar(18) NOT NULL,
  PRIMARY KEY (`gebruikersnummer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruikersnummer`, `gebruikersnaam`, `wachtwoord`, `emailadres`, `recovery_string`, `datum`, `voornaam`, `achternaam`, `adres`, `gemeente`, `postcode`, `telefoonnummer`, `status`, `leverwijze`) VALUES
(1, 'Test', '$2y$12$49863142125369dfe45d4uxMCQ063sG21WoMHrv3fqYNhYWdYXEpe', 'test@test.com', '0', '2014-05-06 13:54:40', 'Test', 'Test', 'Test 16', 'Oostende', '8400', 164, 2, 'Afhalen'),
(2, 'test2', '$2y$12$70062419745369d924d08u1eZk0bRr5Vfgh/aWeP22nmXXUVA.rka', 'test2@test.com', '', '2014-05-07 08:56:37', 'test2', 'test', 'test 15', 'test', '8400', 1564, 0, 'Thuislevering'),
(4, 'test3', '$2y$12$460879182537e053e84eaO6sXfb32nfsk11blt5hP0giW6hysadvC', 'test3@test.com', '0', '2014-05-08 15:52:32', 'dffhdh', 'dd', 'ddfd', 'ddhnd', '9000', 0, 1, ''),
(5, 'bert', '$2y$12$051449169537b57cee1beukkkivQ1OTWYJYZm9Af0o.nfW9ztOsEe', 'bert@bert.be', '', '2014-05-20 15:25:35', 'bert', 'bert', 'bert 2', 'bertegem', '8510', 5214152, 1, 'Afhalen'),
(6, 'Thomas', '$2y$12$8414914793537b57fa9deuEh78ulJZzqZSYCzGGvZuggbJuQjG78C', 'thomas', '', '2014-05-20 15:26:18', 'Thomas', 'Deserranno', 'Datzoujewelwillenweten 22', '8000', 'Brugge', 12345678, 1, 'Afhalen'),
(10, 'jan', '$2y$12$522697257537effca121dupWXrtgDu1b/BW2GZfAvsILlxPuD3vK2', 'jan.vandorpe@vdab.be', '', '2014-05-23 09:59:06', 'jan', 'vandorpe', 'archimedestraat 4', 'Oostende', '8400', 123456789, 0, 'Thuislevering');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverzones`
--

CREATE TABLE IF NOT EXISTS `leverzones` (
  `postcode` varchar(10) NOT NULL,
  `gemeente` varchar(15) NOT NULL,
  `prijs` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`postcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `leverzones`
--

INSERT INTO `leverzones` (`postcode`, `gemeente`, `prijs`) VALUES
('8400', 'Oostende', '0.00'),
('8430', 'Middelkerke', '1.50'),
('8450', 'Bredene', '1.00'),
('8460', 'Oudenburg', '1.50');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
