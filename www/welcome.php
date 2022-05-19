<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"] !== true){
    header("location: login.php");
    exit;
}
?>
<h1>Bienvenido</h1>