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


-- Volcando estructura de base de datos para gamonalcolunche
DROP DATABASE IF EXISTS `gamonalcolunche`;
CREATE DATABASE IF NOT EXISTS `gamonalcolunche` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `gamonalcolunche`;

-- Volcando estructura para tabla gamonalcolunche.caja
DROP TABLE IF EXISTS `caja`;
CREATE TABLE IF NOT EXISTS `caja` (
  `caja_id` int(11) NOT NULL AUTO_INCREMENT,
  `caja_numero` varchar(10) NOT NULL,
  `caja_nombre` varchar(50) NOT NULL,
  `caja_folio` varchar(50) NOT NULL,
  `caja_state` tinyint(4) NOT NULL DEFAULT 1,
  `caja_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `caja_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`caja_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.caja: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
REPLACE INTO `caja` (`caja_id`, `caja_numero`, `caja_nombre`, `caja_folio`, `caja_state`, `caja_creation`, `caja_update`) VALUES
	(1, '1', 'Caja General', '1', 1, '2021-04-01 12:12:51', NULL),
	(2, '2', 'Caja secundaria', '1', 1, '2021-04-01 12:13:15', NULL);
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(50) NOT NULL DEFAULT '',
  `categoria_state` tinyint(4) NOT NULL DEFAULT 1,
  `categoria_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categoria_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.categoria: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
REPLACE INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_state`, `categoria_creation`, `categoria_update`) VALUES
	(1, 'Celulares', 1, '2021-03-29 19:49:59', '2021-03-29 19:49:59'),
	(2, 'Cargadores', 1, '2021-03-29 19:52:07', '2021-03-29 19:52:07'),
	(3, 'Audífonos', 1, '2021-03-29 20:32:35', '2021-03-29 20:32:35');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nombre` varchar(100) NOT NULL,
  `cliente_direccion` varchar(150) DEFAULT NULL,
  `cliente_telefono` varchar(20) DEFAULT NULL,
  `cliente_correo` varchar(50) DEFAULT NULL,
  `cliente_state` tinyint(4) NOT NULL DEFAULT 1,
  `cliente_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `cliente_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.cliente: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
REPLACE INTO `cliente` (`cliente_id`, `cliente_nombre`, `cliente_direccion`, `cliente_telefono`, `cliente_correo`, `cliente_state`, `cliente_creation`, `cliente_update`) VALUES
	(1, 'Marcos a', 'POr ', '', '', 1, '2021-03-30 21:55:26', '2021-03-30 22:08:08'),
	(2, 'Marcos', '', '', '', 1, '2021-03-30 21:56:17', '2021-03-30 22:18:20'),
	(3, 'Car', 'sds', '', '', 1, '2021-03-30 21:56:41', '2021-03-30 21:56:41'),
	(4, 'Tare', '', '92515', '', 1, '2021-03-30 21:56:50', '2021-03-30 22:21:58'),
	(5, 'Named8', 'Ju8', '028208', 'josma@a.ac8om', 1, '2021-03-30 21:57:18', '2021-03-30 22:18:34'),
	(6, 'Carlos', '', '', '', 1, '2021-03-30 21:58:20', '2021-03-30 21:58:20'),
	(7, 'Enrrique Varaja111', 'Asquiajo111', '9285478111', 'minuni@dw.com111', 1, '2021-03-30 22:20:46', '2021-03-30 22:21:06');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.compra
DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `compra_folio` varchar(15) NOT NULL,
  `compra_total` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `compra_ustate` tinyint(4) NOT NULL DEFAULT 1,
  `compra_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`compra_id`),
  KEY `FK_usuario_compra` (`usuario_id`),
  CONSTRAINT `FK_usuario_compra` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.compra: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
REPLACE INTO `compra` (`compra_id`, `compra_folio`, `compra_total`, `usuario_id`, `compra_ustate`, `compra_creation`) VALUES
	(5, '6067adccb4c4b', 12.00, 3, 0, '2021-04-02 18:51:07'),
	(6, '6067adf6cfcdc', 18.00, 3, 1, '2021-04-02 18:51:31'),
	(7, '6067aefc85698', 400.00, 3, 1, '2021-04-02 18:57:34'),
	(8, '6067af80bf98e', 6.00, 3, 1, '2021-04-02 18:58:36'),
	(9, '6067aff2a10de', 6.00, 3, 1, '2021-04-02 19:00:06'),
	(10, '6067b01843398', 6.00, 3, 1, '2021-04-02 19:02:34'),
	(11, '6067b1b602645', 6013.00, 3, 1, '2021-04-02 19:08:28'),
	(12, '6067b20656795', 8413.00, 3, 1, '2021-04-02 19:09:24'),
	(13, '6067ddba6d03e', 200.99, 1, 1, '2021-04-02 22:15:12'),
	(14, '60680707c748c', 12414.98, 1, 1, '2021-04-03 01:11:56');
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.configuracion
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `configuracion_id` int(11) NOT NULL AUTO_INCREMENT,
  `configuracion_nombre` varchar(50) NOT NULL,
  `configuracion_valor` varchar(100) NOT NULL,
  PRIMARY KEY (`configuracion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.configuracion: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
REPLACE INTO `configuracion` (`configuracion_id`, `configuracion_nombre`, `configuracion_valor`) VALUES
	(1, 'nombre_tienda', 'Mi tienda 1'),
	(2, 'tienda_rfc', 'XEXX0101010001'),
	(3, 'tienda_telefono', '902321'),
	(4, 'tienda_email', 'tienda@email.com1'),
	(5, 'tienda_direccion', 'Av. Juares1'),
	(6, 'ticket_leyenda', 'Gracias por Comprar1');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.det_compra
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.det_compra: ~17 rows (aproximadamente)
/*!40000 ALTER TABLE `det_compra` DISABLE KEYS */;
REPLACE INTO `det_compra` (`det_compra_id`, `compra_id`, `producto_id`, `det_compra_cantidad`, `det_compra_nombre`, `det_compra_precio`, `det_compra_creation`) VALUES
	(5, 5, 4, 1, 'aaa', 12.00, '2021-04-02 18:51:07'),
	(6, 5, 2, 2, 'CelPhone', 6000.00, '2021-04-02 18:51:07'),
	(7, 5, 5, 3, 'wdd8', 12.08, '2021-04-02 18:51:07'),
	(8, 6, 2, 3, 'CelPhone', 6000.00, '2021-04-02 18:51:31'),
	(9, 7, 1, 2, 'Audi', 200.00, '2021-04-02 18:57:34'),
	(10, 8, 2, 1, 'CelPhone', 6000.00, '2021-04-02 18:58:36'),
	(11, 8, 1, 1, 'Audi', 200.00, '2021-04-02 18:58:36'),
	(12, 9, 1, 2, 'Audi', 200.00, '2021-04-02 19:00:06'),
	(13, 9, 2, 1, 'CelPhone', 6000.00, '2021-04-02 19:00:06'),
	(14, 10, 2, 1, 'CelPhone', 6000.00, '2021-04-02 19:02:34'),
	(15, 10, 1, 1, 'Audi', 200.00, '2021-04-02 19:02:34'),
	(16, 11, 3, 1, 'CELL', 13.00, '2021-04-02 19:08:28'),
	(17, 11, 2, 1, 'CelPhone', 6000.00, '2021-04-02 19:08:28'),
	(18, 12, 3, 1, 'CELL', 13.00, '2021-04-02 19:09:24'),
	(19, 12, 1, 12, 'Audi', 200.00, '2021-04-02 19:09:24'),
	(20, 12, 2, 1, 'CelPhone', 6000.00, '2021-04-02 19:09:24'),
	(21, 13, 1, 1, 'Audi', 200.99, '2021-04-02 22:15:12'),
	(22, 14, 1, 2, 'Audi', 200.99, '2021-04-03 01:11:56'),
	(23, 14, 2, 2, 'CelPhone', 6000.00, '2021-04-03 01:11:56'),
	(24, 14, 3, 1, 'CELL', 13.00, '2021-04-03 01:11:56');
/*!40000 ALTER TABLE `det_compra` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.det_venta
DROP TABLE IF EXISTS `det_venta`;
CREATE TABLE IF NOT EXISTS `det_venta` (
  `det_venta_id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `det_venta_nombre` varchar(200) NOT NULL,
  `det_venta_cantidad` int(11) NOT NULL,
  `det_venta_precio` decimal(10,2) NOT NULL,
  `det_ventra_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`det_venta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.det_venta: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `det_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_venta` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.producto
DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `producto_id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_codigo` varchar(20) NOT NULL,
  `producto_nombre` varchar(200) NOT NULL,
  `producto_precioventa` decimal(10,2) NOT NULL DEFAULT 0.00,
  `producto_preciocompra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `producto_stock` int(11) NOT NULL DEFAULT 0,
  `producto_stockminimo` int(11) NOT NULL DEFAULT 0,
  `producto_inventariable` tinyint(4) NOT NULL,
  `unidad_id` int(11) NOT NULL DEFAULT 0,
  `categoria_id` int(11) NOT NULL DEFAULT 0,
  `producto_state` tinyint(4) NOT NULL DEFAULT 1,
  `producto_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `producto_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`producto_id`),
  UNIQUE KEY `UQ_codigo` (`producto_codigo`),
  KEY `FK_unidad_producto` (`unidad_id`),
  KEY `FK_categoria_producto` (`categoria_id`),
  CONSTRAINT `FK_categoria_producto` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  CONSTRAINT `FK_unidad_producto` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`unidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.producto: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
REPLACE INTO `producto` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_precioventa`, `producto_preciocompra`, `producto_stock`, `producto_stockminimo`, `producto_inventariable`, `unidad_id`, `categoria_id`, `producto_state`, `producto_creation`, `producto_update`) VALUES
	(1, '12345678', 'Audi', 120.00, 200.99, 21, 20, 1, 4, 1, 1, '2021-04-03 01:11:56', '2021-03-29 22:07:23'),
	(2, '20154798', 'CelPhone', 250.00, 6000.00, 12, 200, 1, 4, 3, 1, '2021-04-03 01:11:56', '2021-03-30 16:53:56'),
	(3, '5165416351', 'CELL', 12.00, 13.00, 3, 1, 0, 2, 2, 1, '2021-04-03 01:11:56', '2021-03-30 16:54:18'),
	(4, '123312312', 'aaa', 12.00, 12.00, 1, 1, 0, 7, 3, 1, '2021-04-02 18:51:07', '2021-03-30 16:43:53'),
	(5, '21218', 'wdd8', 21.08, 12.08, 3, 28, 1, 7, 3, 1, '2021-04-02 18:51:07', '2021-03-30 16:54:23');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.rol
DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(50) NOT NULL,
  `rol_state` tinyint(4) NOT NULL DEFAULT 1,
  `rol_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.rol: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
REPLACE INTO `rol` (`rol_id`, `rol_nombre`, `rol_state`, `rol_creation`, `rol_update`) VALUES
	(1, 'Administrador', 1, '2021-04-01 12:13:34', NULL),
	(2, 'Cajero', 1, '2021-04-01 12:13:43', NULL);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.tem_compra
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
  PRIMARY KEY (`tem_compra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.tem_compra: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `tem_compra` DISABLE KEYS */;
REPLACE INTO `tem_compra` (`tem_compra_id`, `tem_compra_folio`, `producto_id`, `tem_compra_codigo`, `tem_compra_nombre`, `tem_compra_precio`, `tem_compra_subtotal`, `tem_compra_cantidad`) VALUES
	(53, '6067b243047ca', 1, '12345678', 'Audi', 200.99, 200.99, 1);
/*!40000 ALTER TABLE `tem_compra` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.unidad
DROP TABLE IF EXISTS `unidad`;
CREATE TABLE IF NOT EXISTS `unidad` (
  `unidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `unidad_nombre` varchar(50) NOT NULL,
  `unidad_corto` varchar(10) NOT NULL DEFAULT '',
  `unidad_state` tinyint(4) NOT NULL DEFAULT 1,
  `unidad_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `unidad_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.unidad: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
REPLACE INTO `unidad` (`unidad_id`, `unidad_nombre`, `unidad_corto`, `unidad_state`, `unidad_creation`, `unidad_update`) VALUES
	(1, 'Kilogramo', 'Kg', 1, '2021-03-29 19:18:21', '2021-03-29 19:18:21'),
	(2, 'Litro', 'Lt', 1, '2021-03-30 16:52:55', '2021-03-30 16:52:55'),
	(3, 'Litros', 'Lt', 0, '2021-03-29 21:18:23', '2021-03-29 21:18:23'),
	(4, 'Unidades', 'U', 1, '2021-03-29 19:34:27', '2021-03-29 19:34:27'),
	(5, 'wdd8', 'psss', 1, '2021-03-30 19:12:10', '2021-03-30 19:12:10'),
	(6, '', '', 0, '2021-03-29 19:35:57', '2021-03-29 19:35:57'),
	(7, 'Metro', 'mts', 1, '2021-03-29 20:31:23', '2021-03-29 20:31:23');
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.usuario
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.usuario: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
REPLACE INTO `usuario` (`usuario_id`, `usuario_user`, `usuario_password`, `usuario_nombre`, `caja_id`, `rol_id`, `usuario_state`, `usuario_creation`, `usuario_update`) VALUES
	(1, 'user', '$2y$10$NjftQsKdKsY1Ji7w9TAB1ejbg.RIU3P7lBA3ZrYdRaZkM5Nas/9Eu', 'Marco', 1, 2, 1, '2021-04-01 12:23:09', '2021-04-01 16:54:46'),
	(2, 'usuario 2', '$2y$10$Y9hwAd0hopnzt0H07CqJc.PTlUWr2dRWALPWL4eNiaw5.WAxFPeAG', 'Nano', 1, 1, 1, '2021-04-01 12:26:33', '2021-04-01 12:26:33'),
	(3, 'Usuario 3', '$2y$10$NjftQsKdKsY1Ji7w9TAB1ejbg.RIU3P7lBA3ZrYdRaZkM5Nas/9Eu', 'Franco', 1, 1, 1, '2021-04-01 12:27:30', '2021-04-01 12:27:30'),
	(4, 'ter', '$2y$10$l1LRWt6dNbFUi1Uk0Ko2u.7PUjOf6V7smdmoJQnoKNX20LeBjEuHi', 'cd', 2, 1, 1, '2021-04-01 12:30:21', '2021-04-01 12:30:21'),
	(5, 'gr', '$2y$10$S6xIU/IiQRZED247zxLyTuqclgDJ9x6IWZFG72MJhfZSh7UzQFiNa', 're', 2, 1, 1, '2021-04-01 12:30:40', '2021-04-01 12:30:40'),
	(6, 'adw', '$2y$10$r/rL0ggbDkIRgyYiBa/TAevbyZhnX26cRF8.wUY.2Ed6gepqqDHvy', 'adw', 1, 2, 1, '2021-04-01 12:31:00', '2021-04-01 12:31:00');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Volcando estructura para tabla gamonalcolunche.venta
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
  PRIMARY KEY (`venta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla gamonalcolunche.venta: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
