<?php 
class Login extends CI_Controller {

	   public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
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

                $this->load->model('login_model');

                if ($this->login_model->autenticar_usuario($datos))
                {
                    #iniciar sesión, guardar datos necesarios
                    $this->load->model('usuario_model');

                    $usuario = $this->usuario_model->obtener_usuario_por_email($datos['email']);

                    $_SESSION['usuario_id'] = $usuario->id_usuario;
                    $_SESSION['usuario_email'] = $usuario->email;
                    $_SESSION['usuario_autenticado'] = TRUE;

                    $this->load->helper('url');

                    redirect('principal');
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