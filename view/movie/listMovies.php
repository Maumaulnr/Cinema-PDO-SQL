<?php

ob_start(); //def : Enclenche la temporisation de sortie
?>


<div class="uk-section uk-section-secondary">
    <div class="uk-container">
        <h1>Lists of movies <span class="uk-badge"><?= $movies->rowCount() ?></span></h1>

        <div class="uk-grid-match uk-flex-center" uk-grid>
            <?php
            while ($movie = $movies->fetch()) { var_dump($movies)?>
            
                <div class="uk-width-auto uk-height-match" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 500">
                    <div class="uk-card uk-card-small uk-card-default uk-height-match uk-border-rounded">
                        <figure class="uk-height-match uk-border-rounded">
                            <!-- Add a link to display film details -->
                            <a href="">
                                <img class="uk-border-rounded" src="./public/image/<?= $movie["poster"]; ?>" alt="picture of movie : <?= $movie["title"]; ?>" width="300">
                            </a>
                            <figcaption class="uk-text-center uk-margin-small-top uk-margin-small-bottom">
                                <a class="uk-link-toggle" href="index.php?action=detailsMovie&id= <?= $movie['id_movie'] ?>"><strong><?= $movie['title']?></strong></a>
                            </figcaption>
                        </figure>

                    </div>
                </div>

            <?php }
            ?>
        </div>

    </div>
</div>



<?php
$title = "List of Movies";
$content = ob_get_clean(); //def : Exécute successivement ob_get_contents() et ob_end_clean(). Lit le contenu courant du tampon de sortie puis l'efface
require "view/template.php";
?>