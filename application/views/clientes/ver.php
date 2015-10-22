<?php $this->load->helper('url'); 
$this->load->library('form_validation');?>

<div class="container">
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title"><?php echo $titulo; ?></h2>
		</div>
		<div class="panel-body">
			<?php if(isset($contenido)) 
			{ 
				echo $contenido;
			} 
			else
				{?>
			<?php echo form_open('clientes/editar'); ?>

			<input type="hidden" name="id_cliente" value="<?php echo set_value('id_cliente', $id_cliente);?>"/>

			<div class="form-group">
				<label for="nombre_cliente">Nombre</label> <span class="badge">Requerido</span>
				<input type="input" class="form-control" name="nombre" value="<?php echo set_value('nombre', $nombre);?>"/><br />
			</div>

			<div class="form-group">
				<label for="nombre_usuario">Apellido</label> <span class="badge">Requerido</span>
				<input type="input" class="form-control" name="apellido" value="<?php echo set_value('apellido', $apellido);?>"/><br />
			</div>

			<div class="form-group">
				<label for="nombre_usuario">Teléfono</label>
				<input type="input" class="form-control" name="telefono" value="<?php echo set_value('telefono', $telefono);?>"/><br />
			</div>

			<input type="submit" name="submit" value="Actualizar" class="btn"/>
			<a href="<?php echo site_url('clientes/eliminar') . '/' . $id_cliente ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste cliente?');">Eliminar</a>

		</form>	
		<?php } ?>
	</div><!-- Fin panel body -->
</div> <!-- Fin panel-->
</div><!-- Fin container-->
