<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('opcion_publica_model');
        $this->load->model('parametro_sistema_model');
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

        $data = [];
        $data += $this->get_system_params();

        $data['opciones_publicas'] = $this->opcion_publica_model->get_opciones_publicas();

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/inicio');
        $this->load->view('templates/footer', $data);
    }

}
