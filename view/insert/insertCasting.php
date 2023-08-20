<!-- Insert Casting -->

<?php
ob_start();

?>

<h2>Insert Casting</h2>

<form method="POST" action="index.php?action=insertCasting">
    <!-- Role -->
    <label for="select-role">Role :</label>
    <select class="select" name="role" id="select-role">
        <option class="select-option">Select the role</option>
        <!-- $director related to the insertController.php and showMovieForm() method -->
        <?php while ($role = $roles->fetch()) { ?>
        <!--  -->
        <option value="<?= $role['id_role'] ?>"> <?= $role['role'] ?> </option>
        <?php } ?>
    </select>
    <!-- Actor -->
    <label for="select-actor">Actor :</label>
    <select name="actor" id="select-actor">
        <option class="select-option">Select the actor</option>
        <!-- $director related to the insertController.php and showMovieForm() method -->
        <?php while ($actor = $actors->fetch()) { ?>
        <!--  -->
        <option value="<?= $actor['id_actor'] ?>"> <?= $actor['lastname']. ' '. $actor['firstname'] ?> </option>
        <?php } ?>
    </select>
    <!-- Film -->
    <label for="select-film">Film :</label>
    <select name="movieCasting" id="select-movie">
        <option class="select-option">Select the movie</option>
        <!-- $director related to the insertController.php and showMovieForm() method -->
        <?php while ($film = $films->fetch()) { ?>
        <!--  -->
        <option value="<?= $film['id_film'] ?>"> <?= $film['title'] ?> </option>
        <?php } ?>
    </select>

    <button type="submit" name="submit">Submit</button>
</form>

<?php
// clean the temporary memory
$content = ob_get_clean();

// Redirected to template.php
require "view/template.php";

?>