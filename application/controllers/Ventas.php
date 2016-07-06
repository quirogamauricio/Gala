<?php
class Ventas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('venta_model');
        $this->load->model('cliente_model');
        $this->load->model('producto_model');
        $this->load->model('caja_model');
        $this->load->model('movimiento_caja_model');
    }

    public function index()
    {
        $this->ver();
    }
    
    public function nueva()
    {
        $data['titulo'] = 'Registrar nueva venta';
        $data['productos'] = $this->producto_model->obtener_productos_dropdown();
        $data['clientes'] = $this->cliente_model->obtener_clientes_dropdown();
        $data['cajas'] = $this->caja_model->obtener_cajas_dropdown();

        $this->cargar_header_y_principal();
        $this->load->view('ventas/crear', $data);
        $this->load->view('templates/footer');
    }

    public function obtener_datos_producto($id_producto)
    {
        $id_producto = $this->uri->segment(3);

        if ($id_producto != NULL)
         {
            $datos = $this->producto_model->obtener_datos_producto($id_producto);

           header('Content-Type: application/json');
           echo json_encode( $datos );
         }
    }

    public function registrar_venta()
    {
        $venta = $this->input->post('venta');

        $resultado = 0;

        if ($this->venta_model->registrar_venta($venta))
        {
            $resultado = 1;
        }

        echo $resultado;
    }

    public function resultado($resultado)
    {
        $data['mensaje'] = $resultado == 1 ? '<h3 class="alert alert-success"> ¡Venta registrada exitosamente! </h3>' 
        : '<h3 class="alert alert-danger"> Error al intentar registrar venta </h3>';
        $this->cargar_header_y_principal();
        $this->load->view('ventas/exito', $data);
        $this->load->view('templates/footer');
    }

  
    public function ver()
    {
        $this->cargar_header_y_principal();

        $data['titulo'] = 'Historial de ventas';

        $ventas = $this->venta_model->obtener_ventas();

        $resultado;

        if(!empty($ventas))
        {
            $this->load->library('table');
            $this->load->helper('url');
            $this->table->set_template(array('table_open' => '<table class="table">'));
            $this->table->set_heading('Importe total', 'Cliente', 'Código producto', 'Talle', 'Número', 'Cantidad', 'Fecha de venta', 'Vendedor', 'Caja', 'Forma de pago');
            $this->table->set_empty('-');

            $resultado = '<div class="table-responsive">' . $this->table->generate($ventas) . '</div>';
        }
        else
        {
            $resultado = '<h4>No se encontraron resultados</h4>';
        }

        $data['contenido'] = $resultado;

        $this->load->view('ventas/ver', $data);

        $this->load->view('templates/footer');
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }
}