<?php
class Parametro_sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('parametro_sistema_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'parametro_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['parametros_sistema'] = $this->parametro_sistema_model->get_parametros_sistema();

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/parametro_sistema/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_parametro_sistema)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'parametro_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['parametro_sistema'] = $this->parametro_sistema_model->get_parametro_sistema_id($id_parametro_sistema);

                $this->load->view('templates/admheader', $data);
                $this->load->view('catalogos/parametro_sistema/detalle', $data);
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
                'parametro_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                // guardado
                $data = array(
                    'nom_parametro_sistema' => null,
                );
                $id_parametro_sistema = $this->parametro_sistema_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'parametro_sistema';
                $valor = $id_parametro_sistema;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                $this->detalle($id_parametro_sistema);

            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_parametro_sistema=null)
    {
        if ($this->session->userdata('logueado')) {

            $parametro_sistema = $this->input->post();
            if ($parametro_sistema) {

                if ($id_parametro_sistema) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_parametro_sistema' => $parametro_sistema['nom_parametro_sistema'],
                    'valor' => $parametro_sistema['valor'],
                );
                $id_parametro_sistema = $this->parametro_sistema_model->guardar($data, $id_parametro_sistema);

                // registro en bitacora
                $entidad = 'parametro_sistema';
                $valor = $id_parametro_sistema . " " . $parametro_sistema['nom_parametro_sistema'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'parametro_sistema');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_parametro_sistema)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $parametro_sistema = $this->parametro_sistema_model->get_parametro_sistema_id($id_parametro_sistema);
            $accion = 'eliminó';
            $entidad = 'parametro_sistema';
            $valor = $id_parametro_sistema . " " . $parametro_sistema['nom_parametro_sistema'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->parametro_sistema_model->eliminar($id_parametro_sistema);

            redirect(base_url() . 'parametro_sistema');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
