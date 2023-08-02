<!-- Appelle les contrôleurs -->

<?php

require_once "controller/FilmController.php";

require_once "controller/HomeController.php";


// Appel de la function autoload pour charger automatiquement tout les controllers crées
spl_autoload_register(function ($class_name) {
    require_once 'controller/' . $class_name . '.php';
});

// variable declaration

$ctrFilm = new FilmController();
$ctrHome = new HomeController();

// protection of injection in URL
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Verify if there's an action & what to do next
if (isset($_GET['action'])) {
    // Choosing the next step based on each specific action
    switch ($_GET['action']) {
            //insert here all the request to generate new page
        case "listMovies":
            $ctrFilm->listMovies();
            break;
        case "detailsMovie":
            // $movieId = $_GET['movie_id'];
            $ctrFilm->detailsMovie($id);
            break;
       
    }
} else {
    //Si l'url de contient pas d'action enregistrer, ont fait appel au constructeur homepage, pour afficher la page d'acceuil par défaut
    $ctrHome->homePage();
}

?>