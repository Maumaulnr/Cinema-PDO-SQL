<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<!-- On veut les détails du genre donc tous les films qui se rapporte à un genre -->

<div class="details-genre">

    <h1>Film's Genre : <span class="span-label-background-color"><?= $genre['label']; ?></span></h1>

    <!-- On veut seulement le titre du film -->

    <ul class="ul-list-movies">
        <?php while ($movie = $movies->fetch()) { ?>
            <li><?= $movie['title'] ?></li>
        <?php } ?>
    </ul>

    <a href="index.php?action=listGenres" class="button-link">Return</a>

</div>


<?php
$title = "Genre Details";
$content = ob_get_clean();
require "view/template.php";
?>

