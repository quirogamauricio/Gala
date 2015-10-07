<?php
class MY_Session extends CI_Session{

	public function __construct(array $params = array())
	{
		parent::__construct($params);
		$CI =& get_instance();
		$CI->load->helper('url');
	}

	public function user_is_authenticated()
	{
        if (!isset($_SESSION['usuario_autenticado']) || !$_SESSION['usuario_autenticado'] === TRUE)
        {
            redirect('login');
        }
	}
}