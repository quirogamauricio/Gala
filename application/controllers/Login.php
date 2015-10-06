<?php 
class Login extends CI_Controller {

	   public function __construct()
        {
            parent::__construct();
            $this->load->model('login_model');
        }

        public function index()
        {
            $this->load->view('templates/login');
        }

        public function autenticar()
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $this->establecer_reglas();

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/login');
            }
            else
            {
                $datos = array('email' => $this->input->post('email'),
                               'clave' => $this->input->post('clave'));

                if ($this->login_model->autenticar_usuario($datos))
                {
                    #iniciar sesión, guardar datos necesarios

                    $this->load->view('templates/header');
                    $this->load->view('templates/principal');
                    $this->load->view('templates/footer');
                }
                else
                {
                    #mostrar error
                    $data['mostrar_error'] = TRUE;
                    $this->load->view('templates/login', $data);
                }
            }
        }

        private function establecer_reglas()
        {
            $this->form_validation->set_rules('email', 'Email', array('required'), array('required' => 'Debe ingresar el email'));
            $this->form_validation->set_rules('clave', 'Contraseña', array('required'), array('required' => 'Debe ingresar la contraseña'));
        }
}