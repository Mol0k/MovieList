<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

// session_start();
$mysqli = get_db_connection_or_die();


$titulo_pelicula = $_POST['f_titulo_pelicula'];
$descripcion_pelicula = $_POST['f_descripcion_pelicula'];
$created_pelicula = $_POST['f_created_pelicula'];
$gender_array =  $_POST['f_gender_pelicula'];
$gender_pelicula = explode(',',$gender_array);
echo $gender_array;
$duration_pelicula = $_POST['f_duration_pelicula'];



$imagen_pelicula=$_FILES['imagenPelicula']['name'];
$guardado=$_FILES['imagenPelicula']['tmp_name'];

$fileType=$_FILES['imagenPelicula']['type'];
$fileError = $_FILES['imagenPelicula']['error'];
$fileExt = explode('.', $imagen_pelicula);
$fileActualExt = strtolower(end($fileExt));
$allowed = array('jpg','jpeg','png');

if(in_array($fileActualExt, $allowed)){
    if($fileError === 0){
        if(!file_exists('assets/imagenesPortada')){
            mkdir('assets/imagenesPortada',0777,true);
                if(file_exists('assets/imagenesPortada')){
                    if(move_uploaded_file($guardado, 'assets/imagenesPortada/'.$imagen_pelicula)){
                        echo "Archivo guardado con exito";
                    }else{
                        echo "Archivo no se pudo guardar";
                    }
                }     
        }else{
            if(move_uploaded_file($guardado, 'assets/imagenesPortada/'.$imagen_pelicula)){
                echo "Archivo guardado con exito";
            }else{
                    echo "Archivo no se pudo guardar";
            }
        }
    }
    else{
        echo "Ha habido un error subiendo lso archivos";
        die();
    }
} else{
    header('Location: add_movie.php?failed=True');
    
}

// if(!file_exists('assets/imagenesPortada')){
//     mkdir('assets/imagenesPortada',0777,true);
//         if(file_exists('assets/imagenesPortada')){
//             if(move_uploaded_file($guardado, 'assets/imagenesPortada/'.$imagen_pelicula)){
//                 echo "Archivo guardado con exito";
//             }else{
//                 echo "Archivo no se pudo guardar";
//             }
//         }     
// }else{
//     if(move_uploaded_file($guardado, 'assets/imagenesPortada/'.$imagen_pelicula)){
//         echo "Archivo guardado con exito";
//     }else{
//             echo "Archivo no se pudo guardar";
//     }
// }
    


    try {
        $stmt = $mysqli->prepare("INSERT INTO tmovie (title, description , image , created, gender, duration) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $titulo_pelicula, $descripcion_pelicula, $imagen_pelicula, $created_pelicula, $gender_pelicula,$duration_pelicula);
        $stmt->execute();
        // echo $stmt -> error;
     
        header('Location: do_add_movie.php');
        $stmt->close();
        
    } catch (Exception $e) {
        error_log($e);
        // header('Location: add_movie.php?failed=True');
    }
    $mysqli->close();

?>