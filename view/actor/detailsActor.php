<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<!-- On affiche les détails de l'acteur comme sa date de naissance, etc -->
<div class="details-actor">

    <h1>Details Actor</h1>

    <div class="informations-casting-actor">
        <?php //$actor = $personActor->fetch() ?>
        <p><?= $personActor['firstname'] ?></p>
        <p><?= $personActor['lastname'] ?></p>
        <p><?= $personActor['gender_person'] ?></p>
        <p><?= $personActor['birth_date'] ?></p>
    </div>

<!-- On veut pouvoir afficher les films dans lesquels l'acteur a joué et ses rôles-->

    <div class="informations-casting-actor">

        <h2>Actor's Films</h2>

        <?php while ($casting = $castingActor->fetch()) { ?>
            <!-- (Je veux afficher le titre du film et le rôle que l'acteur a joué) x n -->
            <span><i class="fa-solid fa-film" style="color: #000000;"></i></span>
            <p><?= $casting['title']?></p>
            <p><strong>Role: </strong><?=$casting['name_role']?></p>
        <?php } ?>

    </div>

    <a href="index.php?action=updateActor&id=<?= $actor['id_actor'] ?>" class="button-link">Update ↻</a>

    <a href="index.php?action=listActors" class="button-link">Return ←</a>

</div>


<?php
$title = "Details Actor";
$content = ob_get_clean();
require "view/template.php";
?>