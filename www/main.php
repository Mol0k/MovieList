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
      <div class="row default-row mt-1 mb-1" id="row-1"> <h3 class=" text-light">WANDA VISION</h3></div>
      <div class="row default-row mt-1 mb-1" id="row-2"></div>
    </div>
  </div>

  
  

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>
  <script src="/assets/js/index.js" type="module"></script>
</body>

</html>