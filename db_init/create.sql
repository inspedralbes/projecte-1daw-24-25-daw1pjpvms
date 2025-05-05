-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Temps de generació: 05-05-2025 a les 08:40:28
-- Versió del servidor: 10.11.10-MariaDB-ubu2204
-- Versió de PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `a24pauvermac_incidencies`
--
CREATE DATABASE IF NOT EXISTS a24pauvermac_incidencies
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
-- --------------------------------------------------------

--
-- Estructura de la taula `INCIDENCIA`
--

GRANT ALL PRIVILEGES ON a24pauvermac_incidencies.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

CREATE TABLE `INCIDENCIA` (
  `Dept` enum('L.cat','Matematiques','Angles','Fisica') NOT NULL,
  `Descripcio` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





-- Després de crear la base de dades, cal seleccionar-la per treballar-hi
USE a24pauvermac_incidencies;
-- Bolcament de dades per a la taula `INCIDENCIA`
--

INSERT INTO `INCIDENCIA` (`Dept`, `Descripcio`) VALUES
('L.cat', 'hola'),
('L.cat', 's'),
('Matematiques', 'd'),
('Matematiques', 'dfsfsd'),
('Matematiques', 'hola'),
('Matematiques', 'Una taula sha trencat '),
('Fisica', 'd'),
('Fisica', 'holahola'),
('Fisica', 'Un ordinador no funciona');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `INCIDENCIA`
--
ALTER TABLE `INCIDENCIA`
  ADD PRIMARY KEY (`Dept`,`Descripcio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;