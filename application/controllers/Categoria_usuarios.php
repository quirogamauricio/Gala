<?php
class Categoria_usuarios extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
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
        
        public function nueva()
        {
            $this->load->library('form_validation');

            $data['title'] = 'Crear nueva categoría de usuario';

            $this->form_validation->set_rules(
                'categoria',
                'Categoria', 
                array('required', 'is_unique[categoria_usuario.categoria]'),
                array('required' => 'La categoría es requerida', 'is_unique' => 'La categoría ingresada ya existe')
                );

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header');
                $this->load->view('categoria_usuarios/crear', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $this->categoria_usuarios_model->crear_categoria_usuario();
                $this->load->view('categoria_usuarios/exito');
            }
        }

        public function ver()
        {
            $data['titulo'] = 'Categorías de usuarios del sistema';

            $this->load->view('templates/header');

            $this->load->library('table');

            $categorias_usuario = $this->categoria_usuarios_model->obtener_categorias_usuario_table();

            $resultado;

            if(!empty($categorias_usuario))
            {
                $this->table->set_heading('Categoría');

                $resultado = $this->table->generate($categorias_usuario);
            }
            else
            {
                $resultado = '<h4>No se encontraron resultados</h4>';
            }

            $data['tabla'] = $resultado;

            $this->load->view('categoria_usuarios/ver', $data);

            $this->load->view('templates/footer');
        }
}