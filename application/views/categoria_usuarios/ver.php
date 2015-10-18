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
				<?php echo form_open('categoria_usuarios/editar'); ?>
			
					<input type="hidden" name="id_categoria" value="<?php echo set_value('id_categoria', $id_categoria);?>"/>
					<input type="hidden" name="categoria_original" value="<?php echo set_value('categoria_original', $categoria_original);?>"/>
					
					<div class="form-group">
					    <label for="categoria">Categoría</label> <span class="badge">Requerido</span>
					    <input type="input" name="categoria" class="form-control"value="<?php echo set_value('categoria', $categoria);?>"/><br />
					</div>

				    <input type="submit" name="submit" value="Actualizar" class="btn"/>

				    <a href="<?php echo site_url('categoria_usuarios/eliminar') . '/' . $id_categoria?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta categoría?');">Eliminar</a>

				</form>	
			<?php } ?>
      </div><!-- Fin panel body -->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->



