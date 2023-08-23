<!-- Appelle les contrôleurs -->

<?php

require_once "controller/FilmController.php";

require_once "controller/HomeController.php";

require_once "controller/GenreController.php";

require_once "controller/PersonController.php";

require_once "controller/RoleController.php";


// Appel de la function autoload pour charger automatiquement tout les controllers crées
spl_autoload_register(function ($class_name) {
    require_once 'controller/' . $class_name . '.php';
});

// variable declaration

$ctrFilm = new FilmController();
$ctrHome = new HomeController();
$ctrGenre = new GenreController();
$ctrPerson = new PersonController();
$ctrRole = new RoleController();

// protection of injection in URL
// $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

// Verify if there's an action & what to do next
if (isset($_GET['action'])) {
    // Choosing the next step based on each specific action
    switch ($_GET['action']) {
            //insert here all the request to generate new page
            
        // LIST
        case "listMovies":
            $ctrFilm->listMovies();
            break;

        
        case "listActors":
            $ctrFilm->listActors();
            break;

        case "listGenres":
            $ctrGenre->listGenres();
            break;

        case "listRoles":
            $ctrRoles->listRoles();
            break;

        case "listDirectors":
            $ctrPerson->listDirectors();
        
        // DETAIL
        case "detailsMovie":
            $ctrFilm->detailsMovie($id);
            break;

        case "detailsGenre":
            $ctrGenre->detailsGenre($id);
            break;
        
        case "detailsActor":
            $ctrPerson->detailsActor($id);
            break;
        
        
        // ADD
        case "insertMovieForm":
            $ctrFilm->insertMovieForm();
            break;
        case "insertMovie":
            $ctrFilm->insertMovie();
            break;

        case "addGenreForm":
            $ctrGenre->addGenreForm();
            break;

        case "addActorForm":
            $ctrPerson->addActorForm();
            break;

        // UPDATE

        // DEFAULT
        default:
            $ctrHome->homePage();
            break;
       
    }
} else {
    //Si l'url de contient pas d'action enregistrer, ont fait appel au constructeur homepage, pour afficher la page d'acceuil par défaut
    $ctrHome->homePage();
}

?>