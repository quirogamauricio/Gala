<?php
class Usuario_model extends CI_Model{

        public function __construct()
        {
                $this->load->database();
        }

        public function crear_usuario()
        {
            $data = array(
                'nombre_usuario' => $this->input->post('nombre_usuario'),
                'email' => $this->input->post('email'),
                'clave' => password_hash($this->input->post('clave'), PASSWORD_DEFAULT),
                'id_categoria' => $this->input->post('categoria'),
                'fecha_alta'=> date('Y-m-d H:i:s')
                 );

            return $this->db->insert('usuario', $data);
        }

        public function obtener_usuarios()
        {
            $this->load->helper('url'); // Cargo helper para usar función anchor

            $resultado = $this->db->query(
                'SELECT u.nombre_usuario, cu.categoria, u.email, u.fecha_alta, u.id_usuario as "id"
                 FROM usuario u
                 INNER JOIN categoria_usuario cu on u.id_categoria = cu.id_categoria
                 WHERE u.fecha_baja IS NULL
                 ORDER BY u.fecha_alta'
                )->result_array();

            foreach ($resultado as $indice_fila => $fila)
                {
                    $resultado[$indice_fila]['id'] = anchor('usuarios/ver/'.$fila['id'],'Ver');
                }

            return $resultado;
        }
}