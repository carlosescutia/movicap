<?php
class Tipo_pregunta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('tipo_pregunta_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'tipo_pregunta.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['tipos_pregunta'] = $this->tipo_pregunta_model->get_tipos_pregunta();

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/tipo_pregunta/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_tipo_pregunta)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'tipo_pregunta.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['tipo_pregunta'] = $this->tipo_pregunta_model->get_tipo_pregunta_id($id_tipo_pregunta);

                $this->load->view('templates/admheader', $data);
                $this->load->view('catalogos/tipo_pregunta/detalle', $data);
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
                'tipo_pregunta.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                // guardado
                $data = array(
                    'nom_tipo_pregunta' => null,
                );
                $id_tipo_pregunta = $this->tipo_pregunta_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'tipo_pregunta';
                $valor = $id_tipo_pregunta;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                $this->detalle($id_tipo_pregunta);

            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_tipo_pregunta=null)
    {
        if ($this->session->userdata('logueado')) {

            $tipo_pregunta = $this->input->post();
            if ($tipo_pregunta) {

                if ($id_tipo_pregunta) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_tipo_pregunta' => $tipo_pregunta['nom_tipo_pregunta'],
                    'orden' => $tipo_pregunta['orden'],
                );
                $id_tipo_pregunta = $this->tipo_pregunta_model->guardar($data, $id_tipo_pregunta);

                // registro en bitacora
                $entidad = 'tipo_pregunta';
                $valor = $id_tipo_pregunta . " " . $tipo_pregunta['nom_tipo_pregunta'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'tipo_pregunta');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_tipo_pregunta)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $tipo_pregunta = $this->tipo_pregunta_model->get_tipo_pregunta_id($id_tipo_pregunta);
            $accion = 'eliminó';
            $entidad = 'tipo_pregunta';
            $valor = $id_tipo_pregunta . " " . $tipo_pregunta['nom_tipo_pregunta'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->tipo_pregunta_model->eliminar($id_tipo_pregunta);

            redirect(base_url() . 'tipo_pregunta');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
