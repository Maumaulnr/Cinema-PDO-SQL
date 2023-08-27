<!--  -->

<?php
ob_start();
?>

<!-- mettre à jour le label donc il faut au préalable que je puisse sélectionner le label à modifier puis écrire la modification et l'envoyer via un formulaire -->

<div class="update-genre">

    <h1>Update the genre</h1>



    <form method="POST" action="index.php?action=updateGenre&id=<?= $id ?>">

        <label for="genre-label">Genre name</label>
        <input type="text" id="genre-label" name="label" value="<?= $formValues['label'] ?>" placeholder="Label" maxlength="30" />

        <!-- Quand on clique sur Update, le résultat renvoie vers le détail du genre -->
        <button type="submit" class="button-link">Update</button>

    </form>

    <a href="index.php?action=listGenres" class="button-link">Return</a>

</div>


<?php

$title = "Update Genres";
$content = ob_get_clean();
require "view/template.php";

?>