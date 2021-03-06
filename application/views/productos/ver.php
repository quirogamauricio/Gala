<?php $this->load->helper('url');
$this->load->library('form_validation'); ?>

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
			<?php echo form_open_multipart('productos/editar'); ?>

			<input type="hidden" name="id_producto" value="<?php echo set_value('id_producto', $id_producto);?>"/>

			<div class="form-group">
				<label for="tipo">Tipo</label>
				<?php echo form_dropdown('tipo', $tipos, $id_tipo_producto, 'class="form-control"');?><br />
			</div>

			<div class="form-group">
				<label for="color">Color</label>
				<?php echo form_dropdown('color', $colores, $id_color_producto, 'class="form-control"');?><br />
			</div>

			<div class="form-group">
				<label for="nombre_producto">Código</label> <span class="badge">Requerido</span>
				<input type="input" class="form-control" name="codigo" value="<?php echo set_value('codigo', $codigo);?>"/><br />
			</div>

			<div class="form-group">
				<label for="precio_costo">Precio de costo</label> <span class="badge">Requerido</span>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="input" class="form-control" name="precio_costo" value="<?php echo set_value('precio_costo', $precio_costo);?>"/>
				</div>
				 <br />
				<p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
			</div>

			<div class="form-group">
				<label for="precio_venta_efectivo">Precio de venta en efectivo</label> <span class="badge">Requerido</span>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="input" class="form-control" name="precio_venta_efectivo" value="<?php echo set_value('precio_venta_efectivo', $precio_venta_efectivo);?>"/>
				</div> 
				<br />
				<p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
			</div>

			<div class="form-group">
				<label for="precio_venta_tarjeta">Precio de venta con tarjeta</label> <span class="badge">Requerido</span>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="input" class="form-control" name="precio_venta_tarjeta" value="<?php echo set_value('precio_venta_tarjeta', $precio_venta_tarjeta);?>"/>
				</div> 
				<br />
				<p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
			</div>

			<div class="form-group">
				<label for="nombre_usuario">Detalles</label>
				<textarea class="form-control" rows="5" name="detalles"><?php echo set_value('detalles', $detalles);?></textarea><br />
			</div>

			<div class="form-group">
				<label for="Talle">Talle</label>
				<input type="input" class="form-control" name="talle" value="<?php echo set_value('talle', $talle);?>"/><br />
			</div>    

			<div class="form-group">
				<label for="numero">Número</label>
				<input type="input" class="form-control" name="numero" value="<?php echo set_value('numero', $numero);?>"/><br />
			</div>

			<div class="form-group">
				<label for="publicado">Publicado</label>
				<br>
				<input type="radio"  name="publicado" value="1" <?php echo  set_radio('publicado', '1', $esta_publicado); ?>/>Si
				<br>
				<input type="radio"  name="publicado" value="0" <?php echo  set_radio('publicado', '0', $no_esta_publicado); ?>/>No
			</div>
			<input type="hidden" name="imagen_original" value="<?php echo set_value('imagen_original', $imagen_original);?>"/>
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-lg-4">
						<?php if(!empty($imagen_original)) {echo img('assets/img/'.$imagen_original, FALSE, array('class' => 'img-thumbnail'));} ?>
					</div>
				</div>
				<br>
				<input type="file" name="imagen" style="width: 100%"/>
				<br>
				<p class="help-block">Extensiones permitidas: .gif | .jpg | .png | .bmp</p>
			</div>

			<br/>

			<input type="submit" name="submit" value="Actualizar" class="btn btn-default"/>
			<a href="<?php echo site_url('productos/eliminar') . '/' . $id_producto ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste producto?');">Eliminar</a>

		</form>	
		<?php } ?>
	</div><!-- Fin panel body -->
</div> <!-- Fin panel-->
</div><!-- Fin container-->

<script type="text/javascript">

	$(window).load(function () {

	    $('.alerta-stock').parents('tr').addClass('danger').attr('title', 'Alerta de stock mínimo');
	});

</script>