<?php
class Categoria_usuarios_model extends CI_Model{

        public function __construct()
        {
                $this->load->database();
        }

        public function crear_categoria_usuario()
        {
            $data = array('categoria' => $this->input->post('categoria'));

            return $this->db->insert('categoria_usuario', $data);
        }
}