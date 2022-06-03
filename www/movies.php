<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    
    $mysqli = get_db_connection_or_die();
    //LO COMENTE PORQUE SALE ERROR DE QUE NO ESTA DEFINIDO
    // $user_id = $_SESSION['user_id'];

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }
    //CONSULTA PARA COMPROBAR SI UN USUARIO ES ADMIN O UN USUARIO NORMAL
    // $consult_admin = "SELECT roles FROM tuser WHERE id = " .$_SESSION['user_id'];
    // $result_admin = mysqli_query($mysqli, $consult_admin) or die(mysqli_error($mysqli));
    // $admin = mysqli_fetch_array($result_admin);
    $ruta_absoluta = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
   
    <link rel="stylesheet" href="./assets/css/style_comment.css">
    <link rel="stylesheet" href="./assets/css/profile.css">
    <link rel="shortcut icon" href="#">
    <style>
        .container {
            max-width: 1800px;
        }
        /* body{
            font-family: 'Roboto Slab', serif;
        } */
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

    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?>

    <div class="container text-light">
        <div class="row default-row mt-1 mb-1" id="row-2">
            <?php
            if (!isset($_GET['id'])) {
                die('No se ha especificado un juego');
            }
                $movie_id = $_GET['id'];
                $consult_movies = 'SELECT * FROM tmovie WHERE id='.$movie_id;
                $result_movies = mysqli_query($mysqli, $consult_movies) or die('Query error');
                while($fila = mysqli_fetch_array($result_movies)){?>
                <?php $generos= unserialize($fila['gender']);?>
                
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 mt-4 movie_style">
                            <img style='width:100%;' src='assets/imagenesPortada/<?php echo $fila['image']?>' >
                        </div>
                        <div class="col-md-7 mt-3">
                            <h1><?php echo $fila['title']?></h1>
                            <p ><?php echo $fila['sinopsis']?></p>
                            <?php 
                            //Formatear fechas
                            date_default_timezone_set('Europe/Madrid');
                            setlocale(LC_TIME, 'es_ES.UTF-8');
                            //DEPRECATED EN LA VERSIÓN 8 DE PHP strftime
                            // $date= strftime("%x", strtotime($fila['created'])); 
                            $date = date_create($fila['created']);
                            ?>
                            <p>Estreno: <?php echo date_format($date, 'd-m-Y');?></p>
                            <p>Duración: <?php echo $fila['duration']?></p>
                            <h4>Géneros: </h4>
                            <?php  foreach($generos as $genero){ ?>
                            <p class="mb-1"><?php echo $genero?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row row-cols-auto">
                        <div class="col mt-2">
                            <form action="add_to_watchlist.php?id=<?php echo $fila['id']?>" method="post">
                            <input type="hidden" name="return" value="<?php $ruta_absoluta ?>">
                            <?php
                                $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                                $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                                $stmt_watchlist -> bind_param("ii", $user_id, $fila['id']);
                                $stmt_watchlist -> execute();
                                $result_watchlist = $stmt_watchlist->get_result();
                                $row_watchlist = $result_watchlist->fetch_array(); 
                            
                            if(!empty($row_watchlist)){?>  
                                <button  type="submit" class="btn btn-danger "> <i class="fa-solid fa-check"> </i> Quitar de la watchlistt</button>
                            <?php 
                            } else { 
                            ?>
                            <button  type="submit" class="btn btn-primary "> <i class="fa-solid fa-circle-plus fa-beat"> </i> Añadir a la watchlist</button>
                            <?php
                            } 
                            ?>    
                            </form>
                        </div>
                        <div class="col mt-2">
                            <form action="add_to_favorites.php?id=<?php echo $fila['id']?>" method="post">
                            <input type="hidden" name="return_favorites" value=" <?php echo $ruta_absoluta ?>"> 
                            <?php 
                                $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                                $stmt_favorites = $mysqli ->prepare($exist_favorites);
                                $stmt_favorites -> bind_param("ii", $user_id, $fila['id']);
                                $stmt_favorites -> execute();
                                $result_favorites = $stmt_favorites->get_result();
                                $row_favorites = $result_favorites->fetch_array();
                            if(!empty($row_favorites)){?>    
                                <button  type="submit" class="btn btn-danger"><i class="fa-solid fa-heart-circle-minus"> </i> Quitar de favoritos</button>
                            <?php 
                            } else { 
                            ?>
                                <button  type="submit" class="btn btn-secondary"><i class="fa-solid fa-heart-circle-plus fa-beat"> </i> Añadir a favoritos</button>
                            <?php
                            } 
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
                
                <?php } ?>

            <?php
            // COMPROBAR SI YA LA TIENE EN LA WHATCHLIST
            // if(empty($_POST['user_id'])){
            //     $user_id = $_SESSION['user_id'];
            // }
            // $movie_id = $_GET['id'];
            // $exist = "SELECT * FROM `twatchlist` WHERE usuario_id = ? AND movie_id = ?";
            // $stmt_2 = $mysqli ->prepare($exist);
            // $stmt_2 -> bind_param("ii", $user_id, $movie_id);
            // $stmt_2 -> execute();
            // $result_2 = $stmt_2->get_result();
            // $row = $result_2->fetch_array();
            // if (!empty($_SESSION['user_id'])) {
            //     if(!empty($row)){
            //         echo  '<p class="text-danger mt-2"> Ya la tienes en la watchlist</p>';
            //     } else{
            //         echo '<p> No la tienes en la watchlist</p>';
            //     }
            // }
            ?>

            <!-- MENSAJES DE TEXTO DE LA WATCHLIST -->
           
            <?php if(isset($_SESSION['no_logueado_Watchlist'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php echo $_SESSION['no_logueado_Watchlist']; ?>
            </div>
            <?php
                unset($_SESSION['no_logueado_Watchlist']);
            }?>

            <!-- MENSAJES DE TEXTO DE FAVORITOS -->
            
            <?php if(isset($_SESSION['no_logueado_favorites'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php echo $_SESSION['no_logueado_favorites']; ?>
            </div>
            <?php
                    unset($_SESSION['no_logueado_favorites']);
            }?>

            <section>
                <div class="row">
                    <div class="col-sm-5 col-md-6 col-12 pb-4" >
                        <h1 class="mt-2">Comentarios</h1>
                        <?php
                        
                        $query3 = 'SELECT *, tuser.username, tuser.profile_image FROM  tcomentarios INNER JOIN tuser ON tcomentarios.usuario_id = tuser.id 
                        INNER JOIN tmovie  ON tcomentarios.movie_id = tmovie.id  WHERE movie_id = '.$movie_id;
                        $result3 = mysqli_query($mysqli, $query3) or die('Query error');

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
                            <h4>
                                <?php echo $row['username'] ?>
                            </h4>
                            <span>
                            <?php 
                                //formatear fecha
                                date_default_timezone_set('Europe/Madrid');
                                setlocale(LC_TIME, 'spanish');
                                //DEPRECATED EN LA VERSIÓN 8 DE PHP strftime
                                // $date= strftime("%c", strtotime($row['fecha_comentario']));
                                // echo $date;
                                $date = date_create($row['fecha_comentario']);
                                echo date_format($date, 'd-m-Y H:i:s');
                            ?>
                            </span>
                            <br>
                            <p>
                                <?php echo $row['comentario'] ?>
                            </p>
                                <?php if($row['usuario_id'] == $user_id) {?>
                                <form  id= "algin-form" action="del_comment.php?id=<?php echo $movie_id?>" method="post">
                                    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                                    <button type="submit" value="Borrar" class="btn btn-danger">Borrar comentario</button>
                                <?php } ?>
                            </form>
                        </div>
                        <?php }?>
                    
                    </div>


                    <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                        <?php if(isset($_SESSION['error_coment'])){?>
                        <div class="alert alert-danger text-center mt-0" style="margin-top:20px;"> <?php echo $_SESSION['error_coment']; ?> </div>
                        <?php unset($_SESSION['error_coment']);}?>
                        <?php if(isset($_SESSION['duplicado_coment'])){?>
                        <div class="alert alert-danger text-center mt-0" style="margin-top:20px;"><?php echo $_SESSION['duplicado_coment']; ?> </div>
                        <?php  unset($_SESSION['duplicado_coment']);}?> 
                        <form id="algin-form" action="do_comment.php" method="post">
                            <div class="form-group" id="form-comment">
                                <h4>Deja tu comentario</h4>
                                <label for="message">Mensaje</label>
                                <textarea name="new_comment" id="" msg cols="30" rows="5" class="form-control  text-light" maxlength="100" style="background-color: #212529 ;"></textarea>
                            </div>
                            <div class="form-group" id="form-comment-div">
                                <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                                <button type="submit" value="Comentar" class="btn btn-primary mt-2 p-2 mb-4">Comentar</button>
                                <!-- ANTES ESTABAN AQUI LOS MENSAJES DE ERROR -->
                            </div>
                        </form>  
                    </div>
                </div>
            </section>
        </div>
    </div>
    


    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?>
    <!-- Incluir el popup -->
    <?php include_once "./inc/popup_uPassword.php"; ?> 
    <?php include_once "./inc/popup_uProfile.php"; ?>


</body>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

    <script>
        if (window.history.replaceState) { // verificamos disponibilidad
            window.history.replaceState(null, null, window.location.href);
        }   
    </script>

</html>