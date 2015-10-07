<div class="container">
	<h2><?php echo $title; ?></h2>

	<?php echo validation_errors(); ?>

	<?php echo form_open('tipo_productos/nuevo'); ?>

	<div class="form-group">
		<label for="categoria">Tipo</label>
		<input type="input" class="form-control" name="tipo" value="<?php echo set_value('tipo');?>"/><br />
	</div>

    <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />

</form>	
</div>