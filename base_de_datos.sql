-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.17-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para licorland
DROP DATABASE IF EXISTS `licorland`;
CREATE DATABASE IF NOT EXISTS `licorland` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `licorland`;

-- Volcando estructura para tabla licorland.caja
DROP TABLE IF EXISTS `caja`;
CREATE TABLE IF NOT EXISTS `caja` (
  `caja_id` int(11) NOT NULL AUTO_INCREMENT,
  `caja_nombre` varchar(50) NOT NULL,
  `caja_numero` varchar(10) NOT NULL,
  `caja_folio` varchar(50) NOT NULL DEFAULT '1',
  `caja_state` tinyint(4) NOT NULL DEFAULT 1,
  `caja_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `caja_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`caja_id`),
  UNIQUE KEY `UQ_numero` (`caja_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.caja: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
REPLACE INTO `caja` (`caja_id`, `caja_nombre`, `caja_numero`, `caja_folio`, `caja_state`, `caja_creation`, `caja_update`) VALUES
	(0, 'Ninguno', '0', '1', 1, '2021-04-24 15:22:51', NULL),
	(1, 'Caja Nva Cajamarca', '1', '1', 1, '2021-04-01 12:12:51', '2021-04-30 18:26:06'),
	(2, 'Caja Rioja - Centro', '2', '1', 1, '2021-04-01 12:13:15', '2021-04-18 17:55:39'),
	(4, 'Caja Rioja - Av. Independientes', '3', '1', 1, '2021-04-18 17:08:05', '2021-04-24 15:31:06');
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(50) NOT NULL DEFAULT '',
  `categoria_state` tinyint(4) NOT NULL DEFAULT 1,
  `categoria_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.categoria: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
REPLACE INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_state`, `categoria_creation`, `categoria_update`) VALUES
	(1, 'Whisky´s', 1, '2021-03-29 19:49:59', '2021-06-23 09:25:04'),
	(2, 'Vodka´s', 1, '2021-04-17 15:43:25', '2021-06-23 09:25:14'),
	(3, 'Vino´s', 1, '2021-04-18 10:45:11', '2021-06-23 09:25:25'),
	(9, 'Ron´s', 1, '2021-04-30 20:55:35', '2021-06-23 09:25:47'),
	(10, 'Pisco´s', 1, '2021-06-23 09:25:57', '2021-06-23 09:26:10'),
	(11, 'Aguas y energizantes', 1, '2021-06-23 09:26:31', '2021-06-23 09:26:31');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nombre` varchar(100) NOT NULL,
  `cliente_direccion` varchar(150) DEFAULT NULL,
  `cliente_telefono` varchar(20) DEFAULT NULL,
  `cliente_razonsocial` varchar(100) DEFAULT NULL,
  `cliente_dni` varchar(15) DEFAULT NULL,
  `cliente_correo` varchar(50) DEFAULT NULL,
  `cliente_state` tinyint(4) NOT NULL DEFAULT 1,
  `cliente_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `cliente_update` timestamp NULL DEFAULT NULL,
  `cliente_documento` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.cliente: ~19 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
REPLACE INTO `cliente` (`cliente_id`, `cliente_nombre`, `cliente_direccion`, `cliente_telefono`, `cliente_razonsocial`, `cliente_dni`, `cliente_correo`, `cliente_state`, `cliente_creation`, `cliente_update`, `cliente_documento`) VALUES
	(1, 'VARIOS', 'NVA CAJAMARCA', '', '', '12345678', '', 0, '2021-04-18 14:01:38', '2021-07-04 18:42:54', 'DNI'),
	(8, 'GUILLERMO MUNAYLLA AYME', 'Jr. Cajamarca', '926458741', 'MUNAYLLA AYME', '48591526', 'jorgechavez@gmail.com', 1, '2021-04-18 12:48:23', '2021-06-26 23:43:02', 'DNI'),
	(36, 'CRISTIAN JERRY FERNANDEZ DAVILA', 'J.r 20 de abril s/n', '929429741', 'FERNANDEZ DAVILA', '48613344', 'cristianfd27@gmail.com', 1, '2021-05-01 14:58:53', '2021-07-04 18:47:48', 'DNI'),
	(37, 'FREDDY JOSIAS HERRERA BECERRA', '', '928587123', 'HERRERA BECERRA', '70616828', '', 1, '2021-06-21 19:18:22', '2021-07-04 18:48:23', 'DNI'),
	(39, 'TOP RANK PUBLICIDAD S.A.C.', 'AV. BENAVIDES NRO. 4981 URB. LAS GARDENIAS LIMA LIMA SANTIAGO DE SURCO', '', NULL, '20133877615', '', 1, '2021-06-26 21:48:48', '2021-06-26 23:44:32', 'RUC'),
	(40, 'CARLA ISABEL VALVERDE DEL AGUILA', 'JR AMORARCA - MORALES - SAN MARTIN', '', NULL, '71001085', 'carla@gmail.com', 1, '2021-07-03 16:06:59', '2021-07-03 16:06:59', 'DNI'),
	(41, 'VLADIMIR ANTONIO CULQUI PANDURO', 'AV. LIMA #490 - JUANJUI - SAN MARTIN ', '', NULL, '75966392', 'culqui@gmail.com', 1, '2021-07-03 16:07:46', '2021-07-04 18:44:42', 'DNI'),
	(42, 'LUIS JACK CASTAÑEDA PINEDO', 'J.r callao #666', '', NULL, '70935008', 'jack12@gmail.com', 1, '2021-07-04 18:41:04', '2021-07-04 18:41:04', 'DNI'),
	(43, 'MIGUEL ANGEL PERDOMO CACHIQUE', 'J.r Alfonso Ugarte #767', '918213421', NULL, '73989678', '', 1, '2021-07-04 18:42:48', '2021-07-04 18:42:48', 'DNI'),
	(44, 'ROCKY JEANS FERNANDEZ DAVILA', 'J.r Serafin Filomeno #667', '982044689', NULL, '46896617', '', 1, '2021-07-04 18:44:04', '2021-07-04 18:44:04', 'DNI'),
	(45, 'CORPORACION FERRETERA ADRIANO E.I.R.L.', 'JR. SERAFIN FILOMENO NRO. 709 SAN MARTIN MOYOBAMBA MOYOBAMBA', '', NULL, '20601660246', '', 1, '2021-07-04 18:45:19', '2021-07-04 18:45:19', 'RUC'),
	(46, 'DAVILA VASQUEZ GEORGINA', 'A.v Cajamarca sur #549', '988026758', NULL, '10010490621', '', 1, '2021-07-04 18:46:12', '2021-07-04 18:46:12', 'RUC'),
	(47, 'VALVERDE FEBRES WILFREDO', '', '', NULL, '10062794165', 'valfebres@gmail.com', 1, '2021-07-04 18:47:10', '2021-07-04 18:47:10', 'RUC'),
	(48, 'KELLER KATLIN PINEDO TOCAS', '', '935064473', NULL, '72876686', '', 1, '2021-07-04 19:16:08', '2021-07-04 19:16:08', 'DNI'),
	(49, 'HARRIET BEECHER FLORES LUNA', 'J.r Huallacho #878', '936705985', NULL, '72888906', 'larry23@gmail.com', 1, '2021-07-04 19:17:33', '2021-07-04 19:17:33', 'DNI'),
	(50, 'MARCELO LEANDRO GUERRA SAAVEDRA', '', '942764678', NULL, '70161862', 'marcelo123@gmail.com', 1, '2021-07-04 19:18:31', '2021-07-04 19:18:31', 'DNI'),
	(51, 'JORDI FRANCO RODRIGUEZ WILHEM', 'J.r Pedro Ruiz #899', '987564354', NULL, '77423166', '', 1, '2021-07-04 19:19:04', '2021-07-04 19:19:04', 'DNI'),
	(52, 'ABNER ROJAS PAZ', '', '942678767', NULL, '71503874', 'abner98@gmail.com', 1, '2021-07-04 19:20:13', '2021-07-04 19:20:13', 'DNI'),
	(53, 'HAROLD FRETH SANGAMA LOPEZ', 'J.r los angeles #999', '942348767', NULL, '72812808', 'fredd10@gmail.com', 1, '2021-07-04 20:34:03', '2021-07-04 20:34:03', 'DNI');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.compra
DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `compra_folio` varchar(15) NOT NULL,
  `compra_total` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `compra_ustate` tinyint(4) NOT NULL DEFAULT 1,
  `compra_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `compra_proveedor` varchar(150) NOT NULL,
  `compra_tipodoc` varchar(50) NOT NULL,
  `compra_numerodoc` varchar(50) NOT NULL,
  `compra_fechadoc` date NOT NULL DEFAULT sysdate(),
  `compra_igv` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`compra_id`),
  KEY `FK_usuario_compra` (`usuario_id`),
  CONSTRAINT `FK_usuario_compra` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.compra: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
