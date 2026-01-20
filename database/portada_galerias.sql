-- Insertar portada para la página de galerías
INSERT INTO `portadas` (`nombre`, `pagina`, `titulo`, `subtitulo`, `imagen`, `estado`, `fecreg`) 
VALUES (
    'Galerías', 
    'galerias', 
    'GALERÍAS', 
    'Revive nuestros mejores momentos',
    '', 
    'A', 
    NOW()
)
ON DUPLICATE KEY UPDATE 
    nombre = 'Galerías',
    titulo = 'GALERÍAS',
    subtitulo = 'Revive nuestros mejores momentos',
    estado = 'A';
