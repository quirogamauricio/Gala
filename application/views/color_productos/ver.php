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
				<?php echo form_open('color_productos/editar'); ?>
					<input type="hidden" name="id_color_producto" value="<?php echo set_value('id_color_producto', $id_color_producto);?>"/>
					<input type="hidden" name="color_original" value="<?php echo set_value('color_original', $color_original);?>"/>
					
					<div class="form-group">
					    <label for="color">Color</label>
					    <input type="input" name="color" class="form-control"value="<?php echo set_value('color', $color);?>"/><br />
					</div>

				    <input type="submit" name="submit" value="Actualizar" class="btn"/>

				    <a href="<?php echo site_url('color_productos/eliminar') . '/' . $id_color_producto?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste color?');">Eliminar</a>
				</form>	
			<?php } ?>

		</div><!-- Fin panel body -->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->
