-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-08-2026 a las 20:43:16
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
-- Base de datos: `gamezone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `bitacoracod` int(11) NOT NULL,
  `bitacorafch` datetime DEFAULT NULL,
  `bitprograma` varchar(255) DEFAULT NULL,
  `bitdescripcion` varchar(255) DEFAULT NULL,
  `bitobservacion` mediumtext DEFAULT NULL,
  `bitTipo` char(3) DEFAULT NULL,
  `bitusuario` bigint(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`bitacoracod`, `bitacorafch`, `bitprograma`, `bitdescripcion`, `bitobservacion`, `bitTipo`, `bitusuario`) VALUES
(382, '2026-08-06 12:25:47', 'Login', 'Intento de inicio de sesión fallido', 'Usuario inexistente: nuevoadmin@gmail.com', 'WAR', NULL),
(383, '2026-08-06 12:25:53', 'Login', 'Intento de inicio de sesión fallido', 'Usuario inexistente: nuevoadmin@gmail.com', 'WAR', NULL),
(384, '2026-08-06 12:27:11', 'Registro', 'Usuario registrado correctamente', 'Correo: admin@gmail.com', 'INS', NULL),
(385, '2026-08-06 12:27:38', 'Logout', 'Cierre de sesión', 'Usuario: admin@gmail.com', 'LOG', 24),
(386, '2026-08-06 12:27:55', 'Registro', 'Usuario registrado correctamente', 'Correo: ventas@gmail.com', 'INS', NULL),
(387, '2026-08-06 12:28:11', 'Logout', 'Cierre de sesión', 'Usuario: ventas@gmail.com', 'LOG', 25),
(388, '2026-08-06 12:28:33', 'Registro', 'Usuario registrado correctamente', 'Correo: invitado@gmail.com', 'INS', NULL),
(389, '2026-08-06 12:28:49', 'Logout', 'Cierre de sesión', 'Usuario: invitado@gmail.com', 'LOG', 26),
(390, '2026-08-06 12:29:01', 'Registro', 'Usuario registrado correctamente', 'Correo: auditor@gmail.com', 'INS', NULL),
(391, '2026-08-06 12:29:25', 'Logout', 'Cierre de sesión', 'Usuario: auditor@gmail.com', 'LOG', 27),
(392, '2026-08-06 12:31:48', 'Seguridad', 'Rol removido de usuario', 'Usuario: 25 Rol: 3', 'WAR', 24),
(393, '2026-08-06 12:31:50', 'Seguridad', 'Rol asignado a usuario', 'Usuario: 25 Rol: 2', 'LOG', 24),
(394, '2026-08-06 12:32:08', 'Seguridad', 'Rol removido de usuario', 'Usuario: 27 Rol: 3', 'WAR', 24),
(395, '2026-08-06 12:32:11', 'Seguridad', 'Rol asignado a usuario', 'Usuario: 27 Rol: 4', 'LOG', 24),
(396, '2026-08-06 12:36:20', 'Dashboard', 'Acceso al dashboard', 'El usuario consultó el panel administrativo.', 'LOG', 24),
(397, '2026-08-06 12:37:50', 'Logout', 'Cierre de sesión', 'Usuario: admin@gmail.com', 'LOG', 24),
(398, '2026-08-06 12:38:12', 'Favoritos', 'Producto agregado a favoritos', 'Usuario ID: 26 agregó producto ID: 21', 'LOG', 26),
(399, '2026-08-06 12:38:21', 'Favoritos', 'Producto agregado a favoritos', 'Usuario ID: 26 agregó producto ID: 1', 'LOG', 26),
(400, '2026-08-06 12:38:27', 'Favoritos', 'Producto agregado a favoritos', 'Usuario ID: 26 agregó producto ID: 4', 'LOG', 26),
(401, '2026-08-06 12:38:34', 'Favoritos', 'Producto agregado a favoritos', 'Usuario ID: 26 agregó producto ID: 14', 'LOG', 26),
(402, '2026-08-06 12:38:41', 'Carrito', 'Producto agregado al carrito', 'Producto ID: 21', 'LOG', 26),
(403, '2026-08-06 12:39:52', 'Checkout', 'Compra realizada correctamente', 'Venta ID: 30 Total: $79.99', 'LOG', 26),
(404, '2026-08-06 12:40:36', 'Carrito', 'Producto agregado al carrito', 'Producto ID: 1', 'LOG', 26),
(405, '2026-08-06 12:40:40', 'Carrito', 'Producto agregado al carrito', 'Producto ID: 4', 'LOG', 26),
(406, '2026-08-06 12:40:55', 'Checkout', 'Compra realizada correctamente', 'Venta ID: 31 Total: $139.98', 'LOG', 26),
(407, '2026-08-06 12:41:36', 'Logout', 'Cierre de sesión', 'Usuario: invitado@gmail.com', 'LOG', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

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
(1, 'Acción', 'Videojuegos de acción', 'ACT', '2026-07-22 07:05:16', NULL),
(2, 'Aventura', 'Videojuegos de aventura', 'ACT', '2026-07-22 07:05:16', NULL),
(3, 'RPG', 'Juegos de rol', 'ACT', '2026-07-22 07:05:16', NULL),
(4, 'Deportes', 'Juegos deportivos', 'ACT', '2026-07-22 07:05:16', NULL),
(5, 'Carreras', 'Juegos de carreras', 'ACT', '2026-07-22 07:05:16', NULL),
(6, 'Terror', 'Juegos de terror', 'ACT', '2026-07-22 07:05:16', NULL),
(7, 'Estrategia', 'Juegos de estrategia', 'ACT', '2026-07-22 07:05:16', NULL),
(8, 'Simulación', 'Juegos de simulación', 'ACT', '2026-07-22 07:05:16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_usuario`
--

