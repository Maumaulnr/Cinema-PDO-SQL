CREATE DATABASE IF NOT EXISTS `Cinema-PDO-01` /*!40100 COLLATE 'utf8mb4_0900_ai_ci' */;

USE `Cinema-PDO-01`;

CREATE TABLE IF NOT EXISTS Gender(
   id_gender INT NOT NULL AUTO_INCREMENT,
   label VARCHAR(30) NOT NULL,
   PRIMARY KEY(id_gender)
);

CREATE TABLE IF NOT EXISTS Role(
   id_role INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_role)
);

CREATE TABLE IF NOT EXISTS Person(
   id_person INT NOT NULL AUTO_INCREMENT,
   firstname VARCHAR(50) NOT NULL,
   lastname VARCHAR(70) NOT NULL,
   gender VARCHAR(30) NOT NULL,
   birth_date DATE NOT NULL,
   is_alive TINYINT(1) NOT NULL,
   PRIMARY KEY(id_person)
);

CREATE TABLE IF NOT EXISTS Director(
   id_director INT NOT NULL AUTO_INCREMENT,
   person_id INT NOT NULL,
   PRIMARY KEY(id_director),
   UNIQUE(person_id),
   FOREIGN KEY(person_id) REFERENCES Person(id_person)
);

CREATE TABLE IF NOT EXISTS Actor(
   id_actor INT NOT NULL AUTO_INCREMENT,
   person_id INT NOT NULL,
   PRIMARY KEY(id_actor),
   UNIQUE(person_id),
   FOREIGN KEY(person_id) REFERENCES Person(id_person)
);

CREATE TABLE IF NOT EXISTS Movie(
   id_movie INT NOT NULL AUTO_INCREMENT,
   director_id INT NOT NULL,
   title VARCHAR(100) NOT NULL,
   release_film DATE NOT NULL,
   duration INT NOT NULL,
   synopsys TEXT NOT NULL,
   grade DECIMAL(2,1) NOT NULL,
   poster VARCHAR(255) NOT NULL,
   PRIMARY KEY(id_movie),
   FOREIGN KEY(director_id) REFERENCES Director(id_director)
);

CREATE TABLE IF NOT EXISTS Movie_Genre_Link(
   movie_id INT,
   gender_id INT,
   PRIMARY KEY(movie_id, gender_id),
   FOREIGN KEY(movie_id) REFERENCES Movie(id_movie),
   FOREIGN KEY(gender_id) REFERENCES Gender(id_gender)
);

CREATE TABLE IF NOT EXISTS Casting(
   movie_id INT,
   role_id INT,
   actor_id INT,
   PRIMARY KEY(movie_id, role_id, actor_id),
   FOREIGN KEY(movie_id) REFERENCES Movie(id_movie),
   FOREIGN KEY(role_id) REFERENCES Role(id_role),
   FOREIGN KEY(actor_id) REFERENCES Actor(id_actor)
);

-- Request : 
-- b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)
SELECT
	m.title AS title,
	m.duration
FROM
	movie m
WHERE 
	m.duration > "02:15"
ORDER BY
	m.duration DESC;

-- Result :
INSERT INTO `movie` (`title`, `duration`) VALUES ('Le Seigneur des anneaux : La communauté de l\'anneau', '02:58:00');
INSERT INTO `movie` (`title`, `duration`) VALUES ('Inception', '02:28:00');
INSERT INTO `movie` (`title`, `duration`) VALUES ('Robin des bois', '02:20:00');


-- c. Liste des films d’un réalisateur (en précisant l’année de sortie)
SELECT
	m.title AS title,
	p.firstname AS firstname_director,
	YEAR(m.release_film) AS release_film
FROM 
	movie m
	INNER JOIN director d
		ON m.director_id = d.id_director
	INNER JOIN person p
		ON d.person_id = p.id_person
WHERE 
	d.person_id = 7;

