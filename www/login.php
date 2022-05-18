<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

$mysqli = get_db_connection_or_die();
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: main.php");
    exit;
}
 
// Include config file

 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, encrypted_password FROM tuser WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to main page
                            header("location: main.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
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

    <section class="vh-100" style="background-image: url('./assets/images/hero-bg.jpg');background-repeat: no-repeat;
    background-size: cover;">
        <div class="container h-100 ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-light" style="border-radius: 25px;background-color: hsl(216, 22%, 18%);">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Iniciar sesión</p>
                                   

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" role="form" enctype="multipart/form-data" class="mx-1 mx-md-4">

                                        <div class="form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="f_nomb_user">Nombre</label>
                                                <input type="text" id="f_nomb_user" name="username"
                                                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="f_contra">Contraseña</label>
                                                <input type="password" id="f_contra" name="password"
                                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group form-check d-flex justify-content-center mb-1">
                                            <p>No tienes cuenta? <a href="register.php">Registrate aquí</a>.</p>
                                        </div>
                                        
                                        <div class="form-group d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" value="Login" class="btn btn-primary btn-lg">Iniciar sesión</button>
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