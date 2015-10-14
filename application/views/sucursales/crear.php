<div class="container">
	<h2><?php echo $title; ?></h2>

	<?php echo validation_errors(); ?>

	<?php echo form_open('sucursales/nueva'); ?>

	<div class="form-group">
		<label for="sucursal">Sucursal</label>
		<input type="input" class="form-control" name="sucursal" value="<?php echo set_value('sucursal');?>"/><br />
	</div>
	<div class="form-group">
		<label for="direccion">Dirección</label>
		<input type="input" class="form-control" name="direccion" value="<?php echo set_value('direccion');?>"/><br />
	</div>

    <input type="submit" class="btn btn-default"name="submit" value="Aceptar" />

</form>	
</div>