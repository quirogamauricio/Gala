<div class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url("index.php/principal"); ?>">GALA</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url("index.php/usuarios/nuevo"); ?>">Nuevo usuario</a></li>
            <li><a href="<?php echo base_url("index.php/usuarios/ver"); ?>">Administrar usuarios</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Categorías</li>
            <li><a href="<?php echo base_url("index.php/categoria_usuarios/nueva"); ?>">Nueva categoría de usuario</a></li>
            <li><a href="<?php echo base_url("index.php/categoria_usuarios/ver"); ?>">Administrar categorías de usuario</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url("index.php/clientes/nuevo"); ?>">Nuevo cliente</a></li>
            <li><a href="<?php echo base_url("index.php/clientes/ver"); ?>">Administrar clientes</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url("index.php/productos/nuevo"); ?>">Nuevo producto</a></li>
            <li><a href="<?php echo base_url("index.php/productos/ver"); ?>">Administrar productos</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Tipos</li>
            <li><a href="<?php echo base_url("index.php/tipo_productos/nuevo"); ?>">Nuevo tipo de producto</a></li>
            <li><a href="<?php echo base_url("index.php/tipo_productos/ver"); ?>">Administrar tipos de productos</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Colores</li>
            <li><a href="<?php echo base_url("index.php/color_productos/nuevo"); ?>">Nuevo color de producto</a></li>
            <li><a href="<?php echo base_url("index.php/color_productos/ver"); ?>">Administrar colores de productos</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cajas<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url("index.php/cajas/nueva"); ?>">Nueva caja</a></li>
            <li><a href="<?php echo base_url("index.php/cajas/ver"); ?>">Administrar cajas</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Movimientos</li>
            <li><a href="<?php echo base_url("index.php/movimientos_caja/nuevo"); ?>">Nuevo movimiento</a></li>
            <li><a href="<?php echo base_url("index.php/movimientos_caja/ver"); ?>">Administrar movimientos</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ventas<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url("index.php/ventas/nueva"); ?>">Nueva venta</a></li>
            <li><a href="<?php echo base_url("index.php/ventas/ver"); ?>">Administrar ventas</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!--/.nav-collapse -->
  </div>
</div>