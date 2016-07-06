<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('color_productos/nuevo')?>"> Nuevo color de producto </a>
	<br>
	<a href="<?php echo site_url('color_productos/ver')?>"> Administrar colores de productos </a>
</div>