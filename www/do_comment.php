<?php
  ini_set('display_errors', 'On');
  require __DIR__ . '/../php_util/db_connection.php';


    $mysqli = get_db_connection_or_die();

    session_start();
    $user_id_a_insertar = 'NULL';
    if (!empty($_SESSION['user_id'])) {
        $user_id_a_insertar = $_SESSION['user_id'];
    }
    $movie_id = $_POST['movie_id'];
    $comentario = $_POST['new_comment'];

    $date = date("Y-m-d H:i:s"); 

    $count_comment = "SELECT COUNT(*) FROM tcomentarios WHERE usuario_id = $user_id_a_insertar and movie_id = $movie_id";
    $stmt = $mysqli->prepare($count_comment);
    $stmt->execute();
    $result = $stmt->get_result();
    $row_count = $result->fetch_row()[0];
    if($row_count > 0){
      $_SESSION['duplicado_coment']  = "No puedes comentar más de una vez por película.";
      header("Location: movies.php?id=".$movie_id);
      exit();
    }else{
      if (!empty($_SESSION['user_id'])) {
        if(!empty($_POST["new_comment"]) ){
          $insert = "INSERT INTO `tcomentarios`(comentario, movie_id, usuario_id,fecha_comentario) VALUES(?,?,?,?)";
          $stmt_del_insert = $mysqli->prepare($insert);
          $stmt_del_insert ->bind_param("siis", $comentario,$movie_id, $user_id_a_insertar,$date);
          $stmt_del_insert ->execute();
          header("Location: movies.php?id=".$movie_id);
          exit();
        }else{
          header("Location: movies.php?id=".$movie_id);
          $_SESSION['error_coment']  = "Introduce un comentario.";
          exit();
        }
      }else{
        $_SESSION['error_coment']  = "Inicia sesión para poder comentar.";
        header("Location: movies.php?id=".$movie_id);
        exit();
      }
    }    
  
  mysqli_close($mysqli); 
?>        
