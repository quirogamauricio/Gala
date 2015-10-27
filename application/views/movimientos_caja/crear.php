<div class="container">
	<?php echo validation_errors(); ?>
	<div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
        <div class="panel-body">

			<?php echo form_open('movimientos_caja/nuevo'); ?>

				<div class="form-group">
					<label for="caja">Caja</label>
					 <?php echo form_dropdown('caja', $cajas, array(), 'class="form-control"');?><br />
				</div>
				<div class="form-group">
					<label for="importe">Importe</label>  <span class="badge">Requerido</span>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="input" class="form-control" name="importe" value="<?php echo set_value('importe');?>"/><br />
					</div>
					<p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
				</div>
				<div class="form-group">
					<label for="concepto">Concepto</label> <span class="badge">Requerido</span>
					<input type="input" class="form-control" name="concepto" value="<?php echo set_value('concepto');?>"/><br />
				</div>

			    <input type="submit" class="btn btn-default"name="submit" value="Aceptar" />
			</form>	
			
        </div><!-- Fin panel body -->
	</div><!-- Fin panel -->
</div><!-- Fin container -->