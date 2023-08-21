<!-- Genre Controller -->

<?php
require_once 'app/DAO.php';


class GenreController
{
    // Affiche les films associés à un genre spécifique
    public function genreDetails($id)
    {
        $dao = new DAO();

        if (isset($_GET['id'])) {
            $genreId = $_GET['id'];

            // Récupérer les films associés à ce genre
            $sqlGenre = "SELECT m.id_movie, m.title, m.poster, g.label
            FROM movie m
            INNER JOIN movie_genre_link mgl ON m.id_movie = mgl.movie_id
            INNER JOIN genre g ON mgl.genre_id = g.id_genre
            WHERE mgl.genre_id = :genre_id;";

            $paramsGenre = [':genre_id' => $id];
            $detailsGenre = $dao->executeRequest($sqlGenre, $paramsGenre);

            // $genres = $dao->executeRequest("SELECT * FROM Genre");

            require 'view/genre/detailsGenre.php';
        }
    }

    // ADD GENRE MOVIE
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
            $sqlGenre = "INSERT INTO genre (label)
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
                $globalMessage = "L'enregistrement a échoué suite à une erreur technique";
            }
            $isAddGenreSuccess = $dao->executeRequest($sqlGenre, $genreParams);

            if (!$isAddGenreSuccess) {
                $globalMessage = "L'enregistrement a échoué";
            }
        } else {
            // le formulaire est invalide

            $globalMessage = "Le formulaire est invalide";

            $formValues = [
                "label" => $label
            ];
        }

        require "view/genre/addGenreForm.php";
    }
}


?>