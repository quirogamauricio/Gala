<?php
class Cajas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('caja_model');
        $this->load->model('sucursal_model');
    }

    public function index()
    {
        $this->ver();
    }
    
    public function nueva()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['titulo'] = 'Crear nueva caja';
        $data['sucursales'] = $this->sucursal_model->obtener_sucursales_dropdown();

        $this->cargar_header_y_principal();

        $this->establecer_reglas(TRUE);

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('cajas/crear', $data);
        }
        else
        {
            $data = array(
                'descripcion' => $this->input->post('descripcion'),
                'id_sucursal' => $this->input->post('sucursal'));
            
            $this->caja_model->crear_caja($data);
            $data['mensaje'] = "¡Caja creada correctamente!";
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
                $this->table->set_empty('-');

                foreach ($cajas as $indice_fila => $fila)
                {
                    $cajas[$indice_fila]['id_caja'] = anchor('cajas/ver/'.$fila['id_caja'],'Ver', 'class="btn btn-info"');
                }

                $this->table->set_heading('Sucursal', 'Saldo', 'Descripción');

                $resultado = $this->table->generate($cajas);
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
            $data['sucursales'] = $this->sucursal_model->obtener_sucursales_dropdown();

            $caja = $this->caja_model->obtener_caja_por_id($id_caja);

            if ($caja === NULL) 
            {
                $data['contenido'] = '<h4>Error al recuperar información de la caja seleccionada</h4>';
            }
            else
            {
                $data['id_caja'] = $caja->id_caja;
                $data['id_sucursal'] = $caja->id_sucursal;
                $data['id_sucursal_original'] = $caja->id_sucursal;
                $data['descripcion'] = $caja->descripcion;
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
            'id_sucursal' => $this->input->post('sucursal'),
            'descripcion' => $this->input->post('descripcion')
            );

        $validar_sucursal_unica = TRUE;

        if ($datos['id_sucursal'] === $this->input->post('id_sucursal_original'))
        {
             $validar_sucursal_unica = FALSE;
             
        }

        $this-> establecer_reglas($validar_sucursal_unica);

        if ($this->form_validation->run() === FALSE)
        {
            $this->ver($datos['id_caja']);
        }
        else
        {
            if ($this->caja_model->editar_caja($datos)) 
            {
                $data['mensaje'] = '¡Los datos de la caja se actualizaron correctamente!';
            }
            else
            {
                $data['mensaje'] = '¡No se actualizó la información!';
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
             $data['mensaje'] = 'No se especificó una caja a eliminar';
        }
        elseif($this->caja_model->eliminar_caja($id_caja) == 1)
        {
            $data['mensaje'] = '¡Caja eliminada correctamente!';
        }
        elseif($this->caja_model->eliminar_caja($id_caja) == 1451)
        {
            $data['mensaje'] = '¡No se puede eliminar una caja que se encuentra en uso!';
        }
        else
        {
            $data['mensaje'] = '¡Caja inexistente!';
        }

        $this->load->view('cajas/exito', $data);
        $this->load->view('templates/footer');
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

    private function establecer_reglas($validar_sucursal_unica)
    {
        if ($validar_sucursal_unica)
        {
            $this->form_validation->set_rules('sucursal', 
                                             'Sucursal',
                                             array('is_unique[caja.id_sucursal]'), 
                                             array('is_unique' => 'Ya existe una caja vinculada a la sucursal seleccionada'));
        }

        $this->form_validation->set_rules('descripcion', 'Descripción', array('required'), array('required' => 'La descripción es requerida'));
    }
}