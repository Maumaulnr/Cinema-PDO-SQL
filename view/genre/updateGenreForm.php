<!--  -->

<?php
ob_start();
?>

<!-- mettre à jour le label donc il faut au préalable que je puisse sélectionner le label à modifier puis écrire la modification et l'envoyer via un formulaire -->

<div class="update-genre">

    <h1>Update information about the genre</h1>



    <form method="POST" action="index.php?action=updateGenre&id=<?= $id ?>">

        <label for="genre-label">Genre name</label>
        <input type="text" id="genre-label" name="label" value="<?= $formValues['label'] ?>" placeholder="Label" maxlenght="30" />

        <button type="submit">Update</button>

    </form>

    <br><a href="index.php?action=listGenres">Return</a>

</div>


<?php

$title = "Update Genres";
$content = ob_get_clean();
require "view/template.php";

?>