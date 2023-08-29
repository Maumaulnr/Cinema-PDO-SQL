<?php
ob_start(); // Enclenche la temporisation de sortie

?>

<!-- list of the actors -->

<div class="list-actors">
    <h1>List Actors</h1>

    <?php while ($actor = $actors->fetch()) { ?>
        <div class="actor-row">
            <!-- Column 1 : Firstname & lastname actor -->
            <div class="div-list-actors">
                <ul class="list-divider">
                    <li class="li-list-actors">
                        <a href="index.php?action=detailsActor&id=<?= $actor['id_actor'] ?>">
                            <!-- Gun Icon -->
                            <span class="actor-icon">
                                <i class="fa-solid fa-gun" style="color: #000000;"></i>
                            </span>
                            <?= $actor['firstname']. ' '. $actor['lastname']; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Possibilité de update l'acteur qui permettra de modifier aussi dans detailsActor lorsqu'on rappelle à nouveau le prénom et nom de l'acteur -->

            <!-- Column 2 : Update -->
            <div class="div-update-delete">
                <a href="index.php?action=updateActorForm&id=<?= $actor['id_actor'] ?>">
                    <i class="fa-solid fa-pencil" style="color: #000000;" title="Update"></i>
                </a>
            </div>

            <!-- Column 3 : Delete -->
            <div class="div-update-delete">
                <a href="index.php?action=deleteActor&id=<?= $actor['id_actor'] ?>" onclick="return confirmDeleteGenre();">
                    <i class="fa-regular fa-trash-can" style="color: #000000;" title="Delete"></i>
                </a>
            </div>
        </div>
    <?php } ?>
    


    <a href="index.php?action=addActorForm" class="button-link">Add Actor</a>

</div>

<?php
$title = "List Actors";
$content = ob_get_clean();
require "view/template.php";
?>
