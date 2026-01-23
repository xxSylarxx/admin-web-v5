-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 23-01-2026 a las 20:52:06
-- Versión del servidor: 11.5.2-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `admin_v3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admision`
--

DROP TABLE IF EXISTS `admision`;
CREATE TABLE IF NOT EXISTS `admision` (
  `idadmision` int(11) NOT NULL DEFAULT 1,
  `titulo` varchar(255) DEFAULT NULL,
  `cuerpo` longtext DEFAULT NULL,
  PRIMARY KEY (`idadmision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `admision`
--

INSERT INTO `admision` (`idadmision`, `titulo`, `cuerpo`) VALUES
(1, 'PROCESO DE ADMISIÓN 2026', '<div>\r\n<h1>TITULO DE MATR&Iacute;CULArfff</h1>\r\n<div>\r\n<table style=\"border-collapse: collapse; width: 105.092%; height: 597.781px; border-width: 0px; border-style: none;\" border=\"1\"><colgroup><col style=\"width: 36.4738%;\" /><col style=\"width: 63.5262%;\" /></colgroup>\r\n<tbody>\r\n<tr style=\"height: 10px;\">\r\n<td style=\"border-width: 0px; text-align: justify; height: 597.781px;\" rowspan=\"2\">\r\n<div style=\"text-align: left;\"><br /><strong>PROCESO DE MAT&Iacute;CULA 2026</strong><br />&nbsp;<br />En el colegio Jacques Cousteau nos caracterizamos por nunca dejar de innovar.&nbsp;<br />Por eso renovamos nuestro compromiso para seguir ofreciendo experiencias significativas de aprendizajes a nuestros alumnos.</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div><strong>REQUISITOS:</strong></div>\r\n<div>\r\n<ul>\r\n<li>Certificado de Estudios.</li>\r\n<li>Ficha de Matr&iacute;cula con el c&oacute;digo del educando y del colegio.</li>\r\n<li>Boleta de Notas.&nbsp;</li>\r\n<li>Certificado no adeudo.&nbsp;</li>\r\n<li>Constancia de fecha de pagos.</li>\r\n<li>Copia de D.N.I del alumno. &nbsp;</li>\r\n<li>Copia del D.N.I de los padres.</li>\r\n</ul>\r\n</div>\r\n</td>\r\n<td style=\"border-width: 0px; height: 597.781px;\" rowspan=\"2\">\r\n<div><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://www.colegiojacquescousteau.edu.pe/public/img/galeria/Blue-And-Yellow-Bold-3d-Registration-Announcement-Instagram-Post.png\" width=\"455\" height=\"569\" /></div>\r\n</td>\r\n</tr>\r\n<tr style=\"height: 587.781px;\"></tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<div>&nbsp;</div>\r\n<div><strong>PAGOS:</strong></div>\r\n<div>&nbsp;</div>\r\n<div>\r\n<table style=\"border-collapse: collapse; width: 55.5818%; height: 48px; border-color: #000000;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"background-color: #004fae; height: 24px; border-color: #000000;\">\r\n<td style=\"width: 29.669%; height: 24px; border-color: #000000; text-align: center;\"><span style=\"color: #ffffff;\">NIVEL</span></td>\r\n<td style=\"width: 32.8375%; text-align: center; height: 24px;\"><span style=\"color: #ffffff;\">MATR&Iacute;CULA</span></td>\r\n<td style=\"width: 37.4463%; height: 24px; text-align: center;\"><span style=\"color: #ffffff;\">PENSI&Oacute;N</span></td>\r\n</tr>\r\n<tr style=\"height: 24px;\">\r\n<td style=\"width: 29.669%; text-align: center; height: 24px;\">PRIMARIA - SECUNDARIA</td>\r\n<td style=\"width: 32.8375%; text-align: center; height: 24px;\">S/350.00</td>\r\n<td style=\"width: 37.4463%; text-align: center; height: 24px;\">S/500.00</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<div>\r\n<div>&nbsp;</div>\r\n<div><strong>DEP&Oacute;SITOS:</strong></div>\r\n<ul>\r\n<li>BANCO DE&nbsp;CR&Eacute;DITO CTA. &nbsp;N&ordm;: 193-1081531-0-54&nbsp;</li>\r\n</ul>\r\n<div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (SOCIEDAD ECOLOGISTA JACQUES COUSTEAU)</div>\r\n<ul>\r\n<li>BANCO DE CR&Eacute;DITO C&Oacute;DIGO INTERBANCARIO (CCI) N&ordm;: 002-193-001081531054-14&nbsp;</li>\r\n</ul>\r\n<div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(SOCIEDAD ECOLOGISTA JACQUES COUSTEAU)</div>\r\n<div>&nbsp;</div>\r\n<div><em><strong>Pasado los 7 d&iacute;as no hay opci&oacute;n a devoluci&oacute;</strong></em><em><strong>n de dinero.</strong></em></div>\r\n<div>&nbsp;</div>\r\n<div>Tel&eacute;fonos: 348-1695 / 948886928</div>\r\n<div>E-mail: colegiocousteau2017@gmail.com</div>\r\n<div><strong>NOTA: Toda la documentaci&oacute;n deber&aacute; estar en una mica A4.</strong></div>\r\n<div>&nbsp;</div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div style=\"text-align: center;\"><iframe src=\"../public/files/compromiso-padres.pdf\" width=\"100%\" height=\"720\" frameborder=\"0\"></iframe></div>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL COMMENT 'TRIAL',
  `tipo` varchar(10) NOT NULL COMMENT 'TRIAL',
  `cuerpo` mediumtext DEFAULT NULL COMMENT 'TRIAL',
  `opciones` varchar(255) NOT NULL COMMENT 'TRIAL',
  `estado` varchar(1) DEFAULT NULL,
  `trial646` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `banner`
--

INSERT INTO `banner` (`id`, `tipo`, `cuerpo`, `opciones`, `estado`, `trial646`) VALUES
(1, 'slider', '[{\"imagen\":\"http://admin-web-version3.com/public/img/banner/05.jpg\",\"enlace\":null,\"titulo\":\"EDUCACIÓN INTEGRAL\",\"detalle\":\"Proporcionamos una educación integral que engloba todas las áreas<br>con base en un enfoque holístico, que promueve su desarrollo académico,<br>emocional, ético, social y físico.\"},{\"imagen\":\"http://admin-web-version3.com/public/img/banner/06.jpg\",\"enlace\":null,\"titulo\":\"\",\"detalle\":\"\"}]', '{\"fade\":true,\"dimensionar\":true,\"height\":\"100\",\"indicadores\":true,\"flechas\":true}', 'S', 'T'),
(2, 'video', 'https://www.youtube.com/embed/aphaMYrGH1o', '{\"controls\":true,\"autoplay\":false,\"muted\":false,\"dimensionar\":false,\"youtube\":true}', 'N', 'T');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `idcatg` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nombre` varchar(70) NOT NULL COMMENT 'TRIAL',
  `filtro` varchar(70) NOT NULL COMMENT 'TRIAL',
  `catpad` int(11) DEFAULT NULL COMMENT 'TRIAL',
  `fecreg` datetime DEFAULT NULL COMMENT 'TRIAL',
  `estado` char(1) DEFAULT 'A' COMMENT 'TRIAL',
  `trial652` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`idcatg`),
  UNIQUE KEY `idx_nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcatg`, `nombre`, `filtro`, `catpad`, `fecreg`, `estado`, `trial652`) VALUES
