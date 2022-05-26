<?php

    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    
    $mysqli = get_db_connection_or_die();
    
   
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style_allmovies.css">
    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="#">
    <style>
    .quitar {
        text-decoration: none;
    }

    .movie_card #boton-mas {
        cursor: pointer;
        border-style: none;
        background-color: #ff3838;
        color: #fff;
        outline: none;
        box-shadow: 0px 2px 3px rgba(0, 0, 0, .4);
        transition: all .5s ease-in-out;
        line-height: 20px;
        width: 70px;
        font-size: 10pt;
        margin-bottom: 5px;
        margin-right: 2px;
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .movie_card #boton-mas:hover {
        transform: scale(.95) translateX(-5px);
        transition: all .5s ease-in-out;
    }

    .movie_card #boton-watchlist {
        cursor: pointer;
        border-style: none;
        background-color: #ff3838;
        color: #fff;
        outline: none;
        box-shadow: 0px 2px 3px rgba(0, 0, 0, .4);
        transition: all .5s ease-in-out;
        line-height: 20px;
        width: 30px;
        margin-right: 35px;
        position: absolute;
        top: 0;
        right: 0;
    }

    .movie_card #boton-watchlist:hover {
        transform: scale(.95) translateX(-5px);
        transition: all .5s ease-in-out;
    }

    .movie_card #boton-favorites {
        cursor: pointer;
        border-style: none;

        background-color: #ff3838;
        color: #fff;
        outline: none;
        box-shadow: 0px 2px 3px rgba(0, 0, 0, .4);
        transition: all .5s ease-in-out;
        line-height: 20px;
        width: 30px;


        position: absolute;
        top: 0;
        right: 0;
    }

    .movie_card #boton-favorites:hover {
        transform: scale(.95) translateX(-5px);
        transition: all .5s ease-in-out;
    }
    </style>
    <title>All movies</title>
</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="main.php">
                    <img src="./assets/images/icon.png" width="24px" height="24px" alt="logo">MovieList
                </a> -->
            <a class="navbar-brand" href="main.php">MovieList</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                    <li class="nav-item">
                        <a class="nav-link active" href="main.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="all_movies.php">Películas</a>
                    </li>
                    <?php if (!empty($_SESSION['user_id'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="watchlist.php">Películas Vistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas deseadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>
                    <?php } ?>

                </ul>
                <form class="d-flex justify-content-end ms-2">
                    <input class="form-control me-2 my-input" label="boton-search" type="text"
                        placeholder="Ejemplo: Sonic" name="query" required />
                    <button class="btn btn-primary btn-search" id="boton-search" type="submit"
                        value="Search">Buscar</button>
                    <?php if (empty($_SESSION['user_id'])) {
                    ?>
                    <a class="btn btn-success btn-signin ms-2" href="login.php" role="button">Iniciar</a>
                    <a class="btn btn-danger btn-signout ms-2" href="register.php" role="button">Registrate</a>

                    <?php } else { ?>
                    <ul class="navbar-nav bg-dark"">
                            <li class=" nav-item dropdown ms-2">
                        <a href="#" class="nav-link dropdown-toggle bg-dark" data-bs-toggle="dropdown"
                            id="navbarDropdownMenuLink" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php
                                        $query = "SELECT profile_image FROM tuser WHERE id = " . $_SESSION['user_id'] ;
                                        $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
                                        $row = mysqli_fetch_array($result);
                                        $profile_image = $row['profile_image'];

                                        if(empty($profile_image)){
                                            $profile_image = "default-user.png";
                                            echo "<img width='35' height='35' class='rounded-circle' src='assets/images/".$profile_image."' >" ;
                                        }else{ 
                                            echo "<img width='35' height='35' class='rounded-circle' src='assets/imagenesUsuario/".$row['profile_image']."' >" ; 
                                        }
                                    ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="profile.php">Panel</a>
                            <a class="dropdown-item" href="edit_profile.php">Editar
                                perfil</a>
                            <a class="dropdown-item" href="logout.php">Log Out</a>
                        </div>
                        </li>
                    </ul>
                    <?php } ?>
                </form>
            </div>
        </div>
    </nav>

    <div class="cards-container card-resp col mt-2 ">
        <div class="container-fluid">
            <div class="row default-row mt-1 mb-1" id="row-1">
                <div class="col-md-2 col-xs-5">
                    <div class="list-group list-group-light mb-5 mt-5">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                            enctype="multipart/form-data">
                            <button type="button" class="list-group-item list-group-item-action  px-3 border-0 active"
                                aria-current="true">
                                TODOS LOS GÉNEROS
                            </button>
                        
                            <button type="submit" name="btCrimen"
                                class="list-group-item list-group-item-action px-3 border-0" >Crimen</button>
                            <button type="submit" name="btComedia"
                                class="list-group-item list-group-item-action px-3 border-0">Comedia</button>
                            <button type="submit" name="btSuspense"
                                class="list-group-item list-group-item-action px-3 border-0">Suspense</button>
                            <button type="submit" name="btAccion"
                                class="list-group-item list-group-item-action px-3 border-0">Acción</button>
                            <button type="submit" name="btDrama"
                                class="list-group-item list-group-item-action px-3 border-0">Drama</button>
                            <button type="submit" name="btAventuras"
                                class="list-group-item list-group-item-action px-3 border-0">Aventuras</button>
                            <button type="submit" name="btCienciaFiccion"
                                class="list-group-item list-group-item-action px-3 border-0">Ciencia  ficción</button>
                            <button type="submit" name="btTerror"
                                class="list-group-item list-group-item-action px-3 border-0">Terror</button>
                            <button type="submit" name="btMonstruos"
                                class="list-group-item list-group-item-action px-3 border-0">Monstruos</button>
                            <button type="submit" name="btSuperheroes"
                                class="list-group-item list-group-item-action px-3 border-0">Superhéroes</button>
                            <button type="submit" name="btFantasiaOscura"
                                class="list-group-item list-group-item-action px-3 border-0">Fantasía  oscura</button> 
                            <button type="submit" name="btFantasia"
                                class="list-group-item list-group-item-action px-3 border-0">Fantasía</button>
                            <button type="submit" name="btMisterio"
                                class="list-group-item list-group-item-action px-3 border-0">Misterio</button>
                            <button type="submit" name="btEspionaje"
                                class="list-group-item list-group-item-action px-3 border-0">Espionaje</button>
                            </from>
                    </div>
                </div>
               
                <?php include "do_genre.php"; ?>           
            </div>

        </div>
    </div>


    <footer class="bg-dark text-center text-white mt-3">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" facebook" src="./assets/images/facebook.png">
                </a>

                <!-- Twitter -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" twitter" src="./assets/images/gorjeo.png">
                </a>

                <!-- Tik Tok -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" twitter" src="./assets/images/tik-tok.png">
                </a>

                <!-- Instagram -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" instagram" src="./assets/images/instagram.png">
                </a>


                <!-- Github -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" github" src="./assets/images/github.png">
                </a>
            </section>
            <!-- Section: Social media -->
        </div>


        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a class="text-white" href="#">MovieList</a>
        </div>
        <!-- Copyright -->
    </footer>

 
   
    
</body>
<script>
    if (window.history.replaceState) { // verificamos disponibilidad
    window.history.replaceState(null, null, window.location.href);
}
</script>
</html>