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
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="shortcut icon" href="#">
    <style>
        /* .container {
            max-width: 1800px;
        } */

        /* @media(min-width:568px) {
            .end {
                margin-left: auto;
            }
        }

        @media(max-width:768px) {
            #post {
                width: 100%;
            }
        }

        #clicked {
            padding-top: 1px;
            padding-bottom: 1px;
            text-align: center;
            width: 100%;
            background-color: #ecb21f;
            border-color: #a88734 #9c7e31 #846a29;
            color: black;
            border-width: 1px;
            border-style: solid;
            border-radius: 13px;
        }

        #profile {
            background-color: unset;

        }

        #post {
            margin: 10px;
            padding: 6px;
            padding-top: 2px;
            padding-bottom: 2px;
            text-align: center;
            background-color: #ecb21f;
            border-color: #a88734 #9c7e31 #846a29;
            color: black;
            border-width: 1px;
            border-style: solid;
            border-radius: 13px;
            width: 50%;
        }

        body {
            background-color: black;
        }

        #nav-items li a,
        #profile {
            text-decoration: none;
            color: rgb(224, 219, 219);
            background-color: black;
        }


        .comments {
            margin-top: 5%;
            margin-left: 20px;
        }

        .darker {
            border: 1px solid #ecb21f;
            background-color: black;
            float: right;
            border-radius: 5px;
            padding-left: 40px;
            padding-right: 30px;
            padding-top: 10px;
        }

        .comment {
            border: 1px solid rgba(16, 46, 46, 1);
            background-color: rgba(16, 46, 46, 0.973);
            float: left;
            border-radius: 5px;
            padding-left: 40px;
            padding-right: 30px;
            padding-top: 10px;

        }

        .comment h4,
        .comment span,
        .darker h4,
        .darker span {
            display: inline;
        }

        .comment p,
        .comment span,
        .darker p,
        .darker span {
            color: rgb(184, 183, 183);
        }

        h1,
        h4 {
            color: white;
            font-weight: bold;
        }

        label {
            color: rgb(212, 208, 208);
        }

        #align-form {
            margin-top: 20px;
        }

        .form-group p a {
            color: white;
        }

        #checkbx {
            background-color: black;
        }

        #darker img {
            margin-right: 15px;
            position: static;
        }

        .form-group input,
        .form-group textarea {
            background-color: black;
            border: 1px solid rgba(16, 46, 46, 1);
            border-radius: 12px;
        }

        form {
            border: 1px solid rgba(16, 46, 46, 1);
            background-color: rgba(16, 46, 46, 0.973);
            border-radius: 5px;
            padding: 20px;
        } */
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
            if (!isset($_GET['id'])) {
                die('No se ha especificado un juego');
            }
                $movie_id = $_GET['id'];
                $query2 = 'SELECT * FROM tmovie WHERE id='.$movie_id;
                $result2 = mysqli_query($mysqli, $query2) or die('Query error');
                while($fila = mysqli_fetch_array($result2)){
                    $variable= unserialize($fila['gender']);  
                    echo '<h1>'.$fila['title'].'</h1>';
                    echo "<img style='width:15%;' src='assets/imagenesPortada/".$fila['image']."' >";   
                    echo '<p>'.$fila['sinopsis'].'</p>';
                    echo '<p>'.$fila['created'].'</p>';
                    foreach($variable as $value){
                        echo '<p class="mb-1">'.$value.' </p>';
                    }
                    echo '<p>'.$fila['duration'].' </p>'; 
                }
            ?>
        </div>

        <div class="row default-row mt-1 mb-1" id="row-2">
            <h3 >Comentarios:</h3>
            <ul>
                <?php
                   $query3 = 'SELECT * FROM tComentarios WHERE movie_id='.$movie_id; 
                // $query3 = 'SELECT tcomentarios.comentario, tuser.username FROM tcomentarios INNER JOIN tuser ON tcomentarios.id=tuser.id where tuser.id = '.$user_id.' and movie_id= '.$movie_id. '';
                //   $sql = "SELECT especie.Nombre, animales.Animales FROM especie INNER JOIN animales ON especie.id=animales.IdEspecie where animales.IdEspecie=1";

                    $result3 = mysqli_query($mysqli, $query3) or die('Query error');
                    while ($row = mysqli_fetch_array($result3)) {
                    echo 
                    '<li> Comentario: '.$row['comentario']. ' || Fecha del comentario:  '.$row['fecha_comentario'].' || Nombre de usuario: </li>';
                    }
                mysqli_close($mysqli);
                ?>
            </ul>
            <br>
            <p>Deja un nuevo comentario:</p>
            <form action="/comment.php" method="post">
                <textarea rows="4" cols="50" name="new_comment"></textarea><br>
                <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                <input type="submit" value="Comentar">
            </form>
        </div>
        <!-- <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 col-md-6 col-12 pb-4">
                        <h1>Comentarios</h1>
                        <div class="comment mt-4 text-justify float-left">
                            <img src="https://i.imgur.com/yTFUilP.jpg" alt="" class="rounded-circle" width="40"
                                height="40">
                            <h4>Nombree</h4>
                            <span>FECHA</span>
                            <br>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic
                                aliquam vero sequi velit molestias doloremque molestiae dicta?</p>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                        <form id="algin-form">
                            <div class="form-group">
                                <h4>Leave a comment</h4>
                                <label for="message">Message</label>
                                <textarea name="msg" id="" msg cols="30" rows="5" class="form-control"
                                    style="background-color: black;"></textarea>
                            </div>


                            <div class="form-group">
                                <button type="button" id="post" class="btn">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section> -->
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