<?php 
class Principal extends CI_Controller {

	   public function __construct()
        {
            parent::__construct();
            $this->load->library('session');

            if (!isset($_SESSION['usuario_autenticado']) || !$_SESSION['usuario_autenticado'] === TRUE)
            {
                $this->load->helper('url');
                redirect('login');
            }
        }

        public function index()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
            $this->load->view('templates/footer');
        }
}