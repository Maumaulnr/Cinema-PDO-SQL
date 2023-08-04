
<?php

ob_start(); //def : Enclenche la temporisation de sortie

$movie = $detailsMovie->fetch();
// var_dump($detailsMovie);

?>

<div class="uk-section uk-section-secondary">
    <div class="uk-container">
        <h1>Details of movie <span class="uk-badge"><?= $movie['title']; ?></span></h1>

        <div class="uk-grid-match uk-flex-center" uk-grid>

                <div class="uk-width-auto uk-height-match" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 500">
                    <div class="uk-card uk-card-small uk-card-default uk-height-match uk-border-rounded">
                        <figure class="poster uk-height-match uk-border-rounded">
                            <img class="uk-border-rounded" src="./public/image/<?= $movie["poster"]; ?>" width="300">
                        </figure>
                        <p><strong>Release Year:</strong> <?= $movie['release_film']; ?></p>
                        <p><strong>Duration:</strong> <?= $movie['duration']; ?> minutes</p>
                        <p><strong>Synopsis:</strong> <?= $movie['synopsys']; ?></p>
                        <p><strong>Rating:</strong> <?= $movie['grade']; ?> /5</p>

                        <!-- Director informations-->
                        <p><strong>Director:</strong> <?= $movie['firstnameDirector']. ' '. $movie['lastnameDirector']; ?></p>
                        
                        <h3>Casting</h3>
                        <?php while ($casting = $detailsCastings->fetch()) { 
                        ?>
                        <!-- Casting informations -->
                        <p><?= $casting['firstnameActor']. ' '. $casting['lastnameActor']. ': '. $casting['name_role'] ; ?></p>
                        <?php } ?>
                    </div>
                </div>

        </div>

    </div>
</div>



<?php
$title = "Details of Movie";
$content = ob_get_clean(); //def : Exécute successivement ob_get_contents() et ob_end_clean(). Lit le contenu courant du tampon de sortie puis l'efface
require "view/template.php";
?>