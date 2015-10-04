<?php
class Usuario_model extends CI_Model{

        public function __construct()
        {
                $this->load->database();
        }

        public function crear_usuario($datos)
        {
            return $this->db->insert('usuario', $datos);
        }

        public function obtener_usuarios()
        {
            return $this->db->query(
                'SELECT u.email, cu.categoria, u.fecha_alta, u.id_usuario as "id"
                 FROM usuario u
                 INNER JOIN categoria_usuario cu on u.id_categoria = cu.id_categoria
                 WHERE u.fecha_baja IS NULL
                 ORDER BY u.fecha_alta'
            )->result_array();
        }

        public function obtener_usuario_por_id($id_usuario)
        {
            $resultado = $this->db->query(
               'SELECT u.id_usuario, u.email, u.id_categoria
                FROM usuario u
                WHERE u.id_usuario =' . $id_usuario
            );

            $usuario = NULL;

            if($resultado->num_rows() > 0)
            {
                $usuario = $resultado->row();
            }

            return $usuario;
        }

        public function editar_usuario($datos)
        {
            $campos = array('email' => $datos['email'], 'id_categoria' => $datos['id_categoria']);
            $condicion = 'id_usuario =' . $datos['id_usuario'];
            $sentencia = $this->db->update_string('usuario', $campos, $condicion);
            return $this->db->query($sentencia);
        }

        public function eliminar_usuario($id_usuario)
        {
            $campos = array('fecha_baja' => date('Y-m-d H:i:s'));
            $condicion = 'id_usuario =' . $id_usuario . ' AND fecha_baja IS NULL';
            $sentencia = $this->db->update_string('usuario', $campos, $condicion);
            $this->db->query($sentencia);
            return $this->db->affected_rows();
        }
}