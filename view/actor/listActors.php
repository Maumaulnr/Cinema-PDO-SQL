<?php
ob_start(); // Enclenche la temporisation de sortie

?>
<p>Page listActors</p>

<!-- list of the actors -->
<div class="uk-section uk-section-secondary">
    <div class="uk-container">
        <h1>List Actors</h1>

        <ul class="uk-list uk-list-divider">
            <?php while ($actor = $actors->fetch()) { ?>
                <p><?= $actor['id_actor']; ?></p>
                <p><?= $actor['lastname']; ?></p>
                <p><?= $actor['firstname']; ?></p>
                <p></p>
                <li><a href="index.php?action=actorDetails&id"></li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php
$title = "List Actors";
$content = ob_get_clean();
require "view/template.php";
?>
