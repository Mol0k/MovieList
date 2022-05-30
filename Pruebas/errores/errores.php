<!-- MENSAJES DE TEXTO DE LA WATCHLIST -->
<?php if(isset($_SESSION['añadida_watchlist'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php 
                    echo $_SESSION['añadida_watchlist']; 
                ?>
            </div>
            <?php
                unset($_SESSION['añadida_watchlist']);
            }?>

            <?php if(isset($_SESSION['error_delete_watchlist'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php 
                    echo $_SESSION['error_delete_watchlist']; 
                ?>
            </div>
            <?php
                    unset($_SESSION['error_delete_watchlist']);
            }?>
            <?php if(isset($_SESSION['no_logueado_Watchlist'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php echo $_SESSION['no_logueado_Watchlist']; ?>
            </div>
            <?php
                unset($_SESSION['no_logueado_Watchlist']);
            }?>

            <!-- MENSAJES DE TEXTO DE FAVORITOS -->
            <?php if(isset($_SESSION['añadida_favorites'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php 
                    echo $_SESSION['añadida_favorites']; 
                ?>
            </div>
            <?php
                    unset($_SESSION['añadida_favorites']);
            }?>

            <?php if(isset($_SESSION['error_delete_favorites'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php 
                    echo $_SESSION['error_delete_favorites']; 
                ?>
            </div>
            <?php
                    unset($_SESSION['error_delete_favorites']);
            }?>
            <?php if(isset($_SESSION['no_logueado_favorites'])){
            ?>
            <div class="w-25 p-3 alert alert-danger text-center" style="margin-top:20px;">
                <?php echo $_SESSION['no_logueado_favorites']; ?>
            </div>
            <?php
                    unset($_SESSION['no_logueado_favorites']);
            }?>