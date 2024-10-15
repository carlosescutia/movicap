<?php
class Opcion_publica extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('opcion_publica_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $data['opciones_publicas'] = $this->opcion_publica_model->get_opciones_publicas();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/opcion_publica/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_opcion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $data['opcion_publica'] = $this->opcion_publica_model->get_opcion_publica($id_opcion);

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/opcion_publica/detalle', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/opcion_publica/nuevo', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_opcion=null)
    {
        if ($this->session->userdata('logueado')) {

            $opcion_publica = $this->input->post();
            if ($opcion_publica) {

                if ($id_opcion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'orden' => $opcion_publica['orden'],
                    'nombre' => $opcion_publica['nombre'],
                    'url' => $opcion_publica['url'],
                );
                $id_opcion = $this->opcion_publica_model->guardar($data, $id_opcion);

                // registro en bitacora
                $entidad = 'opcion_publica';
                $valor = $id_opcion ." ". $opcion_publica['orden'] . " " . $opcion_publica['nombre'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect(base_url() . 'opcion_publica');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_opcion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $opcion = $this->opcion_publica_model->get_opcion_publica($id_opcion);
            $accion = 'eliminó';
            $entidad = 'opcion_publica';
            $valor = $id_opcion ." ". $opcion['orden'] . " " . $opcion['nombre'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->opcion_publica_model->eliminar($id_opcion);
            redirect(base_url() . 'opcion_publica');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
