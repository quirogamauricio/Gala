<?php
class Sucursales extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('sucursal_model');
    }

    public function index()
    {
        $this->ver();
    }
    
    public function nueva()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['titulo'] = 'Crear nueva sucursal';

        $this->cargar_header_y_principal();

        $this->establecer_reglas(TRUE);

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('sucursales/crear', $data);
        }
        else
        {
            $data = array(
                'sucursal' => $this->input->post('sucursal'),
                'direccion' => !empty($this->input->post('direccion')) ? $this->input->post('direccion') : NULL
                );
            
            $this->sucursal_model->crear_sucursal($data);
            $data['mensaje'] = "¡Sucursal creada correctamente!";
            $this->load->view('sucursales/exito', $data);
        }

        $this->load->view('templates/footer');
    }

    public function ver($id_sucursal = NULL)
    {
        $this->cargar_header_y_principal();

        if ($id_sucursal === NULL)
        {
            $data['titulo'] = 'Sucursales';

            $sucursales = $this->sucursal_model->obtener_sucursales_table();

            $resultado;

            if(!empty($sucursales))
            {
                $this->load->library('table');
                $this->load->helper('url');
                $this->table->set_template(array('table_open' => '<table class="table">'));
                $this->table->set_empty('-');

                foreach ($sucursales as $indice_fila => $fila)
                {
                    $sucursales[$indice_fila]['id_sucursal'] = anchor('sucursales/ver/'.$fila['id_sucursal'],'Ver', 'class="btn btn-info"'); //Permite generar el link para ver el usuario particular
                }

                $this->table->set_heading('Sucursal', 'Dirección');

                $resultado = $this->table->generate($sucursales);
            }
            else
            {
                $resultado = '<h4>No se encontraron resultados</h4>';
            }

            $data['contenido'] = $resultado;
        }
        else
        { 
            $data['titulo'] = 'Información de la sucursal';

            $sucursal = $this->sucursal_model->obtener_sucursal_por_id($id_sucursal);

            if ($sucursal === NULL) 
            {
                $data['contenido'] = '<h4>Error al recuperar información de la sucursal seleccionada</h4>';
            }
            else
            {
                $data['id_sucursal'] = $sucursal->id_sucursal;
                $data['sucursal'] = $sucursal->sucursal;
                $data['sucursal_original'] = $sucursal->sucursal;
                $data['direccion'] = $sucursal->direccion;
            }
        }

        $this->load->view('sucursales/ver', $data);

        $this->load->view('templates/footer');
    }

    public function editar()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $datos = array(
            'id_sucursal' => $this->input->post('id_sucursal'),
            'sucursal' => $this->input->post('sucursal'),
            'direccion' => $this->input->post('direccion')
            );

        $validar_sucursal_unica = TRUE;

        if ($datos['sucursal'] === $this->input->post('sucursal_original'))
        {
             $validar_sucursal_unica = FALSE;
        }

        $this-> establecer_reglas($validar_sucursal_unica);

        if ($this->form_validation->run() === FALSE)
        {
            $this->ver($datos['id_sucursal']);
        }
        else
        {
            if ($this->sucursal_model->editar_sucursal($datos)) 
            {
                $data['mensaje'] = '¡Los datos de la sucursal se actualizaron correctamente!';
            }
            else
            {
                $data['mensaje'] = '¡No se actualizó la información!';
            }
            $this->cargar_header_y_principal();
            $this->load->view('sucursales/exito', $data);
            $this->load->view('templates/footer');
        }
    }

    public function eliminar()
    {
        $this->cargar_header_y_principal();
        $id_sucursal = $this->uri->segment(3);

        if ($id_sucursal === NULL)
        {
             $data['mensaje'] = 'No se especificó una sucursal a eliminar';
        }
        elseif($this->sucursal_model->eliminar_sucursal($id_sucursal) == 1)
        {
            $data['mensaje'] = '¡Sucursal eliminada correctamente!';
        }
        elseif($this->sucursal_model->eliminar_sucursal($id_sucursal) == 1451)
        {
            $data['mensaje'] = '¡No se puede eliminar una sucursal que se encuentra en uso!';
        }
        else
        {
            $data['mensaje'] = '¡Sucursal inexistente!';
        }

        $this->load->view('sucursales/exito', $data);
        $this->load->view('templates/footer');
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

    private function establecer_reglas($validar_sucursal_unica)
    {
        $array_validaciones = array('required');
        $array_mensajes = array('required' => 'La sucursal es requerida');

        if ($validar_sucursal_unica)
        {
            array_push($array_validaciones, 'is_unique[sucursal.sucursal]');
            $array_mensajes['is_unique'] = 'La sucursal ingresada ya existe';
        }

        $this->form_validation->set_rules('sucursal', 'sucursal', $array_validaciones, $array_mensajes);
    }
}