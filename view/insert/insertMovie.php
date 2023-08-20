<!-- Insert movie -->

<?php
ob_start();

?>

<h2>Insert the movie</h2>

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
    <label>Grade</label>
    <input type="text" name="movieGrade" required>
    <label>Poster</label>
    <input type="text" name="moviePoster" required>
</form>

<label for="select-genre">Genre :</label>
<select name="movieGenre" id="select-genre">
    <option>Select the genre</option>
    <!--  $directors related to the insertController.php file and showMovieForm() method -->
    <?php while ($genre = $genres->fetch()) { ?>
    <option value="<?= $genre[id_genre] ?>"> <?= $genre['genre'] ?> </option>
    <?php } ?>
</select>

<label for="select-director">Director :</label>
<select name="movieDirector" id="select-director">
    <option>Select the director</option>
    <!--  $directors related to the insertController.php file and showMovieForm() method -->
    <?php while ($director = $directors->fetch()) { ?>
    <option value="<?= $director['id_director']?>"> <?= $director['lastname']. ' '. $director['firstname'] ?></option>
    <?php } ?>
</select>

<button type="submit" name="submit">Submit</button>

<?php

// clean the temporary memory
$content = ob_get_clean();

// redirection
require "view/template.php";
?>