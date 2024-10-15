<?php
class Reportes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('bitacora_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $this->load->view('templates/admheader', $data);
            $this->load->view('reportes/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function listado_bitacora_01($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->load->helper('file');
            $this->load->helper('download');

            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $filtros = $this->input->post();
            if ($filtros) {
                $accion = $filtros['accion'];
                $entidad = $filtros['entidad'];
            } else {
                $accion = '';
                $entidad = '';
            }

            $data['accion'] = $accion;
            $data['entidad'] = $entidad;
            $id_rol = $data['id_rol'];

            $nom_organizacion = $this->session->userdata['nom_organizacion'];
            $usuario = $this->session->userdata['usuario'];
            $data['bitacora'] = $this->bitacora_model->get_bitacora($usuario, $nom_organizacion, $id_rol, $accion, $entidad, $salida);

            if ($salida == 'csv') {
                force_download("listado_bitacora_01.csv", $data['bitacora']);
            } else {
                $this->load->view('templates/admheader', $data);
                $this->load->view('reportes/listado_bitacora_01', $data);
                $this->load->view('templates/footer', $data);
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
