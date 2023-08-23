<?php
// require_once 'app/DAO.php';

ob_start(); // Enclenche la temporisation de sortie

// Calculate the number of genres.
$genresCount = $genres->rowCount();

?>

    <div class="list-genres">
        <h1>List Genres</h1>

        <!-- Si il y a plus d'un genre alors on ajoute un "s" sinon rien -->
        <p>Il existe <?= $genresCount ?> genre<?= $genresCount > 1 ? "s" : "" ?>.</p>

        <ul class="">
            <?php while ($genre = $genres->fetch()) { ?>
                <li><?= $genre["label"] ?></li>
                <li><a href="index.php?action=detailsGenre&id=<?= $genre['id_genre'] ?>"><?= $genre["label"] ?></a></li>
            <?php } ?>
        </ul>
        
        <a href="index.php?action=addGenreForm">
            <button>Add Genre</button>
        </a>

    </div>


<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>
