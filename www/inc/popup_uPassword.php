
<?php
$ruta_absoluta = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div id="popup1" class="popup-cuadro  text-light">
    <div class="log-popup">
        <h1 class="text-center mt-3">Cambiar la contraseña</h1>
        <a class="cerrar-ventana" href="#">&times;</a>
        <div class="contenido-pop">
            <form method="POST" action="update_password.php">
                <div class="form-group mt-3">
                    <label for="password_old">Contraseña antigua:</label>
                    <input type="password" name="password_old" id="password_old" class="form-control"
                        alue="<?php echo (isset($_SESSION['password_old'])) ? $_SESSION['password_old'] : ''; ?>">
                </div>
                <div class="form-group mt-3">
                    <label for="password_nueva">Nueva contraseña:</label>
                    <input type="password" name="password_nueva" id="password_nueva" class="form-control"
                        value="<?php echo (isset($_SESSION['password_nueva'])) ? $_SESSION['password_nueva'] : ''; ?>">
                </div>
                <div class="form-group mt-3">
                    <label for="password_confirmar">Confirmar la nueva contraseña:</label>
                    <input type="password" name="password_confirmar" id="password_confirmar" class="form-control "
                        value="<?php echo (isset($_SESSION['password_confirmar'])) ? $_SESSION['password_confirmar'] : ''; ?>">
                </div>
                <input type="hidden" name="return_profile" value=" <?php echo $ruta_absoluta ?>">
                <button type="submit" name="update" class="btn btn-success mt-3"><span
                    class="glyphicon glyphicon-check"></span> Actualizar contraseña</button>
            </form>
                <!-- MENSAJES QUE SE PINTARAN POR PANTALLA -->
                <?php if(isset($_SESSION['error'])){?>
					
                <div class="alert alert-danger text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']);}
					if(isset($_SESSION['success'])){?>
				
                <div class="alert alert-success text-center" style="margin-top:20px;">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); } ?>
        </div>
    </div>
</div>