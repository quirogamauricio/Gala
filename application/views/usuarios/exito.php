<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('usuarios/nuevo') ?>">Nuevo usuario</a>
	<br>
	<a href="<?php echo site_url('usuarios/ver') ?>">Administrar usuarios</a>
</div>