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
          <li class="nav-item active">
            <a class="nav-link" href="./alquiler.php">Alquiler
				<span class="sr-only">(current)</span>
			</a>
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
	<?php
		$where = "WHERE (";
		$primero = true;
		$anterior = "";
		if(isset($_POST['btn-filtrar'])){//to run PHP script on submit
			if(!empty($_POST['filter'])){
			// Loop to store and display values of individual checked checkbox
				foreach($_POST['filter'] as $selected){
					// hay que componer el sql para la consulta
					if($primero) {
						$where = $where.$selected;
						$primero = false;
						$anterior = $selected;
					} else {
						$actual = substr($selected, 0, 3);
						$anterior = substr($anterior, 0, 3);
						if(strcmp($anterior,$actual) == 0){
							$where = $where." OR ".$selected;
						} else {
							$where = $where.") AND (".$selected;
						}
						$anterior = $selected;
					}
				}
				$where = $where.")";
			} else header('Location: ./error_filter.html');
		} else header('Location: ./error_submit.html');
	?>
    <div class="row">
      <div class="col-lg-3">
      <h1 class="my-4">Filtros</h1>
	  <form id="filter" action="./alquiler_filtros.php" method="POST">
        <div class="list-group">
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check1" name="filter[]" value="tipo='Casa'"
			<?php if(in_array("tipo='Casa'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check1">Casa</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check2" name="filter[]" value="tipo='Departamento'"
			<?php if(in_array("tipo='Departamento'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check2">Departamento</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check3" name="filter[]" value="tipo='Casaquinta'"
			<?php if(in_array("tipo='Casaquinta'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check3">Casaquinta</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check4" name="filter[]" value="tipo='Cochera'"
			<?php if(in_array("tipo='Cochera'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check4">Cochera</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check5" name="filter[]" value="tipo='Oficina'"
			<?php if(in_array("tipo='Oficina'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check5">Oficina</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check6" name="filter[]" value="tipo='Local'"
			<?php if(in_array("tipo='Local'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check6">Local</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check7" name="filter[]" value="tipo='Galpón'"
			<?php if(in_array("tipo='Galpón'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check7">Galpón</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check8" name="filter[]" value="tipo='Terreno'"
			<?php if(in_array("tipo='Terreno'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check8">Terreno</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check9" name="filter[]" value="tipo='Campo'"
			<?php if(in_array("tipo='Campo'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check9">Campo</label>
		  </div>
          <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check10" name="filter[]" value="dormitorios='Monoambiente'"
			<?php if(in_array("dormitorios='Monoambiente'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check10">Monoambiente</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check11" name="filter[]" value="dormitorios='1'"
			<?php if(in_array("dormitorios='1 Dormitorio'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check11">1 Dormitorio</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check12" name="filter[]" value="dormitorios='2'"
			<?php if(in_array("dormitorios='2 Dormitorios'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check12">2 Dormitorios</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check13" name="filter[]" value="dormitorios>='3'"
			<?php if(in_array("dormitorios='3 Dormitorios'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check13">3 o más Dormitorios</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check14" name="filter[]" value="localidad='Santa Fe'"
			<?php if(in_array("localidad='Santa Fe'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check14">Santa Fe</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check15" name="filter[]" value="localidad='Colastiné'"
			<?php if(in_array("localidad='Colastiné'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check15">Colastiné</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check16" name="filter[]" value="localidad='Rincón'"
			<?php if(in_array("localidad='Rincón'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check16">Rincón</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check17" name="filter[]" value="localidad='Santo Tomé'"
			<?php if(in_array("localidad='Santo Tomé'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check17">Santo Tomé</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check18" name="filter[]" value="localidad='Sauce Viejo'"
			<?php if(in_array("localidad='Sauce Viejo'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check18">Sauce Viejo</label>
		  </div>
		  <div class="list-group-item">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="check19" name="filter[]" value="localidad='Otras'"
			<?php if(in_array("localidad='Otras'",$_POST['filter'])) echo ' checked="checked"';?>>
			<label class="form-check-label" for="check19">Otras</label>
		  </div>
        </div>
		<div class="list-group-item border-0 text-center">		  
		  <button type="submit" class="btn btn-primary bg-dark font-weight-bold" id="btn-filtral" name="btn-filtrar">Filtrar</button>
		</div>
		</form>

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

        <div class="row">
		  <?php 
			require_once('conexion.php');
			$conn = new conexion();
			$alquileres = $conn->consulta_alquiler_filtro($where);
			foreach ($alquileres as $alquiler):
		  ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href=<?php echo $alquiler["url"]; ?> target="_blank"><img class="card-img-top" src=<?php echo $alquiler["url_foto"]; ?> alt="Foto inmueble"></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href=<?php echo $alquiler["url"]; ?> target="_blank"><?php echo $alquiler["domicilio"]; ?></a>
                </h4>
                <h5><?php echo $alquiler["precio"]; ?></h5>
                <p class="card-text">
					<?php echo "Dormitorios: ".$alquiler["dormitorios"]."<br>"; ?>
					<?php echo "Tipo: ".$alquiler["tipo"]."<br>"; ?>
					<?php echo "Barrio: ".$alquiler["barrio"]."<br>"; ?>
					<?php echo "Localidad: ".$alquiler["localidad"]."<br>"; ?>
				</p>
              </div>
              <div class="card-footer">
                <a href=<?php echo $alquiler["url"]; ?> target="_blank">Enlace a la inmobiliaria</a>
              </div>
            </div>
          </div>
		  <?php endforeach; ?>


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
