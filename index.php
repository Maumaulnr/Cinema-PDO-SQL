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

$ctrlFilm = new FilmController();
$ctrlHome = new HomeController();
$ctrlGenre = new GenreController();
$ctrlPerson = new PersonController();
$ctrlRole = new RoleController();

// protection of injection in URL
// $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

// si on reçoit une action (en GET)
if (isset($_GET['action'])) {
    // En fonction de l'action reçue
    switch ($_GET['action']) {
            //insert here all the request to generate new page
            
        // LIST
        case "listMovies":
            $ctrlFilm->listMovies();
            break;

        
        case "listActors":
            $ctrlFilm->listActors();
            break;

        case "listGenres":
            $ctrlGenre->listGenres();
            break;

        // case "listRoles":
        //     $ctrlRole->listRoles();
        //     break;

        // case "listDirectors":
        //     $ctrlPerson->listDirectors();
        
        // DETAIL
        case "detailsMovie":
            $ctrlFilm->detailsMovie($id);
            break;

        case "detailsGenre":
            $ctrlGenre->detailsGenre($id);
            break;
        
        case "detailsActor":
            $ctrlPerson->detailsActor($id);
            break;

        case "filmsActor":
            $ctrlPerson->filmsActor($id);
            break;
        
        
        // ADD
        case "insertMovieForm":
            $ctrlFilm->insertMovieForm();
            break;
        case "insertMovie":
            $ctrlFilm->insertMovie();
            break;

        case "addGenreForm":
            $ctrlGenre->addGenreForm();
            break;

        case "addGenre":
            $ctrlGenre->addGenre();
            break;

        case "addActorForm":
            $ctrlPerson->addActorForm();
            break;

        case "addActor":
            $ctrlPerson->addActor();
            break;

        case "addDirectorForm":
            $ctrlPerson->addDirectorForm();
            break;

        case "addDirector":
            $ctrlPerson->addDirector();
            break;

        // UPDATE
        case "updateActor":
            $ctrlPerson->updateActor($id);
            break;
        
        // DELETE
        case "deleteGenreForm":
            $ctrlGenre->delGenre();
            break;

        // DEFAULT
        default:
            $ctrlHome->homePage();
            break;
       
    }
} else {
    //Si l'url de contient pas d'action enregistrer, ont fait appel au constructeur homepage, pour afficher la page d'acceuil par défaut
    $ctrlHome->homePage();
}

?>