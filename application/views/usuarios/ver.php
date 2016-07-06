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
					<?php echo form_open('usuarios/editar'); ?>

						<input type="hidden" name="id_usuario" value="<?php echo set_value('id_usuario', $id_usuario);?>"/>
						<input type="hidden" name="email_original" value="<?php echo set_value('email_original', $email_original);?>"/>

						<div class="form-group" style="display: none;">
							<label for="categoria">Categoría</label>
						    <?php echo form_dropdown('categoria', $categorias, $id_categoria, 'class="form-control"');?><br />
						</div>

						<div class="form-group">
						    <label for="nombre_usuario">Email</label> <span class="badge">Requerido</span>
						    <input type="input" class="form-control" name="email" value="<?php echo set_value('email', $email);?>"/><br />
						</div>

						<div class="form-group">
						    <label for="nombre_usuario">Confirmación de email</label> <span class="badge">Requerido</span>
						    <input type="input" class="form-control" name="confirmacion_email" value="<?php echo set_value('confirmacion_email', $email);?>"/><br />
						</div>

					    <input type="submit" name="submit" value="Actualizar" class="btn"/>
					    <a href="<?php echo site_url('usuarios/eliminar') . '/' . $id_usuario ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar éste usuario?');">Eliminar</a>

					</form>	
				<?php } ?>
      </div><!-- Fin panel body -->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->
