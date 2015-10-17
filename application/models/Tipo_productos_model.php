<?php
class Tipo_productos_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function crear_tipo_producto($data)
    {
        return $this->db->insert('tipo_producto', $data);
    }

    public function obtener_tipos_producto_dropdown()
    {
        $tipos_array = array();

        $resultado = $this->db->query('SELECT * FROM tipo_producto')->result();

        foreach ($resultado as $fila)
        {
            $tipos_array[$fila->id_tipo_producto] = $fila->tipo;
        }

        return $tipos_array;
    }

    public function obtener_tipo_productos_table()
    {
        return $this->db->query('SELECT tipo, id_tipo_producto FROM tipo_producto')->result_array();
    }

    public function obtener_tipo_producto_por_id($id_tipo_producto)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM tipo_producto
            WHERE id_tipo_producto = ' . $id_tipo_producto);

        $tipo_producto = NULL;

        if($resultado->num_rows() > 0)
        {
            $tipo_producto = $resultado->row();
        }

        return $tipo_producto;
    }

    public function editar_tipo_producto($datos)
    {
        $campos = array('tipo' => $datos['tipo']);
        $condicion = 'id_tipo_producto = ' . $datos['id_tipo_producto'];
        $sentencia = $this->db->update_string('tipo_producto', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function eliminar_tipo_producto($id_tipo_producto)
    {
        $numero_retorno;

        if (!$this->db->query('DELETE FROM tipo_producto WHERE id_tipo_producto = ' . $id_tipo_producto)) 
        {
            $numero_retorno = $this->db->error()['code'];
        }
        else
        {
            
            $numero_retorno = $this->db->affected_rows();
        }
        
        return $numero_retorno;
    }
}