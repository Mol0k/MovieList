<!-- 
**NOTA IMPORTANTE**
ESTO HABRÍA QUE PENSAR EN CAMBIARLO. NO ES VIABLE. DE MOMENTO SE QUEDA ASÍ PERO EN UN FUTURO SE DEBE CAMBIAR.
SOLUCIÓN:
HABRÍA QUE TENER 2 TABLAS:
TABLA tgenre
    gen_id
    gen_title
TABLA tmovie_genres
    mov_id FOREIGN KEY
    gen_id FOREIGN KEY
 -->
 <?php
 $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 ?>
<div class="col-md-9 col-xs-7 ">
    <div class="container mt-2 ">
    <?php 
    if (!isset($_POST['btCrimen']) && !isset($_POST['btComedia']) 
                && !isset($_POST['btSuspense']) && !isset($_POST['btAccion']) 
                && !isset($_POST['btDrama']) && !isset($_POST['btAventuras']) 
                && !isset($_POST['btCienciaFiccion']) && !isset($_POST['btTerror']) 
                && !isset($_POST['btMonstruos']) && !isset($_POST['btSuperheroes']) 
                && !isset($_POST['btFantasiaOscura']) && !isset($_POST['btFantasia']) 
                && !isset($_POST['btMisterio']) && !isset($_POST['btEspionaje'])) {
            $all = "SELECT * FROM tmovie";
            $all_result = mysqli_query($mysqli, $all) or die(mysqli_error($mysqli));?>
            <?php  echo '<h1 class="text-center text-light mb-2" >TODAS LAS PELÍCULAS</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_all = mysqli_fetch_array($all_result)){
                                $variable= unserialize($fila_all['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_all['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_all['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_all['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_all['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_all['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_all['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
        }            ?>
     <?php  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['btCrimen'])) {
                    $crimen = "SELECT * FROM tmovie WHERE GENDER LIKE '%Crimen%'";
                    $crimen_result = mysqli_query($mysqli, $crimen) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE CRIMEN</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_crimen = mysqli_fetch_array($crimen_result)){
                                $variable= unserialize($fila_genre_crimen['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_crimen['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_crimen['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_crimen['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_crimen['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_crimen['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_crimen['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btComedia'])) {
                    $comedia = "SELECT * FROM tmovie WHERE GENDER LIKE '%Comedia%'";
                    $comedia_result = mysqli_query($mysqli, $comedia) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE COMEDIA</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_comedia = mysqli_fetch_array($comedia_result)){
                                $variable= unserialize($fila_genre_comedia['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_comedia['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_comedia['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_comedia['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_comedia['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_comedia['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_comedia['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btSuspense'])) {
                    $suspense = "SELECT * FROM tmovie WHERE GENDER LIKE '%Suspense%'";
                    $suspense_result = mysqli_query($mysqli, $suspense) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE SUSPENSO</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_suspense = mysqli_fetch_array($suspense_result)){
                                $variable= unserialize($fila_genre_suspense['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_suspense['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_suspense['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_suspense['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_suspense['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_suspense['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_suspense['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btAccion'])) {
                    $accion = "SELECT * FROM tmovie WHERE GENDER LIKE '%Accion%'";
                    $accion_result = mysqli_query($mysqli, $accion) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE ACCIÓN</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_accion = mysqli_fetch_array($accion_result)){
                                $variable= unserialize($fila_genre_accion['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_accion['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_accion['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_accion['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_accion['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_accion['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_accion['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btDrama'])) {
                    $drama = "SELECT * FROM tmovie WHERE GENDER LIKE '%Drama%'";
                    $drama_result = mysqli_query($mysqli, $drama) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE DRAMA</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_drama = mysqli_fetch_array($drama_result)){
                                $variable= unserialize($fila_genre_drama['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_drama['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_drama['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_drama['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_drama['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_drama['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_drama['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btAventuras'])) {
                    $aventuras = "SELECT * FROM tmovie WHERE GENDER LIKE '%Aventuras%'";
                    $aventuras_result = mysqli_query($mysqli, $aventuras) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE AVENTURAS</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_aventuras = mysqli_fetch_array($aventuras_result)){
                                $variable= unserialize($fila_genre_aventuras['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_aventuras['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_aventuras['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_aventuras['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_aventuras['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_aventuras['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_aventuras['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btCienciaFiccion'])) {
                    $cienciaFiccion = "SELECT * FROM tmovie WHERE GENDER LIKE '%Ciencia Ficcion%'";
                    $cienciaFiccion_result = mysqli_query($mysqli, $cienciaFiccion) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE CIENCIA FICCIÓN</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_cienciaFiccion = mysqli_fetch_array($cienciaFiccion_result)){
                                $variable= unserialize($fila_genre_cienciaFiccion['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_cienciaFiccion['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_cienciaFiccion['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_cienciaFiccion['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_cienciaFiccion['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_cienciaFiccion['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_cienciaFiccion['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btTerror'])) {
                    $terror = "SELECT * FROM tmovie WHERE GENDER LIKE '%Terror%'";
                    $terror_result = mysqli_query($mysqli, $terror) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE TERROR</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_terror = mysqli_fetch_array($terror_result)){
                                $variable= unserialize($fila_genre_terror['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_terror['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_terror['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_terror['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_terror['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_terror['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_terror['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btMonstruos'])) {
                    $monstruos = "SELECT * FROM tmovie WHERE GENDER LIKE '%Monstruos%'";
                    $monstruos_result = mysqli_query($mysqli, $monstruos) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE MONSTRUOS</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_monstruos = mysqli_fetch_array($monstruos_result)){
                                $variable= unserialize($fila_genre_monstruos['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_monstruos['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_monstruos['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_monstruos['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_monstruos['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_monstruos['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_monstruos['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btSuperheroes'])) {
                    $superheroes = "SELECT * FROM tmovie WHERE GENDER LIKE '%Superheroes%'";
                    $superheroes_result = mysqli_query($mysqli, $superheroes) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE SUPERHÉROES</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_superheroes = mysqli_fetch_array($superheroes_result)){
                                $variable= unserialize($fila_genre_superheroes['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_superheroes['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_superheroes['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_superheroes['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_superheroes['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_superheroes['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_superheroes['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btFantasiaOscura'])) {
                    $fantasiaOscura = "SELECT * FROM tmovie WHERE GENDER LIKE '%Fantasia Oscura%'";
                    $fantasiaOscura_result = mysqli_query($mysqli, $fantasiaOscura) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE FANTASÍA OSCURA</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_fantasiaOscura = mysqli_fetch_array($fantasiaOscura_result)){
                                $variable= unserialize($fila_genre_fantasiaOscura['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_fantasiaOscura['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_fantasiaOscura['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_fantasiaOscura['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_fantasiaOscura['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_fantasiaOscura['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_fantasiaOscura['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btMisterio'])) {
                    $misterio = "SELECT * FROM tmovie WHERE GENDER LIKE '%Misterio%'";
                    $misterio_result = mysqli_query($mysqli, $misterio) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE MISTERIO</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_misterio = mysqli_fetch_array($misterio_result)){
                                $variable= unserialize($fila_genre_misterio['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_misterio['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_misterio['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_misterio['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_misterio['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_misterio['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_misterio['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btEspionaje'])) {
                    $espionaje = "SELECT * FROM tmovie WHERE GENDER LIKE '%Espionaje%'";
                    $espionaje_result = mysqli_query($mysqli, $espionaje) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE ESPIONAJE</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_espionaje = mysqli_fetch_array($espionaje_result)){
                                $variable= unserialize($fila_genre_espionaje['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_espionaje['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_espionaje['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_espionaje['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_espionaje['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_espionaje['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_espionaje['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }if (isset($_POST['btFantasia'])) {
                    $fantasia = "SELECT * FROM tmovie WHERE GENDER LIKE '%Fantasia%'";
                    $fantasia_result = mysqli_query($mysqli, $fantasia) or die(mysqli_error($mysqli));?>
                    <?php  echo '<h1 class="text-center text-light mb-2" >PELÍCULAS DE FANTASÍA</h1>'?>
        <div class="row justify-content-center wrapperino " id="foco">
                    <?php while($fila_genre_fantasia = mysqli_fetch_array($fantasia_result)){
                                $variable= unserialize($fila_genre_fantasia['gender']);  ?>
            <div class="movie_card ">
                    <?php echo "<img   src='assets/imagenesPortada/".$fila_genre_fantasia['image']."' >" ?>
                    <div class="descriptions">
                        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px">
                        <?php echo $fila_genre_fantasia['title']; ?>
                        </h3>
                        <p style="line-height: 20px;height: 70%;">
                        <?php echo $fila_genre_fantasia['sinopsis']; ?>
                        </p>
                        <?php
                        echo "<button id='boton-mas'>
                                <a style='text-decoration: none;color:white'  href='movies.php?id=".$fila_genre_fantasia['id']."'>Mas info</a>
                              </button>";
                              if(!empty($_SESSION['user_id'])){
                                echo '<form  method="post" action="add_to_watchlist.php?id='.$fila_genre_fantasia['id'].'" >
                                        <input type="hidden" name="return" value=" '.$link.'"?>
                                        <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist" class="fa-solid fa-circle-plus fa-beat"> </i> </button>     
                                      </form>';
                                echo '<form method="post" action="add_to_favorites.php?id='.$fila_genre_fantasia['id'].'">
                                        <button id="boton-favorites"> <i title="Agregar a favoritos" class="fa-solid fa-heart fa-beat"> </i> </button>         
                                      </form>';
                              }
                             ?>
                    </div>
            </div>
                    <?php }
                }
            }?>
        </div>
    </div>
</div>
