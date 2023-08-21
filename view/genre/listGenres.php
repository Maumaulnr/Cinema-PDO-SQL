<?php
// require_once 'app/DAO.php';

ob_start(); // Enclenche la temporisation de sortie
?>
<p>listGenders</p>

    <div class="">
        <h1>List of Genres</h1>

        <!-- Si il y a plus d'un genre alors on ajoute un "s" sinon rien -->
        <p>Il existe <?= $genreCount ?> genre<?= $genreCount > 1 ? "s" : "" ?>. </p>

        <ul class="">
            <?php while ($genre = $genres->fetch()) { ?>
                <li><a href="index.php?action=genreDetails&id=<?= $genre['id_genre']; ?>"><?= $genre['label']; ?></a></li>
            <?php } ?>
        </ul>
        
        <a href="index.php?action=addGenreForm">
            <button>Ajouter Genre</button>
        </a>

    </div>

<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>
