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

		<?php echo form_open('tipo_productos/editar'); ?>
	
		<input type="hidden" name="id_tipo_producto" value="<?php echo set_value('id_tipo_producto', $id_tipo_producto);?>"/>
		<input type="hidden" name="tipo_original" value="<?php echo set_value('tipo_original', $tipo_original);?>"/>
		
		<div class="form-group">
		    <label for="tipo">Tipo</label>
		    <input type="input" name="tipo" class="form-control"value="<?php echo set_value('tipo', $tipo);?>"/><br />
		</div>

	    <input type="submit" name="submit" value="Actualizar" class="btn"/>

	    <a href="<?php echo site_url('tipo_productos/eliminar') . '/' . $id_tipo_producto?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste tipo?');">Eliminar</a>

		</form>	
<?php } ?>
</div>


