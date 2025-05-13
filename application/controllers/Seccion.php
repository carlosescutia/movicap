<?php
class Seccion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('seccion_model');
        $this->load->model('pregunta_model');
    }

    public function detalle($id_seccion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $data['seccion'] = $this->seccion_model->get_seccion($id_seccion);
            $id_cuestionario = $data['seccion']['id_cuestionario'];
            $data['preguntas'] = $this->pregunta_model->get_preguntas_seccion($id_seccion);

            $permisos_requeridos = array(
                'seccion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/cuestionario/seccion_detalle', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'cuestionario/detalle/' . $id_cuestionario);
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
                'seccion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                // guardado
                $seccion = $this->input->post();
                if ($seccion) {
                    $data = array(
                        'id_cuestionario' => $seccion['id_cuestionario'],
                        'nom_seccion' => 'Nueva sección',
                    );
                    $id_seccion = $this->seccion_model->guardar($data, null);

                    // registro en bitacora
                    $accion = 'agregó';
                    $entidad = 'seccion';
                    $valor = $id_seccion;
                    $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                    $this->detalle($id_seccion);
                }
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_seccion=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_seccion = is_null($id_seccion);

            $seccion = $this->input->post();
            $id_cuestionario = $seccion['id_cuestionario'];
            if ($seccion) {

                if ($id_seccion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_seccion' => $seccion['nom_seccion'],
                    'orden' => empty($seccion['orden']) ? null : $seccion['orden'],
                );
                $id_seccion = $this->seccion_model->guardar($data, $id_seccion);

                // registro en bitacora
                $entidad = 'seccion';
                $valor = $id_seccion . " " . $seccion['nom_seccion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'seccion/detalle/' . $id_seccion);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_seccion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $seccion = $this->seccion_model->get_seccion($id_seccion);
            $id_cuestionario = $seccion['id_cuestionario'];
            $accion = 'eliminó';
            $entidad = 'seccion';
            $valor = $id_seccion . " " . $seccion['nom_seccion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->seccion_model->eliminar($id_seccion);

            redirect(base_url() . 'cuestionario/detalle/' . $id_cuestionario);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}


