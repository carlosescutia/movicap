<?php
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('acceso_sistema_model');
        $this->load->model('opcion_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametro_sistema_model');
    }

    public function get_userdata()
    {
        $id_rol = $this->session->userdata('id_rol');
        $data['id_usuario'] = $this->session->userdata('id_usuario');
        $data['id_organizacion'] = $this->session->userdata('id_organizacion');
        $data['nom_organizacion'] = $this->session->userdata('nom_organizacion');
        $data['id_rol'] = $id_rol;
        $data['nom_usuario'] = $this->session->userdata('nom_usuario');
        $data['error'] = $this->session->flashdata('error');
        $data['accesos_sistema'] = explode(',', $this->acceso_sistema_model->get_accesos_sistema_rol($id_rol)['accesos']);
        $data['opciones_sistema'] = $this->opcion_sistema_model->get_opciones_sistema();
        return $data;
    }

    public function get_system_params()
    {
        $data['nom_sitio_corto'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('nom_sitio_corto');
        $data['nom_sitio_largo'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('nom_sitio_largo');
        $data['nom_org_sitio'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('nom_org_sitio');
        $data['anio_org_sitio'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('anio_org_sitio');
        $data['tel_org_sitio'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('tel_org_sitio');
        $data['correo_org_sitio'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('correo_org_sitio');
        $data['logo_org_sitio'] = $this->parametro_sistema_model->get_parametro_sistema_nombre('logo_org_sitio');
        return $data;
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $data += $this->get_system_params();

            $this->load->view('templates/admheader', $data);
            $this->load->view('admin/inicio', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->login();
        }
    }

    public function login() {
        $data = array();
        $data['error'] = $this->session->flashdata('error');
        $data += $this->get_system_params();

        $this->load->view('admin/login', $data);
    }

    public function cerrar_sesion() {
        $usuario_data = array(
            'logueado' => FALSE
        );
        $usuario = $this->session->userdata('usuario');
        $nom_usuario = $this->session->userdata('nom_usuario');
        $id_organizacion = $this->session->userdata('id_organizacion');
        $nom_organizacion = $this->session->userdata('nom_organizacion');
        $data = array(
            'fecha' => date("Y-m-d"),
            'hora' => date("H:i"),
            'origen' => $_SERVER['REMOTE_ADDR'],
            'usuario' => $usuario,
            'nom_usuario' => $nom_usuario,
            'nom_organizacion' => $nom_organizacion,
            'accion' => 'logout',
            'entidad' => '',
            'valor' => ''
        );
        $this->bitacora_model->guardar($data);
        $this->session->set_userdata($usuario_data);
        redirect('admin/login');
    }

    public function post_login() {
        if ($this->input->post()) {
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('password');
            $usuario_db = $this->usuario_model->usuario_por_nombre($usuario, $password);
            if ($usuario_db) {
                $usuario_data = array(
                    'id_usuario' => $usuario_db->id_usuario,
                    'id_organizacion' => $usuario_db->id_organizacion,
                    'nom_organizacion' => $usuario_db->nom_organizacion,
                    'id_rol' => $usuario_db->id_rol,
                    'nom_usuario' => $usuario_db->nom_usuario,
                    'usuario' => $usuario_db->usuario,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);
                $data = array(
                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i"),
                    'origen' => $_SERVER['REMOTE_ADDR'],
                    'usuario' => $usuario_db->usuario,
                    'nom_usuario' => $usuario_db->nom_usuario,
                    'nom_organizacion' => $usuario_db->nom_organizacion,
                    'accion' => 'login',
                    'entidad' => '',
                    'valor' => ''
                );
                $this->bitacora_model->guardar($data);
                redirect('admin');
            } else {
                $this->session->set_flashdata('error', 'Usuario o contraseña incorrectos');
                redirect('admin/login');
            }
        } else {
            $this->login();
        }
    }
}

