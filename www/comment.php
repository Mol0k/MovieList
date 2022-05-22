<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

// session_start();
$mysqli = get_db_connection_or_die();
?>
<html>
    <body>
      <?php
        session_start();
        $user_id_a_insertar = 'NULL';
        if (!empty($_SESSION['user_id'])) {
        $user_id_a_insertar = $_SESSION['user_id'];
        }
        $movie_id = $_POST['movie_id'];
        $comentario = $_POST['new_comment'];
        $date = date('Y-m-d');

        $query = "INSERT INTO tComentarios(comentario, movie_id, usuario_id, fecha_comentario)
        VALUES ('".$comentario."',".$movie_id.",".$user_id_a_insertar.",'".$date."')";
        mysqli_query($mysqli, $query) or die('Error');
        echo "<p>Nuevo comentario ";
        echo mysqli_insert_id($mysqli);
        echo " añadido</p>";
        echo "<p>Nueva fecha";
        echo " añadida</p>";
        echo "<p>Id usuario";
        echo " añadido</p>";
        echo "<a href='/movies.php?id=".$movie_id."'>Volver</a>";
        mysqli_close($mysqli);
      ?>
    </body>
</html>