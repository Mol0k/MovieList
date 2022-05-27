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
                <h3 class="mt-2">Hola, <?php echo $fila_nombre['username']; ?> </h3>
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
                    <button type=" submit" name="update_user" class="btn btn-success mt-3"><span class="glyphicon glyphicon-check"></span> Actualizar usuario</button>
                            
                </form>
                <!-- MENSAJES QUE SE PINTARAN POR PANTALLA -->
                    
                <?php if(isset($_SESSION['successUser'])){
                ?>
                <div class="alert alert-danger text-center mt-0" style="margin-top:20px;">
                    <?php echo $_SESSION['successUser']; ?>
                </div>
                <?php
                    unset($_SESSION['successUser']);
                }?> 
                
                <?php if(isset($_SESSION['failedUser'])){
                ?>
                <div class="alert alert-danger text-center mt-0" style="margin-top:20px;">
                    <?php echo $_SESSION['failedUser']; ?>
                </div>
                <?php
                    unset($_SESSION['failedUser']);
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
        $("input").change(function(e) {

        for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
            
            var file = e.originalEvent.srcElement.files[i];
            
            var img = document.createElement("img");
            var reader = new FileReader();
            reader.onloadend = function() {
                img.src = reader.result;
            }
            reader.readAsDataURL(file);
            $("input").after(img);
        }
            });
    </script>
    <script>
        document.getElementById('inputId').removeAttribute('name');
    </script>
</html>