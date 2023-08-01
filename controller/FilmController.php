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
    public function detailsMovies($movieId)
    {
        $dao = new DAO();

        $sql2 = 'SELECT m.title, m.release_film, m.duration, m.synopsys, m.grade, m.poster, p.lastname AS nameDirector, p.firstname AS firstnameDirector, p.lastname AS nameActor, p.firstname AS firstnameActor
                FROM movie m
                INNER JOIN director d ON m.director_id = d.id_director
                WHERE m.id_movie = movie_id';

        $param = ['movie_id' => $movieId];

        $movie = $dao->executeRequest($sql2, $param)->fetch();

        require 'view/movie/detailsMovie.php';
    }
   
}

?>