-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2026 a las 22:36:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
CREATE TABLE `bitacora` (
  `bitacoracod` int(11) NOT NULL,
  `bitacorafch` datetime DEFAULT NULL,
  `bitprograma` varchar(255) DEFAULT NULL,
  `bitdescripcion` varchar(255) DEFAULT NULL,
  `bitobservacion` mediumtext DEFAULT NULL,
  `bitTipo` char(3) DEFAULT NULL,
  `bitusuario` bigint(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

DROP TABLE IF EXISTS `carrito`;
CREATE TABLE `carrito` (
  `carrito_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `carrito_estado` char(3) DEFAULT 'ACT',
  `carrito_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `carrito_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_detalle`
--

DROP TABLE IF EXISTS `carrito_detalle`;
CREATE TABLE `carrito_detalle` (
  `detalle_id` int(11) NOT NULL,
  `carrito_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_nombre` varchar(100) NOT NULL,
  `categoria_descripcion` text DEFAULT NULL,
  `categoria_estado` char(3) NOT NULL DEFAULT 'ACT',
  `categoria_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `categoria_nombre`, `categoria_descripcion`, `categoria_estado`, `categoria_fecha_creacion`, `categoria_fecha_actualizacion`) VALUES
(1, 'Acción', 'Videojuegos de acción', 'ACT', '2026-07-21 19:05:16', NULL),
(2, 'Aventura', 'Videojuegos de aventura', 'ACT', '2026-07-21 19:05:16', NULL),
(3, 'RPG', 'Juegos de rol', 'ACT', '2026-07-21 19:05:16', NULL),
(4, 'Deportes', 'Juegos deportivos', 'ACT', '2026-07-21 19:05:16', NULL),
(5, 'Carreras', 'Juegos de carreras', 'ACT', '2026-07-21 19:05:16', NULL),
(6, 'Terror', 'Juegos de terror', 'ACT', '2026-07-21 19:05:16', NULL),
(7, 'Estrategia', 'Juegos de estrategia', 'ACT', '2026-07-21 19:05:16', NULL),
(8, 'Simulación', 'Juegos de simulación', 'ACT', '2026-07-21 19:05:16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_usuario`
--

DROP TABLE IF EXISTS `direcciones_usuario`;
CREATE TABLE `direcciones_usuario` (
  `direccion_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `direccion_alias` varchar(50) DEFAULT NULL,
  `direccion_receptor` varchar(150) NOT NULL,
  `direccion_telefono` varchar(20) NOT NULL,
  `direccion_departamento` varchar(100) NOT NULL,
  `direccion_ciudad` varchar(100) NOT NULL,
  `direccion_detalle` text NOT NULL,
  `direccion_referencia` text DEFAULT NULL,
  `direccion_predeterminada` tinyint(1) DEFAULT 0,
  `direccion_estado` char(3) DEFAULT 'ACT',
  `direccion_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `direccion_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones`
--

DROP TABLE IF EXISTS `funciones`;
CREATE TABLE `funciones` (
  `fncod` varchar(255) NOT NULL,
  `fndsc` varchar(255) DEFAULT NULL,
  `fnest` char(3) DEFAULT NULL,
  `fntyp` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `funciones`
--

INSERT INTO `funciones` (`fncod`, `fndsc`, `fnest`, `fntyp`) VALUES
('1', 'Iniciar Sesión', 'ACT', 'MEN'),
('2', 'Gestión de Usuarios', 'ACT', 'MEN'),
('3', 'Reportes del Sistema', 'INA', 'Pro'),
('Controllers\\Security\\FuncionesRoles', 'Administración de Funciones', 'ACT', 'CTR'),
('Controllers\\Security\\FuncionRol', 'Administrar Funciones de un Rol', 'ACT', 'CTR'),
('Controllers\\Security\\RolesUsuarios', 'Controllers\\Security\\RolesUsuarios', 'ACT', 'CTR'),
('Controllers\\Security\\RolUsuario', 'Controllers\\Security\\RolUsuario', 'ACT', 'CTR'),
('Menu_PaymentCheckout', 'Menu_PaymentCheckout', 'ACT', 'MNU'),
('Menu_RutasEntrega', 'Menu_RutasEntrega', 'ACT', 'MNU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones_roles`
--

DROP TABLE IF EXISTS `funciones_roles`;
CREATE TABLE `funciones_roles` (
  `rolescod` varchar(128) NOT NULL,
  `fncod` varchar(255) NOT NULL,
  `fnrolest` char(3) DEFAULT NULL,
  `fnexp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `funciones_roles`
--

INSERT INTO `funciones_roles` (`rolescod`, `fncod`, `fnrolest`, `fnexp`) VALUES
('1', '1', 'INA', NULL),
('1', '2', 'INA', NULL),
('1', 'Controllers\\Security\\FuncionesRoles', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionRol', 'ACT', NULL),
('1', 'Controllers\\Security\\RolesUsuarios', 'ACT', NULL),
('1', 'Controllers\\Security\\RolUsuario', 'ACT', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_movimientos`
--

DROP TABLE IF EXISTS `inventario_movimientos`;
CREATE TABLE `inventario_movimientos` (
  `movimiento_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `usercod` bigint(20) DEFAULT NULL,
  `movimiento_tipo` enum('ENTRADA','SALIDA','AJUSTE') NOT NULL,
  `movimiento_cantidad` int(11) NOT NULL,
  `movimiento_stock_anterior` int(11) NOT NULL,
  `movimiento_stock_nuevo` int(11) NOT NULL,
  `movimiento_observacion` varchar(255) DEFAULT NULL,
  `movimiento_fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `marcas` (
  `marca_id` int(11) NOT NULL,
  `marca_nombre` varchar(100) NOT NULL,
  `marca_descripcion` text DEFAULT NULL,
  `marca_estado` char(3) NOT NULL DEFAULT 'ACT',
  `marca_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `marca_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`marca_id`, `marca_nombre`, `marca_descripcion`, `marca_estado`, `marca_fecha_creacion`, `marca_fecha_actualizacion`) VALUES
(1, 'Sony', 'PlayStation Studios', 'ACT', '2026-07-21 19:05:37', NULL),
(2, 'Microsoft', 'Xbox Game Studios', 'ACT', '2026-07-21 19:05:37', NULL),
(3, 'Nintendo', 'Nintendo', 'ACT', '2026-07-21 19:05:37', NULL),
(4, 'Ubisoft', 'Ubisoft Entertainment', 'ACT', '2026-07-21 19:05:37', NULL),
(5, 'Electronic Arts', 'EA', 'ACT', '2026-07-21 19:05:37', NULL),
(6, 'Rockstar Games', 'Rockstar Games', 'ACT', '2026-07-21 19:05:37', NULL),
(7, 'Activision', 'Activision', 'ACT', '2026-07-21 19:05:37', NULL),
(8, 'Square Enix', 'Square Enix', 'ACT', '2026-07-21 19:05:37', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE `metodos_pago` (
  `metodo_pago_id` int(11) NOT NULL,
  `metodo_nombre` varchar(100) NOT NULL,
  `metodo_descripcion` varchar(255) DEFAULT NULL,
  `metodo_estado` char(3) DEFAULT 'ACT',
  `metodo_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`metodo_pago_id`, `metodo_nombre`, `metodo_descripcion`, `metodo_estado`, `metodo_fecha_creacion`) VALUES
(1, 'Efectivo', 'Pago en efectivo al momento de la entrega', 'ACT', '2026-07-21 19:05:05'),
(2, 'Tarjeta de Crédito', 'Pago mediante tarjeta de crédito', 'ACT', '2026-07-21 19:05:05'),
(3, 'Tarjeta de Débito', 'Pago mediante tarjeta de débito', 'ACT', '2026-07-21 19:05:05'),
(4, 'Transferencia Bancaria', 'Transferencia bancaria', 'ACT', '2026-07-21 19:05:05'),
(5, 'PayPal', 'Pago mediante PayPal', 'ACT', '2026-07-21 19:05:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `pago_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `metodo_pago_id` int(11) NOT NULL,
  `pago_monto` decimal(10,2) NOT NULL,
  `pago_referencia` varchar(150) DEFAULT NULL,
  `pago_estado` char(3) DEFAULT 'PEN',
  `pago_fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas`
--

DROP TABLE IF EXISTS `plataformas`;
CREATE TABLE `plataformas` (
  `plataforma_id` int(11) NOT NULL,
  `plataforma_nombre` varchar(100) NOT NULL,
  `plataforma_descripcion` text DEFAULT NULL,
  `plataforma_estado` char(3) NOT NULL DEFAULT 'ACT',
  `plataforma_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `plataforma_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plataformas`
--

INSERT INTO `plataformas` (`plataforma_id`, `plataforma_nombre`, `plataforma_descripcion`, `plataforma_estado`, `plataforma_fecha_creacion`, `plataforma_fecha_actualizacion`) VALUES
(1, 'PC', 'Computadora', 'ACT', '2026-07-21 19:05:26', NULL),
(2, 'PlayStation 5', 'Consola Sony', 'ACT', '2026-07-21 19:05:26', NULL),
(3, 'Xbox Series X', 'Consola Microsoft', 'ACT', '2026-07-21 19:05:26', NULL),
(4, 'Nintendo Switch', 'Consola Nintendo', 'ACT', '2026-07-21 19:05:26', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `producto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `marca_id` int(11) NOT NULL,
  `plataforma_id` int(11) DEFAULT NULL,
  `producto_sku` varchar(40) NOT NULL,
  `producto_nombre` varchar(150) NOT NULL,
  `producto_slug` varchar(180) DEFAULT NULL,
  `producto_descripcion` text DEFAULT NULL,
  `producto_costo` decimal(10,2) NOT NULL,
  `producto_precio` decimal(10,2) NOT NULL,
  `producto_stock` int(11) NOT NULL DEFAULT 0,
  `producto_activo_web` char(3) DEFAULT 'ACT',
  `producto_estado` char(3) DEFAULT 'ACT',
  `producto_fecha_publicacion` timestamp NULL DEFAULT NULL,
  `producto_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `producto_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

DROP TABLE IF EXISTS `producto_imagenes`;
CREATE TABLE `producto_imagenes` (
  `imagen_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `imagen_ruta` varchar(255) NOT NULL,
  `imagen_principal` tinyint(1) DEFAULT 0,
  `imagen_orden` smallint(6) DEFAULT 1,
  `imagen_estado` char(3) DEFAULT 'ACT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `rolescod` varchar(128) NOT NULL,
  `rolesdsc` varchar(45) DEFAULT NULL,
  `rolesest` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rolescod`, `rolesdsc`, `rolesest`) VALUES
('1', 'Administrador del Sistema', 'ACT'),
('2', 'Usuario de Ventas', 'ACT'),
('3', 'Usuario Invitado', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

DROP TABLE IF EXISTS `roles_usuarios`;
CREATE TABLE `roles_usuarios` (
  `usercod` bigint(10) NOT NULL,
  `rolescod` varchar(128) NOT NULL,
  `roleuserest` char(3) DEFAULT NULL,
  `roleuserfch` datetime DEFAULT NULL,
  `roleuserexp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`usercod`, `rolescod`, `roleuserest`, `roleuserfch`, `roleuserexp`) VALUES
(1, '1', 'ACT', '2026-07-16 15:34:11', NULL),
(1, '2', 'INA', '2026-07-17 10:54:58', NULL),
(5, '1', 'ACT', '2026-07-16 16:58:06', NULL),
(6, '1', 'ACT', '2026-07-17 11:12:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas_entrega`
--

DROP TABLE IF EXISTS `rutas_entrega`;
CREATE TABLE `rutas_entrega` (
  `id_ruta` int(11) NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `distancia_km` decimal(8,2) NOT NULL,
  `duracion_min` int(11) NOT NULL,
  `estado` char(3) NOT NULL DEFAULT 'ACT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas_entrega`
--

INSERT INTO `rutas_entrega` (`id_ruta`, `origen`, `destino`, `distancia_km`, `duracion_min`, `estado`) VALUES
(1, 'Tegucigalpa', 'Comayagua', 82.50, 90, 'ACT'),
(2, 'San Pedro Sula', 'Puerto Cortés', 58.20, 55, 'ACT'),
(3, 'La Ceiba', 'Tela', 101.75, 110, 'INA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `usercod` bigint(10) NOT NULL,
  `useremail` varchar(80) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `userpswd` varchar(128) DEFAULT NULL,
  `userfching` datetime DEFAULT NULL,
  `userpswdest` char(3) DEFAULT NULL,
  `userpswdexp` datetime DEFAULT NULL,
  `userest` char(3) DEFAULT NULL,
  `useractcod` varchar(128) DEFAULT NULL,
  `userpswdchg` varchar(128) DEFAULT NULL,
  `usertipo` char(3) DEFAULT NULL COMMENT 'Tipo de Usuario, Normal, Consultor o Cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usercod`, `useremail`, `username`, `userpswd`, `userfching`, `userpswdest`, `userpswdexp`, `userest`, `useractcod`, `userpswdchg`, `usertipo`) VALUES
(1, 'admin@admin.com', 'Administrador', '123457', '2026-07-01 17:50:39', 'ACT', '2026-09-29 17:50:39', 'ACT', 'ACT001', '2026-07-01T17:50:39', 'ADM'),
(2, 'fernandogofu04@gmail.com', 'Supervisor', '12345', '2026-07-03 19:08:00', 'Cam', '2029-06-12 19:08:00', 'ACT', 'ACT002', '2026-07-10T19:08', 'Sup'),
(4, 'rogergoper@gmail.com', 'UsuarioInvitado', '777777', '2026-07-18 20:49:00', 'Cam', '2027-10-20 20:49:00', 'INA', 'ACT003', '2026-07-31T20:49', 'USR'),
(5, 'prueba@gmail.com', 'John Doe', '$2y$10$g2.o5EsoZlj27vWoI/0Hf.tKCCP4uWP5oeIN2pCPngzrsIZRsZHG2', '2026-07-16 15:25:49', 'ACT', '2026-10-14 00:00:00', 'ACT', '68ff39d358b419530339d56f797c8f35d943568171d35a877f5461ce0275cc31', '2026-07-16 15:25:49', 'PBL'),
(6, 'prueba@unah.edu', 'John Doe', '$2y$10$BqO/PDCWWUHCBoOJiFgImOPoJez5qDHAUfI0GChaJzXFJboR7Jvr2', '2026-07-17 10:59:40', 'ACT', '2026-10-15 00:00:00', 'ACT', '2a11d7b8275972d8f8ab117884904c297cf95624b66938cbe34d5073fb21af4e', '2026-07-17 10:59:40', 'PBL'),
(7, 'ejemp@unah.edu', 'John Doe', '$2y$10$c0gEqkB768wTqo4nKwTeKODFeooc2n0cGQ8eWKAjGj7gG5oC0opCG', '2026-07-17 11:02:00', 'ACT', '2026-10-15 00:00:00', 'ACT', 'baa758556d7102e8780303e5600550bb292a6fd32f3b0fcac8330335e2db953d', '2026-07-17 11:02:00', 'PBL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `venta_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `direccion_id` int(11) NOT NULL,
  `metodo_pago_id` int(11) NOT NULL,
  `venta_fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `venta_subtotal` decimal(10,2) NOT NULL,
  `venta_impuesto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `venta_descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `venta_total` decimal(10,2) NOT NULL,
  `venta_estado` char(3) DEFAULT 'PEN',
  `venta_observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
CREATE TABLE `venta_detalle` (
  `detalle_venta_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `producto_nombre` varchar(150) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `wishlist_fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp(),
  `wishlist_estado` char(3) DEFAULT 'ACT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`bitacoracod`),
  ADD KEY `fk_bitacora_usuario` (`bitusuario`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`carrito_id`),
  ADD KEY `idx_carrito_usuario` (`usercod`),
  ADD KEY `idx_carrito_estado` (`carrito_estado`);

--
-- Indices de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD PRIMARY KEY (`detalle_id`),
  ADD KEY `idx_carrito_detalle_carrito` (`carrito_id`),
  ADD KEY `idx_carrito_detalle_producto` (`producto_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`),
  ADD UNIQUE KEY `categoria_nombre` (`categoria_nombre`);

--
-- Indices de la tabla `direcciones_usuario`
--
ALTER TABLE `direcciones_usuario`
  ADD PRIMARY KEY (`direccion_id`),
  ADD KEY `idx_direcciones_usuario` (`usercod`);

--
-- Indices de la tabla `funciones`
--
ALTER TABLE `funciones`
  ADD PRIMARY KEY (`fncod`);

--
-- Indices de la tabla `funciones_roles`
--
ALTER TABLE `funciones_roles`
  ADD PRIMARY KEY (`rolescod`,`fncod`),
  ADD KEY `rol_funcion_key_idx` (`fncod`);

--
-- Indices de la tabla `inventario_movimientos`
--
ALTER TABLE `inventario_movimientos`
  ADD PRIMARY KEY (`movimiento_id`),
  ADD KEY `idx_inventario_producto` (`producto_id`),
  ADD KEY `idx_inventario_usuario` (`usercod`),
  ADD KEY `idx_inventario_fecha` (`movimiento_fecha`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`marca_id`),
  ADD UNIQUE KEY `marca_nombre` (`marca_nombre`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`metodo_pago_id`),
  ADD UNIQUE KEY `metodo_nombre` (`metodo_nombre`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `idx_pagos_venta` (`venta_id`),
  ADD KEY `idx_pagos_metodo` (`metodo_pago_id`),
  ADD KEY `idx_pagos_estado` (`pago_estado`);

--
-- Indices de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  ADD PRIMARY KEY (`plataforma_id`),
  ADD UNIQUE KEY `plataforma_nombre` (`plataforma_nombre`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`producto_id`),
  ADD UNIQUE KEY `producto_sku` (`producto_sku`),
  ADD UNIQUE KEY `producto_slug` (`producto_slug`),
  ADD KEY `idx_productos_categoria` (`categoria_id`),
  ADD KEY `idx_productos_marca` (`marca_id`),
  ADD KEY `idx_productos_plataforma` (`plataforma_id`),
  ADD KEY `idx_productos_nombre` (`producto_nombre`),
  ADD KEY `idx_productos_slug` (`producto_slug`),
  ADD KEY `idx_productos_estado` (`producto_estado`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`imagen_id`),
  ADD KEY `fk_imagen_producto` (`producto_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rolescod`);

--
-- Indices de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD PRIMARY KEY (`usercod`,`rolescod`),
  ADD KEY `rol_usuario_key_idx` (`rolescod`);

--
-- Indices de la tabla `rutas_entrega`
--
ALTER TABLE `rutas_entrega`
  ADD PRIMARY KEY (`id_ruta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usercod`),
  ADD UNIQUE KEY `useremail_UNIQUE` (`useremail`),
  ADD KEY `usertipo` (`usertipo`,`useremail`,`usercod`,`userest`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`venta_id`),
  ADD KEY `fk_venta_direccion` (`direccion_id`),
  ADD KEY `idx_ventas_usuario` (`usercod`),
  ADD KEY `idx_ventas_fecha` (`venta_fecha`),
  ADD KEY `idx_ventas_estado` (`venta_estado`),
  ADD KEY `idx_ventas_metodo` (`metodo_pago_id`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`detalle_venta_id`),
  ADD KEY `idx_venta_detalle_venta` (`venta_id`),
  ADD KEY `idx_venta_detalle_producto` (`producto_id`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `uq_wishlist` (`usercod`,`producto_id`),
  ADD KEY `idx_wishlist_usuario` (`usercod`),
  ADD KEY `idx_wishlist_producto` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `bitacoracod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `carrito_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  MODIFY `detalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `direcciones_usuario`
--
ALTER TABLE `direcciones_usuario`
  MODIFY `direccion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario_movimientos`
--
ALTER TABLE `inventario_movimientos`
  MODIFY `movimiento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `marca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `metodo_pago_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `pago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `plataforma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `imagen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rutas_entrega`
--
ALTER TABLE `rutas_entrega`
  MODIFY `id_ruta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usercod` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `venta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `detalle_venta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `fk_bitacora_usuario` FOREIGN KEY (`bitusuario`) REFERENCES `usuario` (`usercod`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);

--
-- Filtros para la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD CONSTRAINT `fk_detalle_carrito` FOREIGN KEY (`carrito_id`) REFERENCES `carrito` (`carrito_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`);

--
-- Filtros para la tabla `direcciones_usuario`
--
ALTER TABLE `direcciones_usuario`
  ADD CONSTRAINT `fk_direccion_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);

--
-- Filtros para la tabla `funciones_roles`
--
ALTER TABLE `funciones_roles`
  ADD CONSTRAINT `funcion_rol_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rol_funcion_key` FOREIGN KEY (`fncod`) REFERENCES `funciones` (`fncod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inventario_movimientos`
--
ALTER TABLE `inventario_movimientos`
  ADD CONSTRAINT `fk_movimiento_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`),
  ADD CONSTRAINT `fk_movimiento_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pago_metodo` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`metodo_pago_id`),
  ADD CONSTRAINT `fk_pago_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`venta_id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`),
  ADD CONSTRAINT `fk_producto_marca` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`marca_id`),
  ADD CONSTRAINT `fk_producto_plataforma` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`plataforma_id`);

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `fk_imagen_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD CONSTRAINT `rol_usuario_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_rol_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_venta_direccion` FOREIGN KEY (`direccion_id`) REFERENCES `direcciones_usuario` (`direccion_id`),
  ADD CONSTRAINT `fk_venta_metodo` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`metodo_pago_id`),
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);

--
-- Filtros para la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD CONSTRAINT `fk_venta_detalle_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`),
  ADD CONSTRAINT `fk_venta_detalle_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`venta_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`),
  ADD CONSTRAINT `fk_wishlist_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
