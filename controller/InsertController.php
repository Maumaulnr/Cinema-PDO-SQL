<!-- Insert movies, actors, ... -->

<?php
require_once 'app/DAO.php';


class InsertController
{
    public function InsertMovie() {
        $dao = new DAO();

        if(isset($_POST['submit'])) {
            $movieTitle = filter_input(INPUT_POST, "movieTitle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $movieReleaseFilm = filter_input(INPUT_POST, "movieReleaseFilm", FILTER_SANITIZE_NUMBER_INT);
            $movieDuration = filter_input(INPUT_POST, "movieDuration", FILTER_SANITIZE_NUMBER_INT);
            $movieSynopsys = filter_input(INPUT_POST, "movieSynopsys", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $movieDirector = $_POST['movieDirector'];
            $movieGenre = $_POST['movieGenre'];
        }

        if(!empty($movieTitle) && !empty($movieReleaseFilm) && !empty($movieDuration) && !empty($movieSynopsys) && !empty($movieGrade) && !empty($moviePoster) && !empty($movieDirector)) {
            // Insert movie details
            $sqlAddMovie = 'INSERT INTO movie (title, release_film, duration, synopsys, grade, poster, id-director)
            VALUES (:title, :release_film, :duration, :synopsys, :grade, :poster, :id-director)';

            // We execute the query and stock it in an associative array
            // Stock the information about the film
            $insertMovie = $dao->executeRequest($sqlAddMovie, [':title'=>$movieTitle, 
            ':release_film'=>$movieReleaseFilm, 
            ':duration'=>$movieDuration, 
            ':synopsys'=>$movieSynopsys, 
            ':grade'$movieGrade, 
            ':poster'$movieGrade, 
            ':id-director'=>$movieDirector]);

        }
        
        // Allows us to reload the page after the submit
        $this->insertMovieForm();
    }


}


?>