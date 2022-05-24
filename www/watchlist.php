<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();
$user_id = $_SESSION['user_id'];
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

if(isset($_POST['records-limit'])){
    $_SESSION['records-limit'] = $_POST['records-limit'];
}

$limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 10;
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

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>WatchList</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./assets/css/styles.css"> -->
    <style>
    .quitar {
        text-decoration: none;
    }

    .movie_style #boton-cerrar {
        cursor: pointer;
        border-style: none;
        transition: all .5s ease-in-out;
        position: absolute;
		top: 0;
		right: 0;
    }
	
    .movie_style #boton-cerrar:hover {
        transform: scale(.95) translateX(1px);
        transition: all .5s ease-in-out;
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
                    <li class="nav-item">
                        <a class="nav-link" href="watchlist.php">Películas Vistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas deseadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>

                </ul>
                <form class="d-flex justify-content-end ms-2" action="backend-search.php" method="GET">

                    <input class="form-control me-2 my-input" type="text" placeholder="Enter your search term"
                        name="query" required>
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
                                            echo "<img width='35' height='35' alt='profile_image' class='rounded-circle' src='assets/images/".$profile_image."' >" ;
                                        }else{ 
                                            echo "<img width='35' height='35'alt ='default_image' class='rounded-circle' src='assets/imagenesUsuario/".$row['profile_image']."' >" ; 
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
    <?php


	$query3 = 'SELECT * FROM tmovie INNER JOIN twatchlist ON tmovie.id = twatchlist.movie_id INNER JOIN tuser ON twatchlist.usuario_id = tuser.id where twatchlist.usuario_id = ' . $user_id;		
	$res = mysqli_query($mysqli, $query3);
	
	?>
    <div class='cards-container card-resp'>
        <h2 class="text-center text-light mt-5 me-2 ">PELICULAS VISIONADAS</h2>
        <div class='container-fluid'>
            <div class="row default-row mt-5 mb-1" id="row-1">
                <div class='container mt-2'>
                    <div class='row justify-content-center wrapperino' id='foco'>
                        <?php while($fila = mysqli_fetch_assoc($res)){?>
                        <div class='movie_style'>
						
                            <?php
							 echo "<a style='text-decoration: none;color:black' href='movies.php?id=".$fila['movie_id']."'><img  alt= 'borrar'style='width:100%' src='assets/imagenesPortada/".$fila['image']."' ></a>";
							 echo "
							 <form method='post' action='del_watchlist.php?id=".$fila['movie_id']."' >
							 <button id='boton-cerrar' ><img src='assets/images/x-button.png'></button>
							 </form>";		
                           ?>
							
                        </div>
                        <?php } 
							?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <nav aria-label="Page navigation example mt-5">
        <ul class="pagination justify-content-center mt-4 my-5" style="scroll-behavior: smooth;">
            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "
                                    ?page=" . $prev; } ?>">Previous</a>
            </li>
            <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a class="page-link" href="watchlist.php?page=<?= $i; ?>">
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

    <footer class="bg-dark text-center text-white  ">
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