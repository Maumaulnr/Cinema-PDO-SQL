CREATE DATABASE IF NOT EXISTS `Cinema-PDO-01` /*!40100 COLLATE 'utf8mb4_0900_ai_ci' */;

USE `Cinema-PDO-01`;

CREATE TABLE IF NOT EXISTS Genre(
   id_genre INT NOT NULL AUTO_INCREMENT,
   label VARCHAR(30) NOT NULL,
   PRIMARY KEY(id_genre)
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
   genre_id INT,
   PRIMARY KEY(movie_id, genre_id),
   FOREIGN KEY(movie_id) REFERENCES Movie(id_movie),
   FOREIGN KEY(genre_id) REFERENCES Genre(id_genre)
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

SELECT m.title, m.release_film, m.duration, m.synopsys, m.grade, m.poster, d.firstname AS firstnameDirector, d.lastname AS lastnameDirector, a.firstname AS firstnameActor, a.lastname AS lastnameActor, r.name_role
FROM movie m
LEFT JOIN director dir ON m.director_id = dir.id_director
LEFT JOIN person d ON dir.person_id = d.id_person
LEFT JOIN casting c ON m.id_movie = c.movie_id
LEFT JOIN actor act ON c.actor_id = act.id_actor
LEFT JOIN person a ON act.person_id = a.id_person
LEFT JOIN role r ON c.role_id = r.id_role
WHERE m.id_movie = movie_id;

INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Robin des bois', '2003-02-15', 124, 'Robin entre en résistance et rallie à sa cause une petite bande de maraudeurs dont les prouesses de combat n’ont d’égal que le goût pour les plaisirs de la vie. Ensemble, ils vont s\'efforcer de soulager un peuple opprimé et pressuré sans merci, de ramener la justice en Angleterre et de restaurer la gloire d\'un royaume menacé par la guerre civile. Brigand pour les uns, héros pour les autres, la légende de "Robin des bois" est née.', 3.2, 'Robin_des_bois_2010.jpg', 'Ridley', 'Scott', 'Cate', 'Blanchett', 'Marianne Loxley');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Robin des bois', '2003-02-15', 124, 'Robin entre en résistance et rallie à sa cause une petite bande de maraudeurs dont les prouesses de combat n’ont d’égal que le goût pour les plaisirs de la vie. Ensemble, ils vont s\'efforcer de soulager un peuple opprimé et pressuré sans merci, de ramener la justice en Angleterre et de restaurer la gloire d\'un royaume menacé par la guerre civile. Brigand pour les uns, héros pour les autres, la légende de "Robin des bois" est née.', 3.2, 'Robin_des_bois_2010.jpg', 'Ridley', 'Scott', 'Russell', 'Crow', 'Robin des bois');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Le Seigneur des anneaux : La communauté de l\'anneau', '2001-12-19', 125, ' Dans La Comté, à Hobbitebourg, se joue le sort de la Terre du Milieu. Frodon, paisible hobbit, se voit remettre par le vieux Bilbon un anneau mystérieux. Gandalf le magicien est persuadé que cet anneau recèle des pouvoirs infinis. Pour lui, il s’agit de l’anneau unique. D’apparence anodine, cette bague est l’objet des convoitises du diabolique Sauron, seigneur de Mordor. D’ailleurs, le trot infernal de ses soldats, les chevaliers noirs, retentit déjà dans le comté. La seule échappatoire pour Frodon, désormais porteur de l’anneau, est de fuir avec ses cousins Pippin et Merry, et son fidèle serviteur Sam. Il doit se rendre en terre ennemie, dans le lointain pays de Mordor, pour détruire l’anneau.', 4.5, 'The_Lord_of_the_ring-The_Fellowship_of_the_ring.jpg', 'Peter', 'Jackson', 'Ian', 'McKellen', 'Gandalf');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Le Seigneur des anneaux : La communauté de l\'anneau', '2001-12-19', 125, ' Dans La Comté, à Hobbitebourg, se joue le sort de la Terre du Milieu. Frodon, paisible hobbit, se voit remettre par le vieux Bilbon un anneau mystérieux. Gandalf le magicien est persuadé que cet anneau recèle des pouvoirs infinis. Pour lui, il s’agit de l’anneau unique. D’apparence anodine, cette bague est l’objet des convoitises du diabolique Sauron, seigneur de Mordor. D’ailleurs, le trot infernal de ses soldats, les chevaliers noirs, retentit déjà dans le comté. La seule échappatoire pour Frodon, désormais porteur de l’anneau, est de fuir avec ses cousins Pippin et Merry, et son fidèle serviteur Sam. Il doit se rendre en terre ennemie, dans le lointain pays de Mordor, pour détruire l’anneau.', 4.5, 'The_Lord_of_the_ring-The_Fellowship_of_the_ring.jpg', 'Peter', 'Jackson', 'Liv', 'Tyler', 'Arwen');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Inception', '2010-07-21', 154, 'Dom Cobb est spécialiste des extractions. Il s’invite dans le sommeil de ses victimes pour y dérober des informations précieuses qu’on ne trouve que dans le subconscient. Cobb se fait commissionner par Saito non pas pour voler quelque chose, plutôt pour déposer quelque chose dans le subconscient de Robert Fisher : une inception.', 4.5, 'Inception_poster.jpg', 'Christopher', 'Nolan', 'Leonardo', 'DiCaprio', 'Cobb');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Inception', '2010-07-21', 154, 'Dom Cobb est spécialiste des extractions. Il s’invite dans le sommeil de ses victimes pour y dérober des informations précieuses qu’on ne trouve que dans le subconscient. Cobb se fait commissionner par Saito non pas pour voler quelque chose, plutôt pour déposer quelque chose dans le subconscient de Robert Fisher : une inception.', 4.5, 'Inception_poster.jpg', 'Christopher', 'Nolan', 'Tom', 'Hardy', 'Eames');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Interstellar', '2014-11-05', 169, 'Le film raconte les aventures d’un groupe d’explorateurs qui utilisent une faille récemment découverte dans l’espace-temps afin de repousser les limites humaines et partir à la conquête des distances astronomiques dans un voyage interstellaire. ', 4.5, 'Interstellar_poster.jpg', 'Christopher', 'Nolan', 'Anne', 'Hathaway', 'Amelia Brand');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('The Dark Knight Rises', '2012-07-20', 164, 'Il y a huit ans, Batman a disparu dans la nuit : lui qui était un héros est alors devenu un fugitif. S\'accusant de la mort du procureur-adjoint Harvey Dent, le Chevalier Noir a tout sacrifié au nom de ce que le commissaire Gordon et lui-même considéraient être une noble cause. Et leurs actions conjointes se sont avérées efficaces pour un temps puisque la criminalité a été éradiquée à Gotham City grâce à l\'arsenal de lois répressif initié par Dent.', 4.3, 'The_Dark_Knight_Rises.jpg', 'Christopher', 'Nolan', 'Christian', 'Bale', 'Batman');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('The Dark Knight Rises', '2012-07-20', 164, 'Il y a huit ans, Batman a disparu dans la nuit : lui qui était un héros est alors devenu un fugitif. S\'accusant de la mort du procureur-adjoint Harvey Dent, le Chevalier Noir a tout sacrifié au nom de ce que le commissaire Gordon et lui-même considéraient être une noble cause. Et leurs actions conjointes se sont avérées efficaces pour un temps puisque la criminalité a été éradiquée à Gotham City grâce à l\'arsenal de lois répressif initié par Dent.', 4.3, 'The_Dark_Knight_Rises.jpg', 'Christopher', 'Nolan', 'Anne', 'Hathaway', 'Catwoman');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Dark Shadows', '2012-05-09', 112, 'En 1752, Joshua et Naomi Collins quittent Liverpool, en Angleterre, pour prendre la mer avec leur jeune fils Barnabas, et commencer une nouvelle vie en Amérique. Mais même un océan ne parvient pas à les éloigner de la terrible malédiction qui s’est abattue sur leur famille. Vingt années passent et Barnabas a le monde à ses pieds, ou du moins la ville de Collinsport, dans le Maine. Riche et puissant, c’est un séducteur invétéré… jusqu’à ce qu’il commette la grave erreur de briser le cœur d’Angelique Bouchard. C’est une sorcière, dans tous les sens du terme, qui lui jette un sort bien plus maléfique que la mort : celui d’être transformé en vampire et enterré vivant.', 3.5, 'Dark_Shadows.jpg', 'Tim', 'Burton', 'Johnny', 'Depp', 'Barnabas Collins');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Dark Shadows', '2012-05-09', 112, 'En 1752, Joshua et Naomi Collins quittent Liverpool, en Angleterre, pour prendre la mer avec leur jeune fils Barnabas, et commencer une nouvelle vie en Amérique. Mais même un océan ne parvient pas à les éloigner de la terrible malédiction qui s’est abattue sur leur famille. Vingt années passent et Barnabas a le monde à ses pieds, ou du moins la ville de Collinsport, dans le Maine. Riche et puissant, c’est un séducteur invétéré… jusqu’à ce qu’il commette la grave erreur de briser le cœur d’Angelique Bouchard. C’est une sorcière, dans tous les sens du terme, qui lui jette un sort bien plus maléfique que la mort : celui d’être transformé en vampire et enterré vivant.', 3.5, 'Dark_Shadows.jpg', 'Tim', 'Burton', 'Eva', 'Green', 'Angelique Bouchard');
INSERT INTO `Table inconnue` (`title`, `release_film`, `duration`, `synopsys`, `grade`, `poster`, `firstnameDirector`, `lastnameDirector`, `firstnameActor`, `lastnameActor`, `name_role`) VALUES ('Dark Shadows', '2012-05-09', 112, 'En 1752, Joshua et Naomi Collins quittent Liverpool, en Angleterre, pour prendre la mer avec leur jeune fils Barnabas, et commencer une nouvelle vie en Amérique. Mais même un océan ne parvient pas à les éloigner de la terrible malédiction qui s’est abattue sur leur famille. Vingt années passent et Barnabas a le monde à ses pieds, ou du moins la ville de Collinsport, dans le Maine. Riche et puissant, c’est un séducteur invétéré… jusqu’à ce qu’il commette la grave erreur de briser le cœur d’Angelique Bouchard. C’est une sorcière, dans tous les sens du terme, qui lui jette un sort bien plus maléfique que la mort : celui d’être transformé en vampire et enterré vivant.', 3.5, 'Dark_Shadows.jpg', 'Tim', 'Burton', 'Helena', 'Bohnam Carter', 'Dr Julia Hoffman');
