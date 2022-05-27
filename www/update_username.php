<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['user_id']; //
	$username = $_POST['username']; 

	$buscar_username = "SELECT * FROM tuser where username= ? ";
    $stmt_username= $mysqli->prepare($buscar_username);
    $stmt_username->bind_param("s", $username );
    $stmt_username->execute();
    $result = $stmt_username->get_result(); // get the mysqli result
    $user = $result->fetch_assoc();

    if (empty(trim( $_POST['username']))) {
        $username_err = "No has escrito ningun nombre.";
    }
    if ($user && empty($username_err)) { // if user exists
        if ($user['username'] === $username) {
            header('location: edit_profile.php');
            $_SESSION['username_ocupado'] = "Este nombre de usuario ya está ocupado.";
        }
        
    }else{ 
        try{
            $sql = "UPDATE tuser SET username=? WHERE id=?";
            $stmt= $mysqli->prepare($sql);
            $stmt->bind_param("si", $username , $id);
            $stmt->execute();
            header('location: edit_profile.php');
            $_SESSION['successUser'] = "Se ha actualizado el nombre del usuario con éxito";
    
        }catch(Exception $e){
            header('location: edit_profile.php');
            $_SESSION['failedUser'] = "Ha habido un error actualizando el usuario";
        }
    }
  
    mysqli_close($mysqli);	
		
	
?>