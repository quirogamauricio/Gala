<?php
class Movimiento_caja_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function registrar_movimiento_caja($data)
    {
        return $this->db->insert('movimiento_caja', $data);
    }

    public function obtener_movimientos_table()
    {
        return $this->db->query('SELECT c.descripcion as "Caja", mc.importe, mc.concepto, ro.fecha, ro.descripcion, u.email
                                 FROM movimiento_caja mc
                                 INNER JOIN caja c ON c.id_caja = mc.id_caja
                                 INNER JOIN registro_operacion ro  ON mc.id_registro_operacion = ro.id_registro_operacion
                                 INNER JOIN usuario u on ro.id_usuario = u.id_usuario
                                 ORDER BY ro.fecha DESC')->result_array();
    }

    public function obtener_movimientos_por_caja_table($id_caja)
    {
        return $this->db->query('SELECT mc.importe, mc.concepto, ro.fecha, ro.descripcion, u.email
                                 FROM movimiento_caja mc
                                 INNER JOIN caja c ON c.id_caja = mc.id_caja
                                 INNER JOIN registro_operacion ro  ON mc.id_registro_operacion = ro.id_registro_operacion
                                 INNER JOIN usuario u on ro.id_usuario = u.id_usuario
                                 WHERE c.id_caja = '. $id_caja
                                 . ' ORDER BY ro.fecha DESC')->result_array();
    }

    public function obtener_movimiento_caja_por_id($id_movimiento_caja)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM movimiento_caja mc
            WHERE mc.id_movimiento_caja =' . $id_movimiento_caja
        );

        $movimiento_caja = NULL;

        if($resultado->num_rows() > 0)
        {
            $movimiento_caja = $resultado->row();
        }

        return $movimiento_caja;
    }
}