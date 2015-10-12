
<div class="container">
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">GALA</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th-list"></span> Usuarios <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url("index.php/usuarios/nuevo"); ?>">Crear usuario</a></li>
                  <li><a href="<?php echo base_url("index.php/usuarios/ver"); ?>">Ver usuarios</a></li>
                  <li><a href="<?php echo base_url("index.php/categoria_usuarios/nueva"); ?>">Crear categoría de usuario</a></li>
                  <li><a href="<?php echo base_url("index.php/categoria_usuarios/ver"); ?>">Ver categorías de usuario</a></li>
                </ul>
              </li>
            </ul>
             <ul class="nav navbar-nav navbar-left">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Productos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url("index.php/productos/nuevo"); ?>">Crear producto</a></li>
                  <li><a href="<?php echo base_url("index.php/productos/ver"); ?>">Ver productos</a></li>
                  <li><a href="<?php echo base_url("index.php/tipo_productos/nuevo"); ?>">Crear tipo de producto</a></li>
                  <li><a href="<?php echo base_url("index.php/tipo_productos/ver"); ?>">Ver tipos de productos</a></li>
                  <li><a href="<?php echo base_url("index.php/color_productos/nuevo"); ?>">Crear color de producto</a></li>
                  <li><a href="<?php echo base_url("index.php/color_productos/ver"); ?>">Ver colores de productos</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="<?php echo base_url("index.php/logout/terminar_sesion"); ?>" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" onclick="return confirm('¿Cerrar sesión?');">
                  <span class="glyphicon glyphicon-off"></span> Cerrar sesión
                </a>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
</div>
