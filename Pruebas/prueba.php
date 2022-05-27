<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

// session_start();
$mysqli = get_db_connection_or_die();
//  Code to retrieve the values from database:-

$query = "SELECT gender FROM tmovie";
$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

$values = mysqli_fetch_array($result);
while($values = mysqli_fetch_array($result))
{
   $values= unserialize($values['gender']);
   
   foreach($values as $value)
   {
      //code to play with $value
      echo $value;
   }
}




?>
<div class="col-md-6">
    <input class="form-check-input" type="checkbox" value="accion"  name="value[]"id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Acción
    </label>
</div>
<div class="col-md-6">
    <input class="form-check-input" type="checkbox" value="suspense"  name="value[]"id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Suspense
    </label>
</div>
<!-- <select class="form-select" name="value[]" multiple aria-label="multiple select example">
                    <option disabled="true" >Menú generos</option>
                    <option value="Suspense"  >Suspense</option>
                    <option value="Accion"  >Acción</option>
                    <option value="Drama"  >Drama</option>
                    <option value="Comedia" >Comedia</option>
                    <option value="Fantastica"  >Fantástica</option>
                    <option value="Superheroes"  >Superheroes</option>
                </select> -->
 <!-- <div class="col-md-6">
                <label for="f_gender_peliculas" class="form-label">Género de la película:</label>
                <input type="text" class="form-control" name="f_gender_pelicula" id="f_gender_pelicula" />
            </div> -->
<?php
// ini_set('display_errors', 'On');
// require __DIR__ . '/../php_util/db_connection.php';

// // session_start();
// $mysqli = get_db_connection_or_die();
// //  Code to retrieve the values from database:-

// $query = "SELECT gender FROM tmovie";
 
// $result = mysqli_query($mysqli,$query);
 
// while($values = mysqli_fetch_array($result))
// {
//    $values= unserialize($values['gender']);
   
//    foreach($values as $value)
//    {
//       //code to play with $value
//       echo $value;
//    }
// }


?>
