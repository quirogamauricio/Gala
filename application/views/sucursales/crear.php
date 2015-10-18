<div class="container">
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
        <div class="panel-body">

			<?php echo form_open('sucursales/nueva'); ?>

				<div class="form-group">
					<label for="sucursal">Sucursal</label> <span class="badge">Requerido</span>
					<input type="input" class="form-control" name="sucursal" value="<?php echo set_value('sucursal');?>"/><br />
				</div>
				<div class="form-group">
					<label for="direccion">Dirección</label>
					<input type="input" class="form-control" name="direccion" value="<?php echo set_value('direccion');?>"/><br />
				</div>

			    <input type="submit" class="btn btn-default"name="submit" value="Aceptar" />
			</form>	
			
        </div><!-- Fin panel body -->
	</div><!-- Fin panel -->
</div><!-- Fin container -->