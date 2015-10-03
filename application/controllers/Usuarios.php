<?php
class Usuarios extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('usuario_model');
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

            $this->load->model('categoria_usuarios_model');

            $data['categorias'] = $this->categoria_usuarios_model->obtener_categorias_usuario_dropdown();

            $data['title'] = 'Crear nuevo usuario';

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
                'categoria',
                'Categoria', 
                'required',
                array('required' => 'La categoría es requerida')
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

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('usuarios/crear');
                $this->load->view('templates/footer');
            }
            else
            {
                $this->usuario_model->crear_usuario();
                $this->load->view('usuarios/exito');
            }
        }

        public function ver($id_usuario = NULL)
        {
            $data['title'] = 'Usuarios del sistema';

            $this->load->view('templates/header', $data);

            if ($id_usuario === NULL) 
            {
                $this->load->library('table');

                $usuarios = $this->usuario_model->obtener_usuarios();
                $resultado;

                if(!empty($usuarios))
                {
                    $this->table->set_heading('Nombre de usuario', 'Categoría', 'Email', 'Fecha de alta');
                    $resultado = $this->table->generate($usuarios);
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['tabla'] = $resultado;
                $this->load->view('usuarios/ver', $data);
            }
            else
            {
                

            }

            $this->load->view('templates/footer');
        }
}