(1, 'Noticias', 'noticias', NULL, '2022-05-29 15:11:31', 'A', 'T'),
(2, 'Eventos', 'eventos', NULL, '2022-05-29 15:11:31', 'A', 'T');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_galerias`
--

DROP TABLE IF EXISTS `categorias_galerias`;
CREATE TABLE IF NOT EXISTS `categorias_galerias` (
  `idcatg` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `fecreg` datetime NOT NULL,
  PRIMARY KEY (`idcatg`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_galerias`
--

INSERT INTO `categorias_galerias` (`idcatg`, `nombre`, `estado`, `fecreg`) VALUES
(1, 'Eventos', 'A', '2026-01-19 09:34:07'),
(2, 'Actividades', 'A', '2026-01-19 09:34:07'),
(3, 'Infraestructura', 'A', '2026-01-19 09:34:07'),
(4, 'Académico', 'A', '2026-01-19 09:34:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `idemp` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nombre` varchar(100) NOT NULL COMMENT 'TRIAL',
  `telefono` varchar(40) DEFAULT NULL COMMENT 'TRIAL',
  `celular` varchar(40) DEFAULT NULL COMMENT 'TRIAL',
  `direccion` varchar(220) DEFAULT NULL COMMENT 'TRIAL',
  `direccion2` varchar(255) DEFAULT NULL,
  `correo1` varchar(100) DEFAULT NULL COMMENT 'TRIAL',
  `correo2` varchar(100) DEFAULT NULL COMMENT 'TRIAL',
  `anio_admision` int(11) NOT NULL,
  `facebook` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `whatsapp1` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `whatsapp2` varchar(200) NOT NULL COMMENT 'TRIAL',
  `instagram` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `youtube` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `twitter` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `linkedin` varchar(250) DEFAULT NULL COMMENT 'TRIAL',
  `tiktok` varchar(255) DEFAULT NULL,
  `intranet` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `liblink` varchar(200) DEFAULT NULL COMMENT 'TRIAL',
  `libmail` varchar(100) DEFAULT NULL COMMENT 'TRIAL',
  `libnume` int(11) DEFAULT NULL COMMENT 'TRIAL',
  `metades` varchar(255) DEFAULT NULL COMMENT 'TRIAL',
  `trial652` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`idemp`),
  UNIQUE KEY `idx_nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idemp`, `nombre`, `telefono`, `celular`, `direccion`, `direccion2`, `correo1`, `correo2`, `anio_admision`, `facebook`, `whatsapp1`, `whatsapp2`, `instagram`, `youtube`, `twitter`, `linkedin`, `tiktok`, `intranet`, `liblink`, `libmail`, `libnume`, `metades`, `trial652`) VALUES
