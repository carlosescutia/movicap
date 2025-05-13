<?php
class Proyecto extends CI_Controller {

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
                $data['cuestionario'] = $this->cuestionario_model->get_cuestionario($data['proyecto_activo']);
                $data['capturas'] = $this->captura_model->get_capturas_cuestionario($data['proyecto_activo'], $data['id_usuario'], $data['id_rol']);
                $data['num_registros_importados'] = $this->session->flashdata('num_registros_importados');

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('proyecto/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function set_proyecto_activo() {
        if ($this->input->post()){
            $proyecto_activo = $this->input->post()['proyecto_activo'];
            $this->session->set_userdata('proyecto_activo', $proyecto_activo);
            redirect(base_url() . 'proyecto');
        }
    }

}
