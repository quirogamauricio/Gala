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
}