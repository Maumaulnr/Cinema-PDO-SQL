<?php
ob_start(); // Enclenche la temporisation de sortie

?>

<!-- list of the actors -->

<div class="container">
    <h1>List Actors</h1>

    <ul class="list-divider">
        <?php while ($actor = $actors->fetch()) { ?>
            <li>
                <a href="index.php?action=detailsActor&id= <?= $actor['id_actor'] ?>"><?= $actor['lastname']. ' '. $actor['firstname']; ?></a>
            </li>
        <?php } ?>
    </ul>
    
    <a href="index.php?action=addActorForm">
        <button>Add Actor</button>
    </a>

</div>

<?php
$title = "List Actors";
$content = ob_get_clean();
require "view/template.php";
?>
