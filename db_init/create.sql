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

USE a24pauvermac_incidencies;

DROP TABLE IF EXISTS `ESTAT`;
CREATE TABLE `ESTAT` (
  `cod_estat` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cod_estat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ESTAT` (`cod_estat`, `nom`) VALUES
(1,	'En espera'),
(2,	'Revisant'),
(3,	'Solucionada');

DROP TABLE IF EXISTS `INCIDENCIA`;
CREATE TABLE `INCIDENCIA` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Dept` enum('L.cat','Matematiques','Angles','Fisica') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Descripcio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Data` datetime NOT NULL,
  `cod_estat` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_estat` (`cod_estat`),
  CONSTRAINT `INCIDENCIA_ibfk_1` FOREIGN KEY (`cod_estat`) REFERENCES `ESTAT` (`cod_estat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

