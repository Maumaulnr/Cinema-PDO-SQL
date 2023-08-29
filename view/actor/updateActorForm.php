<!--  -->

<?php
ob_start();
?>


<div class="update-actor">

    <h1>Modify information about the actor</h1>

    <form method="POST" action="index.php?action=updateActor&id=<?= $id ?>" class="form-flex-column">

        <?php //$actor = $actorUpdate->fetch() ?>
        
        <!-- Input fields: Firstname -->
        <label for="firstname">Firstname</label>
        <input id="firstname" type="text" name="firstname" value="<?= $actor['firstname'] ?>"/>

        <!-- Input fields: Lastname -->
        <label for="lastname">Lastname</label>
        <input id="lastname" class="" type="text" name="lastname" value="<?= $actor['lastname'] ?>" />

        <!-- Input fields: Gender -->
        <label for="gender_person">Gender</label>
        <input id="gender_person" type="text" name="gender_person" value="<?= $actor['gender_person'] ?>"/>

        <!-- Input fields: Birth Date -->
        <label for="birth_date">Birth Date</label>
        <input id="birth_date" type="text" name="birth_date" value="<?= $actor['birth_date'] ?>"/>

        <!-- Button: Submit -->
        <button type="submit" class="button-link">↑ Update ↻</button>
        
    </form>

    <a href="index.php?action=listActors" class="button-link">Return ←</a>

</div>


<?php

$title = "Modify Actors";
$content = ob_get_clean();
require "view/template.php";

?>