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

    public function obtener_stock()
    {
       return $this->db->query(
            'SELECT tp.tipo, p.codigo , su.sucursal, s.stock_actual, s.stock_minimo, s.id_stock
             FROM stock s
             INNER JOIN producto p ON s.id_producto = p.id_producto
             INNER JOIN tipo_producto tp ON p.id_tipo_producto = tp.id_tipo_producto
             INNER JOIN sucursal su ON s.id_sucursal = su.id_sucursal
             ORDER BY s.id_stock DESC'
         )->result_array();
    }

    public function obtener_stock_por_id($id_stock)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM stock s
            WHERE s.id_stock =' . $id_stock
        );

        $stock = NULL;

        if($resultado->num_rows() > 0)
        {
            $stock = $resultado->row();
        }

        return $stock;
    }

    public function editar_stock($datos)
    {
        $campos = array('stock_actual' => $datos['stock_actual'], 
                        'stock_minimo' => $datos['stock_minimo'],
                        'id_producto' => $datos['id_producto'],
                        'id_sucursal' => $datos['id_sucursal']
                        );

        $condicion = 'id_stock =' . $datos['id_stock'];
        $sentencia = $this->db->update_string('stock', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function eliminar_stock($id_stock)
    {
        $numero_retorno;

            if ($this->db->query('DELETE FROM stock WHERE id_stock = ' . $id_stock)) 
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