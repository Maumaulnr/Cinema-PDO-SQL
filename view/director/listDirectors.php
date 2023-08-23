<?php
ob_start(); // Enclenche la temporisation de sortie

?>

<!-- list of the directors -->

<div class="container">
    <h1>List Directors</h1>

    <ul class="list-divider">
        <?php while ($director = $directors->fetch()) { ?>
            <li>
                <a href="index.php?action=detailsDirector&id= <?= $director['id_director'] ?>"><?= $director['lastname']. ' '. $director['firstname']; ?></a>
            </li>
        <?php } ?>
    </ul>
    
    <a href="index.php?action=addDirectorForm">
        <button>Add Director</button>
    </a>

</div>



<?php
$title = "List Directors";
$content = ob_get_clean();
require "view/template.php";
?>