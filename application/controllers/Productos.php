<?php
class Productos extends CI_Controller {

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
                'publicado' => $this->input->post('publicado') == 0 ? FALSE : TRUE,
                'detalles' => !empty($this->input->post('detalles')) ? $this->input->post('detalles') : NULL,
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
                $data['titulo'] = 'productos del sistema';
                
                $productos = $this->producto_model->obtener_productos();

                $resultado;

                if(!empty($productos))
                {

                    $this->load->library('table');
                    $this->load->helper('url'); // Cargo helper para usar función anchor
                    $this->load->helper('date');
                    $this->table->set_heading('Email', 'Categoría', 'Fecha de alta');
                    $this->table->set_template(array('table_open' => '<table class="table">'));

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
                    $data['email'] = $producto->email;
                    $data['email_original'] = $producto->email;
                    $data['id_tipo'] = $producto->id_tipo;
                    $data['tipos'] = $this->tipo_productos_model->obtener_tipos_producto_dropdown();
                }
            }
            $this->load->view('productos/ver', $data);
            $this->load->view('templates/footer');
        }

        private function establecer_reglas_creacion()
        {
                $this->form_validation->set_rules(
                'precio_costo',
                'Precio de costo', 
                array('required', 'decimal', 'greater_than_equal_to[0]'),
                array('required' => 'El precio de costo es requerido', 
                      'decimal' => 'El precio costo debe ser un valor decimal',
                      'greater_than_equal_to' => 'El precio de costo debe ser mayor o igual a cero')
                );

            $this->form_validation->set_rules(
                'codigo',
                'Código', 
                array('required', 'is_unique[producto.codigo]'),
                array('required' => 'El código es requerido',
                      'is_unique' => 'Ya existe un producto con el código ingresado')
                ); 

            $this->form_validation->set_rules(
                'numero', 
                'Número',
                array('numeric'),
                array('numeric' => 'El número debe ser un valor numérico')
                );
        }

        private function cargar_header_y_principal()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
        }

}