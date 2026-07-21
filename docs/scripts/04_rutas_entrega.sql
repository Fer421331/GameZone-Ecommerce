CREATE TABLE rutas_entrega (
    id_ruta INT AUTO_INCREMENT PRIMARY KEY,
    origen VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    distancia_km DECIMAL(8,2) NOT NULL,
    duracion_min INT NOT NULL,
    estado CHAR(3) NOT NULL DEFAULT 'ACT'
);  