<!-- Insert movie -->

<?php
ob_start();

?>

<h2>Insert the movie</h2>

<div class="insertMovie">

    <form method="POST" action="index.php?action=insertMovie">
        <label>Title</label>
        <input type="text" name="movieTitle" required>
        <label>Release Film</label>
        <input type="text" name="movieReleaseFilm" required>
        <label>Duration</label>
        <input type="text" name="movieDuration" required>
        <label>Synopsys</label>
        <input type="text" name="movieSynopsys" required>
        <label>Grade</label>
        <input type="text" name="movieGrade" required>
        <label>Poster</label>
        <input type="text" name="moviePoster" required>

        <!-- <label for="select-genre">Genre :</label> -->
        <p>Genre :</p>
        <!-- <select id="select-genre" name="movieGenre"> -->
            <!-- <option>Select the genre</option> -->
            <!--  $directors related to the insertController.php file and showMovieForm() method -->
            <?php while ($genre = $genres->fetch()) { ?>
            <?php /* <option value="<?= $genre[id_genre] ?>"> <?= $genre['genre'] ?> </option> */ ?>
            <input type="checkbox" id="checkbox-genre-<?= $genre["id_genre"] ?>" name="movieGenres[]" value="<?= $genre["id_genre"] ?>">
            <label for="checkbox-genre-<?= $genre["id_genre"] ?>"><?= $genre['label'] ?></label>
            <?php } ?>
        </select>

        <p>Director :</p>
        <label for="select-director">Director :</label>
        <select type="text" id="select-director" name="movieDirector" required>
            <!--  $directors related to the insertController.php file and showMovieForm() method -->
            <?php while ($director = $directors->fetch()) { ?> 
            <option value="<?= $director['id_director']?>"><?= $director['lastname']. ' '. $director['firstname'] ?></option>
            <?php } ?>
        </select>

        <p>Casting</p>
        <select type="text" id="select-casting" name="movieActor" required>
            <?php while ($actor = $actors->fetch()) { ?>
            <option value="<?= $director['id_actor']?>"><?= $director['lastname']. ' '. $director['firstname'] ?></option>
            <?php } ?>
        </select>

        <p>Roles</p>
        <select type="text" id="select-role" name="movieRole" required>
            <?php while ($role = $roles->fetch()) { ?>
            <option value="<?= $director['id_role']?>"><?= $role['name_role']?></option>
            <?php } ?>
        </select>

        <!-- Input: submit request to FilmController.php -->
        <!-- Input name must be identical to the insertMovie() function -->
        <input type="submit" class="insert" name="insertMovie" value="ADD" />

    </form>

</div>

<?php

$title = "Insert Movies";
// clean the temporary memory
$content = ob_get_clean();

// redirection
require "view/template.php";
?>