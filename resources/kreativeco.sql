-- Crear la base de datos si no existe y usarla
CREATE DATABASE IF NOT EXISTS kreativeco;
USE kreativeco;

-- =========================================
-- Tabla: roles
-- Contiene los diferentes roles del sistema con sus permisos.
-- =========================================
CREATE TABLE IF NOT EXISTS `roles` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `permission_level` INT(11) NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_level` (`permission_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- =========================================
-- Tabla: users
-- Almacena los usuarios registrados en el sistema.
-- =========================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `last_name` TEXT NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `rol_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rol_id` (`rol_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- =========================================
-- Tabla: posts
-- Almacena los posts creados por los usuarios.
-- =========================================
CREATE TABLE IF NOT EXISTS `posts` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `description` MEDIUMTEXT NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `user_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- =========================================
-- Insertar datos en la tabla roles
-- =========================================
INSERT INTO `roles` (`id`, `name`, `permission_level`, `deleted`) VALUES
(1, 'Rol básico', 1, 0),
(2, 'Rol medio', 2, 0),
(3, 'Rol medio alto', 3, 0),
(4, 'Rol alto medio', 4, 0),
(5, 'Rol alto', 5, 0);

-- =========================================
-- Insertar datos en la tabla users
-- =========================================
INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `password`, `deleted`, `rol_id`) VALUES
(1, 'Javier', 'Salazar 1', 'javssala1@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 1),
(2, 'Javier', 'Salazar 2', 'javssala2@example.com', '$2y$10$KMXRxFYY5kZ.0q25Hrt7jOhVSpL1MIRfigX3ro2RYDspMLTcxRbD2', 0, 2),
(3, 'Javier', 'Salazar 3', 'javssala3@example.com', '$2y$10$zqMbdECyRbOW.nD/98xXSeED99luv2feIVt6/HEB7ZsfSi6XGGK5K', 0, 3),
(4, 'Javier', 'Salazar 4', 'javssala4@example.com', '$2y$10$w5UXL6BYXBFhqRO5QBlsyOEtH.rMbbg3whg6LIKWo75BWw4aWs.A2', 0, 4),
(5, 'Javier', 'Salazar 5', 'javssala5@example.com', '$2y$10$z/i5Ha//Af7pzFyb5A5BtuF9foiXumEvn/vxTPvffnhPRXDQQXX8K', 0, 5);

-- =========================================
-- Insertar datos en la tabla posts
-- =========================================
INSERT INTO `posts` (`id`, `title`, `description`, `date_created`, `deleted`, `user_id`) VALUES
(1, 'Mi post numero 1', 'Este es mi primer post en la plataforma', '2025-02-19 22:25:55', 0, 5),
(2, 'Mi segundo post', 'Este es mi segundo post', '2025-02-20 05:53:43', 0, 4),
(3, 'rgrgreg', 'rggregrgg', '2025-02-21 07:03:07', 0, 5);

COMMIT;
