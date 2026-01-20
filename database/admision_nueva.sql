-- Tabla admisión (estructura simple)

DROP TABLE IF EXISTS `admision`;
CREATE TABLE `admision` (
  `idadmision` int(11) NOT NULL DEFAULT 1,
  `titulo` varchar(255) DEFAULT NULL,
  `cuerpo` longtext DEFAULT NULL,
  PRIMARY KEY (`idadmision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Insertar registro inicial
INSERT INTO `admision` (`idadmision`, `titulo`, `cuerpo`) VALUES
(1, 'PROCESO DE ADMISIÓN 2026', '<p>Contenido de la página de admisión.</p>');
