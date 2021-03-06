   <!-- Navigation -->
   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">GALA</a>

      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="<?php echo base_url("index.php/login"); ?>">Iniciar sesión</a> 
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-md-3">
        <div class="list-group">
          <a href="#" class="list-group-item" onclick="quitarFiltro();">Todos los productos</a>

          <?php foreach ($tipo_productos as $tipo_producto)  { ?>

          <a href="#" class="list-group-item" onclick="filtrar(<?php echo $tipo_producto['id_tipo_producto'] ?>);"><?php echo $tipo_producto['tipo'] ?></a>

          <?php }?>
        </div>
      </div>

      <div class="col-md-9">

        <div class="row carousel-holder">

          <div class="col-md-12">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="item active">
                  <img class="slide-image" src="<?php echo base_url("assets/img/slider1.jpg"); ?>" alt="slider1">
                </div>
                <div class="item">
                  <img class="slide-image" src="<?php echo base_url("assets/img/slider2.png"); ?>" alt="slider2">
                </div>
                <div class="item">
                  <img class="slide-image" src="<?php echo base_url("assets/img/slider3.jpg"); ?>" alt="slider3">
                </div>
              </div>
              <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
              </a>
            </div>
          </div>
        </div>

        <div class="row" id="productos">
          <?php foreach ($productos as $producto)  { ?>

              <div class="col-sm-4 col-lg-4 col-md-4 <?php echo $producto['id_tipo_producto'] ?>">
               <div class="thumbnail">
                <img class="img-thumbnail" src="<?php echo base_url('assets/img/'.$producto['imagen_url'] )?>" alt="imagen_producto">
                <div class="caption">
                  <h4 class="pull-right">
                  <b>$<?php echo $producto['precio_venta_efectivo'] ?></b>
                  </h4>
                  <h4><b><?php echo $producto['codigo']?></b></h4>
                  <p><?php echo $producto['detalles']?></p>
              </div>
            </div>
          </div>

          <?php }?>
        </div>
      </div>

    </div>

</div>

<script type="text/javascript">
  function filtrar(id_tipo_producto){

    filtro = '.' + id_tipo_producto;

    $('#productos').children().not(filtro).hide();
    $('#productos').children(filtro).show();

  };

  function quitarFiltro(){
     $('#productos').children().show();
  }
</script>