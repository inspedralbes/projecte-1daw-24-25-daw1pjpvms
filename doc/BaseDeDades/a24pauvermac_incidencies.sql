-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Temps de generació: 19-05-2025 a les 10:22:29
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

-- --------------------------------------------------------

--
-- Estructura de la taula `ACTUACIONS`
--

CREATE TABLE `ACTUACIONS` (
  `cod_act` int(11) NOT NULL,
  `cod_tecnic` int(11) NOT NULL,
  `cod_inci` int(11) NOT NULL,
  `descri` varchar(500) NOT NULL,
  `mostrar` int(11) DEFAULT NULL,
  `temps` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `ACTUACIONS`
--

INSERT INTO `ACTUACIONS` (`cod_act`, `cod_tecnic`, `cod_inci`, `descri`, `mostrar`, `temps`, `data`) VALUES
(1, 1, 1, 'S\'ha revisat l\'ordinador i es demana una font d\'alimentació nova.', 1, 30, '2024-05-10 09:00:00'),
(2, 3, 2, 'Comprovació de cables i connexions del projector. S\'ha sol·licitat recanvi.', 1, 45, '2024-05-11 10:30:00'),
(3, 2, 3, 'Reparació de la canonada d\'aigua. Incidència solucionada.', 1, 60, '2024-05-12 13:00:00'),
(4, 1, 4, 'S\'ha reiniciat el router i canviat la configuració WiFi.', 1, 20, '2024-05-14 13:00:00'),
(5, 3, 5, 'Reinstal·lació del software de la pissarra digital.', 1, 40, '2024-05-13 12:00:00'),
(8, 1, 37, 'S\'ha comprovat la configuració de xarxa i es sospita un problema amb la targeta.', 1, 25, '2025-05-17 11:15:00'),
(9, 3, 38, 'Canviat el cable HDMI, però el projector continua sense senyal. Possible port danyat.', 1, 35, '2025-05-17 11:45:00'),
(10, 1, 39, 'S\'ha substituït el ratolí i comprovat la configuració del dispositiu.', 1, 10, '2025-05-17 12:10:00'),
(11, 2, 40, 'Revisió del sistema de ventilació i aïllament. Es programarà una reparació.', 1, 40, '2025-05-17 12:45:00'),
(12, 2, 41, 'I have inspected the door as reported in your incident. The issue was caused by a loose hinge and some misalignment. I have tightened all the screws and adjusted the door to ensure it closes smoothly. After testing several times, the door now closes properly without any resistance.', 1, 50, '2025-05-18 12:41:35'),
(16, 2, 54, 'I have inspected the heater in the math classroom and found a faulty thermostat. I have repaired it and tested the heater to ensure it is now heating the room correctly. Please let us know if the problem continues.', 1, 120, '2025-05-18 18:09:28'),
(17, 4, 53, 'I have inspected the heater in the math classroom and found a faulty thermostat. I have repaired it and tested the heater to ensure it is now heating the room correctly. Please let us know if the problem continues.', 1, 45, '2025-05-18 18:12:46');

-- --------------------------------------------------------

--
-- Estructura de la taula `DEPARTAMENT`
--

CREATE TABLE `DEPARTAMENT` (
  `cod_dept` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `DEPARTAMENT`
--

INSERT INTO `DEPARTAMENT` (`cod_dept`, `nom`) VALUES
(1, 'Angles'),
(2, 'Fisica'),
(3, 'L.cat'),
(4, 'Matematiques');

-- --------------------------------------------------------

--
-- Estructura de la taula `ESTAT`
--

CREATE TABLE `ESTAT` (
  `cod_estat` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `ESTAT`
--

INSERT INTO `ESTAT` (`cod_estat`, `nom`) VALUES
(1, 'En espera'),
(2, 'Revisant'),
(3, 'Solucionada');

-- --------------------------------------------------------

--
-- Estructura de la taula `INCIDENCIA`
--

CREATE TABLE `INCIDENCIA` (
  `Id` int(11) NOT NULL,
  `cod_dept` int(11) NOT NULL,
  `Descripcio` varchar(200) NOT NULL,
  `Data` datetime NOT NULL,
  `cod_estat` int(11) NOT NULL,
  `cod_tecnic` int(11) NOT NULL,
  `prioritat` enum('Sense asignar','Crítica','Alta','Moderada','Baixa') NOT NULL,
  `data_ini_sol` datetime DEFAULT NULL,
  `data_fi_sol` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `INCIDENCIA`
--

INSERT INTO `INCIDENCIA` (`Id`, `cod_dept`, `Descripcio`, `Data`, `cod_estat`, `cod_tecnic`, `prioritat`, `data_ini_sol`, `data_fi_sol`) VALUES
(1, 1, 'L\'ordinador de l\'aula 101 no encén.', '2024-05-10 08:15:00', 3, 1, 'Crítica', NULL, NULL),
(2, 2, 'Projector sense senyal a la sala de física.', '2024-05-11 09:30:00', 2, 3, 'Alta', '2024-05-11 10:00:00', NULL),
(3, 3, 'Fuites d\'aigua a la classe de català.', '2024-05-12 11:00:00', 3, 2, 'Moderada', '2024-05-12 12:00:00', '2024-05-13'),
(4, 4, 'Problemes amb la connexió WiFi.', '2024-05-14 12:45:00', 3, 1, 'Baixa', NULL, NULL),
(5, 1, 'Pissarra digital no funciona.', '2024-05-13 10:20:00', 3, 3, 'Alta', '2024-05-13 11:00:00', NULL),
(37, 2, 'Problema amb la connexió de xarxa del portàtil.', '2025-05-17 11:00:00', 1, 3, 'Alta', '2025-05-19 11:48:48', NULL),
(38, 4, 'Projector no reconeix senyal HDMI.', '2025-05-17 11:20:00', 2, 3, 'Moderada', '2025-05-17 11:30:00', NULL),
(39, 1, 'Ratolí sense resposta a l\'aula 102.', '2025-05-17 11:40:00', 3, 1, 'Baixa', '2025-05-17 12:00:00', '2025-05-17'),
(40, 3, 'Humitat a la paret del fons de la classe.', '2025-05-17 12:10:00', 2, 1, 'Moderada', '2025-05-17 12:30:00', NULL),
(41, 4, 'The door doesn\'t close properly', '2025-05-18 12:06:49', 3, 2, 'Moderada', '2025-05-18 12:38:25', '2025-05-18'),
(43, 4, 'The projector in the math classroom is not turning on. I have checked the power cable and the outlet, and everything seems fine.', '2025-05-18 17:52:33', 1, 0, 'Sense asignar', NULL, NULL),
(53, 4, 'The classroom whiteboard markers are dried out and unusable. This is making it difficult to write clearly during lessons. Please provide new markers as soon as possible.', '2025-05-18 18:06:13', 1, 4, 'Alta', '2025-05-18 18:11:55', NULL),
(54, 4, 'The classroom heater is not working properly and the room is very cold during lessons. Please check the heating system and fix it as soon as possible.', '2025-05-18 18:07:51', 3, 2, 'Alta', '2025-05-18 18:08:26', NULL);

-- --------------------------------------------------------

--
-- Estructura de la taula `TECNICS`
--

CREATE TABLE `TECNICS` (
  `cod_tecnic` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `TECNICS`
--

INSERT INTO `TECNICS` (`cod_tecnic`, `rol`, `nom`) VALUES
(0, 'Sense asignar', 'Cap'),
(1, 'Informatic', 'Ermengol '),
(2, 'Manteniment', 'Jorge López'),
(3, 'Multimedia', 'Nuria Rius'),
(4, 'Mediador/a', 'Sofia Vera');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `ACTUACIONS`
--
ALTER TABLE `ACTUACIONS`
  ADD PRIMARY KEY (`cod_act`),
  ADD KEY `cod_inci` (`cod_inci`),
  ADD KEY `cod_tecnic` (`cod_tecnic`);

--
-- Índexs per a la taula `DEPARTAMENT`
--
ALTER TABLE `DEPARTAMENT`
  ADD PRIMARY KEY (`cod_dept`);

--
-- Índexs per a la taula `ESTAT`
--
ALTER TABLE `ESTAT`
  ADD PRIMARY KEY (`cod_estat`);

--
-- Índexs per a la taula `INCIDENCIA`
--
ALTER TABLE `INCIDENCIA`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `cod_estat` (`cod_estat`),
  ADD KEY `cod_tecnic` (`cod_tecnic`),
  ADD KEY `INCIDENCIA_ibfk_3` (`cod_dept`);

--
-- Índexs per a la taula `TECNICS`
--
ALTER TABLE `TECNICS`
  ADD PRIMARY KEY (`cod_tecnic`),
  ADD KEY `nom` (`rol`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `ACTUACIONS`
--
ALTER TABLE `ACTUACIONS`
  MODIFY `cod_act` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la taula `DEPARTAMENT`
--
ALTER TABLE `DEPARTAMENT`
  MODIFY `cod_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la taula `INCIDENCIA`
--
ALTER TABLE `INCIDENCIA`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `ACTUACIONS`
--
ALTER TABLE `ACTUACIONS`
  ADD CONSTRAINT `actuacions_ibfk_1` FOREIGN KEY (`cod_inci`) REFERENCES `INCIDENCIA` (`Id`),
  ADD CONSTRAINT `actuacions_ibfk_2` FOREIGN KEY (`cod_tecnic`) REFERENCES `TECNICS` (`cod_tecnic`);

--
-- Restriccions per a la taula `INCIDENCIA`
--
ALTER TABLE `INCIDENCIA`
  ADD CONSTRAINT `INCIDENCIA_ibfk_1` FOREIGN KEY (`cod_estat`) REFERENCES `ESTAT` (`cod_estat`),
  ADD CONSTRAINT `INCIDENCIA_ibfk_2` FOREIGN KEY (`cod_tecnic`) REFERENCES `TECNICS` (`cod_tecnic`),
  ADD CONSTRAINT `INCIDENCIA_ibfk_3` FOREIGN KEY (`cod_dept`) REFERENCES `DEPARTAMENT` (`cod_dept`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
