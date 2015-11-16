
<div class="container">
  <!-- Static navbar -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">GALA</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span> Usuarios <span class="caret"></span></a>
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Clientes <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url("index.php/clientes/nuevo"); ?>">Crear cliente</a></li>
              <li><a href="<?php echo base_url("index.php/clientes/ver"); ?>">Ver clientes</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Productos <span class="caret"></span></a>
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
         <ul class="nav navbar-nav navbar-left">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Cajas <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url("index.php/cajas/nueva"); ?>">Crear caja</a></li>
              <li><a href="<?php echo base_url("index.php/cajas/ver"); ?>">Ver cajas</a></li>
              <li><a href="<?php echo base_url("index.php/movimientos_caja/nuevo"); ?>">Registrar movimiento</a></li>
              <li><a href="<?php echo base_url("index.php/movimientos_caja/ver"); ?>">Ver movimientos</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Ventas <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url("index.php/ventas/nueva"); ?>">Registrar venta</a></li>
              <li><a href="<?php echo base_url("index.php/ventas/ver"); ?>">Ver ventas</a></li>
            </ul>
          </li>
        </ul>
         <ul class="nav navbar-nav navbar-left">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Reportes <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url("index.php/reportes"); ?>">Ver reportes</a></li>
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
