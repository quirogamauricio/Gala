<?php
class Usuarios extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('usuario_model');
        $this->load->model('categoria_usuarios_model');
    }

    public function index()
    {
        $this->ver();
    }
    
    public function nuevo()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['categorias'] = $this->categoria_usuarios_model->obtener_categorias_usuario_dropdown();

        $data['titulo'] = 'Crear nuevo usuario';

        $this->establecer_reglas_creacion();

        $this->cargar_header_y_principal();

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('usuarios/crear', $data);
        }
        else
        {
            $datos = array(
                'email' => $this->input->post('email'),
                'clave' => password_hash($this->input->post('clave'), PASSWORD_DEFAULT),
                'id_categoria' => $this->input->post('categoria'),
                'fecha_alta'=> date('Y-m-d H:i:s')
                );

            $this->usuario_model->crear_usuario($datos);
            $data['mensaje'] = "¡Usuario creado correctamente!";
            $this->load->view('usuarios/exito', $data);
        }

        $this->load->view('templates/footer');
    }

    public function ver($id_usuario = NULL)
    {
        $this->cargar_header_y_principal();

        if ($id_usuario === NULL) 
        {
            $data['titulo'] = 'Usuarios del sistema';
            
            $usuarios = $this->usuario_model->obtener_usuarios();

            $resultado;

            if(!empty($usuarios))
            {

                $this->load->library('table');
                $this->load->helper('url'); // Cargo helper para usar función anchor
                $this->load->helper('date');
                $this->table->set_heading('Email', 'Categoría', 'Fecha de alta', '');
                $this->table->set_template(array('table_open' => '<table class="table">'));

                foreach ($usuarios as $indice_fila => $fila)
                {
                    $usuarios[$indice_fila]['id'] = anchor('usuarios/ver/'.$fila['id'],'Ver', 'class="btn btn-info"'); //Permite generar el link para ver el usuario particular
                    $usuarios[$indice_fila]['fecha_alta'] = transform_date($fila['fecha_alta'], '/');
                }

                $resultado = '<div class="table-responsive">' . $this->table->generate($usuarios) . '</div>';
            }
            else
            {
                $resultado = '<h4>No se encontraron resultados</h4>';
            }

                $data['contenido'] = $resultado;
        }
        else
        {
            $data['titulo'] = 'Información del usuario';

            $usuario = $this->usuario_model->obtener_usuario_por_id($id_usuario);

            if ($usuario === NULL) 
            {
                $data['contenido'] = '<h4>Error al recuperar información del usuario seleccionado</h4>';
            }
            else
            {
                $data['id_usuario'] = $usuario->id_usuario;
                $data['email'] = $usuario->email;
                $data['email_original'] = $usuario->email;
                $data['id_categoria'] = $usuario->id_categoria;
                $data['categorias'] = $this->categoria_usuarios_model->obtener_categorias_usuario_dropdown();
            }
        }

            $this->load->view('usuarios/ver', $data);
            $this->load->view('templates/footer');
    }

    public function editar()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $datos = array(
            'id_usuario' => $this->input->post('id_usuario'),
            'email' => $this->input->post('email'),
            'id_categoria' => $this->input->post('categoria'),
            );

        $validar_email_unico = TRUE;

        if ($datos['email'] === $this->input->post('email_original'))
        {
           $validar_email_unico = FALSE;
        }

        $this-> establecer_reglas_edicion($validar_email_unico);

        if ($this->form_validation->run() === FALSE)
        {
            $this->ver($datos['id_usuario']);
        }
        else
        {
            if ($this->usuario_model->editar_usuario($datos)) 
            {
                $data['mensaje'] = '¡Los datos del usuario se actualizaron correctamente!';
            }
            else
            {
                $data['mensaje'] = '¡No se actualizó la información!';
            }   

            $this->cargar_header_y_principal();
            $this->load->view('usuarios/exito', $data);
            $this->load->view('templates/footer');
        }
    }

    public function eliminar()
    {
        $this->cargar_header_y_principal();
        $id_usuario = $this->uri->segment(3);

        if ($id_usuario === NULL)
        {
           $data['mensaje'] = 'No se especificó un usuario a eliminar';
        }
        elseif($id_usuario == $_SESSION['usuario_id'])
        {
            $data['mensaje'] = '¡No es posible eliminar el usuario actual!';
        }
        elseif($this->usuario_model->eliminar_usuario($id_usuario) > 0)
        {
            $data['mensaje'] = '¡Usuario eliminado correctamente!';
        }
        else
        {
          $data['mensaje'] = '¡Usuario inexistente!';
        }


       $this->load->view('usuarios/exito', $data);
       $this->load->view('templates/footer');
    }

    private function establecer_reglas_edicion($validar_email_unico)
    {
        $array_validaciones = array('required', 'valid_email');

        $array_mensajes = array('required' => 'El email es requerido', 
            'valid_email' => 'El email ingresado no tiene el formato correcto');

        if ($validar_email_unico) 
        {
            array_push($array_validaciones, 'is_unique[usuario.email]') ;
            $array_mensajes['is_unique'] = 'El email ingresado ya se encuentra en uso';
        }

        $this->form_validation->set_rules('email','Email', $array_validaciones, $array_mensajes);

        $this->form_validation->set_rules(
            'confirmacion_email',
            'Confirmación de email', 
            array('required', 'matches[email]'),
            array('required' => 'La confirmación de email es requerida', 'matches' => 'Los email ingresados no coinciden')
            ); 
    }

    private function establecer_reglas_creacion()
    {
        $this->form_validation->set_rules(
            'email',
            'Email', 
            array('required', 'valid_email', 'is_unique[usuario.email]'),
            array('required' => 'El email es requerido', 
              'valid_email' => 'El email ingresado no tiene el formato correcto',
              'is_unique' => 'El email ingresado ya se encuentra en uso')
            );

        $this->form_validation->set_rules(
            'confirmacion_email',
            'Confirmación de email', 
            array('required', 'matches[email]'),
            array('required' => 'La confirmación de email es requerida', 'matches' => 'Los email ingresados no coinciden')
            ); 

        $this->form_validation->set_rules(
            'clave', 
            'Contraseña',
            array('required', 'min_length[8]'),
            array('required' => 'La contraseña es requerida', 'min_length' => 'La contraseña debe tener al menos 8 caracteres')
            );

        $this->form_validation->set_rules(
            'confirmacion_clave',
            'Confirmación de contraseña', 
            array('required', 'matches[clave]'),
            array('required' => 'La confirmación de contraseña es requerida', 'matches' => 'Las contraseñas ingresadas no coinciden')
            );
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }
}