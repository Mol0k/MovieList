
<?php

// **NOTA IMPORTANTE**
// ESTO HABRÍA QUE PENSAR EN CAMBIARLO. NO ES VIABLE.
// THIS IS THE JUNGLE.
// DE MOMENTO SE QUEDA ASÍ PERO EN UN FUTURO SE CAMBIARÁ.
// SOLUCIÓN:
// HABRÍA QUE TENER 2 TABLAS:
// TABLA tgenre
//     gen_id
//     gen_title
// TABLA tmovie_genres
//     mov_id FOREIGN KEY
//     gen_id FOREIGN KEY

    ini_set('display_errors', 'On');
    require_once __DIR__ . '/../php_util/db_connection.php';
    $mysqli = get_db_connection_or_die();
    
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }
    
    $ruta_absoluta = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
?>
<div class="col-md-9 col-xs-7 ">
    <div class="container mt-2 ">
    <?php 
    if (!isset($_POST['btCrimen']) && !isset($_POST['btComedia']) && !isset($_POST['btSuspense']) && !isset($_POST['btAccion'])  && !isset($_POST['btDrama']) && !isset($_POST['btAventuras']) && !isset($_POST['btCienciaFiccion']) && !isset($_POST['btTerror']) 
        && !isset($_POST['btMonstruos']) && !isset($_POST['btSuperheroes']) && !isset($_POST['btFantasiaOscura']) && !isset($_POST['btFantasia']) && !isset($_POST['btMisterio']) && !isset($_POST['btEspionaje'])) {
        //Consulta
        $movies = $mysqli->query("SELECT * FROM tmovie ")->fetch_all(MYSQLI_ASSOC);?>
        <h1 class="text-center text-light mb-2" >TODAS LAS PELÍCULAS</h1>
        <div class="row justify-content-center wrapperino" id="foco">
            <?php foreach($movies as $movie): ?>        
            <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$movie['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $movie['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $movie['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO. SI NO PONGO ESTO EN UN FORMULARIO EL SIGUIENTE FORMULARIO ROMPE ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $movie['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $movie['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $movie['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?>         
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $movie['id'] ?>" >
                    <input type="hidden" name="return_favorites" value=" <?php echo $ruta_absoluta ?>">
                    <?php
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $movie['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array(); 
                    ?>
                        <?php 
                        if(!empty($row_favorites)){?>    
                            <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                        <?php
                        } 
                        ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
    <?php }
        ?>
    <?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['btCrimen'])) {
            $crimens = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Crimen%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE CRIMEN</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($crimens as $crimen): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$crimen['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $crimen['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $crimen['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO. SI NO PONGO ESTO EN UN FORMULARIO EL SIGUIENTE FORMULARIO ROMPE ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $crimen['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $crimen['id'] ?>" > 
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $crimen['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $crimen['id'] ?>" > 
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $crimen['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
    <?php } 
        ?>
    <?php
        if (isset($_POST['btComedia'])) {
            $comedias = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Comedia%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE COMEDIA</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($comedias as $comedia): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$comedia['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $comedia['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $comedia['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $comedia['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $comedia['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $comedia['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $comedia['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $comedia['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btSuspense'])) {
            $suspenses = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Suspense%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE SUSPENSE</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($suspenses as $suspense): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$suspense['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $suspense['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $suspense['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $suspense['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $suspense['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $suspense['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $suspense['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $suspense['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btAccion'])) {
            $accions = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Accion%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE ACCIÓN</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($accions as $accion): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$accion['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $accion['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $accion['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $accion['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $accion['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $accion['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $accion['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $accion['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btDrama'])) {
            $dramas = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Drama%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE DRAMA</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($dramas as $drama): ?>        
                <div class="movie_card">
                <?php echo "<img  src='assets/imagenesPortada/".$drama['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $drama['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $drama['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $drama['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $drama['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $drama['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $drama['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $drama['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btAventuras'])) {
            $aventuras = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Aventuras%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE AVENTURAS</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($aventuras as $aventura): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$aventura['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $aventura['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $aventura['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $aventura['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $aventura['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $aventura['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $aventura['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $aventura['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btCienciaFiccion'])) {
            $cienciaFiccions = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Ciencia ficcion%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE CIENCIA FICCIÓN</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($cienciaFiccions as $cienciaFiccion): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$cienciaFiccion['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $cienciaFiccion['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $cienciaFiccion['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $cienciaFiccion['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $cienciaFiccion['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $cienciaFiccion['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $cienciaFiccion['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $cienciaFiccion['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btTerror'])) {
            $terrors = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Terror%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE TERROR</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($terrors as $terror): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$terror['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $terror['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $terror['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $terror['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $terror['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $terror['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $terror['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $terror['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btMonstruos'])) {
            $monstruos = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Monstruos%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE MONSTRUOS</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($monstruos as $monstruo): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$monstruo['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $monstruo['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $monstruo['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $monstruo['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $monstruo['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $monstruo['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $monstruo['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $monstruo['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btSuperheroes'])) {
            $superheroes = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Superheroes%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE SUPERHÉROES</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($superheroes as $superheroe): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$superheroe['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $superheroe['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $superheroe['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $superheroe['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $superheroe['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $superheroe['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $superheroe['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $superheroe['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btFantasiaOscura'])) {
            $fantasiaOscuras = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Fantasia oscura%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE FANTASÍA OSCURA</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($fantasiaOscuras as $fantasiaOscura): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$fantasiaOscura['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $fantasiaOscura['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $fantasiaOscura['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $fantasiaOscura['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $fantasiaOscura['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $fantasiaOscura['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $fantasiaOscura['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $fantasiaOscura['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btFantasia'])) {
            $fantasias = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Fantasia%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE FANTASÍA</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($fantasias as $fantasia): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$fantasia['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $fantasia['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $fantasia['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $fantasia['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $fantasia['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $movie['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $fantasia['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $fantasi['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btMisterio'])) {
            $misterios = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Misterio%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE MISTERIO</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($misterios as $misterio): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$misterio['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $misterio['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $misterio['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $misterio['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $misterio['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $misterio['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $misterio['id'] ?>" >
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $movie['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php
        if (isset($_POST['btEspionaje'])) {
            $espionajes = $mysqli->query("SELECT * FROM tmovie WHERE GENDER LIKE '%Misterio%'")->fetch_all(MYSQLI_ASSOC);?>
            <h1 class="text-center text-light mb-2" >PELÍCULAS DE ESPIONAJE</h1>
            <div class="row justify-content-center wrapperino" id="foco">
                <?php foreach($espionajes as $espionaje): ?>        
                <div class="movie_card">
                <?php echo "<img   src='assets/imagenesPortada/".$espionaje['image']."' >" ?>
                <div class="descriptions">
                    <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $espionaje['title']; ?>  </h3>
                    <p style="line-height: 20px;height: 70%;">  <?php echo $espionaje['sinopsis']; ?></p>
                    <?php //AQUI HAY UN BUG QUE ME DEJA LOCO ?>
                    <form method="post" action="">
                        <button id='boton-mas'>
                            <a style="text-decoration: none;color:white" href="movies.php?id=<?php echo $espionaje['id'];?>">Mas info</a>
                        </button>
                    </form>
                    <?php  if(!empty($_SESSION['user_id'])){ ?>
                    <form  method="post" action="add_to_watchlist.php?id=<?php echo $espionaje['id'] ?>" >    
                    <input type="hidden" name="return" value=" <?php echo $ruta_absoluta ?>">
                    <?php 
                        $exist_watchlist = "SELECT * FROM twatchlist WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_watchlist = $mysqli ->prepare($exist_watchlist);
                        $stmt_watchlist -> bind_param("ii", $user_id, $espionaje['id']);
                        $stmt_watchlist -> execute();
                        $result_watchlist = $stmt_watchlist->get_result();
                        $row_watchlist = $result_watchlist->fetch_array(); 
                    ?>
                        <?php
                        if(!empty($row_watchlist)){?>                                            
                            <button id="boton-watchlist" name="boton-main"> <i title ="Quitar de la watchlist"class="fa-solid fa-check"></i>  </button>    
                        <?php 
                        } else { 
                        ?>
                            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>                                   
                        <?php
                        } 
                        ?> 
                    </form>
                    <form  method="post" action="add_to_favorites.php?id=<?php echo $espionaje['id'] ?>" >
                    <input type="hidden" name="return_favorites" value=" <?php echo $ruta_absoluta ?>"> 
                    <?php 
                        $exist_favorites = "SELECT * FROM tfavorites WHERE usuario_id = ? AND movie_id = ?";
                        $stmt_favorites = $mysqli ->prepare($exist_favorites);
                        $stmt_favorites -> bind_param("ii", $user_id, $espionaje['id']);
                        $stmt_favorites -> execute();
                        $result_favorites = $stmt_favorites->get_result();
                        $row_favorites = $result_favorites->fetch_array();
                    if(!empty($row_favorites)){?>    
                        <button id="boton-favorites" name="boton-favorites"> <i title="Quitar de favoritos"class="fa-solid fa-heart-circle-minus"> </i> </button>
                    <?php 
                    } else { 
                    ?>
                        <button id="boton-favorites" name="boton-favorites"> <i title="Agregar de favoritos"class="fa-solid fa-heart-circle-plus fa-beat"> </i> </button>
                    <?php
                    } 
                    ?>
                    </form>
                    <?php } ?>
                </div>                            
            </div>
            <?php endforeach; ?>
        </div>
        <?php } 
            ?>
        <?php 
    }?>
    </div>
</div>