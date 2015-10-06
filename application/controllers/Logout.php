<?php 
class Logout extends CI_Controller {

   public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function terminar_sesion()
    {
    	session_destroy();
    	redirect('login');
    }
}	