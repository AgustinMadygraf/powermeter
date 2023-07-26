-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-07-2023 a las 04:07:17
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
-- Estructura de tabla para la tabla `histograma_inst_bt_a1`
--

CREATE TABLE `histograma_inst_bt_a1` (
  `id` int(11) NOT NULL,
  `potencia_w` float NOT NULL,
  `minutos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `histograma_inst_bt_a1`
--

INSERT INTO `histograma_inst_bt_a1` (`id`, `potencia_w`, `minutos`) VALUES
(1, 320, 660),
(2, 300, 1840),
(3, 280, 3325),
(4, 660, 105),
(5, 860, 120),
(6, 680, 65),
(7, 740, 60),
(8, 840, 140),
(9, 380, 245),
(10, 820, 135),
(11, 1180, 20),
(12, 700, 75),
(13, 640, 160),
(14, 900, 35),
(15, 940, 20),
(16, 1480, 10),
(17, 1120, 55),
(18, 720, 75),
(19, 1100, 125),
(20, 260, 1315),
(21, 620, 70),
(22, 600, 35),
(23, 240, 1210),
(24, 220, 3445),
(25, 200, 3915),
(26, 180, 9780),
(27, 800, 90),
(28, 1040, 45),
(29, 1060, 40),
(30, 1020, 35),
(31, 1000, 25),
(32, 1080, 80),
(33, 1420, 20),
(34, 1440, 35),
(35, 1900, 5),
(36, 1740, 15),
(37, 340, 745),
(38, 1280, 5),
(39, 1340, 5),
(40, 360, 270),
(41, 960, 35),
(42, 400, 210),
(43, 1140, 20),
(44, 7580, 5),
(45, 7420, 15),
(46, 7340, 20),
(47, 7400, 15),
(48, 3200, 5),
(49, 7720, 5),
(50, 580, 20),
(51, 7320, 10),
(52, 7360, 10),
(53, 920, 60),
(54, 7860, 15),
(55, 7660, 5),
(56, 7440, 15),
(57, 3120, 5),
(58, 7480, 25),
(59, 7500, 10),
(60, 7380, 5),
(61, 7980, 5),
(62, 5140, 5),
(63, 7520, 10),
(64, 7460, 10),
(65, 7600, 5),
(66, 420, 35),
(67, 7540, 5),
(68, 7880, 10),
(69, 7820, 5),
(70, 4760, 5),
(71, 6800, 5),
(72, 1840, 5),
(73, 8040, 10),
(74, 8020, 15),
(75, 1320, 10),
(76, 7740, 5),
(77, 1300, 5),
(78, 8100, 5),
(79, 1360, 20),
(80, 8140, 10),
(81, 1380, 15),
(82, 8060, 5),
(83, 2040, 5),
(84, 2260, 5),
(85, 7280, 15),
(86, 1860, 5),
(87, 7300, 5),
(88, 7240, 5),
(89, 540, 35),
(90, 480, 75),
(91, 760, 70),
(92, 500, 85),
(93, 1400, 20),
(94, 780, 70),
(95, 1520, 5),
(96, 1760, 25),
(97, 1780, 5),
(98, 1820, 5),
(99, 560, 15),
(100, 460, 65),
(101, 880, 80),
(102, 980, 5),
(103, 1240, 15),
(104, 1460, 10),
(105, 1660, 5),
(106, 1200, 10),
(107, 1160, 5),
(108, 1680, 5),
(109, 1500, 5),
(110, 1540, 5),
(111, 160, 13025),
(112, 140, 3045),
(113, 120, 290),
(114, 440, 55),
(115, 520, 30),
(116, 100, 25),
(117, 80, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `histograma_inst_bt_a1`
--
ALTER TABLE `histograma_inst_bt_a1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `histograma_inst_bt_a1`
--
ALTER TABLE `histograma_inst_bt_a1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
