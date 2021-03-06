<?php
class Movimientos_caja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->library('operaciones_enum');
        $this->load->model('movimiento_caja_model');
        $this->load->model('registro_operacion_model');
        $this->load->model('caja_model');
    }

    public function index()
    {
        $this->ver();
    }
    
    public function nuevo()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['titulo'] = 'Registrar movimiento de caja';
        $data['cajas'] = $this->caja_model->obtener_cajas_dropdown();

        $this->cargar_header_y_principal();

        $this->establecer_reglas();

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('movimientos_caja/crear', $data);
        }
        else
        {
            $id_caja_seleccionada = $this->input->post('caja');
            $importe = $this->input->post('importe');
            $caja_seleccionada = $this->caja_model->obtener_caja_por_id($id_caja_seleccionada);
            $saldo_caja = $caja_seleccionada->saldo;
            $id_registro_operacion = $this->registrar_operacion();

            $data = array(
                'importe' =>$importe,
                'id_caja' => $id_caja_seleccionada,
                'concepto' => $this->input->post('concepto'),
                'id_registro_operacion' => $id_registro_operacion
                );

            $this->actualizar_saldo_caja($id_caja_seleccionada, $importe, $saldo_caja);
            
            $this->movimiento_caja_model->registrar_movimiento_caja($data);

            $data['mensaje'] = '<h3 class="alert alert-success"> ¡Movimiento de caja registrado correctamente! </h3>';
            $this->load->view('movimientos_caja/exito', $data);
        }

        $this->load->view('templates/footer');
    }

    public function ver($id_caja = NULL)
    {
        $this->cargar_header_y_principal();

        if ($id_caja === NULL)
        {
            $data['titulo'] = 'Movimientos de cajas';

            $movimientos = $this->movimiento_caja_model->obtener_movimientos_table();

            $resultado;

            if(!empty($movimientos))
            {
                $this->load->helper('date');
                $this->load->library('table');
                $this->table->set_template(array('table_open' => '<table class="table">'));
                $this->table->set_heading('Caja','Importe', 'Concepto', 'Fecha', 'Descripción', 'Usuario');

                foreach ($movimientos as $indice => $fila) 
                {
                    $movimientos[$indice]['fecha'] = transform_date($fila['fecha']);
                }

                $resultado = '<div class="table-responsive">' . $this->table->generate($movimientos) . '</div>';
            }
            else
            {
                $resultado = '<h4>No se encontraron resultados</h4>';
            }

            $data['contenido'] = $resultado;
        }
        else
        { 
            $caja = $this->caja_model->obtener_caja_por_id($id_caja);

            $movimientos = $this->movimiento_caja_model->obtener_movimientos_por_caja_table($id_caja);

            $data['titulo'] = 'Movimientos de ' . ($caja != NULL ? $caja->descripcion : 'caja');

            if (empty($movimientos) || $movimientos === NULL) 
            {
                $data['contenido'] = '<h4>No se encontraron movimientos para la caja seleccionada</h4>';
            }
            else
            {
                $this->load->helper('date');
                $this->load->library('table');
                $this->table->set_template(array('table_open' => '<table class="table">'));
                $this->table->set_heading('Importe', 'Concepto', 'Fecha', 'Descripción', 'Usuario');

                foreach ($movimientos as $indice => $fila) 
                {
                    $movimientos[$indice]['fecha'] = transform_date($fila['fecha']);
                }

                $data['contenido'] = '<div class="table-responsive">' . $this->table->generate($movimientos) . '</div>';
            }
        }

        $this->load->view('movimientos_caja/ver', $data);

        $this->load->view('templates/footer');
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

    private function establecer_reglas()
    {
        $this->form_validation->set_rules('importe', 
                                          'Importe', 
                                           array('required', 'decimal', 'callback_validar_diferencia_saldo'),
                                           array('required' => 'El importe es requerido',
                                                 'decimal' => 'El importe debe ser un valor decimal',
                                                 'validar_diferencia_saldo' => 'El saldo de la caja no puede ser menor a cero'));

        $this->form_validation->set_rules('concepto', 'Concepto', array('required'), array('required' => 'El concepto es requerido'));
    }

    public function validar_diferencia_saldo()
    {
        $id_caja_seleccionada = $this->input->post('caja');
        $importe = $this->input->post('importe');
        $caja_seleccionada = $this->caja_model->obtener_caja_por_id($id_caja_seleccionada);
        $saldo_caja = $caja_seleccionada->saldo;

        if ($importe<0 && ($saldo_caja+$importe) < 0 ) 
        {
            return FALSE;
        }

        return TRUE;
    }

    private function actualizar_saldo_caja($id_caja_seleccionada, $importe, $saldo)
    {
        $saldo = $saldo + $importe;

        $datos_actualizacion = array('id_caja' => $id_caja_seleccionada, 'saldo' => $saldo);

        $this->caja_model->actualizar_saldo_caja($datos_actualizacion);
    }

    private function registrar_operacion()
    {
        $descripcion = $this->input->post('importe') < 0 ? operaciones_enum::egreso_caja : operaciones_enum::ingreso_caja;

        $datos_operacion = array('descripcion' => $descripcion,
                                 'id_usuario' => $_SESSION['usuario_id'],
                                 'fecha' => date('Y-m-d H:i:s'));

        return $this->registro_operacion_model->registrar_operacion($datos_operacion);
    }
}