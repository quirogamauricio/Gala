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
            "SELECT p.codigo, tp.tipo, p.precio_costo, p.precio_venta_efectivo, 
                    p.precio_venta_tarjeta, cp.color, p.detalles, p.numero,
                    p.talle, (case when p.publicado = 0 then 'No' else 'Si' end), s.stock_actual,
                    s.stock_minimo, s.id_stock, p.id_producto as 'id'

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
            "SELECT p.imagen_url, p.detalles, p.codigo, p.precio_venta_efectivo, p.id_tipo_producto
            FROM producto p
            WHERE p.publicado = 1 AND  p.imagen_url IS NOT NULL"
            )->result_array();
    }

    public function obtener_productos_dropdown()
    {
        $productos_array = array();

        $resultado = $this->db->query(
            'SELECT p.id_producto, p.codigo, tp.tipo, p.talle, p.numero
            FROM producto p 
            INNER JOIN tipo_producto tp ON p.id_tipo_producto = tp.id_tipo_producto
            INNER JOIN stock s ON s.id_producto = p.id_producto
            WHERE s.stock_actual > 0
            ORDER BY tp.tipo'
            )->result();

        $talle_nro = '';

        foreach ($resultado as $fila)
        {
            if (!empty($fila->talle)) 
            {
                $talle_nro .= ' - Talle '. $fila->talle;
            }
                if (!empty($fila->numero))
            {
                $talle_nro .= ' - Número ' . $fila->numero;
            }   

            $productos_array[$fila->id_producto] = '[ '. $fila->tipo .' ]' . ' - ' . $fila->codigo . ' ' . $talle_nro;

            //Reset para que no se repita en todos los productos
            $talle_nro = '';
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

        if($resultado && $resultado->num_rows() > 0)
        {
            $producto = $resultado->row();
        }

        return $producto;
    }

    public function obtener_datos_producto($id_producto)
    {
        $resultado = $this->db->query(
        'SELECT p.id_producto, p.precio_venta_efectivo, p.precio_venta_tarjeta, s.stock_actual, s.stock_minimo
         FROM producto p
         INNER JOIN stock s ON p.id_producto = s.id_producto
         WHERE p.id_producto =' . $id_producto
         );

        $datos_producto = NULL;

        if($resultado && $resultado->num_rows() > 0)
        {
            $datos_producto = $resultado->row();
        }

        return $datos_producto;
    }

    public function editar_producto($datos)
    {
        $campos = array('codigo' => $datos['codigo'], 
            'id_tipo_producto' => $datos['id_tipo_producto'],
            'id_color_producto' => $datos['id_color_producto'],
            'precio_costo' => $datos['precio_costo'],
            'precio_venta_efectivo' => $datos['precio_venta_efectivo'],
            'precio_venta_tarjeta' => $datos['precio_venta_tarjeta'],
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

    public function producto_existe($id_producto)
    {
        
        $resultado = $this->db->query(
        'SELECT *
         FROM producto p
         INNER JOIN stock s ON p.id_producto = s.id_producto
         WHERE p.id_producto =' . $id_producto
         );

        return  $resultado->num_rows() > 0;
    }
}