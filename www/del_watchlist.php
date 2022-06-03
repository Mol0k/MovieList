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
		
		$select_w = "SELECT * FROM `twatchlist` WHERE usuario_id = ? AND movie_id = ?";
		$stmt_select = $mysqli ->prepare($select_w);
		$stmt_select -> bind_param("ii", $user_id, $movie_id);
		$stmt_select -> execute();
		$result_2 = $stmt_select->get_result();
		$row = $result_2->fetch_array();
	if($row){ // si existen peliculas en la watchlist las borramos
		$del_list = "DELETE FROM `twatchlist` WHERE `twatchlist`.`id` = ?";
		$stmt_del = $mysqli->prepare($del_list);
		$stmt_del ->bind_param("i", $row['id']);
		$stmt_del ->execute();
		$stmt_del ->close();
		header('location: watchlist.php');
		die();
	}
}else{
	header('location: index.php');
}

?>