<?php
class Cuestionario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('cuestionario_model');
        $this->load->model('captura_model');
        $this->load->model('seccion_model');
        $this->load->model('cuestionario_usuario_model');
        $this->load->model('usuario_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'cuestionario.can_view',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['cuestionarios'] = $this->cuestionario_model->get_cuestionarios_usuario($data['id_usuario'], $data['id_rol']);
                $data['capturas'] = $this->captura_model->get_capturas_usuario($data['id_usuario'], $data['id_rol']);

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('cuestionario/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_cuestionario)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'cuestionario.can_view',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['cuestionario'] = $this->cuestionario_model->get_cuestionario($id_cuestionario);
                $data['secciones'] = $this->seccion_model->get_secciones_cuestionario($id_cuestionario);
                $data['cuestionario_usuarios'] = $this->cuestionario_usuario_model->get_usuarios_cuestionario($id_cuestionario);
                $id_rol = 'usr';
                $data['usuarios'] = $this->usuario_model->get_usuarios_rol($id_rol);

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('cuestionario/detalle', $data);
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
                'cuestionario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $capturista = $data['id_usuario'];
                // guardado
                $data = array(
                    'id_usuario' => $capturista,
                    'nom_cuestionario' => 'Nuevo cuestionario',
                );
                $id_cuestionario = $this->cuestionario_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'cuestionario';
                $valor = $id_cuestionario;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                $this->detalle($id_cuestionario);
            } else {
                redirect(base_url() . 'cuestionario');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_cuestionario=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_cuestionario = is_null($id_cuestionario);

            $cuestionario = $this->input->post();
            if ($cuestionario) {

                if ($id_cuestionario) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_cuestionario' => $cuestionario['nom_cuestionario'],
                    'fecha' => empty($cuestionario['fecha']) ? null : $cuestionario['fecha'],
                    'lugar' => $cuestionario['lugar'],
                );
                $id_cuestionario = $this->cuestionario_model->guardar($data, $id_cuestionario);

                // registro en bitacora
                $entidad = 'cuestionario';
                $valor = $id_cuestionario . " " . $cuestionario['nom_cuestionario'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'cuestionario');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_cuestionario)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $cuestionario = $this->cuestionario_model->get_cuestionario($id_cuestionario);
            $accion = 'eliminó';
            $entidad = 'cuestionario';
            $valor = $id_cuestionario . " " . $cuestionario['nom_cuestionario'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->cuestionario_model->eliminar($id_cuestionario);

            redirect(base_url() . 'cuestionario');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}

