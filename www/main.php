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
  $authors = $mysqli->query("SELECT * FROM tmovie ORDER BY id ASC LIMIT $paginationStart, $limit")->fetch_all(MYSQLI_ASSOC);
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
    <title>MovieList</title>
    <style>
        .quitar{
            text-decoration:none;
        }
        .movie_card button {
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
        
        .movie_card button:hover {
            transform: scale(.95) translateX(-5px);
            transition: all .5s ease-in-out;
        }
        </style>
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
                        <a class="nav-link" href="#">Películas</a>
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
                    
                    <input class="form-control me-2 my-input"type="text" placeholder="Ejemplo: Sonic" name="query">
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
                        <?php foreach($authors as $author): ?>
                        
                        <div class="movie_card">
                            <?php echo "<img   src='assets/imagenesPortada/".$author['image']."' >" ?>
                            <div class="descriptions">
                                <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                                    <?php echo $author['title']; ?>
                                    </h1>
                                    <p style="line-height: 20px;height: 70%;">
                                        <?php echo $author['sinopsis']; ?>
                                    </p>
                                    <?php
                                    echo "<form method='post' action='movies.php?id=".$author['id']."' >
                                    <button>Mas info</button>
                                    </form>"
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
                                    ?page=" . $prev; } ?>">Previous</a>
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
                                    ?page=". $next; } ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row default-row mt-1 mb-1" id="row-2">
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
</body>

</html>