CREATE TABLE `direcciones_usuario` (
  `direccion_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `direccion_alias` varchar(50) DEFAULT NULL,
  `direccion_receptor` varchar(150) NOT NULL,
  `direccion_telefono` varchar(20) NOT NULL,
  `direccion_departamento` varchar(100) NOT NULL,
  `direccion_ciudad` varchar(100) NOT NULL,
  `id_ruta` int(11) DEFAULT NULL,
  `direccion_detalle` text NOT NULL,
  `direccion_referencia` text DEFAULT NULL,
  `direccion_predeterminada` tinyint(1) DEFAULT 0,
  `direccion_estado` char(3) DEFAULT 'ACT',
  `direccion_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `direccion_fecha_actualizacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones_usuario`
--

INSERT INTO `direcciones_usuario` (`direccion_id`, `usercod`, `direccion_alias`, `direccion_receptor`, `direccion_telefono`, `direccion_departamento`, `direccion_ciudad`, `id_ruta`, `direccion_detalle`, `direccion_referencia`, `direccion_predeterminada`, `direccion_estado`, `direccion_fecha_creacion`, `direccion_fecha_actualizacion`) VALUES
(9, 26, 'ejemplo', 'ejemplo', '98765432', 'Francisco Morazán', 'Tegucigalpa', 8, 'Ejemplo', 'Ejemplo', 1, 'ACT', '2026-08-06 18:39:15', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `favorito_id` int(11) NOT NULL,
  `usercod` bigint(10) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `favorito_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`favorito_id`, `usercod`, `producto_id`, `favorito_fecha`) VALUES
(26, 26, 21, '2026-08-06 12:38:12'),
(27, 26, 1, '2026-08-06 12:38:21'),
(28, 26, 4, '2026-08-06 12:38:27'),
(29, 26, 14, '2026-08-06 12:38:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones`
--

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
('Auditoria_Auditoria', 'Menú Auditoría', 'ACT', 'MNU'),
('Auditoria_Bitacora', 'Bitácora Auditoría', 'ACT', 'MNU'),
('Auditoria_Menu', 'Auditoría', 'ACT', 'MNU'),
('Auditoria_Reportes', 'Reportes Auditoría', 'ACT', 'MNU'),
('Bitacora_Menu', 'Bitácora', 'ACT', 'MNU'),
('Catalogo_Catalogo', 'Catálogo de Productos', 'ACT', 'MNU'),
('ControllersCategoriasCategorias', 'Acceso Categorías', 'ACT', 'CTR'),
('ControllersDashboardDashboard', 'Acceso Dashboard', 'ACT', 'CTR'),
('ControllersMenuMenu', 'Menú Administrativo', 'ACT', 'CTR'),
('ControllersPerfilPerfil', 'Pantalla de Perfil', 'ACT', 'CTR'),
('Controllers\\Carrito\\Carrito', 'Controllers\\Carrito\\Carrito', 'ACT', 'CTR'),
('Controllers\\Catalogo\\Catalogo', 'Controllers\\Catalogo\\Catalogo', 'ACT', 'CTR'),
('Controllers\\Catalogo\\Catalogo&mode=DSP', 'Consultar catálogo', 'ACT', 'FNC'),
('Controllers\\Categorias\\Categoria', 'Controllers\\Categorias\\Categoria', 'ACT', 'CTR'),
('Controllers\\Categorias\\Categoria&mode=DEL', 'Eliminar categoría', 'ACT', 'FNC'),
('Controllers\\Categorias\\Categoria&mode=DSP', 'Ver categoría', 'ACT', 'FNC'),
('Controllers\\Categorias\\Categoria&mode=INS', 'Crear categoría', 'ACT', 'FNC'),
('Controllers\\Categorias\\Categoria&mode=UPD', 'Actualizar categoría', 'ACT', 'FNC'),
('Controllers\\Categorias\\Categorias', 'Controllers\\Categorias\\Categorias', 'ACT', 'CTR'),
('Controllers\\Checkout\\Accept', 'Pago exitoso', 'ACT', 'CTR'),
('Controllers\\Checkout\\Checkout', 'Controllers\\Checkout\\Checkout', 'ACT', 'CTR'),
('Controllers\\Checkout\\Error', 'Pago fallido', 'ACT', 'CTR'),
('Controllers\\Dashboard\\Dashboard', 'Controllers\\Dashboard\\Dashboard', 'ACT', 'CTR'),
('Controllers\\Dashboard\\Dashboard&mode=DSP', 'Consultar dashboard', 'ACT', 'FNC'),
('Controllers\\DireccionesUsuario\\DireccionesUsuarios', 'Controllers\\DireccionesUsuario\\DireccionesUsuarios', 'ACT', 'CTR'),
('Controllers\\DireccionesUsuario\\DireccionUsuario', 'Controllers\\DireccionesUsuario\\DireccionUsuario', 'ACT', 'CTR'),
('Controllers\\DireccionesUsuario\\DireccionUsuario&mode=DEL', 'Controllers\\DireccionesUsuario\\DireccionUsuario&mode=DEL', 'ACT', 'FNC'),
('Controllers\\DireccionesUsuario\\DireccionUsuario&mode=INS', 'Controllers\\DireccionesUsuario\\DireccionUsuario&mode=INS', 'ACT', 'FNC'),
('Controllers\\Favoritos\\Favorito', 'Controllers\\Favoritos\\Favorito', 'ACT', 'CTR'),
('Controllers\\Favoritos\\Favoritos', 'Controllers\\Favoritos\\Favoritos', 'ACT', 'CTR'),
('Controllers\\Historial\\Historial', 'Controllers\\Historial\\Historial', 'ACT', 'CTR'),
('Controllers\\Marcas\\Marca', 'Administrar marca', 'ACT', 'CTR'),
('Controllers\\Marcas\\Marca&mode=DEL', 'Eliminar marca', 'ACT', 'ACC'),
('Controllers\\Marcas\\Marca&mode=DSP', 'Ver marca', 'ACT', 'ACC'),
('Controllers\\Marcas\\Marca&mode=INS', 'Crear marca', 'ACT', 'ACC'),
('Controllers\\Marcas\\Marca&mode=UPD', 'Editar marca', 'ACT', 'ACC'),
('Controllers\\Marcas\\Marcas', 'Controllers\\Marcas\\Marcas', 'ACT', 'CTR'),
('Controllers\\Menu\\Menu', 'Controllers\\Menu\\Menu', 'ACT', 'CTR'),
('Controllers\\Perfil\\CambiarPassword', 'Controllers\\Perfil\\CambiarPassword', 'ACT', 'CTR'),
('Controllers\\Perfil\\Perfil', 'Controllers\\Perfil\\Perfil', 'ACT', 'CTR'),
('Controllers\\Perfil\\Perfil&mode=DSP', 'Consultar perfil', 'ACT', 'FNC'),
('Controllers\\Perfil\\Perfil&mode=UPD', 'Actualizar perfil', 'ACT', 'FNC'),
('Controllers\\Plataformas\\Plataforma', 'Administrar Plataforma', 'ACT', 'CTR'),
('Controllers\\Plataformas\\Plataforma&mode=DEL', 'Eliminar Plataforma', 'ACT', 'ACC'),
('Controllers\\Plataformas\\Plataforma&mode=DSP', 'Ver Plataforma', 'ACT', 'ACC'),
('Controllers\\Plataformas\\Plataforma&mode=INS', 'Crear Plataforma', 'ACT', 'ACC'),
('Controllers\\Plataformas\\Plataforma&mode=UPD', 'Editar Plataforma', 'ACT', 'ACC'),
('Controllers\\Plataformas\\Plataformas', 'Gestión de Plataformas', 'ACT', 'CTR'),
('Controllers\\Productos\\Producto', 'Controllers\\Productos\\Producto', 'ACT', 'CTR'),
('Controllers\\Productos\\Producto&mode=DEL', 'Eliminar producto', 'ACT', 'FNC'),
('Controllers\\Productos\\Producto&mode=DSP', 'Ver detalle de producto', 'ACT', 'FNC'),
('Controllers\\Productos\\Producto&mode=INS', 'Crear producto', 'ACT', 'FNC'),
('Controllers\\Productos\\Producto&mode=UPD', 'Actualizar producto', 'ACT', 'FNC'),
('Controllers\\Productos\\Productos', 'Controllers\\Productos\\Productos', 'ACT', 'CTR'),
('Controllers\\Products\\Insertar', 'Insertar Nuevo Producto', 'ACT', 'CTR'),
('Controllers\\Reportes\\Reportes&mode=DSP', 'Consultar reportes', 'ACT', 'FNC'),
('Controllers\\RutasEntregas\\RutaEntrega&mode=DEL', 'Eliminar rutas de entrega', 'ACT', 'DEL'),
('Controllers\\RutasEntregas\\RutaEntrega&mode=DSP', 'Ver rutas de entrega', 'ACT', 'DSP'),
('Controllers\\RutasEntregas\\RutaEntrega&mode=INS', 'Insertar ruta de entrega', 'ACT', 'CTR'),
('Controllers\\RutasEntregas\\RutaEntrega&mode=UPD', 'Editar rutas de entrega', 'ACT', 'UPD'),
('Controllers\\RutasEntrega\\RutaEntrega', 'Administrar ruta', 'ACT', 'CTR'),
('Controllers\\RutasEntrega\\RutaEntrega&mode=DEL', 'Eliminar ruta', 'ACT', 'FNC'),
('Controllers\\RutasEntrega\\RutaEntrega&mode=DSP', 'Consultar ruta', 'ACT', 'FNC'),
('Controllers\\RutasEntrega\\RutaEntrega&mode=INS', 'Crear ruta', 'ACT', 'FNC'),
('Controllers\\RutasEntrega\\RutaEntrega&mode=UPD', 'Editar ruta', 'ACT', 'FNC'),
('Controllers\\RutasEntrega\\RutasEntrega', 'Controllers\\RutasEntrega\\RutasEntrega', 'ACT', 'CTR'),
('Controllers\\Security\\Bitacora', 'Controllers\\Security\\Bitacora', 'ACT', 'CTR'),
('Controllers\\Security\\Bitacora&mode=DSP', 'Consultar bitácora', 'ACT', 'FNC'),
('Controllers\\Security\\Funcion', 'Crear/Editar Función', 'ACT', 'CTR'),
('Controllers\\Security\\Funcion&mode=DEL', 'Eliminar Función', 'ACT', 'ACC'),
('Controllers\\Security\\Funcion&mode=DSP', 'Ver Función', 'ACT', 'ACC'),
('Controllers\\Security\\Funcion&mode=INS', 'Crear Función', 'ACT', 'ACC'),
('Controllers\\Security\\Funcion&mode=UPD', 'Editar Función', 'ACT', 'ACC'),
('Controllers\\Security\\Funciones', 'Gestión de Funciones', 'ACT', 'CTR'),
('Controllers\\Security\\FuncionesRoles', 'Administración de Funciones', 'ACT', 'CTR'),
('Controllers\\Security\\FuncionesRoles&mode=DEL', 'Eliminar Función de Rol', 'ACT', 'ACC'),
('Controllers\\Security\\FuncionesRoles&mode=DSP', 'Ver Funciones de Rol', 'ACT', 'ACC'),
('Controllers\\Security\\FuncionesRoles&mode=INS', 'Asignar Función a Rol', 'ACT', 'ACC'),
('Controllers\\Security\\FuncionesRoles&mode=UPD', 'Editar Funciones de Rol', 'ACT', 'ACC'),
('Controllers\\Security\\FuncionRol', 'Administrar Funciones de un Rol', 'ACT', 'CTR'),
('Controllers\\Security\\Rol', 'Administrar Roles', 'ACT', 'CTR'),
('Controllers\\Security\\Rol&mode=DEL', 'Eliminar Rol', 'ACT', 'ACC'),
('Controllers\\Security\\Rol&mode=DSP', 'Ver Rol', 'ACT', 'ACC'),
('Controllers\\Security\\Rol&mode=INS', 'Crear Rol', 'ACT', 'ACC'),
('Controllers\\Security\\Rol&mode=UPD', 'Editar Rol', 'ACT', 'ACC'),
('Controllers\\Security\\Roles', 'Administración de Roles', 'ACT', 'CTR'),
('Controllers\\Security\\RolesUsuarios', 'Controllers\\Security\\RolesUsuarios', 'ACT', 'CTR'),
('Controllers\\Security\\RolUsuario', 'Controllers\\Security\\RolUsuario', 'ACT', 'CTR'),
('Controllers\\Usuarios\\Usuario&mode=DEL', 'Eliminar usuario', 'ACT', 'FNC'),
('Controllers\\Usuarios\\Usuario&mode=DSP', 'Consultar usuario', 'ACT', 'FNC'),
('Controllers\\Usuarios\\Usuario&mode=INS', 'Crear usuario', 'ACT', 'FNC'),
('Controllers\\Usuarios\\Usuario&mode=UPD', 'Actualizar usuario', 'ACT', 'FNC'),
('Controllers\\Ventas\\Detalle', 'Controllers\\Ventas\\Detalle', 'ACT', 'CTR'),
('Controllers\\Ventas\\Detalle&mode=DSP', 'Consultar detalle de venta', 'ACT', 'FNC'),
('Controllers\\Ventas\\Venta&mode=DEL', 'Eliminar venta', 'ACT', 'FNC'),
('Controllers\\Ventas\\Venta&mode=DSP', 'Consultar venta', 'ACT', 'FNC'),
('Controllers\\Ventas\\Venta&mode=INS', 'Crear venta', 'ACT', 'FNC'),
('Controllers\\Ventas\\Venta&mode=UPD', 'Actualizar venta', 'ACT', 'FNC'),
('Controllers\\Ventas\\Ventas', 'Consulta de ventas', 'ACT', 'CTR'),
('Controllers\\Ventas\\Ventas&mode=DSP', 'Ver historial de ventas', 'ACT', 'FNC'),
('DireccionesUsuario', 'Administración de direcciones de usuario', 'ACT', 'CTR'),
('DireccionesUsuario_DEL', 'Eliminar dirección de usuario', 'ACT', 'CTR'),
('DireccionesUsuario_DireccionesUsuarios', 'Listado direcciones usuario', 'ACT', 'CTR'),
('DireccionesUsuario_DireccionUsuario', 'Agregar dirección de usuario', 'ACT', 'CTR'),
('DireccionesUsuario_DireccionUsuario&mode=INS', 'Agregar dirección de usuario', 'ACT', 'FNC'),
('DireccionesUsuario_DSP', 'Ver direcciones de usuario', 'ACT', 'CTR'),
('DireccionesUsuario_INS', 'Agregar dirección de usuario', 'ACT', 'CTR'),
('DireccionesUsuario_UPD', 'Editar dirección de usuario', 'ACT', 'CTR'),
('favoritos', 'Acceso al módulo de favoritos', 'ACT', 'CTR'),
('Marcas_Menu', 'Menú Marcas', 'ACT', 'MNU'),
('Menu_Admin', 'Menu_Admin', 'ACT', 'MNU'),
('Menu_Auditoria', 'Menú auditoría', 'ACT', 'FNC'),
('Menu_Bitacora', 'Menu_Bitacora', 'ACT', 'FNC'),
('Menu_Carrito', 'Menu_Carrito', 'ACT', 'MNU'),
('Menu_Catalogo', 'Menu_Catalogo', 'ACT', 'MNU'),
('Menu_Categorias', 'Menu_Categorias', 'ACT', 'MNU'),
('Menu_Checkout', 'Menu_Checkout', 'ACT', 'MNU'),
('Menu_Dashboard', 'Menu_Dashboard', 'ACT', 'MNU'),
('Menu_DireccionesUsuario', 'Menu_DireccionesUsuario', 'ACT', 'FNC'),
('Menu_Favoritos', 'Menú favoritos', 'ACT', 'FNC'),
('Menu_Funciones', 'Menu_Funciones', 'ACT', 'MNU'),
('Menu_FuncionesRoles', 'Menu_FuncionesRoles', 'ACT', 'MNU'),
('Menu_FuncionRol', 'Menu_FuncionRol', 'ACT', 'MNU'),
('Menu_Historial', 'Menu_Historial', 'ACT', 'MNU'),
('Menu_PaymentCheckout', 'Menu_PaymentCheckout', 'ACT', 'MNU'),
('Menu_Perfil', 'Menu_Perfil', 'ACT', 'MNU'),
('Menu_Plataformas', 'Menu_Plataformas', 'ACT', 'MNU'),
('Menu_Principal', 'Menu_Principal', 'ACT', 'MNU'),
('Menu_Productos', 'Menu_Productos', 'ACT', 'MNU'),
('Menu_Reportes', 'Menu_Reportes', 'ACT', 'MNU'),
('Menu_RolesUsuarios', 'Menu_RolesUsuarios', 'ACT', 'MNU'),
('Menu_RolUsuario', 'Menu_RolUsuario', 'ACT', 'MNU'),
('Menu_RutasEntrega', 'Menu_RutasEntrega', 'ACT', 'MNU'),
('Menu_Usuarios', 'Menu_Usuarios', 'ACT', 'MNU'),
('Menu_Ventas', 'Menu_Ventas', 'ACT', 'MNU'),
('Productos_Imagenes', 'Administración de imágenes de productos', 'ACT', 'CTR'),
('Productos_Imagenes_DEL', 'Eliminar imágenes de productos', 'ACT', 'CTR'),
('Productos_Imagenes_DSP', 'Ver imágenes de productos', 'ACT', 'CTR'),
('Productos_Imagenes_INS', 'Agregar imágenes de productos', 'ACT', 'CTR'),
('Productos_Imagenes_UPD', 'Editar imágenes de productos', 'ACT', 'CTR'),
('Reportes_Menu', 'Reportes', 'ACT', 'MNU'),
('Security_Bitacora', 'Bitácora', 'ACT', 'CTR'),
('Ventas_Detalle', 'Consultar detalle de una venta', 'ACT', 'CTR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones_roles`
--

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
('1', '1', 'ACT', NULL),
('1', '2', 'ACT', NULL),
('1', 'Auditoria_Auditoria', 'ACT', NULL),
('1', 'Auditoria_Bitacora', 'ACT', NULL),
('1', 'Auditoria_Menu', 'ACT', NULL),
('1', 'Auditoria_Reportes', 'ACT', NULL),
('1', 'Bitacora_Menu', 'ACT', NULL),
('1', 'Catalogo_Catalogo', 'ACT', NULL),
('1', 'ControllersCategoriasCategorias', 'ACT', NULL),
('1', 'ControllersDashboardDashboard', 'ACT', NULL),
('1', 'ControllersMenuMenu', 'ACT', NULL),
('1', 'ControllersPerfilPerfil', 'ACT', NULL),
('1', 'Controllers\\Carrito\\Carrito', 'ACT', NULL),
('1', 'Controllers\\Catalogo\\Catalogo', 'ACT', NULL),
('1', 'Controllers\\Catalogo\\Catalogo&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Categorias\\Categoria', 'ACT', '2030-12-31 23:59:59'),
('1', 'Controllers\\Categorias\\Categoria&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Categorias\\Categoria&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Categorias\\Categoria&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Categorias\\Categoria&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Categorias\\Categorias', 'ACT', '2030-12-31 23:59:59'),
('1', 'Controllers\\Checkout\\Accept', 'ACT', NULL),
('1', 'Controllers\\Checkout\\Checkout', 'ACT', NULL),
('1', 'Controllers\\Checkout\\Error', 'ACT', NULL),
('1', 'Controllers\\Dashboard\\Dashboard', 'ACT', '2030-12-31 23:59:59'),
('1', 'Controllers\\Dashboard\\Dashboard&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\DireccionesUsuario\\DireccionesUsuarios', 'ACT', NULL),
('1', 'Controllers\\DireccionesUsuario\\DireccionUsuario', 'ACT', NULL),
('1', 'Controllers\\DireccionesUsuario\\DireccionUsuario&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Favoritos\\Favorito', 'ACT', NULL),
('1', 'Controllers\\Favoritos\\Favoritos', 'ACT', NULL),
('1', 'Controllers\\Historial\\Historial', 'ACT', NULL),
('1', 'Controllers\\Marcas\\Marca', 'ACT', NULL),
('1', 'Controllers\\Marcas\\Marca&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Marcas\\Marca&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Marcas\\Marca&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Marcas\\Marca&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Marcas\\Marcas', 'ACT', NULL),
('1', 'Controllers\\Menu\\Menu', 'ACT', '2030-12-31 23:59:59'),
('1', 'Controllers\\Perfil\\CambiarPassword', 'ACT', NULL),
('1', 'Controllers\\Perfil\\Perfil', 'ACT', NULL),
('1', 'Controllers\\Perfil\\Perfil&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Perfil\\Perfil&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Plataformas\\Plataforma', 'ACT', NULL),
('1', 'Controllers\\Plataformas\\Plataforma&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Plataformas\\Plataforma&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Plataformas\\Plataforma&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Plataformas\\Plataforma&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Plataformas\\Plataformas', 'ACT', NULL),
('1', 'Controllers\\Productos\\Producto', 'ACT', NULL),
('1', 'Controllers\\Productos\\Producto&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Productos\\Producto&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Productos\\Producto&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Productos\\Producto&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Productos\\Productos', 'ACT', NULL),
('1', 'Controllers\\Products\\Insertar', 'ACT', NULL),
('1', 'Controllers\\Reportes\\Reportes&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\RutasEntregas\\RutaEntrega&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\RutasEntregas\\RutaEntrega&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\RutasEntregas\\RutaEntrega&mode=INS', 'ACT', NULL),
('1', 'Controllers\\RutasEntregas\\RutaEntrega&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\RutasEntrega\\RutaEntrega', 'ACT', NULL),
('1', 'Controllers\\RutasEntrega\\RutaEntrega&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\RutasEntrega\\RutaEntrega&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\RutasEntrega\\RutaEntrega&mode=INS', 'ACT', NULL),
('1', 'Controllers\\RutasEntrega\\RutaEntrega&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\RutasEntrega\\RutasEntrega', 'ACT', NULL),
('1', 'Controllers\\Security\\Bitacora', 'ACT', '2099-12-31 00:00:00'),
('1', 'Controllers\\Security\\Bitacora&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Security\\Funcion', 'ACT', NULL),
('1', 'Controllers\\Security\\Funcion&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Security\\Funcion&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Security\\Funcion&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Security\\Funcion&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Security\\Funciones', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionesRoles', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionesRoles&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionesRoles&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionesRoles&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionesRoles&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Security\\FuncionRol', 'ACT', NULL),
('1', 'Controllers\\Security\\Rol', 'ACT', NULL),
('1', 'Controllers\\Security\\Rol&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Security\\Rol&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Security\\Rol&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Security\\Rol&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Security\\Roles', 'ACT', NULL),
('1', 'Controllers\\Security\\RolesUsuarios', 'ACT', NULL),
('1', 'Controllers\\Security\\RolUsuario', 'ACT', NULL),
('1', 'Controllers\\Usuarios\\Usuario&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Usuarios\\Usuario&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Usuarios\\Usuario&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Usuarios\\Usuario&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Detalle', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Detalle&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Venta&mode=DEL', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Venta&mode=DSP', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Venta&mode=INS', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Venta&mode=UPD', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Ventas', 'ACT', NULL),
('1', 'Controllers\\Ventas\\Ventas&mode=DSP', 'ACT', NULL),
('1', 'DireccionesUsuario', 'ACT', NULL),
('1', 'DireccionesUsuario_DEL', 'ACT', NULL),
('1', 'DireccionesUsuario_DireccionesUsuarios', 'ACT', NULL),
('1', 'DireccionesUsuario_DireccionUsuario', 'ACT', NULL),
('1', 'DireccionesUsuario_DireccionUsuario&mode=INS', 'ACT', NULL),
('1', 'DireccionesUsuario_DSP', 'ACT', NULL),
('1', 'DireccionesUsuario_INS', 'ACT', NULL),
('1', 'DireccionesUsuario_UPD', 'ACT', NULL),
('1', 'favoritos', 'ACT', NULL),
('1', 'Marcas_Menu', 'ACT', NULL),
('1', 'Menu_Admin', 'ACT', NULL),
('1', 'Menu_Auditoria', 'ACT', NULL),
('1', 'Menu_Bitacora', 'ACT', NULL),
('1', 'Menu_Carrito', 'ACT', NULL),
('1', 'Menu_Catalogo', 'ACT', NULL),
('1', 'Menu_Categorias', 'ACT', NULL),
('1', 'Menu_Checkout', 'ACT', NULL),
('1', 'Menu_Dashboard', 'ACT', NULL),
('1', 'Menu_DireccionesUsuario', 'ACT', NULL),
('1', 'Menu_Favoritos', 'ACT', NULL),
('1', 'Menu_Funciones', 'ACT', NULL),
('1', 'Menu_FuncionesRoles', 'ACT', NULL),
('1', 'Menu_FuncionRol', 'ACT', NULL),
('1', 'Menu_Historial', 'ACT', NULL),
('1', 'Menu_PaymentCheckout', 'ACT', NULL),
('1', 'Menu_Perfil', 'ACT', NULL),
('1', 'Menu_Plataformas', 'ACT', NULL),
('1', 'Menu_Principal', 'ACT', NULL),
('1', 'Menu_Productos', 'ACT', NULL),
('1', 'Menu_Reportes', 'ACT', NULL),
('1', 'Menu_RolesUsuarios', 'ACT', NULL),
('1', 'Menu_RolUsuario', 'ACT', NULL),
('1', 'Menu_RutasEntrega', 'ACT', NULL),
('1', 'Menu_Usuarios', 'ACT', NULL),
('1', 'Menu_Ventas', 'ACT', NULL),
('1', 'Productos_Imagenes', 'ACT', NULL),
('1', 'Productos_Imagenes_DEL', 'ACT', NULL),
('1', 'Productos_Imagenes_DSP', 'ACT', NULL),
('1', 'Productos_Imagenes_INS', 'ACT', NULL),
('1', 'Productos_Imagenes_UPD', 'ACT', NULL),
('1', 'Reportes_Menu', 'ACT', NULL),
('1', 'Security_Bitacora', 'ACT', NULL),
('1', 'Ventas_Detalle', 'ACT', NULL),
('2', 'ControllersCategoriasCategorias', 'INA', NULL),
('2', 'ControllersDashboardDashboard', 'INA', NULL),
('2', 'ControllersPerfilPerfil', 'ACT', NULL),
('2', 'Controllers\\Carrito\\Carrito', 'ACT', NULL),
('2', 'Controllers\\Catalogo\\Catalogo', 'ACT', NULL),
('2', 'Controllers\\Catalogo\\Catalogo&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Categorias\\Categoria', 'INA', NULL),
('2', 'Controllers\\Categorias\\Categoria&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Categorias\\Categorias', 'INA', NULL),
('2', 'Controllers\\Dashboard\\Dashboard', 'ACT', NULL),
('2', 'Controllers\\Dashboard\\Dashboard&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Menu\\Menu', 'ACT', '2030-12-31 23:59:59'),
('2', 'Controllers\\Perfil\\Perfil', 'ACT', NULL),
('2', 'Controllers\\Perfil\\Perfil&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Productos\\Producto', 'ACT', NULL),
('2', 'Controllers\\Productos\\Producto&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Productos\\Productos', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Detalle', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Detalle&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Venta&mode=DSP', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Venta&mode=INS', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Venta&mode=UPD', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Ventas', 'ACT', NULL),
('2', 'Controllers\\Ventas\\Ventas&mode=DSP', 'ACT', NULL),
('2', 'Menu_Carrito', 'INA', NULL),
('2', 'Menu_Catalogo', 'INA', '2030-12-31 23:59:59'),
('2', 'Menu_Categorias', 'INA', NULL),
('2', 'Menu_Checkout', 'INA', '2030-12-31 23:59:59'),
('2', 'Menu_Dashboard', 'INA', NULL),
('2', 'Menu_Historial', 'INA', '2030-12-31 23:59:59'),
('2', 'Menu_PaymentCheckout', 'INA', NULL),
('2', 'Menu_Perfil', 'INA', '2030-12-31 23:59:59'),
('2', 'Menu_Productos', 'INA', '2030-12-31 23:59:59'),
('2', 'Menu_Ventas', 'ACT', '2030-12-31 23:59:59'),
('2', 'Ventas_Detalle', 'ACT', NULL),
('3', 'ControllersPerfilPerfil', 'ACT', NULL),
('3', 'Controllers\\Carrito\\Carrito', 'ACT', NULL),
('3', 'Controllers\\Catalogo\\Catalogo', 'ACT', NULL),
('3', 'Controllers\\Catalogo\\Catalogo&mode=DSP', 'ACT', NULL),
('3', 'Controllers\\Checkout\\Accept', 'ACT', NULL),
('3', 'Controllers\\Checkout\\Checkout', 'ACT', NULL),
('3', 'Controllers\\Checkout\\Error', 'ACT', NULL),
('3', 'Controllers\\DireccionesUsuario\\DireccionesUsuarios', 'ACT', NULL),
('3', 'Controllers\\DireccionesUsuario\\DireccionUsuario', 'ACT', NULL),
('3', 'Controllers\\DireccionesUsuario\\DireccionUsuario&mode=DEL', 'ACT', NULL),
('3', 'Controllers\\DireccionesUsuario\\DireccionUsuario&mode=INS', 'ACT', NULL),
('3', 'Controllers\\Favoritos\\Favorito', 'ACT', NULL),
('3', 'Controllers\\Favoritos\\Favoritos', 'ACT', NULL),
('3', 'Controllers\\Historial\\Historial', 'ACT', NULL),
('3', 'Controllers\\Perfil\\Perfil', 'ACT', NULL),
('3', 'Controllers\\Perfil\\Perfil&mode=DSP', 'ACT', NULL),
('3', 'Controllers\\Perfil\\Perfil&mode=UPD', 'ACT', NULL),
('3', 'Controllers\\Ventas\\Detalle', 'INA', NULL),
('3', 'DireccionesUsuario', 'INA', NULL),
('3', 'DireccionesUsuario_DEL', 'INA', NULL),
('3', 'DireccionesUsuario_DireccionesUsuarios', 'ACT', NULL),
('3', 'DireccionesUsuario_DireccionUsuario', 'INA', NULL),
('3', 'DireccionesUsuario_DireccionUsuario&mode=INS', 'INA', NULL),
('3', 'DireccionesUsuario_DSP', 'INA', NULL),
('3', 'DireccionesUsuario_INS', 'INA', NULL),
('3', 'DireccionesUsuario_UPD', 'INA', NULL),
('3', 'Menu_Carrito', 'ACT', NULL),
('3', 'Menu_Checkout', 'ACT', NULL),
('3', 'Menu_Favoritos', 'ACT', NULL),
('3', 'Menu_Historial', 'ACT', NULL),
('3', 'Menu_Perfil', 'ACT', NULL),
('3', 'Menu_RutasEntrega', 'INA', NULL),
('3', 'Menu_Ventas', 'INA', NULL),
('4', 'Auditoria_Auditoria', 'ACT', NULL),
('4', 'Auditoria_Bitacora', 'ACT', NULL),
('4', 'Auditoria_Menu', 'ACT', NULL),
('4', 'Auditoria_Reportes', 'ACT', NULL),
('4', 'Bitacora_Menu', 'ACT', NULL),
('4', 'ControllersPerfilPerfil', 'ACT', NULL),
('4', 'Controllers\\Carrito\\Carrito', 'ACT', NULL),
('4', 'Controllers\\Catalogo\\Catalogo', 'ACT', NULL),
('4', 'Controllers\\Catalogo\\Catalogo&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Categorias\\Categoria', 'ACT', NULL),
('4', 'Controllers\\Categorias\\Categoria&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Categorias\\Categorias', 'ACT', NULL),
('4', 'Controllers\\Dashboard\\Dashboard', 'ACT', NULL),
('4', 'Controllers\\Dashboard\\Dashboard&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Historial\\Historial', 'ACT', NULL),
('4', 'Controllers\\Marcas\\Marca', 'ACT', NULL),
('4', 'Controllers\\Marcas\\Marca&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Marcas\\Marcas', 'ACT', NULL),
('4', 'Controllers\\Menu\\Menu', 'ACT', '2030-12-31 23:59:59'),
('4', 'Controllers\\Perfil\\CambiarPassword', 'ACT', NULL),
('4', 'Controllers\\Perfil\\Perfil', 'ACT', NULL),
('4', 'Controllers\\Perfil\\Perfil&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Perfil\\Perfil&mode=UPD', 'ACT', NULL),
('4', 'Controllers\\Plataformas\\Plataforma', 'ACT', NULL),
('4', 'Controllers\\Plataformas\\Plataforma&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Plataformas\\Plataformas', 'ACT', NULL),
('4', 'Controllers\\Productos\\Producto', 'ACT', NULL),
('4', 'Controllers\\Productos\\Producto&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Productos\\Productos', 'ACT', NULL),
('4', 'Controllers\\Reportes\\Reportes&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\RutasEntregas\\RutaEntrega&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\RutasEntrega\\RutaEntrega', 'ACT', NULL),
('4', 'Controllers\\RutasEntrega\\RutaEntrega&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\RutasEntrega\\RutasEntrega', 'ACT', NULL),
('4', 'Controllers\\Security\\Bitacora', 'ACT', NULL),
('4', 'Controllers\\Security\\Bitacora&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Security\\Funcion', 'ACT', NULL),
('4', 'Controllers\\Security\\Funcion&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Security\\Funciones', 'ACT', NULL),
('4', 'Controllers\\Security\\FuncionesRoles', 'ACT', NULL),
('4', 'Controllers\\Security\\FuncionesRoles&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Security\\FuncionRol', 'INA', NULL),
('4', 'Controllers\\Security\\Rol', 'ACT', NULL),
('4', 'Controllers\\Security\\Rol&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Security\\Roles', 'ACT', NULL),
('4', 'Controllers\\Security\\RolesUsuarios', 'ACT', NULL),
('4', 'Controllers\\Security\\RolUsuario', 'INA', NULL),
('4', 'Controllers\\Usuarios\\Usuario&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Ventas\\Detalle', 'ACT', NULL),
('4', 'Controllers\\Ventas\\Detalle&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Ventas\\Venta&mode=DSP', 'ACT', NULL),
('4', 'Controllers\\Ventas\\Ventas', 'ACT', NULL),
('4', 'Controllers\\Ventas\\Ventas&mode=DSP', 'ACT', NULL),
('4', 'DireccionesUsuario', 'ACT', NULL),
('4', 'DireccionesUsuario_DSP', 'ACT', NULL),
('4', 'Marcas_Menu', 'ACT', NULL),
('4', 'Menu_FuncionesRoles', 'INA', NULL),
('4', 'Menu_Perfil', 'ACT', NULL),
('4', 'Menu_Plataformas', 'ACT', NULL),
('4', 'Menu_RutasEntrega', 'INA', NULL),
('4', 'Menu_Ventas', 'ACT', NULL),
('4', 'Reportes_Menu', 'ACT', NULL),
('4', 'Ventas_Detalle', 'ACT', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_movimientos`
--

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
(1, 'Sony', 'PlayStation Studios', 'ACT', '2026-07-22 07:05:37', NULL),
(2, 'Microsoft', 'Xbox Game Studios', 'ACT', '2026-07-22 07:05:37', NULL),
(3, 'Nintendo', 'Nintendo', 'ACT', '2026-07-22 07:05:37', NULL),
(4, 'Ubisoft', 'Ubisoft Entertainment', 'ACT', '2026-07-22 07:05:37', NULL),
(5, 'Electronic Arts', 'EA', 'ACT', '2026-07-22 07:05:37', NULL),
(6, 'Rockstar Games', 'Rockstar Games', 'ACT', '2026-07-22 07:05:37', NULL),
(7, 'Activision', 'Activision', 'ACT', '2026-07-22 07:05:37', NULL),
(8, 'Square Enix', 'Square Enix', 'ACT', '2026-07-22 07:05:37', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

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
(1, 'Efectivo', 'Pago en efectivo al momento de la entrega', 'ACT', '2026-07-22 07:05:05'),
(2, 'Tarjeta de Crédito', 'Pago mediante tarjeta de crédito', 'ACT', '2026-07-22 07:05:05'),
(3, 'Tarjeta de Débito', 'Pago mediante tarjeta de débito', 'ACT', '2026-07-22 07:05:05'),
(4, 'Transferencia Bancaria', 'Transferencia bancaria', 'ACT', '2026-07-22 07:05:05'),
(5, 'PayPal', 'Pago mediante PayPal', 'ACT', '2026-07-22 07:05:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `pago_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `metodo_pago_id` int(11) NOT NULL,
  `pago_monto` decimal(10,2) NOT NULL,
  `pago_referencia` varchar(150) DEFAULT NULL,
  `pago_estado` char(3) DEFAULT 'PEN',
  `pago_fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`pago_id`, `venta_id`, `metodo_pago_id`, `pago_monto`, `pago_referencia`, `pago_estado`, `pago_fecha`) VALUES
(26, 30, 5, 79.99, '0T338913HJ517493C', 'APR', '2026-08-06 18:39:52'),
(27, 31, 5, 139.98, '5TF71715AV5931932', 'APR', '2026-08-06 18:40:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas`
--

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
(1, 'PC', 'Computadora', 'ACT', '2026-07-22 07:05:26', NULL),
(2, 'PlayStation 5', 'Consola Sony', 'ACT', '2026-07-22 07:05:26', NULL),
(3, 'Xbox Series X', 'Consola Microsoft', 'ACT', '2026-07-22 07:05:26', NULL),
(4, 'Nintendo Switch', 'Consola Nintendo', 'ACT', '2026-07-22 07:05:26', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

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

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`producto_id`, `categoria_id`, `marca_id`, `plataforma_id`, `producto_sku`, `producto_nombre`, `producto_slug`, `producto_descripcion`, `producto_costo`, `producto_precio`, `producto_stock`, `producto_activo_web`, `producto_estado`, `producto_fecha_publicacion`, `producto_fecha_creacion`, `producto_fecha_actualizacion`) VALUES
(1, 1, 1, 2, 'SKU-SPIDER2-PS5', 'Marvel\'s Spider-Man 2', 'marvels-spider-man-2-ps5', 'Disfruta de la emocionante continuación de la saga de Spider-Man desarrollada por Insomniac Games para PlayStation 5.', 45.00, 69.99, 1, 'ACT', 'ACT', '2026-07-29 00:17:07', '2026-07-29 00:17:07', '2026-08-06 18:40:55'),
(2, 3, 2, 3, 'SKU-STARFIELD-XSX', 'Starfield', 'starfield-xbox-series-x', 'Explora el espacio infinito y descubre los mayores misterios de la humanidad en este RPG de nueva generación de Bethesda.', 50.00, 69.99, 15, 'ACT', 'ACT', '2026-07-29 00:17:07', '2026-07-29 00:17:07', NULL),
(3, 2, 3, 4, 'SKU-ZELDA-NSW', 'The Legend of Zelda: Tears of the Kingdom', 'the-legend-of-zelda-tears-of-the-kingdom-switch', 'Una aventura épica a través de los paisajes y los cielos de Hyrule en la consola Nintendo Switch.', 42.00, 69.99, 30, 'ACT', 'ACT', '2026-07-29 00:17:07', '2026-07-29 00:17:07', NULL),
(4, 1, 1, 2, 'SKU-GOWR-PS5', 'God of War Ragnarök', 'god-of-war-ragnarok-ps5', 'Embárcate en una aventura épica junto a Kratos y Atreus mientras enfrentan el Ragnarök en una historia llena de acción y mitología nórdica.', 48.00, 69.99, 17, 'ACT', 'ACT', '2026-08-02 06:44:43', '2026-08-02 06:44:43', '2026-08-06 18:40:55'),
(5, 5, 2, 3, 'SKU-FORZA-XSX', 'Forza Horizon 5', 'forza-horizon-5-xbox-series-x', 'Explora un enorme mundo abierto inspirado en México con cientos de vehículos y emocionantes competencias.', 40.00, 59.99, 18, 'ACT', 'ACT', '2026-08-02 06:44:43', '2026-08-02 06:44:43', '2026-08-05 00:15:18'),
(6, 2, 3, 4, 'SKU-MARIOWONDER-NSW', 'Super Mario Bros. Wonder', 'super-mario-bros-wonder-switch', 'Disfruta una nueva aventura de Mario con mecánicas innovadoras, mundos coloridos y diversión para toda la familia.', 38.00, 59.99, 33, 'ACT', 'ACT', '2026-08-02 06:44:43', '2026-08-02 06:44:43', '2026-08-06 05:39:28'),
(7, 1, 1, 2, 'SKU-FF7R-PS5', 'Final Fantasy VII Rebirth', 'final-fantasy-vii-rebirth-ps5', 'La nueva aventura de Cloud y sus compañeros continúa con una historia épica.', 48.00, 69.99, 17, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-06 04:55:24'),
(8, 1, 1, 2, 'SKU-HFW-PS5', 'Horizon Forbidden West', 'horizon-forbidden-west-ps5', 'Acompaña a Aloy en una aventura por un mundo postapocalíptico lleno de máquinas.', 42.00, 59.99, 22, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(9, 5, 1, 2, 'SKU-GT7-PS5', 'Gran Turismo 7', 'gran-turismo-7-ps5', 'El simulador de conducción más completo de PlayStation.', 40.00, 59.99, 16, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-05 00:15:35'),
(10, 3, 2, 3, 'SKU-HALOINF-XSX', 'Halo Infinite', 'halo-infinite-xbox-series-x', 'Master Chief regresa para enfrentar una nueva amenaza en Halo.', 39.00, 59.99, 17, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-06 05:35:22'),
(11, 3, 2, 3, 'SKU-FLIGHTSIM-XSX', 'Microsoft Flight Simulator', 'microsoft-flight-simulator-xbox-series-x', 'Vuela por todo el mundo con un nivel de realismo impresionante.', 45.00, 69.99, 14, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(12, 3, 2, 3, 'SKU-DOOMDA-XSX', 'DOOM: The Dark Ages', 'doom-the-dark-ages-xbox-series-x', 'La precuela medieval de DOOM con intensas batallas y acción.', 50.00, 69.99, 12, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(13, 5, 3, 4, 'SKU-MARIOKART8-NSW', 'Mario Kart 8 Deluxe', 'mario-kart-8-deluxe-switch', 'Compite con tus personajes favoritos en carreras llenas de diversión.', 35.00, 59.99, 29, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-05 00:15:03'),
(14, 2, 3, 4, 'SKU-SMASH-NSW', 'Super Smash Bros. Ultimate', 'super-smash-bros-ultimate-switch', 'El juego de peleas definitivo con decenas de personajes icónicos.', 42.00, 59.99, 22, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-06 02:39:48'),
(15, 2, 3, 4, 'SKU-ANIMAL-NSW', 'Animal Crossing: New Horizons', 'animal-crossing-new-horizons-switch', 'Crea y administra tu propia isla paradisíaca.', 38.00, 59.99, 28, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(16, 2, 3, 4, 'SKU-METROID-NSW', 'Metroid Dread', 'metroid-dread-switch', 'Samus Aran regresa en una intensa aventura de acción y exploración.', 37.00, 59.99, 19, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(17, 1, 1, 2, 'SKU-ELDEN-PS5', 'Elden Ring', 'elden-ring-ps5', 'Explora un enorme mundo de fantasía creado por FromSoftware.', 46.00, 59.99, 17, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-06 09:34:36'),
(18, 1, 1, 2, 'SKU-RE4-PS5', 'Resident Evil 4 Remake', 'resident-evil-4-remake-ps5', 'El clásico del survival horror completamente renovado.', 44.00, 59.99, 16, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', '2026-08-06 09:34:36'),
(19, 3, 2, 3, 'SKU-INDIANA-XSX', 'Indiana Jones and the Great Circle', 'indiana-jones-and-the-great-circle-xbox-series-x', 'Vive una aventura llena de exploración, acción y misterios.', 48.00, 69.99, 15, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(20, 2, 3, 4, 'SKU-POKEMONV-NSW', 'Pokémon Violet', 'pokemon-violet-switch', 'Explora la región de Paldea y conviértete en el mejor entrenador Pokémon.', 40.00, 59.99, 26, 'ACT', 'ACT', '2026-08-02 06:49:28', '2026-08-02 06:49:28', NULL),
(21, 1, 1, 2, 'SKU-GTA6-PS5', 'Grand Theft Auto VI', 'grand-theft-auto-vi-ps5', 'Explora el estado ficticio de Leonida en la nueva entrega de la saga Grand Theft Auto, con un enorme mundo abierto y una historia protagonizada por Jason y Lucia.', 55.00, 79.99, 18, 'ACT', 'ACT', '2026-08-02 07:01:21', '2026-08-02 07:01:21', '2026-08-06 18:39:52'),
(22, 1, 1, 2, 'SKU-DEATH2-PS5', 'Death Stranding 2: On the Beach', 'death-stranding-2-on-the-beach-ps5', 'Sam Porter Bridges regresa en una nueva aventura cargada de exploración, acción y una narrativa única.', 52.00, 69.99, 15, 'ACT', 'ACT', '2026-08-02 07:01:21', '2026-08-02 07:01:21', NULL),
(23, 3, 2, 3, 'SKU-FABLE-XSX', 'Fable', 'fable-xbox-series-x', 'La clásica franquicia de RPG regresa con un nuevo mundo lleno de humor, magia y aventuras.', 50.00, 69.99, 18, 'ACT', 'ACT', '2026-08-02 07:01:21', '2026-08-02 07:01:21', NULL),
(24, 2, 3, 4, 'SKU-KIRBYFL-NSW', 'Kirby and the Forgotten Land', 'kirby-and-the-forgotten-land-switch', 'Acompaña a Kirby en una aventura en un misterioso mundo lleno de plataformas, enemigos y habilidades.', 38.00, 59.99, 24, 'ACT', 'ACT', '2026-08-02 07:01:21', '2026-08-02 07:01:21', '2026-08-06 02:00:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `imagen_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `imagen_ruta` varchar(255) NOT NULL,
  `imagen_principal` tinyint(1) DEFAULT 0,
  `imagen_orden` smallint(6) DEFAULT 1,
  `imagen_estado` char(3) DEFAULT 'ACT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_imagenes`
--

INSERT INTO `producto_imagenes` (`imagen_id`, `producto_id`, `imagen_ruta`, `imagen_principal`, `imagen_orden`, `imagen_estado`) VALUES
(1, 1, 'public/imgs/productos/spiderman2.jpg', 0, 1, 'ACT'),
(2, 2, 'public/imgs/productos/starfield.jpg', 0, 1, 'ACT'),
(3, 3, 'public/imgs/productos/zelda.jpg', 0, 1, 'ACT'),
(4, 4, 'public/imgs/productos/gowragnarok.jpg', 0, 1, 'ACT'),
(5, 5, 'public/imgs/productos/forzahorizon5.jpg', 0, 1, 'ACT'),
(6, 6, 'public/imgs/productos/mariowonder.jpg', 0, 1, 'ACT'),
(7, 7, 'public/imgs/productos/ff7rebirth.jpg', 0, 1, 'ACT'),
(8, 8, 'public/imgs/productos/horizonfw.jpg', 0, 1, 'ACT'),
(9, 9, 'public/imgs/productos/granturismo7.jpg', 0, 1, 'ACT'),
(10, 10, 'public/imgs/productos/haloinfinite.jpg', 0, 1, 'ACT'),
(11, 11, 'public/imgs/productos/flightsimulator.jpg', 0, 1, 'ACT'),
(12, 12, 'public/imgs/productos/doomdarkages.jpg', 0, 1, 'ACT'),
(13, 13, 'public/imgs/productos/mariokart8.jpg', 0, 1, 'ACT'),
(14, 14, 'public/imgs/productos/smashultimate.jpg', 0, 1, 'ACT'),
(15, 15, 'public/imgs/productos/animalcrossing.jpg', 0, 1, 'ACT'),
(16, 16, 'public/imgs/productos/metroiddread.jpg', 0, 1, 'ACT'),
(17, 17, 'public/imgs/productos/eldenring.jpg', 0, 1, 'ACT'),
(18, 18, 'public/imgs/productos/re4remake.jpg', 0, 1, 'ACT'),
(19, 19, 'public/imgs/productos/indianajones.jpg', 0, 1, 'ACT'),
(20, 20, 'public/imgs/productos/pokemonviolet.jpg', 0, 1, 'ACT'),
(21, 21, 'public/imgs/productos/gta6.jpg', 0, 1, 'ACT'),
(22, 22, 'public/imgs/productos/deathstranding2.jpg', 0, 1, 'ACT'),
(23, 23, 'public/imgs/productos/fable.jpg', 0, 1, 'ACT'),
(24, 24, 'public/imgs/productos/kirbyforgottenland.jpg', 0, 1, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_stock`
--

CREATE TABLE `reservas_stock` (
  `reserva_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `cantidad_reservada` int(11) NOT NULL DEFAULT 1,
  `reserva_estado` char(3) NOT NULL DEFAULT 'ACT',
  `reserva_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `reserva_fecha_expiracion` datetime NOT NULL,
  `reserva_fecha_confirmacion` datetime DEFAULT NULL,
  `reserva_fecha_liberacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas_stock`
--

INSERT INTO `reservas_stock` (`reserva_id`, `producto_id`, `usercod`, `cantidad_reservada`, `reserva_estado`, `reserva_fecha_creacion`, `reserva_fecha_expiracion`, `reserva_fecha_confirmacion`, `reserva_fecha_liberacion`) VALUES
(45, 21, 26, 1, 'CON', '2026-08-06 18:39:22', '2026-08-06 13:09:22', '2026-08-06 12:39:52', NULL),
(46, 1, 26, 1, 'CON', '2026-08-06 18:40:47', '2026-08-06 13:10:47', '2026-08-06 12:40:55', NULL),
(47, 4, 26, 1, 'CON', '2026-08-06 18:40:47', '2026-08-06 13:10:47', '2026-08-06 12:40:55', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

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
('3', 'Usuario Invitado', 'ACT'),
('4', 'Auditor', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

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
(24, '1', 'ACT', '2026-08-06 12:27:11', NULL),
(25, '2', 'ACT', '2026-08-06 12:31:50', NULL),
(25, '3', 'INA', '2026-08-06 12:27:55', NULL),
(26, '3', 'ACT', '2026-08-06 12:28:33', NULL),
(27, '3', 'INA', '2026-08-06 12:29:01', NULL),
(27, '4', 'ACT', '2026-08-06 12:32:11', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas_entrega`
--

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
(3, 'La Ceiba', 'Tela', 101.75, 110, 'INA'),
(4, 'Tegucigalpa', 'San Pedro Sula', 243.00, 240, 'ACT'),
(5, 'Tegucigalpa', 'La Ceiba', 390.00, 360, 'ACT'),
(6, 'Tegucigalpa', 'Choluteca', 135.00, 150, 'ACT'),
(7, 'Tegucigalpa', 'Danlí', 92.00, 110, 'ACT'),
(8, 'San Pedro Sula', 'Tegucigalpa', 243.00, 240, 'ACT'),
(9, 'San Pedro Sula', 'La Ceiba', 192.00, 210, 'ACT'),
(10, 'San Pedro Sula', 'Copán Ruinas', 174.00, 220, 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

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
(24, 'admin@gmail.com', 'Administrador', '$2y$10$09StbSGmb/VHnz/RbSL1COcXNqMdE8iVZP.7glb0LQ5jKMnY1.XQm', '2026-08-06 12:27:11', 'ACT', '2026-11-04 00:00:00', 'ACT', '036316c289c638c6d89ad8e4a2cf1b3db999b1023170d1bba9af34e0a2d7478e', '2026-08-06 12:27:11', 'PBL'),
(25, 'ventas@gmail.com', 'Ventas', '$2y$10$cQTix34xsnRdwb8Wla610eHl/ZWSKF9H3KJHTkx485o2PRjknrcAq', '2026-08-06 12:27:55', 'ACT', '2026-11-04 00:00:00', 'ACT', 'ab7c4d87f9e8beb00fc6113997ff06e724f31a3adf89d8f7399a18355afb750b', '2026-08-06 12:27:55', 'PBL'),
(26, 'invitado@gmail.com', 'Invitado', '$2y$10$H8OzAdY6r4MS9owHOtTr0OA2.SeB7MWf9KN3volrKkxRyRpoX0bMC', '2026-08-06 12:28:33', 'ACT', '2026-11-04 00:00:00', 'ACT', '50e8cccc449f4c35cdd321253a6a5f05e3b1fad308c4b8dc33e2f8818c56ae15', '2026-08-06 12:28:33', 'PBL'),
(27, 'auditor@gmail.com', 'Auditor', '$2y$10$qCpLSLP8NjeBJ3LvqI372OH6iDdQGAa6eqaa5c6EPw4EKSj9F4lEm', '2026-08-06 12:29:01', 'ACT', '2026-11-04 00:00:00', 'ACT', 'c07288e674ea8f01fb49bdd771a94b47536e5ecd652658c3034dd1cfb1a064cd', '2026-08-06 12:29:01', 'PBL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `venta_id` int(11) NOT NULL,
  `usercod` bigint(20) NOT NULL,
  `direccion_id` int(11) DEFAULT NULL,
  `metodo_pago_id` int(11) NOT NULL,
  `venta_fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `venta_subtotal` decimal(10,2) NOT NULL,
  `venta_impuesto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `venta_descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `venta_total` decimal(10,2) NOT NULL,
  `venta_estado` char(3) DEFAULT 'PEN',
  `venta_observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`venta_id`, `usercod`, `direccion_id`, `metodo_pago_id`, `venta_fecha`, `venta_subtotal`, `venta_impuesto`, `venta_descuento`, `venta_total`, `venta_estado`, `venta_observaciones`) VALUES
(30, 26, 9, 5, '2026-08-06 18:39:52', 79.99, 0.00, 0.00, 79.99, 'APR', NULL),
(31, 26, 9, 5, '2026-08-06 18:40:55', 139.98, 0.00, 0.00, 139.98, 'APR', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

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

--
-- Volcado de datos para la tabla `venta_detalle`
--

INSERT INTO `venta_detalle` (`detalle_venta_id`, `venta_id`, `producto_id`, `producto_nombre`, `precio_unitario`, `cantidad`, `descuento`, `subtotal`) VALUES
(28, 30, 21, 'Grand Theft Auto VI', 79.99, 1, 0.00, 79.99),
(29, 31, 1, 'Marvel\'s Spider-Man 2', 69.99, 1, 0.00, 69.99),
(30, 31, 4, 'God of War Ragnarök', 69.99, 1, 0.00, 69.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

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
  ADD KEY `idx_direcciones_usuario` (`usercod`),
  ADD KEY `fk_direccion_ruta` (`id_ruta`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`favorito_id`),
  ADD UNIQUE KEY `uq_favorito` (`usercod`,`producto_id`),
  ADD KEY `fk_favoritos_producto` (`producto_id`);

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
-- Indices de la tabla `reservas_stock`
--
ALTER TABLE `reservas_stock`
  ADD PRIMARY KEY (`reserva_id`),
  ADD KEY `idx_reserva_producto` (`producto_id`),
  ADD KEY `idx_reserva_usuario` (`usercod`),
  ADD KEY `idx_reserva_estado` (`reserva_estado`);

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
  MODIFY `bitacoracod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=408;

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
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `direcciones_usuario`
--
ALTER TABLE `direcciones_usuario`
  MODIFY `direccion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `favorito_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `pago_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `plataforma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `imagen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `reservas_stock`
--
ALTER TABLE `reservas_stock`
  MODIFY `reserva_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `rutas_entrega`
--
ALTER TABLE `rutas_entrega`
  MODIFY `id_ruta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usercod` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `venta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `detalle_venta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  ADD CONSTRAINT `fk_direccion_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `rutas_entrega` (`id_ruta`),
  ADD CONSTRAINT `fk_direccion_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_favoritos_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_favoritos_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE CASCADE;

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
-- Filtros para la tabla `reservas_stock`
--
ALTER TABLE `reservas_stock`
  ADD CONSTRAINT `fk_reserva_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`),
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`);

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
  ADD CONSTRAINT `fk_venta_metodo` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`metodo_pago_id`),
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`),
  ADD CONSTRAINT `fk_ventas_direccion` FOREIGN KEY (`direccion_id`) REFERENCES `direcciones_usuario` (`direccion_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
