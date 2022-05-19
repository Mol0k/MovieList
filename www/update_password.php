<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
    
    $user_id = $_SESSION['user_id']; 

    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $password_confirm = $_POST['password_confirm'];


    $query = "SELECT * FROM tuser WHERE id = ?";
    $stmt = $mysqli -> prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $user = $result->fetch_assoc();
    

    if(password_verify($password_actual, $user['encrypted_password'])){
        if($password_nueva == $password_confirm){
            $update = "UPDATE tuser SET encrypted_password = ? WHERE id = ?"; 
            $stmt = $mysqli->prepare($update);
            $password = password_hash($_POST['password_nueva'], PASSWORD_BCRYPT);
            $stmt->bind_param("si", $password, $user_id);
            $stmt->execute();
            echo "La contraseña ha sido actualizada.";
            die();
        }
        else{
            echo  "Las contraseñas no coinciden.";
            die();
        } 
    } else {
        echo  "La contraseña actual es incorrecta.";
        die();
      
    }

   
?>