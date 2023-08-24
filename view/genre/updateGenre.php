<!--  -->

<?php
ob_start();
?>

<h1>Modify information about the actor</h1>

<div>

    <form method="POST" action="index.php?action=modifyGenre">

        <?php  ?>

        <label for="genre-label">Genre name</label>
            <input type="text" id="genre-label" name="label" placeholder="Label" maxlenght="30" />

    </form>

    <br><a href="index.php?action=updateGenre&id=<?= $actor['id_genre'] ?>"> Modify </a></br>

</div>

<a href="index.php?action=listGenres">Return</a>

<?php

$title = "Modify Genres";
$content = ob_get_clean();
require "view/template.php";

?>