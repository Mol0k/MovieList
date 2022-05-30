<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    $mysqli = get_db_connection_or_die();
    $user_id = $_SESSION['user_id'];
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
    }

    if(isset($_POST['records-limit-favorites'])){
        $_SESSION['records-limit-favorites'] = $_POST['records-limit-favorites'];
    }

    $limit = isset($_SESSION['records-limit-favorites']) ? $_SESSION['records-limit-favorites'] : 10;
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
    $paginationStart = ($page - 1) * $limit;

    $movies = $mysqli->query("SELECT * FROM tmovie ORDER BY id ASC LIMIT $paginationStart, $limit")->fetch_all(MYSQLI_ASSOC);
    // Obtenemos el total records
    $sql = $mysqli->query("SELECT count(id) AS id FROM tmovie")->fetch_all(MYSQLI_ASSOC);
    $allRecrods = $sql[0]['id'];

    // Calculamos el total de páginas
    $totoalPages = ceil($allRecrods / $limit);

    // Anteior y siguiente
    $prev = $page - 1;
    $next = $page + 1;

    //Consulta para buscar el id de la pelicula
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
    <link rel="stylesheet" href="./assets/css/profile.css">
    <link rel="stylesheet" href="./assets/css/style_favorites_watchlist.css">
    <style>
        .foter{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #f5f5f5;
            color: black;
            text-align: center;
        }
    </style>

</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">
    

    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?> 

    <?php
	$query3 = 'SELECT * FROM tmovie INNER JOIN tfavorites ON tmovie.id = tfavorites.movie_id INNER JOIN tuser ON tfavorites.usuario_id = tuser.id where tfavorites.usuario_id = ' . $user_id;		
	$res = mysqli_query($mysqli, $query3);
	
	?>
    <div class='cards-container card-resp'>
        <h2 class="text-center text-light mt-5 me-2 ">PELICULAS FAVORITAS</h2>
        <div class='container-fluid'>
            <div class="row default-row mt-5 mb-1" id="row-1">
                <div class='container mt-2'>
                    <div class='row justify-content-center wrapperino' id='foco'>
                        <?php while($fila = mysqli_fetch_assoc($res)){?>
                        <div class='movie_style'>
                            <a style='text-decoration: none;color:black' href='movies.php?id=<?php echo $fila['movie_id']?>'>
                                <img  alt= 'borrar'style='width:100%' src='assets/imagenesPortada/<?php echo $fila['image']?>' >
                            </a>
                            <form method='post' action='del_favorites.php?id=<?php echo $fila['movie_id']?>'>
                                <button id='boton-cerrar' ><img src='assets/images/x-button.png'></button>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
	//
	$consult_peli_favoritas = 'SELECT * FROM tuser INNER JOIN tfavorites ON tuser.id = tfavorites.movie_id INNER JOIN tmovie ON tfavorites.usuario_id = tmovie.id WHERE tfavorites.usuario_id  = ' . $user_id;		
	$result_peli_favoritas = mysqli_query($mysqli, $consult_peli_favoritas);
    $fila_favoritas = mysqli_fetch_array($result_peli_favoritas);?>
    <?php if(!$fila_favoritas){ ?>
        <div class="text-center mt-5" style="color:red">
            <h1 class=" mb-5">
                NO TIENES NINGUNA PELÍCULA FAVORITA AÑADIDA
            </h1>
        </div>
    <?php } ?>

    <nav aria-label="Page navigation example mt-5">
        <ul class="pagination justify-content-center mt-4 my-5" style="scroll-behavior: smooth;">
            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "
                                    ?page=" . $prev; } ?>">Anterior</a>
            </li>
            <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a class="page-link" href="favorites.php?page=<?= $i; ?>">
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
    
    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?> 
    <!-- Incluir el popup -->
    <?php include_once "./inc/popup_uPassword.php"; ?> 
    <?php include_once "./inc/popup_uProfile.php"; ?>


</body>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#records-limit-favorites').change(function() {
            $('form').submit();
        })
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

</html>