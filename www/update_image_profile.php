
<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['user_id']; //
	$return = $_POST['return_image'];
	$imagen_usuario=$_FILES['imagenUsuario']['name'];
	$guardado=$_FILES['imagenUsuario']['tmp_name'];
	$maxSize = 2097152;
	$fileType=$_FILES['imagenUsuario']['type'];
	$fileError = $_FILES['imagenUsuario']['error'];
	$fileExt = explode('.', $imagen_usuario);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg','jpeg','png');

	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if($_FILES["imagenUsuario"]["size"] < $maxSize) {	
				if(!file_exists('assets/imagenesUsuario')){
						mkdir('assets/imagenesUsuario',0777,true);
							if(file_exists('assets/imagenesUsuario')){
								if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
									
										$sql_image = "UPDATE tuser SET profile_image = ? WHERE id=?";
										$stmt_image= $mysqli->prepare($sql_image);
										$stmt_image->bind_param("si", $imagen_usuario, $id);
										$stmt_image->execute();
										header("Location: $return#popup2");
										$_SESSION['successProfileImage'] = "Se ha actualizado la imagen con éxito.";
										die();						
								
									}else{ 
										header("Location: $return#popup2");
										$_SESSION['error_profile_image'] = "No se ha podido guardar.";
										die();	
									}			
							}     
				}else{
					if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
						
							$sql_image = "UPDATE tuser SET profile_image = ? WHERE id=?";
							$stmt_image= $mysqli->prepare($sql_image);
							$stmt_image->bind_param("si", $imagen_usuario, $id);
							$stmt_image->execute();
							header("Location: $return#popup2");
							$_SESSION['successProfileImage'] = "Se ha actualizado la imagen con éxito.";
							die();						
						
						}else{ 
							header("Location: $return#popup2");
							$_SESSION['error_profile_image'] = "No se ha podido guardar.";
							die();	
						}
				}
			
		}else{
			header("Location: $return#popup2");
			$_SESSION['error_profile_image'] = "No se pueden subir imágenes de más de 2MB.";
			die();
			
		}
	}else{
		header("Location: $return#popup2");
		$_SESSION['error_profile_image'] = "Algo ha salido mal.";
		die();
	}
}else{
	header("Location: $return#popup2");
	// $_SESSION['error_profile_image'] = "Parece que has subido ninguna imagen.";
	die();
}


		
$mysqli->close();
		
	
?>