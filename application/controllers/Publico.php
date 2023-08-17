<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('templates/pubheader');
        $this->load->view('publico/inicio');
        $this->load->view('templates/footer');
    }

}
