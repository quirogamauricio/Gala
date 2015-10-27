<?php
class Registro_operacion_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function registrar_operacion($data)
    {
        $this->db->insert('registro_operacion', $data);
        return $this->db->insert_id();
    }

    // public function obtener_movimientos_cajas_table()
    // {
    //     return $this->db->query('SELECT c.descripcion, mc.importe, mc.concepto, ro.fecha, ro.descripcion, u.email ,mc.id_operacion
    //                              FROM operacion mc
    //                              INNER JOIN caja c ON c.id_caja = mc.id_caja
    //                              INNER JOIN registro_operacion ro  ON mc.id_registro_operacion = ro.id_registro_operacion
    //                              INNER JOIN usuario u on ro.id_usuario = u.id_usuario
    //                              ORDER BY c.caja')->result_array();
    // }

    // public function obtener_operacion_por_id($id_operacion)
    // {
    //     $resultado = $this->db->query(
    //        'SELECT *
    //         FROM operacion mc
    //         WHERE mc.id_operacion =' . $id_operacion
    //     );

    //     $operacion = NULL;

    //     if($resultado->num_rows() > 0)
    //     {
    //         $operacion = $resultado->row();
    //     }

    //     return $operacion;
    // }
}