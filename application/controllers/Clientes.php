<?php
class Clientes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->session->user_is_authenticated();
        $this->load->library('form_validation');
        $this->load->model('cliente_model');
    }

    public function index()
    {
        $this->ver();
    }

    public function nuevo()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

        $data['titulo'] = 'Crear nuevo cliente';

        $this->establecer_reglas();

        $this->cargar_header_y_principal();

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('clientes/crear', $data);
        }
        else
        {
            $datos = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'telefono' => empty($this->input->post('telefono')) ? NULL : $this->input->post('telefono'),
                'fecha_alta'=> date('Y-m-d H:i:s')
                );

            $this->cliente_model->crear_cliente($datos);
            $data['mensaje'] = "¡Cliente creado correctamente!";
            $this->load->view('clientes/exito', $data);
        }

        $this->load->view('templates/footer');
    }

    public function ver($id_cliente = NULL)
    {
        $this->cargar_header_y_principal();

        if ($id_cliente === NULL) 
        {
            $data['titulo'] = 'Clientes';

            $clientes = $this->cliente_model->obtener_clientes();

            $resultado;

            if(!empty($clientes))
            {

                $this->load->library('table');
                    $this->load->helper('url'); // Cargo helper para usar función anchor
                    $this->load->helper('date');
                    $this->table->set_heading('Nombre', 'Apellido', 'Teléfono', 'Fecha de alta');
                    $this->table->set_template(array('table_open' => '<table class="table">'));
                    $this->table->set_empty('-');

                    foreach ($clientes as $indice_fila => $fila)
                    {
                        $clientes[$indice_fila]['id'] = anchor('clientes/ver/'.$fila['id'],'Ver', 'class="btn btn-info"'); //Permite generar el link para ver el cliente particular
                        $clientes[$indice_fila]['fecha_alta'] = transform_date($fila['fecha_alta'], '/');
                    }

                    $resultado = $this->table->generate($clientes);
                }
                else
                {
                    $resultado = '<h4>No se encontraron resultados</h4>';
                }

                $data['contenido'] = $resultado;
            }
            else
            {
                $data['titulo'] = 'Información del cliente';

                $cliente = $this->cliente_model->obtener_cliente_por_id($id_cliente);

                if ($cliente === NULL) 
                {
                    $data['contenido'] = '<h4>Error al recuperar información del cliente seleccionado</h4>';
                }
                else
                {
                    $data['id_cliente'] = $cliente->id_cliente;
                    $data['nombre'] = $cliente->nombre;
                    $data['apellido'] = $cliente->apellido;
                    $data['telefono'] = $cliente->telefono;
                }
            }
            $this->load->view('clientes/ver', $data);
            $this->load->view('templates/footer');
        }

        public function editar()
        {
            $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');

            $datos = array(
                'id_cliente' => $this->input->post('id_cliente'),
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'telefono' => empty($this->input->post('telefono')) ? NULL : $this->input->post('telefono'));

             $this-> establecer_reglas();

           if ($this->form_validation->run() === FALSE)
           {
                $this->ver($datos['id_cliente']);
           }
           else
           {
                if ($this->cliente_model->editar_cliente($datos)) 
                {
                    $data['mensaje'] = '¡Los datos del cliente se actualizaron correctamente!';
                }
                else
                {
                    $data['mensaje'] = '¡No se actualizó la información!';
                }   
                $this->cargar_header_y_principal();
                $this->load->view('clientes/exito', $data);
                $this->load->view('templates/footer');
            }
    }

    public function eliminar()
    {
        $this->cargar_header_y_principal();
        $id_cliente = $this->uri->segment(3);

        if ($id_cliente === NULL)
        {
           $data['mensaje'] = 'No se especificó un cliente a eliminar';
        }
        elseif($this->cliente_model->eliminar_cliente($id_cliente) == 1)
        {
           $data['mensaje'] = '¡cliente eliminado correctamente!';
        }
        elseif($this->cliente_model->eliminar_cliente($id_cliente) == 1451)
        {
          $data['mensaje'] = '¡No se puede eliminar un producto que se encuentra en uso!';
        }
        else
        {
          $data['mensaje'] = '¡Cliente inexistente!';
        }

      $this->load->view('clientes/exito', $data);
      $this->load->view('templates/footer');
    }

    private function establecer_reglas()
    {
        $this->form_validation->set_rules(
            'nombre',
            'Nombre', 
            array('required'),
            array('required' => 'El nombre es requerido')); 

        $this->form_validation->set_rules(
            'apellido',
            'Apellido', 
            array('required'),
            array('required' => 'El apellido es requerido')); 
    }

    private function cargar_header_y_principal()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/principal');
    }

}