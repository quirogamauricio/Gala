<?php
class Sucursal_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function crear_sucursal($data)
    {
        return $this->db->insert('sucursal', $data);
    }

    public function obtener_sucursales_dropdown()
    {
    	$sucursales_array = array();

    	$resultado = $this->db->query('SELECT * FROM sucursal')->result();

    	foreach ($resultado as $fila)
    	{
    		$sucursales_array[$fila->id_sucursal] = $fila->sucursal;
    	}

    	return $sucursales_array;
    }

    public function obtener_sucursales_table()
    {
        return $this->db->query('SELECT sucursal, direccion, id_sucursal FROM sucursal')->result_array();
    }

    public function obtener_sucursal_por_id($id_sucursal)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM sucursal s
            WHERE s.id_sucursal =' . $id_sucursal
        );

        $sucursal = NULL;

        if($resultado->num_rows() > 0)
        {
            $sucursal = $resultado->row();
        }

        return $sucursal;
    }

    public function editar_sucursal($datos)
    {
        $campos = array('direccion' => $datos['direccion'], 'sucursal' => $datos['sucursal']);
        $condicion = 'id_sucursal =' . $datos['id_sucursal'];
        $sentencia = $this->db->update_string('sucursal', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function eliminar_sucursal($id_sucursal)
    {
        $numero_retorno;

        if ($this->db->query('DELETE FROM sucursal WHERE id_sucursal = ' . $id_sucursal)) 
        {
            $numero_retorno = $this->db->affected_rows();
        }
        else
        {
            $numero_retorno = $this->db->error()['code'];
        }

        return $numero_retorno;
    }
}