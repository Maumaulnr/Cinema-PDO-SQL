<?php
require_once 'app/DAO.php';


class PersonController
{
    // LIST ACTORS
    public function listActors() {
        $dao = new DAO();

        $sqlListActors = "SELECT a.id_actor, p.firstname AS firstnameActor, p.lastname AS lastnameActor
                        FROM actor a
                        INNER JOIN person p ON a.person_id = p.id_person
                        ORDER BY firstnameActor ASC;";
        
        $actors = $dao->executeRequest($sqlListActors);

        require "view/actor/listActors.php";
    }

    // Récupre les infos en bdd et return (récupère tableau associatif)
    public function getPersonById($id) {
        $dao = new DAO();

        // Récupérer les infos de l'acteur via la table Person
        $sqlPersonActor = "SELECT a.person_id, a.id_actor, p.firstname, p.lastname, p.gender_person, DATE_FORMAT(p.birth_date,'%d-%m-%Y') AS birth_date
                            FROM actor a
                            INNER JOIN person p ON a.person_id = p.id_person
                            WHERE a.id_actor = :id_actor
                            ORDER BY p.firstname ASC;";

        $paramsPersonActor = [':id_actor' => $id];                   
        
        $personActor = $dao->executeRequest($sqlPersonActor, $paramsPersonActor);

        return $personActor->fetch();
    }

    // DETAILS ACTOR
    public function detailsActor($id) {
        $personActor = $this->getPersonById($id);

        $dao = new DAO();

        // $sqlDetailsActor = "SELECT p.id_person, a.id_actor, p.firstname, p.lastname, p.gender_person, DATE_FORMAT(p.birth_date,'%d-%m-%Y') AS birth_date
        //                     FROM actor a
        //                     INNER JOIN person p ON a.person_id = p.id_person
        //                     WHERE a.id_actor = :actor_id
        //                     ORDER BY p.firstname ASC;";

        // $paramsActor = [':actor_id' => $id];                   
        
        // $actors = $dao->executeRequest($sqlDetailsActor, $paramsActor);

        // Nouvelle requête pour ajouter les films et les rôles de l'acteur
        $sqlCastingActor = "SELECT  m.title, r.name_role
                        FROM casting c
                        INNER JOIN actor a ON c.actor_id = a.id_actor
                        INNER JOIN role r ON c.role_id = r.id_role
                        INNER JOIN movie m ON c.movie_id = m.id_movie
                        WHERE c.actor_id = :actor_id;";

        $paramsCastingActor = [':actor_id' => $id];

        $castingActor = $dao->executeRequest($sqlCastingActor, $paramsCastingActor);

        require "view/actor/detailsActor.php";
    }

    // // ACTOR'S FILMS
    // public function filmsActor($id) {
    //     $dao = new DAO();

    //     $sqlFilmsActor = "SELECT  m.title, r.name_role
    //                     FROM casting c
    //                     INNER JOIN actor a ON c.actor_id = a.id_actor
    //                     INNER JOIN role r ON c.role_id = r.id_role
    //                     INNER JOIN movie m ON c.movie_id = m.id_movie
    //                     WHERE c.actor_id = :id_actor;";

    //     $paramsFilmsActor = [':id_actor' => $id];

    //     $filmsActor = $dao->executeRequest($sqlFilmsActor, $paramsFilmsActor);

    //     require "view/actor/filmsActor.php";
    // }

    // ADD ACTOR
    public function addActorForm() {
        require 'view/actor/addActorForm.php';
    }

