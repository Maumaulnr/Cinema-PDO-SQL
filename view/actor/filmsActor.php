<?php

ob_start();

?>

<div class="films-actor">
<!-- On veut pouvoir afficher quand on a cliqué sur un acteur les films dans lesquels il a joué et ses rôles-->

<h1>Actor's Films</h1>


    <?php //$actor = $actors->fetch(); ?>

    <?php while ($casting = $filmsActor->fetch()) { ?>
        <!-- (Je veux afficher le titre du film et le rôle que l'acteur a joué) x n -->
        <p>Movie :<?= $casting['title'].' Role: '.$casting['name_role']  ?></p>
    <?php } ?>

    <a href="index.php?action=listActors">Return</a>
</div>

<?php

$title = "Actor's Films";
$content = ob_get_clean();
require "view/template.php";

?>