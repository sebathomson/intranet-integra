-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-01-2013 a las 01:58:11
-- Versión del servidor: 5.5.25a
-- Versión de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `thomson_taller`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE IF NOT EXISTS `bodega` (
  `BODEGA_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UBICACION` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `DESCRIPCION_BOD` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`BODEGA_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=498 ;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`BODEGA_ID`, `UBICACION`, `DESCRIPCION_BOD`) VALUES
(1, 'Republica #238', 'Bodega de productos generales.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `CATEGORIA_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_CAT` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `DESCRIPCION_CAT` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`CATEGORIA_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`CATEGORIA_ID`, `NOMBRE_CAT`, `DESCRIPCION_CAT`) VALUES
(1, 'INFORMATICA', 'INFORMATICA'),
(2, 'ELECTRONICA', 'ELECTRONICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `RUT_CLI` varchar(15) CHARACTER SET latin1 NOT NULL,
  `NOMBRE_CLI` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `CORREO_CLI` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `DIRECCION_CLI` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `FONO_FIJO_CLI` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `FONO_MOVIL_CLI` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `ACTIVACION` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`RUT_CLI`),
  KEY `NOMBRE_CLI` (`NOMBRE_CLI`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`RUT_CLI`, `NOMBRE_CLI`, `CORREO_CLI`, `DIRECCION_CLI`, `FONO_FIJO_CLI`, `FONO_MOVIL_CLI`, `ACTIVACION`) VALUES
