<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();

// $_SESSION['user_id'] = 3;
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="#">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    
 
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <title>Añadir películas:</title>
    <style>
       
  
        .multipleSelection {
            width: 300px;
            background-color: #BCC2C1;
        }
  
        .selectBox {
            position: relative;
        }
  
        .selectBox select {
            width: 100%;
            
        }
  
        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }
  
        #checkBoxes {
            display: none;
            border: 1px #8DF5E4 solid;
        }
  
        #checkBoxes label {
            display: block;
        }
  
        #checkBoxes label:hover {
            background-color: #4F615E;
        }
    </style>
   

</head>

<body class="bg-dark">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="main.php">
                    <img src="./assets/images/icon.png" width="24px" height="24px" alt="logo">MovieList
                </a> -->
            <a class="navbar-brand" href="#">MovieList</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                    <li class="nav-item">
                        <a class="nav-link active" href="main.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas Vistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Películas deseadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>

                </ul>
                <form class="d-flex justify-content-end ms-2">
                    <input class="form-control me-2 my-input" type="search" placeholder="Buscar peliculas"
                        aria-label="Search">
                    <button class="btn btn-primary btn-search" type="submit">Buscar</button>
                    <?php if (empty($_SESSION['user_id'])) {
                    ?>
                     <button class="btn btn-success btn-signin ms-2" type="submit"
                          formaction="login.php">Iniciar</button> 
                      <a class="btn btn-danger btn-signout ms-2" href="register.php" role="button">Registrate</a> 
                     
                    <?php } else { ?>
                        <ul class="navbar-nav bg-dark"">
                            <li class="nav-item dropdown ms-2" >
                                    <a  href="#" class="nav-link dropdown-toggle bg-dark" data-bs-toggle="dropdown" id="navbarDropdownMenuLink" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                        $query = "SELECT * FROM tuser WHERE id = " . $_SESSION['user_id'] ;
                                        $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
                                        $row = mysqli_fetch_array($result);
                                        $profile_image = $row['profile_image'];

                                        if(empty($profile_image)){
                                            $profile_image = "default-user.png";
                                            echo "<img width='35' height='35' class='rounded-circle' src='assets/images/".$profile_image."' >" ;
                                        }else{ 
                                            echo "<img width='35' height='35' class='rounded-circle' src='assets/imagenesUsuario/".$row['profile_image']."' >" ; 
                                        }
                                    ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="profile.php">Panel</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_usuario">Editar perfil</a>
                                        <a class="dropdown-item" href="logout.php">Log Out</a>
                                    </div>
                            </li>   
                        </ul>
                    <?php } ?>
                </form>
            </div>
        </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="modal_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel">Editar perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="update_profile.php" method="POST" id="edit-form" role="form" enctype="multipart/form-data" class="mx-1 mx-md-4">

                            <div class="form-group d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="f_nomb_user">Nombre</label>
                                    <input type="text" id="f_nomb_user" name="username" class="form-control ">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="f_contra_actual">Contraseña actual</label>
                                    <input type="password" id="f_contra_actual" name="password_actual" class="form-control ">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="form-group d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="f_contra">Nueva Contraseña</label>
                                    <input type="password" id="f_contra" name="password" class="form-control ">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class=" form-group d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label" for="f_contra_rep">Repite la
                                        contraseña</label>
                                    <input type="password" id="f_contra_rep" name="confirm_password"
                                        class="form-control ">
                                    <span class="invalid-feedback"></span>

                                </div>
                            </div>
                            <div class=" form-group d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label for="imagenPerfiles" class="form-label">Imagen perfil:</label>
                                    <input type="file" class="form-control"  name="image_perfil" id="image_perfil"/>
                                </div>
                            </div>
                            
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnUpdateSubmit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    <hr class="bg-danger border-2 border-top border-danger" />
    <form action="do_add_movie.php" role="form" class="row p-3 text-light" method="POST" enctype="multipart/form-data">
        <h2>DATOS DE LA PELÍCULA:</h2>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="f_titulo_peliculas" class="form-label">Título Película</label>
                <input type="text" class="form-control" name="f_titulo_pelicula" id="f_titulo_pelicula" />
            </div>
            <div class="col-md-6">
                <label for="f_sinopsiss_peliculas" class="form-label">Sinopsis película:</label>
                <textarea class="form-control" name="f_sinopsis_pelicula" id="f_sinopsis_pelicula" maxlength="1225"
                    rows="4" cols="3" style="resize: none; width: 100%; height: 17px" required></textarea>
            </div>
            <div class="col-md-6">
                <label for="imagenPeliculas" class="form-label">Imagen película:</label>
                <input type="file" class="form-control"  name="imagenPelicula" id="imagenPelicula"/>
            </div>
            <div class="col-md-6">
                <label for="f_created_peliculas" class="form-label">Año de emisión de la película:</label>
                <input type="date" class="form-control" name="f_created_pelicula" id="f_created_pelicula" />
            </div>
            <div class="col-md-6">
                <div class="mt-4 multipleSelection">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select class="form-select">
                            <option>Menu de géneros</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkBoxes">
                        <label for="first">
                            <input type="checkbox" value="Suspense"  name="value[] id="first" />
                            Suspense
                        </label>
                        <label for="second">
                            <input type="checkbox" value="Accion"  name="value[] id="second" />
                            Acción
                        </label>
                        <label for="third">
                            <input type="checkbox" value="Drama"  name="value[] id="third" />
                            Drama
                        </label>
                        <label for="fourth">
                            <input type="checkbox" value="Comedia"  name="value[] id="fourth" />
                            Comedia
                        </label>
                        <label for="five">
                            <input type="checkbox" value="Aventuras"  name="value[] id="five" />
                            Aventuras
                        </label>
                        <label for="six">
                            <input type="checkbox" value="Ciencia ficcion"  name="value[] id="six" />
                            Ciencia ficción
                        </label>
                        <label for="seven">
                            <input type="checkbox" value="Terror"  name="value[] id="seven" />
                            Terror
                        </label>
                        <label for="eigth">
                            <input type="checkbox" value="Monstruos"  name="value[] id="eigth" />
                            Monstruos
                        </label>
                        <label for="nine">
                            <input type="checkbox" value="Superheroes"  name="value[] id="nine" />
                            Superhéroes
                        </label>
                        <label for="ten">
                            <input type="checkbox" value="Fantasia oscura"  name="value[] id="ten" />
                            Fantasía oscura
                        </label>
                        <label for="eleven">
                            <input type="checkbox" value="Crimen"  name="value[] id="eleven" />
                            Crimen
                        </label>
                        <label for="twelve">
                            <input type="checkbox" value="Fantasia"  name="value[] id="twelve" />
                            Fantasía
                        </label>
                        <label for="thirteen">
                            <input type="checkbox" value="Misterio"  name="value[] id="thirteen" />
                            Misterio
                        </label>
                        <label for="fourteen">
                            <input type="checkbox" value="Espionaje"  name="value[] id="fourteen" />
                            Espionaje
                        </label>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <label for="f_duration_peliculas" class="form-label">Duración de la película:</label>
                <input type="text" class="form-control" name="f_duration_pelicula" id="f_duration_pelicula" />
            </div>
            <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary mt-5 btn-full" name="upload">Enviar</button>
        </div>
        </div>
       
        <?php
        // recoger la variable $_GET['failed'] para mostrar el error
        if (isset($_GET['failed'])) {
            if($_GET['failed'] == TRUE){ ?>
            <p class="lead" style="color:red">
                Solo se pueden subir imágenes con la extensión jpg, jpeg y png.
            </p>
            <?php } ?>
        <?php } ?>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
        
    </script>
    <script>
        var show = true;
  
        function showCheckboxes() {
            var checkboxes = 
                document.getElementById("checkBoxes");
  
            if (show) {
                checkboxes.style.display = "block";
                show = false;
            } else {
                checkboxes.style.display = "none";
                show = true;
            }
        }
    </script>
     
</body>

</html>







   


 

