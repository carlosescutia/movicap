<?php
class Pregunta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('pregunta_model');
        $this->load->model('tipo_pregunta_model');
        $this->load->model('valor_posible_model');
    }

    public function detalle($id_pregunta)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $data['pregunta'] = $this->pregunta_model->get_pregunta($id_pregunta);
            $id_seccion = $data['pregunta']['id_seccion'];
            $data['tipos_pregunta'] = $this->tipo_pregunta_model->get_tipos_pregunta();
            $data['valores_posibles'] = $this->valor_posible_model->get_valores_posibles_pregunta($id_pregunta);

            $permisos_requeridos = array(
                'pregunta.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('cuestionario/pregunta_detalle', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'seccion/detalle/' . $id_seccion);
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
                'pregunta.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                // guardado
                $pregunta = $this->input->post();
                if ($pregunta) {
                    $data = array(
                        'id_seccion' => $pregunta['id_seccion'],
                        'nom_pregunta' => 'nueva_pregunta',
                        'texto' => 'Nueva pregunta',
                    );
                    $id_pregunta = $this->pregunta_model->guardar($data, null);

                    // registro en bitacora
                    $accion = 'agregó';
                    $entidad = 'pregunta';
                    $valor = $id_pregunta;
                    $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                    $this->detalle($id_pregunta);
                }
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_pregunta=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_pregunta = is_null($id_pregunta);

            $pregunta = $this->input->post();
            $id_cuestionario = $pregunta['id_cuestionario'];
            if ($pregunta) {

                if ($id_pregunta) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'id_seccion' => $pregunta['id_seccion'],
                    'cve_tipo_pregunta' => $pregunta['cve_tipo_pregunta'],
                    'nom_pregunta' => $pregunta['nom_pregunta'],
                    'texto' => $pregunta['texto'],
                    'expresion' => $pregunta['expresion'],
                    'orden' => empty($pregunta['orden']) ? null : $pregunta['orden'],
                );
                $id_pregunta = $this->pregunta_model->guardar($data, $id_pregunta);

                // registro en bitacora
                $entidad = 'pregunta';
                $valor = $id_pregunta . " " . $pregunta['texto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'seccion/detalle/' . $pregunta['id_seccion']);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_pregunta)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $pregunta = $this->pregunta_model->get_pregunta($id_pregunta);
            $id_seccion = $pregunta['id_seccion'];
            $accion = 'eliminó';
            $entidad = 'pregunta';
            $valor = $id_pregunta . " " . $pregunta['texto'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->pregunta_model->eliminar($id_pregunta);

            redirect(base_url() . 'seccion/detalle/' . $id_seccion);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
