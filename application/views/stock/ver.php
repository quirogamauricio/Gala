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
				<?php echo form_open('stock/editar'); ?>

					<input type="hidden" name="id_stock" value="<?php echo set_value('id_stock', $id_stock);?>"/>

			        <div class="form-group">
	                    <label for="stock_actual">Stock actual</label> <span class="badge">Requerido</span>
	                    <input type="input" class="form-control" name="stock_actual" value="<?php echo set_value('stock_actual', $stock_actual);?>"/><br />
	                </div>

	                <div class="form-group">
	                    <label for="stock_minimo">Stock mínimo</label> <span class="badge">Requerido</span>
	                    <input type="input" class="form-control" name="stock_minimo" value="<?php echo set_value('stock_minimo', $stock_minimo);?>"/><br />
	                </div>

				    <input type="submit" name="submit" value="Actualizar" class="btn btn-default"/>

				</form>	
			<?php } ?>
        </div> <!-- Fin panel body-->
    </div> <!-- Fin panel -->
	
</div> <!-- Fin container -->