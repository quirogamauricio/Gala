<?php
class Productos extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('producto_model');
        $this->load->model('tipo_productos_model');
        $this->load->model('color_productos_model');
        $this->load->model('stock_model');
    }

    public function index()
    {
        $this->ver();
    }

    public function nuevo()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['tipos'] = $this->tipo_productos_model->obtener_tipos_producto_dropdown();

        $data['colores'] = $this->color_productos_model->obtener_colores_producto_dropdown();

        $data['titulo'] = 'Crear nuevo producto';

        $this->establecer_reglas();

        $this->cargar_header_y_principal();

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('productos/crear', $data);
        }
        else
        {
            $datos = array(
                'precio_costo' => $this->input->post('precio_costo'),
                'precio_venta_efectivo' => !empty($this->input->post('precio_venta_efectivo')) ? $this->input->post('precio_venta_efectivo') : NULL,
                'precio_venta_tarjeta' => !empty($this->input->post('precio_venta_tarjeta')) ? $this->input->post('precio_venta_tarjeta') : NULL,
                'codigo' => $this->input->post('codigo'),
                'talle' => !empty($this->input->post('talle')) ? $this->input->post('talle') : NULL,
                'numero' => !empty($this->input->post('numero')) ? $this->input->post('numero') : NULL,
                'detalles' => !empty($this->input->post('detalles')) ? $this->input->post('detalles') : NULL,
                'imagen_url' => $this->subir_imagen(),
                'publicado' => $this->input->post('publicado') == 0 ? FALSE : TRUE,
                'id_tipo_producto' => $this->input->post('tipo'),
                'id_color_producto' => $this->input->post('color'),
                'fecha_alta'=> date('Y-m-d H:i:s')
                );

            //Creo producto
            $id_nuevo_producto = $this->producto_model->crear_producto($datos);

            //Creo stock
            $datos_stock = array('id_producto' => $id_nuevo_producto, 'stock_actual' => 0, 'stock_minimo' => 0);
            $this->stock_model->crear_stock($datos_stock);

            $data['mensaje'] = '<h3 class="alert alert-success"> ¡Producto creado correctamente! </h3>';
            $this->load->view('productos/exito', $data);
        }

        $this->load->view('templates/footer');
    }

    public function ver($id_producto = NULL)
    {
        $this->cargar_header_y_principal();
        $this->load->helper('html'); //Helper para usar img() 

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
                $this->table->set_heading('Código', 'Tipo', 'Precio costo', 'Precio venta efectivo', 'Precio venta tarjeta', 'Color', 'Detalles', 'Número', 'Talle', 'Publicado', 'Stock actual', 'Stock mínimo', '', '');
                $this->table->set_template(array('table_open' => '<table class="table">'));
                $this->table->set_empty('-');

                foreach ($productos as $indice_fila => $fila)
                {
                    $productos[$indice_fila]['id'] = anchor('productos/ver/'.$fila['id'],'Ver', 'class="btn btn-info"');
                    $productos[$indice_fila]['id_stock'] = anchor('stock/ver/'.$fila['id_stock'],'Stock', 'class="btn btn-info"'); //Permite generar el link para ver el producto particular
                    
                    if ($productos[$indice_fila]['stock_actual'] < $productos[$indice_fila]['stock_minimo'])
                    {
                        $productos[$indice_fila]['id'] .= form_input(array('type' => 'hidden', 'class' => 'alerta-stock'));
                    }
                }

                    $resultado = '<div class="table-responsive">' . $this->table->generate($productos) . '</div>';
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['contenido'] = $resultado;
            }
            else
            {
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
                    $data['precio_costo'] = $producto->precio_costo;
                    $data['precio_costo_original'] = $producto->precio_costo;
                    $data['precio_venta_efectivo'] = $producto->precio_venta_efectivo;
                    $data['precio_venta_tarjeta'] = $producto->precio_venta_tarjeta;
                    $data['id_tipo_producto'] = $producto->id_tipo_producto;
                    $data['tipos'] = $this->tipo_productos_model->obtener_tipos_producto_dropdown();
                    $data['id_color_producto'] = $producto->id_color_producto;
                    $data['colores'] = $this->color_productos_model->obtener_colores_producto_dropdown();
                    $data['detalles'] = $producto->detalles;
                    $data['talle'] = $producto->talle;
                    $data['numero'] = $producto->numero;
                    $data['esta_publicado'] = $producto->publicado == 1 ? TRUE : FALSE;
                    $data['no_esta_publicado'] = $producto->publicado == 0 ? TRUE : FALSE;
                    $data['imagen_original'] = $producto->imagen_url;
                }
            }

            $this->load->view('productos/ver', $data);
            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $imagen_subida = $this->subir_imagen();

            $datos = array(
                'id_producto' => $this->input->post('id_producto'),
                'codigo' => $this->input->post('codigo'),
                'id_tipo_producto' => $this->input->post('tipo'),
                'id_color_producto' => $this->input->post('color'),
                'precio_costo' => $this->input->post('precio_costo'),
                'precio_venta_efectivo' => !empty($this->input->post('precio_venta_efectivo')) ? $this->input->post('precio_venta_efectivo') : NULL,
                'precio_venta_tarjeta' => !empty($this->input->post('precio_venta_tarjeta')) ? $this->input->post('precio_venta_tarjeta') : NULL,
                'talle' => !empty($this->input->post('talle')) ? $this->input->post('talle') : NULL,
                'numero' => !empty($this->input->post('numero')) ? $this->input->post('numero') : NULL,
                'detalles' => !empty($this->input->post('detalles')) ? $this->input->post('detalles') : NULL,
                'publicado' => $this->input->post('publicado') == 0 ? FALSE : TRUE,
                'imagen_url' =>  $imagen_subida === NULL ?  $this->input->post('imagen_original') : $imagen_subida
                );

            $this-> establecer_reglas();

            if ($this->form_validation->run() === FALSE)
                {
                    $this->ver($datos['id_producto']);
                }
            else
            {
                if ($this->producto_model->editar_producto($datos)) 
                {
                    $data['mensaje'] = '<h3 class="alert alert-success"> ¡Los datos del producto se actualizaron correctamente! </h3>';
                }
                else
                {
                    $data['mensaje'] = '<h3 class="alert alert-danger">¡No se actualizó la información! </h3>';
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
            $data['mensaje'] = '<h3 class="alert alert-warning"> No se especificó un producto a eliminar </h3>';
        }
        elseif(!is_numeric($id_producto))
        {
            $data['mensaje'] = '<h3 class="alert alert-warning">¡Producto inexistente!</h3>';
        }
        elseif(!$this->producto_model->producto_existe($id_producto))
        {
            $data['mensaje'] = '<h3 class="alert alert-warning"> ¡Producto inexistente! </h3>';
        }
        elseif($this->producto_model->eliminar_producto_y_stock_asociado($id_producto))
        {
            $data['mensaje'] = '<h3 class="alert alert-success"> ¡Producto eliminado correctamente! </h3>';
        }
        elseif(!$this->producto_model->eliminar_producto_y_stock_asociado($id_producto))
        {
            $data['mensaje'] = '<h3 class="alert alert-warning"> No se puede eliminar un producto que registra ventas </h3>';
        }

        $this->load->view('productos/exito', $data);
        $this->load->view('templates/footer');
    }

    private function establecer_reglas()
    {
        $this->form_validation->set_rules('codigo','Código',  array('required'), array('required' => 'El codigo es requerido'));

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
              'decimal' => 'El precio de costo debe ser un valor decimal',
              'greater_than_equal_to' => 'El precio de costo debe ser mayor o igual a cero')
            );

        $this->form_validation->set_rules(
            'precio_venta_tarjeta',
            'Precio de venta con tarjeta', 
            array('required', 'decimal', 'greater_than_equal_to[0]'),
            array('required' => 'El precio de venta con tarjeta es requerido', 
              'decimal' => 'El precio de venta con tarjeta debe ser un valor decimal',
              'greater_than_equal_to' => 'El precio de venta con tarjeta debe ser mayor o igual a cero')
            );

        $this->form_validation->set_rules(
            'precio_venta_efectivo',
            'Precio de venta en efectivo', 
            array('required', 'decimal', 'greater_than_equal_to[0]'),
            array('required' => 'El precio de venta en efectivo es requerido', 
              'decimal' => 'El precio de venta en efectivo debe ser un valor decimal',
              'greater_than_equal_to' => 'El precio de venta en efectivo debe ser mayor o igual a cero')
            );
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

    private function subir_imagen()
    {
        $imagen_url = NULL;

        $this->load->library('upload');

        if ($this->upload->do_upload('imagen')) 
        {
            $imagen_url = $this->upload->data('file_name');
        }
        return $imagen_url;
    }
}