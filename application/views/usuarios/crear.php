<div class="container">
    <h2><?php echo $titulo; ?></h2>

    <?php echo validation_errors(); ?>

    <?php echo form_open('usuarios/nuevo'); ?>

    <div class="form-group">
        <label for="categoria">Categoría</label>
        <?php echo form_dropdown('categoria', $categorias, array(), 'class="form-control"');?><br />
    </div>

    <div class="form-group">
        <label for="nombre_usuario">Email</label>
        <input type="input" class="form-control" name="email" value="<?php echo set_value('email');?>"/><br />
    </div>

    <div class="form-group">
        <label for="nombre_usuario">Confirmación de email</label>
        <input type="input" class="form-control" name="confirmacion_email" value="<?php echo set_value('confirmacion_email');?>"/><br />
    </div>

    <div class="form-group">
        <label for="clave">Contraseña</label>
        <input type="password" class="form-control" name="clave"/><br />
    </div>    

    <div class="form-group">
        <label for="confirmacion_clave">Confirmación de contraseña</label>
        <input type="password" class="form-control" name="confirmacion_clave"/><br />
    </div>

    <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />
</form> 
</div>