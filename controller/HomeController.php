<!-- Page d'accueil -->

<?php
require_once 'app/DAO.php';

class HomeController
{
    // function permettant d'afficher les 5 films les plus récents ainsi que les 5 films les mieux notés
    public function homePage()
    {
        $dao = new DAO();

        $sql = "SELECT m.id_movie, m.title, DATE_FORMAT(m.release_film, '%Y') AS releaseYear, TIME_FORMAT(SEC_TO_TIME(m.duration*60),'%H:%i') AS durationMin, m.grade, m.poster 
        FROM movie m
        ORDER BY m.release_film DESC
        LIMIT 5";

        $sql2 = "SELECT m.id_movie, m.title, DATE_FORMAT(m.release_film, '%Y') AS releaseYear, TIME_FORMAT(SEC_TO_TIME(m.duration*60),'%H:%i') AS durationMin, m.grade, m.poster
        FROM movie m
        ORDER BY m.grade DESC
        LIMIT 5";

        $films = $dao->executeRequest($sql);
        $notes = $dao->executeRequest($sql2);
        require 'view/home/home.php';
    }
}
