<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    $mysqli = get_db_connection_or_die();
    $user_id = $_SESSION['user_id'];
    
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
    }
    
    //Consulta para comprobar si el usuario es admin o un usuario normal
    $role_sql = "SELECT * FROM tuser WHERE id = '".$user_id."'";
    $query = $mysqli->query($role_sql);
    $row_role = $query->fetch_assoc(); 

    if($row_role['roles'] != "admin"){
        header('Location: index.php');
    }

    //Paginación
    if(isset($_POST['records-limit-addmovie'])){
        $_SESSION['records-limit-addmovie'] = $_POST['records-limit-addmovie'];
    }
    $limit = isset($_SESSION['records-limit-addmovie']) ? $_SESSION['records-limit-addmovie'] : 2;
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
    $paginationStart = ($page - 1) * $limit;
    
    $movies = $mysqli->query("SELECT * FROM tmovie  LIMIT $paginationStart, $limit")->fetch_all(MYSQLI_ASSOC);
    // Obtener el total de records
    $sql = $mysqli->query("SELECT count(id) AS id FROM tmovie")->fetch_all(MYSQLI_ASSOC);
    $allRecords = $sql[0]['id'];

    //Calcular el  total de págians
    $totalPaginas = ceil($allRecords / $limit);
    // Anterior y siguiente
    $prev = $page - 1;
    $next = $page + 1;
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="#">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="./assets/css/style_add_movie.css" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <link rel="stylesheet" href="./assets/css/profile.css">
    <title>Añadir películas:</title>

