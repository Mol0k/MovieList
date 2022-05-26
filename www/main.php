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
  // Get total records
  $sql = $mysqli->query("SELECT count(id) AS id FROM tmovie")->fetch_all(MYSQLI_ASSOC);
  $allRecrods = $sql[0]['id'];
  
  // Calculate total pages
  $totoalPages = ceil($allRecrods / $limit);
  // Prev + Next
  $prev = $page - 1;
  $next = $page + 1;

  $consult = "SELECT * FROM tmovie;"; 
  $resultado = mysqli_query($mysqli, $consult) or die(mysqli_error($mysqli));
  $consultid = mysqli_fetch_array($resultado);
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
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="#">
    <title>MovieList</title>
    <style>
        .quitar{
            text-decoration:none;
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
            position:absolute;
            bottom:0;
            right:0;
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
    <?php include "header.php"; ?> 

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
                        <p>Registrate para añadir tus peliculas favoritas.</p>
                        <p><a class="btn btn-lg btn-primary" href="register.php">Registrate ahora</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/imagencarousel.jpg" class="bd-placeholder-img" width="100%" height="100%"
                    aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" alt="popcorn">

                <div class="container">
                    <div class="carousel-caption">
                        <h1>WatchList.</h1>
                        <p>Añade tus peliculas a la lista de WatchList.</p>
                        <p><a class="btn btn-lg btn-primary" href="watchlist.php">Leer más</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/popcorn.jpg" class="bd-placeholder-img" alt="popcorn" width="100%"
                    height="100%">

                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>Ayudanos.</h1>
                        <p>Inicia sesión y mandanos las peliculas que desees para agregarlas a la página.</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Explora</a></p>
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
        <h2 class="text-center text-light ">PELICULAS POPULARES</h2>
        <!-- Quitar el fluid  -->
        <div class="container-fluid">
            <!-- Quitar el row default-row -->
            <div class="row default-row mt-1 mb-1" id="row-1">
                <div class="container mt-5">
                    <!-- DIV -->
                    <!-- Esto es para cuando le doy click en la imagen que me vaya para otra pag -->
                    
                    <div class="row justify-content-center wrapperino" id="foco">
                        <?php foreach($movies as $movie): ?>
                        
                        <div class="movie_card">
                            <?php echo "<img   src='assets/imagenesPortada/".$movie['image']."' >" ?>
                            <div class="descriptions">
                                <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                                    <?php echo $movie['title']; ?>
                                    </h1>
                                    <p style="line-height: 20px;height: 70%;">
                                        <?php echo $movie['sinopsis']; ?>
                                    </p>
                                    <?php
                                    echo "<form method='post' action='movies.php?id=".$movie['id']."' >
                                    <button id='boton-mas'>Mas info</button>
                                    </form>";
                                    if(!empty($_SESSION['user_id'])){
                                    echo '<form  method="post" action="add_to_watchlist.php?id='.$movie['id'].'" >
                                    <input type="hidden" name="return" value=" '.$link.'"?>
                                    <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>
                                    </form>';
                                    echo '<form  method="post" action="add_to_favorites.php?id='.$movie['id'].'" >
                                    <button id="boton-favorites"> <i title="Agregar a favoritos"class="fa-solid fa-heart fa-beat"> </i> </button>
                                    </form>';
                                    }
                                    ?>                                 
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
                                <a class="page-link" href="main.php?page=<?= $i; ?>">
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
            <div class="row default-row mt-1 mb-1" id="row-2">
            </div>
        </div>
    </div>

    <!-- Incluir el footer -->
    <?php include "footer.php"; ?>  
    
</body>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    <script>
    const foco = document.getElementById('foco');

    // foco.scrollIntoView(true);
    foco.scrollIntoView({
        block: 'center',
    });
    </script>
    <script src="/assets/js/index.js" type="module"></script>
</html>