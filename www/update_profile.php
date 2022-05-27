<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['user_id']; //
	$username = $_POST['username']; 
	$imagen_usuario=$_FILES['imagenUsuario']['name'];
	$guardado=$_FILES['imagenUsuario']['tmp_name'];

	$fileType=$_FILES['imagenUsuario']['type'];
	$fileError = $_FILES['imagenUsuario']['error'];
	$fileExt = explode('.', $imagen_usuario);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg','jpeg','png');

	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if(!file_exists('assets/imagenesUsuario')){
				mkdir('assets/imagenesUsuario',0777,true);
					if(file_exists('assets/imagenesUsuario')){
						if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
							echo "Archivo guardado con exito";
						}else{
							echo "Archivo no se pudo guardar";
						}
					}     
			}else{
				if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
					echo "Archivo guardado con exito";
				}else{
						echo "Archivo no se pudo guardar";
				}
			}
		}
		else{
			echo "Ha habido un error subiendo lso archivos";
			
		}
	} 
	try{
		$sql = "UPDATE tuser SET username=?, profile_image = ? WHERE id=?";
		$stmt= $mysqli->prepare($sql);
		$stmt->bind_param("ssi", $username, $imagen_usuario, $id);
		$stmt->execute();
		$_SESSION['successUser'] = "Se ha actualizado el usuario con éxito";

	}catch(Exception $e){
		$_SESSION['failedUser'] = "Ha habido un error actualizando el usuario";
	}
	
?>