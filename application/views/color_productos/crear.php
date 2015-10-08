<div class="container">
	<h2><?php echo $title; ?></h2>

	<?php echo validation_errors(); ?>

	<?php echo form_open('color_productos/nuevo'); ?>

	<div class="form-group">
		<label for="categoria">Color</label>
		<input type="input" class="form-control" name="color" value="<?php echo set_value('color');?>"/><br />
	</div>

    <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />

</form>	
</div>