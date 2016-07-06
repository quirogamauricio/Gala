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
                'SELECT u.email, u.fecha_alta, u.id_usuario as "id"
                 FROM usuario u
                 INNER JOIN categoria_usuario cu on u.id_categoria = cu.id_categoria
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

            if($resultado && $resultado->num_rows() > 0)
            {
                $usuario = $resultado->row();
            }

            return $usuario;
        }

       public function obtener_usuario_por_email($email)
        {
            $resultado = $this->db->query(
               'SELECT u.id_usuario, u.email
                FROM usuario u
                WHERE u.email = "' . $email . ' " '
                );

            return $resultado->row();
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
           $this->db->query('DELETE FROM usuario WHERE id_usuario = ' . $id_usuario);
           return $this->db->affected_rows();
        }
}