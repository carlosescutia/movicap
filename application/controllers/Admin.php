<?php
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('usuario_model');
        $this->load->model('cuestionario_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            redirect(base_url() . 'cuestionario');
        } else {
            $this->login();
        }
    }

    public function login() {
        $data = array();
        $data['error'] = $this->session->flashdata('error');
        $data += $this->funciones_sistema->get_system_params();

        $this->load->view('admin/login', $data);
    }

    public function cerrar_sesion() {
        $usuario_data = array(
            'logueado' => FALSE
        );

        $accion = 'logout';
        $entidad = '';
        $valor = '';
        $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

        $this->session->set_userdata($usuario_data);
        redirect(base_url() . 'admin');
    }

    public function post_login() {
        if ($this->input->post()) {
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('password');
            $usuario_db = $this->usuario_model->usuario_por_nombre($usuario, $password);
            if ($usuario_db) {
                $cuestionarios = $this->cuestionario_model->get_cuestionarios_usuario($usuario_db['id_usuario'], $usuario_db['id_rol']);
                $cuestionario_activo = $cuestionarios[0]['id_cuestionario'];
                $usuario_data = array(
                    'id_usuario' => $usuario_db['id_usuario'],
                    'id_organizacion' => $usuario_db['id_organizacion'],
                    'nom_organizacion' => $usuario_db['nom_organizacion'],
                    'id_rol' => $usuario_db['id_rol'],
                    'nom_usuario' => $usuario_db['nom_usuario'],
                    'usuario' => $usuario_db['usuario'],
                    'cuestionario_activo' => $cuestionario_activo,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);

                $accion = 'login';
                $entidad = '';
                $valor = '';
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                redirect(base_url() . 'admin');
            } else {
                $this->session->set_flashdata('error', 'Usuario o contraseña incorrectos');
                redirect(base_url() . 'admin/login');
            }
        } else {
            $this->login();
        }
    }
}
