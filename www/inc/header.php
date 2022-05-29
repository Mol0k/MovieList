<?php 
$mysqli = get_db_connection_or_die();

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" >
    <div class="container-fluid">
        <!-- <a class="navbar-brand" href="main.php">
                <img src="./assets/images/icon.png" width="24px" height="24px" alt="logo">MovieList
            </a> -->
        <a class="navbar-brand" href="main.php">MovieList</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                <li class="nav-item">
                    <a class="nav-link active" href="main.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="all_movies.php">Películas</a>
                </li>
                <?php if (!empty($_SESSION['user_id'])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="watchlist.php">Películas Vistas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favorites.php">Películas favoritas</a>
                </li>
                <?php 
                $role_sql = "SELECT * FROM tuser WHERE id = '".$_SESSION['user_id']."'";
                $query = $mysqli->query($role_sql);
                $row_role = $query->fetch_assoc();
                if($row_role['roles'] == 'admin'){?>
                <li class="nav-item">
                    <a class="nav-link" href="add_movie.php">Añadir Películas</a>
                </li>
                <?php }else{ ?>
                    <h1></h1>
                <?php } ?>
                    
                <?php } ?>

            </ul>
            <form class="d-flex justify-content-end ms-2" action="backend-search.php" method="GET">

                <input class="form-control me-2 my-input" label="boton-search" type="text" placeholder="Ejemplo: Sonic"
                    name="query" required />
                <button class="btn btn-primary btn-search" id="boton-search" type="submit"
                    value="Search">Buscar</button>
                <?php if (empty($_SESSION['user_id'])) {
                ?>
                <a class="btn btn-success btn-signin ms-2" href="login.php" role="button">Iniciar</a>
                <a class="btn btn-danger btn-signout ms-2" href="register.php" role="button">Registrate</a>

                <?php } else { ?>
                <ul class="navbar-nav bg-dark"">
                        <li class=" nav-item dropdown ms-2">
                    <a href="#" class="nav-link dropdown-toggle bg-dark" data-bs-toggle="dropdown"
                        id="navbarDropdownMenuLink" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php
                            $query = "SELECT profile_image FROM tuser WHERE id = " . $_SESSION['user_id'] ;
                            $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
                            $row = mysqli_fetch_array($result);
                            $profile_image = $row['profile_image'];

                            if(empty($profile_image)){
                                $profile_image = "default-user.png";
                                echo "<img width='35' height='35' class='rounded-circle' src='assets/images/".$profile_image."' >" ;
                            }else{ 
                                echo "<img width='35' height='35' class='rounded-circle' src='assets/imagenesUsuario/".$row['profile_image']."' >" ; 
                            }
                        ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profile.php">Panel</a>
                        <a class="dropdown-item" href="#popup1">Editar contraseña</a>
                        <a class="dropdown-item" href="#popup2">Editar perfil</a>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                    </li>
                </ul>
                <?php } ?>
            </form>
        </div>
    </div>
</nav>