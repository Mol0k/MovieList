<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

    session_start();
	$mysqli = get_db_connection_or_die();

    if(isset($_POST['user_id'])){
        $user_id = $_SESSION['user_id'];
    }

    if(isset($_POST['records-limit'])){
        $_SESSION['records-limit'] = $_POST['records-limit'];
    }
    
    $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 5;
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
    $paginationStart = ($page - 1) * $limit;
    
    $movies = $mysqli->query("SELECT * FROM tmovie ORDER BY id ASC LIMIT $paginationStart, $limit")->fetch_all(MYSQLI_ASSOC);
    // Obtenemos el total
    $sql = $mysqli->query("SELECT count(id) AS id FROM tmovie")->fetch_all(MYSQLI_ASSOC);
    $allRecrods = $sql[0]['id'];
    
    // Calculamos el total de páginas
    $totoalPages = ceil($allRecrods / $limit);
    // Anterior y posterior
    $prev = $page - 1;
    $next = $page + 1;

    //Para consultar el id de la movie
    $consult = "SELECT * FROM tmovie;"; 
    $resultado = mysqli_query($mysqli, $consult) or die(mysqli_error($mysqli));
    $consultid = mysqli_fetch_array($resultado);
    
    //COGER LA RUTA ABSOLUTA
    $ruta_absoluta = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if(isset($_SESSION['user_id'])){
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
    <link rel="stylesheet" href="./assets/css/styles.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/style_main.css" type="text/css"> 
    <link rel="stylesheet" href="./assets/css/profile.css" type="text/css">

    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="#">
    <title>MovieList</title>
     <script src="./assets/js/scrollToTop.js"></script>
</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">

   
    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?> 

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/popcorn.jpg" class="bd-placeholder-img" alt="popcorn" width="100%" height="100%"
                    aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">

                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>My MovieList.</h1>
                        <p>Registrate para añadir tus películas favoritas.</p>
                        <p><a class="btn btn-lg btn-primary" href="register.php">Registrate ahora</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/imagen11.jpg" class="bd-placeholder-img" width="100%" height="100%"
                    aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" alt="popcorn">

                <div class="container">
                    <div class="carousel-caption">
                        <h1>WatchList.</h1>
                        <p>Añade tus películas a la WatchList.</p>
                        <p><a class="btn btn-lg btn-primary" href="watchlist.php">Watchlist</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/imagen7.jpg" class="bd-placeholder-img" alt="popcorn" width="100%"
                    height="100%">

                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>Inicia sesión.</h1>
                        <p>Inicia sesión y disfruta de todas las funcionalidades.</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="cards-container card-resp">
        <h2 class="text-center text-light ">PELÍCULAS POPULARES</h2>
        <!-- Quitar el fluid  -->
        <div class="container-fluid">
            <!-- Quitar el row default-row -->
            <div class="row default-row mt-1 mb-1" id="row-1">
                <div class="container mt-5">
                    <!-- DIV -->
                    
                    <div class="row justify-content-center wrapperino" id="foco">
                    <?php foreach($movies as $movie): ?>        
                        <div class="movie_card">
                            <?php echo "<img   src='assets/imagenesPortada/".$movie['image']."' >" ?>
                            <div class="descriptions">
                                <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $movie['title']; ?>  </h3>
                                <p style="line-height: 20px;height: 70%;">  <?php echo $movie['sinopsis']; ?></p>
                                <button id='boton-mas'>
                                    <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $movie['id'];?>">Mas info</a>
                                </button>
                                <?php  if(!empty($_SESSION['user_id'])){ ?>

                                <form  method="post" action="add_to_watchlist.php?id=<?php echo $movie['id'] ?>" >    
                                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                                    <?php
                                        //Esta consulta es para comprobar si el usuario tiene en la watchlist la pelicula y si es asi se cambiara el boton a check
                                        //$consult_vision = "SELECT * from twatchlist INNER JOIN tmovie ON twatchlist.movie_id = tmovie.id WHERE usuario_id = '.$user_id.'"; 
                                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                                        $stmt_watchlist -> bind_param("ii", $user_id, $movie['id']);
                                        $stmt_watchlist -> execute();
                                        $result_watchlist = $stmt_watchlist->get_result();
                                        $row_watchlist = $result_watchlist->fetch_array();          
                                    if(!empty($row_watchlist)){?>                                            
                                        <button class="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                                    <?php 
                                    } else { 
                                    ?>
                                        <button class="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                                    <?php
                                    } 
                                    ?>        
                                </form>
                                <form  method="post" action="add_to_favorites.php?id=<?php echo $movie['id'] ?>" >
                                    <input type="hidden" name="return_favorites" value=" <?php echo $ruta_absoluta ?>"> 

                                    <?php 
                                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                                        $stmt_favorites -> bind_param("ii", $user_id, $movie['id']);
                                        $stmt_favorites -> execute();
                                        $result_favorites = $stmt_favorites->get_result();
                                        $row_favorites = $result_favorites->fetch_array();
                                    if(!empty($row_favorites)){?>    
                                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos" class="fa-solid fa-heart-circle-minus"> </i> </button>
                                    <?php 
                                    } else { 
                                    ?>
                                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos" class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                                    <?php
                                    } 
                                    ?>
                                    
                                </form>
                                <?php } ?>
                            </div>                            
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="Page navigation example mt-5">
                        <ul class="pagination justify-content-center" style="scroll-behavior: smooth;">
                            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "
                                    ?page=" . $prev; } ?>">Anterior</a>
                            </li>
                            <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                                <a class="page-link" href="index.php?page=<?= $i; ?>">
                                    <?= $i; ?>
                                </a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "
                                    ?page=". $next; } ?>">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>
    <button onclick="topFunction()" id="botonScroll" title="Ir hacia arriba"><i class="fa-solid fa-angle-up"></i></button>
    <!-- Incluir popup registrado -->
    <?php include "./inc/popup_registrado.php"; ?>  
    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?>
    <!-- Incluir el popup -->
    <?php include "./inc/popup_uPassword.php"; ?> 
    <?php include "./inc/popup_uProfile.php"; ?>   
    
</body>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!-- Script para que el usuario pueda ir hacia arriba dandole a un botón -->
    <script src="./assets/js/scrollToTop.js"></script>
    <script>
        //Cuando el usuario entre en la página principal el div que muestra las películas cogerá el foco.
        //Solo se ejecutará cuando el tamaño sea mayor a 767px osea solo para pc.
        const foco = document.getElementById('foco');
        // foco.scrollIntoView(true);
        if(screen.width > 767){
            foco.scrollIntoView({
            block: 'center',
        });
        }
        
    </script>

    <script>
        $(document).ready(function() {
            $('#records-limit').change(function() {
                $('form').submit();
            })
        });
    </script>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
</html>
