<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();

$user_id = $_SESSION['user_id'];
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
$nombre = "SELECT username FROM tuser WHERE id = " . $_SESSION['user_id'] ;
$resultado_nombre = mysqli_query($mysqli, $nombre) or die(mysqli_error($mysqli));
$fila_nombre = mysqli_fetch_array($resultado_nombre);
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

    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?> 

    <div class="container text-light">
        <h1 class="text-center mt-3">Cambiar la contraseña</h1>
        <div class="row d-flex justify-content-center align-items-center">

            <div class="">
                <h3 class="mt-2">Hola, <?php echo $fila_nombre['username']; ?>

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
                <!-- MENSAJES QUE SE PINTARAN POR PANTALLA -->
                <?php if(isset($_SESSION['error'])){?>
					
                <div class="alert alert-danger text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']);}
					if(isset($_SESSION['success'])){?>
				
                <div class="alert alert-success text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); } ?>

            </div>
        </div>
    </div>
    <div class="container text-light">
        <h1 class="text-center mt-3">Editar usuario y avatar</h1>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="">
                <hr>
                <form method="POST" name="formulario" action="update_username.php" role="form" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="usernames">Nuevo username:</label>
                        <input type="text" name="username" id="usernames" class="form-control"
                            value="">
                        <!-- <label for="f_nacimientos" class="form-label">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" name="f_nacimiento" id="f_nacimientos" /> -->
                    </div>
                    <button type="submit" name="update_username" class="btn btn-success mt-3"><span class="glyphicon glyphicon-check"></span> Actualizar nombre</button>
                </form>
                <form method="POST" action="update_image_profile.php" role="form" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="imagenUsuarios">Sube tu avatar:</label>
                        <input type="file" name="imagenUsuario" id="imagenUsuarios" onchange="preview()" class="form-control"">
                        <img id="frame" alt ="Sube una imagen para ver la previsualización" src="" width="60" height="60" class="rounded-circle mt-3" />
                    </div>
                    <button type="submit" name="update_avatar" class="btn btn-success mt-3"><span class="glyphicon glyphicon-check"></span> Actualizar avatar</button>
                </form>            
                
                <!-- MENSAJES QUE SE PINTARAN POR PANTALLA -->
                    
                <?php if(isset($_SESSION['successUser'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['successUser']; ?>
                </div>
                <?php
                    unset($_SESSION['successUser']);
                }?>
                <?php if(isset($_SESSION['error_update_username'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['error_update_username']; ?>
                </div>
                <?php
                    unset($_SESSION['error_update_username']);
                }?> 

                <!-- MENSAJE DE QUE SE HA SUBIDO LA IMAGEN -->
                <?php if(isset($_SESSION['successProfileImage'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['successProfileImage']; ?>
                </div>
                <?php
                    unset($_SESSION['successProfileImage']);
                }?> 
                
                <!-- MENSAJE DE ERROR IMAGEN -->
                <?php if(isset($_SESSION['error_profile_image'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['error_profile_image']; ?>
                </div>
                <?php
                    unset($_SESSION['error_profile_image']);
                }?> 

            </div>
        </div>
    </div>


    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?>



</body>
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
    <script>
        function preview() {
            frame.src=URL.createObjectURL(event.target.files[0]);
        }
    </script>
    
</html>