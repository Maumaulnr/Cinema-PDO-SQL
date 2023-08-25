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
        WHERE m.id_movie = :movie_id
        ORDER BY title ASC;';

        $paramsMovie = [':movie_id' => $id];
        
        $detailsMovie = $dao->executeRequest($sqlMovieDirector, $paramsMovie);

        // APPROCHE : LISTE DES ACTEURS ET LISTE DES ROLES (SEPAREES) //

        // $sqlActors = 'SELECT *
        //     FROM casting c
        //     INNER JOIN actor act ON c.actor_id = act.id_actor
        //     WHERE c.movie_id = :movie_id
        // ';
        
        // $detailsActors = $dao->executeRequest($sqlActors, $paramsMovie);

        // roles
        // $sqlRoles = 'SELECT *
        //     FROM casting c
        //     INNER JOIN role r ON c.role_id = r.id_role
        //     WHERE c.movie_id = :movie_id
        // ';
        
        // $detailsRoles = $dao->executeRequest($sqlRoles, $paramsMovie);

        // APPROCHE : PAR CASTING (acteur et rôle liés) //

        // Castings
        $sqlCastings = 'SELECT a.firstname AS firstnameActor, a.lastname AS lastnameActor, r.name_role
            FROM casting c
                INNER JOIN actor act ON c.actor_id = act.id_actor
                INNER JOIN person a ON act.person_id = a.id_person
                INNER JOIN role r ON c.role_id = r.id_role
            WHERE c.movie_id = :movie_id
        ';
        
        $detailsCastings = $dao->executeRequest($sqlCastings, $paramsMovie);

        require 'view/movie/detailsMovie.php';
    }

    

    // Affiche la liste de tous les acteurs/actrices
    public function listActors()
    {
        $dao = new DAO();

        $sqlListActor = "SELECT a.id_actor, p.firstname, p.lastname
                FROM actor a
                INNER JOIN person p ON a.person_id = p.id_person
                ORDER BY p.lastname, p.firstname";

        $actors = $dao->executeRequest($sqlListActor);

        require 'view/actor/listActors.php';
    }


    // FORMULAIRE POUR INSERER UN FILM
    public function insertMovieForm() {
        $dao = new DAO();

        $sqlDirectors = "SELECT p.firstname AS firstnameDirector, p.lastname AS lastnameDirector
        FROM director d
        INNER JOIN person p ON d.person_id = p.id_person
        ORDER BY lastname ASC ;";

        $directors = $dao->executeRequest($sqlDirectors);

        require "view/movie/insertMovieForm.php";
    }

    public function insertMovie() {
        $dao = new DAO();

            $movieTitle = filter_input(INPUT_POST, "movieTitle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $movieReleaseFilm = filter_input(INPUT_POST, "movieReleaseFilm", FILTER_SANITIZE_NUMBER_INT);
            $movieDuration = filter_input(INPUT_POST, "movieDuration", FILTER_SANITIZE_NUMBER_INT);
            $movieSynopsys = filter_input(INPUT_POST, "movieSynopsys", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $movieGrade = filter_input(INPUT_POST, "movieGrade", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $moviePoster = filter_input(INPUT_POST, "moviePoster", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $movieDirector = filter_input(INPUT_POST, "movieDirector", FILTER_SANITIZE_NUMBER_INT);

            $movieActor = filter_input(INPUT_POST, "movieActor", FILTER_SANITIZE_NUMBER_INT);
            $movieRole = filter_input(INPUT_POST, "movieRole", FILTER_SANITIZE_NUMBER_INT);

            $movieGenres = filter_input(INPUT_POST, "movieGenre", FILTER_SANITIZE_NUMBER_INT);


        if(!empty($movieTitle) && !empty($movieReleaseFilm) && !empty($movieDuration) && !empty($movieSynopsys) && !empty($movieGrade) && !empty($moviePoster)) {
            // Insert movie details
            $sqlAddMovie = 'INSERT INTO movie (title, release_film, duration, synopsys, grade, poster)
            VALUES (:title, :release_film, :duration, :synopsys, :grade, :poster)';

            $addMovieParams = [
                ':title' => $movieTitle, 
                ':release_film' => $movieReleaseFilm, 
                ':duration' => $movieDuration, 
                ':synopsys' => $movieSynopsys, 
                ':grade' => $movieGrade, 
                ':poster' => $moviePoster
            ];

            // We execute the query and stock it in an associative array
            // Stock the information about the film
            $insertMovie = $dao->executeRequest($sqlAddMovie, $addMovieParams);

        }
        
        require "view/movie/insertMovieForm.php";
    }


    // DELETE
    public function deleteMovieForm() {
        $dao = new DAO();

        $sqlDelete = "SELECT m.id_movie, m.title, m.release_film, m.duration, m.synopsys, d.firstname AS firstnameDirector, d.lastname AS lastnameDirector 
        FROM movie m 
        INNER JOIN director dir ON m.director_id = dir.id_director
        INNER JOIN person d ON dir.person_id = d.id_person
        ORDER BY m.id_movie ASC;" ;

        $movies = $dao->executeRequest($sqlDelete);

        // Redirection to the deleteMovie.php
        require "view/delete/deleteMovieForm.php";
    }
   
}

?>