<?php
require_once 'app/DAO.php';


class FilmController
{
    // function qui permet de récupérer la liste de tous les films ajoutés en BDD
    public function listMovies()
    {
        $dao = new DAO();

        $sql = 'SELECT m.id_movie, m.title, date_format(m.release_film, "%Y") year, m.duration, m.synopsys, m.grade, m.poster 
                FROM movie m
                ORDER BY m.release_film DESC';

        // -- Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur
        // $sql2 = 'SELECT f.id_film, f.titre_film, f.annee_sortie, DATE_FORMAT(f.duree_min*60, "%H:%i") AS duree_film, f.realisateur_id
        //         FROM film f
        //         WHERE f.titre_film = "Doctor strange in the multiverse of madness"';

        $movies = $dao->executeRequest($sql);
        require 'view/movie/listMovies.php';
    }

    // function qui permet de récupérer les infos d'un film (année de sortie, le casting, réalisateur, durée, synopsis, note)
    public function detailsMovie($id)
    {
        $dao = new DAO();

        // $sqlMovieDirector = 'SELECT m.title, m.release_film, m.duration, m.synopsys, m.grade, m.poster, d.firstname AS firstnameDirector, d.lastname AS lastnameDirector, a.firstname AS firstnameActor, a.lastname AS lastnameActor, r.name_role
        $sqlMovieDirector = 'SELECT m.title, m.release_film, m.duration, m.synopsys, m.grade, m.poster, d.firstname AS firstnameDirector, d.lastname AS lastnameDirector
        FROM movie m
        INNER JOIN director dir ON m.director_id = dir.id_director
        INNER JOIN person d ON dir.person_id = d.id_person
        -- INNER JOIN casting c ON m.id_movie = c.movie_id
        -- INNER JOIN actor act ON c.actor_id = act.id_actor
        -- INNER JOIN person a ON act.person_id = a.id_person
        -- INNER JOIN role r ON c.role_id = r.id_role
        WHERE m.id_movie = :movie_id';

        $paramsMovie = [':movie_id' => $id];
        
        $detailsMovie = $dao->executeRequest($sqlMovieDirector, $paramsMovie);

        // // APPROCHE : LISTE DES ACTEURS ET LISTE DES ROLES (SEPAREES) //

        // // actors
        // $sqlActors = 'SELECT *
        //     FROM casting c
        //         INNER JOIN actor act ON c.actor_id = act.id_actor
        //     WHERE c.movie_id = :movie_id
        // ';
        
        // $detailsActors = $dao->executeRequest($sqlActors, $paramsMovie);

        // // roles
        // $sqlRoles = 'SELECT *
        //     FROM casting c
        //         INNER JOIN role r ON c.role_id = r.id_role
        //     WHERE c.movie_id = :movie_id
        // ';
        
        // $detailsRoles = $dao->executeRequest($sqlRoles, $paramsMovie);

        // APPROCHE : PAR CASTING (acteur et rôle liés) //

        // castings
        $sqlCastings = 'SELECT a.firstname AS firstnameActor, a.lastname AS lastnameActor, r.name_role
            FROM casting c
                INNER JOIN actor act ON c.actor_id = act.id_actor
                INNER JOIN person a ON act.person_id = a.id_person
                INNER JOIN role r ON c.role_id = r.id_role
            WHERE c.movie_id = :movie_id
        ';
        
        $detailsCastings = $dao->executeRequest($sqlCastings, $paramsMovie);
        
        // $movie = $detailsMovie->fetch();

        require 'view/movie/detailsMovie.php';
    }

    // Affiche les films associés à un genre spécifique
    public function genreDetails()
    {
        $dao = new DAO();

        if (isset($_GET['id'])) {
            $genreId = $_GET['id'];

            // Récupérer les films associés à ce genre
            $sql = "SELECT m.id_movie, m.title, m.poster, g.label
            FROM movie m
            INNER JOIN movie_genre_link mgl ON m.id_movie = mgl.movie_id
            INNER JOIN genre g ON mgl.genre_id = g.id_genre
            WHERE mgl.genre_id = :genre_id;";

            $params = [':genre_id' => $id];
            $movies = $dao->executeRequest($sql, $params);

            // $genres = $dao->executeRequest("SELECT * FROM Genre");

            require 'view/genre/detailsGenre.php';
        }
    }

    // Affiche la liste de tous les acteurs/actrices
    public function listActors()
    {
        $dao = new DAO();

        $sql = "SELECT a.id_actor, p.firstname, p.lastname
                FROM actor a
                INNER JOIN person p ON a.person_id = p.id_person
                ORDER BY p.lastname, p.firstname";

        $actors = $dao->executeRequest($sql);

        require 'view/actor/listActors.php';
    }
   
}

?>