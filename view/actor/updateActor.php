<!--  -->

<?php
ob_start();
?>

<h1>Modify information about the actor</h1>

<div>

    <form method="POST" action="index.php?action=modifyActor">

        <?php $actor = $actorUpdate->fetch() ?>

        <!-- Input fields: Lastname -->
        <label for="lastname">Lastname</label>
        <input id="lastname" class="" type="text" name="lastname" value="<?= $actor['lastname'] ?>" />

        <!-- Input fields: Firstname -->
        <label for="firstname">Firstname</label>
        <input id="firstname" type="text" name="firstname" value="<?= $actor['firstname'] ?>"/>

        <!-- Input fields: Gender -->
        <label for="gender_person">Gender</label>
        <input id="gender_person" type="text" name="gender_person" value="<?= $actor['gender_person'] ?>"/>

        <!-- Input fields: Birth Date -->
        <label for="birth_date">Birth Date</label>
        <input id="birth_date" type="text" name="birth_date" value="<?= $actor['birth_date'] ?>"/>

        <!-- Input: Submit -->
        <input type="submit" name="modifyActor" value="Modify"/>
        
        <input type="hidden" name="id_person" value="<?= $actor['id_person'] ?>"/>
    </form>

</div>

<a href="index.php?action=listActors">Return</a>

<?php

$title = "Modify Actors";
$content = ob_get_clean();
require "view/template.php";

?>