</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">

    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?>

    <form action="do_add_movie.php" role="form" class="row p-3 text-light" method="POST" enctype="multipart/form-data">
        <h2>DATOS DE LA PELÍCULA:</h2>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="f_titulo_peliculas" class="form-label">Título Película</label>
                <input type="text" class="form-control" name="f_titulo_pelicula" id="f_titulo_pelicula" />
            </div>
            <div class="col-md-6">
                <label for="f_sinopsiss_peliculas" class="form-label">Sinopsis película:</label>
                <textarea class="form-control" name="f_sinopsis_pelicula" id="f_sinopsis_pelicula" maxlength="1225"
                    rows="4" cols="3" style="resize: none; width: 100%; height: 17px" required></textarea>
            </div>
            <div class="col-md-6">
                <label for="imagenPeliculas" class="form-label">Imagen película:</label>
                <input type="file" class="form-control" name="imagenPelicula" id="imagenPelicula" />
            </div>
            <div class="col-md-6">
                <label for="f_created_peliculas" class="form-label">Año de emisión de la película:</label>
                <input type="date" class="form-control" name="f_created_pelicula" id="f_created_pelicula" />
            </div>
            <div class="col-md-6">
                <div class="mt-4 multipleSelection">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select class="form-select">
                            <option>Menu de géneros</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkBoxes">
                        <label for="first">
                            <input type="checkbox" value="Suspense" name="value[] id=" first" />
                            Suspense
                        </label>
                        <label for="second">
                            <input type="checkbox" value="Acción" name="value[] id=" second" />
                            Acción
                        </label>
                        <label for="third">
                            <input type="checkbox" value="Drama" name="value[] id=" third" />
                            Drama
                        </label>
                        <label for="fourth">
                            <input type="checkbox" value="Comedia" name="value[] id=" fourth" />
                            Comedia
                        </label>
                        <label for="five">
                            <input type="checkbox" value="Aventuras" name="value[] id=" five" />
                            Aventuras
                        </label>
                        <label for="six">
                            <input type="checkbox" value="Ciencia ficción" name="value[] id=" six" />
                            Ciencia ficción
                        </label>
                        <label for="seven">
                            <input type="checkbox" value="Terror" name="value[] id=" seven" />
                            Terror
                        </label>
                        <label for="eigth">
                            <input type="checkbox" value="Monstruos" name="value[] id=" eigth" />
                            Monstruos
                        </label>
                        <label for="nine">
                            <input type="checkbox" value="Superhéroes" name="value[] id=" nine" />
                            Superhéroes
                        </label>
                        <label for="ten">
                            <input type="checkbox" value="Fantasía oscura" name="value[] id=" ten" />
                            Fantasía oscura
                        </label>
                        <label for="eleven">
                            <input type="checkbox" value="Crimen" name="value[] id=" eleven" />
                            Crimen
                        </label>
                        <label for="twelve">
                            <input type="checkbox" value="Fantasía" name="value[] id=" twelve" />
                            Fantasía
                        </label>
                        <label for="thirteen">
                            <input type="checkbox" value="Misterio" name="value[] id=" thirteen" />
                            Misterio
                        </label>
                        <label for="fourteen">
                            <input type="checkbox" value="Espionaje" name="value[] id=" fourteen" />
                            Espionaje
                        </label>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <label for="f_duration_peliculas" class="form-label">Duración de la película:</label>
                <input type="text" class="form-control" name="f_duration_pelicula" id="f_duration_pelicula" />
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary mt-5 btn-full" name="upload">Enviar</button>
            </div>
        </div>

        <?php
        // recoger la variable $_GET['failed'] para mostrar el error
        if (isset($_GET['failed'])) {
            if($_GET['failed'] == TRUE){ ?>
        <p class="lead" style="color:red">
            Solo se pueden subir imágenes con la extensión jpg, jpeg y png.
        </p>
        <?php } ?>
        <?php } ?>

    </form>
    <div class="text-light d-flex flex-row-reverse bd-highlight mb-3">
        <form action="add_movie.php" id ="form-pag" method="post">
            <select name="records-limit-addmovie" id="records-limit-addmovie" class="custom-select">
                <option disabled selected>Límite</option>
                <?php foreach([2,4,8,10] as $limit) : ?>
                <option
                    <?php if(isset($_SESSION['records-limit-addmovie']) && $_SESSION['records-limit-addmovie'] == $limit) echo 'selected'; ?>
                    value="<?= $limit; ?>">
                    <?= $limit; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <!-- Datatable -->
    <table class="table table-bordered text-light mb-5">
        <thead>
            <tr class="table-success">
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Sinopsis</th>
                <th scope="col">Imagen</th>
                <th scope="col">Emisión</th>
                <th scope="col">Duración</th>
                <th scope="col">Géneros</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($movies as $movie): 
                    $generos= unserialize($movie['gender']); 
                    $array_generos = implode(", ",$generos);
                    //formatear fecha
                    date_default_timezone_set('Europe/Madrid');
                    setlocale(LC_TIME, 'spanish');
                    $date = date_create($movie['created']);
                    echo date_format($date, 'd-m-Y');
                    
                ?>

            <tr>
                <th scope="row"><?php echo $movie['id']; ?></th>
                <td><?php echo $movie['title']; ?></td>
                <td><?php echo $movie['sinopsis']; ?></td>
                <td><?php echo "<img style='width:30%;height:30%; margin-left: auto;margin-right: auto;display: block;' src='assets/imagenesPortada/".$movie['image']."' >" ?>
                </td>
                <td><?php echo $created; ?></td>
                <td><?php echo $movie['duration']; ?></td>
                <td><?php echo $array_generos;  ?> </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Pagination -->
    <nav aria-label="Page navigation example mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link"
                    href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Anterior</a>
            </li>
            <?php for($i = 1; $i <= $totalPaginas; $i++ ): ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a class="page-link" href="add_movie.php?page=<?= $i; ?>"> <?= $i; ?> </a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?php if($page >= $totalPaginas) { echo 'disabled'; } ?>">
                <a class="page-link"
                    href="<?php if($page >= $totalPaginas){ echo '#'; } else {echo "?page=". $next; } ?>">Siguiente</a>
            </li>
        </ul>
    </nav>

    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?>
    <!-- Incluir el popup -->
    <?php include_once "./inc/popup_uPassword.php"; ?> 
    <?php include_once "./inc/popup_uProfile.php"; ?>

</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#records-limit-addmovie').change(function() {
            var frm = document.getElementById("form-pag");
            frm.submit();
        })
    });
    </script>
    <script>
    var show = true;

    function showCheckboxes() {
        var checkboxes =
            document.getElementById("checkBoxes");

        if (show) {
            checkboxes.style.display = "block";
            show = false;
        } else {
            checkboxes.style.display = "none";
            show = true;
        }
    }
    </script>

</html>