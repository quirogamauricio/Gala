<div class="container">
	<h2><?php echo $title; ?></h2>

	<?php echo validation_errors(); ?>

	<?php echo form_open('categoria_usuarios/nueva'); ?>

	<div class="form-group">
		<label for="categoria">Categoría</label>
		<input type="input" class="form-control" name="categoria" value="<?php echo set_value('categoria');?>"/>
	</div>

	<br />

    <input type="submit" class="btn btn-default"name="submit" value="Aceptar" />

</form>	
</div>