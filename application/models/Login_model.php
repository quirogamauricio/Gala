<?php
class Login_model extends CI_Model
{
	public function __construct()
    {
        $this->load->database();
    }

    public function autenticar_usuario($datos)
    {
    	$resultado_consulta = $this->db->query('SELECT email, clave FROM usuario WHERE email = "' . $datos['email'] .'"');

    	if ($resultado_consulta->num_rows() > 0)
    	{
    		$clave = $resultado_consulta ->row()->clave;

    		if (password_verify($datos['clave'], $clave))
    		{
    			return TRUE;
    		}
    	}

    	return FALSE;
    }
}