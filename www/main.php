<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';
session_start();
$mysqli = get_db_connection_or_die();
// echo $mysqli;


?>
<h1>Hola</h1>
