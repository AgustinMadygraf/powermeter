--inst_bt_a1.sql
-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-10-2023 a las 16:56:35
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `powermeter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inst_bt_a1`
--

CREATE TABLE `inst_bt_a1` (
  `id` int(11) NOT NULL,
  `unixtime` int(16) NOT NULL,
  `potencia_r` float NOT NULL,
  `potencia_s` float NOT NULL,
  `potencia_t` float NOT NULL,
  `potencia_III` float GENERATED ALWAYS AS (((`potencia_r` + `potencia_s`) + `potencia_t`)) VIRTUAL,
  `datetime` datetime GENERATED ALWAYS AS (from_unixtime(`unixtime`)) VIRTUAL,
  `dia` int(11) GENERATED ALWAYS AS (dayofweek(from_unixtime(`unixtime`))) VIRTUAL,
  `v_r` float NOT NULL,
  `v_s` float NOT NULL,
  `v_t` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inst_bt_a1`
--

INSERT INTO `inst_bt_a1` (`id`, `unixtime`, `potencia_r`, `potencia_s`, `potencia_t`, `v_r`, `v_s`, `v_t`) VALUES
(0, 1696087800, 80, 80, 30, 230, 230, 230),
(1, 1666724400, 180, 70, 80, 230, 230, 230),
(2, 1666724700, 180, 70, 70, 230, 230, 230),
(3, 1666725000, 180, 70, 60, 230, 230, 230),
(4, 1666725300, 170, 60, 70, 230, 230, 230),
(5, 1666725600, 180, 50, 80, 230, 230, 230),
(6, 1666725900, 170, 60, 60, 230, 230, 230),
(7, 1666726200, 170, 70, 60, 230, 230, 230),
(8, 1666726500, 170, 60, 60, 230, 230, 230),
(9, 1666726800, 330, 200, 130, 230, 230, 230),
(10, 1666727100, 180, 80, 60, 230, 230, 230),
(11, 1666727400, 190, 60, 70, 230, 230, 230),
(12, 1666727700, 180, 70, 60, 230, 230, 230),
(13, 1666728000, 170, 70, 80, 230, 230, 230),
(14, 1666728300, 180, 70, 60, 230, 230, 230),
(15, 1666728600, 180, 50, 70, 230, 230, 230),
(16, 1666728900, 180, 70, 70, 230, 230, 230),
(17, 1666729200, 180, 60, 60, 230, 230, 230),
(18, 1666729500, 410, 230, 220, 230, 230, 230),
(19, 1666729800, 330, 170, 190, 230, 230, 230),
(20, 1666730100, 360, 210, 120, 230, 230, 230),
(21, 1666730400, 180, 80, 70, 230, 230, 230),
(22, 1666730700, 360, 190, 190, 230, 230, 230),
(23, 1666731000, 400, 240, 210, 230, 230, 230),
(24, 1666731300, 220, 90, 70, 230, 230, 230),
(25, 1666731600, 390, 230, 200, 230, 230, 230),
(26, 1666731900, 560, 380, 240, 230, 230, 230),
(27, 1666732200, 220, 90, 70, 230, 230, 230),
(28, 1666732500, 350, 210, 120, 230, 230, 230),
(29, 1666732800, 180, 50, 60, 230, 230, 230),
(30, 1666733100, 170, 60, 60, 230, 230, 230),
(31, 1666733400, 340, 200, 170, 230, 230, 230),
(32, 1666733700, 340, 200, 100, 230, 230, 230),
(33, 1666734000, 190, 60, 70, 230, 230, 230),
(34, 1666734300, 390, 230, 210, 230, 230, 230),
(35, 1666734600, 400, 280, 220, 230, 230, 230),
(36, 1666734900, 180, 60, 90, 230, 230, 230),
(37, 1666735200, 340, 210, 100, 230, 230, 230),
(38, 1666735500, 400, 230, 200, 230, 230, 230),
(39, 1666735800, 190, 70, 60, 230, 230, 230),
(40, 1666736100, 350, 210, 110, 230, 230, 230),
(41, 1666736400, 190, 70, 60, 230, 230, 230),
(42, 1666736700, 190, 70, 70, 230, 230, 230),
(43, 1666737000, 430, 280, 230, 230, 230, 230),
(44, 1666737300, 190, 60, 60, 230, 230, 230),
(45, 1666737600, 510, 390, 280, 230, 230, 230),
(46, 1666737900, 680, 490, 310, 230, 230, 230),
(47, 1666738200, 510, 330, 280, 230, 230, 230),
(48, 1666738500, 380, 250, 90, 230, 230, 230),
(49, 1666738800, 180, 80, 70, 230, 230, 230),
(50, 1666739100, 180, 70, 60, 230, 230, 230),
(51, 1666739400, 510, 340, 260, 230, 230, 230),
(52, 1666739700, 370, 220, 160, 230, 230, 230),
(53, 1666740000, 170, 50, 50, 230, 230, 230),
(54, 1666740300, 340, 220, 60, 230, 230, 230),
(55, 1666740600, 170, 70, 50, 230, 230, 230),
(56, 1666740900, 180, 60, 60, 230, 230, 230),
(57, 1666741200, 180, 80, 60, 230, 230, 230),
(58, 1666741500, 340, 210, 60, 230, 230, 230),
(59, 1666741800, 180, 70, 70, 230, 230, 230),
(60, 1666742100, 170, 70, 80, 230, 230, 230),
(61, 1666742400, 170, 50, 60, 230, 230, 230),
(62, 1666742700, 160, 60, 60, 230, 230, 230),
(63, 1666743000, 160, 60, 60, 230, 230, 230),
(64, 1666743300, 170, 60, 60, 230, 230, 230),
(65, 1666743600, 160, 60, 60, 230, 230, 230),
(66, 1666743900, 180, 60, 40, 230, 230, 230),
(67, 1666744200, 170, 80, 60, 230, 230, 230),
(68, 1666744500, 170, 50, 50, 230, 230, 230),
(69, 1666744800, 170, 50, 60, 230, 230, 230),
(70, 1666745100, 160, 70, 60, 230, 230, 230),
(71, 1666745400, 120, 60, 60, 230, 230, 230),
(72, 1666745700, 130, 60, 50, 230, 230, 230),
(73, 1666746000, 120, 60, 50, 230, 230, 230),
(74, 1666746300, 120, 60, 70, 230, 230, 230),
(75, 1666746600, 130, 40, 60, 230, 230, 230),
(76, 1666746900, 130, 50, 70, 230, 230, 230),
(77, 1666747200, 120, 60, 70, 230, 230, 230),
(78, 1666747500, 110, 60, 70, 230, 230, 230),
(79, 1666747800, 120, 70, 60, 230, 230, 230),
(80, 1666748100, 120, 40, 60, 230, 230, 230),
(81, 1666748400, 130, 60, 50, 230, 230, 230),
(82, 1666748700, 120, 60, 70, 230, 230, 230),
(83, 1666749000, 110, 60, 50, 230, 230, 230),
(84, 1666749300, 110, 60, 50, 230, 230, 230),
(85, 1666749600, 130, 50, 60, 230, 230, 230),
(86, 1666749900, 130, 50, 50, 230, 230, 230),
(87, 1666750200, 120, 50, 60, 230, 230, 230),
(88, 1666750500, 130, 60, 40, 230, 230, 230),
(89, 1666750800, 120, 50, 60, 230, 230, 230),
(90, 1666751100, 120, 60, 60, 230, 230, 230),
(91, 1666751400, 120, 60, 80, 230, 230, 230),
(92, 1666751700, 130, 70, 40, 230, 230, 230),
(93, 1666752000, 120, 60, 60, 230, 230, 230),
(94, 1666752300, 120, 50, 60, 230, 230, 230),
(95, 1666752600, 130, 40, 70, 230, 230, 230),
(96, 1666752900, 120, 70, 60, 230, 230, 230),
(97, 1666753200, 110, 50, 60, 230, 230, 230),
(98, 1666753500, 120, 60, 70, 230, 230, 230),
(99, 1666753800, 110, 40, 60, 230, 230, 230);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inst_bt_a1`
--
ALTER TABLE `inst_bt_a1` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inst_bt_a1`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