REPLACE INTO `compra` (`compra_id`, `compra_folio`, `compra_total`, `usuario_id`, `compra_ustate`, `compra_creation`, `compra_proveedor`, `compra_tipodoc`, `compra_numerodoc`, `compra_fechadoc`, `compra_igv`) VALUES
	(19, '608cc9950ecd1', 0.00, 8, 1, '2020-08-01 11:00:36', 'PROVEEDORES VARIOS', 'FACTURA', '1', '2021-06-28', 1),
	(20, '608d65b91d1b0', 135.00, 8, 0, '2020-09-07 19:29:44', 'PROVEEDORES VARIOS', 'FACTURA', '2', '2021-06-28', 1),
	(21, '608dd082c2fed', 180.00, 8, 1, '2020-10-01 17:06:00', 'PROVEEDORES VARIOS', 'FACTURA', '3', '2021-06-28', 1),
	(22, '60be86e108606', 2397.00, 8, 1, '2020-11-07 19:53:27', 'PROVEEDORES VARIOS', 'FACTURA', '4', '2021-06-28', 0),
	(23, '60ce783e1687d', 2547.00, 8, 0, '2020-12-19 18:07:12', 'PROVEEDORES VARIOS', 'FACTURA', '5', '2021-06-28', 1),
	(24, '60ce7974d380e', 4245.00, 8, 1, '2021-01-19 18:11:06', 'PROVEEDORES VARIOS', 'FACTURA', '6', '2021-06-28', 0),
	(25, '60da6c87d8db5', 3.00, 8, 1, '2021-02-27 19:49:20', 'PROVEEDORES VARIOS', 'FACTURA', '7', '2021-06-28', 0),
	(26, '60de31f390ddd', 2098.00, 8, 1, '2021-03-01 16:25:32', 'TOP RANK PUBLICIDAD S.A.C.', 'FACTURA', '33', '2021-06-30', 0),
	(27, '60e24030d0e10', 282.00, 8, 1, '2021-04-04 18:15:10', 'HERRERA BECERRA FREDDY JOSIAS', 'FACTURA', '25', '2021-07-02', 0),
	(28, '60e2493416817', 2987.94, 8, 1, '2021-05-04 18:58:23', 'VALVERDE FEBRES WILFREDO', 'BOLETA', '30', '2021-06-20', 0),
	(29, '60e24b5b71324', 1841.94, 8, 1, '2021-06-04 19:02:17', 'DAVILA VASQUEZ GEORGINA', 'FACTURA', '31', '2021-06-22', 0),
	(30, '60e24c6be5f7c', 916.94, 8, 1, '2021-07-04 19:08:21', 'CORPORACION FERRETERA ADRIANO E.I.R.L.', 'FACTURA', '32', '2021-06-28', 0);
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.configuracion
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `configuracion_id` int(11) NOT NULL AUTO_INCREMENT,
  `configuracion_nombre` varchar(50) NOT NULL,
  `configuracion_valor` varchar(100) NOT NULL,
  PRIMARY KEY (`configuracion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.configuracion: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
REPLACE INTO `configuracion` (`configuracion_id`, `configuracion_nombre`, `configuracion_valor`) VALUES
	(1, 'nombre_tienda', 'Licorland'),
	(2, 'tienda_ruc', '20706168281'),
	(3, 'tienda_telefono', '928587145'),
	(4, 'tienda_email', 'licorland.bebidas@gmail.com'),
	(5, 'tienda_direccion', 'Av. Grau #377'),
	(6, 'ticket_leyenda', 'Gracias por comprar en Licorland'),
	(7, 'tienda_logo', '20210619_155656_logotienda.png');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.det_compra
DROP TABLE IF EXISTS `det_compra`;
CREATE TABLE IF NOT EXISTS `det_compra` (
  `det_compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `det_compra_cantidad` int(11) NOT NULL,
  `det_compra_nombre` varchar(200) NOT NULL,
  `det_compra_precio` decimal(10,2) NOT NULL,
  `det_compra_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`det_compra_id`),
  KEY `FK_compra_det_compra` (`compra_id`),
  KEY `FK_producto_det_compra` (`producto_id`),
  CONSTRAINT `FK_compra_det_compra` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`compra_id`),
  CONSTRAINT `FK_producto_det_compra` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.det_compra: ~38 rows (aproximadamente)
/*!40000 ALTER TABLE `det_compra` DISABLE KEYS */;
REPLACE INTO `det_compra` (`det_compra_id`, `compra_id`, `producto_id`, `det_compra_cantidad`, `det_compra_nombre`, `det_compra_precio`, `det_compra_creation`) VALUES
	(30, 19, 21, 1, 'Redmi Note 8 Negro', 849.00, '2021-05-01 08:00:36'),
	(31, 19, 25, 2, 'Producto Prueba 3', 90.00, '2021-05-01 08:00:36'),
	(32, 19, 26, 4, 'Producto Prueba 2', 14.00, '2021-05-01 08:00:36'),
	(33, 20, 24, 150, 'Recarga Bitel', 0.90, '2021-05-01 09:29:44'),
	(34, 21, 25, 2, 'Producto Prueba 3', 90.00, '2021-05-01 17:06:00'),
	(35, 22, 20, 3, 'Redmi Note 8 Blanco', 799.00, '2021-06-07 15:53:27'),
	(36, 23, 21, 3, 'Redmi Note 8 Negro', 849.00, '2021-06-19 18:07:12'),
	(37, 24, 21, 5, 'Redmi Note 8 Negro', 849.00, '2021-06-19 18:11:06'),
	(38, 25, 48, 1, 'Red bull Energydrink', 3.00, '2021-06-28 19:49:20'),
	(39, 26, 45, 10, 'Pisco Qillari Quebranta', 28.00, '2021-07-01 16:25:32'),
	(40, 26, 48, 6, 'Red bull Energydrink', 3.00, '2021-07-01 16:25:32'),
	(41, 26, 40, 12, 'Ron Cartavio 8 años', 40.00, '2021-07-01 16:25:32'),
	(42, 26, 39, 24, 'Flor de Caña centenario 25 años ', 55.00, '2021-07-01 16:25:33'),
	(43, 27, 47, 6, 'Red bull Sugarfree', 3.00, '2021-07-04 18:15:10'),
	(44, 27, 44, 12, 'Pisco Qillari Italia', 22.00, '2021-07-04 18:15:10'),
	(45, 28, 20, 6, 'Johnnie Walker Black icon', 79.00, '2021-07-04 18:58:23'),
	(46, 28, 21, 6, 'Johnnie Walker a Song of Fire', 70.00, '2021-07-04 18:58:23'),
	(47, 28, 24, 6, 'Johnnie Walker Black label', 89.00, '2021-07-04 18:58:23'),
	(48, 28, 25, 6, 'Johnnie Walker Gold label', 90.00, '2021-07-04 18:58:23'),
	(49, 28, 28, 6, 'Vodka Absolut Pera', 40.00, '2021-07-04 18:58:23'),
	(50, 28, 27, 6, 'Johnnie Walker Red label icon', 80.00, '2021-07-04 18:58:23'),
	(51, 28, 26, 6, 'Johnnie Walker Red label', 49.99, '2021-07-04 18:58:23'),
	(52, 29, 29, 6, 'Vodka Absolut Raspberri', 40.00, '2021-07-04 19:02:17'),
	(53, 29, 30, 6, 'Vodka Absolut Clasica', 49.00, '2021-07-04 19:02:17'),
	(54, 29, 31, 6, 'Vino Blanco Semi seco ', 25.00, '2021-07-04 19:02:17'),
	(55, 29, 32, 6, 'Vino Intipalka Sauvignon', 25.00, '2021-07-04 19:02:17'),
	(56, 29, 33, 6, 'Vino Intipalka Syrah', 30.00, '2021-07-04 19:02:17'),
	(57, 29, 34, 6, 'Vino Tacama Rose Semi seco', 18.00, '2021-07-04 19:02:17'),
	(58, 29, 35, 6, 'Vino Intipalka Tannat', 20.00, '2021-07-04 19:02:17'),
	(59, 29, 36, 6, 'Vino Tabernero Rose Semi seco ', 19.00, '2021-07-04 19:02:17'),
	(60, 29, 37, 6, 'Flor de Caña 5 años ', 38.99, '2021-07-04 19:02:17'),
	(61, 29, 38, 6, 'Flor de Caña 7 años ', 42.00, '2021-07-04 19:02:17'),
	(62, 30, 41, 6, 'Ron Medellin Extra añejo 8 años', 50.00, '2021-07-04 19:08:21'),
	(63, 30, 42, 6, 'Ron Medellin Extra añejo 3 años', 29.99, '2021-07-04 19:08:21'),
	(64, 30, 43, 6, 'Pisco Bellavista acholado', 30.00, '2021-07-04 19:08:21'),
	(65, 30, 46, 6, 'Pisco Qillari Clasico', 18.00, '2021-07-04 19:08:21'),
	(66, 30, 48, 3, 'Red bull Energydrink', 3.00, '2021-07-04 19:08:21'),
	(67, 30, 45, 5, 'Pisco Qillari Quebranta', 28.00, '2021-07-04 19:08:21');
/*!40000 ALTER TABLE `det_compra` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.det_permiso
DROP TABLE IF EXISTS `det_permiso`;
CREATE TABLE IF NOT EXISTS `det_permiso` (
  `det_permiso_id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `det_permiso_state` tinyint(4) NOT NULL DEFAULT 1,
  `det_permiso_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `det_permiso_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`det_permiso_id`),
  UNIQUE KEY `UQ_permiso_usuario` (`permiso_id`,`rol_id`) USING BTREE,
  KEY `FK_usuario_det_permiso` (`rol_id`) USING BTREE,
  CONSTRAINT `FK_det_permiso_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`),
  CONSTRAINT `FK_permiso_det_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`permiso_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.det_permiso: ~20 rows (aproximadamente)
