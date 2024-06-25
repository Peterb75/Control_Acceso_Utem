CREATE DATABASE IF NOT EXISTS `Control-Acceso`;
USE `Control-Acceso`;

CREATE TABLE IF NOT EXISTS `Personas` (
  `Id_Persona` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Nombres` VARCHAR(50) NOT NULL,
  `ApellidoP` VARCHAR(50) NOT NULL,
  `ApellidoM` VARCHAR(50) NOT NULL,
  `Correo` VARCHAR(150) NOT NULL,
  `TipoTransporte` VARCHAR(60) NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS `TipoUsuario` (
  `Id_TipoUsuario` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `TipoUsuarios` VARCHAR(100) NOT NULL,
  `Descripcion` VARCHAR(200) NOT NULL,
  `FechaCreated` DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS `Users` (
  `Id_Users` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Persona` INT NOT NULL,
  `FK_TipoUsuario` INT NOT NULL,
  `Num_Iden` INT NOT NULL,
  `Password` VARCHAR(20) NOT NULL,
  `Carrera` VARCHAR(100) NULL,
  `Grupo` VARCHAR(50) NULL,
  `Activo` BIT(1) DEFAULT b'1',
  `HoraFija_Entrada` DATETIME NOT NULL,
  `HoraFija_Salida` DATETIME NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  FOREIGN KEY (`FK_Id_Persona`) REFERENCES `Personas`(`Id_Persona`),
  FOREIGN KEY (`FK_TipoUsuario`) REFERENCES `TipoUsuario`(`Id_TipoUsuario`)
);

CREATE TABLE IF NOT EXISTS `QR_Usuarios` (
  `Id_QRUser` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_User` INT NOT NULL,
  `Activo` BIT(1) DEFAULT b'1',
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  `QR_imgUser` BLOB NOT NULL,
  FOREIGN KEY (`FK_Id_User`) REFERENCES `Users`(`Id_Users`)
);

CREATE TABLE IF NOT EXISTS `Registro_Entrada` (
  `Id_Entrada` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Persona` INT NOT NULL,
  `Entrada` DATETIME NOT NULL,
  FOREIGN KEY (`FK_Id_Persona`) REFERENCES `Personas`(`Id_Persona`)
);

CREATE TABLE IF NOT EXISTS `Registro_Salida` (
  `Id_Salida` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Persona` INT NOT NULL,
  `Salida` DATETIME NOT NULL,
  FOREIGN KEY (`FK_Id_Persona`) REFERENCES `Personas`(`Id_Persona`)
);

CREATE TABLE IF NOT EXISTS `TipoInvitado` (
  `Id_TipoInvitado` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Tipo_Invitado` VARCHAR(100) NOT NULL,
  `Descripcion` VARCHAR(200) NOT NULL,
  `FechaCreated` DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS `Invitados` (
  `Id_Invitados` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Persona` INT NOT NULL,
  `FK_TipoInvitado` INT NOT NULL,
  `Edificio` VARCHAR(30) NOT NULL,
  `CantVis` INT NOT NULL,
  `MotivioVisit` VARCHAR(100) NOT NULL,
  `FechaSolicitada` DATE NOT NULL,
  FOREIGN KEY (`FK_TipoInvitado`) REFERENCES `TipoInvitado`(`Id_TipoInvitado`),
  FOREIGN KEY (`FK_Id_Persona`) REFERENCES `Personas`(`Id_Persona`)
);

CREATE TABLE IF NOT EXISTS `DatoV` (
  `Id_DatoV` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `MarcaV` VARCHAR(100) NOT NULL,
  `ModeloV` VARCHAR(100) NOT NULL,
  `ColorV` VARCHAR(40) NOT NULL,
  `Placas` VARCHAR(80)
);

CREATE TABLE IF NOT EXISTS `Vehiculos` (
  `Id_Vehicular` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Persona` INT NOT NULL,
  `FK_Id_DatoV` INT NOT NULL,
  FOREIGN KEY (`FK_Id_Persona`) REFERENCES `Personas`(`Id_Persona`),
  FOREIGN KEY (`FK_Id_DatoV`) REFERENCES `DatoV`(`Id_DatoV`)
);

CREATE TABLE IF NOT EXISTS `Solictud_Vis` (
  `Id_solicitud` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Invitados` INT NOT NULL,
  FOREIGN KEY (`FK_Id_Invitados`) REFERENCES `Invitados`(`Id_Invitados`)
);

CREATE TABLE IF NOT EXISTS `VisitAceptados` (
  `Id_Aceptado` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_solicitud` INT NOT NULL,
  `FK_Id_UserAceptado` INT NOT NULL,
  FOREIGN KEY (`FK_Id_UserAceptado`) REFERENCES `Users`(`Id_Users`),
  FOREIGN KEY (`FK_Id_solicitud`) REFERENCES `Solictud_Vis`(`Id_solicitud`)
);

CREATE TABLE IF NOT EXISTS `QR_Invitados` (
  `Id_QRInv` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `FK_Id_Aceptado` INT NOT NULL,
  `Activo` BIT(1) DEFAULT b'1',
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  `QR_invit` BLOB NOT NULL,
  FOREIGN KEY (`FK_Id_Aceptado`) REFERENCES `VisitAceptados`(`Id_Aceptado`)
);


INSERT INTO `tipousuario` (`Id_TipoUsuario`, `TipoUsuarios`, `Descripcion`, `FechaCreated`) VALUES
	(1, 'Administrador', 'Administra a los usaurios y solicitudes de los invitados', '2024-06-13'),
	(2, 'Alumno', 'Estudiante de la universidad', '2024-06-13'),
	(3, 'Docente Tiempo Completo', 'Docente que esta dando clases en tiempo completo', '2024-06-13'),
	(4, 'Docente Medio Tiempo', 'Docente que esta dando clases en medio tiempo', '2024-06-13');


INSERT INTO `tipoinvitado` (`Id_TipoInvitado`, `Tipo_Invitado`, `Descripcion`, `FechaCreated`) VALUES
	(1, 'Externo', 'Viene de fuea', '2024-06-13'),
	(2, 'Escolar', 'Visitante de escuela', '2024-06-13'),
  (3, 'Proovedor', 'Da comida' , '2024-06-13');
