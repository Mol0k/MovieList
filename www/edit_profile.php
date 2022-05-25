<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();


$user_id = $_SESSION['user_id'];
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
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


    <title>Editar de usuario</title>

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
                        <a class="nav-link" href="favorites.php">Películas favoritas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>
                    <?php } ?>
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
                            <a class="dropdown-item" href="edit_profile.php">Editar perfil</a>
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
        <h1 class="text-center mt-3">Cambiar la contraseña</h1>
        <div class="row d-flex justify-content-center align-items-center">

            <div class="">
                <h3 class="mt-2">Hola, <?php echo $row['username']; ?>

                </h3>
                <hr>
                <form method="POST" action="update_password.php">
                    <div class="form-group mt-3">
                        <label for="password_old">Contraseña antigua:</label>
                        <input type="password" name="password_old" id="password_old" class="form-control"
                            value="<?php echo (isset($_SESSION['password_old'])) ? $_SESSION['password_old'] : ''; ?>">
                    </div>
                    <div class="form-group mt-3">
                        <label for="password_nueva">Nueva contraseña:</label>
                        <input type="password" name="password_nueva" id="password_nueva" class="form-control"
                            value="<?php echo (isset($_SESSION['password_nueva'])) ? $_SESSION['password_nueva'] : ''; ?>">
                    </div>
                    <div class="form-group mt-3">
                        <label for="password_confirmar">Confirmar la nueva contraseña:</label>
                        <input type="password" name="password_confirmar" id="password_confirmar" class="form-control "
                            value="<?php echo (isset($_SESSION['password_confirmar'])) ? $_SESSION['password_confirmar'] : ''; ?>">
                    </div>
                    <button type="submit" name="update" class="btn btn-success mt-3"><span
                            class="glyphicon glyphicon-check"></span> Actualizar contraseña</button>
                </form>
                <?php
				if(isset($_SESSION['error'])){
					?>
                <div class="alert alert-danger text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php
					unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
					?>
                <div class="alert alert-success text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <?php
					unset($_SESSION['success']);
				}
			?>
            </div>
        </div>
    </div>
    <div class="container text-light">
        <h1 class="text-center mt-3">Editar usuario y avatar</h1>
        <div class="row d-flex justify-content-center align-items-center">

            <div class="">
                <h3 class="mt-2">Hola, <?php echo $row['username']; ?>

                </h3>
                <hr>
                <form method="POST" action="update_profile.php" role="form" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="username">Nuevo username:</label>
                        <input type="text" name="username" id="username" class="form-control"
                            value="<?php echo (isset($_SESSION['username'])) ? $_SESSION['username'] : ''; ?>">
                    </div>
                    <div class="form-group mt-3">
                        <label for="imagenUsuario">Sube tu avatar:</label>
                        <input type="file" name="imagenUsuario" id="imagenUsuario" class="form-control"">
                    </div>
                    <button type=" submit" name="update_user" class="btn btn-success mt-3"><span
                            class="glyphicon glyphicon-check"></span> Actualizar usuario</button>
                </form>
                <?php
				if(isset($_SESSION['errorUser'])){
					?>
                <div class="alert alert-danger text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['errorUser']; ?>
                </div>
                <?php
					unset($_SESSION['errorUser']);
				}
				if(isset($_SESSION['errorUser'])){
					?>
                <div class="alert alert-success text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['successUser']; ?>
                </div>
                <?php
					unset($_SESSION['successUser']);
				}
			?>
            </div>
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


</body>

</html>