<!-- Insert Director -->

<?php
ob_start();

?>

<h2>Insert Director</h2>

<form method="POST" action="index.php?action=insertDirector">
    <label>Director's Last Name</label>
    <input type="text" name="directorLastname" required>
    <label>Director's First Name</label>
    <input type="text" name="directorFisrtname" required>
    <div>
        <label>Director's gender</label>
        <input type="radio" name="directorGender">
        <label for="male">Male</label>
        
        <input type="radio" name="directorGender">
        <label for="female">Female</label>
    </div>
    <label>Director's Birth Date</label>
    <input type="date" name="directorBirthDate" required>
    <button type="submit" name="submit">Submit</button>
</form>

<?php
// clean the temporary memory
$content = ob_get_clean();

// redirection
require "view/template.php";

?>