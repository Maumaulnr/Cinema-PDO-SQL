<?php
// require_once 'app/DAO.php';

ob_start(); // Enclenche la temporisation de sortie

// Calculate the number of genres.
$genresCount = $genresList->rowCount();

?>

    <div class="list-genres">
        <h1>List Genres</h1>

        <!-- Si il y a plus d'un genre alors on ajoute un "s" sinon rien -->
        <p>There are <?= $genresCount ?> genre<?= $genresCount > 1 ? "s" : "" ?>.</p>

        <table class="table-list-genres">
            <thead>
                <tr>
                    <!-- Title column -->
                    <th id="th-title-column">Label</th>
                    <th id="th-title-column">Update</th>
                    <th id="th-title-column">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($genre = $genresList->fetch()) { ?>
                <tr>
                    <!-- label -->
                    <td class="td-label-border">
                        <a href="index.php?action=detailsGenre&id=<?= $genre['id_genre'] ?>"><?= $genre["label"] ?></a>
                    </td>
                    <!-- Update -->
                    <td class="td-update-delete">
                        <a href="index.php?action=updateGenreForm&id=<?= $genre['id_genre'] ?>">
                            <i class="fa-solid fa-pencil" title="Update"></i>
                        </a>
                    </td>
                    <!-- Delete -->
                    <td class="td-update-delete">
                        <a href="index.php?action=deleteGenre&id=<?= $genre['id_genre'] ?>" onclick="return confirmDeleteGenre();">
                            <i class="fa-regular fa-trash-can" title="Delete"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        
        
        <!-- <a href="index.php?action=addGenreForm">
            <button>Add Genre</button>
        </a> -->

        <a href="index.php?action=addGenreForm" class="button-link">Add Genre</a>

    </div>
    

<?php
$title = "List of Genres";
$content = ob_get_clean();
require "view/template.php";
?>
