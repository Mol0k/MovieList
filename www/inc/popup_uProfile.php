
<?php
$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div id="popup2" class="popup-overlay text-light">
    <div class="log-popup">
        <h1 class="text-center mt-3">Editar perfil</h1>
        <a class="close-window" href="#">&times;</a>
        <div class="log-content">
            <form method="POST" name="formulario" action="update_username.php" role="form" enctype="multipart/form-data">
                <div class="form-group mt-3">
                    <label for="usernames">Nuevo username:</label>
                    <input type="text" name="username" id="usernames" class="form-control"
                        value="">
                        <!-- <label for="f_nacimientos" class="form-label">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" name="f_nacimiento" id="f_nacimientos" /> -->
                </div>
                <input type="hidden" name="return_username" value=" <?php echo $link ?>">
                <button type="submit" name="update_username" class="btn btn-success mt-3"><span class="glyphicon glyphicon-check"></span> Actualizar nombre</button>
            </form>
            <form method="POST" action="update_image_profile.php" role="form" enctype="multipart/form-data">
                <div class="form-group mt-3">
                    <label for="imagenUsuarios">Sube tu avatar:</label>
                    <input type="file" name="imagenUsuario" id="imagenUsuarios" onchange="preview()" class="form-control"">
                        <img id="frame" alt ="Sube una imagen para ver la previsualización" src="" width="60" height="60" class="rounded-circle mt-3" />
                </div>
                    <input type="hidden" name="return_image" value=" <?php echo $link ?>">
                    <button type="submit" name="update_avatar" class="btn btn-success mt-3"><span class="glyphicon glyphicon-check"></span> Actualizar avatar</button>
            </form>            
                
                <!-- MENSAJES QUE SE PINTARAN POR PANTALLA -->
                    
                <?php if(isset($_SESSION['successUser'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['successUser']; ?>
                </div>
                <?php
                    unset($_SESSION['successUser']);
                }?>
                <?php if(isset($_SESSION['error_update_username'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['error_update_username']; ?>
                </div>
                <?php
                    unset($_SESSION['error_update_username']);
                }?> 

                <!-- MENSAJE DE QUE SE HA SUBIDO LA IMAGEN -->
                <?php if(isset($_SESSION['successProfileImage'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['successProfileImage']; ?>
                </div>
                <?php
                    unset($_SESSION['successProfileImage']);
                }?> 
                
                <!-- MENSAJE DE ERROR IMAGEN -->
                <?php if(isset($_SESSION['error_profile_image'])){
                ?>
                <div class="alert alert-danger text-center  mt-2" style="margin-top:20px;">
                    <?php echo $_SESSION['error_profile_image']; ?>
                </div>
                <?php
                    unset($_SESSION['error_profile_image']);
                }?>                 
        </div>
    </div>
</div>
<script>
    function preview() {
        frame.src=URL.createObjectURL(event.target.files[0]);
    }
</script>