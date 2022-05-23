<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

session_start();
$mysqli = get_db_connection_or_die();
$user_id = $_SESSION['user_id'];

?>


<div>


<?php
        
		$query3 = 'SELECT * FROM tmovie INNER JOIN twatchlist ON tmovie.id = twatchlist.movie_id INNER JOIN tuser ON twatchlist.usuario_id = tuser.id where twatchlist.usuario_id = ' . $user_id;
       
		$res = mysqli_query($mysqli, $query3);
		while($fila = mysqli_fetch_assoc($res)){
	?>
					<tr>
						<td>
							
						</td>
                        <td><?php echo $fila['title']; ?></td>
						
					</tr>
				<?php } ?>


</div>