<div class="container">

    <?php echo validation_errors(); ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
        <div class="panel-body">

            <?php echo form_open_multipart('productos/nuevo'); ?>

            <div class="form-group">
                <label for="tipo">Tipo</label>
                <?php echo form_dropdown('tipo', $tipos, array(), 'class="form-control"');?><br />
            </div>

            <div class="form-group">
                <label for="color">Color</label>
                <?php echo form_dropdown('color', $colores, array(), 'class="form-control"');?><br />
            </div>

            <div class="form-group">
                <label for="codigo">Código</label> <span class="badge">Requerido</span>
                <input type="input" class="form-control" name="codigo" value="<?php echo set_value('codigo');?>"/><br />
            </div>

            <div class="form-group">
                <label for="precio_costo">Precio de costo</label> <span class="badge">Requerido</span>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="input" class="form-control" name="precio_costo" value="<?php echo set_value('precio_costo');?>"/>
                </div> 
                <br />
                <p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
            </div>

            <div class="form-group">
                <label for="precio_venta_efectivo">Precio de venta en efectivo</label> <span class="badge">Requerido</span>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="input" class="form-control" name="precio_venta_efectivo" value="<?php echo set_value('precio_venta_efectivo');?>"/>
                </div> 
                <br />
                <p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
            </div>

            <div class="form-group">
                <label for="precio_venta_tarjeta">Precio de venta con tarjeta</label> <span class="badge">Requerido</span>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="input" class="form-control" name="precio_venta_tarjeta" value="<?php echo set_value('precio_venta_tarjeta');?>"/>
                </div> 
                <br />
                <p class="help-block">Ingresar un valor decimal utilizando '.' para separar los decimales</p>
            </div>

            <div class="form-group">
                <label for="detalles">Detalles</label>
                <textarea class="form-control" rows="5" name="detalles"><?php echo set_value('detalles');?></textarea><br />
            </div>

            <div class="form-group">
                <label for="talle">Talle</label>
                <input type="input" class="form-control" name="talle" value="<?php echo set_value('talle');?>"/><br />
            </div>    

            <div class="form-group">
                <label for="numero">Número</label>
                <input type="input" class="form-control" name="numero" value="<?php echo set_value('numero');?>"/><br />
            </div>

            <div class="form-group">
                <label for="publicado">Publicado</label>
                <br>
                <input type="radio"  name="publicado" value="1" <?php echo  set_radio('publicado', '1'); ?>/> Si
                <br>
                <input type="radio"  name="publicado" value="0" <?php echo  set_radio('publicado', '0', TRUE); ?>/> No
            </div>

            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" style="width: 100%"/>
                <br>
                <p class="help-block">Extensiones permitidas: .gif | .jpg | .png | .bmp</p>
            </div>

            <br>

            <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />
        </form> 
    </div> <!-- Fin panel body-->
</div> <!-- Fin panel -->

</div>