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
				<?php echo form_open('cajas/editar'); ?>
				
					<input type="hidden" name="id_caja" value="<?php echo set_value('id_caja', $id_caja);?>"/>
					<input type="hidden" name="descripcion_original" value="<?php echo set_value('descripcion_original', $descripcion_original);?>"/>

					<div class="form-group">
					    <label for="descripcion">Descripción</label> <span class="badge"> Requerido</span>
					    <input type="input" name="descripcion" class="form-control" value="<?php echo set_value('descripcion', $descripcion);?>"/><br />
					</div>

					<div class="form-group">
					    <label>Saldo</label>
					    <input type="input" class="form-control" disabled="disabled" value="<?php echo set_value('saldo', $saldo);?>"/><br />
					</div>

				    <input type="submit" name="submit" value="Actualizar" class="btn"/>

				    <a href="<?php echo site_url('cajas/eliminar') . '/' . $id_caja?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar ésta caja?');">Eliminar</a>

				</form>	
			<?php } ?>
        </div><!-- Fin panel body-->
	</div><!-- Fin panel-->
</div>