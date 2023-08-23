<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<div class="details-actor">

    <h2>Details Actor</h2>

    <div>
        <?php $actor = $actors->fetch(); ?>
        <p><?= $actor['firstname'] ?></p>
        <p><?= $actor['lastname'] ?></p>
        <p><?= $actor['gender_person'] ?></p>
        <p><?= $actor['birth_date'] ?></p>
    </div>

    <a href="index.php?action=filmsActor&id=<?= $actor['id_actor'] ?>">
        <h2>Actor's films</h2>
    </a>

    <br><a href="index.php?action=updateActor&id=<?= $actor['id_actor'] ?>"> Modify </a></br>

    <br><a href="index.php?action=listActors">Return</a></br>
</div>


<?php
$title = "Details Actor";
$content = ob_get_clean();
require "view/template.php";
?>