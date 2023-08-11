<?php

ob_start(); //def : Enclenche la temporisation de sortie
?>
<h1>List Movies</h1>

<div class="section section-secondary">
    <div class="container">
        <h1>Lists of movies <span class="badge"><?= $movies->rowCount() ?></span></h1>

        <div class="">
            <?php
            while ($movie = $movies->fetch()) { ?>
            
                <div class="">
                    <div class="">
                        <figure class="">
                            <!-- Add a link to display film details -->
                            <a href="">
                                <img class="" src="./public/image/<?= $movie["poster"]; ?>" alt="picture of movie : <?= $movie["title"]; ?>" width="300">
                            </a>
                            <figcaption class="">
                                <a class="" href="index.php?action=detailsMovie&id= <?= $movie['id_movie'] ?>"><strong><?= $movie['title']?></strong></a>
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