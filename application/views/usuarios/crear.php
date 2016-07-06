<div class="container">
    <?php echo validation_errors(); ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
          <div class="panel-body">

            <?php echo form_open('usuarios/nuevo'); ?>

                <div class="form-group" style="display: none;">
                    <label for="categoria">Categoría</label>
                    <?php echo form_dropdown('categoria', $categorias, array(), 'class="form-control"');?><br />
                </div>

                <div class="form-group">
                    <label for="nombre_usuario">Email</label> <span class="badge">Requerido</span>
                    <input type="input" class="form-control" name="email" value="<?php echo set_value('email');?>"/><br />
                </div>

                <div class="form-group">
                    <label for="nombre_usuario">Confirmación de email</label> <span class="badge">Requerido</span>
                    <input type="input" class="form-control" name="confirmacion_email" value="<?php echo set_value('confirmacion_email');?>"/><br />
                </div>

                <div class="form-group">
                    <label for="clave">Contraseña</label> <span class="badge">Requerido</span>
                    <input type="password" class="form-control" name="clave"/><br />
                </div>    

                <div class="form-group">
                    <label for="confirmacion_clave">Confirmación de contraseña</label> <span class="badge">Requerido</span>
                    <input type="password" class="form-control" name="confirmacion_clave"/><br />
                </div>

                <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />

            </form>

        </div><!-- Fin panel body -->
    </div> <!-- Fin panel-->
</div><!-- Fin container-->
