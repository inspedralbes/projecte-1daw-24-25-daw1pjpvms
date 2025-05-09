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

USE a24pauvermac_incidencies;DROP TABLE IF EXISTS `INCIDENCIA`;
DROP TABLE IF EXISTS `TECNICS`;
DROP TABLE IF EXISTS `ESTAT`;
DROP TABLE IF EXISTS `DEPARTAMENT`;

CREATE TABLE `DEPARTAMENT` (
  `cod_dept` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cod_dept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `DEPARTAMENT` (`cod_dept`, `nom`) VALUES
(1, 'Angles'),
(2, 'Fisica'),
(3, 'L.cat'),
(4, 'Matematiques');

CREATE TABLE `ESTAT` (
  `cod_estat` int NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cod_estat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ESTAT` (`cod_estat`, `nom`) VALUES
(1, 'En espera'),
(2, 'Revisant'),
(3, 'Solucionada');

CREATE TABLE `TECNICS` (
  `cod_tecnic` int NOT NULL,
  `rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_proj` int DEFAULT NULL,
  PRIMARY KEY (`cod_tecnic`),
  KEY `nom` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `TECNICS` (`cod_tecnic`, `rol`, `cod_proj`) VALUES
(0,	'Sense asignar',	NULL),
(1,	'Informatic',	NULL),
(2,	'Manteniment',	NULL),
(3,	'Multimedia',	NULL),
(4,	'Mediador/a',	NULL);

CREATE TABLE `INCIDENCIA` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_dept` int NOT NULL,
  `Descripcio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Data` datetime NOT NULL,
  `cod_estat` int NOT NULL,
  `cod_tecnic` int NOT NULL,
  `prioritat` enum('Sense asignar','Crítica','Alta','Moderada','Baixa') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_estat` (`cod_estat`),
  KEY `cod_tecnic` (`cod_tecnic`),
  KEY `INCIDENCIA_ibfk_3` (`cod_dept`),
  CONSTRAINT `INCIDENCIA_ibfk_1` FOREIGN KEY (`cod_estat`) REFERENCES `ESTAT` (`cod_estat`),
  CONSTRAINT `INCIDENCIA_ibfk_2` FOREIGN KEY (`cod_tecnic`) REFERENCES `TECNICS` (`cod_tecnic`),
  CONSTRAINT `INCIDENCIA_ibfk_3` FOREIGN KEY (`cod_dept`) REFERENCES `DEPARTAMENT` (`cod_dept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

