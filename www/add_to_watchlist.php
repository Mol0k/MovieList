<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();
$user_id = $_SESSION['user_id'];
$movie_id = $_GET['id'];
// $return = $_POST['return'];

if(!isset($_SESSION['user_id']) & empty($_SESSION['user_id'])){
		header('location: login.php');
}
if(isset($_GET['id']) & !empty($_GET['id'])){

	
		$movie_id = $_GET['id'];
		$prueba = "SELECT * FROM `tmovie` WHERE id = ? ";
		$stmt_prueba = $mysqli ->prepare($prueba);
		$stmt_prueba -> bind_param("i", $movie_id);
		$stmt_prueba -> execute();
		$result_3= $stmt_prueba->get_result();
		$row2 = $result_3->fetch_array();
	
		$query = "SELECT * FROM `twatchlist` WHERE usuario_id = ? AND movie_id = ?";
		$stmt_select = $mysqli ->prepare($query);
		$stmt_select -> bind_param("ii", $user_id, $movie_id);
		$stmt_select -> execute();
		$result_2 = $stmt_select->get_result();
		$row = $result_2->fetch_array();
	if($row){
		$delete_watchlist = "DELETE FROM `twatchlist` WHERE `twatchlist`.`id` = ?";
		$stmt_delete = $mysqli->prepare($delete_watchlist);
		$stmt_delete ->bind_param("i", $row['id']);
		$stmt_delete ->execute();
		$stmt_delete ->close();
		// header('location: watchlist.php');
		header("Location:movies.php?id=".$row['movie_id']);
		$_SESSION['error_delete_watchlist']  = "Película borrada de la watchlist.";
		die();
	}
	if (!empty($_SESSION['user_id'])) {
		$insert = "INSERT INTO `twatchlist`(movie_id, usuario_id) VALUES(?,?)";
		$stmt_del_insert = $mysqli->prepare($insert);
		$stmt_del_insert ->bind_param("ii", $movie_id, $user_id);
		$stmt_del_insert ->execute();
		$stmt_del_insert ->close();
		// header('location: watchlist.php');
		// header('location: watchlist.php');
		header("Location:movies.php?id=".$row2['id']);
		$_SESSION['añadida_watchlist']  = "Película añadida a la watchlist.";
		die();
	}else{
        $_SESSION['no_logueado_Watchlist']  = "Inicia sesión para poder agregar las pelis.";
        header("Location: movies.php?id=".$movie_id);
        exit();
    }
	
}else{
	header('location: main.php');
}

?>