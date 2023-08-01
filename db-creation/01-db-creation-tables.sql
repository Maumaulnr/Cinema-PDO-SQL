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

