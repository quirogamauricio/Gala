<?php
class Usuarios extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('usuario_model');
                $this->load->model('categoria_usuarios_model');
        }

        public function index()
        {
                // $data['news'] = $this->news_model->get_news();
                // $data['title'] = 'News archive';

                // $this->load->view('templates/header', $data);
                // $this->load->view('news/index', $data);
                // $this->load->view('templates/footer');
        }
        
        public function nuevo()
        {
            $this->load->library('form_validation');

            $data['categorias'] = $this->categoria_usuarios_model->obtener_categorias_usuario_dropdown();

            $data['titulo'] = 'Crear nuevo usuario';

            $this->establecer_reglas_creacion();

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header');
                $this->load->view('usuarios/crear', $data);
                $this->load->view('templates/footer');
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
        }

        public function ver($id_usuario = NULL)
        {
            $this->load->view('templates/header');

            if ($id_usuario === NULL) 
            {
                $data['titulo'] = 'Usuarios del sistema';

                $this->load->library('table');
                $this->load->helper('url'); // Cargo helper para usar función anchor

                $usuarios = $this->usuario_model->obtener_usuarios();

                foreach ($usuarios as $indice_fila => $fila)
                {
                    $usuarios[$indice_fila]['id'] = anchor('usuarios/ver/'.$fila['id'],'Ver'); //Permite generar el link para ver el usuario particular
                }

                $resultado;

                if(!empty($usuarios))
                {
                    $this->table->set_heading('Email', 'Categoría', 'Fecha de alta');
                    $resultado = $this->table->generate($usuarios);
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['contenido'] = $resultado;
                $this->load->view('usuarios/ver', $data);
            }
            else
            {
                $this->load->library('form_validation');

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
                    $data['id_categoria'] = $usuario->id_categoria;
                    $data['categorias'] = $this->categoria_usuarios_model->obtener_categorias_usuario_dropdown();
                }

                $this->load->view('usuarios/ver', $data);
            }

            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->load->library('form_validation');
            $this->load->view('templates/header');

            $datos = array(
                'id_usuario' => $this->input->post('id_usuario'),
                'email' => $this->input->post('email'),
                'id_categoria' => $this->input->post('categoria'),
                 );

            $this-> establecer_reglas_edicion();

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header');
                $this->ver($datos['id_usuario']);
                $this->load->view('templates/footer');
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

                $this->load->view('usuarios/exito', $data);
                $this->load->view('templates/footer');
            }
        }

        public function eliminar()
        {
            $id_usuario = $this->uri->segment(3);

            if ($id_usuario === NULL)
            {
                 $data['mensaje'] = 'No se especificó un usuario a eliminar';
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

        private function establecer_reglas_edicion()
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
}