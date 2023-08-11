<!-- Delete movies, actors, ... -->

<?php
require_once 'app/DAO.php';


class DeleteController
{
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