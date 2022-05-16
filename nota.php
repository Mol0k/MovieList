<?php 
            $consulta = 'SELECT * FROM tmovie';
            $resultado = mysqli_query($mysqli, $consulta) or die('Query Error');
            while($fila = mysqli_fetch_array($resultado)){
              $variable= unserialize($fila['gender']);  
                echo '<h1>'.$fila['title'].'</h1>';
                echo '<p>'.$fila['sinopsis'].'</p>';
                echo "<img style='width:15%;' src='assets/imagenesPortada/".$fila['image']."' >";   
                echo '<p>'.$fila['created'].'</p>';
                foreach($variable as $value){
                  echo '<p>'.$value.' </p>';
                }
                echo '<p>'.$fila['duration'].' </p>'; 
            }
        ?>

<?php
ini_set('display_errors', 'On');
require __DIR__ . '/../php_util/db_connection.php';

// session_start();
$mysqli = get_db_connection_or_die();

session_start();
  if(isset($_POST['records-limit'])){
      $_SESSION['records-limit'] = $_POST['records-limit'];
  }
  
  $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 2;
  $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
  $paginationStart = ($page - 1) * $limit;
  $authors = $mysqli->query("SELECT * FROM tmovie  LIMIT $paginationStart, $limit")->fetch_all(MYSQLI_ASSOC);
  // Get total records
  $sql = $mysqli->query("SELECT count(id) AS id FROM tmovie")->fetch_all(MYSQLI_ASSOC);
  $allRecrods = $sql[0]['id'];
  
  // Calculate total pages
  $totoalPages = ceil($allRecrods / $limit);
  // Prev + Next
  $prev = $page - 1;
  $next = $page + 1;


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="shortcut icon" href="#">
  <style>
        .container {
            max-width: 1000px
        }
        .custom-select {
            max-width: 150px
        }
    </style>
  <title>MovieList</title>
</head>

<body class="bg-dark">

  <div class="error-container"></div>

  <div class="error"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MovieList</a>
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
            <a class="nav-link" href="#">Películas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Películas Vistas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Películas deseadas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add_movie.php">Añadir Películas</a>
          </li>
          
        </ul>
        <form class="d-flex justify-content-end ms-2">
          <input class="form-control me-2 my-input"  type="search" placeholder="Buscar peliculas" aria-label="Search">
          <button class="btn btn-primary btn-search" type="submit">Buscar</button>
          <button class="btn btn-success btn-signin ms-2" type="submit"  formaction="login.php">Iniciar</button>
          <a class="btn btn-danger btn-signout ms-2" href="register.php" role="button">Registrate</a>
        </form>
      </div>
    </div>
  </nav>

  <div id="myCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
        aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active" style="background-image: url('/assets/images/popcorn.jpg');">
        <div class="container carousel-info"></div>
      </div>
      <div class="carousel-item" style="background-image: url('/assets/images/netflix.jpg');">
        <div class="container carousel-info"></div>
      </div>
      <div class="carousel-item" style="background-image: url('/assets/images/tv.jpg');">
        <div class="container carousel-info"></div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="cards-container">
    <h2 class="text-center text-light mb-4">PELICULAS POPULARES</h2>
    <div class="container-fluid">
      <div class="row new-row mt-1 mb-1">
        
      </div>
      <div class="text-light row default-row mt-1 mb-1" id="row-1"> 
      <div class="text-light container mt-5">
        <h2 class="text-center mb-5">Simple PHP Pagination Demo</h2>

        <!-- Select dropdown -->
        <div class="text-light d-flex flex-row-reverse bd-highlight mb-3">
            <form action="main.php" method="post">
                <select name="records-limit" id="records-limit" class="custom-select">
                    <option disabled selected>Records Limit</option>
                    <?php foreach([2,4,8,10] as $limit) : ?>
                    <option
                        <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                        value="<?= $limit; ?>">
                        <?= $limit; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <!-- Datatable -->
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Email</th>
                    <th scope="col">DOB</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($authors as $author): ?>
                <tr>
                    <th scope="row"><?php echo $author['id']; ?></th>
                    <td><?php echo $author['title']; ?></td>
                    <td><?php echo $author['sinopsis']; ?></td>
                    <td><?php echo "<img style='width:15%;' src='assets/imagenesPortada/".$author['image']."' >" ?></td>
                    <td><?php echo $author['created']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav aria-label="Page navigation example mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Previous</a>
                </li>
                <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                    <a class="page-link" href="main.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                    <a class="page-link"
                        href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#records-limit').change(function () {
                $('form').submit();
            })
        });
    </script>
      </div>
      <div class="row default-row mt-1 mb-1" id="row-2"></div>
    </div>
  </div>

  
  

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>
  <script src="/assets/js/index.js" type="module"></script>
</body>

</html>