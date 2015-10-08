<?php
class Color_productos_model extends CI_Model{
    
        public function __construct()
        {
            $this->load->database();
        }

        public function crear_color_producto($data)
        {
            return $this->db->insert('color_producto', $data);
        }

        public function obtener_colores_producto_dropdown()
        {
            $colores_array = array();

            $resultado = $this->db->query('SELECT * FROM color_producto')->result();

            foreach ($resultado as $fila)
            {
                $colores_array[$fila->id_color_producto] = $fila->color;
            }

            return $colores_array;
        }

        public function obtener_color_productos_table()
        {
            return $this->db->query('SELECT color, id_color_producto FROM color_producto')->result_array();
        }

        public function obtener_color_producto_por_id($id_color_producto)
        {
            $resultado = $this->db->query(
               'SELECT *
                FROM color_producto
                WHERE id_color_producto = ' . $id_color_producto);

            $color_producto = NULL;

            if($resultado->num_rows() > 0)
            {
                $color_producto = $resultado->row();
            }

            return $color_producto;
        }

        public function editar_color_producto($datos)
        {
            $campos = array('color' => $datos['color']);
            $condicion = 'id_color_producto = ' . $datos['id_color_producto'];
            $sentencia = $this->db->update_string('color_producto', $campos, $condicion);
            return $this->db->query($sentencia);
        }

        public function eliminar_color_producto($id_color_producto)
        {
            $this->db->query('DELETE FROM color_producto WHERE id_color_producto = ' . $id_color_producto);
            return $this->db->affected_rows();
        }
}