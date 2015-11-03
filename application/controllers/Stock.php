<?php
class Stock extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('stock_model');
    }

    public function index()
    {
        $this->ver();
    }

    public function ver($id_stock = NULL)
    {
        $this->cargar_header_y_principal();

        $data['titulo'] = 'Información del stock de producto';

        if ($id_stock === NULL)
        {
            $data['contenido'] = '<h4>No se especificó el stock de un producto</h4>';
        }
        else
        {
            $stock = $this->stock_model->obtener_stock_por_id($id_stock);

            if ($stock === NULL)
            {
                $data['contenido'] = '<h4>Error al recuperar información del stock seleccionado</h4>';
            }
            else
            {   
                $data['id_stock'] = $stock->id_stock;
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
            'stock_actual' => $this->input->post('stock_actual'),
            'stock_minimo' => $this->input->post('stock_minimo'));

        $this-> establecer_reglas();

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

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

    private function establecer_reglas()
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
    }
}