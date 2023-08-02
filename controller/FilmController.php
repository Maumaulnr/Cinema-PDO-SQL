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

        $sql2 = 'SELECT m.title, m.release_film, m.duration, m.synopsys, m.grade, m.poster
                FROM movie m
                WHERE m.id_movie = :id';

        // Return all the director
        $sql3 = 'SELECT m.title, p.lastname AS lastnameDirector, p.firstname AS firstnameDirector
                FROM movie m
                INNER JOIN director d ON m.director_id = d.id_director
                INNER JOIN person p ON d.person_id = p.id_person
                WHERE m.id_movie = :id';
        
        // Return the casting
        $sql4 = 'SELECT m.title, r.name_role, p.firstname AS firstnameActor, p.lastname AS lastnameActor
                FROM casting c
                INNER JOIN movie m ON c.movie_id = m.id_movie
                INNER JOIN role r ON c.role_id = r.id_role
                INNER JOIN actor a ON c.actor_id = a.id_actor
                INNER JOIN person p ON a.person_id = p.id_person
                WHERE m.id_movie = :id';

        $param = ['movie_id' => $id];
        
        $detailsMovie = $dao -> executeRequest($sql2, [':id' => $id]);
        $movieDirector = $dao -> executeRequest($sql3, [':id' => $id]);
        $castingMovie = $dao -> executeRequest($sql4, [':id' => $id]);

        require 'view/movie/detailsMovie.php';
    }
   
}

?>