<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('cajas/nueva')?>">Nueva caja</a>
	<br>
	<a href="<?php echo site_url('cajas/ver')?>">Administrar cajas</a>
</div>