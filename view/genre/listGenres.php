<?php
// require_once 'app/DAO.php';

ob_start(); // Enclenche la temporisation de sortie

// Calculate the number of genres.
$genresCount = $genresList->rowCount();

?>

    <div class="list-genres">
        <h1>List Genres</h1>

        <!-- Si il y a plus d'un genre alors on ajoute un "s" sinon rien -->
        <p>Il existe <?= $genresCount ?> genre<?= $genresCount > 1 ? "s" : "" ?>.</p>

        <table>
            <thead>
                <tr>
                    <!-- Title column -->
                    <th>Label</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php while ($genre = $genresList->fetch()) { ?>
                    <!-- label -->
                    <a href="index.php?action=detailsGenre&id=<?= $genre['id_genre'] ?>">
                        <td><?= $genre["label"] ?></td>
                    </a>
                    <!-- Update -->
                    <td></td>
                    <!-- Delete -->
                    <td></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <?php while ($genre = $genresList->fetch()) { ?>
                    <!-- ligne -->
                    <a href="index.php?action=detailsGenre&id=<?= $genre['id_genre'] ?>">
                        <th><?= $genre["label"] ?></th>
                    </a>

                    
                    <?php } ?>
                </tr>
            </thead>
        </table>

        <ul class="">
            <?php while ($genre = $genresList->fetch()) { ?>
                <li>
                    <a href="index.php?action=detailsGenre&id=<?= $genre['id_genre'] ?>"><?= $genre["label"] ?></a>
                    
                    <a href="index.php?action=updateGenreForm&id=<?= $genre['id_genre'] ?>"><i class="fas fa-pencil-alt"></i></a>
                    <a href="index.php?action=deleteGenre&id=<?= $genre['id_genre'] ?>"><i class="fa-regular fa-trash-can"></i></a>
                </li>
            <?php } ?>
        </ul>
        
        <a href="index.php?action=addGenreForm">
            <button>Add Genre</button>
        </a>

    </div>


<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>
