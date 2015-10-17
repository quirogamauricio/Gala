<?php $this->load->helper('url'); ?>

<div class="container">
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
			<?php echo validation_errors(); ?>

				<?php echo form_open('stock/editar'); ?>

					<input type="hidden" name="id_stock" value="<?php echo set_value('id_stock', $id_stock);?>"/>
					<input type="hidden" name="id_producto_original" value="<?php echo set_value('id_producto_original', $id_producto_original);?>"/>

					<div class="form-group">
				        <label for="tipo">Producto</label>
				        <?php echo form_dropdown('producto', $productos, $id_producto, 'class="form-control"');?><br />
				    </div>

				    <div class="form-group">
				        <label for="color">Sucursal</label>
				        <?php echo form_dropdown('sucursal', $sucursales, $id_sucursal, 'class="form-control"');?><br />
			    	</div>

			        <div class="form-group">
	                    <label for="stock_actual">Stock actual</label> <span class="badge">Requerido</span>
	                    <input type="input" class="form-control" name="stock_actual" value="<?php echo set_value('stock_actual', $stock_actual);?>"/><br />
	                </div>

	                <div class="form-group">
	                    <label for="stock_minimo">Stock mínimo</label> <span class="badge">Requerido</span>
	                    <input type="input" class="form-control" name="stock_minimo" value="<?php echo set_value('stock_minimo', $stock_minimo);?>"/><br />
	                </div>

				    <input type="submit" name="submit" value="Actualizar" class="btn"/>
				    <a href="<?php echo site_url('stock/eliminar') . '/' . $id_stock ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste producto?');">Eliminar</a>

				</form>	
			<?php } ?>
        </div> <!-- Fin panel body-->
    </div> <!-- Fin panel -->
	
</div> <!-- Fin container -->