<?php

ob_start(); //def : Enclenche la temporisation de sortie
?>

<h2>List of Directors</h2>

<?php

while ($director = $directors->fetch()) {

?>

    <p><?= $director['firstname'] ?></p>
    <p><?= $director['lastname'] ?></p>
    <p><?= $director['birth_date'] ?></p>
    <p><?= $director['gender_person'] ?></p>


<?php } ?>




<?php

$content = ob_get_clean(); //def : Exécute successivement ob_get_contents() et ob_end_clean(). Lit le contenu courant du tampon de sortie puis l'efface

// Redirecting to template.php
require "view/template.php";
?>