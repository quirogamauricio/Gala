<?php
class Cajas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('caja_model');
    }

    public function index()
    {
        $this->ver();
    }
    
    public function nueva()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['titulo'] = 'Crear nueva caja';

        $this->cargar_header_y_principal();

        $this->establecer_reglas(TRUE);

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('cajas/crear', $data);
        }
        else
        {
            $data = array('descripcion' => $this->input->post('descripcion'));
            
            $this->caja_model->crear_caja($data);
            $data['mensaje'] = '<h3 class="alert alert-success"> ¡Caja creada correctamente! </h3>';
            $this->load->view('cajas/exito', $data);
        }

        $this->load->view('templates/footer');
    }

    public function ver($id_caja = NULL)
    {
        $this->cargar_header_y_principal();

        if ($id_caja === NULL)
        {
            $data['titulo'] = 'Cajas';

            $cajas = $this->caja_model->obtener_cajas_table();

            $resultado;

            if(!empty($cajas))
            {
                $this->load->library('table');
                $this->load->helper('url');
                $this->table->set_template(array('table_open' => '<table class="table">'));
                $this->table->set_heading('Saldo', 'Descripción', '', '');
                $this->table->set_empty('-');

                foreach ($cajas as $indice_fila => $fila)
                {
                    $cajas[$indice_fila]['id_caja'] = anchor('cajas/ver/'.$fila['id_caja'],'Ver', 'class="btn btn-info"');
                    array_push($cajas[$indice_fila], anchor('movimientos_caja/ver/'.$fila['id_caja'],'Movimientos', 'class="btn btn-info"'));
                }

                $resultado = '<div class="table-responsive">' . $this->table->generate($cajas) . '</div>';
            }
            else
            {
                $resultado = '<h4>No se encontraron resultados</h4>';
            }

            $data['contenido'] = $resultado;
        }
        else
        { 
            $data['titulo'] = 'Información de la caja';

            $caja = $this->caja_model->obtener_caja_por_id($id_caja);

            if ($caja === NULL) 
            {
                $data['contenido'] = '<h4>Error al recuperar información de la caja seleccionada</h4>';
            }
            else
            {
                $data['id_caja'] = $caja->id_caja;
                $data['descripcion'] = $caja->descripcion;
                $data['descripcion_original'] = $caja->descripcion;
                $data['saldo'] = $caja->saldo;
            }
        }

        $this->load->view('cajas/ver', $data);

        $this->load->view('templates/footer');
    }

    public function editar()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $datos = array(
            'id_caja' => $this->input->post('id_caja'),
            'descripcion' => $this->input->post('descripcion')
            );

        $validar_descripcion_unica = TRUE;

        if ($datos['descripcion'] === $this->input->post('descripcion_original'))
        {
             $validar_descripcion_unica = FALSE;
        }

        $this-> establecer_reglas($validar_descripcion_unica);

        if ($this->form_validation->run() === FALSE)
        {
            $this->ver($datos['id_caja']);
        }
        else
        {
            if ($this->caja_model->editar_caja($datos)) 
            {
                $data['mensaje'] = '<h3 class="alert alert-success"> ¡Los datos de la caja se actualizaron correctamente! </h3>';
            }
            else
            {
                $data['mensaje'] = '<h3 class="alert alert-danger"> ¡No se actualizó la información! </h3>';
            }
            $this->cargar_header_y_principal();
            $this->load->view('cajas/exito', $data);
            $this->load->view('templates/footer');
        }
    }

    public function eliminar()
    {
        $this->cargar_header_y_principal();
        $id_caja = $this->uri->segment(3);

        if ($id_caja === NULL)
        {
             $data['mensaje'] = '<h3 class="alert alert-warning"> No se especificó una caja a eliminar </h3>';
        }
        elseif($this->caja_model->eliminar_caja($id_caja) == 1)
        {
            $data['mensaje'] = '<h3 class="alert alert-success"> ¡Caja eliminada correctamente! </h3>';
        }
        elseif($this->caja_model->eliminar_caja($id_caja) == 1451)
        {
            $data['mensaje'] = '<h3 class="alert alert-warning"> ¡No se puede eliminar una caja que se encuentra en uso! </h3>';
        }
        else
        {
            $data['mensaje'] = '<h3 class="alert alert-warning"> ¡Caja inexistente! </h3>';
        }

        $this->load->view('cajas/exito', $data);
        $this->load->view('templates/footer');
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

    private function establecer_reglas($validar_descripcion_unica)
    {
        $array_validaciones = array('required');
        $array_mensajes = array('required' => 'La descripción es requerida');

        if ($validar_descripcion_unica)
        {
            array_push($array_validaciones, 'is_unique[caja.descripcion]');
            $array_mensajes['is_unique'] = 'Ya existe una caja con la descripción ingresada';
        }

        $this->form_validation->set_rules('descripcion', 'Descripción', $array_validaciones, $array_mensajes);
    }
}