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
		<input type="hidden" name="precio_costo_original" value="<?php echo set_value('precio_costo_original', $precio_costo_original);?>"/>

		<div class="form-group">
	        <label for="tipo">Tipo</label>
	        <?php echo form_dropdown('tipo', $tipos, $id_tipo_producto, 'class="form-control"');?><br />
	    </div>

	    <div class="form-group">
	        <label for="color">Color</label>
	        <?php echo form_dropdown('color', $colores, $id_color_producto, 'class="form-control"');?><br />
    	</div>

		<div class="form-group">
		    <label for="nombre_producto">Código</label>
		    <input type="input" class="form-control" name="codigo" value="<?php echo set_value('codigo', $codigo);?>"/><br />
		</div>

		<div class="form-group">
	        <label for="nombre_usuario">Precio de costo</label>
	        <input type="input" class="form-control" name="precio_costo" value="<?php echo set_value('precio_costo', $precio_costo);?>"/><br />
    	</div>

		 <div class="form-group">
	        <label for="nombre_usuario">Detalles</label>
	        <input type="input" class="form-control" name="detalles" value="<?php echo set_value('detalles', $detalles);?>"/><br />
    	</div>

	    <div class="form-group">
	        <label for="Talle">Talle</label>
	        <input type="input" class="form-control" name="talle" value="<?php echo set_value('talle', $talle);?>"/><br />
	    </div>    

	    <div class="form-group">
	        <label for="numero">Número</label>
	        <input type="input" class="form-control" name="numero" value="<?php echo set_value('numero', $numero);?>"/><br />
	    </div>

	    <div class="form-inline">
	        <div class="controls-row">
	            <label for="publicado" class="radio inline control-label">Publicado</label>

	            <label class="radio inline"> Si <input type="radio"  name="publicado" value="1" <?php echo  set_radio('publicado', '1', $esta_publicado); ?>/> </label> 
	            
	            <label class="radio inline">No <input type="radio"  name="publicado" value="0" <?php echo  set_radio('publicado', '0', $no_esta_publicado); ?>/> </label>
	        </div>
	    </div>

	    <br />

	    <input type="submit" name="submit" value="Actualizar" class="btn"/>
	    <a href="<?php echo site_url('productos/eliminar') . '/' . $id_producto ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste producto?');">Eliminar</a>

		</form>	
	<?php } ?>
</div>