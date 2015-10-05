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
                $this->cargar_header_y_principal();
                $this->load->view('categoria_usuarios/crear', $data);
                $this->load->view('templates/footer');
            }
            else
            {
                $data = array('categoria' => $this->input->post('categoria'));
                $this->categoria_usuarios_model->crear_categoria_usuario($data);
                $this->load->view('categoria_usuarios/exito');
            }
        }

        public function ver($id_categoria_usuario = NULL)
        {
            $this->cargar_header_y_principal();

            if ($id_categoria_usuario === NULL)
            {
                $data['titulo'] = 'Categorías de usuarios del sistema';

                $this->load->library('table');
                $this->load->helper('url');

                $categorias_usuario = $this->categoria_usuarios_model->obtener_categorias_usuario_table();

                foreach ($categorias_usuario as $indice_fila => $fila)
                {
                    $categorias_usuario[$indice_fila]['id_categoria'] = anchor('categoria_usuarios/ver/'.$fila['id_categoria'],'Ver'); //Permite generar el link para ver el usuario particular
                }

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

                $data['contenido'] = $resultado;
            }
            else
            { 
                $this->load->library('form_validation');

                $data['titulo'] = 'Información de la categoría de usuario';

                $categoria_usuario = $this->categoria_usuarios_model->obtener_categoria_usuario_por_id($id_categoria_usuario);

                if ($categoria_usuario === NULL) 
                {
                    $data['contenido'] = '<h4>Error al recuperar información de la categoría de  usuario seleccionada</h4>';
                }
                else
                {
                    $data['id_categoria'] = $categoria_usuario->id_categoria;
                    $data['categoria'] = $categoria_usuario->categoria;
                }
            }
    
            $this->load->view('categoria_usuarios/ver', $data);

            $this->load->view('templates/footer');
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }
}