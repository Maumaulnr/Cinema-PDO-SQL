<!-- le plus gros du html sera dans le template -->

<!-- a href : index.php?action=listFilms : sera envoyé en GET grâce à action -->

<!-- $content : correspondra aux différentes vues -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.5.9/css/uikit.min.css">
    <link rel="shortcut icon" href="../public/img/icons8-film-projector-48.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.5.9/js/uikit.min.js" integrity="sha512-OZ9Sq7ecGckkqgxa8t/415BRNoz2GIInOsu8Qjj99r9IlBCq2XJlm9T9z//D4W1lrl+xCdXzq0EYfMo8DZJ+KA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.5.9/js/uikit-icons.min.js" integrity="sha512-hcz3GoZLfjU/z1OyArGvM1dVgrzpWcU3jnYaC6klc2gdy9HxrFkmoWmcUYbraeS+V/GWSgfv6upr9ff4RVyQPw==" crossorigin="anonymous"></script>
    <script src="app/script.js"></script> -->
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
        <?= $content ?>
    </main>
    <footer class="footer-cinema">
        <small>2023 &copy; Cinema - Cinema by </small>
    </footer>
</body>
</html>
