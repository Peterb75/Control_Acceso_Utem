CREATE DATABASE IF NOT EXISTS `Control-Acceso`;
USE `Control-Acceso`;

CREATE TABLE IF NOT EXISTS `Personas` (
  `Id_Persona` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Nombres` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Correo` VARCHAR(150) NOT NULL,
);

CREATE TABLE IF NOT EXISTS `TipoUsuario` (
  `Id_TipoUsuario` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `TipoUsuarios` VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS `Entrada` (
  `Id_Entrada` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Users` INT NOT NULL,
  `Entrada` DATE NOT NULL,
  FOREIGN KEY (FK_Id_Users) REFERENCES Users(Id_Users)
);

CREATE TABLE IF NOT EXISTS `Salida` (
  `Id_Salida` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Users` INT NOT NULL,
  `Salida` DATE NOT NULL,
  FOREIGN KEY (FK_Id_Users) REFERENCES Users(Id_Users)
);

CREATE TABLE IF NOT EXISTS `Users` (
    `Id_Users` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FK_Id_Persona` INT NOT NULL,
    `FK_TipoUsuario` INT NOT NULL,
    `Password` VARCHAR(20) NOT NULL,
    `Activo` INT NOT NULL,
    `Carrera` VARCHAR(100) NOT NULL,
    `FK_Grupo` VARCHAR(50) DEFAULT NULL,
    `FK_TipoTransporte` INT NOT NULL,
    FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona),
    FOREIGN KEY (FK_TipoUsuario) REFERENCES TipoUsuario(Id_TipoUsuario),
    FOREIGN KEY (FK_Grupos) REFERENCES Alumno(Grupo),
    FOREIGN KEY (FK_TipoTransporte) REFERENCES Vehiculos(Tipo_Transporte)
);

CREATE TABLE IF NOT EXISTS `Administradores` (
  `Id_Admin` INT NOT NULL AUTO_INCREMENT PRIMARY KEY
  `NumTrabajador` INT NOT NULL,
  `FK_Id_Persona` INT NOT NULL,
  FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona)
);

-- En el tipo docente 1 significa Tiempo Completo 2 Significa Medio Tiempo
CREATE TABLE IF NOT EXISTS `TipoDocente` (
    `Id_TipoDocente` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `TipoDocente` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `Docente` (
    `Id_Docente` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `NumTrabajo` INT NOT NULL,
    `FK_Id_Persona` INT NOT NULL,
    `FK_Id_TipoDocente` INT NOT NULL,
    FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona),
    FOREIGN KEY (FK_Id_TipoDocente) REFERENCES TipoDocente(Id_TipoDocente)
);

CREATE TABLE IF NOT EXISTS `Alumno` (
    `Id_Alumno` INT NOT NULL AUTO_INCREMENT PRIMARY KEY
    `NumControl` INT NOT NULL,
    `FK_Id_Persona` INT NOT NULL,
    `Grupo` VARCHAR(50) NOT NULL,
    FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona)
);

CREATE TABLE IF NOT EXISTS `Guardia` (
    `Id_Guardia` INT NOT NULL AUTO_INCREMENT PRIMARY KEY
    `NumTrabajador` INT NOT NULL,
    `FK_Id_Persona` INT NOT NULL,
    FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona)
);

CREATE TABLE IF NOT EXISTS `Invitados` (
    `Id_Invitados` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FK_TipoInvitado` INT NOT NULL,
    FOREIGN KEY (FK_TipoInvitado) REFERENCES TipoInvitado(Id_TipoInvitado)
);

CREATE TABLE IF NOT EXISTS `TipoInvitado` (
    `Id_TipoInvitado` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Tipo_Invitado` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `Provedor` (
    `Id_Proovedor` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `NombreCompania` VARCHAR(150) NOT NULL,
    `Edificio` VARCHAR(40)
);

CREATE TABLE IF NOT EXISTS `Instituto` (
    `Id_Inst` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nombre_Institucion` VARCHAR(150) NOT NULL

);

CREATE TABLE IF NOT EXISTS `Vehiculos`(
  `Id_Vehicular` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Id_Persona` INT NOT NULL,
  `Tipo_Transporte` VARCHAR(200) NOT NULL
);

CREATE TABLE IF NOT EXISTS `DatoV` (
    `Id_DatoV` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FK_Id_Vehicular` INT NOT NULL,
    `MarcaV` VARCHAR(100) NOT NULL,
    `ModeloV` VARCHAR(100) NOT NULL,
    `ColorV` VARCHAR(40) NOT NULL
    `Placas` VARCHAR(80) NULL,
    FOREIGN KEY (FK_Id_Vehicular) REFERENCES Vehiculos(Id_Vehicular)

);

CREATE TABLE IF NOT EXISTS `VisAceptados` (
  `Id_Aceptado` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_User` INT NOT NULL,
  FOREIGN KEY (FK_Id_User) REFERENCES Users(Id_Users)
);
-- Cambiar nombre de tabla confirmar con alan
CREATE TABLE IF NOT EXISTS `Fuer`(
  `IdFS` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_User` INT NOT NULL,
  `FK_Id_Entrada` INT NOT NULL,
  `FK_Id_Salida` INT NOT NULL,
  FOREIGN KEY (FK_Id_User) REFERENCES Users(Id_Users),
  FOREIGN KEY (FK_Id_Entrada) REFERENCES Entrada(Id_Entrada),
  FOREIGN KEY (FK_Id_Salida) REFERENCES Salida(Id_Salida)
);


/*
Base de datos implementacion en POSTGRES SQL

-- Crear la base de datos (asegúrese de que la base de datos no exista previamente)
CREATE DATABASE "Control-Acceso";

-- Cambiar al contexto de la base de datos creada
\c "Control-Acceso";

-- Crear tablas
CREATE TABLE IF NOT EXISTS "Personas" (
  "Id_Persona" SERIAL PRIMARY KEY,
  "Nombres" VARCHAR(50) NOT NULL,
  "Apellidos" VARCHAR(50) NOT NULL,
  "Correo" VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS "TipoUsuario" (
  "Id_TipoUsuario" SERIAL PRIMARY KEY,
  "TipoUsuarios" VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS "Users" (
  "Id_Users" SERIAL PRIMARY KEY,
  "FK_Id_Persona" INT NOT NULL,
  "FK_TipoUsuario" INT NOT NULL,
  "Password" VARCHAR(20) NOT NULL,
  "Activo" INT NOT NULL,
  "Carrera" VARCHAR(100) NOT NULL,
  "FK_Grupo" VARCHAR(50) DEFAULT NULL,
  "FK_TipoTransporte" INT NOT NULL,
  FOREIGN KEY ("FK_Id_Persona") REFERENCES "Personas"("Id_Persona"),
  FOREIGN KEY ("FK_TipoUsuario") REFERENCES "TipoUsuario"("Id_TipoUsuario")
);

CREATE TABLE IF NOT EXISTS "Entrada" (
  "Id_Entrada" SERIAL PRIMARY KEY,
  "FK_Id_Users" INT NOT NULL,
  "Entrada" DATE NOT NULL,
  FOREIGN KEY ("FK_Id_Users") REFERENCES "Users"("Id_Users")
);

CREATE TABLE IF NOT EXISTS "Salida" (
  "Id_Salida" SERIAL PRIMARY KEY,
  "FK_Id_Users" INT NOT NULL,
  "Salida" DATE NOT NULL,
  FOREIGN KEY ("FK_Id_Users") REFERENCES "Users"("Id_Users")
);

CREATE TABLE IF NOT EXISTS "Administradores" (
  "Id_Admin" SERIAL PRIMARY KEY,
  "NumTrabajador" INT NOT NULL,
  "FK_Id_Persona" INT NOT NULL,
  FOREIGN KEY ("FK_Id_Persona") REFERENCES "Personas"("Id_Persona")
);

CREATE TABLE IF NOT EXISTS "TipoDocente" (
  "Id_TipoDocente" SERIAL PRIMARY KEY,
  "TipoDocente" INT NOT NULL
);

CREATE TABLE IF NOT EXISTS "Docente" (
  "Id_Docente" SERIAL PRIMARY KEY,
  "NumTrabajo" INT NOT NULL,
  "FK_Id_Persona" INT NOT NULL,
  "FK_Id_TipoDocente" INT NOT NULL,
  FOREIGN KEY ("FK_Id_Persona") REFERENCES "Personas"("Id_Persona"),
  FOREIGN KEY ("FK_Id_TipoDocente") REFERENCES "TipoDocente"("Id_TipoDocente")
);

CREATE TABLE IF NOT EXISTS "Alumno" (
  "Id_Alumno" SERIAL PRIMARY KEY,
  "NumControl" INT NOT NULL,
  "FK_Id_Persona" INT NOT NULL,
  "Grupo" VARCHAR(50) NOT NULL,
  FOREIGN KEY ("FK_Id_Persona") REFERENCES "Personas"("Id_Persona")
);

CREATE TABLE IF NOT EXISTS "Guardia" (
  "Id_Guardia" SERIAL PRIMARY KEY,
  "NumTrabajador" INT NOT NULL,
  "FK_Id_Persona" INT NOT NULL,
  FOREIGN KEY ("FK_Id_Persona") REFERENCES "Personas"("Id_Persona")
);

CREATE TABLE IF NOT EXISTS "TipoInvitado" (
  "Id_TipoInvitado" SERIAL PRIMARY KEY,
  "Tipo_Invitado" INT NOT NULL
);

CREATE TABLE IF NOT EXISTS "Invitados" (
  "Id_Invitados" SERIAL PRIMARY KEY,
  "FK_TipoInvitado" INT NOT NULL,
  FOREIGN KEY ("FK_TipoInvitado") REFERENCES "TipoInvitado"("Id_TipoInvitado")
);

CREATE TABLE IF NOT EXISTS "Provedor" (
  "Id_Proovedor" SERIAL PRIMARY KEY,
  "NombreCompania" VARCHAR(150) NOT NULL,
  "Edificio" VARCHAR(40)
);

CREATE TABLE IF NOT EXISTS "Instituto" (
  "Id_Inst" SERIAL PRIMARY KEY,
  "Nombre_Institucion" VARCHAR(150) NOT NULL
);


CREATE TABLE IF NOT EXISTS "Vehiculos" (
  "Id_Vehicular" SERIAL PRIMARY KEY,
  "Id_Persona" INT NOT NULL,
  "Tipo_Transporte" VARCHAR(200) NOT NULL
);

CREATE TABLE IF NOT EXISTS "DatoV" (
  "Id_DatoV" SERIAL PRIMARY KEY,
  "FK_Id_Vehicular" INT NOT NULL,
  "MarcaV" VARCHAR(100) NOT NULL,
  "ModeloV" VARCHAR(100) NOT NULL,
  "ColorV" VARCHAR(40) NOT NULL,
  "Placas" VARCHAR(80) NULL,
  FOREIGN KEY ("FK_Id_Vehicular") REFERENCES "Vehiculos"("Id_Vehicular")
);

*/

/*
SQL SERVER

-- Crear la base de datos
IF DB_ID('Control-Acceso') IS NULL
BEGIN
    CREATE DATABASE [Control-Acceso];
END
GO

-- Utilizar la base de datos
USE [Control-Acceso];
GO

-- Crear tablas
IF OBJECT_ID('Personas', 'U') IS NULL
BEGIN
    CREATE TABLE Personas (
        Id_Persona INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        Nombres VARCHAR(50) NOT NULL,
        Apellidos VARCHAR(50) NOT NULL,
        Correo VARCHAR(150) NOT NULL
    );
END
GO

IF OBJECT_ID('TipoUsuario', 'U') IS NULL
BEGIN
    CREATE TABLE TipoUsuario (
        Id_TipoUsuario INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        TipoUsuarios VARCHAR(100) NOT NULL
    );
END
GO

IF OBJECT_ID('Entrada', 'U') IS NULL
BEGIN
    CREATE TABLE Entrada (
        Id_Entrada INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        FK_Id_Users INT NOT NULL,
        Entrada DATE NOT NULL,
        FOREIGN KEY (FK_Id_Users) REFERENCES Users(Id_Users)
    );
END
GO

IF OBJECT_ID('Salida', 'U') IS NULL
BEGIN
    CREATE TABLE Salida (
        Id_Salida INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        FK_Id_Users INT NOT NULL,
        Salida DATE NOT NULL,
        FOREIGN KEY (FK_Id_Users) REFERENCES Users(Id_Users)
    );
END
GO

IF OBJECT_ID('Users', 'U') IS NULL
BEGIN
    CREATE TABLE Users (
        Id_Users INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        FK_Id_Persona INT NOT NULL,
        FK_TipoUsuario INT NOT NULL,
        Password VARCHAR(20) NOT NULL,
        Activo INT NOT NULL,
        Carrera VARCHAR(100) NOT NULL,
        FK_Grupo VARCHAR(50) NULL,
        FK_TipoTransporte INT NOT NULL,
        FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona),
        FOREIGN KEY (FK_TipoUsuario) REFERENCES TipoUsuario(Id_TipoUsuario),
        FOREIGN KEY (FK_Grupo) REFERENCES Alumno(Grupo),
        FOREIGN KEY (FK_TipoTransporte) REFERENCES Vehiculos(Tipo_Transporte)
    );
END
GO

IF OBJECT_ID('Administradores', 'U') IS NULL
BEGIN
    CREATE TABLE Administradores (
        Id_Admin INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        NumTrabajador INT NOT NULL,
        FK_Id_Persona INT NOT NULL,
        FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona)
    );
END
GO

-- En el tipo docente 1 significa Tiempo Completo 2 Significa Medio Tiempo
IF OBJECT_ID('TipoDocente', 'U') IS NULL
BEGIN
    CREATE TABLE TipoDocente (
        Id_TipoDocente INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        TipoDocente INT NOT NULL
    );
END
GO

IF OBJECT_ID('Docente', 'U') IS NULL
BEGIN
    CREATE TABLE Docente (
        Id_Docente INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        NumTrabajo INT NOT NULL,
        FK_Id_Persona INT NOT NULL,
        FK_Id_TipoDocente INT NOT NULL,
        FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona),
        FOREIGN KEY (FK_Id_TipoDocente) REFERENCES TipoDocente(Id_TipoDocente)
    );
END
GO

IF OBJECT_ID('Alumno', 'U') IS NULL
BEGIN
    CREATE TABLE Alumno (
        Id_Alumno INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        NumControl INT NOT NULL,
        FK_Id_Persona INT NOT NULL,
        Grupo VARCHAR(50) NOT NULL,
        FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona)
    );
END
GO

IF OBJECT_ID('Guardia', 'U') IS NULL
BEGIN
    CREATE TABLE Guardia (
        Id_Guardia INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        NumTrabajador INT NOT NULL,
        FK_Id_Persona INT NOT NULL,
        FOREIGN KEY (FK_Id_Persona) REFERENCES Personas(Id_Persona)
    );
END
GO

IF OBJECT_ID('Invitados', 'U') IS NULL
BEGIN
    CREATE TABLE Invitados (
        Id_Invitados INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        FK_TipoInvitado INT NOT NULL,
        FOREIGN KEY (FK_TipoInvitado) REFERENCES TipoInvitado(Id_TipoInvitado)
    );
END
GO

IF OBJECT_ID('TipoInvitado', 'U') IS NULL
BEGIN
    CREATE TABLE TipoInvitado (
        Id_TipoInvitado INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        Tipo_Invitado INT NOT NULL
    );
END
GO

IF OBJECT_ID('Provedor', 'U') IS NULL
BEGIN
    CREATE TABLE Provedor (
        Id_Proovedor INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        NombreCompania VARCHAR(150) NOT NULL,
        Edificio VARCHAR(40)
    );
END
GO

IF OBJECT_ID('Instituto', 'U') IS NULL
BEGIN
    CREATE TABLE Instituto (
        Id_Inst INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        Nombre_Institucion VARCHAR(150) NOT NULL
    );
END
GO

IF OBJECT_ID('Vehiculos', 'U') IS NULL
BEGIN
    CREATE TABLE Vehiculos (
        Id_Vehicular INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        Id_Persona INT NOT NULL,
        Tipo_Transporte VARCHAR(200) NOT NULL
    );
END
GO

IF OBJECT_ID('DatoV', 'U') IS NULL
BEGIN
    CREATE TABLE DatoV (
        Id_DatoV INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        FK_Id_Vehicular INT NOT NULL,
        MarcaV VARCHAR(100) NOT NULL,
        ModeloV VARCHAR(100) NOT NULL,
        ColorV VARCHAR(40) NOT NULL,
        Placas VARCHAR(80) NULL,
        FOREIGN KEY (FK_Id_Vehicular) REFERENCES Vehiculos(Id_Vehicular)
    );
END
GO

*/