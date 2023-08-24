<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<!-- On veut les détails du genre donc tous les films qui se rapporte à un genre -->

<div class="details-genre">

    <?php $genre = $GenreLabel->fetch() ?>
    <h2>Film's Genre : <strong><?= $genre['label']; ?></strong></h2>

    <div>
        
        
    </div>

    <!-- On veut seulement le titre du film -->
    
        <p></p>

    <ul>
    Movies :
        <?php while ($movie = $detailsGenre->fetch()) { ?>
            <li><?= $movie['title'] ?></li>
        <?php } ?>
    </ul>


    <a href="index.php?action=listGenres">Return</a>
</div>


<?php
$title = "Genre Details";
$content = ob_get_clean();
require "view/template.php";
?>

