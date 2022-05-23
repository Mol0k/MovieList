<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id']) & empty($_SESSION['user_id'])){
		header('location: login.php');
	}
if(isset($_GET['id']) & !empty($_GET['id'])){
	$movie_id = $_GET['id'];
	$sql = "DELETE FROM twatchlist WHERE id=$movie_id";
	$res = mysqli_query($mysqli, $sql);
	if($res){
		header('location: watchlist.php');
		//echo "redirect to wish list page";
	}
}else{
	
    echo "no se ha podido borrar";
}

?>