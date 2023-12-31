<?php
ob_start(); // Enclenche la temporisation de sortie
?>

<div class="add-genre">
    <h1>Add Genre</h1>

    <?php
    // On regarde si $isAddGenreSuccess est setté ainsi que $globalMessage et on vérifie qu'elle est initialisé
    if (isset($isAddGenreSuccess) && isset($globalMessage) && $globalMessage) {
    ?>   
        <!-- id pour animation JS et la class pour personnaliser affichage du message -->
        <p id="global-message" class="<?= $isAddGenreSuccess ? "text-success" : "text-error" ?>"><?= $globalMessage ?></p>
    <?php
    }
    ?>

    <form action="index.php?action=addGenre" method="POST" id="addGenreForm" class="flex-col" >

        <!-- Placeholder : permet d'afficher du texte dans un input, permet d'informer l'utilisateur sur ce qu'il doit écrire -->
        <!-- maxlenght : permet de limiter le nombre de caractères mais ce n'est pas sécurisé car peut être modifié dans le "Inspecter". C'est plus pour le confort de l'utilisateur.  -->
        <label for="genre-label" class="form-label-center">Genre name</label>
        <input type="text" id="genre-label" class="form-input-center" name="label" placeholder="Label" maxlength="30" />
        <?php
        // Si rien n'est écrit dans le champ alors un message renvoit "Le formulaire est invalide" et "Ce champs est obligatoire"
        if (isset($errorMessage) && isset($errorMessage["label"]) && $errorMessage["label"]) {
        ?>   
        <!-- Texte d'erreur à mettre en rouge -->
        <p class="text-error"><?= $errorMessage["label"] ?></p>
        <?php
        }
        ?>

        <button type="submit" class="button-link">Save</button>

        <a href="index.php?action=listGenres" class="button-link">Return</a>

    </form>

</div>

<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>
