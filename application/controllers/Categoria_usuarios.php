<?php
class Categoria_usuarios extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->session->user_is_authenticated();
            $this->load->library('form_validation');
            $this->load->model('categoria_usuarios_model');
        }

        public function index()
        {
            $this->ver();
        }
        
        public function nueva()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $data['titulo'] = 'Crear nueva categoría de usuario';

            $this->cargar_header_y_principal();

            $this->establecer_reglas(TRUE);

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('categoria_usuarios/crear', $data);
            }
            else
            {
                $data = array('categoria' => $this->input->post('categoria'));
                $this->categoria_usuarios_model->crear_categoria_usuario($data);
                $data['mensaje'] = "¡Categoría de usuario creada correctamente!";
                $this->load->view('categoria_usuarios/exito', $data);
            }

            $this->load->view('templates/footer');
        }

        public function ver($id_categoria_usuario = NULL)
        {
            $this->cargar_header_y_principal();

            if ($id_categoria_usuario === NULL)
            {
                $data['titulo'] = 'Categorías de usuarios del sistema';

                $categorias_usuario = $this->categoria_usuarios_model->obtener_categorias_usuario_table();

                $resultado;

                if(!empty($categorias_usuario))
                {
                    $this->load->library('table');
                    $this->load->helper('url');
                    $this->table->set_template(array('table_open' => '<table class="table">'));

                    foreach ($categorias_usuario as $indice_fila => $fila)
                    {
                        $categorias_usuario[$indice_fila]['id_categoria'] = anchor('categoria_usuarios/ver/'.$fila['id_categoria'],'Ver', 'class="btn btn-info"'); //Permite generar el link para ver el usuario particular
                    }

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
                    $data['categoria_original'] = $categoria_usuario->categoria;
                }
            }
    
            $this->load->view('categoria_usuarios/ver', $data);

            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $datos = array(
                'id_categoria' => $this->input->post('id_categoria'),
                'categoria' => $this->input->post('categoria')
                );

            $validar_categoria_unica = TRUE;

            if ($datos['categoria'] === $this->input->post('categoria_original'))
            {
                 $validar_categoria_unica = FALSE;
            }

            $this-> establecer_reglas($validar_categoria_unica);

            if ($this->form_validation->run() === FALSE)
            {
                $this->ver($datos['id_categoria']);
            }
            else
            {
                if ($this->categoria_usuarios_model->editar_categoria_usuario($datos)) 
                {
                    $data['mensaje'] = '¡Los datos de la categoría de usuario se actualizaron correctamente!';
                }
                else
                {
                    $data['mensaje'] = '¡No se actualizó la información!';
                }
                $this->cargar_header_y_principal();
                $this->load->view('categoria_usuarios/exito', $data);
                $this->load->view('templates/footer');
            }
        }

        public function eliminar()
        {
            $this->cargar_header_y_principal();
            $id_categoria_usuario = $this->uri->segment(3);

            if ($id_categoria_usuario === NULL)
            {
                 $data['mensaje'] = 'No se especificó una categoría de usuario a eliminar';
            }
            elseif($this->categoria_usuarios_model->eliminar_categoria_usuario($id_categoria_usuario) == 1)
            {
                $data['mensaje'] = '¡Categoría de usuario eliminada correctamente!';
            }
            elseif($this->categoria_usuarios_model->eliminar_categoria_usuario($id_categoria_usuario) == 1451)
            {
                $data['mensaje'] = '¡No se puede eliminar una categoría de usuario que se encuentra en uso!';
            }
            else
            {
                $data['mensaje'] = '¡Categoría inexistente!';
            }

            $this->load->view('categoria_usuarios/exito', $data);
            $this->load->view('templates/footer');
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }

        private function establecer_reglas($validar_categoria_unica)
        {
            $array_validaciones = array('required');
            $array_mensajes = array('required' => 'La categoría es requerida');

            if ($validar_categoria_unica)
            {
                array_push($array_validaciones, 'is_unique[categoria_usuario.categoria]');
                $array_mensajes['is_unique'] = 'La categoría ingresada ya existe';
            }

            $this->form_validation->set_rules('categoria', 'Categoria', $array_validaciones, $array_mensajes);
        }
}