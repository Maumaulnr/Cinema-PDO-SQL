<?php
require_once 'app/DAO.php';

// $dao = new DAO();
// $genres = $dao->executeRequest("SELECT * FROM Genre");

ob_start(); // Enclenche la temporisation de sortie
?>
<p>listGenders</p>
<div class="uk-section uk-section-secondary">
    <div class="uk-container">
        <h1>List of Genres</h1>

        <ul class="uk-list uk-list-divider">
            <?php while ($genre = $genres->fetch()) { ?>
                <li><a href="index.php?action=genreDetails&id=<?= $genre['id_genre']; ?>"><?= $genre['label']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>
