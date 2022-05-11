<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();

$_SESSION['user_id'] = 3;
$user_id = $_SESSION['user_id'];

if (empty($user_id)) {
    header('Location: login.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="#">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <title>Añadir películas:</title>
</head>

<body class="bg-dark">
    <div class="error-container"></div>

    <div class="error"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MovieList</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="main.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">WatchList</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas deseadas</a>
                    </li>
                </ul>
                <form class="d-flex justify-content-end ms-2">
                    <input class="form-control me-2 my-input" type="search" placeholder="Buscar peliculas"
                        aria-label="Search" />
                    <button class="btn btn-primary btn-search" type="submit">
                        Buscar
                    </button>
                    <button class="btn btn-success btn-signin ms-2" type="submit" formaction="login.php">
                        Iniciar
                    </button>
                    <button class="btn btn-danger btn-signout ms-2" type="submit">
                        Registrarse
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <hr class="bg-danger border-2 border-top border-danger" />
    <form action="do_add_movie.php" role="form" class="row p-3 text-light" method="POST" enctype="multipart/form-data">
        <h2>DATOS DE LA PELÍCULA:</h2>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="f_titulo_peliculas" class="form-label">Título Película</label>
                <input type="text" class="form-control" name="f_titulo_pelicula" id="f_titulo_pelicula" />
            </div>
            <div class="col-md-6">
                <label for="f_descripcion_peliculas" class="form-label">Descripción película:</label>
                <textarea class="form-control" name="f_descripcion_pelicula" id="f_descripcion_pelicula" maxlength="500"
                    rows="4" cols="3" style="resize: none; width: 100%; height: 17px" required></textarea>
            </div>
            <div class="col-md-6">
                <label for="imagenPeliculas" class="form-label">Imagen película:</label>
                <input type="file" class="form-control"  name="imagenPelicula" id="imagenPelicula"/>
            </div>
            <div class="col-md-6">
                <label for="f_created_peliculas" class="form-label">Año de emisión de la película:</label>
                <input type="date" class="form-control" name="f_created_pelicula" id="f_created_pelicula" />
            </div>
            <div class="col-md-6">
                <label for="f_gender_peliculas" class="form-label">Género de la película:</label>
                <input type="text" class="form-control" name="f_gender_pelicula" id="f_gender_pelicula" />
            </div>
            <div class="col-md-6">
                <label for="f_duration_peliculas" class="form-label">Duración de la película:</label>
                <input type="text" class="form-control" name="f_duration_pelicula" id="f_duration_pelicula" />
            </div>
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-full" name="upload">Enviar</button>
        </div>
        <?php
        // recoger la variable $_GET['failed'] para mostrar el error
        if (isset($_GET['failed'])) {
            if($_GET['failed'] == 'True'){ ?>
            <p class="lead" style="color:red">
                Solo se pueden subir imágenes con la extensión jpg, jpeg y png.
            </p>
             <?php   
            }
        }?>
       
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
</body>

</html>







   


 

