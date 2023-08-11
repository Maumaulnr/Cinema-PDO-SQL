<?php
ob_start(); // Enclenche la temporisation de sortie
?>
<p>detailsGenre</p>
<div class="">
    <div class="">
        <h1>Genre Details</h1>

        <h2>Films in this Genre</h2>

        <ul class="">
            <?php while ($movie = $movies->fetch()) { ?>
                <li><a href="index.php?action=detailsMovie&id=<?= $movie['id_movie']; ?>"><?= $movie['title']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php
$title = "Genre Details";
$content = ob_get_clean();
require "view/template.php";
?>
