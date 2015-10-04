<?php $this->load->helper('url'); ?>

<h2><?php echo $titulo; ?></h2>

<?php if(isset($contenido)) 
	{ 
		echo $contenido;
	} 
	else
	{?>
		<?php echo validation_errors(); ?>

		<?php echo form_open('categoria_usuarios/editar'); ?>

		<input type="hidden" name="id_categoria" value="<?php echo set_value('id_categoria', $id_categoria);?>"/>

	    <label for="categoria">Categoría</label>
	    <input type="input" name="categoria" value="<?php echo set_value('categoria', $categoria);?>"/><br />

	    <input type="submit" name="submit" value="Actualizar"/>

	    <a href="<?php echo site_url('categoria_usuarios/eliminar') . '/' . $id_categoria?>">Eliminar</a>

		</form>	
<?php } ?>