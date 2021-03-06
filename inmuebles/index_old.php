<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sitio web que unifica las publicaciones de todas las inmobiliarias de Santa Fe y la zona para alquilar o vender">
  <meta name="author" content="Andrés Gilli">

  <title>Publicaciones de todas las inmobiliarias de Santa Fe</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="./index.php">Inmuebles Santa Fe</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./index.php">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./alquiler.php">Alquiler</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./venta.php">Venta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contacto.php">Contacto</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">Categorías</h1>
        <div class="list-group">
          <a href="#" class="list-group-item">Casa</a>
          <a href="#" class="list-group-item">Departamento</a>
		  <a href="#" class="list-group-item">Casaquinta</a>
		  <a href="#" class="list-group-item">Cochera</a>
		  <a href="#" class="list-group-item">Oficina</a>
		  <a href="#" class="list-group-item">Local</a>
		  <a href="#" class="list-group-item">Galpón</a>
		  <a href="#" class="list-group-item">Terreno</a>
		  <a href="#" class="list-group-item">Campo</a>
        </div>
		
		<h1 class="my-4">Filtros</h1>
        <div class="list-group">
          <a href="#" class="list-group-item">Mono ambiente</a>
          <a href="#" class="list-group-item">1 Dormitorio</a>
		  <a href="#" class="list-group-item">2 Dormitorios</a>
		  <a href="#" class="list-group-item">3 o más Dormitorios</a>
		  <a href="#" class="list-group-item">Santa Fe</a>
		  <a href="#" class="list-group-item">Colastiné</a>
		  <a href="#" class="list-group-item">Rincón</a>
		  <a href="#" class="list-group-item">Santo Tomé</a>
		  <a href="#" class="list-group-item">Sauce Viejo</a>
		  <a href="#" class="list-group-item">Otras</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="./img/publicidad.jpg" alt="Primer publicidad">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./img/publicidad.jpg" alt="Segunda publicidad">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./img/publicidad.jpg" alt="Tercer publicidad">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row justify-content-center">
			<h1 class="h1">Primero seleccione el tipo de operación</h1>
        </div>
        <!-- /.row -->
		<div class="row justify-content-center">
			<div class="list-group list-group-horizontal">
				<a class="list-group-item" href="./alquiler.php">Alquiler</a>
				<a class="list-group-item" href="./venta.php">Venta</a>
			</div>
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Inmuebles Santa Fe</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
