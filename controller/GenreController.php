<!-- Genre Controller -->

<?php
require_once 'app/DAO.php';


class GenreController
{
    // LIST GENRES
    public function listGenres() {
        $dao = new DAO();

        $sqlListGenres = "SELECT g.id_genre, g.label
                        FROM genre g
                        ORDER BY label ASC;";
        
        $genresList = $dao->executeRequest($sqlListGenres);

        require "view/genre/listGenres.php";
    }

    // Affiche les films associés à un genre spécifique
    public function detailsGenre($id)
    {
        $dao = new DAO();

            // Récupérer les films associés à ce genre
            $sqlGenreLabel = "SELECT g.label
                            FROM movie_genre_link mgl
                            INNER JOIN genre g ON mgl.genre_id = g.id_genre
                            WHERE mgl.genre_id = :genre_id;";

            $paramsDetailsGenre = [':genre_id' => $id];

            $GenreLabel = $dao->executeRequest($sqlGenreLabel, $paramsDetailsGenre);

            $sqlDetailsGenre = "SELECT mgl.genre_id, m.title
            FROM movie m
            INNER JOIN movie_genre_link mgl ON m.id_movie = mgl.movie_id
            INNER JOIN genre g ON mgl.genre_id = g.id_genre
            WHERE mgl.genre_id = :genre_id;";

            $detailsGenre = $dao->executeRequest($sqlDetailsGenre, $paramsDetailsGenre);

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

    // DELETE Genre
    public function delGenre() {
        $dao = new DAO();

        $sqlDeleteGenre = "";
    }
}


?>