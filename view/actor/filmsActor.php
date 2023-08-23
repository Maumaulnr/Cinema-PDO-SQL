<?php

ob_start();

?>

<h1>Actor's Films</h1>

<div>
    <?php $actor = $actors->fetch(); ?>

    <a href="index.php?action=detailsMovie&id=<?= $actor['id_movie'] ?>">
        <p><?= $actor['title'] ?></p>
    </a>

    <?php while ($actor = $actors->fetch()) { ?>
        <p><?= $actor['title'] ?></p>
    <?php } ?>

    <a href="index.php?action=listActors.php">Return</a>
</div>

<?php

$title = "Actor's Films";
$content = ob_get_clean();
require "view/template.php";

?>