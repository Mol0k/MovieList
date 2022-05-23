<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    
    $mysqli = get_db_connection_or_die();
    //LO COMENTE PORQUE SALE ERROR DE QUE NO ESTA DEFINIDO
    // $user_id = $_SESSION['user_id'];

    if(isset($_POST['user_id'])){
        $user_id = $_SESSION['user_id'];
    }


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./assets/css/styles.css"> -->
    <link rel="stylesheet" href="./assets/css/style_comment.css">
    <link rel="shortcut icon" href="#">
    <style>
    .container {
        max-width: 1800px;
    }

    .movie_style {
        padding: 0 !important;
        width: 18.9rem;
        margin: 14px;
        position: relative;
        background: #fff;
        border: 2px solid #fff;
        box-shadow: 0px 4px 7px rgba(0, 0, 0, .5);

        transition: all .5s cubic-bezier(.8, .5, .2, 1.4);
        overflow: hidden;
        height: 440px;
    }
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
                <form class="d-flex justify-content-end ms-2" action="backend-search.php" method="GET">
                    <input class="form-control me-2 my-input" type="text" placeholder="Ejemplo: Sonic" name="query">
                    <button class="btn btn-primary btn-search" type="submit" value="Search">Buscar</button>
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
            if (!isset($_GET['id'])) {
                die('No se ha especificado un juego');
            }
                $movie_id = $_GET['id'];
                $query2 = 'SELECT * FROM tmovie WHERE id='.$movie_id;
                $result2 = mysqli_query($mysqli, $query2) or die('Query error');
                while($fila = mysqli_fetch_array($result2)){
                    $variable= unserialize($fila['gender']); 
                    echo '<div class="container">';
                    echo '<div class="row">';
                    echo '<div class="col-md-3 mt-4 movie_style">';
                    echo "<img style='width:100%;' src='assets/imagenesPortada/".$fila['image']."' >";
                    echo '</div>';
                    echo '<div class="col-md-7 mt-3">';
                    echo '<h1>'.$fila['title'].'</h1>';   
                    echo '<p >'.$fila['sinopsis'].'</p>';
                    echo '<p>Fecha de lanzamiento: '.$fila['created'].'</p>';
                    echo '<p>Duración: '.$fila['duration'].' </p>';
                    echo '<h4>Géneros: </h4>';
                    foreach($variable as $value){
                        echo '<p class="mb-1">'.$value.' </p>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    if(empty($_SESSION['user_id'])){
                        echo '<div class="container">';
                        echo '<div class="row">';
                        echo '<div class="col-md-12 mt-4">';
                        echo '<h4>Para poder agregar la película a la watchlist debes iniciar sesión o registrarte.</h4>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="container">';
                        echo '<div class="row row-cols-auto">';
                        echo '<div class="col mt-2 ">';
                        echo '<form  method="post" action="add_to_watchlist.php?id='.$fila['id'].'" >';
                        echo '<button  type="submit" class="btn btn-primary me-2"> AÑADIR A LA WATCHLIST</button>';   
                        echo '</form>';
                        echo '</div>';
                        echo '<div class="col mt-2">';
                        echo '<form  method="post" action="" >';
                        echo '<button  type="submit" class="btn btn-danger"> AÑADIR A DESEADOS</button>';   
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        
                        
                    }
                }
            ?>

            <section>
                <div class="row">
                    <div class="col-sm-5 col-md-6 col-12 pb-4">
                        <h1 class="mt-2">Comentarios</h1>
                        <?php
                             //  $query3 = 'SELECT * FROM tComentarios WHERE movie_id='.$movie_id; 
                            // $query3 = 'SELECT *, tuser.username, tuser.profile_image from tcomentarios INNER JOIN tuser ON tcomentarios.usuario_id = tuser.id';
                            $query3 = 'SELECT *, tuser.username, tuser.profile_image FROM  tcomentarios INNER JOIN tuser ON tcomentarios.usuario_id = tuser.id 
                            INNER JOIN tmovie  ON tcomentarios.movie_id = tmovie.id  WHERE movie_id = '.$movie_id;
                            $result3 = mysqli_query($mysqli, $query3) or die('Query error');
                           
                        ?>
                        <?php  
                        while ($row = mysqli_fetch_array($result3)) {?>
                        <div class="comment mt-4 text-justify float-left">
                            <?php 
                                $profile_image = $row['profile_image'];
                          
                                if(empty($profile_image)){
                                    $profile_image = "default-user.png";
                                    echo "<img width='35' height='35' class='rounded-circle' src='assets/images/".$profile_image."' >" ;
                                }else{ 
                                    echo "<img width='35' height='35' class='rounded-circle' src='assets/imagenesUsuario/".$row['profile_image']."' >" ; 
                                }
                                
                            ?>
                            <h4><?php echo $row['username'] ?></h4>
                            <span><?php echo $row['fecha_comentario'] ?></span>
                            <br>
                            <p><?php echo $row['comentario'] ?></p>
                        </div>
                        <?php }
                     mysqli_close($mysqli);?>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                        <form id="algin-form" action="comment.php" method="post">
                            <div class="form-group" id="form-comment">
                                <h4>Deja tu comentario</h4>
                                <label for="message">Mensaje</label>
                                <textarea name="new_comment" id="" msg cols="30" rows="5"
                                    class="form-control  text-light" style="background-color: #212529 ;"></textarea>
                            </div>


                            <div class="form-group" id="form-comment-div">
                                <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                                <button type="submit" value="Comentar"
                                    class="btn btn-primary mt-2 p-2 mb-4">Comentar</button>
                                <?php if(isset($_SESSION['error'])){
                                ?>
                                <div class="alert alert-danger text-center" style="margin-top:20px;">
                                    <?php echo $_SESSION['error']; ?>
                                </div>
                                <?php
                                    unset($_SESSION['error']);
                                }?>
                            </div>
                        </form>
                    </div>
                </div>

            </section>

        </div>

    </div>

    </div>


    <footer class="bg-dark text-center text-white ">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn  btn-floating m-1 " href="https://facebook.com/">
                    <img alt=" facebook" src="./assets/images/facebook.png">
                </a>

                <!-- Twitter -->
                <a class="btn  btn-floating m-1 " href="https://twitter.com/Mol0k/">
                    <img alt=" twitter" src="./assets/images/gorjeo.png">
                </a>

                <!-- Tik Tok -->
                <a class="btn  btn-floating m-1 " href="https://tiktok.com/">
                    <img alt=" twitter" src="./assets/images/tik-tok.png">
                </a>

                <!-- Instagram -->
                <a class="btn  btn-floating m-1 " href="https://instagram.com">
                    <img alt=" instagram" src="./assets/images/instagram.png">
                </a>


                <!-- Github -->
                <a class="btn  btn-floating m-1 " href="https://github.com/Mol0k/MovieList/">
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

</body>

</html>