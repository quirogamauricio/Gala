<?php 
class Home extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('producto_model');
        $this->load->model('tipo_productos_model');
    }

    public function index()
    {
       
       $data['imagenes'] = $this->producto_model->obtener_productos_publicados();
       $data['tipo_productos'] = $this->tipo_productos_model->obtener_tipo_productos_table();


       $this->load->view('templates/header');
       $this->load->view('templates/home', $data);
       $this->load->view('templates/footer');
    }
}