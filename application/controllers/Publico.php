<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
    }

    public function index()
    {

        $data = [];
        $data += $this->funciones_sistema->get_system_params();

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/inicio');
        $this->load->view('templates/footer', $data);
    }

}
