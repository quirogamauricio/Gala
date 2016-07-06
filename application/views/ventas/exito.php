<?php $this->load->helper('url'); ?>

<div class="container">
	<?php echo $mensaje ?>
	<a href="<?php echo site_url('ventas/nueva')?>"> Nueva venta </a> 
	<br>
	<a href="<?php echo site_url('ventas/ver')?>"> Historial de ventas </a>
</div>