<?php
class Producto_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    public function crear_producto($datos)
    {
        $this->db->insert('producto', $datos);
        return $this->db->insert_id();
    }

    public function obtener_productos()
    {
        return $this->db->query(
            "SELECT p.codigo, tp.tipo, p.precio_costo, cp.color, p.detalles, p.numero, p.talle, p.imagen_url, (case when p.publicado = 0 then 'No' else 'Si' end), s.stock_actual, s.stock_minimo, s.id_stock, p.id_producto as 'id'
            FROM producto p
            INNER JOIN tipo_producto tp ON p.id_tipo_producto = tp.id_tipo_producto
            INNER JOIN color_producto cp ON p.id_color_producto = cp.id_color_producto
            INNER JOIN stock s ON s.id_producto = p.id_producto
            ORDER BY p.fecha_alta DESC"
            )->result_array();
    }

    public function obtener_productos_publicados()
    {
        return $this->db->query(
            "SELECT p.imagen_url, p.detalles, p.codigo
            FROM producto p
            WHERE p.publicado = 1 AND  p.imagen_url IS NOT NULl"
            )->result_array();
    }

    public function obtener_productos_dropdown()
    {
        $productos_array = array();

        $resultado = $this->db->query(
            'SELECT p.id_producto, p.codigo, tp.tipo
            FROM producto p 
            INNER JOIN tipo_producto tp ON p.id_tipo_producto = tp.id_tipo_producto
            ORDER BY tp.tipo'
            )->result();

        foreach ($resultado as $fila)
        {
            $productos_array[$fila->id_producto] = '[ '. $fila->tipo .' ]' . ' - ' . $fila->codigo;
        }

        return $productos_array;
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
            'publicado' => $datos['publicado'],
            'imagen_url' => empty($datos['imagen_url']) ? NULL : $datos['imagen_url']
            );

        $condicion = 'id_producto = ' . $datos['id_producto'];
        $sentencia = $this->db->update_string('producto', $campos, $condicion);
        return $this->db->query($sentencia);
    }

    public function eliminar_producto_y_stock_asociado($id_producto)
    {
        /* Se utiliza transacción para evitar eliminar el stock si no se puede eliminar
         el producto por restricción de FK */

        $this->db->trans_start();
        $this->db->query('DELETE FROM stock WHERE id_producto = ' . $id_producto);
        $this->db->query('DELETE FROM producto WHERE id_producto = ' . $id_producto);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}