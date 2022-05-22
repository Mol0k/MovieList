<?php

    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    
    $mysqli = get_db_connection_or_die();

    // $query = "SELECT * FROM tmovie WHERE GENDER LIKE '%Crimen%'";
    // $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    // while($fila = mysqli_fetch_array($result)){
    //     $variable= unserialize($fila['gender']);  
    //     echo '<h1 class="text-light">'.$fila['title'].'</h1>';
    //     echo "<img style='width:15%;' src='assets/imagenesPortada/".$fila['image']."' >";   
    //     echo '<p class="text-light">'.$fila['sinopsis'].'</p>';
    //     echo '<p class="text-light" > '.$fila['created'].'</p>';
       
    //     echo '<p class="text-light">'.$fila['duration'].' </p>'; 
    // }
    
        
   
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="shortcut icon" href="#">
    <style>
        
    </style>
    <title>MovieList</title>
</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="main.php">
                    <img src="./assets/images/icon.png" width="24px" height="24px" alt="logo">MovieList
                </a> -->
            <a class="navbar-brand" href="#">MovieList</a>
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
                        <a class="nav-link" href="all_movies">Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas Vistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas deseadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>

                </ul>
                <form class="d-flex justify-content-end ms-2">
                    <input class="form-control me-2 my-input" type="search" placeholder="Buscar peliculas"
                        aria-label="Search">
                    <button class="btn btn-primary btn-search" type="submit">Buscar</button>
                    <?php if (empty($_SESSION['user_id'])) {
                    ?>
                    <button class="btn btn-success btn-signin ms-2" type="submit"
                        formaction="login.php">Iniciar</button>
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


    <div class="container text-light">
        <div class="row default-row mt-1 mb-1" id="row-2">
            <?php 
             $query = "SELECT * FROM tmovie WHERE GENDER LIKE '%Crimen%'";
             $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
            
            //  while($fila = mysqli_fetch_array($result)){
            //      $variable= unserialize($fila['gender']);  
            //      echo '<h1 class="text-light">'.$fila['title'].'</h1>';
            //      echo "<img style='width:15%;' src='assets/imagenesPortada/".$fila['image']."' >";   
            //      echo '<p class="text-light">'.$fila['sinopsis'].'</p>';
            //      echo '<p class="text-light" > '.$fila['created'].'</p>';
                
            //      echo '<p class="text-light">'.$fila['duration'].' </p>'; 
            //  }
            
            ?>

        <select class="select"  name="tipo_usuario" id="tipo_usuario"><br>
                <option value="0">Selecciona privilegios para este usuario</option>
                    <?php  while($fila = mysqli_fetch_array($result)) {?>
                        <option value="
                            <?php
                                $variable= unserialize($fila['gender']);  
                                echo '<h1 class="text-light">'.$fila['title'].'</h1>';
                                echo "<img style='width:15%;' src='assets/imagenesPortada/".$fila['image']."' >";   
                                echo '<p class="text-light">'.$fila['sinopsis'].'</p>';
                                echo '<p class="text-light" > '.$fila['created'].'</p>';
                                echo '<p class="text-light">'.$fila['duration'].' </p>';  ?>
                            ">
                    <?php }  ;?>
        </select>
        </div>
    </div>




    <footer class="bg-dark text-center text-white ">
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



    </div>

    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#records-limit').change(function() {
            $('form').submit();
        })
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <script src="/assets/js/index.js" type="module"></script>
</body>

</html>