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

<label for=""></label>
<select name="" id="">
    <option value=""></option>
</select>

<?php

// clean the temporary memory
$content = ob_get_clean();

// redirection
require "view/template.php";
?>