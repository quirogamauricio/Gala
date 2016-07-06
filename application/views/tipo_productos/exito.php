<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('tipo_productos/nuevo')?>"> Nuevo tipo de producto </a>
	<br>
	<a href="<?php echo site_url('tipo_productos/ver')?>"> Administrar tipos de productos </a>
</div>