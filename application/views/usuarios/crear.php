<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('usuarios/nuevo'); ?>

	<label for="categoria">Categoría</label>
    <?php echo form_dropdown('categoria', $categorias);?>
	<!-- <input type="input" name="categoria" value="<?php echo set_value('categoria');?>"/> --><br />

    <label for="nombre_usuario">Nombre de usuario</label>
    <input type="input" name="nombre_usuario" value="<?php echo set_value('nombre_usuario');?>"/><br />

    <label for="email">Email</label>
    <input type="input" name="email" value="<?php echo set_value('email');?>"/><br />

    <label for="confirmacion_email">Confirmación de email</label>
    <input type="input" name="confirmacion_email" value="<?php echo set_value('confirmacion_email');?>"/><br />

    <label for="clave">Contraseña</label>
    <input type="password" name="clave"/><br />

     <label for="confirmacion_clave">Confirmación de contraseña</label>
    <input type="password" name="confirmacion_clave"/><br />

    <input type="submit" name="submit" value="Aceptar" />

</form>	