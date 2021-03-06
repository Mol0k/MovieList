<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['user_id']; //
	$username = $_POST['username']; 
    $return = $_POST['return_username'];
	$buscar_username = "SELECT * FROM tuser where username= ? ";
    $stmt_username= $mysqli->prepare($buscar_username);
    $stmt_username->bind_param("s", $username );
    $stmt_username->execute();
    $result = $stmt_username->get_result();
    $user = $result->fetch_assoc();



        if(strlen($_POST['username']) > 3  && strlen($_POST['username']) < 20){
            if ($user) { // si el usuario existe
                if ($user['username'] === $username) {
                    header("Location: $return#popup2");
                    $_SESSION['error_update_username'] = "Este nombre de usuario ya está ocupado.";
                }
            }else{ 
                try{
                    $sql = "UPDATE tuser SET username=? WHERE id=?";
                    $stmt= $mysqli->prepare($sql);
                    $stmt->bind_param("si", $username , $id);
                    $stmt->execute();
                    header("Location: $return#popup2");
                    $_SESSION['successUser'] = "Se ha actualizado el nombre del usuario con éxito.";
            
                }catch(Exception $e){
                    header("Location: $return#popup2");
                    $_SESSION['error_update_username'] = "Ha habido un error actualizando el usuario.";
                }
            }
        }else{ 
            header("Location: $return#popup2");
            $_SESSION['error_update_username'] = "El nombre tiene que tener como mínimo 4 caracteres y como máximo 20.";
            die();
        }
    
        mysqli_close($mysqli);	

	
?>


