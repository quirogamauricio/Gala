<?php $this->load->helper('url'); ?>

<div class="container">
	<h2><?php echo $titulo; ?></h2>
	<?php if(isset($contenido)) 
	{ 
		echo $contenido;
	} 
	else
	{?>
		<?php echo validation_errors(); ?>

		<?php echo form_open('color_productos/editar'); ?>
	
		<input type="hidden" name="id_color_producto" value="<?php echo set_value('id_color_producto', $id_color_producto);?>"/>
		<input type="hidden" name="color_original" value="<?php echo set_value('color_original', $color_original);?>"/>
		
		<div class="form-group">
		    <label for="color">Color</label>
		    <input type="input" name="color" class="form-control"value="<?php echo set_value('color', $color);?>"/><br />
		</div>

	    <input type="submit" name="submit" value="Actualizar" class="btn"/>

	    <a href="<?php echo site_url('color_productos/eliminar') . '/' . $id_color_producto?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste color?');">Eliminar</a>

		</form>	
<?php } ?>
</div>