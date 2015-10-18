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
				<?php echo form_open('tipo_productos/editar'); ?>
			
					<input type="hidden" name="id_tipo_producto" value="<?php echo set_value('id_tipo_producto', $id_tipo_producto);?>"/>
					<input type="hidden" name="tipo_original" value="<?php echo set_value('tipo_original', $tipo_original);?>"/>
					
					<div class="form-group">
					    <label for="tipo">Tipo</label> <span class="badge">Requerido</span>
					    <input type="input" name="tipo" class="form-control"value="<?php echo set_value('tipo', $tipo);?>"/><br />
					</div>

				    <input type="submit" name="submit" value="Actualizar" class="btn"/>

				    <a href="<?php echo site_url('tipo_productos/eliminar') . '/' . $id_tipo_producto?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste tipo?');">Eliminar</a>

				</form>	
			<?php } ?>
 		</div><!-- Fin panel body -->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->


