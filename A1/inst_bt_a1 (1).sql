-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-10-2023 a las 01:47:14
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
(1, 1687411800, 40, 80, 40, 230, 230, 230),
(2, 1687412700, 10, 90, 10, 230, 230, 230),
(3, 1687413600, 40, 80, 40, 230, 230, 230),
(4, 1687414500, 40, 80, 30, 230, 230, 230),
(5, 1687415400, 50, 90, 40, 230, 230, 230),
(6, 1687416300, 50, 80, 40, 230, 230, 230),
(7, 1687417200, 40, 90, 30, 230, 230, 230),
(8, 1687418100, 50, 70, 40, 230, 230, 230),
(9, 1687419000, 40, 90, 20, 230, 230, 230),
(10, 1687419900, 40, 70, 40, 230, 230, 230),
(11, 1687420800, 30, 80, 10, 230, 230, 230),
(12, 1687421700, 40, 90, 30, 230, 230, 230),
(13, 1687422600, 40, 80, 20, 230, 230, 230),
(14, 1687423500, 50, 80, 40, 230, 230, 230),
(15, 1687424400, 50, 90, 30, 230, 230, 230),
(16, 1687425300, 40, 80, 40, 230, 230, 230),
(17, 1687426200, 40, 80, 40, 230, 230, 230),
(18, 1687427100, 40, 90, 30, 230, 230, 230),
(19, 1687428000, 40, 90, 40, 230, 230, 230),
(20, 1687428900, 50, 90, 40, 230, 230, 230),
(21, 1687429800, 40, 80, 40, 230, 230, 230),
(22, 1687430700, 50, 140, 40, 230, 230, 230),
(23, 1687431600, 40, 140, 40, 230, 230, 230),
(24, 1687432500, 40, 140, 40, 230, 230, 230),
(25, 1687433400, 40, 130, 40, 230, 230, 230),
(26, 1687434300, 100, 330, 220, 220, 230, 230),
(27, 1687435200, 80, 310, 230, 230, 230, 230),
(28, 1687436100, 90, 360, 270, 230, 230, 230),
(29, 1687437000, 30, 130, 50, 230, 230, 230),
(30, 1687437900, 80, 350, 280, 230, 230, 230),
(31, 1687438800, 80, 370, 250, 230, 230, 230),
(32, 1687439700, 90, 360, 260, 230, 230, 230),
(33, 1687440600, 90, 370, 250, 230, 230, 230),
(34, 1687441500, 80, 350, 260, 230, 230, 230),
(35, 1687442400, 90, 330, 230, 230, 230, 230),
(36, 1687443300, 50, 280, 190, 230, 230, 230),
(37, 1687444200, 40, 140, 40, 230, 230, 230),
(38, 1687445100, 80, 360, 280, 230, 230, 230),
(39, 1687446000, 40, 130, 30, 230, 230, 230),
(40, 1687446900, 50, 130, 40, 230, 230, 230),
(41, 1687447800, 40, 130, 50, 230, 230, 230),
(42, 1687448700, 40, 120, 30, 230, 230, 230),
(43, 1687449600, 40, 130, 40, 230, 230, 230),
(44, 1687450500, 30, 130, 30, 230, 230, 230),
(45, 1687451400, 50, 260, 160, 230, 230, 230),
(46, 1687452300, 50, 150, 60, 230, 230, 230),
(47, 1687453200, 50, 150, 50, 230, 230, 230),
(48, 1687454100, 50, 150, 60, 230, 230, 230),
(49, 1687455000, 50, 150, 50, 230, 230, 230),
(50, 1687455900, 40, 130, 40, 230, 230, 230);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inst_bt_a1`
--
ALTER TABLE `inst_bt_a1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inst_bt_a1`
--
ALTER TABLE `inst_bt_a1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14068;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
