<?php
    ini_set('display_errors', 'On');
    require __DIR__ . '/../php_util/db_connection.php';
    session_start();

    $mysqli = get_db_connection_or_die();
	$id = $_SESSION['user_id']; 
	$username = $_POST['username']; 
	

	$imagen_usuario=$_FILES['image_perfil']['name'];
	$guardado=$_FILES['image_perfil']['tmp_name'];

	$fileType=$_FILES['image_perfil']['type'];
	$fileError = $_FILES['image_perfil']['error'];
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
	} else{
		header('Location: profile.php?failed=True');
		die();
	}
	
	// if(!file_exists('assets/imagenesUsuario')){
	//     mkdir('assets/imagenesUsuario',0777,true);
	//         if(file_exists('assets/imagenesUsuario')){
	//             if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
	//                 echo "Archivo guardado con exito";
	//             }else{
	//                 echo "Archivo no se pudo guardar";
	//             }
	//         }     
	// }else{
	//     if(move_uploaded_file($guardado, 'assets/imagenesUsuario/'.$imagen_usuario)){
	//         echo "Archivo guardado con exito";
	//     }else{
	//             echo "Archivo no se pudo guardar";
	//     }
	// }
		
	
	
	// // Set the INSERT SQL data
	// $sql = "UPDATE tuser SET username=".$username.", profile_image=".$imagen_usuario.' WHERE id='".$id."";

	
	// if ($mysqli->query($sql)) {
	//   echo "Se ha actualizado el usuario.";
	// } else {
	//   return "Error: " . $sql . "<br>" . $mysqli->error;
	// }

	
	// $mysqli->close();
	
	

	$sql = "UPDATE tuser SET username=?, profile_image = ? WHERE id=?";
	$stmt= $mysqli->prepare($sql);
	$stmt->bind_param("ssi", $username, $imagen_usuario, $id);
	$stmt->execute();
	echo "Se ha actualizado el usuario.";
?>