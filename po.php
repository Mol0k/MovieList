<div class="movie_card">
    <?php echo "<img   src='assets/imagenesPortada/".$movie['image']."' >" ?>
    <div class="descriptions">
        <h3 style=" color: #ff3838;margin: 2px; margin-bottom:5px"> <?php echo $movie['title']; ?>  </h3>
        <p style="line-height: 20px;height: 70%;">  <?php echo $movie['sinopsis']; ?></p>
        <form method="post" action="movies.php?id=<?php echo $movie['id'] ?>" >
            <button id='boton-mas'>Mas info</button>
        </form>
        <?php  if(!empty($_SESSION['user_id'])){ ?>
        <form  method="post" action="add_to_watchlist.php?id=<?php echo $movie['id'] ?>" >    
            <input type="hidden" name="return" value=" <?php echo $link ?>">
            <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>        
        </form>

        <form  method="post" action="add_to_favorites.php?id=<?php echo $movie['id'] ?>" >    
            
            <button id="boton-favorites" name="boton-main"> <i title="Agregar a favoritos"class="fa-solid fa-heart"> </i> </button>
        </form>
        <?php } ?>
        </div>
         <?php
            echo "<form method='post' action='movies.php?id=".$movie['id']."' >
                                    <button id='boton-mas'>Mas info</button>
            </form>";
                                    if(!empty($_SESSION['user_id'])){
                                    echo '<form  method="post" action="add_to_watchlist.php?id='.$movie['id'].'" >
                                    <input type="hidden" name="return" value=" '.$link.'"?>
                                    <button id="boton-watchlist" name="boton-main"> <i title="Agregar a la watchlist"class="fa-solid fa-circle-plus fa-beat"> </i> </button>
                                    </form>';
                                    echo '<form  method="post" action="add_to_favorites.php?id='.$movie['id'].'" >
                                    <button id="boton-favorites"> <i title="Agregar a favoritos"class="fa-solid fa-heart fa-beat"> </i> </button>
                                    </form>';
                                    }
                                    ?>                                 
                            