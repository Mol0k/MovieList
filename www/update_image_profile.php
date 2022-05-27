
<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['user_id']; //
	
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
										header('location: edit_profile.php');
										$_SESSION['successProfileImage'] = "Se ha actualizado la imagen con éxito.";
										die();						
								
									}else{ 
										header('location: edit_profile.php');
										$_SESSION['errorGuardar'] = "No se ha podido guardar.";
										die();	
									}			
							}     
				}else{
					if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
						
							$sql_image = "UPDATE tuser SET profile_image = ? WHERE id=?";
							$stmt_image= $mysqli->prepare($sql_image);
							$stmt_image->bind_param("si", $imagen_usuario, $id);
							$stmt_image->execute();
							header('location: edit_profile.php');
							$_SESSION['successProfileImage'] = "Se ha actualizado la imagen con éxito.";
							die();						
						
						}else{ 
							header('location: edit_profile.php');
							$_SESSION['errorGuardar'] = "No se ha podido guardar.";
							die();	
						}
				}
			
		}else{
			header('location: edit_profile.php');
			$_SESSION['errorTamanho'] = "No se pueden subir imágenes de más de 2MB.";
			die();
			
		}
	}else{
		header('location: edit_profile.php');
		$_SESSION['errorGenerico'] = "Algo ha salido mal.";
		die();
	}
}else{
	header('location: edit_profile.php');
	// $_SESSION['errorGenerico'] = "Parece que has subido ninguna imagen.";
	die();
}


		
$mysqli->close();
		
	
?>