-- Result :
INSERT INTO `Table inconnue` (`title`, `firstname_director`, `release_film`) VALUES ('Le Seigneur des anneaux : La communauté de l\'anneau', 'Peter', 2001);

-- d. Nombre de films par genre (classés dans l’ordre décroissant)
SELECT
	m.title AS title,
	g.label AS gender_film
FROM 
	movie m
	INNER JOIN movie_genre_link mgl
		ON m.id_movie = mgl.movie_id
	INNER JOIN gender g
		ON mgl.gender_id = g.id_gender
WHERE
	mgl.gender_id = 2
ORDER BY
	mgl.gender_id DESC;

-- Result :
INSERT INTO `Table inconnue` (`title`, `gender_film`) VALUES ('Le Seigneur des anneaux : La communauté de l\'anneau', 'Fantasy');


-- e. Nombre de films par réalisateur (classés dans l’ordre décroissant)
-- COUNT(*) = compte le nombre de films pour chaque groupe de réalisateur
SELECT
	p.firstname AS firstname_director,
	COUNT(*) AS nb_films
FROM
	movie m
	INNER JOIN director d
		ON m.director_id = d.id_director
	INNER JOIN person p
		ON d.person_id = p.id_person
GROUP BY
	p.firstname
ORDER BY
	nb_films DESC;

-- Result :
INSERT INTO `person` (`firstname_director`, `nb_films`) VALUES ('Peter', 1);
INSERT INTO `person` (`firstname_director`, `nb_films`) VALUES ('Christopher', 1);
INSERT INTO `person` (`firstname_director`, `nb_films`) VALUES ('Ridley', 1);


-- f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe
SELECT
	m.id_movie,
	p.lastname AS lastname_actor,
	p.firstname AS firstname_actor,
	p.gender_person AS gender_actor
FROM 
	movie m
	INNER JOIN casting c
		ON m.id_movie = c.movie_id
	INNER JOIN actor a
		ON c.actor_id = a.id_actor
	INNER JOIN person p
		ON a.person_id = p.id_person
WHERE
	m.id_movie = 2;
;

-- Result :
INSERT INTO `Table inconnue` (`id_movie`, `lastname_actor`, `firstname_actor`, `gender_actor`) VALUES (2, 'McKellen', 'Ian', 'Male');
INSERT INTO `Table inconnue` (`id_movie`, `lastname_actor`, `firstname_actor`, `gender_actor`) VALUES (2, 'Tyler', 'Liv', 'Female');


-- g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien)
SELECT
	c.actor_id,
	m.title,
	r.name_role,
	YEAR(m.release_film) AS release_film
FROM
	movie m
	INNER JOIN casting c
		ON m.id_movie = c.movie_id
	INNER JOIN role r
		ON c.role_id = r.id_role
WHERE
	c.actor_id = 4
ORDER BY
	release_film DESC;

-- Result :
INSERT INTO `Table inconnue` (`actor_id`, `title`, `name_role`, `release_film`) VALUES (4, 'Inception', 'Cobb', 2010);


-- h. Liste des personnes qui sont à la fois acteurs et réalisateurs
SELECT
	p.id_person,
	p.firstname
FROM
	person p
	INNER JOIN actor a
		ON p.id_person = a.person_id
	INNER JOIN director d
		ON a.person_id = d.person_id
WHERE 
	a.person_id IS NOT NULL AND 
	d.person_id IS NOT NULL 
GROUP BY
	p.id_person,
	p.firstname
;

-- Result :
None;


-- i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)
SELECT
	m.title
FROM
	movie m
WHERE 
	DATEDIFF(CURRENT_DATE, m.release_film) < YEAR(5)
ORDER BY
	m.release_film DESC
;

-- Result :
None;


-- j. Nombre d’hommes et de femmes parmi les acteurs
-- L’opérateur logique IN dans SQL  s’utilise avec la commande WHERE pour vérifier si une colonne est égale à une des valeurs comprise dans set de valeurs déterminés.
SELECT
	p.gender_person,
	COUNT(*) AS nb_actors
