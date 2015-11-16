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
        $data['mensaje'] = $resultado == 1 ? "¡Venta registrada exitosamente!" : "Error al intentar registrar venta";
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

            $resultado = $this->table->generate($ventas);
        }
        else
        {
            $resultado = '<h4>No se encontraron resultados</h4>';
        }

        $data['contenido'] = $resultado;

        $this->load->view('ventas/ver', $data);

        $this->load->view('templates/footer');
    }

    // public function editar()
    // {
    //     $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

    //     $datos = array(
    //         'id_venta' => $this->input->post('id_venta'),
    //         'descripcion' => $this->input->post('descripcion')
    //         );

    //     $this-> establecer_reglas();

    //     if ($this->form_validation->run() === FALSE)
    //     {
    //         $this->ver($datos['id_venta']);
    //     }
    //     else
    //     {
    //         if ($this->venta_model->editar_venta($datos)) 
    //         {
    //             $data['mensaje'] = '¡Los datos de la venta se actualizaron correctamente!';
    //         }
    //         else
    //         {
    //             $data['mensaje'] = '¡No se actualizó la información!';
    //         }
    //         $this->cargar_header_y_principal();
    //         $this->load->view('ventas/exito', $data);
    //         $this->load->view('templates/footer');
    //     }
    // }

    // public function eliminar()
    // {
    //     $this->cargar_header_y_principal();
    //     $id_venta = $this->uri->segment(3);

    //     if ($id_venta === NULL)
    //     {
    //          $data['mensaje'] = 'No se especificó una venta a eliminar';
    //     }
    //     elseif($this->venta_model->eliminar_venta($id_venta) == 1)
    //     {
    //         $data['mensaje'] = '¡venta eliminada correctamente!';
    //     }
    //     elseif($this->venta_model->eliminar_venta($id_venta) == 1451)
    //     {
    //         $data['mensaje'] = '¡No se puede eliminar una venta que se encuentra en uso!';
    //     }
    //     else
    //     {
    //         $data['mensaje'] = '¡venta inexistente!';
    //     }

    //     $this->load->view('ventas/exito', $data);
    //     $this->load->view('templates/footer');
    // }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }
}