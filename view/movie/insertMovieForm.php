<!-- Insert movie -->

<?php
ob_start();

?>

<h2>Insert the movie</h2>

<div class="insertMovie">

    <form method="POST" action="index.php?action=insertMovie">
        <label>Title</label>
        <input type="text" name="movieTitle" required>
        <label>Release Film (DD-MM-YYYY)</label>
        <input type="date" name="movieReleaseFilm" placeholder="DD-MM-YYYY" required>
        <label>Duration (min)</label>
        <input type="text" name="movieDuration" placeholder="min" required>
        <label>Synopsys</label>
        <textarea name="movieSynopsys" id="" cols="10" rows="0" required></textarea>
        <label>Grade (/5)</label>
        <input type="text" name="movieGrade" placeholder="/5" required>
        <label>Poster</label>
        <input type="file" name="moviePoster" required>

        <!-- On récupère les infos du réalisateur via la clé étrangère director_id dans la table Movie -->
        <p>Director :</p>
        <label for="select-director">Director :</label>
        <select type="text" id="select-director" name="movieDirector" required>
            <!--  $directors related to the insertController.php file and insertMovieForm() method -->
            <?php while ($director = $directors->fetch()) { ?> 
            <option value="<?= $director['id_director']?>"><?= $director['firstname']. ' '.$director['lastname'] ?></option>
            <?php } ?>
        </select>

        <!-- Choix des genres à cocher : Plusieurs genres par film possible -->
        <p>Genre :</p>
            <!--  $genres related to the insertController.php file and showMovieForm() method -->
            <?php while ($genre = $genres->fetch()) { ?>
            <?php /* <option value="<?= $genre[id_genre] ?>"> <?= $genre['genre'] ?> </option> */ ?>
            <input type="checkbox" id="checkbox-genre-<?= $genre["id_genre"] ?>" name="movieGenres[]" value="<?= $genre["id_genre"] ?>">
            <label for="checkbox-genre-<?= $genre["id_genre"] ?>"><?= $genre['label'] ?></label>
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
        <button type="submit">Save</button>

        <a href="index.php?action=listMovies">Return</a>

    </form>

</div>

<?php

$title = "Insert Movies";
// clean the temporary memory
$content = ob_get_clean();

// redirection
require "view/template.php";
?>