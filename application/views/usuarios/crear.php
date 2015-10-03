<h2><?php echo $titulo; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('usuarios/nuevo'); ?>

	<label for="categoria">Categoría</label>
    <?php echo form_dropdown('categoria', $categorias);?><br />

    <label for="nombre_usuario">Email</label>
    <input type="input" name="email" value="<?php echo set_value('email');?>"/><br />

    <label for="nombre_usuario">Confirmación de email</label>
    <input type="input" name="confirmacion_email" value="<?php echo set_value('confirmacion_email');?>"/><br />

    <label for="clave">Contraseña</label>
    <input type="password" name="clave"/><br />

     <label for="confirmacion_clave">Confirmación de contraseña</label>
    <input type="password" name="confirmacion_clave"/><br />

    <input type="submit" name="submit" value="Aceptar" />

</form>	