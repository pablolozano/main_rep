-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2016 a las 21:38:42
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tesis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_session`
--

CREATE TABLE IF NOT EXISTS `login_session` (
  `username` varchar(60) NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT 'OFF',
  `ipAdd` varchar(60) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `login_session`
--

INSERT INTO `login_session` (`username`, `status`, `ipAdd`, `log_time`) VALUES
('admin', 'OFF', '', '2016-06-09 02:06:40'),
('PC2', 'ON', '127.0.0.1', '2016-06-09 02:06:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_status`
--

CREATE TABLE IF NOT EXISTS `login_status` (
  `id` mediumint(9) NOT NULL,
  `username` varchar(60) NOT NULL,
  `ipAdd` varchar(45) NOT NULL,
  `fecha` datetime NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `normalIP` varchar(45) DEFAULT NULL,
  `estatus` int(2) NOT NULL,
  `pass_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`, `normalIP`, `estatus`, `pass_time`) VALUES
('admin', 'root', '127.0.0.1', 0, NULL),
('PC1', 'pc1234', NULL, 0, NULL),
('PC2', 'pc1234', NULL, 1, '2016-06-09 00:04:32'),
('PC3', 'pc1234', NULL, 0, NULL),
('PC4', 'pc1234', NULL, 0, NULL),
('root', 'admin', NULL, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `login_session`
--
ALTER TABLE `login_session`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `login_status`
--
ALTER TABLE `login_status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `login_status`
--
ALTER TABLE `login_status`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
