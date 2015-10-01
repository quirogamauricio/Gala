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

            $data['title'] = 'Crear nuevo usuario';

            $this->form_validation->set_rules(
                'nombre_usuario',
                'Nombre de usuario', 
                array('required', 'is_unique[usuario.nombre_usuario]'),
                array('required' => 'El nombre de usuario es requerido', 'is_unique' => 'El nombre de usuario ingresado ya se encuentra en uso')
                );

            $this->form_validation->set_rules(
                'email',
                'Email',
                array('required', 'valid_email', 'is_unique[usuario.email]'),
                array('required' => 'El email es requerido', 'valid_email' => 'El email ingresado no tiene el formato correcto', 'is_unique' => 'El email ingresado ya se encuentra en uso')
                );

            $this->form_validation->set_rules(
                'confirmacion_email',
                'Confirmación de email',
                array('required', 'matches[email]'),
                array('required' => 'La confirmación de email es requerida', 'matches' => 'Los emails ingresados no coinciden')
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

        public function ver()
        {
            $data['title'] = 'Usuarios del sistema';

            $this->load->library('table');

            $usuarios = $this->usuario_model->obtener_usuarios();

            if(!empty($usuarios))
            {
                $this->table->set_caption('<strong>USUARIOS</strong>');
                $this->table->set_heading('Nombre de usuario', 'Categoría', 'Email', 'Fecha de alta');
                $data['tabla'] = $this->table->generate($usuarios);
            }
            else
            {
                $data['tabla'] = '<h4>No se encontraron resultados</h4>';
            }

            $this->load->view('templates/header', $data);
            $this->load->view('usuarios/ver', $data);
            $this->load->view('templates/footer');
        }
}