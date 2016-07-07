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

    public function obtener_ventas()
    {
        $query = "SELECT v.importe_total, CONCAT_WS(', ', cli.apellido, cli.nombre ), p.codigo, p.talle, p.numero, dv.cantidad, ro.fecha, u.email, ca.descripcion as caja, fp.descripcion
                FROM venta v
                INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
                INNER JOIN forma_pago fp ON fp.id_forma_pago = dv.id_forma_pago
                INNER JOIN producto p on dv.id_producto = p.id_producto
                INNER JOIN cliente cli ON v.id_cliente  = cli.id_cliente
                INNER JOIN caja ca ON v.id_caja = ca.id_caja
                INNER JOIN registro_operacion ro ON ro.id_registro_operacion = v.id_registro_operacion
                INNER JOIN usuario u ON ro.id_usuario = u.id_usuario
                ORDER BY ro.fecha DESC";

        return $this->db->query($query)->result_array();
    }

    public function obtener_productos_mas_vendidos()
    {
        $query = "SELECT CONCAT_WS(' - ', p.codigo, p.talle, p.numero) as producto, SUM(dv.cantidad) as cantidad_vendida
                 FROM producto p 
                 INNER JOIN detalle_venta dv on dv.id_producto = p.id_producto
                 GROUP BY p.id_producto
                 ORDER BY cantidad_vendida DESC
                 LIMIT 3
                ";

        return $this->db->query($query)->result_array();
    }

    public function obtener_ventas_por_periodo()
    {
        $query = "SELECT  COUNT(*) as cant_ventas, MONTH(ro.fecha) as mes
                 FROM venta v
                 INNER JOIN registro_operacion ro on v.id_registro_operacion = ro.id_registro_operacion
                 INNER JOIN detalle_venta dv on v.id_venta = dv.id_venta
                 GROUP BY mes";

        return $this->db->query($query)->result_array();
    }

    public function obtener_ventas_por_cliente()
    {
        $query = "SELECT COUNT(c.id_cliente) as cant_ventas, CONCAT_WS(', ', c.apellido, c.nombre ) as cliente
                FROM venta v
                INNER JOIN cliente c ON v.id_cliente = c.id_cliente
                GROUP BY cliente";

        return $this->db->query($query)->result_array();
    }

    public function registrar_venta($venta)
    {
        $detalles_venta = $venta['detalles_venta'];

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