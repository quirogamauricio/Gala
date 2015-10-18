<div class="container">
	<?php echo validation_errors(); ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
      <div class="panel-body">

			<?php echo form_open('categoria_usuarios/nueva'); ?>

				<div class="form-group">
					<label for="categoria">Categoría</label> <span class="badge">Requerido</span>
					<input type="input" class="form-control" name="categoria" value="<?php echo set_value('categoria');?>"/>
				</div>

				<br />

			    <input type="submit" class="btn btn-default"name="submit" value="Aceptar" />

			</form>	

      </div><!-- Fin panel body -->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->
