<?php
    // ini_set('display_errors', 'On');
    // require __DIR__ . '/../php_util/db_connection.php';
    // session_start();

    // $mysqli = get_db_connection_or_die();
    
    // $user_id = $_SESSION['user_id']; 
    
    // $password_actual = $_GET['password_actual'];
    // $password_nueva = $_GET['password_nueva'];
    // $password_confirm = $_GET['password_confirm'];


    // $query = "SELECT * FROM tuser WHERE id = ?";
    // $stmt = $mysqli -> prepare($query);
    // $stmt->bind_param("i", $user_id);
    // $stmt->execute();
    // $result = $stmt->get_result(); // get the mysqli result
    // $user = $result->fetch_assoc();
    
  

    //     if(password_verify($password_actual, $user['encrypted_password'])){
    //         if($password_nueva == $password_confirm){
    //             $update = "UPDATE tuser SET encrypted_password = ? WHERE id = ?"; 
    //             $stmt = $mysqli->prepare($update);
    //             $password = password_hash($_POST['password_nueva'], PASSWORD_BCRYPT);
    //             $stmt->bind_param("si", $password, $user_id);
    //             $stmt->execute();
    //             echo "La contraseña ha sido actualizada.";   
    //         }
    //         else{
    //             echo  "Las contraseñas no coinciden.";
    //         } 
    //     } else {
    //         echo  "La contraseña actual es incorrecta.";
    //     }
   
?>
<?php
   ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();
    $return = $_POST['return_profile'];
    $mysqli = get_db_connection_or_die();
if(isset($_POST['update'])){
		//get POST data
		$password_old = $_POST['password_old'];
		$password_nueva = $_POST['password_nueva'];
		$password_confirmar = $_POST['password_confirmar'];
        $user_id = $_SESSION['user_id']; 
 
		//creamos una sesión para los datos en caso de error
		$_SESSION['password_old'] = $password_old;
		$_SESSION['password_nueva'] = $password_nueva;
		$_SESSION['password_confirmar'] = $password_confirmar;
 
	
	
 
		//obtenemos los datos del usuario
		$sql = "SELECT * FROM tuser WHERE id = '".$_SESSION['user_id']."'";
		$query = $mysqli->query($sql);
		$row = $query->fetch_assoc();
 
		//comprobamos si la antigua contraseña es correcta
		if(password_verify($password_old, $row['encrypted_password'])){
            if(strlen($password_nueva) > 6  && strlen($_POST['username']) < 20){
			//comprobamos si la nueva contraseña coincide con la reescrita
                if($password_nueva == $password_confirmar){
                    //hasheamos la password
                    $password = password_hash($password_nueva, PASSWORD_DEFAULT);
                    try{
                        $update = "UPDATE tuser SET encrypted_password = ? WHERE id = ?"; 
                        $stmt = $mysqli->prepare($update);
                        $stmt->bind_param("si", $password, $user_id);
                        $stmt->execute();
                        $_SESSION['success'] = "Contraseña actualizada con éxito";
                        //Desactivamos nuestra sesión si no se ha producido ningún error
                        unset($_SESSION['password_old']);
                        unset($_SESSION['password_nueva']);
                        unset($_SESSION['password_confirmar']);
                    }catch(Exception $e){
                        $_SESSION['error'] = $mysqli->error;
                    }
                }
                else{
                    $_SESSION['error'] = "La contraseña nueva y la que se ha vuelto a escribir no coinciden.";
                }
            }
            else{
                $_SESSION['error'] = "La contraseña tiene que tener mas de 6 caracteres.";
            }
        }   
		else{
			$_SESSION['error'] = "Contraseña antigua incorrecta";
		}
	}
	else{
		$_SESSION['error'] = "Introduzca los datos necesarios para actualizar primero";
	}
 
    header("Location: $return#popup1");
 
?>