    public function addActor() {

        // filtrer ce qui arrive en POST
        // "actorLastname" : vient du name="actorLastname" du fichier addActorForm.php
        $actorPersonId = filter_input(INPUT_POST, "actorBirthDate", FILTER_SANITIZE_NUMBER_INT);
        $actorFirstname = filter_input(INPUT_POST, "actorFirstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorLastname = filter_input(INPUT_POST, "actorLastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorGenderPerson = filter_input(INPUT_POST, "actorGenderPerson", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorBirthDate = filter_input(INPUT_POST, "actorBirthDate", FILTER_SANITIZE_NUMBER_INT, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Formatage de la date pour qu'elle corresponde au format de date SQL
        // $formatBirthDate = date('Y-m-d', strtotime($actorBirthDate));

        $actorIdActor = filter_input(INPUT_POST, "actorBirthDate", FILTER_SANITIZE_NUMBER_INT);

        // vars
        $isAddPersonSuccess = false;
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
            $errorMessages["actorFirstname"] = "Ce champ est obligatoire";
            $errorMessages["actorLastname"] = "Ce champ est obligatoire";
            $errorMessages["actorGenderPerson"] = "Ce champ est obligatoire";
            $errorMessages["actorBirthDate"] = "Ce champ est obligatoire";
        }

        // actorLastname && actorFirstname ne doivent pas dépasser 30 caractères
        if(strlen($actorFirstname && $actorLastname) > 30) {
            $isFormValid = false;
            $errorMessages["actorFirstname"] = "Ce champ est limité à 30 caractères";
            $errorMessages["actorLastname"] = "Ce champ est limité à 30 caractères";
        }

        // si les règles de validation du formulaire sont respectées
        if ($isFormValid) {

            // ajout du genre dans la BDD

            $dao = new DAO();

            // respecter l'ordre dans la BDD si pas de parenthèses avant le VALUES
            $sqlPerson = "INSERT INTO person(firstname, lastname, gender_person, birth_date)
                        VALUES (:firstname, :lastname, :gender_person, :birth_date)
                        ;";

            // "actorLastname", ... doivent être identique à :actorLastname, ...
            $personParams = [
                "firstname" => $actorFirstname,
                "lastname" => $actorLastname,
                "gender_person" => $actorGenderPerson,
                "birth_date" => $actorBirthDate
            ];

            // On met dans le try (on essaie) les lignes qui ont une chance plus élevée de lever (throw) une exception/erreur
            try {
                $isAddPersonSuccess = $dao->executeRequest($sqlPerson, $personParams);

                if ($isAddPersonSuccess) {
                    // Récupération de l'ID de la personne ajoutée
                    $personId = $dao->getBDD()->lastInsertId();

                    $sqlActor = "INSERT INTO actor(person_id)
                                VALUES (:person_id);";

                    // Utilisation de l'ID de la personne pour ajouter l'acteur dans la table Actor
                    $actorParams = [
                        "person_id" => $personId
                    ];

                    $isAddActorSuccess = $dao->executeRequest($sqlActor, $actorParams);
                }

                // && !$isAddActorSuccess
                if (!$isAddPersonSuccess && !$isAddActorSuccess) {
                    $globalMessage = "L'enregistrement a échoué";
                }
            } catch (\Throwable $error) {
                // si une exception/erreur est levée (thrown), alors on l'attrape (catch) et on la gère manuellement
                $isAddPersonSuccess = false;
                $isAddActorSuccess = false;
                $globalMessage = "This actor already exists!";

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

    // UPDATE ACTOR
    public function updateActorForm() {
        
        // $formValues = $this->getPersonById($id);

        require 'view/actor/updateActorForm.php';
    }

    public function updateActor($id) {
        $dao = new DAO();

        $actorIdPerson = filter_input(INPUT_POST, "id_person", FILTER_VALIDATE_INT);
        $actorFirstname = filter_input(INPUT_POST, "actorFirstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorLastname = filter_input(INPUT_POST, "actorLastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorGenderPerson = filter_input(INPUT_POST, "actorGenderPerson", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $actorBirthDate = filter_input(INPUT_POST, "actorBirthDate", FILTER_SANITIZE_NUMBER_INT);

        $sqlUpdateActor = "UPDATE person p
                        SET actorFirstname = '" .$actorFirstname. "', actorLastname = '" .$actorLastname. "', actorGenderPerson = '" .$actorGenderPerson. "', actorBirthDate = '" .$actorBirthDate. "'
                        WHERE p.id_person = ". $actorIdPerson;

       $actorUpdate = $dao->executeRequest($sqlUpdateActor);

       require "view/actor/updateActorForm.php";
    }

    // DELETE ACTOR


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