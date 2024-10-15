<?php
class Rol extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('rol_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $data['roles'] = $this->rol_model->get_roles();

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/rol/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
