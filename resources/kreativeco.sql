-- Crear la base de datos si no existe y usarla
CREATE DATABASE IF NOT EXISTS kreativeco;
USE kreativeco;

-- =========================================
-- Tabla: roles
-- Almacenará los tokens de los usuarios al cerrar sesión, para que no se vuelvan a utilizar
-- =========================================

CREATE TABLE IF NOT EXISTS revoked_tokens (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `token` TEXT NOT NULL,
    `revoked_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Tabla: roles
-- Contiene los diferentes roles del sistema con sus permisos.
-- =========================================
CREATE TABLE IF NOT EXISTS `roles` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `permissions` LONGTEXT NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Insertar datos en la tabla roles
-- =========================================
INSERT INTO `roles` (`id`, `name`, `permissions`, `deleted`) VALUES
(1, 'Rol básico', 'acceso', 0),
(2, 'Rol medio', 'acceso,consulta', 0),
(3, 'Rol medio alto', 'acceso,consulta,agregar', 0),
(4, 'Rol alto medio', 'acceso,consulta,agregar,actualizar', 0),
(5, 'Rol alto', 'acceso,consulta,agregar,actualizar,eliminar', 0),
(7, 'Super user', 'acceso,consulta,agregar,actualizar,eliminar', 0);

-- =========================================
-- Insertar datos en la tabla users ** TODAS LAS CONTRASEÑAS SON 12345678 **
-- =========================================
INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `password`, `deleted`, `rol_id`) VALUES
(1, 'Usuario', 'Básico', 'usuariobasico@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 1),
(2, 'Usuario', 'Medio', 'usuariomedio@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 2),
(3, 'Usuario', 'Medio Alto', 'usuariomedioa@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 3),
(4, 'Usuario', 'Alto Medio', 'usuarioaltom@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 4),
(5, 'Usuario', 'Alto', 'usuarioalto@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 5),
(6, 'Javier', 'Salazar', 'javier@example.com', '$2y$10$Wqd083faM0.f2ficYySYTedgvdPI85QXdHsf7okGhQRxrqfyVAYuK', 0, 5);

-- =========================================
-- Insertar datos en la tabla posts
-- =========================================
INSERT INTO `posts` (`id`, `title`, `description`, `date_created`, `deleted`, `user_id`) VALUES
(1, 'Explorando el Universo', 'Un artículo sobre los misterios del cosmos y la exploración espacial.', '2025-02-17 22:25:55', 0, 5),
(2, 'Cómo Aprender JavaScript Rápido', 'Consejos y trucos para dominar JavaScript en poco tiempo.', '2025-02-18 12:34:13', 0, 5),
(3, 'Recetas Saludables para el Día a Día', 'Ideas de comidas saludables y deliciosas para toda la familia.', '2025-02-19 05:53:43', 0, 4),
(4, 'Las Mejores Prácticas en Desarrollo Web', 'Buenas prácticas para escribir código limpio y eficiente en desarrollo web.', '2025-02-20 10:10:23', 0, 5),
(5, 'Historia de la Inteligencia Artificial', 'Desde sus inicios hasta la actualidad, la evolución de la IA.', '2025-02-21 19:10:24', 0, 4);

COMMIT;
