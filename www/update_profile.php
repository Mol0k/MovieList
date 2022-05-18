

<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['loggedin']; //
	$username = $_POST['username']; 
	$imagen_usuario=$_FILES['imagenUsuario']['name'];
	$guardado=$_FILES['imagenUsuario']['tmp_name'];

	$fileType=$_FILES['imagenUsuario']['type'];
	$fileError = $_FILES['imagenUsuario']['error'];
	$fileExt = explode('.', $imagen_pelicula);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg','jpeg','png');

	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if(!file_exists('assets/imagenesUsuario')){
				mkdir('assets/imagenesUsuario',0777,true);
					if(file_exists('assets/imagenesUsuario')){
						if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_pelicula)){
							echo "Archivo guardado con exito";
						}else{
							echo "Archivo no se pudo guardar";
						}
					}     
			}else{
				if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_pelicula)){
					echo "Archivo guardado con exito";
				}else{
						echo "Archivo no se pudo guardar";
				}
			}
		}
		else{
			echo "Ha habido un error subiendo lso archivos";
			
		}
	} else{
		header('Location: add_movie.php?failed=True');
		die();
	}
	
	// Set the INSERT SQL data
	$sql = "UPDATE tuser SET username='".$username."' WHERE id='".$id."'";

	
	if ($mysqli->query($sql)) {
	  echo "Se ha actualizado el usuario.";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	
	$mysqli->close();
?>