/*!40000 ALTER TABLE `det_permiso` DISABLE KEYS */;
REPLACE INTO `det_permiso` (`det_permiso_id`, `permiso_id`, `rol_id`, `det_permiso_state`, `det_permiso_creation`, `det_permiso_update`) VALUES
	(1, 1, 1, 1, '2021-04-17 14:37:08', NULL),
	(2, 2, 1, 1, '2021-04-17 14:46:34', NULL),
	(5, 10, 1, 1, '2021-04-17 20:26:16', NULL),
	(6, 11, 1, 1, '2021-04-17 23:25:00', NULL),
	(7, 12, 1, 1, '2021-04-18 11:00:04', NULL),
	(8, 9, 1, 1, '2021-04-18 12:11:40', NULL),
	(9, 4, 1, 1, '2021-04-18 16:48:34', NULL),
	(11, 3, 1, 1, '2021-04-18 23:17:58', NULL),
	(18, 13, 1, 1, '2021-04-25 16:49:27', NULL),
	(20, 7, 1, 1, '2021-04-25 21:15:38', '2021-04-25 21:15:38'),
	(23, 8, 1, 1, '2021-04-30 17:30:54', '2021-04-30 17:30:54'),
	(24, 5, 1, 1, '2021-04-30 18:44:13', '2021-04-30 19:30:47'),
	(25, 6, 1, 1, '2021-04-30 20:34:23', '2021-05-01 08:14:19'),
	(35, 5, 17, 1, '2021-06-21 13:57:45', '2021-06-21 13:57:45'),
	(39, 6, 17, 1, '2021-06-21 16:07:55', '2021-06-21 16:07:55'),
	(40, 2, 17, 1, '2021-06-21 16:10:20', '2021-06-21 16:10:20'),
	(41, 2, 2, 1, '2021-06-21 16:10:26', '2021-06-21 16:10:26'),
	(42, 7, 2, 1, '2021-06-21 16:10:26', '2021-06-21 16:10:26'),
	(43, 8, 2, 1, '2021-06-21 16:10:26', '2021-06-21 16:10:26'),
	(44, 14, 1, 1, '2021-07-04 18:05:19', '2021-07-04 18:05:19');
