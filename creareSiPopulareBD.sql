SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS revista_online;
USE revista_online;

DROP TABLE IF EXISTS `articole`;
CREATE TABLE IF NOT EXISTS `articole` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titlu` varchar(255) NOT NULL,
  `continut` text NOT NULL,
  `data_publicarii` datetime NOT NULL,
  `id_utilizator` int NOT NULL,
  `status` enum('aprobat','neaprobat') NOT NULL,
  `categorie` enum('artistic','tehnic','stiintific','moda') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizator` (`id_utilizator`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `articole` (`id`, `titlu`, `continut`, `data_publicarii`, `id_utilizator`, `status`, `categorie`) VALUES
(1, 'Titlu articol 1', 'Continut articol 1', '2023-02-21 07:44:26', 1, 'aprobat', 'artistic'),
(2, 'Titlu articol 2', 'Continut articol 2', '2023-02-21 07:44:26', 1, 'aprobat', 'tehnic'),
(3, 'Titlu articol 3', 'Continut articol 3', '2023-02-21 07:44:26', 1, 'aprobat', 'stiintific'),
(4, 'Titlu articol 4', 'Continut articol 4', '2023-02-21 07:44:26', 1, 'aprobat', 'moda'),
(5, 'Titlu articol 5', 'Continut articol 5', '2023-02-21 07:44:26', 1, 'aprobat', 'artistic'),
(6, 'Titlu articol 6', 'Continut articol 6', '2023-02-21 07:44:26', 1, 'neaprobat', 'tehnic'),
(7, 'Titlu articol 7', 'Continut articol 7', '2023-02-21 07:44:26', 1, 'neaprobat', 'stiintific'),
(8, 'Titlu articol 8', 'continutul acestui articol este foooooaaaaarte luuuuuuuuung', '2023-02-21 07:44:26', 1, 'neaprobat', 'moda');

DROP TABLE IF EXISTS `utilizatori`;
CREATE TABLE IF NOT EXISTS `utilizatori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nume_utilizator` varchar(50) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `tip_utilizator` enum('autor','editor','cititor') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `utilizatori` (`id`, `nume_utilizator`, `parola`, `tip_utilizator`) VALUES
(1, 'autor1', 'parola1', 'autor'),
(2, 'editor1', 'parola1', 'editor'),
(3, 'cititor1', 'parola1', 'cititor'),
(4, 'cititor_test1@email.com', '$2y$10$pOgxc3UqPQRzhD2AUeGmGO/p6DqVRflV5MEw1hv3iZYlrQTosr1vO', 'cititor'),
(5, 'cititor_test2@email.com', '$2y$10$3gmPia2tZS8XAzwqJrIkP.RtFSbX2Q8wdcc.ArPICW2Cz8.Y8deWq', 'cititor'),
(6, 'autor1', '$2y$10$Dm7Aax77TFUXBt/8/9gG/.uEu9f26OuX5e5z6eDn69BnupIpJYiW2', 'autor'),
(7, 'autor5', '$2y$10$0jIed4JsJPvXJv5TbroJ3.XKxajFRROYBoBVlofAcBChwoix.3kiW', 'autor');
COMMIT;
