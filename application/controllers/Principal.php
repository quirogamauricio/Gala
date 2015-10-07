<?php 
class Principal extends CI_Controller {

	   public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->session->user_is_authenticated();
        }

        public function index()
        {
            $this->load->view('templates/header');
            $this->load->view('templates/principal');
            $this->load->view('templates/footer');
        }
}