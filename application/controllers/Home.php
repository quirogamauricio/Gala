<?php 
class Home extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('producto_model');
    }

    public function index()
    {
       
       $data['imagenes'] = $this->producto_model->obtener_productos_publicados();

       // $data['imagenes'] = $imagenes[0]['imagen_url'];

       $this->load->view('templates/header');
       $this->load->view('templates/home', $data);
       $this->load->view('templates/footer');
    }
}