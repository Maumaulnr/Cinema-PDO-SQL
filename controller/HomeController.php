<!-- Page d'accueil -->

<?php
// require_once 'app/DAO.php';

class HomeController
{
    // function permettant d'affciher les 5 films les plus récents ainsi que les 5 films les mieux notés
    public function homePage() {
        $dao = new DAO();

        $sql = "SELECT id_film, title, DATE_FORMAT(film_release, '%Y') filmRelease, TIME_FORMAT(SEC_TO_TIME(duration*60), '%H:%i) duration, note, picture
        FROM movie
        ORDER BY film_release DESC
        LIMIT 5";

        $films = $dao->executeRequest($sql);

        require 'view/home/home.php';
    }
}