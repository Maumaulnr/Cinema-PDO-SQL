<!-- Appelle les contrôleurs -->

<?php
require_once "controller/HomeController.php";

require_once "controller/FilmController.php";

// Appel de la fonction autoload pour charger automatiquement tout les controllers crées
spl_autoload_register(function ($class_name) {
    require_once 'controller/' .$class_name. '.php';
});

// Vriable declaration

$ctrlHome = new HomeController();
$ctrlFilm = new FilmController();

if (isset($_GET['action'])) {

    switch ($_GET['action']) {
        //insert here all the request to generate new page
        
    }
}