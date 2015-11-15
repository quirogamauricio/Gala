<?php
class Venta_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('registro_operacion_model');
        $this->load->library('operaciones_enum');
    }

    public function registrar_venta($venta)
    {

        $detalles_venta = $venta["detalles_venta"];

        /* Se utiliza transacción para evitar registrar la venta sin detalles y viceversa*/

        $this->db->trans_start();

        $datos_venta = array("id_cliente" => $venta["id_cliente"],
                             "importe_total" => $venta["importe_total"],
                             "id_caja" => $venta["id_caja"],
                             "id_registro_operacion" => $this->registrar_operacion());

        $this->db->insert('venta', $datos_venta);

        $id_venta =  $this->db->insert_id();

        foreach ($detalles_venta as $detalle) {

            $detalle["id_venta"] = $id_venta;
            $this->db->insert('detalle_venta', $detalle);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    private function registrar_operacion()
    {
        $descripcion = operaciones_enum::registro_venta;

        $datos_operacion = array('descripcion' => $descripcion,
                                 'id_usuario' => $_SESSION['usuario_id'],
                                 'fecha' => date('Y-m-d H:i:s'));

        return $this->registro_operacion_model->registrar_operacion($datos_operacion);
    }

}