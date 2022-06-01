<?php 
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();
    $mysqli = get_db_connection_or_die();
    $movie_id = $_POST['movie_id'];
    $user_id = $_SESSION['user_id'];
    
    if(!isset($_SESSION['user_id']) & empty($_SESSION['user_id'])){
		header('location: login.php');
	}
    if(isset($_GET['id']) & !empty($_GET['id'])){

            $select_w = "SELECT * FROM tcomentarios WHERE usuario_id = ? AND movie_id = ?";
            $stmt_select = $mysqli ->prepare($select_w);
            $stmt_select -> bind_param("ii", $user_id, $movie_id);
            $stmt_select -> execute();
            $result_2 = $stmt_select->get_result();
            $row = $result_2->fetch_array();
        if($row){
            $del_list = "DELETE FROM tcomentarios WHERE id = ? and usuario_id = ?";
            $stmt_del = $mysqli->prepare($del_list);
            $stmt_del ->bind_param("ii", $row['id'], $user_id);
            $stmt_del ->execute();
            $stmt_del ->close();
            header("Location: movies.php?id=".$movie_id);
            $_SESSION['error_coment']  = "Borrado correctamente.";
            exit();
        }else{
            $_SESSION['error_coment']  = "No tienes más comentarios.";
            header("Location: movies.php?id=".$movie_id);
            exit();
        }
    }else{
        header('location: index.php');
    }

       
  




















?>
