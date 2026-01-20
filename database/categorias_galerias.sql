-- Tabla de categorías para galerías
CREATE TABLE IF NOT EXISTS `categorias_galerias` (
  `idcatg` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A' COMMENT 'A=Activo, I=Inactivo',
  `fecreg` datetime NOT NULL,
  PRIMARY KEY (`idcatg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar campo idcatg a la tabla galeria (si no existe)
ALTER TABLE `galeria` 
ADD COLUMN `idcatg` int(11) NULL DEFAULT NULL AFTER `idgaleria`,
ADD KEY `fk_galeria_categoria` (`idcatg`);

-- Insertar algunas categorías de ejemplo
INSERT INTO `categorias_galerias` (`nombre`, `estado`, `fecreg`) VALUES
('Eventos', 'A', NOW()),
('Actividades', 'A', NOW()),
('Infraestructura', 'A', NOW()),
('Académico', 'A', NOW());
