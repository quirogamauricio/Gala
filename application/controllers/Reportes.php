<?php
class Reportes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('venta_model');
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
        $this->load->view('templates/reportes');
        $this->load->view('templates/footer');
    }

    public function  obtener_productos_mas_vendidos()
    {
        $productos = $this->venta_model->obtener_productos_mas_vendidos();

        if (!empty($productos))
         {
           header('Content-Type: application/json');
           echo json_encode( $productos);
         }
    }
}