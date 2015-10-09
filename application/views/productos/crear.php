<div class="container">
    <h2><?php echo $titulo; ?></h2>

    <?php echo validation_errors(); ?>

    <?php echo form_open('productos/nuevo'); ?>

    <div class="form-group">
        <label for="tipo">Tipo</label>
        <?php echo form_dropdown('tipo', $tipos, array(), 'class="form-control"');?><br />
    </div>

   <div class="form-group">
        <label for="color">Color</label>
        <?php echo form_dropdown('color', $colores, array(), 'class="form-control"');?><br />
    </div>

    <div class="form-group">
        <label for="nombre_usuario">Código</label>
        <input type="input" class="form-control" name="codigo" value="<?php echo set_value('codigo');?>"/><br />
    </div>

    <div class="form-group">
        <label for="nombre_usuario">Precio de costo</label>
        <input type="input" class="form-control" name="precio_costo" value="<?php echo set_value('precio_costo');?>"/><br />
    </div>

    <div class="form-group">
        <label for="nombre_usuario">Detalles</label>
        <input type="input" class="form-control" name="detalles" value="<?php echo set_value('detalles');?>"/><br />
    </div>

    <div class="form-group">
        <label for="Talle">Talle</label>
        <input type="input" class="form-control" name="talle" value="<?php echo set_value('talle');?>"/><br />
    </div>    

    <div class="form-group">
        <label for="numero">Número</label>
        <input type="input" class="form-control" name="numero" value="<?php echo set_value('numero');?>"/><br />
    </div>

    <div class="form-inline">
        <div class="controls-row">
            <label for="publicado" class="radio inline control-label">Publicado</label>

            <label class="radio inline"> Si <input type="radio"  name="publicado" value="1" <?php echo  set_radio('publicado', '1'); ?>/> </label> 
            
            <label class="radio inline">No <input type="radio"  name="publicado" value="0" <?php echo  set_radio('publicado', '0', TRUE); ?>/> </label>
        </div>
    </div>

     <br/>

    <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />
</form> 
</div>