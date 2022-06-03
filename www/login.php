<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();


// Comprobar si el usuario ya ha iniciado la sesión, en caso correcto, redirigirlo a la página de inicio
if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] === true){
    header("location: index.php");
    exit;
}
 

// Definir variables e inicializar con valores vacíos
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Procesamiento de los datos del formulario al enviarlo

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Comprobar si el nombre de usuario está vacío
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduce un nombre de usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Comprobar si la contraseña está vacía
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduce tu contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar las credenciales
    if(empty($username_err) && empty($password_err)){
        $username = $_POST['username'];
        // Prepare a select statement
        $query = "SELECT id, encrypted_password FROM tuser WHERE username = '".$username."'";
        $result = mysqli_query($mysqli, $query) or die(header('login.php?login_failed_unknown=True'));
        if (mysqli_num_rows($result) > 0) {
            $only_row = mysqli_fetch_array($result);
            if (password_verify($password, $only_row[1])) {
                session_start();
                $_SESSION['user_id'] = $only_row[0];
                header('Location: index.php');
            } else {
                $login_err = "Usuario o contraseña incorrectos.";}
        } else{
            $login_err = "Usuario o contraseña incorrectos.";}
    }
    
    $mysqli -> close();
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
    <title>Inicio de sesión:</title>

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
                                                <label class="form-label" for="f_nomb_user">Nombre de usuario</label>
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
                                        
                                        <?php 
                                            if(!empty($login_err)){
                                                echo '<p class="text-center" style="color:#dc3545">' . $login_err . '</p>';
                                            }        
                                        ?>      
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