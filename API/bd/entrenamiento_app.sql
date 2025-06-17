-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2025 a las 18:37:44
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `entrenamiento_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

CREATE TABLE `historico` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `escenario` varchar(1) DEFAULT NULL,
  `cluster` int(11) DEFAULT NULL,
  `calorias` float DEFAULT NULL,
  `datos_json` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historico`
--

INSERT INTO `historico` (`id`, `user_id`, `fecha`, `escenario`, `cluster`, `calorias`, `datos_json`) VALUES
(1, 2, '2025-06-11 14:10:33', 'C', NULL, 786.01, '{\"edad\":25,\"peso\":75,\"altura\":1.74,\"bmi\":15,\"grasa\":18,\"experiencia\":3,\"frecuencia\":2,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":74,\"duracion\":1,\"agua\":1,\"cardio\":0,\"hiit\":0,\"strength\":0,\"yoga\":1}'),
(3, 2, '2025-06-11 14:28:23', 'A', 1, 1072.72, '{\"edad\":50,\"peso\":78,\"altura\":1.75,\"bmi\":18,\"grasa\":15,\"experiencia\":2,\"frecuencia\":2,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":70,\"duracion\":1.5,\"agua\":1,\"cardio\":1,\"hiit\":0,\"strength\":0,\"yoga\":0}'),
(4, 8, '2025-06-11 14:43:25', 'B', NULL, 798.14, '{\"edad\":28,\"peso\":96,\"altura\":1.86,\"bmi\":28,\"grasa\":15,\"experiencia\":2,\"frecuencia\":3,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":75,\"duracion\":1,\"agua\":1.5,\"cardio\":1,\"hiit\":0,\"strength\":0,\"yoga\":0}'),
(5, 8, '2025-06-11 14:44:18', 'A', 0, 802.59, '{\"edad\":28,\"peso\":96,\"altura\":1.86,\"bmi\":15,\"grasa\":15,\"experiencia\":2,\"frecuencia\":3,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":75,\"duracion\":1,\"agua\":1,\"cardio\":1,\"hiit\":0,\"strength\":0,\"yoga\":0}'),
(6, 3, '2025-06-11 15:02:27', 'A', 0, 780.55, '{\"edad\":28,\"peso\":70,\"altura\":1.75,\"bmi\":21,\"grasa\":10,\"experiencia\":2,\"frecuencia\":3,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":75,\"duracion\":1,\"agua\":1,\"cardio\":1,\"hiit\":0,\"strength\":0,\"yoga\":0}'),
(7, 3, '2025-06-11 15:03:11', 'B', NULL, 820.78, '{\"edad\":28,\"peso\":70,\"altura\":1.75,\"bmi\":21,\"grasa\":10,\"experiencia\":2,\"frecuencia\":3,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":75,\"duracion\":1,\"agua\":1,\"cardio\":1,\"hiit\":0,\"strength\":0,\"yoga\":0}'),
(8, 3, '2025-06-11 15:04:55', 'C', NULL, 943.95, '{\"edad\":28,\"peso\":70,\"altura\":1.75,\"bmi\":21,\"grasa\":10,\"experiencia\":2,\"frecuencia\":3,\"max_bpm\":180,\"avg_bpm\":150,\"resting_bpm\":75,\"duracion\":1,\"agua\":1,\"cardio\":1,\"hiit\":0,\"strength\":0,\"yoga\":0}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$Q7xTBaPvsAyGfubFfwJDPu8fyWICRoNRbr9YzSrk/mI.YsXvBs7FW'),
(3, 'Carlos', '$2y$10$mwY0S2zJf015ThsRujNyNeCWSuOIEKTjg5v8QffbC0JWAaJSWHuDe'),
(6, 'Carlos7', '$2y$10$CHq/alxpO7CJiWiLvxsS8.hNKyPIYhugxiriL0or5EdeGZmZsOmjG'),
(7, 'Javi1', '$2y$10$njAvKUxZISAMJKU5ckgEuu0iqzrinPk8EhOeJlnCLrpw7ySvihxwS'),
(8, 'Carlos77', '$2y$10$2RxqrKHwnCAm05A5lZqrL.qYSfm/OsEDQqD1hOHOmcKVQNx8wXEPC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
