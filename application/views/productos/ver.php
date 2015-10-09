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

		<?php echo form_open('productos/editar'); ?>

		<input type="hidden" name="id_producto" value="<?php echo set_value('id_producto', $id_producto);?>"/>
		<input type="hidden" name="email_original" value="<?php echo set_value('email_original', $email_original);?>"/>

		<div class="form-group">
			<label for="categoria">Categoría</label>
		    <?php echo form_dropdown('categoria', $categorias, $id_categoria, 'class="form-control"');?><br />
		</div>

		<div class="form-group">
		    <label for="nombre_producto">Email</label>
		    <input type="input" class="form-control" name="email" value="<?php echo set_value('email', $email);?>"/><br />
		</div>

		<div class="form-group">
		    <label for="nombre_producto">Confirmación de email</label>
		    <input type="input" class="form-control" name="confirmacion_email" value="<?php echo set_value('confirmacion_email', $email);?>"/><br />
		</div>

	    <input type="submit" name="submit" value="Actualizar" class="btn"/>
	    <a href="<?php echo site_url('productos/eliminar') . '/' . $id_producto ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste producto?');">Eliminar</a>

		</form>	
	<?php } ?>
</div>