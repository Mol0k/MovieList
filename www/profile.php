<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';

    session_start();
    $mysqli = get_db_connection_or_die();


    $user_id = $_SESSION['user_id'];
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
    }
    $sql = "SELECT * FROM tuser WHERE id = '".$user_id."'";
	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc();
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
    <link rel="stylesheet" href="./assets/css/profile.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="shortcut icon" href="#">
    <style>
        .foter{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: black;
            text-align: center;
        }

    </style>
    <title>Perfil de usuario</title>

</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">

    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?> 


    <?php 
        $consultar_usuario = "SELECT * FROM tuser WHERE id = " . $user_id ;
        $resultado_usuario = mysqli_query($mysqli, $consultar_usuario) or die(mysqli_error($mysqli));
        $fila_usuario = mysqli_fetch_array($resultado_usuario);
    ?>   

    
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center text-light"> 
        <div class="card bg-dark p-4"> 
            <div class=" image d-flex flex-column justify-content-center align-items-center"> 
                <button class="btn  botones"> 
                    <?php 
                        $profile_image = $fila_usuario['profile_image'];
                        if(empty($profile_image)){
                            $profile_image = "default-user.png";
                            echo "<img width='100%' height='100%'  class='rounded-circle' src='assets/images/".$profile_image."' >" ;
                        }else{ 
                            echo "<img width='100%' height='100%'  class='rounded-circle' src='assets/imagenesUsuario/".$fila_usuario['profile_image']."' >" ; 
                        }
                    ?>
                </button> 
                <span class="name mt-3"><?php echo $fila_usuario['username']?></span> 
                <span class="idd"><?php echo $fila_usuario['email']?></span> 
                <div class="d-flex flex-row justify-content-center align-items-center gap-2"> 
                    <span class="idd1">Roles:
                        <?php if($fila_usuario['roles'] == NULL){
                            echo "No tiene";
                        }else{
                            echo $fila_usuario['roles'];
                        }
                        ?>
                    </span> 
                    <span><i class="fa fa-copy"></i></span> 
                </div> 
                 
            <div class=" d-flex mt-2"> 
                <button class="btn1 btn-dark">
                    <a href="edit_profile.php" style="text-decoration: none; color:white">Editar perfil</a>
                </button> 
                
            </div> 
            <div class=" px-2 rounded mt-4 date "> 
                <span class="join">Se ha unido el
                <?php
                    date_default_timezone_set('Europe/Madrid');
                        // En windows
                    setlocale(LC_TIME, 'spanish.UTF-8');
                    $date= strftime("%A, %d de %B de %Y", strtotime($fila_usuario['registration_date']));
                    echo $date;
                    ?>
                </span> 
            </div> 
        </div> 
    </div>

    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?> 

    <!-- Incluir el popup -->
    <?php include_once "./inc/popup_uPassword.php"; ?> 
    <?php include_once "./inc/popup_uProfile.php"; ?>                     




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
    
</html>