
<?php

ob_start(); //def : Enclenche la temporisation de sortie

$movie = $detailsMovie->fetch();

?>


<div class="details-movie">

    <h1>Details of movie : <br><span class="details-movie-title"><?= $movie['title']; ?></span></br></h1>

    <div class="card card-small card-default height-match border-rounded">
        <figure class="poster height-match border-rounded">
            <img class="border-rounded" src="./public/image/<?= $movie["poster"]; ?>" width="300">
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

    <a href="index.php?action=listMovies">Return</a>
    
</div>

<?php

$title = "Details of Movie";
$content = ob_get_clean(); //def : Exécute successivement ob_get_contents() et ob_end_clean(). Lit le contenu courant du tampon de sortie puis l'efface
require "view/template.php";

?>