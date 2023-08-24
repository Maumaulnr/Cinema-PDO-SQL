<?php
require_once 'app/DAO.php';


class PersonController
{
    // LIST ACTORS
    public function listActors() {
        $dao = new DAO();

        $sqlListActors = "SELECT a.id_actor, p.lastname, p.firstname
                        FROM actor a
                        INNER JOIN person p ON a.person_id = p.id_person
                        ORDER BY p.lastname ASC;";
        
        $actors = $dao->executeRequest($sqlListActors);

        require "view/actor/listActors.php";
    }

    // DETAILS ACTOR
    public function detailsActor($id) {
        $dao = new DAO();

        $sqlDetailsActor = "SELECT p.id_person, a.id_actor, p.firstname, p.lastname, p.gender_person, DATE_FORMAT(p.birth_date,'%d-%m-%Y') AS birth_date
                            FROM actor a
                            INNER JOIN person p ON a.person_id = p.id_person
                            WHERE a.id_actor = :actor_id
                            ORDER BY p.firstname ASC;";

        $paramsActor = [':actor_id' => $id];                   
        
        $actors = $dao->executeRequest($sqlDetailsActor, $paramsActor);

        require "view/actor/detailsActor.php";
    }

    // ACTOR'S FILMS
    public function filmsActor($id) {
        $dao = new DAO();

        $sqlFilmsActor = "SELECT  m.title, r.name_role
                        FROM casting c
                        INNER JOIN actor a ON c.actor_id = a.id_actor
                        INNER JOIN role r ON c.role_id = r.id_role
                        INNER JOIN movie m ON c.movie_id = m.id_movie
                        WHERE c.actor_id = :id_actor;";

        $paramsFilmsActor = [':id_actor' => $id];

        $filmsActor = $dao->executeRequest($sqlFilmsActor, $paramsFilmsActor);

        require "view/actor/filmsActor.php";
    }

    // UPDATE ACTOR
    public function updateActor() {
        $dao = new DAO();

        $actorIdPerson = filter_input(INPUT_POST, "id_person", FILTER_SANITIZE_NUMBER_INT);;
        $actorFirstname = filter_input(INPUT_POST, "actorFirstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorLastname = filter_input(INPUT_POST, "actorLastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorGenderPerson = filter_input(INPUT_POST, "actorGenderPerson", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorBirthDate = filter_input(INPUT_POST, "actorBirthDate", FILTER_SANITIZE_NUMBER_INT);

        $sqlUpdateActor = "UPDATE person p
                        SET actorFirstname = '" .$actorFirstname. "', actorLastname = '" .$actorLastname. "', actorGenderPerson = '" .$actorGenderPerson. "', actorBirthDate = '" .$actorBirthDate. "'
                        WHERE p.id_person = ". $actorIdPerson;

       $actorUpdate = $dao->executeRequest($sqlUpdateActor);

       require "view/actor/updateActor.php";
    }

    // ADD ACTOR
    public function addActorForm() {
        require 'view/actor/addActorForm.php';
    }

    public function addActor() {

        // filtrer ce qui arrive en POST
        // "actorLastname" : vient du name="actorLastname" du fichier addActorForm.php
        $actorLastname = filter_input(INPUT_POST, "actorLastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorFirstname = filter_input(INPUT_POST, "actorFirstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorGenderPerson = filter_input(INPUT_POST, "actorGenderPerson", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorBirthDate = filter_input(INPUT_POST, "actorBirthDate", FILTER_SANITIZE_NUMBER_INT);

        $insertPersonId = filter_input(INPUT_POST, "insertPersonId", FILTER_SANITIZE_NUMBER_INT);

        // vars
        $isAddPersonActorSuccess = false;
        $isAddActorSuccess = false;
        $globalMessage = "L'enregistrement a bien été effectué";
        $formValues = null;

        // validation des règles du formulaire
        $isFormValid = true;
        $errorMessages = [];

        // actorLastname, ... sont obligatoire
        // si actorLastname, ... sont vide
        if($actorLastname && $actorFirstname && $actorGenderPerson && $actorBirthDate == "") {
            $isFormValid = false;
            $errorMessages["actorLastname"] = "Ce champ est obligatoire";
            $errorMessages["actorFirstname"] = "Ce champ est obligatoire";
            $errorMessages["actorGenderPerson"] = "Ce champ est obligatoire";
            $errorMessages["actorBirthDate"] = "Ce champ est obligatoire";
        }

        // actorLastname && actorFirstname ne doivent pas dépasser 30 caractères
        if(strlen($actorLastname && $actorFirstname) > 30) {
            $isFormValid = false;
            $errorMessages["actorLastname"] = "Ce champ est limité à 30 caractères";
            $errorMessages["actorFirstname"] = "Ce champ est limité à 30 caractères";
        }

        // si les règles de validation du formulaire sont respectées
        if ($isFormValid) {

            // ajout du genre dans la BDD

            $dao = new DAO();

            // respecter l'ordre dans la BDD si pas de parenthèses avant le VALUES
            $sqlPersonActor = "INSERT INTO person(lastname, firstname, gender_person, birth_date)
                                VALUES (:lastname, :firstname, :gender_person, :birth_date)
                                ;";

            $sqlInsertActor = "INSERT INTO actor(person_id)
                                VALUES (:person_id)
                                ;";

            // "actorLastname", ... doivent être identique à :actorLastname, ...
            $personActorParams = [
                "actorLastname" => $actorLastname,
                "actorFirstname" => $actorFirstname,
                "actorGenderPerson" => $actorGenderPerson,
                "actorBirthDate" => $actorBirthDate
            ];

            $insertActorParams = [
                "person_id" => $insertPersonId
            ];

            // On met dans le try (on essaie) les lignes qui ont une chance plus élevée de lever (throw) une exception/erreur
            try {
                $isAddPersonActorSuccess = $dao->executeRequest($sqlPersonActor, $personActorParams);
                $isAddActorSuccess = $dao->executeRequest($sqlInsertActor, $insertActorParams);

                if (!$isAddPersonActorSuccess && !$isAddActorSuccess) {
                    $globalMessage = "L'enregistrement a échoué";
                }
            } catch (\Throwable $error) {
                // si une exception/erreur est levée (thrown), alors on l'attrape (catch) et on la gère manuellement
                $isAddPersonActorSuccess = false;
                $isAddActorSuccess = false;
                $globalMessage = "L'enregistrement a échoué suite à une erreur technique";

                // var_dump($error);
                // die();
            }
        } else {
            // le formulaire est invalide

            $globalMessage = "Le formulaire est invalide";

            $formValues = [
                "actorLastname" => $actorLastname,
                "actorFirstname" => $actorFirstname,
                "actorGenderPerson" => $actorGenderPerson,
                "actorBirthDate" => $actorBirthDate
            ];
        }

        require "view/actor/addActorForm.php";
    }


    // CASTING FORMULAIRE
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

    // DIRECTOR
    public function addDirectorForm() {
        require 'view/director/addDirectorForm.php';
    }

    public function addDirector() {

    }

    // ROLE

}


?>