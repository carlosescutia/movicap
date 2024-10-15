<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('opcion_publica_model');
        $this->load->library('funciones_sistema');
    }

    public function index()
    {

        $data = [];
        $data += $this->funciones_sistema->get_system_params();

        $data['opciones_publicas'] = $this->opcion_publica_model->get_opciones_publicas();

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/inicio');
        $this->load->view('templates/footer', $data);
    }

}
