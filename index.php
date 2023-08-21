<!-- Appelle les contrôleurs -->
<p>index page</p>

<?php

require_once "controller/FilmController.php";

require_once "controller/HomeController.php";

require_once "controller/InsertController.php";

require_once "controller/DeleteController.php";


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
$ctrDelete = new DeleteController();

// protection of injection in URL
// $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

// Verify if there's an action & what to do next
if (isset($_GET['action'])) {
    // Choosing the next step based on each specific action
    switch ($_GET['action']) {
            //insert here all the request to generate new page
        case "listMovies":
            $ctrFilm->listMovies();
            break;
        // default:
        //     $ctrHome->HomePage();
        

        // LIST
        case "listGenres":
            $ctrFilm->listGenres();
        
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
            $ctrFilm->detailsGenre($id);
            break;
        
        
        // ADD
        case "insertMovieForm":
            $ctrInsert->insertMovieForm();
            break;
        case "insertMovie":
            $ctrInsert->insertMovie();
            break;
        // default:
        //     $ctrHome->HomePage();

        // UPDATE

        // DEFAULT
       
    }
} else {
    //Si l'url de contient pas d'action enregistrer, ont fait appel au constructeur homepage, pour afficher la page d'acceuil par défaut
    $ctrHome->homePage();
}

?>