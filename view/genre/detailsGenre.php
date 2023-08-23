<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<div class="details-genre">

    <h2>Details Genre</h2>

    <div>
        <?php $genre = $genres->fetch(); ?>
        <p>Film's Genre :<?= $genre['label']; ?></p>
    </div>

    <a href="index.php?action=detailsMovie&id=<?= $genre['id_movie'] ?>">
        <p><?= $genre['title'] ?></p>
    </a>

    <?php while ($genre = $genres->fetch()) { ?>
        <a href="index.php?action=detailsMovie&id=<?= $genre['id_movie'] ?>">
            <p><?= $genre['title'] ?></p>
        </a>
    <?php } ?>

    <a href="index.php?action=listGenres">Return</a>
</div>


<?php
$title = "Genre Details";
$content = ob_get_clean();
require "view/template.php";
?>
