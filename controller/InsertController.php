<!-- Insert movies, actors, ... -->

<?php
require_once 'app/DAO.php';


class InsertController
{
    

    // Insert Role
    public function insertRole() {
        $dao = new DAO();

        if(isset($_POST['submit'])) {
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPACIAL_CHARS);

            if(!empty($role)) {
                $sqlInsertRole = 'INSERT INTO role (role) VALUES (:role)';
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
        $sqlRoles = "SELECT id_role, name_role FROM role";
        $roles = $dao->executeRequest($sqlRoles);

        // Select an actor
        $sqlActors = "SELECT a.id_actor, p.firstname, p.lastname 
                            FROM actor 
                            INNER JOIN person p 
                            ON a.id_person = p.id_person; ";
        $actors = $dao->executeRequest($sqlActors);

        // Select a movie
        $sqlMovies = "SELECT m.id_movie, m.title FROM movie";
        $movies = $dao->executeRequest($sqlMovies);

        require "view/insert/insertCastingForm.php";
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
        // Reload the page after submit
        $this->insertCastingForm();
    }

}


?>