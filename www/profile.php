<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();


$user_id = $_SESSION['user_id'];
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
$sql = "SELECT * FROM tuser WHERE id = '".$user_id."'";
	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc();
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


    <title>Perfil de usuario</title>

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
                        <a class="nav-link" href="#">Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="watchlist.php">Películas Vistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorites.php">Películas favoritas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>

                </ul>
                <form class="d-flex justify-content-end ms-2" action="backend-search.php" method="GET">
                <input class="form-control me-2 my-input" label="boton-search" type="text" placeholder="Ejemplo: Sonic" name="query" required />
		            <button class="btn btn-primary btn-search" id="boton-search" type="submit" value="Search">Buscar</button>
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
                                $query = "SELECT * FROM tuser WHERE id = " . $_SESSION['user_id'] ;
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



    <div class="cards-container card-resp">
        <?php 
         $name = "SELECT username, profile_image FROM tuser WHERE id = " . $user_id ;
         $result2 = mysqli_query($mysqli, $name) or die(mysqli_error($mysqli));
         $row2 = mysqli_fetch_array($result2);
            echo '<p class="text-light">Hola que tal estas ' . $row['username'] . ' </p>';
            $profile_image2 = $row2['profile_image'];

            if(empty($profile_image2)){
                $profile_image2 = "default-user.png";
                    echo "<img width='100' height='100'  src='assets/images/".$profile_image2."' >" ;
            }else{ 
                echo "<img width='100' height='100'  src='assets/imagenesUsuario/".$row2['profile_image']."' >" ; 
            }
           
        
        ?>
    </div>
    
    <footer class="bg-dark text-center text-white fixed-bottom">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    <script src="scripts.js"></script>
    <script src="assets/js/script_contra.js"></script>

</body>

</html>