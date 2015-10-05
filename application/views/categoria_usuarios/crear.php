<div class="container">
	<h2><?php echo $title; ?></h2>

	<?php echo validation_errors(); ?>

	<?php echo form_open('categoria_usuarios/nueva'); ?>

	<label for="categoria">Categoría</label>
	<input type="input" name="categoria" value="<?php echo set_value('categoria');?>"/><br />

    <input type="submit" name="submit" value="Aceptar" />

</form>	
</div>