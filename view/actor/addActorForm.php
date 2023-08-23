<?php
ob_start(); // Enclenche la temporisation de sortie
?>

    <div class="add-actor">
        <h1>Add Actors</h1>

    <?php
    // On regarde si $isAddGenreSuccess est setté ainsi que $globalMessage et on vérifie qu'elle est initialisé
    if (isset($isAddActorSuccess) && isset($globalMessage) && $globalMessage) {
    ?>   
        <!-- id pour animation JS et la class pour personnaliser affichage du message -->
        <p id="global-message" class="<?= $isAddActorSuccess ? "text-success" : "text-error" ?>"><?= $globalMessage ?></p>
    <?php
    }
    ?>

        <form action="index.php?action=addActor" method="post" class="flex-col">

            <!-- Placeholder : permet d'afficher du texte dans un input, permet d'informer l'utilisateur sur ce qu'il doit écrire -->
            <!-- maxlenght : permet de limiter le nombre de caractères mais ce n'est pas sécurisé car peut être modifié dans le "Inspecter". C'est plus pour le confort de l'utilisateur.  -->
            <label for="actor-label">Actor Lastname</label>
            <input type="text" id="actor-label" name="actorLastname" placeholder="Lastname" maxlenght="30" />

            <label for="actor-label">Actor Firstname</label>
            <input type="text" id="actor-label" name="actorFirstname" placeholder="Firstname" maxlenght="30" />

            <p>Gender :</p>
            <label for="actor-label">Male</label>
            <input type="radio" id="actor-label" name="actorGenderPerson" />

            <label for="actor-label">Female</label>
            <input type="radio" id="actor-label" name="actorGenderPerson" />

            <label for="actor-label">Other</label>
            <input type="radio" id="actor-label" name="actorGenderPerson" />

            <label for="actor-label">Actor Birth Date</label>
            <input type="date" id="actor-label" name="actorBirthDate" placeholder="DD-MM-YYYY" required/>

            <?php
            // Si rien n'est écrit dans le champ alors un message renvoit "Le formulaire est invalide" et "Ce champs est obligatoire"
            if (isset($errorMessage) && isset($errorMessage["actorLastname"]) && $errorMessage["actorLastname"] && isset($errorMessage["actorFirstname"]) && $errorMessage["actorFirstname"] && isset($errorMessage["actorGenderPerson"]) && $errorMessage["actorGenderPerson"] && isset($errorMessage["actorBirthDate"]) && $errorMessage["actorBirthDate"]) {
            ?>   
            <!-- Texte d'erreur à mettre en rouge -->
            <p class="text-error"><?= $errorMessage["actorLastname"] ?></p>
            <p class="text-error"><?= $errorMessage["actorFirstname"] ?></p>
            <p class="text-error"><?= $errorMessage["actorGenderPerson"] ?></p>
            <p class="text-error"><?= $errorMessage["actorBirthDate"] ?></p>

            <?php
            }
            ?>

            <button type="submit">Save</button>

            <a href="index.php?action=listActors">Return</a>

        </form>

    </div>

<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>