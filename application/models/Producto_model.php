<?php
class Producto_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    public function crear_producto($datos)
    {
        return $this->db->insert('producto', $datos);
    }

    public function obtener_productos()
    {
        return $this->db->query(
            "SELECT p.codigo, tp.tipo, p.precio_costo, cp.color, p.detalles, p.numero, p.talle, (case when p.publicado = 0 then 'No' else 'Si' end), p.fecha_alta, p.id_producto as 'id'
             FROM producto p
             INNER JOIN tipo_producto tp on p.id_tipo_producto = tp.id_tipo_producto
             INNER JOIN color_producto cp on p.id_color_producto = cp.id_color_producto
             ORDER BY p.fecha_alta DESC"
        )->result_array();
    }

    public function obtener_producto_por_id($id_producto)
    {
        $resultado = $this->db->query(
           'SELECT *
            FROM producto p
            WHERE p.id_producto =' . $id_producto
        );

        $producto = NULL;

        if($resultado->num_rows() > 0)
        {
            $producto = $resultado->row();
        }

        return $producto;
    }

    public function editar_producto($datos)
    {
        $campos = array('codigo' => $datos['codigo'], 
                        'id_tipo_producto' => $datos['id_tipo_producto'],
                        'id_color_producto' => $datos['id_color_producto'],
                        'precio_costo' => $datos['precio_costo'],
                        'detalles' => $datos['detalles'],
                        'talle' => $datos['talle'],
                        'numero' => $datos['numero'],
                        'publicado' => $datos['publicado']
                        );

        $condicion = 'id_producto = ' . $datos['id_producto'];
        $sentencia = $this->db->update_string('producto', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    //     $producto = NULL;

    //     if($resultado->num_rows() > 0)
    //     {
    //         $producto = $resultado->row();
    //     }

    //     return $producto;
    // }

    // public function editar_producto($datos)
    // {
    //     $campos = array('codigo' => $datos['codigo'], 'id_tipo' => $datos['id_tipo']);
    //     $condicion = 'id_producto =' . $datos['id_producto'];
    //     $sentencia = $this->db->update_string('producto', $campos, $condicion);
    //     return $this->db->query($sentencia);
    // }

    // public function eliminar_producto($id_producto)
    // {
    //     $campos = array('fecha_baja' => date('Y-m-d H:i:s'));
    //     $condicion = 'id_producto =' . $id_producto . ' AND fecha_baja IS NULL';
    //     $sentencia = $this->db->update_string('producto', $campos, $condicion);
    //     $this->db->query($sentencia);
    //     return $this->db->affected_rows();
    // }
}