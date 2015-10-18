<?php
class Stock extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->session->user_is_authenticated();
            $this->load->library('form_validation');
            $this->load->model('stock_model');
            $this->load->model('sucursal_model');
            $this->load->model('producto_model');
        }

        public function index()
        {
            $this->ver();
        }

        public function nuevo()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $data['productos'] = $this->producto_model->obtener_productos_dropdown();
            $data['sucursales'] = $this->sucursal_model->obtener_sucursales_dropdown();
            $data['titulo'] = 'Crear nuevo stock';

            $this->cargar_header_y_principal();

            $this->establecer_reglas(TRUE);

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('stock/crear', $data);
            }
            else
            {
                $datos = array('stock_actual' => $this->input->post('stock_actual'),
                              'stock_minimo' => $this->input->post('stock_minimo'),
                              'id_producto' => $this->input->post('producto'),
                              'id_sucursal' => $this->input->post('sucursal')
                              );

                $this->stock_model->crear_stock($datos);
                $data['mensaje'] = "¡Stock creado correctamente!";
                $this->load->view('stock/exito', $data);
            }

            $this->load->view('templates/footer');
        }

        public function ver($id_stock = NULL)
        {
            $this->cargar_header_y_principal();

            if ($id_stock === NULL)
            {
                $data['titulo'] = 'Stock de productos';

                $stock = $this->stock_model->obtener_stock();

                $resultado;

                if(!empty($stock))
                {
                    $this->load->library('table');
                    $this->load->helper('url');
                    $this->table->set_template(array('table_open' => '<table class="table">'));

                    foreach ($stock as $indice_fila => $fila)
                    {
                        $stock[$indice_fila]['id_stock'] = anchor('stock/ver/'.$fila['id_stock'],'Ver', 'class="btn btn-info"');
                    }

                    $this->table->set_heading('Tipo de producto', 'Código', 'Sucursal', 'Stock actual', 'Stock mínimo');

                    $resultado = $this->table->generate($stock);
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['contenido'] = $resultado;
            }
            else
            { 
                $data['titulo'] = 'Información del stock de producto';

                $stock = $this->stock_model->obtener_stock_por_id($id_stock);

                if ($stock === NULL) 
                {
                    $data['contenido'] = '<h4>Error al recuperar información del stock seleccionado</h4>';
                }
                else
                {
                    $data['id_stock'] = $stock->id_stock;
                    $data['productos'] = $this->producto_model->obtener_productos_dropdown();
                    $data['id_producto'] = $stock->id_producto;
                    $data['id_producto_original'] = $stock->id_producto;
                    $data['sucursales'] = $this->sucursal_model->obtener_sucursales_dropdown();
                    $data['id_sucursal'] = $stock->id_sucursal;
                    $data['stock_actual'] = $stock->stock_actual;
                    $data['stock_minimo'] = $stock->stock_minimo;
                }
            }
    
            $this->load->view('stock/ver', $data);

            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $datos = array(
                'id_stock' => $this->input->post('id_stock'),
                'id_producto' => $this->input->post('producto'),
                'id_sucursal' => $this->input->post('sucursal'),
                'stock_actual' => $this->input->post('stock_actual'),
                'stock_minimo' => $this->input->post('stock_minimo'));

            $validar_producto_unico = TRUE;

            if ($datos['id_producto'] === $this->input->post('id_producto_original'))
            {
                 $validar_producto_unico = FALSE;
            }

            $this-> establecer_reglas($validar_producto_unico);

            if ($this->form_validation->run() === FALSE)
            {
                $this->ver($datos['id_stock']);
            }
            else
            {
                if ($this->stock_model->editar_stock($datos)) 
                {
                    $data['mensaje'] = '¡Los datos del stock se actualizaron correctamente!';
                }
                else
                {
                    $data['mensaje'] = '¡No se actualizó la información!';
                }
                $this->cargar_header_y_principal();
                $this->load->view('stock/exito', $data);
                $this->load->view('templates/footer');
            }
        }

        public function eliminar()
        {
            $this->cargar_header_y_principal();
            $id_stock = $this->uri->segment(3);

            if ($id_stock === NULL)
            {
                 $data['mensaje'] = 'No se especificó un stock a eliminar';
            }
            elseif($this->stock_model->eliminar_stock($id_stock) == 1)
            {
                $data['mensaje'] = '¡Stock eliminado correctamente!';
            }
            elseif($this->stock_model->eliminar_stock($id_stock) == 1451)
            {
                $data['mensaje'] = '¡No se puede eliminar un stock que se encuentra en uso!';
            }
            else
            {
                $data['mensaje'] = 'Stock inexistente!';
            }

            $this->load->view('stock/exito', $data);
            $this->load->view('templates/footer');
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }

        private function establecer_reglas($validar_producto_unico)
        {
            $this->form_validation->set_rules(
            'stock_actual', 
            'Stock actual',
            array('required', 'numeric', 'greater_than_equal_to[0]'),
            array('numeric' => 'El stock actual debe ser un valor numérico',
                  'greater_than_equal_to' => 'El stock actual debe ser mayor o igual a cero',
                  'required' => 'El stock actual es requerido')
            );

           $this->form_validation->set_rules(
            'stock_minimo', 
            'Stock mínimo',
            array('required','numeric', 'greater_than_equal_to[0]'),
            array('numeric' => 'El Stock mínimo debe ser un valor numérico',
                  'greater_than_equal_to' => 'El stock mínimo debe ser mayor o igual a cero',
                  'required' => 'El stock mínimo es requerido')
            );

            $array_validaciones = array();
            $array_mensajes = array();

            if ($validar_producto_unico)
            {
                array_push($array_validaciones, 'is_unique[stock.id_producto]');
                $array_mensajes['is_unique'] = 'Ya se creó stock para el producto seleccionado';
            }

            $this->form_validation->set_rules('producto', 'Producto', $array_validaciones, $array_mensajes);
        }
    }