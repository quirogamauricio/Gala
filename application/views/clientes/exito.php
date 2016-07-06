<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('clientes/nuevo') ?>">Nuevo clientes</a>
	<br>
	<a href="<?php echo site_url('clientes/ver') ?>">Administrar clientes</a>
</div>