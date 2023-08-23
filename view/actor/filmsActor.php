<?php

ob_start();

?>

<!-- On veut pouvoir afficher quand on a cliqué sur un acteur les films dans lesquels il a joué et les rôles-->

<h1>Actor's Films</h1>

<div>
    <?php $actor = $actors->fetch(); ?>

    <?php while ($casting = $filmsActor->fetch()) { ?>
        <!-- a.firstname AS firstnameActor, a.lastname AS lastnameActor, m.title, r.name_role -->
        <p><?= $casting['title']. ' '. $casting['firstname']. ' '. $casting['lastname']. ' '. $casting['title']. ' '. $casting['name_role']  ?></p>
    <?php } ?>

    <a href="index.php?action=listActors.php">Return</a>
</div>

<?php

$title = "Actor's Films";
$content = ob_get_clean();
require "view/template.php";

?>