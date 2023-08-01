<?php

ob_start(); //def : Enclenche la temporisation de sortie
?>

<?php
while ($movie = $movies->fetch()) { ?>

<div class="uk-section uk-section-secondary">
    <div class="uk-container">
        <h1><?= $movie['title'] ?></h1>
        <div class="uk-grid-match uk-flex-center" uk-grid>
            <div class="uk-width-auto">
                <img class="uk-border-rounded" src="./public/image/<?= $movie["poster"]; ?>" alt="picture of movie : <?= $movie["title"]; ?>" width="300">
            </div>
            <div class="uk-width-expand">
                <p><strong>Release Year:</strong> <?= $movie['release_film'] ?></p>
                <p><strong>Duration:</strong> <?= $movie['duration'] ?> minutes</p>
                <p><strong>Synopsis:</strong> <?= $movie['synopsys'] ?></p>
                <p><strong>Director:</strong> <?= $movie['name'] ?></p>
                <p><strong>Rating:</strong> <?= $movie['grade'] ?></p>
                <!-- Add more information here if needed -->
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php $content = ob_get_clean();
require "view/template.php";
?>