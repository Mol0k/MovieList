<?php

    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    
    $mysqli = get_db_connection_or_die();
    
    $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
    <link rel="stylesheet" href="./assets/css/profile.css">
    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="#">
    <title>Películas</title>
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
    
</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">


    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?> 

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
                <!-- Incluir el do_genre para mostrar las películas -->
                <?php include "do_genre.php"; ?>           
            </div>

        </div>
    </div>


    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?> 
    <!-- Incluir el popup -->
    <?php include_once "./inc/popup_uPassword.php"; ?> 
    <?php include_once "./inc/popup_uProfile.php"; ?>       

</body>


    <script>
        if (window.history.replaceState) { // verificamos disponibilidad
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

</html>