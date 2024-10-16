<?php
class Opcion_sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('opcion_sistema_model');
        $this->load->model('acceso_sistema_usuario_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'opcion_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['opciones_sistema'] = $this->opcion_sistema_model->get_opciones_sistema();

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/opcion_sistema/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_opcion_sistema)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'opcion_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['opcion_sistema'] = $this->opcion_sistema_model->get_opcion_sistema($id_opcion_sistema);
                $data['roles_acceso'] = $this->acceso_sistema_model->get_roles_acceso($id_opcion_sistema);
                $data['usuarios_acceso'] = $this->acceso_sistema_usuario_model->get_usuarios_acceso($id_opcion_sistema);

                $this->load->view('templates/admheader', $data);
                $this->load->view('catalogos/opcion_sistema/detalle', $data);
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

            // guardado
            $data = array(
                'codigo' => null,
            );
            $permisos_requeridos = array(
                'opcion_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $id_opcion_sistema = $this->opcion_sistema_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'opcion_sistema';
                $valor = $id_opcion_sistema;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                $this->detalle($id_opcion_sistema);

            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_opcion_sistema=null)
    {
        if ($this->session->userdata('logueado')) {

            $opcion_sistema = $this->input->post();
            if ($opcion_sistema) {

                if ($id_opcion_sistema) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'codigo' => $opcion_sistema['codigo'],
                    'nombre' => $opcion_sistema['nombre'],
                    'otorgable' => $opcion_sistema['otorgable'],
                );
                $id_opcion_sistema = $this->opcion_sistema_model->guardar($data, $id_opcion_sistema);

                // registro en bitacora
                $entidad = 'opcion_sistema';
                $valor = $id_opcion_sistema ." ". $opcion_sistema['codigo'] . " " . $opcion_sistema['nombre'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect(base_url() . 'opcion_sistema');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_opcion_sistema)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $opcion = $this->opcion_sistema_model->get_opcion_sistema($id_opcion_sistema);
            $accion = 'eliminó';
            $entidad = 'opcion_sistema';
            $valor = $id_opcion_sistema ." ". $opcion['codigo'] . " " . $opcion['nombre'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->opcion_sistema_model->eliminar($id_opcion_sistema);
            redirect(base_url() . 'opcion_sistema');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