FROM 
	person p
WHERE
	p.id_person IN (SELECT c.actor_id FROM casting c)
GROUP BY
	p.gender_person
;

-- Result :
INSERT INTO `person` (`gender_person`, `nb_actors`) VALUES ('Male', 3);
INSERT INTO `person` (`gender_person`, `nb_actors`) VALUES ('Female', 2);


-- k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)
SELECT
	a.id_actor,
	p.firstname
FROM
	person p
	INNER JOIN actor a
		ON p.id_person = a.person_id
WHERE
	YEAR(CURRENT_DATE) - YEAR(p.birth_date) >= 50
;

INSERT INTO `Table inconnue` (`id_actor`, `firstname`) VALUES (5, 'Ian');
INSERT INTO `Table inconnue` (`id_actor`, `firstname`) VALUES (1, 'Cate');


-- l. Acteurs ayant joué dans 3 films ou plus
SELECT
	a.id_actor,
	p.firstname,
	COUNT(*) AS nb_films
FROM
	person p
	INNER JOIN actor a
		ON p.id_person = a.person_id
GROUP BY
	a.id_actor,
	p.firstname
HAVING 
	nb_films >= 3;
;

-- Result :
None;

--------------------------

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


-- Listage de la structure de la base pour cinema-pdo-01
CREATE DATABASE IF NOT EXISTS `cinema-pdo-01` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema-pdo-01`;

-- Listage de la structure de table cinema-pdo-01. actor
CREATE TABLE IF NOT EXISTS `actor` (
  `id_actor` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  PRIMARY KEY (`id_actor`),
  UNIQUE KEY `person_id` (`person_id`),
  CONSTRAINT `actor_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.actor : ~5 rows (environ)
INSERT INTO `actor` (`id_actor`, `person_id`) VALUES
	(4, 1),
	(3, 2),
	(5, 3),
	(2, 4),
	(1, 5);

-- Listage de la structure de table cinema-pdo-01. casting
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.casting : ~5 rows (environ)
INSERT INTO `casting` (`movie_id`, `role_id`, `actor_id`) VALUES
	(2, 1, 5),
	(3, 2, 4),
	(3, 3, 3),
	(1, 4, 1),
	(2, 5, 2);

