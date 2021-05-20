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
          <li class="nav-item">
            <a class="nav-link" href="./index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Alquiler</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Venta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="./contacto.php">Contacto
				<span class="sr-only">(current)</span>
			</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4">Poner publicidad</h1>
        

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

        <div>
			<div class="form">
			  <div id="success_message" style="width:100%; height:100%; display:none; ">Tu mensaje ha sido enviado, ¡Muchas gracias!</div>
			  <div id="error_message" style="width:100%; height:100%; display:none; ">El mensaje no pudo ser enviado, intentelo nuevamente más tarde</div>
			  <form method="post" role="form" class="contactForm" id="reused_form">
				<div class="form-row">
				  <div class="form-group col-md-6">
					<input type="text" name="name" class="form-control" id="name" placeholder="Nombre" data-rule="minlen:4" data-msg="Ingrese como mínimo 4 caracteres" />
					<div class="validation"></div>
				  </div>
				  <div class="form-group col-md-6">
					<input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" data-rule="email" data-msg="Por favor ingrese un email válido" />
					<div class="validation"></div>
				  </div>
				</div>
				<div class="form-group">
				  <textarea class="form-control" name="message" id="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Mensaje"></textarea>
				  <div class="validation"></div>
				</div>
				<div class="text-center"><button type="submit" class="btn btn-primary bg-dark font-weight-bold">Enviar mensaje</button></div>
			  </form>
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
  
  <!-- Email sender -->
  <script src="form.js"></script>

</body>

</html>
