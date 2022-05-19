<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
    $user_id = $_SESSION['user_id']; 

    $password_actual = $POST['password_actual'];
    $password_nueva = $POST['password_nueva'];
    $password_confirm = $POST['password_confirm'];


    $query = "SELECT encrypted_password FROM tuser WHERE id = ?";
    $stmt = $mysqli -> prepare($query);
    $stmt->bind_param("si", $password_actual, $user_id);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $user = $result->fetch_assoc();

    if($row['encrypted_password'] == $password_actual){

        if($password_nueva == $password_confirm){
            $update = "UPDATE tuser SET encrypted_password = ? WHERE id = ?"; 
            $stmt = $mysqli->prepare($update);
            $stmt->bind_param("si", password_hash($password_confirm, PASSWORD_BCRYPT), $user_id);
            $stmt->execute();
           
            echo "Se ha actualizado la contraseña";
            echo "<br>";
            echo "<a href='main.php'>Ir a la página principal </a>";
        }
        else {
            echo "Las contraseñas no son iguales.";
            echo "<br>";
            header("Location: profile.php?contraseñas=True");
        }  
    } else {
        echo "La contraseña actual no es correcta.";
        echo "<br>";
        header("Location: profile.php?contraseñasActual=True");
    } 

?>