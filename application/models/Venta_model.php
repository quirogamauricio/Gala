<?php
class Venta_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model('registro_operacion_model');
        $this->load->model('movimiento_caja_model');
        $this->load->model('caja_model');
        $this->load->model('stock_model');
        $this->load->library('operaciones_enum');
    }

    public function registrar_venta($venta)
    {
        $detalles_venta = $venta['detalles_venta'];

        /* Se utiliza transacción para evitar registrar la venta sin detalles y viceversa*/

        //Inicia transacción
        $this->db->trans_start();

        //Registro de operación
        $id_registro_operacion = $this->registrar_operacion();

        //Datos de venta
        $id_caja = $venta['id_caja'];
        $importe_total = $venta['importe_total'];

        $datos_venta = array('id_cliente' => $venta['id_cliente'],
                             'importe_total' => $importe_total,
                             'id_caja' => $id_caja,
                             'id_registro_operacion' => $id_registro_operacion);

        //Venta
        $this->db->insert('venta', $datos_venta);

        $id_venta =  $this->db->insert_id();

        //Detalles de venta
        foreach ($detalles_venta as $detalle) {

            $detalle['id_venta'] = $id_venta;
            $this->db->insert('detalle_venta', $detalle);

             //Actualizar stock
             $stock = $this->stock_model->obtener_stock_por_id_producto($detalle['id_producto']);

             $nuevo_stock_actual =  $stock->stock_actual - $detalle['cantidad'];

             $datos_stock = array('stock_actual' => $nuevo_stock_actual, 'stock_minimo' => $stock->stock_minimo, 'id_stock' => $stock->id_stock);

             $this->stock_model->editar_stock($datos_stock);
        }

        //Movimiento de caja
        $datos_movimiento_caja = array(
            'importe' => $importe_total,
            'id_caja' => $id_caja,
            'concepto' => 'Ingreso por venta',
            'id_registro_operacion' => $id_registro_operacion
            );

        $this->movimiento_caja_model->registrar_movimiento_caja($datos_movimiento_caja);

        //Actulizar saldo de caja
        $caja_seleccionada = $this->caja_model->obtener_caja_por_id($id_caja);
        $nuevo_saldo_caja = $caja_seleccionada->saldo + $importe_total;

        $datos_caja = array('saldo' => $nuevo_saldo_caja, 'id_caja' => $id_caja);

        $this->caja_model->actualizar_saldo_caja($datos_caja);

        //Fin transacción
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