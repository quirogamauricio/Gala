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
		<input type="hidden" name="codigo_original" value="<?php echo set_value('codigo_original', $codigo_original);?>"/>

		<div class="form-group">
	        <label for="tipo">Tipo</label>
	        <?php echo form_dropdown('tipo', $tipos, array(), 'class="form-control"');?><br />
	    </div>

	    <div class="form-group">
	        <label for="color">Color</label>
	        <?php echo form_dropdown('color', $colores, array(), 'class="form-control"');?><br />
    	</div>

		<div class="form-group">
		    <label for="nombre_producto">Código</label>
		    <input type="input" class="form-control" name="codigo" value="<?php echo set_value('codigo', $codigo);?>"/><br />
		</div>

		<div class="form-group">
	        <label for="nombre_usuario">Precio de costo</label>
	        <input type="input" class="form-control" name="precio_costo" value="<?php echo set_value('precio_costo');?>"/><br />
    	</div>

		<div class="form-group">
		    <label for="nombre_producto">Confirmación de codigo</label>
		    <input type="input" class="form-control" name="confirmacion_codigo" value="<?php echo set_value('confirmacion_codigo', $codigo);?>"/><br />
		</div>

	    <input type="submit" name="submit" value="Actualizar" class="btn"/>
	    <a href="<?php echo site_url('productos/eliminar') . '/' . $id_producto ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste producto?');">Eliminar</a>

		</form>	
	<?php } ?>
</div>