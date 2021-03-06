<?php
class Color_productos extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->session->user_is_authenticated();
            $this->load->library('form_validation');
            $this->load->model('color_productos_model');
        }

        public function index()
        {
            $this->ver();
        }

        public function nuevo()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $data['titulo'] = 'Crear nuevo color de producto';

            $this->cargar_header_y_principal();

            $this->establecer_reglas(TRUE);

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('color_productos/crear', $data);
            }
            else
            {
                $data = array('color' => $this->input->post('color'));
                $this->color_productos_model->crear_color_producto($data);
                $data['mensaje'] = '<h3 class="alert alert-success"> ¡Color de producto creado correctamente! </h3>';
                $this->load->view('color_productos/exito', $data);
            }

            $this->load->view('templates/footer');
        }

        public function ver($id_color_producto = NULL)
        {
            $this->cargar_header_y_principal();

            if ($id_color_producto === NULL)
            {
                $data['titulo'] = 'Colores de productos';

                $color_productos = $this->color_productos_model->obtener_color_productos_table();

                $resultado;

                if(!empty($color_productos))
                {
                    $this->load->library('table');
                    $this->load->helper('url');
                    $this->table->set_template(array('table_open' => '<table class="table">'));

                    foreach ($color_productos as $indice_fila => $fila)
                    {
                        $color_productos[$indice_fila]['id_color_producto'] = anchor('color_productos/ver/'.$fila['id_color_producto'],'Ver', 'class="btn btn-info"');
                    }

                    $this->table->set_heading('Color', '');

                    $resultado = '<div class="table-responsive">' . $this->table->generate($color_productos) . '</div>';
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['contenido'] = $resultado;
            }
            else
            { 
                $data['titulo'] = 'Información del color de producto';

                $color_producto = $this->color_productos_model->obtener_color_producto_por_id($id_color_producto);

                if ($color_producto === NULL) 
                {
                    $data['contenido'] = '<h4>Error al recuperar información del color de producto seleccionado</h4>';
                }
                else
                {
                    $data['id_color_producto'] = $color_producto->id_color_producto;
                    $data['color'] = $color_producto->color;
                    $data['color_original'] = $color_producto->color;
                }
            }
    
            $this->load->view('color_productos/ver', $data);

            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $datos = array(
                'id_color_producto' => $this->input->post('id_color_producto'),
                'color' => $this->input->post('color'));

            $validar_color_unico = TRUE;

            if ($datos['color'] === $this->input->post('color_original'))
            {
                 $validar_color_unico = FALSE;
            }

            $this-> establecer_reglas($validar_color_unico);

            if ($this->form_validation->run() === FALSE)
            {
                $this->ver($datos['id_color_producto']);
            }
            else
            {
                if ($this->color_productos_model->editar_color_producto($datos)) 
                {
                    $data['mensaje'] = '<h3 class="alert alert-success"> ¡Los datos del color de producto se actualizaron correctamente! </h3>';
                }
                else
                {
                    $data['mensaje'] = '<h3 class="alert alert-danger"> ¡No se actualizó la información! </h3>';
                }
                $this->cargar_header_y_principal();
                $this->load->view('color_productos/exito', $data);
                $this->load->view('templates/footer');
            }
        }

        public function eliminar()
        {
            $this->cargar_header_y_principal();
            $id_color_producto = $this->uri->segment(3);

            if ($id_color_producto === NULL)
            {
                 $data['mensaje'] = '<h3 class="alert alert-warning"> No se especificó un color de producto a eliminar </h3>';
            }
            elseif($this->color_productos_model->eliminar_color_producto($id_color_producto) == 1)
            {
                $data['mensaje'] = '<h3 class="alert alert-success"> ¡Color de producto eliminado correctamente! </h3>';
            }
            elseif($this->color_productos_model->eliminar_color_producto($id_color_producto) == 1451)
            {
                $data['mensaje'] = '<h3 class="alert alert-warning"> ¡No se puede eliminar un color que se encuentra en uso! </h3>';
            }
            else
            {
                $data['mensaje'] = '<h3 class="alert alert-warning"> ¡Color inexistente! </h3>';
            }

            $this->load->view('color_productos/exito', $data);
            $this->load->view('templates/footer');
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }

        private function establecer_reglas($validar_color_unico)
        {
            $array_validaciones = array('required');
            $array_mensajes = array('required' => 'El color es requerido');

            if ($validar_color_unico)
            {
                array_push($array_validaciones, 'is_unique[color_producto.color]');
                $array_mensajes['is_unique'] = 'El color ingresado ya existe';
            }

            $this->form_validation->set_rules('color', 'Color', $array_validaciones, $array_mensajes);
        }
    }