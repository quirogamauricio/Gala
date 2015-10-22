<div class="container">
    <?php echo validation_errors(); ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $titulo; ?></h2>
        </div>
        <div class="panel-body">

            <?php echo form_open('clientes/nuevo'); ?>

            <div class="form-group">
                <label for="categoria">Nombre</label> <span class="badge">Requerido</span>
                <input type="input" class="form-control" name="nombre" value="<?php echo set_value('nombre');?>"/><br />
            </div>

            <div class="form-group">
                <label for="nombre_usuario">Apellido</label> <span class="badge">Requerido</span>
                <input type="input" class="form-control" name="apellido" value="<?php echo set_value('apellido');?>"/><br />
            </div>

            <div class="form-group">
                <label for="clave">Teléfono</label>
                <input type="input" class="form-control" name="telefono" value="<?php echo set_value('telefono');?>"/><br />
            </div>    
            
            <input type="submit" class="btn btn-default" name="submit" value="Aceptar" />

        </form>

    </div><!-- Fin panel body -->
</div> <!-- Fin panel-->
</div><!-- Fin container-->