/*!40000 ALTER TABLE `det_permiso` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.det_venta
DROP TABLE IF EXISTS `det_venta`;
CREATE TABLE IF NOT EXISTS `det_venta` (
  `det_venta_id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `det_venta_nombre` varchar(200) NOT NULL,
  `det_venta_cantidad` int(11) NOT NULL,
  `det_venta_precio` decimal(10,2) NOT NULL,
  `det_venta_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`det_venta_id`),
  KEY `FK_venta_det_venta` (`venta_id`),
  KEY `FK_producto_det_venta` (`producto_id`),
  CONSTRAINT `FK_producto_det_venta` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  CONSTRAINT `FK_venta_det_venta` FOREIGN KEY (`venta_id`) REFERENCES `venta` (`venta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.det_venta: ~49 rows (aproximadamente)
/*!40000 ALTER TABLE `det_venta` DISABLE KEYS */;
REPLACE INTO `det_venta` (`det_venta_id`, `venta_id`, `producto_id`, `det_venta_nombre`, `det_venta_cantidad`, `det_venta_precio`, `det_venta_creation`) VALUES
	(12, 11, 21, 'Redmi Note 8 Negro', 1, 900.00, '2021-05-01 19:53:12'),
	(13, 12, 25, 'Producto Prueba 3', 3, 100.00, '2021-05-01 20:11:44'),
	(14, 12, 26, 'Producto Prueba 1', 4, 15.00, '2021-05-01 20:11:44'),
	(15, 13, 25, 'Producto Prueba 3', 1, 100.00, '2021-06-07 15:50:47'),
	(16, 14, 20, 'Redmi Note 8 Blanco', 3, 849.00, '2021-06-07 15:58:43'),
	(17, 15, 21, 'Redmi Note 8 Negro', 1, 900.00, '2021-06-19 18:12:21'),
	(18, 16, 21, 'Johnnie Walker a Song of Fire', 5, 80.00, '2021-06-28 20:31:34'),
	(19, 16, 48, 'Red bull Energydrink', 1, 4.00, '2021-06-28 20:31:34'),
	(20, 16, 25, 'Johnnie Walker Gold label', 1, 100.00, '2021-06-28 20:31:34'),
	(21, 17, 48, 'Red bull Energydrink', 2, 4.00, '2021-07-01 16:30:45'),
	(22, 17, 45, 'Pisco Qillari Quebranta', 3, 35.00, '2021-07-01 16:30:45'),
	(23, 17, 40, 'Ron Cartavio 8 años', 1, 50.00, '2021-07-01 16:30:45'),
	(24, 17, 39, 'Flor de Caña centenario 25 años ', 3, 70.00, '2021-07-01 16:30:45'),
	(25, 18, 39, 'Flor de Caña centenario 25 años ', 1, 70.00, '2021-07-03 16:09:12'),
	(26, 18, 40, 'Ron Cartavio 8 años', 2, 50.00, '2021-07-03 16:09:12'),
	(27, 18, 48, 'Red bull Energydrink', 1, 4.00, '2021-07-03 16:09:12'),
	(28, 19, 48, 'Red bull Energydrink', 1, 4.00, '2021-07-04 19:24:18'),
	(29, 19, 47, 'Red bull Sugarfree', 2, 4.00, '2021-07-04 19:24:18'),
	(30, 19, 46, 'Pisco Qillari Clasico', 2, 25.00, '2021-07-04 19:24:18'),
	(31, 19, 45, 'Pisco Qillari Quebranta', 1, 35.00, '2021-07-04 19:24:18'),
	(32, 20, 44, 'Pisco Qillari Italia', 5, 28.00, '2021-07-04 19:52:58'),
	(33, 20, 45, 'Pisco Qillari Quebranta', 11, 35.00, '2021-07-04 19:52:58'),
	(34, 20, 43, 'Pisco Bellavista acholado', 2, 45.00, '2021-07-04 19:52:58'),
	(35, 21, 45, 'Pisco Qillari Quebranta', 5, 35.00, '2021-07-04 20:21:03'),
	(36, 21, 44, 'Pisco Qillari Italia', 2, 28.00, '2021-07-04 20:21:03'),
	(37, 21, 43, 'Pisco Bellavista acholado', 2, 45.00, '2021-07-04 20:21:03'),
	(38, 22, 42, 'Ron Medellin Extra añejo 3 años', 1, 40.00, '2021-07-04 20:21:56'),
	(39, 22, 41, 'Ron Medellin Extra añejo 8 años', 1, 60.00, '2021-07-04 20:21:56'),
	(40, 23, 40, 'Ron Cartavio 8 años', 3, 50.00, '2021-07-04 20:22:46'),
	(41, 23, 39, 'Flor de Caña centenario 25 años ', 1, 70.00, '2021-07-04 20:22:46'),
	(42, 24, 40, 'Ron Cartavio 8 años', 3, 50.00, '2021-07-04 20:23:57'),
	(43, 24, 39, 'Flor de Caña centenario 25 años ', 5, 70.00, '2021-07-04 20:23:57'),
	(44, 25, 38, 'Flor de Caña 7 años ', 1, 55.00, '2021-07-04 20:25:52'),
	(45, 25, 37, 'Flor de Caña 5 años ', 2, 45.00, '2021-07-04 20:25:52'),
	(46, 26, 36, 'Vino Tabernero Rose Semi seco ', 1, 25.00, '2021-07-04 20:27:15'),
	(47, 26, 35, 'Vino Intipalka Tannat', 2, 25.00, '2021-07-04 20:27:15'),
	(48, 26, 34, 'Vino Tacama Rose Semi seco', 2, 25.00, '2021-07-04 20:27:15'),
	(49, 27, 33, 'Vino Intipalka Syrah', 1, 40.00, '2021-07-04 20:28:27'),
	(50, 27, 32, 'Vino Intipalka Sauvignon', 1, 35.00, '2021-07-04 20:28:27'),
	(51, 27, 31, 'Vino Blanco Semi seco ', 2, 20.00, '2021-07-04 20:28:27'),
	(52, 28, 30, 'Vodka Absolut Clasica', 1, 67.00, '2021-07-04 20:29:50'),
	(53, 28, 29, 'Vodka Absolut Raspberri', 1, 55.00, '2021-07-04 20:29:50'),
	(54, 29, 28, 'Vodka Absolut Pera', 1, 50.00, '2021-07-04 20:31:31'),
	(55, 29, 27, 'Johnnie Walker Red label icon', 1, 90.00, '2021-07-04 20:31:31'),
	(56, 29, 26, 'Johnnie Walker Red label', 2, 60.00, '2021-07-04 20:31:31'),
	(57, 29, 25, 'Johnnie Walker Gold label', 2, 100.00, '2021-07-04 20:31:31'),
	(58, 30, 24, 'Johnnie Walker Black label', 2, 99.00, '2021-07-04 20:32:30'),
	(59, 30, 21, 'Johnnie Walker a Song of Fire', 2, 80.00, '2021-07-04 20:32:30'),
	(60, 30, 20, 'Johnnie Walker Black icon', 2, 90.00, '2021-07-04 20:32:30');
