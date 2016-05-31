-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2016 a las 17:44:08
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `login_session`
--

INSERT INTO `login_session` (`username`, `status`, `ipAdd`, `log_time`) VALUES
('admin', '', ':::1', '2016-05-31 15:24:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_status`
--

CREATE TABLE IF NOT EXISTS `login_status` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `ipAdd` varchar(45) NOT NULL,
  `fecha` datetime NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `login_status`
--

INSERT INTO `login_status` (`id`, `username`, `ipAdd`, `fecha`, `type`) VALUES
(5, 'admon', '::1', '2016-05-19 04:06:35', 'Not Found');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`) VALUES
('admin', 'root'),
('root', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
