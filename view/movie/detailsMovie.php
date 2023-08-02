
<?php

ob_start(); //def : Enclenche la temporisation de sortie

$movie = $detailsMovie->fetch();
var_dump($detailsMovie);

?>

<div class="uk-section uk-section-secondary">
    <div class="uk-container">
        <h1>Details of movies <span class="uk-badge"><?= $movie['title']; ?></span></h1>

        <div class="uk-grid-match uk-flex-center" uk-grid>

                <div class="uk-width-auto uk-height-match" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 500">
                    <div class="uk-card uk-card-small uk-card-default uk-height-match uk-border-rounded">
                        <p><strong>Release Year:</strong> <?= $movie['release_film']; ?></p>
                        <p><strong>Duration:</strong> <?= $movie['duration']; ?> minutes</p>
                        <p><strong>Synopsis:</strong> <?= $movie['synopsys']; ?></p>
                        <p><strong>Director:</strong> <?= $director['firstname']; ?></p>
                        <p><strong>Rating:</strong> <?= $movie['grade']; ?></p>

                        <h3>List of Directors</h3>
                        <?php while ($director = $directors->fetch()) {
                        ?>
                            <!-- Director informations-->
                            <p><strong>Director:</strong> <?= $director['title']; ?></p>
                            <p><strong>Director:</strong> <?= $director['firstnameDirector']; ?></p>
                            <p><strong>Director:</strong> <?= $director['lastnameDirector']; ?></p>
                        <?php } ?>
                        
                        <h3>Casting</h3>
                        <?php while ($actor = $actors->fetch()) { 
                        ?>
                            <!-- Casting informations -->
                            <p><strong>Actor:</strong> <?= $actor['title']; ?></p>
                            <p><strong>Actor:</strong> <?= $actor['name_role']; ?></p>
                            <p><strong>Actor:</strong> <?= $actor['firstnameActor']; ?></p>
                            <p><strong>Actor:</strong> <?= $actor['lastnameActor']; ?></p>
                        <?php } ?>
                    </div>
                </div>

        </div>

    </div>
</div>



<?php
$title = "List of Movies";
$content = ob_get_clean(); //def : Exécute successivement ob_get_contents() et ob_end_clean(). Lit le contenu courant du tampon de sortie puis l'efface
require "view/template.php";
?>