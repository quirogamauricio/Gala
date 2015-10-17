<div class="container">

    <?php echo validation_errors(); ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
        <div class="panel-body">
            <?php echo form_open('stock/nuevo'); ?>
                <div class="form-group">
                    <label for="producto">Producto</label>
                    <?php echo form_dropdown('producto', $productos, array(), 'class="form-control"');?><br />
                </div>

                <div class="form-group">
                    <label for="sucursal">Sucursal</label>
                    <?php echo form_dropdown('sucursal', $sucursales, array(), 'class="form-control"');?><br />
                </div>

                <div class="form-group">
                    <label for="stock_actual">Stock actual</label> <span class="badge">Requerido</span>
                    <input type="input" class="form-control" name="stock_actual" value="<?php echo set_value('stock_actual');?>"/><br />
                </div>

                <div class="form-group">
                    <label for="stock_minimo">Stock mínimo</label> <span class="badge">Requerido</span>
                    <input type="input" class="form-control" name="stock_minimo" value="<?php echo set_value('stock_minimo');?>"/><br />
                </div>

                <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />
            </form> 
        </div><!-- Fin panel body-->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->