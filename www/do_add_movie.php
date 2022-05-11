<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();
if (isset($_POST['upload'])) {
$msg="";
$titulo_pelicula = $_POST['f_titulo_pelicula'];
$descripcion_pelicula = $_POST['f_descripcion_pelicula'];
// $imagen_pelicula = $_POST['f_imagen_pelicula'];
$created_pelicula = $_POST['f_created_pelicula'];
$gender_pelicula = $_POST['f_gender_pelicula'];
$duration_pelicula = $_POST['f_duration_pelicula'];

$imagen_pelicula = $_FILES["f_imagen_pelicula"]["name"];
$tempname = $_FILES["f_imagen_pelicula"]["tmp_name"]; 
$folder = "www/assets/imagesMovie/".$imagen_pelicula;


    try {
        $stmt = $mysqli->prepare("INSERT INTO tMovie (titulo_pelicula, descripcion_pelicula , imagen_pelicula , created_pelicula, gender_pelicula,duration_pelicula) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $titulo_pelicula, $descripcion_pelicula, $imagen_pelicula, $created_pelicula, $gender_pelicula,$duration_pelicula);
        $stmt->execute();
        // echo $stmt -> error;
        if (move_uploaded_file($tempname, $folder))  {
            echo  "La imagen se ha subido";
        }else{
            echo "La iamgen no se ha subido";
        }
        header('Location: main.php');
        $stmt->close();
        
    } catch (Exception $e) {
        error_log($e);
        // header('Location: add_movie.php?failed=True');
    }
    $mysqli->close();
}
?>
