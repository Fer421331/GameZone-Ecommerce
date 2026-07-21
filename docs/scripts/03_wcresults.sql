CREATE TABLE wcresults(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    equipo_a VARCHAR(255),
    equipo_b VARCHAR(255),
    resumen VARCHAR(255),
    score_a INT,
    score_b INT,
    fecha DATE
) COMMENT '';