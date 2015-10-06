<?php 
  $this->load->helper('url'); 
  $this->load->helper('form');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
    <link href="<?php echo base_url("assets/css/signin.css"); ?>" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <?php echo validation_errors(); ?>

      <?php if (isset($mostrar_error) && $mostrar_error === TRUE) {?>

      <div class="alert alert-warning">Nombre de usuario o contraseña inválidos</div>
       
      <?php }?>

      <?php echo form_open('login/autenticar', 'class="form-signin"'); ?>
        <h2 class="form-signin-heading">Inicio de sesión</h2>
        <label for="email" class="sr-only">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" autofocus="">
        <label for="clave" class="sr-only">Contraseña</label>
        <input type="password" name="clave" class="form-control" placeholder="Contraseña">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>