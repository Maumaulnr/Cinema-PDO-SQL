<?php
ob_start();
?>

<h1>Form to delete actor</h1>

<form method="POST" action="index.php?action=delActor">

    <select id="" name="id_actor" required>
        <option>Actors</option>

        <?php while ($actor = $actors->fetch()) { ?>
            <option value="<?= $actor['id_actor'] ?>"><?= $actor['lastname']. ' '. $actor['firstname'] ?></option>
        <?php } ?>
    </select>

    <!-- Input: DELETE -->
    <input type="submit" name="delActor" value="Delete">

</form>

<a href="index.php?action=listActors">Return</a>

<?php

$title = "Form Actors";
$content = ob_get_clean();
require "view/template.php";

?>