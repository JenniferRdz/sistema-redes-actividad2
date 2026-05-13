
-- Sistema de Gestión de Redes Inalámbricas

USE SistemaRedes;
GO

-- 1. ENTIDAD: Usuarios (Para acceso al sistema)
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[Usuarios]') AND type in (N'U'))
BEGIN
    CREATE TABLE Usuarios (
        id INT PRIMARY KEY IDENTITY(1,1),
        usuario VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        nombre VARCHAR(100) NOT NULL
    );
END
GO

-- 2. ENTIDAD: Clientes (Para el servicio de internet)
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[Clientes]') AND type in (N'U'))
BEGIN
    CREATE TABLE Clientes (
        id INT PRIMARY KEY IDENTITY(1,1),
        nombre VARCHAR(150) NOT NULL,
        telefono VARCHAR(20),
        direccion VARCHAR(255),
        estado VARCHAR(20) DEFAULT 'Activo', -- 'Activo', 'Suspendido' (Amarillo), 'Baja' (Rojo)
        fecha_alta DATETIME DEFAULT GETDATE(),
        notas TEXT
    );
END
GO

-- 3. ENTIDAD: Pagos (Para el control de mensualidades)
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[Pagos]') AND type in (N'U'))
BEGIN
    CREATE TABLE Pagos (
        id INT PRIMARY KEY IDENTITY(1,1),
        id_cliente INT NOT NULL,
        mes INT NOT NULL, -- 1 al 12
        anio INT NOT NULL,
        fecha_pago DATETIME DEFAULT GETDATE(),
        monto DECIMAL(10,2),
        CONSTRAINT FK_Pagos_Clientes FOREIGN KEY (id_cliente) REFERENCES Clientes(id) ON DELETE CASCADE
    );
END
GO

-- Datos de prueba para ver los colores
-- INSERT INTO Clientes (nombre, telefono, direccion, estado) VALUES ('Juan Perez', '12345678', 'Calle A', 'Activo');
-- INSERT INTO Clientes (nombre, telefono, direccion, estado) VALUES ('Maria Lopez', '87654321', 'Calle B', 'Suspendido');
-- INSERT INTO Clientes (nombre, telefono, direccion, estado) VALUES ('Pedro Garcia', '55555555', 'Calle C', 'Baja');
