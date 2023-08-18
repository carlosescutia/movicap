<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('opciones_publicas_model');
        $this->load->model('parametros_sistema_model');
    }

    public function get_system_params()
    {
        $data['nom_sitio_corto'] = $this->parametros_sistema_model->get_parametro_sistema_nom('nom_sitio_corto');
        $data['nom_sitio_largo'] = $this->parametros_sistema_model->get_parametro_sistema_nom('nom_sitio_largo');
        $data['nom_org_sitio'] = $this->parametros_sistema_model->get_parametro_sistema_nom('nom_org_sitio');
        $data['anio_org_sitio'] = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_org_sitio');
        $data['tel_org_sitio'] = $this->parametros_sistema_model->get_parametro_sistema_nom('tel_org_sitio');
        $data['correo_org_sitio'] = $this->parametros_sistema_model->get_parametro_sistema_nom('correo_org_sitio');
        $data['logo_org_sitio'] = $this->parametros_sistema_model->get_parametro_sistema_nom('logo_org_sitio');
        return $data;
    }

    public function index()
    {
        
        $data = [];
        $data += $this->get_system_params();

        $data['opciones_publicas'] = $this->opciones_publicas_model->get_opciones_publicas();

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/inicio');
        $this->load->view('templates/footer', $data);
    }

}
