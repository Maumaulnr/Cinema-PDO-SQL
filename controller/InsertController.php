<!-- Insert movies, actors, ... -->

<?php
require_once 'app/DAO.php';


class InsertController
{
    public function insertMovie() {
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
            ':grade'=>$movieGrade, 
            ':poster'=>$moviePoster, 
            ':id-director'=>$movieDirector]);

        }
        
        // Allows us to reload the page after the submit
        $this->insertMovieForm();
    }

    // Insert Role
    public function insertRole() {
        $dao = new DAO();

        if(isset($_POST['submit'])) {
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPACIAL_CHARS);

            if(!empty($role)) {
                $sqlInsertRole = 'INSERT INTO Role (role) VALUES (:role)';
                $insertRole = dao->executeRequest($sqlInsertRole, [':role' => $role]);

                if($insertRole) {
                    echo "Add Role";
                } else {
                    echo "Error";
                }
            }
        }
        // Reload the page after submit
        $this->insertRoleForm();
    }

    public function insertCastingForm() {
        $dao = new DAO();

        // Select Role
        $sqlInsertRole = "SELECT id_role, name_role FROM role";
        $roles = $dao->executeRequest($sqlInsertRole);

        // Select an actor
        $sqlInsertActor = "SELECT a.id_actor, p.firstname, p.lastname 
                            FROM actor 
                            INNER JOIN person p 
                            ON a.id_actor = p.id_person; ";
        $actor = $dao->executeRequest($sqlInsertActor);

        // Select a movie
        $sqlInsertMovie = "SELECT m.id_movie, m.title FROM movie";
        $movies = $dao->executeRequest($sqlInsertMovie);

        require "view/insert/insertCasting.php";
    }

    public function insertCasting() {
        $dao = new DAO();

        if(isset($_POST['submit'])) {
            // Stock the actor, movie and role
            $roleCasting = $_POST['roleCasting'];
            $actorCasting = $_POST['actorCasting'];
            $movieCasting = $_POST['movieCasting'];

            if(!empty($roleCasting) && !empty($actorCasting) && !empty($movieCasting)) {
                $sqlInsertCasting = 'INSERT INTO casting (movie_id, actor_id, role_id) VALUES (:movie_id, :actor_id, :role_id)';
                $insertCasting = $dao->executeRequest($sqlInsertCasting, [':movie_id' => $movieCasting,
                                                                            ':actor_id' => $actorCasting,
                                                                            ':role_id' => $roleCasting]);
                
                if($insertCasting) {
                    echo "Add Casting";
                } else {
                    echo "Error";
                }
            }
        }
        // Reload the page after the submit
        $this->insertCastingForm();
    }

}


?>