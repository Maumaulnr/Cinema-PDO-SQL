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

if (isset($_GET['action'])) {

    switch ($_GET['action']) {
            //insert here all the request to generate new page
        case "listMovies":
            $ctrFilm->listMovies();
            break;
        case "detailsMovie":
            $movieId = $_GET['movieId'];
            $ctrFilm->detailsMovie($movieId);
            break;
       
    }
} else {
    //Si l'url de contient pas d'action enregistrer, ont fait appel au constructeur homepage, pour afficher la page d'acceuil par défaut
    $ctrHome->homePage();
}

?>