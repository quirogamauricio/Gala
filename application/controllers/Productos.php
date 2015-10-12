<?php
class Productos extends CI_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');

            $this->session->user_is_authenticated();

            $this->load->model('producto_model');
            $this->load->model('tipo_productos_model');
            $this->load->model('color_productos_model');
        }

        public function index()
        {
            $this->ver();
        }
        
        public function nuevo()
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $data['tipos'] = $this->tipo_productos_model->obtener_tipos_producto_dropdown();

            $data['colores'] = $this->color_productos_model->obtener_colores_producto_dropdown();

            $data['titulo'] = 'Crear nuevo producto';

            $this->establecer_reglas_creacion();

            $this->cargar_header_y_principal();

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('productos/crear', $data);
            }
            else
            {
                $datos = array(
                'precio_costo' => $this->input->post('precio_costo'),
                'codigo' => $this->input->post('codigo'),
                'talle' => !empty($this->input->post('talle')) ? $this->input->post('talle') : NULL,
                'numero' => !empty($this->input->post('numero')) ? $this->input->post('numero') : NULL,
                'detalles' => !empty($this->input->post('detalles')) ? $this->input->post('detalles') : NULL,
                'publicado' => $this->input->post('publicado') == 0 ? FALSE : TRUE,
                'id_tipo_producto' => $this->input->post('tipo'),
                'id_color_producto' => $this->input->post('color'),
                'fecha_alta'=> date('Y-m-d H:i:s')
                 );

                $this->producto_model->crear_producto($datos);
                $data['mensaje'] = "¡Producto creado correctamente!";
                $this->load->view('productos/exito', $data);
            }

            $this->load->view('templates/footer');
        }

        public function ver($id_producto = NULL)
        {
            $this->cargar_header_y_principal();

            if ($id_producto === NULL) 
            {
                $data['titulo'] = 'Productos del sistema';
                
                $productos = $this->producto_model->obtener_productos();

                $resultado;

                if(!empty($productos))
                {

                    $this->load->library('table');
                    $this->load->helper('url'); // Cargo helper para usar función anchor
                    $this->load->helper('date');
                    $this->table->set_heading('Código', 'Tipo', 'Precio de costo', 'Color', 'Detalles', 'Número', 'Talle', 'Publicado', 'Fecha de alta');
                    $this->table->set_template(array('table_open' => '<table class="table">'));
                    $this->table->set_empty('-');

                    foreach ($productos as $indice_fila => $fila)
                    {
                        $productos[$indice_fila]['id'] = anchor('productos/ver/'.$fila['id'],'Ver', 'class="btn btn-info"'); //Permite generar el link para ver el producto particular
                        $productos[$indice_fila]['fecha_alta'] = transform_date($fila['fecha_alta'], '/');
                    }

                    $resultado = $this->table->generate($productos);
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

                $data['titulo'] = 'Información del producto';

                $producto = $this->producto_model->obtener_producto_por_id($id_producto);

                if ($producto === NULL) 
                {
                    $data['contenido'] = '<h4>Error al recuperar información del producto seleccionado</h4>';
                }
                else
                {
                    $data['id_producto'] = $producto->id_producto;
                    $data['codigo'] = $producto->codigo;
                    $data['codigo_original'] = $producto->codigo;
                    $data['precio_costo'] = $producto->precio_costo;
                    $data['precio_costo_original'] = $producto->precio_costo;
                    $data['id_tipo_producto'] = $producto->id_tipo_producto;
                    $data['tipos'] = $this->tipo_productos_model->obtener_tipos_producto_dropdown();
                    $data['id_color_producto'] = $producto->id_color_producto;
                    $data['colores'] = $this->color_productos_model->obtener_colores_producto_dropdown();
                    $data['detalles'] = $producto->detalles;
                    $data['talle'] = $producto->talle;
                    $data['numero'] = $producto->numero;
                    $data['esta_publicado'] = $producto->publicado == 1 ? TRUE : FALSE;
                    $data['no_esta_publicado'] = $producto->publicado == 0 ? TRUE : FALSE;
                }
            }

            $this->load->view('productos/ver', $data);
            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $datos = array(
                'id_producto' => $this->input->post('id_producto'),
                'codigo' => $this->input->post('codigo'),
                'id_tipo_producto' => $this->input->post('tipo'),
                'id_color_producto' => $this->input->post('color'),
                'precio_costo' => $this->input->post('precio_costo'),
                'talle' => !empty($this->input->post('talle')) ? $this->input->post('talle') : NULL,
                'numero' => !empty($this->input->post('numero')) ? $this->input->post('numero') : NULL,
                'detalles' => !empty($this->input->post('detalles')) ? $this->input->post('detalles') : NULL,
                'publicado' => $this->input->post('publicado') == 0 ? FALSE : TRUE
                );

            $validar_codigo_unico = TRUE;

            if ($datos['codigo'] === $this->input->post('codigo_original'))
            {
                 $validar_codigo_unico = FALSE;
            }

            $this-> establecer_reglas_edicion($validar_codigo_unico);

            if ($this->form_validation->run() === FALSE)
            {
                $this->ver($datos['id_producto']);
            }
            else
            {
                if ($this->producto_model->editar_producto($datos)) 
                {
                    $data['mensaje'] = '¡Los datos del producto se actualizaron correctamente!';
                }
                else
                {
                    $data['mensaje'] = '¡No se actualizó la información!';
                }   
                $this->cargar_header_y_principal();
                $this->load->view('productos/exito', $data);
                $this->load->view('templates/footer');
            }
        }

        public function eliminar()
        {
            $this->cargar_header_y_principal();
            $id_producto = $this->uri->segment(3);

            if ($id_producto === NULL)
            {
                $data['mensaje'] = 'No se especificó un producto a eliminar';
            }
            elseif($this->producto_model->eliminar_producto($id_producto) > 0)
            {
                $data['mensaje'] = '¡Producto eliminado correctamente!';
            }
            else
            {
                $data['mensaje'] = '¡Producto inexistente!';
            }

            $this->load->view('productos/exito', $data);
            $this->load->view('templates/footer');
        }

        private function establecer_reglas_edicion($validar_codigo_unico)
        {
            $array_validaciones = array('required');

            $array_mensajes = array('required' => 'El codigo es requerido');

            if ($validar_codigo_unico) 
            {
                array_push($array_validaciones, 'is_unique[producto.codigo]') ;
                $array_mensajes['is_unique'] = 'El código ingresado ya se encuentra en uso';
            }

            $this->form_validation->set_rules('codigo','Código', $array_validaciones, $array_mensajes);
            $this->establecer_reglas_comunes();
        }

        private function establecer_reglas_creacion()
        {
            $this->form_validation->set_rules(
                'codigo',
                'Código', 
                array('required', 'is_unique[producto.codigo]'),
                array('required' => 'El código es requerido',
                      'is_unique' => 'Ya existe un producto con el código ingresado')
                ); 

            $this->establecer_reglas_comunes();
        }

        private function establecer_reglas_comunes()
        {
            $this->form_validation->set_rules(
            'numero', 
            'Número',
            array('numeric', 'greater_than_equal_to[0]'),
            array('numeric' => 'El número debe ser un valor numérico',
                  'greater_than_equal_to' => 'El número debe ser mayor o igual a cero')
            );

            $this->form_validation->set_rules(
            'precio_costo',
            'Precio de costo', 
            array('required', 'decimal', 'greater_than_equal_to[0]'),
            array('required' => 'El precio de costo es requerido', 
                  'decimal' => 'El precio costo debe ser un valor decimal',
                  'greater_than_equal_to' => 'El precio de costo debe ser mayor o igual a cero')
            );
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }
}