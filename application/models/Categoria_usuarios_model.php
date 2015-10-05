<?php
class Categoria_usuarios_model extends CI_Model{

        public function __construct()
        {
                $this->load->database();
        }

        public function crear_categoria_usuario($data)
        {

            return $this->db->insert('categoria_usuario', $data);
        }

        public function obtener_categorias_usuario_dropdown()
        {
        	$categorias_array = array();

        	$resultado = $this->db->query('SELECT * FROM categoria_usuario WHERE fecha_baja IS NULL')->result();

        	foreach ($resultado as $fila)
        	{
        		$categorias_array[$fila->id_categoria] = $fila->categoria;
        	}

        	return $categorias_array;
        }

        public function obtener_categorias_usuario_table()
        {
            return $this->db->query('SELECT categoria, id_categoria FROM categoria_usuario WHERE fecha_baja IS NULL')->result_array();
        }

        public function obtener_categoria_usuario_por_id($id_categoria_usuario)
        {
            $resultado = $this->db->query(
               'SELECT *
                FROM categoria_usuario cu
                WHERE cu.id_categoria =' . $id_categoria_usuario .
                ' AND fecha_baja IS NULL'
            );

            $categoria_usuario = NULL;

            if($resultado->num_rows() > 0)
            {
                $categoria_usuario = $resultado->row();
            }

            return $categoria_usuario;
        }

        public function editar_categoria_usuario($datos)
        {
            $campos = array('categoria' => $datos['categoria']);
            $condicion = 'id_categoria =' . $datos['id_categoria'];
            $sentencia = $this->db->update_string('categoria_usuario', $campos, $condicion);
            return $this->db->query($sentencia);
        }

        public function eliminar_categoria_usuario($id_categoria_usuario)
        {
            $campos = array('fecha_baja' => date('Y-m-d H:i:s'));
            $condicion = 'id_categoria =' . $id_categoria_usuario . ' AND fecha_baja IS NULL';
            $sentencia = $this->db->update_string('categoria_usuario', $campos, $condicion);
            $this->db->query($sentencia);
            return $this->db->affected_rows();
        }
}
