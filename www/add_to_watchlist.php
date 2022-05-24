<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();
$user_id = $_SESSION['user_id'];
$movie_id = $_GET['id'];


if(!isset($_SESSION['user_id']) & empty($_SESSION['user_id'])){
		header('location: login.php');
}
if(isset($_GET['id']) & !empty($_GET['id'])){
	
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
	
		$insert = "INSERT INTO `twatchlist`(movie_id, usuario_id) VALUES(?,?)";
		$stmt_del_insert = $mysqli->prepare($insert);
		$stmt_del_insert ->bind_param("ii", $movie_id, $user_id);
		$stmt_del_insert ->execute();
		$stmt_del_insert ->close();
		header('location: watchlist.php');
		
		die();
	
}else{
	header('location: main.php');
}

?>