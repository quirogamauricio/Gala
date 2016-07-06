<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('movimientos_caja/nuevo')?>"> Nuevo movimientos de caja </a>
	<br>
	<a href="<?php echo site_url('movimientos_caja/ver')?>"> Historial de movimientos de caja </a>
</div>