-- Listage de la structure de table cinema-pdo-01. director
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  PRIMARY KEY (`id_director`),
  UNIQUE KEY `person_id` (`person_id`),
  CONSTRAINT `director_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.director : ~3 rows (environ)
INSERT INTO `director` (`id_director`, `person_id`) VALUES
	(2, 6),
	(1, 7),
	(3, 8);

-- Listage de la structure de table cinema-pdo-01. gender
CREATE TABLE IF NOT EXISTS `gender` (
  `id_gender` int NOT NULL AUTO_INCREMENT,
  `label` varchar(30) NOT NULL,
  PRIMARY KEY (`id_gender`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.gender : ~5 rows (environ)
INSERT INTO `gender` (`id_gender`, `label`) VALUES
	(1, 'Action'),
	(2, 'Fantasy'),
	(3, 'Science-fiction'),
	(4, 'Thriller'),
	(5, 'Drama');

-- Listage de la structure de table cinema-pdo-01. movie
CREATE TABLE IF NOT EXISTS `movie` (
  `id_movie` int NOT NULL AUTO_INCREMENT,
  `director_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `release_film` date NOT NULL,
  `duration` time NOT NULL,
  `synopsys` text NOT NULL,
  `grade` decimal(2,1) NOT NULL,
  `poster` varchar(255) NOT NULL,
  PRIMARY KEY (`id_movie`),
  KEY `director_id` (`director_id`),
  CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`director_id`) REFERENCES `director` (`id_director`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.movie : ~3 rows (environ)
INSERT INTO `movie` (`id_movie`, `director_id`, `title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`) VALUES
	(1, 3, 'Robin des bois', '2003-02-15', '02:20:00', 'Robin entre en résistance et rallie à sa cause une petite bande de maraudeurs dont les prouesses de combat n’ont d’égal que le goût pour les plaisirs de la vie. Ensemble, ils vont s\'efforcer de soulager un peuple opprimé et pressuré sans merci, de ramener la justice en Angleterre et de restaurer la gloire d\'un royaume menacé par la guerre civile. Brigand pour les uns, héros pour les autres, la légende de "Robin des bois" est née.', 3.2, 'Robin_des_bois_2010.jpg'),
	(2, 1, 'Le Seigneur des anneaux : La communauté de l\'anneau', '2001-12-19', '02:58:00', ' Dans La Comté, à Hobbitebourg, se joue le sort de la Terre du Milieu. Frodon, paisible hobbit, se voit remettre par le vieux Bilbon un anneau mystérieux. Gandalf le magicien est persuadé que cet anneau recèle des pouvoirs infinis. Pour lui, il s’agit de l’anneau unique. D’apparence anodine, cette bague est l’objet des convoitises du diabolique Sauron, seigneur de Mordor. D’ailleurs, le trot infernal de ses soldats, les chevaliers noirs, retentit déjà dans le comté. La seule échappatoire pour Frodon, désormais porteur de l’anneau, est de fuir avec ses cousins Pippin et Merry, et son fidèle serviteur Sam. Il doit se rendre en terre ennemie, dans le lointain pays de Mordor, pour détruire l’anneau.', 4.5, 'The_Lord_of_the_ring-The_Fellowship_of_the_ring.jpg'),
	(3, 2, 'Inception', '2010-07-21', '02:28:00', 'Dom Cobb est spécialiste des extractions. Il s’invite dans le sommeil de ses victimes pour y dérober des informations précieuses qu’on ne trouve que dans le subconscient. Cobb se fait commissionner par Saito non pas pour voler quelque chose, plutôt pour déposer quelque chose dans le subconscient de Robert Fisher : une inception.', 4.5, 'Inception_poster.jpg');

-- Listage de la structure de table cinema-pdo-01. movie_genre_link
CREATE TABLE IF NOT EXISTS `movie_genre_link` (
  `movie_id` int NOT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`movie_id`,`gender_id`),
  KEY `gender_id` (`gender_id`),
  CONSTRAINT `movie_genre_link_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id_movie`),
  CONSTRAINT `movie_genre_link_ibfk_2` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id_gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.movie_genre_link : ~3 rows (environ)
INSERT INTO `movie_genre_link` (`movie_id`, `gender_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3);

-- Listage de la structure de table cinema-pdo-01. person
CREATE TABLE IF NOT EXISTS `person` (
  `id_person` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(70) NOT NULL,
  `gender_person` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birth_date` date NOT NULL,
  `is_alive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.person : ~8 rows (environ)
INSERT INTO `person` (`id_person`, `firstname`, `lastname`, `gender_person`, `birth_date`, `is_alive`) VALUES
	(1, 'Leonardo', 'DiCaprio', 'Male', '1974-11-11', 1),
	(2, 'Tom', 'Hardy', 'Male', '1977-09-15', 1),
	(3, 'Ian', 'McKellen', 'Male', '1939-05-25', 0),
	(4, 'Liv', 'Tyler', 'Female', '1977-07-01', 1),
	(5, 'Cate', 'Blanchett', 'Female', '1969-05-14', 1),
	(6, 'Christopher', 'Nolan', 'Male', '1970-07-30', 1),
	(7, 'Peter', 'Jackson', 'Male', '1961-10-31', 1),
	(8, 'Ridley', 'Scott', 'Male', '1937-11-30', 1);

-- Listage de la structure de table cinema-pdo-01. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `name_role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema-pdo-01.role : ~5 rows (environ)
INSERT INTO `role` (`id_role`, `name_role`) VALUES
	(1, 'Gandalf'),
	(2, 'Cobb'),
	(3, 'Eames'),
	(4, 'Marianne Loxley'),
	(5, 'Arwen');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
