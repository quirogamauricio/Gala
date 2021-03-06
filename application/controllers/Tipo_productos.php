<?php
class Tipo_productos extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->session->user_is_authenticated();
            $this->load->library('form_validation');
            $this->load->model('tipo_productos_model');
        }

        public function index()
        {
            $this->ver();
        }

        public function nuevo()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $data['titulo'] = 'Crear nuevo tipo de producto';

            $this->cargar_header_y_principal();

            $this->establecer_reglas(TRUE);

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('tipo_productos/crear', $data);
            }
            else
            {
                $data = array('tipo' => $this->input->post('tipo'));
                $this->tipo_productos_model->crear_tipo_producto($data);
                $data['mensaje'] = '<h3 class="alert alert-success"> ¡Tipo de producto creado correctamente! </h3>';
                $this->load->view('tipo_productos/exito', $data);
            }

            $this->load->view('templates/footer');
        }

        public function ver($id_tipo_producto = NULL)
        {
            $this->cargar_header_y_principal();

            if ($id_tipo_producto === NULL)
            {
                $data['titulo'] = 'Tipos de productos';

                $tipo_productos = $this->tipo_productos_model->obtener_tipo_productos_table();

                $resultado;

                if(!empty($tipo_productos))
                {
                    $this->load->library('table');
                    $this->load->helper('url');
                    $this->table->set_template(array('table_open' => '<table class="table">'));

                    foreach ($tipo_productos as $indice_fila => $fila)
                    {
                        $tipo_productos[$indice_fila]['id_tipo_producto'] = anchor('tipo_productos/ver/'.$fila['id_tipo_producto'],'Ver', 'class="btn btn-info"');
                    }

                    $this->table->set_heading('Tipo', '');

                    $resultado = '<div class="table-responsive">' . $this->table->generate($tipo_productos) . '</div>';
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['contenido'] = $resultado;
            }
            else
            { 
                $data['titulo'] = 'Información del tipo de producto';

                $tipo_producto = $this->tipo_productos_model->obtener_tipo_producto_por_id($id_tipo_producto);

                if ($tipo_producto === NULL) 
                {
                    $data['contenido'] = '<h4>Error al recuperar información del tipo de producto seleccionado</h4>';
                }
                else
                {
                    $data['id_tipo_producto'] = $tipo_producto->id_tipo_producto;
                    $data['tipo'] = $tipo_producto->tipo;
                    $data['tipo_original'] = $tipo_producto->tipo;
                }
            }
    
            $this->load->view('tipo_productos/ver', $data);

            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $datos = array(
                'id_tipo_producto' => $this->input->post('id_tipo_producto'),
                'tipo' => $this->input->post('tipo'));

            $validar_tipo_unico = TRUE;

            if ($datos['tipo'] === $this->input->post('tipo_original'))
            {
                 $validar_tipo_unico = FALSE;
            }

            $this-> establecer_reglas($validar_tipo_unico);

            if ($this->form_validation->run() === FALSE)
            {
                $this->ver($datos['id_tipo_producto']);
            }
            else
            {
                if ($this->tipo_productos_model->editar_tipo_producto($datos)) 
                {
                    $data['mensaje'] = '<h3 class="alert alert-success"> ¡Los datos del tipo de producto se actualizaron correctamente! </h3>';
                }
                else
                {
                    $data['mensaje'] = '<h3 class="alert alert-danger"> ¡No se actualizó la información! </h3>';
                }
                $this->cargar_header_y_principal();
                $this->load->view('tipo_productos/exito', $data);
                $this->load->view('templates/footer');
            }
        }

        public function eliminar()
        {
            $this->cargar_header_y_principal();
            $id_tipo_producto = $this->uri->segment(3);

            if ($id_tipo_producto === NULL)
            {
                 $data['mensaje'] = '<h3 class="alert alert-warning"> No se especificó un tipo de producto a eliminar </h3>';
            }
            elseif($this->tipo_productos_model->eliminar_tipo_producto($id_tipo_producto) == 1)
            {
                $data['mensaje'] = '<h3 class="alert alert-success"> ¡Tipo de producto eliminado correctamente! </h3>';
            }
            elseif($this->tipo_productos_model->eliminar_tipo_producto($id_tipo_producto) == 1451)
            {
                $data['mensaje'] = '<h3 class="alert alert-warning"> ¡No se puede eliminar un tipo de producto que se encuentra en uso! </h3>';
            }
            else
            {
                $data['mensaje'] = '<h3 class="alert alert-warning"> ¡Tipo inexistente! </h3>';
            }

            $this->load->view('tipo_productos/exito', $data);
            $this->load->view('templates/footer');
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }

        private function establecer_reglas($validar_tipo_unico)
        {
            $array_validaciones = array('required');
            $array_mensajes = array('required' => 'El tipo es requerido');

            if ($validar_tipo_unico)
            {
                array_push($array_validaciones, 'is_unique[tipo_producto.tipo]');
                $array_mensajes['is_unique'] = 'El tipo ingresado ya existe';
            }

            $this->form_validation->set_rules('tipo', 'Tipo', $array_validaciones, $array_mensajes);
        }
    }