-- Tabla principal de configuración de admisión
CREATE TABLE IF NOT EXISTS `admision` (
  `intro_titulo` varchar(255) DEFAULT NULL,
  `intro_contenido` text DEFAULT NULL,
  `proceso_titulo` varchar(255) DEFAULT NULL,
  `proceso_contenido` text DEFAULT NULL,
  `requisitos_titulo` varchar(255) DEFAULT NULL,
  `requisitos_contenido` text DEFAULT NULL,
  `cta_titulo` varchar(255) DEFAULT NULL,
  `cta_subtitulo` varchar(255) DEFAULT NULL,
  `cta_boton_texto` varchar(100) DEFAULT NULL,
  `cta_boton_enlace` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar registro por defecto
INSERT INTO `admision` (`intro_titulo`, `intro_contenido`, `proceso_titulo`, `proceso_contenido`, `requisitos_titulo`, `requisitos_contenido`, `cta_titulo`, `cta_subtitulo`, `cta_boton_texto`, `cta_boton_enlace`) VALUES
('Proceso de Admisión', 'Bienvenido al proceso de admisión. Aquí encontrarás toda la información necesaria para formar parte de nuestra institución.', 'Nuestro Proceso', 'Conoce los pasos a seguir para completar tu proceso de admisión de manera exitosa.', 'Requisitos', 'Revisa los documentos y requisitos necesarios para iniciar tu proceso de admisión.', '¿Listo para iniciar?', 'Comienza tu proceso de admisión hoy', 'Iniciar Postulación', '/contacto');

-- Tabla de secciones de admisión (pasos, ventajas, etc.)
CREATE TABLE IF NOT EXISTS `admision_secciones` (
  `idseccion` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `icono` varchar(100) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `orden` int(11) DEFAULT 1,
  `estado` char(1) DEFAULT 'A',
  PRIMARY KEY (`idseccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar secciones de ejemplo
INSERT INTO `admision_secciones` (`titulo`, `icono`, `contenido`, `orden`, `estado`) VALUES
('Inscripción Online', 'fas fa-laptop', 'Completa el formulario de inscripción en línea con tus datos personales y académicos.', 1, 'A'),
('Entrevista Personal', 'fas fa-users', 'Participa en una entrevista con nuestro equipo para conocer tus intereses y expectativas.', 2, 'A'),
('Evaluación', 'fas fa-file-alt', 'Realiza la evaluación correspondiente según el nivel al que postulas.', 3, 'A'),
('Matrícula', 'fas fa-check-circle', 'Una vez aceptado, completa el proceso de matrícula y forma parte de nuestra comunidad.', 4, 'A');
