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
    <title>Perfil de usuario</title>

</head>

<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">

    <!-- Incluir el header -->
    <?php include "./inc/header.php"; ?> 



    <div class="cards-container card-resp">
        <?php 
         $name = "SELECT username, profile_image FROM tuser WHERE id = " . $user_id ;
         $result2 = mysqli_query($mysqli, $name) or die(mysqli_error($mysqli));
         $row2 = mysqli_fetch_array($result2);
            echo '<p class="text-light">Hola que tal estas ' . $row2['username'] . ' </p>';
            $profile_image2 = $row2['profile_image'];

            if(empty($profile_image2)){
                $profile_image2 = "default-user.png";
                    echo "<img width='100' height='100'  src='assets/images/".$profile_image2."' >" ;
            }else{ 
                echo "<img width='100' height='100'  src='assets/imagenesUsuario/".$row2['profile_image']."' >" ; 
            }
           
        
        ?>
    </div>
    
    <!-- Incluir el footer -->
    <?php include "./inc/footer.php"; ?> 



    </div>

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
    <script src="scripts.js"></script>
    <script src="assets/js/script_contra.js"></script>

</body>

</html>