/*!40000 ALTER TABLE `det_venta` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.marca
DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `marca_id` int(11) NOT NULL AUTO_INCREMENT,
  `marca_nombre` varchar(50) NOT NULL,
  `marca_state` tinyint(4) NOT NULL DEFAULT 1,
  `marca_update` timestamp NULL DEFAULT NULL,
  `marca_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`marca_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.marca: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
REPLACE INTO `marca` (`marca_id`, `marca_nombre`, `marca_state`, `marca_update`, `marca_creation`) VALUES
	(1, 'Johnnie Walker', 1, '2021-06-23 09:19:58', '2021-04-17 00:00:00'),
	(5, 'Absolut', 1, '2021-06-23 09:20:21', '2021-04-30 20:56:30'),
	(6, 'Intipalka', 1, '2021-06-23 09:22:31', '2021-06-23 09:22:31'),
	(7, 'Tacama', 1, '2021-06-23 09:22:41', '2021-06-23 09:22:41'),
	(8, 'Tabernero', 1, '2021-06-23 09:22:53', '2021-06-23 09:22:53'),
	(9, 'Flor de Caña ', 1, '2021-06-23 09:23:17', '2021-06-23 09:23:17'),
	(10, 'Cartavio', 1, '2021-06-23 09:23:32', '2021-06-23 09:23:32'),
	(11, 'Medellin', 1, '2021-06-23 09:23:48', '2021-06-23 09:23:48'),
	(12, 'Bellavista', 1, '2021-06-23 09:24:11', '2021-06-23 09:24:11'),
	(13, 'Qillari', 1, '2021-06-23 09:24:20', '2021-06-23 09:24:20'),
	(14, 'Red bull', 1, '2021-06-23 09:24:32', '2021-06-23 09:24:32');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.permiso
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE IF NOT EXISTS `permiso` (
  `permiso_id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso_nombre` varchar(50) NOT NULL,
  `permiso_orden` int(11) NOT NULL,
  PRIMARY KEY (`permiso_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.permiso: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
REPLACE INTO `permiso` (`permiso_id`, `permiso_nombre`, `permiso_orden`) VALUES
	(1, 'Ver la lista de Usuarios', 1),
	(2, 'Ver la lista de Productos', 20),
	(3, 'Ver Configuración de la Tienda', 40),
	(4, 'Ver la lista de Cajas', 60),
	(5, 'Ver la lista de Compras', 80),
	(6, 'Hacer Nueva Compra', 100),
	(7, 'Ver la lista de Ventas', 120),
	(8, 'Hacer Nueva Venta', 140),
	(9, 'Ver la lista de Clientes', 160),
	(10, 'Ver la lista de Unidades', 180),
	(11, 'Ver la lista de Categorías', 200),
	(12, 'Ver la lista de Marcas', 220),
	(13, 'Ver la lista de Perfiles', 240),
	(14, 'Ver los reportes', 260);
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.producto
DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `producto_id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_codigo` varchar(20) NOT NULL,
  `producto_nombre` varchar(200) NOT NULL,
  `producto_precioventa` decimal(10,2) NOT NULL DEFAULT 0.00,
  `producto_preciocompra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `producto_stock` int(11) NOT NULL DEFAULT 0,
  `producto_stockminimo` int(11) NOT NULL DEFAULT 0,
  `producto_inventariable` tinyint(4) NOT NULL DEFAULT 1,
  `unidad_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `producto_state` tinyint(4) NOT NULL DEFAULT 1,
  `producto_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `producto_update` timestamp NULL DEFAULT NULL,
  `marca_id` int(11) NOT NULL,
  PRIMARY KEY (`producto_id`),
  UNIQUE KEY `UQ_codigo` (`producto_codigo`),
  KEY `FK_unidad_producto` (`unidad_id`),
  KEY `FK_categoria_producto` (`categoria_id`),
  KEY `FK_marca_producto` (`marca_id`),
  CONSTRAINT `FK_categoria_producto` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  CONSTRAINT `FK_marca_producto` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`marca_id`),
  CONSTRAINT `FK_unidad_producto` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`unidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.producto: ~27 rows (aproximadamente)
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
REPLACE INTO `producto` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_precioventa`, `producto_preciocompra`, `producto_stock`, `producto_stockminimo`, `producto_inventariable`, `unidad_id`, `categoria_id`, `producto_state`, `producto_creation`, `producto_update`, `marca_id`) VALUES
	(20, '8415219542333', 'Johnnie Walker Black icon', 90.00, 79.00, 4, 2, 1, 4, 1, 1, '2021-04-17 20:49:47', NULL, 1),
	(21, '7889323938830', 'Johnnie Walker a Song of Fire', 80.00, 70.00, 4, 2, 1, 4, 1, 1, '2021-04-17 20:49:42', NULL, 1),
	(24, '7859734586357', 'Johnnie Walker Black label', 99.00, 89.00, 4, 2, 1, 4, 1, 1, '2021-04-30 20:57:31', NULL, 1),
	(25, '7889323938831', 'Johnnie Walker Gold label', 100.00, 90.00, 4, 5, 1, 4, 1, 1, '2021-04-30 22:23:54', NULL, 1),
	(26, '7415211232333', 'Johnnie Walker Red label', 60.00, 49.99, 4, 2, 1, 4, 1, 1, '2021-05-01 07:52:45', NULL, 1),
	(27, '7654345678987', 'Johnnie Walker Red label icon', 90.00, 80.00, 5, 2, 1, 4, 1, 1, '2021-06-23 09:33:32', NULL, 1),
	(28, '7964573245987', 'Vodka Absolut Pera', 50.00, 40.00, 5, 3, 1, 4, 2, 1, '2021-06-23 09:40:20', NULL, 5),
	(29, '7645341278546', 'Vodka Absolut Raspberri', 55.00, 40.00, 5, 3, 1, 4, 2, 1, '2021-06-23 09:41:20', NULL, 5),
	(30, '7856432345432', 'Vodka Absolut Clasica', 67.00, 49.00, 5, 3, 1, 4, 2, 1, '2021-06-23 09:48:03', NULL, 5),
	(31, '7654342312431', 'Vino Blanco Semi seco ', 20.00, 25.00, 4, 5, 1, 4, 3, 1, '2021-06-23 09:49:00', NULL, 7),
	(32, '7645678765453', 'Vino Intipalka Sauvignon', 35.00, 25.00, 5, 3, 1, 4, 3, 1, '2021-06-23 09:50:22', NULL, 6),
	(33, '7656432312211', 'Vino Intipalka Syrah', 40.00, 30.00, 5, 3, 1, 4, 3, 1, '2021-06-23 09:51:03', NULL, 6),
	(34, '7687877865534', 'Vino Tacama Rose Semi seco', 25.00, 18.00, 4, 2, 1, 4, 3, 1, '2021-06-23 09:52:09', NULL, 1),
	(35, '7656678787674', 'Vino Intipalka Tannat', 25.00, 20.00, 4, 5, 1, 4, 3, 1, '2021-06-23 09:52:57', NULL, 6),
	(36, '7687765454344', 'Vino Tabernero Rose Semi seco ', 25.00, 19.00, 5, 3, 1, 4, 3, 1, '2021-06-23 09:54:13', NULL, 8),
	(37, '7678876545421', 'Flor de Caña 5 años ', 45.00, 38.99, 4, 2, 1, 4, 9, 1, '2021-06-23 09:56:00', NULL, 9),
	(38, '7685786345346', 'Flor de Caña 7 años ', 55.00, 42.00, 5, 3, 1, 4, 9, 1, '2021-06-23 09:56:51', NULL, 9),
	(39, '7687544534541', 'Flor de Caña centenario 25 años ', 70.00, 55.00, 15, 10, 1, 4, 9, 1, '2021-06-23 09:58:11', NULL, 1),
	(40, '7687453454656', 'Ron Cartavio 8 años', 50.00, 40.00, 6, 3, 1, 4, 9, 1, '2021-06-23 09:59:27', NULL, 1),
	(41, '7687654545765', 'Ron Medellin Extra añejo 8 años', 60.00, 50.00, 5, 3, 1, 4, 9, 1, '2021-06-23 10:00:34', NULL, 1),
	(42, '7656788765546', 'Ron Medellin Extra añejo 3 años', 40.00, 29.99, 5, 3, 1, 4, 9, 1, '2021-06-23 10:01:18', NULL, 1),
	(43, '7656453423432', 'Pisco Bellavista acholado', 45.00, 30.00, 4, 2, 1, 4, 10, 1, '2021-06-23 10:02:49', NULL, 12),
	(44, '7876677545341', 'Pisco Qillari Italia', 28.00, 22.00, 10, 5, 1, 4, 10, 1, '2021-06-23 10:04:16', NULL, 13),
	(45, '7687655676545', 'Pisco Qillari Quebranta', 35.00, 28.00, 6, 3, 1, 4, 10, 1, '2021-06-23 10:05:02', NULL, 1),
	(46, '7687476575876', 'Pisco Qillari Clasico', 25.00, 18.00, 4, 2, 1, 4, 10, 1, '2021-06-23 10:05:36', NULL, 13),
	(47, '7654345432231', 'Red bull Sugarfree', 4.00, 3.00, 4, 2, 1, 4, 11, 1, '2021-06-23 11:21:13', NULL, 14),
	(48, '7656548767654', 'Red bull Energydrink', 4.00, 3.00, 5, 1, 1, 4, 11, 1, '2021-06-23 11:22:12', NULL, 1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.rol
DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(50) NOT NULL,
  `rol_state` tinyint(4) NOT NULL DEFAULT 1,
  `rol_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.rol: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
REPLACE INTO `rol` (`rol_id`, `rol_nombre`, `rol_state`, `rol_creation`, `rol_update`) VALUES
	(1, 'Administrador', 1, '2021-04-01 12:13:34', '2021-07-04 18:05:19'),
	(2, 'Cajero', 1, '2021-04-01 12:13:43', '2021-06-21 16:10:26'),
	(17, 'Almacén', 1, '2021-06-21 13:57:45', '2021-06-21 16:10:20');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.tem_compra
DROP TABLE IF EXISTS `tem_compra`;
CREATE TABLE IF NOT EXISTS `tem_compra` (
  `tem_compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `tem_compra_folio` varchar(50) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `tem_compra_codigo` varchar(50) NOT NULL,
  `tem_compra_nombre` varchar(200) NOT NULL,
  `tem_compra_precio` decimal(10,2) NOT NULL,
  `tem_compra_subtotal` decimal(10,2) NOT NULL,
  `tem_compra_cantidad` int(11) NOT NULL,
  PRIMARY KEY (`tem_compra_id`),
  KEY `FK_producto_tem_compra` (`producto_id`),
  CONSTRAINT `FK_producto_tem_compra` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.tem_compra: ~29 rows (aproximadamente)
/*!40000 ALTER TABLE `tem_compra` DISABLE KEYS */;
REPLACE INTO `tem_compra` (`tem_compra_id`, `tem_compra_folio`, `producto_id`, `tem_compra_codigo`, `tem_compra_nombre`, `tem_compra_precio`, `tem_compra_subtotal`, `tem_compra_cantidad`) VALUES
	(93, '608cbb644483e', 21, '8889323938830', 'Redmi Note 8 Negro', 849.00, 2547.00, 3),
	(106, '608dca252b0f5', 24, '1010', 'Recarga Bitel', 0.90, 2.70, 3),
	(107, '608dcacbcc76b', 24, '1010', 'Recarga Bitel', 0.90, 87.30, 97),
	(108, '608dcb1d23f24', 24, '1010', 'Recarga Bitel', 0.90, 180.00, 200),
	(110, '608dccf632534', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(120, '608dcfdc81f76', 24, '1010', 'Recarga Bitel', 0.90, 900.00, 1000),
	(121, '608dcfdc81f76', 21, '8889323938830', 'Redmi Note 8 Negro', 849.00, 1698.00, 2),
	(122, '608dd03cc0f0f', 24, '1010', 'Recarga Bitel', 0.90, 900.00, 1000),
	(123, '608dd03cc0f0f', 21, '8889323938830', 'Redmi Note 8 Negro', 849.00, 2547.00, 3),
	(132, '608dd6646b345', 24, '1010', 'Recarga Bitel', 0.90, 1.80, 2),
	(133, '608dd6f11dd54', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(134, '608dd744df234', 25, '8889323938831', 'Producto Prueba 3', 90.00, 90.00, 1),
	(137, '608dd80532248', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(138, '608dd99a20c6f', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(139, '608dd9b16c0dd', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(140, '608dd9cbdbec1', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(141, '608ddaa1507e0', 24, '1010', 'Recarga Bitel', 0.90, 1.80, 2),
	(142, '608ddb7928056', 24, '1010', 'Recarga Bitel', 0.90, 0.90, 1),
	(144, '608de0aa5a816', 21, '8889323938830', 'Redmi Note 8 Negro', 849.00, 849.00, 1),
	(153, '608de2f3b6e8f', 26, '8415211232333', 'Producto Prueba 1', 14.00, 56.00, 4),
	(155, '608de454c6ee1', 26, '8415211232333', 'Producto Prueba 1', 15.00, 45.00, 3),
	(156, '608de454c6ee1', 21, '8889323938830', 'Redmi Note 8 Negro', 900.00, 900.00, 1),
	(157, '608de599928c4', 25, '8889323938831', 'Producto Prueba 3', 100.00, 200.00, 2),
	(161, '608de6a1b0b87', 21, '8889323938830', 'Redmi Note 8 Negro', 900.00, 900.00, 1),
	(162, '608de6a1b0b87', 25, '8889323938831', 'Producto Prueba 3', 100.00, 100.00, 1),
	(178, '60d8ddfca7d46', 48, '7656548767654', 'Red bull Energydrink', 3.00, 3.00, 1),
	(179, '60d8de3d6a396', 48, '7656548767654', 'Red bull Energydrink', 3.00, 3.00, 1),
	(180, '60d8df50647ea', 48, '7656548767654', 'Red bull Energydrink', 3.00, 3.00, 1),
	(181, '60d8df778affe', 48, '7656548767654', 'Red bull Energydrink', 3.00, 3.00, 1);
/*!40000 ALTER TABLE `tem_compra` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.unidad
DROP TABLE IF EXISTS `unidad`;
CREATE TABLE IF NOT EXISTS `unidad` (
  `unidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `unidad_nombre` varchar(50) NOT NULL,
  `unidad_corto` varchar(10) NOT NULL DEFAULT '',
  `unidad_state` tinyint(4) NOT NULL DEFAULT 1,
  `unidad_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `unidad_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.unidad: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
REPLACE INTO `unidad` (`unidad_id`, `unidad_nombre`, `unidad_corto`, `unidad_state`, `unidad_creation`, `unidad_update`) VALUES
	(4, 'Unidades', 'U', 1, '2021-03-29 19:34:27', '2021-03-29 19:34:27'),
	(8, 'Soles', 'Soles', 1, '2021-04-17 19:34:24', '2021-04-18 11:33:10');
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_user` varchar(50) NOT NULL,
  `usuario_password` varchar(130) NOT NULL,
  `usuario_nombre` varchar(100) NOT NULL,
  `caja_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `usuario_state` tinyint(4) NOT NULL DEFAULT 1,
  `usuario_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `UQ_user` (`usuario_user`),
  KEY `FK_rol_usuario` (`rol_id`),
  KEY `FK_caja_usuario` (`caja_id`),
  CONSTRAINT `FK_caja_usuario` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`),
  CONSTRAINT `FK_rol_usuario` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.usuario: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
REPLACE INTO `usuario` (`usuario_id`, `usuario_user`, `usuario_password`, `usuario_nombre`, `caja_id`, `rol_id`, `usuario_state`, `usuario_creation`, `usuario_update`) VALUES
	(1, 'almacen', '$2y$10$uuTDskqdcU2zPvTSCiXpD.bPOgfOIgVlgFBM6FTXpBcvDfV8vjNvu', 'Marco Culqui', 0, 17, 1, '2021-04-01 12:23:09', '2021-06-21 16:17:23'),
	(3, 'cajero', '$2y$10$NjftQsKdKsY1Ji7w9TAB1ejbg.RIU3P7lBA3ZrYdRaZkM5Nas/9Eu', 'Franco Fernandez', 1, 2, 1, '2021-04-01 12:27:30', '2021-06-21 16:18:14'),
	(8, 'admin', '$2y$10$uxPaukeAsE08qPg99cMIFexQz/iEX6aDT1pIRZkDSyK8npeXnTWqi', 'Freddy Josias HB', 4, 1, 1, '2021-04-17 14:24:40', '2021-07-04 16:13:37');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Volcando estructura para tabla licorland.venta
DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `venta_id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_folio` varchar(15) NOT NULL,
  `venta_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `venta_total` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `caja_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `venta_formapago` varchar(5) NOT NULL,
  `venta_state` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`venta_id`),
  KEY `FK_cliente_venta` (`cliente_id`),
  KEY `FK_usuario_venta` (`usuario_id`),
  KEY `FK_caja_venta` (`caja_id`),
  CONSTRAINT `FK_caja_venta` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`),
  CONSTRAINT `FK_cliente_venta` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`),
  CONSTRAINT `FK_usuario_venta` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla licorland.venta: ~20 rows (aproximadamente)
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
REPLACE INTO `venta` (`venta_id`, `venta_folio`, `venta_creation`, `venta_total`, `usuario_id`, `caja_id`, `cliente_id`, `venta_formapago`, `venta_state`) VALUES
	(11, '608df48914550', '2020-08-20 19:53:12', 900.00, 8, 4, 1, '001', 1),
	(12, '608dfc29adcc5', '2020-09-24 20:11:44', 360.00, 8, 4, 8, '001', 1),
	(13, '60be86738f614', '2020-10-25 15:50:47', 100.00, 8, 4, 1, '001', 1),
	(14, '60be8843e3958', '2020-11-27 15:58:43', 2547.00, 8, 4, 39, '001', 1),
	(15, '60ce799c61282', '2020-12-21 18:12:21', 900.00, 8, 4, 8, '001', 1),
	(16, '60da76ffd3875', '2021-01-27 20:31:34', 504.00, 8, 4, 36, '001', 1),
	(17, '60de33864df9e', '2021-02-01 16:30:45', 373.00, 8, 4, 36, '001', 1),
	(18, '60e0d1b1a014e', '2021-02-03 16:09:12', 174.00, 8, 4, 40, '001', 1),
	(19, '60e2504fb4400', '2021-03-04 19:24:18', 97.00, 8, 4, 52, '001', 1),
	(20, '60e251bf7580d', '2021-03-04 19:52:58', 0.00, 8, 4, 49, '001', 0),
	(21, '60e2595748399', '2021-03-04 20:21:03', 321.00, 8, 4, 49, '001', 1),
	(22, '60e25e878249c', '2021-04-04 20:21:56', 100.00, 8, 4, 51, '001', 1),
	(23, '60e25eb7df791', '2021-04-04 20:22:46', 0.00, 8, 4, 48, '001', 0),
	(24, '60e25ef6d34ad', '2021-05-04 20:23:57', 500.00, 8, 4, 48, '001', 1),
	(25, '60e25f6354173', '2021-05-04 20:25:52', 145.00, 8, 4, 42, '001', 1),
	(26, '60e25fa58d6a2', '2021-06-04 20:27:15', 125.00, 8, 4, 50, '001', 1),
	(27, '60e2600fe8be6', '2021-06-04 20:28:27', 115.00, 8, 4, 43, '001', 1),
	(28, '60e260628d6d7', '2021-07-04 20:29:50', 122.00, 8, 4, 44, '001', 1),
	(29, '60e260925bf59', '2021-07-04 20:31:31', 460.00, 8, 4, 47, '001', 1),
	(30, '60e2610885d1b', '2021-07-04 20:32:30', 538.00, 8, 4, 45, '001', 1);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
