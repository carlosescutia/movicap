<?php
class Rol extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('rol_model');
        $this->load->model('acceso_sistema_model');
        $this->load->model('opcion_sistema_model');
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

            if ($data['id_rol'] != 'adm') {
                redirect('admin');
            }

            $data['roles'] = $this->rol_model->get_roles();

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/rol/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

}
