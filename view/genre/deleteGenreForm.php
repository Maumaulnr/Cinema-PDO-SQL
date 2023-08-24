<?php
ob_start();
?>

<h1>Form to delete genre</h1>

<form method="POST" action="index.php?action=delGenre">

    <select id="" name="id_genre" required>
        <option>Genre</option>

        <?php while ($genre = $genres->fetch()) { ?>
            <option value="<?= $actor['id_genre'] ?>"><?= $genre['label'] ?></option>
        <?php } ?>
    </select>

    <!-- Input: DELETE -->
    <input type="submit" name="delGenre" value="Delete">

</form>

<a href="index.php?action=listGenres">Return</a>

<?php

$title = "Form Delete Genre";
$content = ob_get_clean();
require "view/template.php";

?>