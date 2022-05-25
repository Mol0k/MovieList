<?php
	ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();
        
    $mysqli = get_db_connection_or_die();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Search results</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
    <style>
        
        .quitar{
            text-decoration:none;
        }
        .movie_card #boton-mas {
            cursor: pointer;
            border-style: none;
            background-color: #ff3838;
            color: #fff;
            outline: none;
            box-shadow: 0px 2px 3px rgba(0, 0, 0, .4);
            transition: all .5s ease-in-out;
            line-height: 20px;
            width: 70px;
            font-size: 10pt;
            margin-bottom: 5px;
            margin-right: 2px;
            position:absolute;
            bottom:0;
            right:0;
        }
        
        .movie_card #boton-mas:hover {
            transform: scale(.95) translateX(-5px);
            transition: all .5s ease-in-out;
        }
        .movie_card #boton-watchlist {
            cursor: pointer;
            border-style: none;
            background-color: #ff3838;
            color: #fff;
            outline: none;
            box-shadow: 0px 2px 3px rgba(0, 0, 0, .4);
            transition: all .5s ease-in-out;
            line-height: 20px;
            width: 30px;
            margin-right: 35px;
            position: absolute;
            top: 0;
            right: 0;
        }
        
        .movie_card #boton-watchlist:hover {
            transform: scale(.95) translateX(-5px);
            transition: all .5s ease-in-out;
        }

        .movie_card #boton-favorites {
            cursor: pointer;
            border-style: none;
          
            background-color: #ff3838;
            color: #fff;
            outline: none;
            box-shadow: 0px 2px 3px rgba(0, 0, 0, .4);
            transition: all .5s ease-in-out;
            line-height: 20px;
            width: 30px;
          
           
            position: absolute;
            top: 0;
            right: 0;
        }
        .movie_card #boton-favorites:hover {
            transform: scale(.95) translateX(-5px);
            transition: all .5s ease-in-out;
        }
        .search-message-empty-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            padding-left: 4.5em;
            }

        .search-message-empty-decal {
            margin-right: 2rem;
            font-size: 6rem;
            transform: rotate(90deg);
            }

        .search-message-empty-message {
            font-size: 1.5em;
            text-rendering: optimizeLegibility;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        
        </style>
</head>
<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="main.php">
                    <img src="./assets/images/icon.png" width="24px" height="24px" alt="logo">MovieList
                </a> -->
            <a class="navbar-brand" href="main.php">MovieList</a>
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
                    <?php if (!empty($_SESSION['user_id'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="watchlist.php">Películas Vistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorites.php">Películas favoritas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                    </li>
                    <?php } ?>

                </ul>
                <form class="d-flex justify-content-end ms-2" action="backend-search.php" method="GET">
                <input class="form-control me-2 my-input" label="boton-search" type="text" placeholder="Ejemplo: Sonic" name="query" required />
		            <button class="btn btn-primary btn-search" id="boton-search" type="submit" value="Search">Buscar</button>
                    <?php if (empty($_SESSION['user_id'])) {
                    ?>
                    <a class="btn btn-success btn-signin ms-2" href="login.php" role="button">Iniciar</a>    
                    <a class="btn btn-danger btn-signout ms-2" href="register.php" role="button">Registrate</a>

                    <?php } else { ?>
                    <ul class="navbar-nav bg-dark"">
                            <li class=" nav-item dropdown ms-2">
                        <a href="#" class="nav-link dropdown-toggle bg-dark" data-bs-toggle="dropdown"
                            id="navbarDropdownMenuLink" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php
                                        $query = "SELECT profile_image FROM tuser WHERE id = " . $_SESSION['user_id'] ;
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
                            <a class="dropdown-item" href="edit_profile.php">Editar
                                perfil</a>
                            <a class="dropdown-item" href="logout.php">Log Out</a>
                        </div>
                        </li>
                    </ul>
                    <?php } ?>
                </form>
            </div>
        </div>
    </nav>
<?php
	$query = $_GET['query']; 
	//obtener el valor enviado a través del formulario de búsqueda
	
	$min_length = 3;
	// establezco la longitud mínima de la consulta si lo desea
	
	if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
		$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$query = htmlspecialchars($query); 
		// cambio los caracteres utilizados en html por sus equivalentes, por ejemplo < a &gt;
		
		$query = mysqli_real_escape_string($mysqli, $query);
		// evitar la inyección SQL
		
        $raw_results = "SELECT * FROM tmovie WHERE title LIKE '%$query%'";
        $result = mysqli_query($mysqli, $raw_results) or die(mysqli_error($mysqli));

		// * significa que selecciono todos los campos, también puedo poner: `id`, `title`, `text`
		// artículos es el nombre de nuestra tabla
	

		// * significa que selecciona todos los campos, también puedo poner: `id`, `title`, `text`
        // articulos es el nombre de nuestra tabla
        // '%$consulta%' es lo que estoy buscando, % significa cualquier cosa, por ejemplo si $consulta es Hola
        // coincidirá con "hola", "Hola hombre", "gogohello", si desea una coincidencia exacta, use `title`='$query'
        // o si desea hacer coincidir solo la palabra completa, por lo que "gogohello" está fuera, use '% $consulta %' ... O ... '$ consulta %' ... O ... '% $ consulta'
		if(mysqli_num_rows($result) > 0){ // if one or more rows are returned do following
			
			while($row = mysqli_fetch_array($result)){
			// $results = mysql_fetch_array($raw_results) pone los datos de la base de datos en el array, mientras es válido hace el bucle
			
				// echo "<p><h3>".$row['title']."</h3>".$row['sinopsis']."</p>";
                echo "
                <div class='cards-container card-resp'>
                    <h2 class='text-center text-light mt-3'>Resultados de la búsqueda</h2>
                    <div class='container-fluid'>
                        <div class='row default-row mt-1 mb-1' id='row-1'>
                            <div class='container mt-5'>
                                <div class='row justify-content-center wrapperino' id='foco'>
                                    <div class='movie_card'>
                                    <img  width='15%' src='assets/imagenesPortada/".$row['image']."' >
                                        <div class='descriptions'>
                                            <h3 style='color: #ff3838;margin: 2px; margin-bottom:5px'>".$row['title']."</h3>
                                            <p style='line-height: 20px;height: 70%;'> ".$row['sinopsis']."</p>
                                            <form method='post' action='movies.php?id=".$row['id']."' >
                                                <button id='boton-mas'>Mas info</button>
                                            </form>
                                            <form  method='post' action='add_to_watchlist.php?id=".$row['id']."' >
                                                <button id='boton-watchlist'> <i title='Agregar a la watchlist'class='fa-solid fa-circle-plus fa-beat'> </i> </button>
                                            </form>
                                            <form  method='post' action='add_to_watchlist.php?id=".$row['id']."' >
                                                <button id='boton-favorites'> <i title='Agregar a la watchlist'class='fa-solid fa-heart fa-beat'> </i> </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
				// resultados de los posts obtenidos de la base de datos (título y texto) también puede mostrar el id ($results['id'])
			}
			
		}
		else{ // si no hay filas coincidentes hacer lo siguiente
            echo "
            <div class='search-message-empty-container text-light'>
                <span class='search-message-empty-decal'>
                    <span class='search-message-empty-decal-eyes'>:</span>
                    <span>(</span>
                </span>
                <h2 class='search-message-empty-message'>
                   Sin resultados.
                </h2>
            </div>
            ";
            
		}
		
	}
	else{ // if query length is less than minimum
		echo "Minimo de busqueda ".$min_length;
	}
?>
</div>
<footer class="bg-dark text-center text-white fixed-bottom ">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" facebook" src="./assets/images/facebook.png">
                </a>

                <!-- Twitter -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" twitter" src="./assets/images/gorjeo.png">
                </a>

                <!-- Tik Tok -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" twitter" src="./assets/images/tik-tok.png">
                </a>

                <!-- Instagram -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" instagram" src="./assets/images/instagram.png">
                </a>


                <!-- Github -->
                <a class="btn  btn-floating m-1 " href="#!" ">
                      <img alt=" github" src="./assets/images/github.png">
                </a>
            </section>
            <!-- Section: Social media -->
        </div>


        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a class="text-white" href="#">MovieList</a>
        </div>
        <!-- Copyright -->
    </footer>



    

    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#records-limit').change(function() {
            $('form').submit();
        })
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <script src="/assets/js/index.js" type="module"></script>
</body>
</html>
