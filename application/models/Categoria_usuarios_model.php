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

        public function obtener_categorias_usuario_dropdown()
        {
        	$categorias_array = array();

        	$resultado = $this->db->query('SELECT * FROM categoria_usuario')->result();

        	foreach ($resultado as $fila)
        	{
        		$categorias_array[$fila->id_categoria] = $fila->categoria;
        	}

        	return $categorias_array;
        }

        public function obtener_categorias_usuario_table()
        {
            return $this->db->query('SELECT cu.categoria FROM categoria_usuario cu')->result_array();
        }
}