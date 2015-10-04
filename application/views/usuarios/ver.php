<?php $this->load->helper('url'); ?>

<h2><?php echo $titulo; ?></h2>
<div>
	<?php if(isset($contenido)) 
	{ 
		echo $contenido;
	} 
	else
	{?>
		<?php echo validation_errors(); ?>

		<?php echo form_open('usuarios/editar'); ?>

		<input type="hidden" name="id_usuario" value="<?php echo set_value('id_usuario', $id_usuario);?>"/>

		<label for="categoria">Categoría</label>
	    <?php echo form_dropdown('categoria', $categorias, $id_categoria);?><br />

	    <label for="nombre_usuario">Email</label>
	    <input type="input" name="email" value="<?php echo set_value('email', $email);?>"/><br />

	    <label for="nombre_usuario">Confirmación de email</label>
	    <input type="input" name="confirmacion_email" value="<?php echo set_value('confirmacion_email', $email);?>"/><br />

	    <input type="submit" name="submit" value="Actualizar"/>
	    <a href="<?php echo site_url('usuarios/eliminar') . '/' . $id_usuario ?>">Eliminar</a>

		</form>	
	<?php } ?>
</div>