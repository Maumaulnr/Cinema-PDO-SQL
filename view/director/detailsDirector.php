<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<div class="details-actor">

    <h2>Details Director</h2>

    <div>
        <?php $director = $directors->fetch(); ?>
        <p><?= $director['firstname'] ?></p>
        <p><?= $director['lastname'] ?></p>
        <p><?= $director['gender_person'] ?></p>
        <p><?= $director['birth_date'] ?></p>
    </div>

    <a href="index.php?action=filmsDirector&id=<?= $director['id_director'] ?>">
        <p>Director's films</p>
    </a>

    <br><a href="index.php?action=updateDirector&id=<?= $director['id_director'] ?>"> Modify </a></br>

    <br><a href="index.php?action=listDirectors">Return</a></br>
</div>


<?php
$title = "Details Director";
$content = ob_get_clean();
require "view/template.php";
?>