(1, 'ADMIN V5', '1111', '111', '', '', '', '', 2026, '111', '111', '', '11', '', '', '', '', '1', '', '', NULL, '111', 'T');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

DROP TABLE IF EXISTS `galeria`;
CREATE TABLE IF NOT EXISTS `galeria` (
  `idgaleria` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `idcatg` int(11) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL COMMENT 'TRIAL',
  `detalle` varchar(270) DEFAULT NULL COMMENT 'TRIAL',
  `ncolum` int(11) DEFAULT NULL COMMENT 'TRIAL',
  `cuerpo` mediumtext DEFAULT NULL COMMENT 'TRIAL',
  `modo` char(1) DEFAULT 'A' COMMENT 'TRIAL',
  `portada` varchar(300) DEFAULT NULL COMMENT 'TRIAL',
  `fecreg` datetime DEFAULT NULL COMMENT 'TRIAL',
  `visible` char(1) DEFAULT 'N' COMMENT 'TRIAL',
  `trial656` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`idgaleria`),
  KEY `fk_galeria_categoria` (`idcatg`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `galeria`
--

INSERT INTO `galeria` (`idgaleria`, `idcatg`, `titulo`, `detalle`, `ncolum`, `cuerpo`, `modo`, `portada`, `fecreg`, `visible`, `trial656`) VALUES
(13, 1, 'FIESTAS PATRIAS', 'asdsadasda', 1, '[{\"id\":65198,\"tipo\":\"I\",\"content\":\"/public/img/galeria/tpm.png\",\"portada\":\"/public/img/galeria/tpm.png\"}]', 'A', 'http://admin-web-version3.com/public/img/galeria/emergent.jpg', '2025-06-18 16:21:14', 'S', NULL),
(19, 3, 'DEMO2', 'OTRO DETALLE', 4, '[{\"id\":18907,\"tipo\":\"I\",\"content\":\"/public/img/galeria/admision.jpg\",\"portada\":\"/public/img/galeria/admision.jpg\"},{\"id\":96749,\"tipo\":\"I\",\"content\":\"/public/img/galeria/emergent.jpg\",\"portada\":\"/public/img/galeria/emergent.jpg\"},{\"id\":55081,\"tipo\":\"I\",\"content\":\"/public/img/galeria/ticket_122611_250124114142.jpg\",\"portada\":\"/public/img/galeria/ticket_122611_250124114142.jpg\"},{\"id\":95999,\"tipo\":\"I\",\"content\":\"/public/img/galeria/03.jpg\",\"portada\":\"/public/img/galeria/03.jpg\"},{\"id\":97965,\"tipo\":\"I\",\"content\":\"/public/img/galeria/04.jpg\",\"portada\":\"/public/img/galeria/04.jpg\"},{\"id\":71558,\"tipo\":\"I\",\"content\":\"/public/img/galeria/06.jpg\",\"portada\":\"/public/img/galeria/06.jpg\"},{\"id\":28873,\"tipo\":\"I\",\"content\":\"/public/img/galeria/05.jpg\",\"portada\":\"/public/img/galeria/05.jpg\"},{\"id\":23289,\"tipo\":\"I\",\"content\":\"/public/img/galeria/07.jpg\",\"portada\":\"/public/img/galeria/07.jpg\"}]', 'A', 'http://admin-web-version3.com/public/img/galeria/01.jpg', '2026-01-21 17:47:56', 'S', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `popup`
--

DROP TABLE IF EXISTS `popup`;
CREATE TABLE IF NOT EXISTS `popup` (
  `id` int(11) NOT NULL COMMENT 'TRIAL',
  `titulo` varchar(250) DEFAULT NULL COMMENT 'TRIAL',
  `tipo` char(1) NOT NULL COMMENT 'TRIAL',
  `cuerpo` mediumtext DEFAULT NULL COMMENT 'TRIAL',
  `header` char(1) DEFAULT NULL COMMENT 'TRIAL',
  `margen` char(1) DEFAULT NULL COMMENT 'TRIAL',
  `slider` char(1) DEFAULT NULL COMMENT 'TRIAL',
  `animation` varchar(40) DEFAULT NULL COMMENT 'TRIAL',
  `visible` char(1) DEFAULT NULL COMMENT 'TRIAL',
  `trial656` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `popup`
--

INSERT INTO `popup` (`id`, `titulo`, `tipo`, `cuerpo`, `header`, `margen`, `slider`, `animation`, `visible`, `trial656`) VALUES
(1, 'demo', 'V', '<video src=\"/public/video/1_VIDEO DE INICIO.mp4\" width=\"100%\" autoplay=\"\" muted=\"\" controls=\"\"></video>', 'N', 'N', 'N', 'animate__zoomIn', 'S', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `portadas`
--

DROP TABLE IF EXISTS `portadas`;
CREATE TABLE IF NOT EXISTS `portadas` (
  `idportada` int(11) NOT NULL AUTO_INCREMENT,
  `pagina` varchar(100) NOT NULL COMMENT 'Identificador de la página (ej: nosotros, servicios)',
  `nombre` varchar(150) NOT NULL COMMENT 'Nombre descriptivo de la página',
  `imagen` varchar(300) DEFAULT NULL COMMENT 'URL de la imagen de portada',
  `titulo` varchar(200) DEFAULT NULL COMMENT 'Título que aparece en la portada',
  `subtitulo` varchar(250) DEFAULT NULL COMMENT 'Subtítulo o descripción',
  `estado` char(1) DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `fecreg` datetime DEFAULT current_timestamp(),
  `fecact` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`idportada`),
  UNIQUE KEY `idx_pagina` (`pagina`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `portadas`
--

INSERT INTO `portadas` (`idportada`, `pagina`, `nombre`, `imagen`, `titulo`, `subtitulo`, `estado`, `fecreg`, `fecact`) VALUES
(1, 'nosotros', 'Nosotros', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200', 'Nosotros', 'Conoce más sobre nuestra institución', 'A', '2026-01-14 16:21:14', '2026-01-21 09:14:57'),
(2, 'servicios', 'Servicios', 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1200', 'Nuestros Servicios', 'Soluciones profesionales adaptadas a tus necesidades', 'A', '2026-01-14 16:21:14', '2026-01-16 16:33:49'),
(3, 'admision', 'Admision', '/public/img/portadas/admision.jpg', 'Admisión 2027', 'Conocerás los requisitos de nuestro proceso de Admisión 2027', 'A', '2026-01-14 16:21:14', '2026-01-21 11:49:02'),
(6, 'galerias', 'Galerías', '/public/img/portadas/admision.jpg', 'GALERÍAS', 'Revive nuestros mejores momentos', 'A', '2026-01-19 10:11:54', '2026-01-19 12:22:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

DROP TABLE IF EXISTS `publicacion`;
CREATE TABLE IF NOT EXISTS `publicacion` (
  `idpub` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `idcatg` int(11) NOT NULL COMMENT 'TRIAL',
  `titulo` varchar(280) NOT NULL COMMENT 'TRIAL',
  `tagname` varchar(330) NOT NULL COMMENT 'TRIAL',
  `portada` varchar(350) DEFAULT NULL COMMENT 'TRIAL',
  `detalle` varchar(250) DEFAULT NULL COMMENT 'TRIAL',
  `cuerpo` longtext DEFAULT NULL COMMENT 'TRIAL',
  `fecpub` datetime NOT NULL COMMENT 'TRIAL',
  `fecreg` datetime DEFAULT NULL COMMENT 'TRIAL',
  `visible` char(1) DEFAULT 'N' COMMENT 'TRIAL',
  `trial656` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`idpub`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idpub`, `idcatg`, `titulo`, `tagname`, `portada`, `detalle`, `cuerpo`, `fecpub`, `fecreg`, `visible`, `trial656`) VALUES
(13, 1, 'Últimas Vacantes 2025', 'ultimas-vacantes-2025', '', '', '<div><iframe style=\"border: none; overflow: hidden; width: 692px; height: 346px;\" src=\"https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fcolegiomariagoretticomas%2Fposts%2Fpfbid02ewnHW9G5bJMkgD2EizHuZofos3tUeuCJjcTsARPqb3rt3DNn4XhEK9dSDPFmHjMfl&amp;show_text=true&amp;width=500\" width=\"100%\" height=\"200\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"allowfullscreen\"></iframe></div>', '2025-03-04 15:16:00', NULL, 'S', NULL),
(16, 1, 'DEMO1', 'demo1', 'http://admin-web-version3.com/public/img/galeria/ticket_122611_250124114142.jpg', 'SDSADAS', '<div>SDFSDFSD</div>', '2026-01-19 09:54:00', NULL, 'S', NULL),
(14, 1, 'Feliz día de la mujer', 'feliz-dia-de-la-mujer', 'dddd', 'Celebramos el día de la mujer.', '<div><iframe style=\"border: none; overflow: hidden; width: 820px; height: 410px;\" src=\"https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fcolegiomariagoretticomas%2Fposts%2Fpfbid0zNPoz61J5uMzPkFoydD1V8oKjEUBn76gbcPm7Rd1sZfqNHAuXzacHo6Z4uAuMzSQl&amp;show_text=true&amp;width=500\" width=\"100%\" height=\"600\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"allowfullscreen\"></iframe></div>', '2025-03-08 17:02:00', NULL, 'S', NULL),
(15, 1, 'Bienvenidos al inicio de clases 2025', 'bienvenidos-al-inicio-de-clases-2025', '', 'Inicio de clases 2025', '<div><iframe style=\"border: none; overflow: hidden; width: 896px; height: 448px;\" src=\"https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fcolegiomariagoretticomas%2Fposts%2Fpfbid0zvPj9U9G6d3bKDiW49YJCybTzGa9qtTCvJCj7r17gJyuDAhqdhNRSzFBCgw75y1Fl&amp;show_text=true&amp;width=500\" width=\"100%\" height=\"600\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"allowfullscreen\"></iframe></div>', '2025-07-10 17:06:00', NULL, 'S', NULL),
(17, 1, 'pub demo', 'pub-demo', 'http://admin-web-version3.com/public/img/galeria/05.jpg', 'demo', '<div style=\"text-align: center;\"><img src=\"../../../public/img/galeria/emergent.jpg\" width=\"85%\" /></div>\r\n<div>&nbsp;</div>\r\n<div style=\"text-align: center;\"><iframe src=\"https://www.youtube.com/embed/iZPyq2aZpmw?si=6FpBqrQd-J5WP4VD\" width=\"560\" height=\"314\" allowfullscreen=\"allowfullscreen\"></iframe></div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div style=\"text-align: center;\"><iframe src=\"../../../public/files/compromiso-padres.pdf\" width=\"100%\" height=\"720\" frameborder=\"0\"></iframe></div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div style=\"text-align: center;\"><iframe style=\"border: none; overflow: hidden;\" src=\"https://www.facebook.com/plugins/video.php?height=314&amp;href=https%3A%2F%2Fwww.facebook.com%2Freel%2F1595634508151407%2F&amp;show_text=false&amp;width=560&amp;t=0\" width=\"560\" height=\"314\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"allowfullscreen\"></iframe></div>', '2026-01-21 08:44:00', NULL, 'S', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

DROP TABLE IF EXISTS `suscripciones`;
CREATE TABLE IF NOT EXISTS `suscripciones` (
  `idsuscripcion` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `nivel` varchar(20) DEFAULT NULL,
  `grado` varchar(10) DEFAULT NULL,
  `consulta` text DEFAULT NULL,
  `asunto` varchar(50) DEFAULT 'informes',
  `nombre_completo` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_suscripcion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `ip_registro` varchar(45) DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`idsuscripcion`),
  UNIQUE KEY `idx_correo_unique` (`correo`),
  KEY `idx_fecha_suscripcion` (`fecha_suscripcion`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `suscripciones`
--

INSERT INTO `suscripciones` (`idsuscripcion`, `nombres`, `apellidos`, `correo`, `nivel`, `grado`, `consulta`, `asunto`, `nombre_completo`, `email`, `fecha_suscripcion`, `estado`, `ip_registro`, `fecha_baja`) VALUES
(4, 'Axel', 'Molina', 'demo@demo.com', 'Primaria', '2do grado', 'sadsadasdsadasdasdasdasdasdasd', 'informes', 'Axel Molina', 'demo@demo.com', '2026-01-22 09:59:45', 'activo', '::1', NULL),
(5, 'Demo', 'demo', 'demo@demsssso.com', 'Inicial', '3 años', 'sadasdasdasdasdasdsadasdasda', 'informes', 'Demo demo', 'demo@demsssso.com', '2026-01-22 10:04:07', 'activo', '::1', NULL),
(6, 'ricardo', 'lujuria', 'luju@lujuria.com', 'Secundaria', '4to año', 'sdsadsadasdsadasdas', 'informes', 'ricardo lujuria', 'luju@lujuria.com', '2026-01-22 11:18:57', 'activo', '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nombre` varchar(30) NOT NULL COMMENT 'TRIAL',
  `pass` varchar(250) NOT NULL COMMENT 'TRIAL',
  `fecreg` datetime DEFAULT NULL COMMENT 'TRIAL',
  `trial656` char(1) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `idx_nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='TRIAL';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`iduser`, `nombre`, `pass`, `fecreg`, `trial656`) VALUES
(101, 'admin', '$2y$10$DhfhM2fqBho3DZCMb79JIOWFjf8KNDfd8eGLU3g4N2djUjqX.9egi', '2022-05-29 15:11:31', 'T');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
