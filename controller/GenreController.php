<!-- Genre Controller -->

<?php
require_once 'app/DAO.php';


class GenreController
{
    // LIST GENRES
    public function listGenres($isGenreDeletedSuccessfully = null) {
        $dao = new DAO();

        $sqlListGenres = "SELECT g.id_genre, g.label
                        FROM genre g
                        ORDER BY label ASC;";
        
        $genresList = $dao->executeRequest($sqlListGenres);

        require "view/genre/listGenres.php";
    }

    public function getGenreById($id) {
        $dao = new DAO();

        // Récupérer les films associés à ce genre
        $sqlGenre = "SELECT g.id_genre, g.label
                        FROM genre g
                        WHERE g.id_genre = :id_genre;";

        $paramsGenre = ['id_genre' => $id];

        $genre = $dao->executeRequest($sqlGenre, $paramsGenre);

        return $genre->fetch();
    }

    // Affiche les films associés à un genre spécifique
    public function detailsGenre($id)
    {
        $genre = $this->getGenreById($id);

        $dao = new DAO();

        $sqlMovies = "SELECT mgl.genre_id, m.title
        FROM movie m
        INNER JOIN movie_genre_link mgl ON m.id_movie = mgl.movie_id
        INNER JOIN genre g ON mgl.genre_id = g.id_genre
        WHERE mgl.genre_id = :genre_id;";

        $paramsGenre = [':genre_id' => $id];

        $movies = $dao->executeRequest($sqlMovies, $paramsGenre);

        require 'view/genre/detailsGenre.php';

    }

    // ADD GENRE MOVIE
    public function addGenreForm() {
        require 'view/genre/addGenreForm.php';
    }

    public function addGenre() {

        // filtrer ce qui arrive en POST
        // "label" : vient du name="label" du fichier addGenreForm.php
        $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // vars
        $isAddGenreSuccess = false;
        $globalMessage = "L'enregistrement a bien été effectué";
        $formValues = null;

        // validation des règles du formulaire
        $isFormValid = true;
        $errorMessages = [];

        // label est obligatoire
        // si label est vide
        if($label == "") {
            $isFormValid = false;
            $errorMessages["label"] = "Ce champ est obligatoire";
        }

        // label ne doit pas dépasser 30 caractères
        if(strlen($label) > 30) {
            $isFormValid = false;
            $errorMessages["label"] = "Ce champ est limité à 30 caractères";
        }

        // si les règles de validation du formulaire sont respectées
        if ($isFormValid) {

            // ajout du genre dans la BDD

            $dao = new DAO();

            // (id_genre, label) : respecter l'ordre dans la BDD si pas de parenthèses avant le VALUES
            $sqlGenre = "INSERT INTO Genre (label)
                VALUES (:label)
            ;";

            // "label" doit être identique à :label
            $genreParams = [
                "label" => $label
            ];

            // On met dans le try (on essaie) les lignes qui ont une chance plus élevée de lever (throw) une exception/erreur
            try {
                $isAddGenreSuccess = $dao->executeRequest($sqlGenre, $genreParams);

                if (!$isAddGenreSuccess) {
                    $globalMessage = "L'enregistrement a échoué";
                }
            } catch (\Throwable $error) {
                // si une exception/erreur est levée (thrown), alors on l'attrape (catch) et on la gère manuellement
                $isAddGenreSuccess = false;
                $globalMessage = "This genre already exists.";
            }
        } else {
            // le formulaire est invalide

            $globalMessage = "Le formulaire est invalide";

            $formValues = [
                "label" => $label
            ];
        }

        require 'view/genre/addGenreForm.php';
    }

    // UPDATE GENRE
    public function updateGenreForm($id) {
        $formValues = $this->getGenreById($id);

        require 'view/genre/updateGenreForm.php';
    }

    public function updateGenre($id) {

        // filtrer ce qui arrive en POST
        // "label" : vient du name="label" du fichier addGenreForm.php
        $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // vars
        $isUpdateGenreSuccess = false;
        $globalMessage = "L'enregistrement a bien été effectué";
        $formValues = null;

        // validation des règles du formulaire
        $isFormValid = true;
        $errorMessages = [];

        // label est obligatoire
        // si label est vide
        if($label == "") {
            $isFormValid = false;
            $errorMessages["label"] = "Ce champ est obligatoire";
        }

        // label ne doit pas dépasser 30 caractères
        if(strlen($label) > 30) {
            $isFormValid = false;
            $errorMessages["label"] = "Ce champ est limité à 30 caractères";
        }

        // si les règles de validation du formulaire sont respectées
        if ($isFormValid) {

            // ajout du genre dans la BDD

            $dao = new DAO();

            // (id_genre, label) : respecter l'ordre dans la BDD si pas de parenthèses avant le VALUES
            $sqlGenre = "UPDATE Genre
                SET label = :newLabel
                WHERE id_genre = :id_genre
            ;";

            // "newLabel" doit être identique à :newLabel
            $genreParams = [
                "id_genre" => $id,
                "newLabel" => $label
            ];

            // On met dans le try (on essaie) les lignes qui ont une chance plus élevée de lever (throw) une exception/erreur
            try {
                $isUpdateGenreSuccess = $dao->executeRequest($sqlGenre, $genreParams);

                if (!$isUpdateGenreSuccess) {
                    $globalMessage = "L'enregistrement a échoué";
                }
            } catch (\Throwable $error) {
                // si une exception/erreur est levée (thrown), alors on l'attrape (catch) et on la gère manuellement
                $isUpdateGenreSuccess = false;
                $globalMessage = "This genre already exists."; // attention une exception peut arriver à cause d'une autre raison
            }
        } else {
            // le formulaire est invalide

            $isUpdateGenreSuccess = false;
            $globalMessage = "Le formulaire est invalide";
        }

        // si la mise à jour est un succès
        if ($isUpdateGenreSuccess) {
            $this->detailsGenre($id); // le require est inclus dans la méthode

        } else {
            // sinon peu importe pourquoi

            $formValues = [
                "label" => $label
            ];

            require 'view/genre/updateGenreForm.php';
        }
    }

    // DELETE GENRE LABEL
    public function deleteGenreForm() {
        $dao = new DAO();

        $sqlOptionGenre = "SELECT g.id_genre, g.label
                        FROM genre g
                        ORDER BY label ASC;";
        
        $deleteGenre = $dao->executeRequest($sqlOptionGenre);

        require 'view/genre/deleteGenreForm.php';
    }

    // DELETE Genre
    public function deleteGenre($id) {

        // $idGenre = filter_input(INPUT_POST, "id_genre", FILTER_SANITIZE_NUMBER_INT);

        $dao = new DAO();

        // choisir un label pour le supprimer par la suite
        $sqlDeleteGenre = "DELETE FROM genre
                        WHERE id_genre = :id_genre;";

        $paramsIdGenre = ['id_genre' => $id];
        
        $isGenreDeletedSuccessfully = $dao->executeRequest($sqlDeleteGenre, $paramsIdGenre);

        $this->listGenres($isGenreDeletedSuccessfully); // on peut profiter du get BDD + require vue (sinon aurait dû se préoccuper des 2 parties séparément)
    }
}


?>