CREATE TABLE `Citas` (
    `CitaID` INT PRIMARY KEY AUTO_INCREMENT,             -- Identificador único de la cita
    `usercod` BIGINT(10) NOT NULL,                       -- Código del usuario (paciente) relacionado con la cita
    `FechaCita` DATETIME NOT NULL,                       -- Fecha y hora de la cita
    `TipoExamen` VARCHAR(100) NOT NULL,                  -- Tipo de examen solicitado
    `EstadoCita` VARCHAR(50) NOT NULL DEFAULT 'Pendiente',-- Estado de la cita (Pendiente, Confirmada, Cancelada, Realizada)
    `FechaCreacion` DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Fecha en que se creó la cita
    `FechaModificacion` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Fecha de la última modificación
    FOREIGN KEY (`usercod`) REFERENCES `usuario`(`usercod`)  -- Relación con la tabla de usuarios (pacientes)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE Examenes (
    ExamenID INT PRIMARY KEY AUTO_INCREMENT,
    NombreExamen VARCHAR(100),
    Descripcion TEXT,
    Precio DECIMAL(10, 2)
);
CREATE TABLE Resultados (
    ResultadoID INT PRIMARY KEY AUTO_INCREMENT,
    CitaID INT,
    ExamenID INT,
    Resultado TEXT,
    FechaResultado DATETIME,
    FOREIGN KEY (CitaID) REFERENCES Citas(CitaID),
    FOREIGN KEY (ExamenID) REFERENCES Examenes(ExamenID)
);
