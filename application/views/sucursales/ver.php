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
				<?php echo form_open('sucursales/editar'); ?>
				
					<input type="hidden" name="id_sucursal" value="<?php echo set_value('id_sucursal', $id_sucursal);?>"/>
					<input type="hidden" name="sucursal_original" value="<?php echo set_value('sucursal_original', $sucursal_original);?>"/>
					
					<div class="form-group">
					    <label for="sucursal">Sucursal</label> <span class="badge">Requerido</span>
					    <input type="input" name="sucursal" class="form-control"value="<?php echo set_value('sucursal', $sucursal);?>"/><br />
					</div>

					<div class="form-group">
					    <label for="direccion">Dirección</label>
					    <input type="input" name="direccion" class="form-control"value="<?php echo set_value('direccion', $direccion);?>"/><br />
					</div>

				    <input type="submit" name="submit" value="Actualizar" class="btn"/>

				    <a href="<?php echo site_url('sucursales/eliminar') . '/' . $id_sucursal?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste sucursal?');">Eliminar</a>

				</form>	
			<?php } ?>
        </div><!-- Fin panel body-->
	</div><!-- Fin panel-->
</div>