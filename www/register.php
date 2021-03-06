
<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

$mysqli = get_db_connection_or_die();
// Definir variables e inicializarlas con valores vacíos
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

$email = $password = $confirm_password = "";
$email_err= $password_err = $confirm_password_err = "";


// Procesamiento de los datos del formulario al enviarlo

if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    // Validar username
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduce un nombre de usuario.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "El nombre de usuario sólo puede contener letras, números y guiones bajos.";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $email_err = "El formato del email es incorrecto.";
    }if(empty(trim($_POST["email"]))){
        $email_err = "Introduce un email.";
    }
    //SIN PREPARED STATEMENT
    // else{
    //     $username = $_POST['username'];
    //     $email = $_POST['email'];   
        
    //     $user_check_query = "SELECT * FROM tuser WHERE username='$username' OR email='$email' LIMIT 1";
    //     $result = mysqli_query($mysqli, $user_check_query);
    //     $user = mysqli_fetch_assoc($result);
        
    //     if ($user) { // if user exists
    //       if ($user['username'] === $username) {
    //         $username_err = "Este nombre de usuario ya está ocupado.";
    //       }
      
    //       if ($user['email'] === $email) {
    //         $email_err ="Este email ya ha sido registrado.";
    //       }
    //     }
    // }
    //CON PREPARED STATEMENT
    else{
        $username = $_POST['username'];
        $email = $_POST['email'];   
        
        // $user_check_query = "SELECT * FROM tuser WHERE username= ? OR email= ? LIMIT 1";
        $user_check_query = "SELECT * FROM tuser WHERE username= ? OR email= ?";
        $stmt = $mysqli -> prepare($user_check_query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        $user = $result->fetch_assoc();
        
        if ($user) { // si el usuario existe
            if ($user['username'] === $username) {
                $username_err = "Este nombre de usuario ya está ocupado.";
            }
        
            if ($user['email'] === $email) {
                $email_err ="Este email ya ha sido registrado.";
            }
        }
        $stmt->close();
    }
    
    // Validar password
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduce una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirme su contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "La contraseña no coincide.";
        }
    }
    
    //Comprobar los errores de entrada antes de la inserción en la base de datos
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        $date = date("Y-m-d H:i:s"); 
        // Prepare an insert statement
        $sql = "INSERT INTO tuser (username, email, encrypted_password, registration_date) VALUES (?, ?,?,?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables al prepared statement como parametros
            $stmt->bind_param("ssss", $username, $email,$param_password,$date);
            
            // Setear parametros
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Intentar ejecutar el prepared statement.
            if($stmt->execute()){
                // Que rediriga a index.php
                header("location: index.php#registrado");
            } else{
                echo "¡Uy! Algo ha ido mal. Por favor, inténtelo de nuevo más tarde";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Cerrar la conexión.
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <title>Registro de sesión:</title>

</head>

<body style="background-color: hsl(253, 21%, 13%);">

    <section class="vh-100" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">
        <div class="container h-100 ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-light" style="border-radius: 25px;background-color: hsl(216, 22%, 18%);">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Crea tu cuenta</p>

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" role="form" enctype="multipart/form-data" class="mx-1 mx-md-4">

                                        <div class="form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="f_nomb_user">Nombre de usuario</label>
                                                <input type="text" id="f_nomb_user" name="username"
                                                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">
                                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="f_correo">Correo</label>
                                                <input type="text" id="f_correo" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="f_contra">Contraseña</label>
                                                <input type="password" id="f_contra" name="password"
                                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                            </div>
                                        </div>

                                        <div class=" form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="f_contra_rep">Repite la
                                                    contraseña</label>
                                                <input type="password" id="f_contra_rep" name="confirm_password"
                                                class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            
                                            </div>
                                        </div>
                                        <!-- FECHA DE NACIMIENTO POR PONER -->
                                        <!-- <div class="form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label for="f_created_peliculas" class="form-label">Fecha de nacimiento</label>
                                                <input type="date" class="form-control" name="f_created_pelicula" id="f_created_pelicula" />
            
                                            </div>
                                        </div> -->
                                       
                                        <div class="form-group form-check d-flex justify-content-center mb-4"><!--mb-5 -->
                                            <input class="form-check-input me-2" type="checkbox" required value=""
                                                id="term_cond" />
                                            <label class="form-check-label" for="term_cond"> 
                                                Acepto que he leído los <a href="#!">términos y condiciones</a>.
                                            </label>
                                        </div>
                                        
                                        <div class="form-group form-check d-flex justify-content-center mb-1">
                                            <p>Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
                                        </div>
                                        
                                        <div class="form-group d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" value="Submit" class="btn btn-primary btn-lg">Registrarse</button>
                                        </div>
                                        
                                    </form>

                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</body>




</html>