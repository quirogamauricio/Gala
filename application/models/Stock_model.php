<?php
class Stock_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function crear_stock($datos)
    {
        return $this->db->insert('stock', $datos);
    }

    public function obtener_stock_por_id($id_stock)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM stock s
            WHERE s.id_stock =' . $id_stock
        );

        $stock = NULL;

        if($resultado && $resultado->num_rows() > 0)
        {
            $stock = $resultado->row();
        }

        return $stock;
    }

    public function obtener_stock_por_id_producto($id_producto)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM stock s
            WHERE s.id_producto =' . $id_producto
        );

        $stock = NULL;

        if($resultado && $resultado->num_rows() > 0)
        {
            $stock = $resultado->row();
        }

        return $stock;
    }

    public function editar_stock($datos)
    {
        $campos = array('stock_actual' => $datos['stock_actual'], 
                        'stock_minimo' => $datos['stock_minimo']
                        );

        $condicion = 'id_stock =' . $datos['id_stock'];
        $sentencia = $this->db->update_string('stock', $campos, $condicion);
        return $this->db->query($sentencia);
    }
}