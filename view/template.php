<!-- le plus gros du html sera dans le template -->

<!-- a href : index.php?action=listFilms : sera envoyé en GET grâce à action -->

<!-- $content : correspondra aux différentes vues -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./public/css/style.css">

    <title><?= $title ?></title>
</head>

<body>
    <header>

        <nav class="navbar">

            <ul class="category">

                <li class="list-category">
                    <a href="index.php">Home</a>
                </li>
                <li class="list-category">
                    <a href="index.php?action=listMovies">Movies</a>
                </li>
                <li class="list-category">
                    <a href="index.php?action=listGenres">Genres</a>
                </li>
                <li class="list-category">
                    <a href="index.php?action=listActors">Actors</a>
                </li>
                <li class="list-category">
                    <a href="index.php?action=listDirectors">Directors</a>
                </li>

            </ul>

        </nav>
            
    </header>
    <main>

        <?php
        // On regarde si $isAddGenreSuccess est setté ainsi que $globalMessage et on vérifie qu'elle est initialisé
        //if (isset($isActionSuccess) && isset($globalMessage) && $globalMessage) {
        ?>   
            <!-- id pour animation JS et la class pour personnaliser affichage du message -->
            <!-- <p id="global-message" class="<?= $isActionSuccess ? "text-success" : "text-error" ?>"><?= $globalMessage ?></p> -->
        <?php
        //}
        ?>

        <?= $content ?>
    </main>
    <footer class="footer-cinema">
        <small>2023 &copy; Cinema - Cinema by </small>
    </footer>
    <script src="./public/js/confirmDelete.js"></script>
</body>
</html>
