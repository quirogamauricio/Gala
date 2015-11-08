<?php
class Cliente_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    public function crear_cliente($datos)
    {
        return $this->db->insert('cliente', $datos);
    }

    public function obtener_clientes()
    {
        return $this->db->query(
            'SELECT c.nombre, c.apellido, c.telefono, c.fecha_alta, c.id_cliente as "id"
            FROM cliente c
            ORDER BY c.apellido'
            )->result_array();
    }

    public function obtener_clientes_dropdown()
    {
        $clientes_array = array();

        $resultado = $this->db->query(
            'SELECT id_cliente, nombre, apellido
            FROM cliente c 
            ORDER BY apellido'
            )->result();

        foreach ($resultado as $fila)
        {
            $clientes_array[$fila->id_cliente] = $fila->apellido . ', ' . $fila->nombre;
        }

        return $clientes_array;
    }

    public function obtener_cliente_por_id($id_cliente)
    {
        $resultado = $this->db->query(
         'SELECT *
         FROM cliente 
         WHERE id_cliente =' . $id_cliente
         );

        $cliente = NULL;

        if($resultado && $resultado->num_rows() > 0)
        {
            $cliente = $resultado->row();
        }

        return $cliente;
    }

    public function editar_cliente($datos)
    {
        $campos = array('nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'telefono' => $datos['telefono']);
        
        $condicion = 'id_cliente =' . $datos['id_cliente'];
        $sentencia = $this->db->update_string('cliente', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function eliminar_cliente($id_cliente)
    {
        $numero_retorno;

        if ($this->db->query('DELETE FROM cliente WHERE id_cliente = ' . $id_cliente)) 
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