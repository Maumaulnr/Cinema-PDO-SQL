-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema
CREATE DATABASE IF NOT EXISTS `cinema` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema`;

-- Listage de la structure de table cinema. actor
CREATE TABLE IF NOT EXISTS `actor` (
  `id_actor` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  PRIMARY KEY (`id_actor`),
  UNIQUE KEY `person_id` (`person_id`),
  CONSTRAINT `actor_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.actor : ~11 rows (environ)
INSERT INTO `actor` (`id_actor`, `person_id`) VALUES
	(4, 1),
	(3, 2),
	(5, 3),
	(2, 4),
	(1, 5),
	(6, 9),
	(11, 10),
	(7, 11),
	(9, 13),
	(10, 14),
	(8, 15);

-- Listage de la structure de table cinema. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `movie_id` int NOT NULL,
  `role_id` int NOT NULL,
  `actor_id` int NOT NULL,
  PRIMARY KEY (`movie_id`,`role_id`,`actor_id`),
  KEY `role_id` (`role_id`),
  KEY `actor_id` (`actor_id`),
  CONSTRAINT `casting_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id_movie`),
  CONSTRAINT `casting_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id_role`),
  CONSTRAINT `casting_ibfk_3` FOREIGN KEY (`actor_id`) REFERENCES `actor` (`id_actor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.casting : ~12 rows (environ)
INSERT INTO `casting` (`movie_id`, `role_id`, `actor_id`) VALUES
	(2, 1, 5),
	(3, 2, 4),
	(3, 3, 3),
	(1, 4, 1),
	(2, 5, 2),
	(6, 6, 9),
	(6, 7, 7),
	(6, 8, 10),
	(5, 9, 11),
	(5, 10, 6),
	(4, 11, 6),
	(1, 12, 8);

-- Listage de la structure de table cinema. director
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  PRIMARY KEY (`id_director`),
  UNIQUE KEY `person_id` (`person_id`),
  CONSTRAINT `director_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.director : ~3 rows (environ)
INSERT INTO `director` (`id_director`, `person_id`) VALUES
	(2, 6),
	(1, 7),
	(3, 8),
	(4, 12);

-- Listage de la structure de table cinema. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `label` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_genre`) USING BTREE,
  UNIQUE KEY `label` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.genre : ~6 rows (environ)
INSERT INTO `genre` (`id_genre`, `label`) VALUES
	(1, 'Action'),
	(6, 'Comedy'),
	(5, 'Drama'),
	(2, 'Fantasy'),
	(20, 'Horror'),
	(3, 'Science-fiction'),
	(4, 'Thriller');

-- Listage de la structure de table cinema. movie
CREATE TABLE IF NOT EXISTS `movie` (
  `id_movie` int NOT NULL AUTO_INCREMENT,
  `director_id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `release_film` date NOT NULL,
  `duration` int NOT NULL DEFAULT '0',
  `synopsys` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `grade` decimal(2,1) NOT NULL,
  `poster` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`id_movie`),
  KEY `director_id` (`director_id`),
  CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`director_id`) REFERENCES `director` (`id_director`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.movie : ~6 rows (environ)
INSERT INTO `movie` (`id_movie`, `director_id`, `title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`) VALUES
	(1, 3, 'Robin des bois', '2003-02-15', 124, 'Robin entre en résistance et rallie à sa cause une petite bande de maraudeurs dont les prouesses de combat n’ont d’égal que le goût pour les plaisirs de la vie. Ensemble, ils vont s\'efforcer de soulager un peuple opprimé et pressuré sans merci, de ramener la justice en Angleterre et de restaurer la gloire d\'un royaume menacé par la guerre civile. Brigand pour les uns, héros pour les autres, la légende de "Robin des bois" est née.', 3.2, 'Robin_des_bois_2010.jpg'),
	(2, 1, 'Le Seigneur des anneaux : La communauté de l\'anneau', '2001-12-19', 125, ' Dans La Comté, à Hobbitebourg, se joue le sort de la Terre du Milieu. Frodon, paisible hobbit, se voit remettre par le vieux Bilbon un anneau mystérieux. Gandalf le magicien est persuadé que cet anneau recèle des pouvoirs infinis. Pour lui, il s’agit de l’anneau unique. D’apparence anodine, cette bague est l’objet des convoitises du diabolique Sauron, seigneur de Mordor. D’ailleurs, le trot infernal de ses soldats, les chevaliers noirs, retentit déjà dans le comté. La seule échappatoire pour Frodon, désormais porteur de l’anneau, est de fuir avec ses cousins Pippin et Merry, et son fidèle serviteur Sam. Il doit se rendre en terre ennemie, dans le lointain pays de Mordor, pour détruire l’anneau.', 4.5, 'The_Lord_of_the_ring-The_Fellowship_of_the_ring.jpg'),
	(3, 2, 'Inception', '2010-07-21', 154, 'Dom Cobb est spécialiste des extractions. Il s’invite dans le sommeil de ses victimes pour y dérober des informations précieuses qu’on ne trouve que dans le subconscient. Cobb se fait commissionner par Saito non pas pour voler quelque chose, plutôt pour déposer quelque chose dans le subconscient de Robert Fisher : une inception.', 4.5, 'Inception_poster.jpg'),
	(4, 2, 'Interstellar', '2014-11-05', 169, 'Le film raconte les aventures d’un groupe d’explorateurs qui utilisent une faille récemment découverte dans l’espace-temps afin de repousser les limites humaines et partir à la conquête des distances astronomiques dans un voyage interstellaire. ', 4.5, 'Interstellar_poster.jpg'),
	(5, 2, 'The Dark Knight Rises', '2012-07-20', 164, 'Il y a huit ans, Batman a disparu dans la nuit : lui qui était un héros est alors devenu un fugitif. S\'accusant de la mort du procureur-adjoint Harvey Dent, le Chevalier Noir a tout sacrifié au nom de ce que le commissaire Gordon et lui-même considéraient être une noble cause. Et leurs actions conjointes se sont avérées efficaces pour un temps puisque la criminalité a été éradiquée à Gotham City grâce à l\'arsenal de lois répressif initié par Dent.', 4.3, 'The_Dark_Knight_Rises.jpg'),
	(6, 4, 'Dark Shadows', '2012-05-09', 112, 'En 1752, Joshua et Naomi Collins quittent Liverpool, en Angleterre, pour prendre la mer avec leur jeune fils Barnabas, et commencer une nouvelle vie en Amérique. Mais même un océan ne parvient pas à les éloigner de la terrible malédiction qui s’est abattue sur leur famille. Vingt années passent et Barnabas a le monde à ses pieds, ou du moins la ville de Collinsport, dans le Maine. Riche et puissant, c’est un séducteur invétéré… jusqu’à ce qu’il commette la grave erreur de briser le cœur d’Angelique Bouchard. C’est une sorcière, dans tous les sens du terme, qui lui jette un sort bien plus maléfique que la mort : celui d’être transformé en vampire et enterré vivant.', 3.5, 'Dark_Shadows.jpg');

-- Listage de la structure de table cinema. movie_genre_link
CREATE TABLE IF NOT EXISTS `movie_genre_link` (
  `movie_id` int NOT NULL,
  `genre_id` int NOT NULL,
  PRIMARY KEY (`movie_id`,`genre_id`) USING BTREE,
  KEY `gender_id` (`genre_id`) USING BTREE,
  CONSTRAINT `movie_genre_link_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id_movie`),
  CONSTRAINT `movie_genre_link_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.movie_genre_link : ~5 rows (environ)
INSERT INTO `movie_genre_link` (`movie_id`, `genre_id`) VALUES
	(1, 1),
	(5, 1),
	(2, 2),
	(3, 3),
	(4, 3);

-- Listage de la structure de table cinema. person
CREATE TABLE IF NOT EXISTS `person` (
  `id_person` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `lastname` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `gender_person` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `birth_date` date NOT NULL,
  PRIMARY KEY (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.person : ~15 rows (environ)
INSERT INTO `person` (`id_person`, `firstname`, `lastname`, `gender_person`, `birth_date`) VALUES
	(1, 'Leonardo', 'DiCaprio', 'Male', '1974-11-11'),
	(2, 'Tom', 'Hardy', 'Male', '1977-09-15'),
	(3, 'Ian', 'McKellen', 'Male', '1939-05-25'),
	(4, 'Liv', 'Tyler', 'Female', '1977-07-01'),
	(5, 'Cate', 'Blanchett', 'Female', '1969-05-14'),
	(6, 'Christopher', 'Nolan', 'Male', '1970-07-30'),
	(7, 'Peter', 'Jackson', 'Male', '1961-10-31'),
	(8, 'Ridley', 'Scott', 'Male', '1937-11-30'),
	(9, 'Anne', 'Hathaway', 'Female', '1982-11-12'),
	(10, 'Christian', 'Bale', 'Male', '1974-01-30'),
	(11, 'Eva', 'Green', 'Female', '1980-07-06'),
	(12, 'Tim', 'Burton', 'Male', '1958-08-25'),
	(13, 'Johnny', 'Depp', 'Male', '1963-06-09'),
	(14, 'Helena', 'Bohnam Carter', 'Female', '1966-05-26'),
	(15, 'Russell', 'Crow', 'Male', '1964-04-07');

-- Listage de la structure de table cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `name_role` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema.role : ~12 rows (environ)
INSERT INTO `role` (`id_role`, `name_role`) VALUES
	(1, 'Gandalf'),
	(2, 'Cobb'),
	(3, 'Eames'),
	(4, 'Marianne Loxley'),
	(5, 'Arwen'),
	(6, 'Barnabas Collins'),
	(7, 'Angelique Bouchard'),
	(8, 'Dr Julia Hoffman'),
	(9, 'Batman'),
	(10, 'Catwoman'),
	(11, 'Amelia Brand'),
	(12, 'Robin des bois');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