('17704026-6', 'Cristobal Pardo', 'Cristobal@pardo.cl', 'Su casa', '123456789', '123456789', 1),
('16717161-3', 'Juan Carlos Faundez', 'Juan_Carlos@faundez.cl', 'Su casa', '123456789', '123456789', 1),
('21791361-6', 'Sebastian Thomson', 'Sebastian@thomson.cl', 'Su casa', '12345678', '123456789', 1),
('8763864-2', 'Camilo Navarrete', 'Camilo@navarrete.cl', 'Su casa', '123456789', '123456789', 1),
('7605484-3', 'Geraldine', 'Geraldine@thomson.cl', 'asdasdasd', '123456789', '123456789', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE IF NOT EXISTS `contiene` (
  `BODEGA_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) NOT NULL,
  `STOCK` int(11) DEFAULT NULL,
  PRIMARY KEY (`BODEGA_ID`,`MATERIAL_ID`),
  KEY `FK_CONTIENE_MATERIAL` (`MATERIAL_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contiene`
--

INSERT INTO `contiene` (`BODEGA_ID`, `MATERIAL_ID`, `STOCK`) VALUES
(1, 1, 400),
(1, 2, 8800),
(1, 3, 100),
(1, 4, 270),
(1, 5, 680);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_material_obra`
--

CREATE TABLE IF NOT EXISTS `egreso_material_obra` (
  `BODEGA_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) NOT NULL,
  `OBRA_ID` int(11) NOT NULL,
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CANTIDAD` int(11) DEFAULT NULL,
  PRIMARY KEY (`BODEGA_ID`,`MATERIAL_ID`,`OBRA_ID`,`RUT_EMP`,`FECHA`),
  KEY `FK_EGRESO_MATERIAL_OBRA_EMPLEADO` (`RUT_EMP`),
  KEY `FK_EGRESO_MATERIAL_OBRA_MATERIAL` (`MATERIAL_ID`),
  KEY `FK_EGRESO_MATERIAL_OBRA_OBRA` (`OBRA_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `egreso_material_obra`
--

INSERT INTO `egreso_material_obra` (`BODEGA_ID`, `MATERIAL_ID`, `OBRA_ID`, `RUT_EMP`, `FECHA`, `CANTIDAD`) VALUES
(1, 1, 9, '15055435-7', '2011-11-29 21:43:07', 10),
(1, 3, 9, '15055435-7', '2011-11-29 21:43:07', 1),
(1, 1, 19, '17243834-2', '2012-09-02 01:30:10', 1),
(1, 1, 19, '17243834-2', '2012-09-02 01:30:24', 1),
(1, 1, 19, '17243834-2', '2012-09-02 01:37:21', 6),
(1, 1, 20, '17243834-2', '2012-09-02 21:06:53', 50),
(1, 4, 20, '17243834-2', '2012-09-02 21:06:55', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_material_venta`
--

CREATE TABLE IF NOT EXISTS `egreso_material_venta` (
  `BODEGA_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) NOT NULL,
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `VENTA_MATERIAL_ID` int(11) NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CANTIDAD` int(11) DEFAULT NULL,
  PRIMARY KEY (`BODEGA_ID`,`MATERIAL_ID`,`RUT_EMP`,`VENTA_MATERIAL_ID`),
  KEY `FK_EGRESO_MATERIAL_VENTA_EMPLEADO` (`RUT_EMP`),
  KEY `FK_EGRESO_MATERIAL_VENTA_MATERIAL` (`MATERIAL_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `egreso_material_venta`
--

INSERT INTO `egreso_material_venta` (`BODEGA_ID`, `MATERIAL_ID`, `RUT_EMP`, `VENTA_MATERIAL_ID`, `FECHA`, `CANTIDAD`) VALUES
(1, 2, '22052521-k', 8, '2011-11-30 16:10:25', 1241),
(1, 1, '22052521-k', 8, '2011-11-30 16:10:25', 30),
(1, 4, '15055435-7', 13, '2012-02-10 13:15:08', 1),
(1, 4, '15055435-7', 14, '2012-02-10 13:16:32', 1),
(1, 4, '15055435-7', 15, '2012-02-10 13:16:36', 1),
(1, 1, '15055435-7', 16, '2012-02-10 17:12:55', 59),
(1, 2, '22052521-k', 18, '2012-02-12 18:22:18', 100),
(1, 1, '15055435-7', 19, '2012-02-26 15:45:04', 100),
(1, 1, '15055435-7', 21, '2012-07-17 04:39:08', 100),
(1, 1, '15055435-7', 22, '2012-07-17 04:40:16', 400),
(1, 2, '15055435-7', 22, '2012-07-17 04:40:16', 600),
(1, 1, '17243834-2', 23, '2012-09-02 01:40:13', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `NOMBRE_EMP` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `APELLIDOM_EMP` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `APELLIDOP_EMP` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `CORREO_EMP` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `DIRECCION_EMP` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `FONO_FIJO_EMP` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `FONO_MOVIL_EMP` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `TIPO_EMP_ID` int(11) NOT NULL,
  `ACTIVACION` int(11) DEFAULT '1',
  PRIMARY KEY (`RUT_EMP`),
  KEY `FK_EMPLEADO_TIPOEMPLEADO` (`TIPO_EMP_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`RUT_EMP`, `NOMBRE_EMP`, `APELLIDOM_EMP`, `APELLIDOP_EMP`, `CORREO_EMP`, `DIRECCION_EMP`, `FONO_FIJO_EMP`, `FONO_MOVIL_EMP`, `TIPO_EMP_ID`, `ACTIVACION`) VALUES
('8861551-4', 'Abraham', 'Torres', 'Martinez', 'correo4@integraingenieria.cl', 'Pasaje4', '5561234', '71287316', 2, 1),
('5289722-k', 'Benjamin', 'Gonzalez', 'Fernandez', 'correo5@integraingenieria.cl', 'Pasaje5', '3786778', '78890116', 2, 1),
('18778395-k', 'Bruno', 'Romero', 'Garcia', 'correo6@integraingenieria.cl', 'Pasaje6', '4572340', '78163916', 2, 1),
('22052521-k', 'Abelardo', 'Molina', 'Aguirre', 'correo3@integraingenieria.cl', 'Pasaje3', '5566778', '78624516', 2, 1),
('15055435-7', 'Abel', 'Garcia', 'Lopez', 'correo2@integraingenieria.cl', 'Pasaje2', '5565478', '78623216', 1, 1),
('23160138-4', 'Aaron', 'Flores', 'Gonzalez', 'correo1@integraingenieria.cl', 'Pasaje1', '5566778', '78624516', 1, 1),
('17243834-2', 'Sebastian', 'Andres', 'Thomson', 'seba.thomson@gmail.com', 'mi casa laraara', '0255599999', '85844725', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_de_obra`
--

CREATE TABLE IF NOT EXISTS `empleado_de_obra` (
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OBRA_ID` int(11) NOT NULL,
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `PRIORIDAD` int(11) DEFAULT NULL,
  `ACTIVACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`OBRA_ID`,`RUT_EMP`),
  KEY `FK_EMPLEADO_DE_OBRA_EMPLEADO` (`RUT_EMP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado_de_obra`
--

INSERT INTO `empleado_de_obra` (`FECHA`, `OBRA_ID`, `RUT_EMP`, `PRIORIDAD`, `ACTIVACION`) VALUES
('2011-11-30 16:24:19', 11, '22052521-k', 0, 1),
('2011-11-29 20:52:19', 10, '22052521-k', 0, 1),
('2011-11-29 20:53:17', 10, '15055435-7', 1, 1),
('2011-11-29 20:54:39', 9, '8861551-4', 1, 1),
('2011-11-30 16:33:02', 12, '22052521-k', 0, 1),
('2011-11-30 16:35:57', 13, '22052521-k', 0, 1),
('2011-11-30 19:33:27', 15, '22052521-k', 1, 1),
('2011-11-30 19:33:43', 15, '8861551-4', 0, 0),
('2011-11-30 19:34:31', 14, '23247127-1', 1, 1),
('2011-11-30 19:34:56', 14, '18778395-k', 0, 1),
('2012-02-08 21:57:18', 11, '17243834-2', 1, 1),
('2012-02-08 22:17:14', 11, '15055435-7', 1, 0),
('2012-02-08 22:17:24', 11, '18778395-k', 0, 1),
('2012-08-30 19:24:06', 18, '17243834-2', 1, 1),
('2012-08-30 19:24:07', 18, '8861551-4', 0, 1),
('2012-09-01 19:07:19', 19, '8861551-4', 1, 0),
('2012-09-01 19:07:20', 19, '17243834-2', 0, 1),
('2012-09-02 21:03:07', 20, '8861551-4', 1, 1),
('2012-09-02 21:03:08', 20, '18778395-k', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_material_nuevo`
--

CREATE TABLE IF NOT EXISTS `ingreso_material_nuevo` (
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `MATERIAL_ID` int(11) NOT NULL,
  `RUT_PROV` varchar(15) CHARACTER SET latin1 NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MATERIAL_ID`,`RUT_PROV`),
  KEY `FK_INGRESO_MATERIAL_NUEVO_EMPLEADO` (`RUT_EMP`),
  KEY `FK_INGRESO_MATERIAL_NUEVO_PROVEEDOR` (`RUT_PROV`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingreso_material_nuevo`
--

INSERT INTO `ingreso_material_nuevo` (`RUT_EMP`, `MATERIAL_ID`, `RUT_PROV`, `FECHA`) VALUES
('17.243.834-2', 1, '17704026-6', '2011-11-21 20:08:41'),
('17.243.834-2', 2, '17704026-6', '2011-11-21 20:08:42'),
('17.243.834-2', 3, '17704026-6', '2011-11-21 20:08:43'),
('17.243.834-2', 4, '17704026-6', '2011-11-21 20:08:44'),
('17.243.834-2', 5, '17704026-6', '2011-11-21 20:08:45'),
('15055435-7', 137, '17704026-6', '2012-01-22 17:39:40'),
('15055435-7', 135, '21791361-6', '2012-01-22 15:25:28'),
('15055435-7', 134, '16717161-3', '2012-01-22 15:15:07'),
('15055435-7', 133, '17704026-6', '2012-01-22 15:13:51'),
('15055435-7', 132, '21791361-6', '2012-01-22 02:34:53'),
('15055435-7', 131, '8763864-2', '2012-01-22 02:33:52'),
('15055435-7', 130, '8763864-2', '2012-01-22 02:33:27'),
('5289722-k', 138, '21791361-6', '2012-02-23 17:37:48'),
('5289722-k', 139, '16717161-3', '2012-02-23 18:06:25'),
('5289722-k', 140, '16717161-3', '2012-02-23 18:07:13'),
('5289722-k', 141, '16717161-3', '2012-02-23 18:11:03'),
('5289722-k', 142, '17704026-6', '2012-02-23 18:12:12'),
('5289722-k', 143, '17704026-6', '2012-02-23 18:13:10'),
('5289722-k', 144, '21791361-6', '2012-02-23 18:14:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_material_obra`
--

CREATE TABLE IF NOT EXISTS `ingreso_material_obra` (
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `BODEGA_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) NOT NULL,
  `OBRA_ID` int(11) NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`RUT_EMP`,`BODEGA_ID`,`MATERIAL_ID`,`OBRA_ID`),
  KEY `FK_INGRESO_MATERIAL_OBRA_BODEGA` (`BODEGA_ID`),
  KEY `FK_INGRESO_MATERIAL_OBRA_MATERIAL` (`MATERIAL_ID`),
  KEY `FK_INGRESO_MATERIAL_OBRA_OBRA` (`OBRA_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `MATERIAL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUB_CAT_ID` int(11) DEFAULT NULL,
  `NOMBRE_MAT` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `IMAGEN_MAT` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `Descripcion_Mat` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`MATERIAL_ID`),
  KEY `FK_MATERIAL_SUBCATEGORIA` (`SUB_CAT_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=145 ;

--
-- Volcado de datos para la tabla `material`
--

INSERT INTO `material` (`MATERIAL_ID`, `SUB_CAT_ID`, `NOMBRE_MAT`, `IMAGEN_MAT`, `Descripcion_Mat`) VALUES
(1, 2, 'TAPA TERMINAL 10MM', 'no_imagen.jpg', 'TAPA TERMINAL 10MM'),
(2, 2, 'PET-010 TEMPORIZADOR SEMANAL ', 'mat_2.jpg', 'PET-010 TEMPORIZADOR MENSUAL'),
(3, 2, 'CAMBIADOR TELEF MANUAL 2 POSIC', 'mat_3.jpg', 'CAMBIADOR TELEF MANUAL 2 POSICIONES '),
(4, 2, 'CABLE PARA KVM 1.8-MT DKVM-CB-', 'no_imagen.jpg', 'CABLE PARA KVM 1.8-MT DKVM-CB-6 '),
(5, 1, 'JL46053A CABLE DE RED 5M AMARI', 'no_imagen.jpg', 'JL46053A CABLE DE RED 5M AMARILLO 24AWG CAT5E ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra`
--

CREATE TABLE IF NOT EXISTS `obra` (
  `OBRA_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SERVICIO_ID` int(11) DEFAULT NULL,
  `DESCRIPCION_OBR` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `NOMBRE_OBR` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `FECHA_INI` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ESTADO` varchar(20) CHARACTER SET latin1 DEFAULT '0',
  PRIMARY KEY (`OBRA_ID`),
  KEY `FK_OBRA_SERVICIO` (`SERVICIO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `obra`
--

INSERT INTO `obra` (`OBRA_ID`, `SERVICIO_ID`, `DESCRIPCION_OBR`, `NOMBRE_OBR`, `FECHA_INI`, `ESTADO`) VALUES
(10, 17, 'desca Testeando', 'Testeando', '2011-11-29 20:50:24', '0'),
(9, 17, 'DescripciÃ³n Obra...2', 'Obra01 para Servicio 15', '2012-02-08 18:18:42', '1'),
(14, 25, 'DescripciÃ³n Obra...', 'Obra 17', '2011-11-30 19:32:46', '0'),
(15, 25, 'DescripciÃ³n Obra...', 'Obra 23', '2011-11-30 19:33:03', '1'),
(18, 28, 'InstalaciÃ³n de los pilares', 'Instalar pilares', '2012-08-30 19:23:12', '1'),
(19, 29, 'DescripciÃ³n Obra...', 'Instalar pilares', '2012-09-01 19:06:41', '0'),
(20, 30, 'InstalaciÃ³n de los pilares.', 'Instalar pilares', '2012-09-02 21:02:25', '0'),
(21, 27, 'DescripciÃ³n Obrakk...', 'crear testeando', '2013-01-27 00:52:58', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `RUT_PROV` varchar(15) CHARACTER SET latin1 NOT NULL,
  `NOMBRE_PROV` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `CORREO_PROV` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `DIRECCION_PROV` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `FONO_FIJO_PROV` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `FONO_MOVIL_PROV` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `ACTIVACION` int(11) DEFAULT '1',
  PRIMARY KEY (`RUT_PROV`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`RUT_PROV`, `NOMBRE_PROV`, `CORREO_PROV`, `DIRECCION_PROV`, `FONO_FIJO_PROV`, `FONO_MOVIL_PROV`, `ACTIVACION`) VALUES
('17704026-6', 'Cristobal Pardo', 'Cristobal@pardo.cl', 'Su casa', '123456789', '123456789', 1),
('16717161-3', 'Juan Carlos Faundez', 'Juan_Carlos@faundez.cl', 'Su casa', '123456789', '123456789', 1),
('21791361-6', 'Sebastian Thomson', 'Sebastian@thomson.cl', 'Su casa', '123456789', '123456789', 1),
('8763864-2', 'Camilo Navarrete', 'Camilo@navarrete.cl', 'Su casa', '123456789', '123456789', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE IF NOT EXISTS `servicio` (
  `SERVICIO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `DESCRIPCION` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`SERVICIO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`SERVICIO_ID`, `NOMBRE`, `DESCRIPCION`) VALUES
(17, 'Construir CASA', 'DescripciÃ³n servicio...'),
(21, 'Construir Casa', 'Construir Casa'),
(22, 'Construir Edificio3', 'Construir edificio de 125 pisos'),
(23, 'ConstrucciÃ³n de Edificio', 'Construir Edificio en Republica #448'),
(24, 'ConstrucciÃ³n de Edificio', 'Construir edificio en Republica #443'),
(25, 'Pasar de curso', 'DescripciÃ³n servicio...'),
(26, 'Servicio tester', 'DescripciÃ³n servicio...'),
(27, 'Terra', 'aaDescripciÃ³n servicio...'),
(28, 'ConstrucciÃ³n edificio', 'Se construirÃ¡ un edificio'),
(29, 'ConstrucciÃ³n edificio', 'ConstrucciÃ³n del edificio.'),
(30, 'ConstrucciÃ³n de edificio', 'Construir un edificio.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categoria`
--

CREATE TABLE IF NOT EXISTS `sub_categoria` (
  `SUB_CAT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORIA_ID` int(11) DEFAULT NULL,
  `NOMBRE_SUB_CAT` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `DESCRIPCION_SUB_CAT` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`SUB_CAT_ID`),
  KEY `FK_SUBCATEGORIA_CATEGORIA` (`CATEGORIA_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `sub_categoria`
--

INSERT INTO `sub_categoria` (`SUB_CAT_ID`, `CATEGORIA_ID`, `NOMBRE_SUB_CAT`, `DESCRIPCION_SUB_CAT`) VALUES
(1, 1, 'SINFORMATICA', 'SINFORMATICA'),
(2, 2, 'ELECTRONICA', 'ELECTRONICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empleado`
--

CREATE TABLE IF NOT EXISTS `tipo_empleado` (
  `TIPO_EMP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_TIPO_EMP` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`TIPO_EMP_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo_empleado`
--

INSERT INTO `tipo_empleado` (`TIPO_EMP_ID`, `NOMBRE_TIPO_EMP`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'VENDEDOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `TIPO_USUARIO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_TIPO_USUARIO` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `OBSERVACION_TIPO_USUARIO` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`TIPO_USUARIO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`TIPO_USUARIO_ID`, `NOMBRE_TIPO_USUARIO`, `OBSERVACION_TIPO_USUARIO`) VALUES
(1, 'ADMINISTRADOR', 'ADMINISTRADOR'),
(2, 'VENDEDOR', 'VENDEDOR'),
(3, 'NORMAL', 'NORMAL'),
(4, 'BODEGUERO', 'BODEGUERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `USERNAME` varchar(30) CHARACTER SET latin1 NOT NULL,
  `PASS` varchar(70) DEFAULT NULL,
  `TIPO_USUARIO_ID` int(11) DEFAULT NULL,
  `ACTIVACION` int(11) DEFAULT NULL,
  PRIMARY KEY (`USERNAME`),
  KEY `FK_USUARIO_EMPLEADO` (`RUT_EMP`),
  KEY `FK_USUARIO_TIPOUSUARIO` (`TIPO_USUARIO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`RUT_EMP`, `USERNAME`, `PASS`, `TIPO_USUARIO_ID`, `ACTIVACION`) VALUES
('17243834-2', 'admintester', '2742a284f3a438ae0a790125d9cfe892', 1, 1),
('22052521-k', 'vendedortester', 'e28778b4c521194d76fdad3a1563d30c', 2, 1),
('8861551-4', 'normaltester', '63b98636f056dbd84cd2c45a99ad67f7', 3, 1),
('5289722-k', 'bodegatester', '5241a673dd42fd2a1b6bdddee80e29d7', 4, 1),
('18778395-k', 'sebathomson', '18778395k', 1, 1),
('23160138-4', 'sthomson', '3b4f20f27314e2bbd8d93f2cbea0e3', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_de_material`
--

CREATE TABLE IF NOT EXISTS `venta_de_material` (
  `VENTA_MATERIAL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `RUT_CLI` varchar(15) NOT NULL,
  `RUT_EMP` varchar(15) NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`VENTA_MATERIAL_ID`),
  KEY `FK_VENTA_DE_MATERIAL` (`RUT_CLI`),
  KEY `FK_VENTA_DE_MATERIAL_EMPLEADO` (`RUT_EMP`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `venta_de_material`
--

INSERT INTO `venta_de_material` (`VENTA_MATERIAL_ID`, `RUT_CLI`, `RUT_EMP`, `FECHA`) VALUES
(8, '8.711.342-6', '22052521-k', '2011-11-30 16:10:24'),
(13, '17243834-2', '15055435-7', '2012-02-10 13:15:08'),
(14, '17243834-2', '15055435-7', '2012-02-10 13:16:32'),
(15, '17243834-2', '15055435-7', '2012-02-10 13:16:36'),
(16, '17243834-2', '15055435-7', '2012-02-10 17:12:55'),
(17, '17243834-2', '15055435-7', '2012-02-10 17:25:09'),
(18, '5590749-8', '22052521-k', '2012-02-12 18:22:18'),
(19, '7605484-3', '15055435-7', '2012-02-26 15:45:04'),
(20, '17243834-2', '15055435-7', '2012-07-17 04:27:13'),
(21, '17243834-2', '15055435-7', '2012-07-17 04:39:08'),
(22, '17243834-2', '15055435-7', '2012-07-17 04:40:16'),
(23, '17243834-2', '17243834-2', '2012-09-02 01:40:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_de_servicio`
--

CREATE TABLE IF NOT EXISTS `venta_de_servicio` (
  `SERVICIO_ID` int(11) NOT NULL,
  `RUT_CLI` varchar(15) CHARACTER SET latin1 NOT NULL,
  `RUT_EMP` varchar(15) CHARACTER SET latin1 NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`SERVICIO_ID`,`RUT_CLI`,`RUT_EMP`,`FECHA`),
  KEY `FK_VENTA_DE_SERVICIO_CLIENTE` (`RUT_CLI`),
  KEY `FK_VENTA_DE_SERVICIO_EMPLEADO` (`RUT_EMP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta_de_servicio`
--

INSERT INTO `venta_de_servicio` (`SERVICIO_ID`, `RUT_CLI`, `RUT_EMP`, `FECHA`) VALUES
(17, '8763864-2', '15055435-7', '2011-11-29 05:08:33'),
(25, '16717161-3', '15055435-7', '2011-11-30 19:32:25'),
(27, '17704026-6', '15055435-7', '2012-02-07 15:13:51'),
(28, '8763864-2', '15055435-7', '2012-08-30 19:22:15'),
(29, '16717161-3', '17243834-2', '2012-09-01 19:05:53'),
(30, '16717161-3', '17243834-2', '2012-09-02 21:01:02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
