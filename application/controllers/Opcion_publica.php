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

            $permisos_requeridos = array(
                'opcion_publica.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['opciones_publicas'] = $this->opcion_publica_model->get_opciones_publicas();

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/opcion_publica/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_opcion_publica)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'opcion_publica.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['opcion_publica'] = $this->opcion_publica_model->get_opcion_publica($id_opcion_publica);

                $this->load->view('templates/admheader', $data);
                $this->load->view('catalogos/opcion_publica/detalle', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();

            $permisos_requeridos = array(
                'opcion_publica.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                // guardado
                $data = array(
                    'orden' => null,
                );
                $id_opcion_publica = $this->opcion_publica_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'opcion_publica';
                $valor = $id_opcion_publica;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                $this->detalle($id_opcion_publica);

            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_opcion_publica=null)
    {
        if ($this->session->userdata('logueado')) {

            $opcion_publica = $this->input->post();
            if ($opcion_publica) {

                if ($id_opcion_publica) {
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
                $id_opcion_publica = $this->opcion_publica_model->guardar($data, $id_opcion_publica);

                // registro en bitacora
                $entidad = 'opcion_publica';
                $valor = $id_opcion_publica ." ". $opcion_publica['orden'] . " " . $opcion_publica['nombre'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect(base_url() . 'opcion_publica');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_opcion_publica)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $opcion = $this->opcion_publica_model->get_opcion_publica($id_opcion_publica);
            $accion = 'eliminó';
            $entidad = 'opcion_publica';
            $valor = $id_opcion_publica ." ". $opcion['orden'] . " " . $opcion['nombre'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->opcion_publica_model->eliminar($id_opcion_publica);
            redirect(base_url() . 'opcion_publica');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
