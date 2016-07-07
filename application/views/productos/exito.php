<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('productos/nuevo') ?>">Nuevo producto</a>
	<br>
	<a href="<?php echo site_url('productos/ver') ?>">Administrar productos</a>
</div>