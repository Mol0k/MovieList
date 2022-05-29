<?php
	ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();
        
    $mysqli = get_db_connection_or_die();
	
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/style_backend_search.css">
    <script src="https://kit.fontawesome.com/b18aa99892.js" crossorigin="anonymous"></script>
    <title>Buscar resultados</title>
</head>
<body class="bg-dark" style="background-image: url('./assets/images/movie-detail-bg.png');background-repeat: no-repeat;
    background-size: cover;">
     <!-- Incluir el header -->
     <?php include "./inc/header.php"; ?> 
     
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
            <div class='container d-flex align-items-center justify-content-center'>
                <div class='search-message-empty-container text-light'>
                    <span class='search-message-empty-decal'>
                        <span class='search-message-empty-decal-eyes'>:</span>
                        <span>(</span>
                    </span>
                    <h2 class='search-message-empty-message'>
                    Sin resultados.
                    </h2>
                </div>
                </div>
            ";
            
		}
		
	}
	else{ // if query length is less than minimum
		echo "Minimo de busqueda ".$min_length;
	}
?>
</div>


<!-- Incluir el footer -->
<?php include "./inc/footer.php"; ?> 

    

   
</body>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    
    
</html>
