<?php
class Caja_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function crear_caja($data)
    {
        return $this->db->insert('caja', $data);
    }

    public function obtener_cajas_table()
    {
        return $this->db->query('SELECT c.saldo, c.descripcion, c.id_caja
                                 FROM caja c
                                 ORDER BY c.id_caja')->result_array();
    }

    public function obtener_cajas_dropdown()
    {
        $cajas_array = array();

        $resultado = $this->db->query('SELECT * FROM caja')->result();

        foreach ($resultado as $fila)
        {
            $cajas_array[$fila->id_caja] = $fila->descripcion . ' - Saldo: $' . $fila->saldo;
        }

        return $cajas_array;
    }

    public function obtener_caja_por_id($id_caja)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM caja c
            WHERE c.id_caja =' . $id_caja
        );

        $caja = NULL;

        if($resultado->num_rows() > 0)
        {
            $caja = $resultado->row();
        }

        return $caja;
    }

    public function editar_caja($datos)
    {
        $campos = array('descripcion' => $datos['descripcion']);
        $condicion = 'id_caja =' . $datos['id_caja'];
        $sentencia = $this->db->update_string('caja', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function actualizar_saldo_caja($datos)
    {
        $campos = array('saldo' => $datos['saldo']);
        $condicion = 'id_caja =' . $datos['id_caja'];
        $sentencia = $this->db->update_string('caja', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function eliminar_caja($id_caja)
    {
        $numero_retorno;

        if ($this->db->query('DELETE FROM caja WHERE id_caja = ' . $id_caja)) 
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