<?php
class Reportes extends CI_Controller {

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
            $this->load->view('reportes/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function listado_bitacora_01()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $data += $this->get_system_params();

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
            $data['bitacora'] = $this->bitacora_model->get_bitacora($usuario, $nom_organizacion, $id_rol, $accion, $entidad);

            $this->load->view('templates/admheader', $data);
            $this->load->view('reportes/listado_bitacora_01', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function listado_bitacora_01_csv()
    {
        if ($this->session->userdata('logueado')) {
            $id_rol = $this->session->userdata('id_rol');
            $data['id_usuario'] = $this->session->userdata('id_usuario');
            $data['id_organizacion'] = $this->session->userdata('id_organizacion');
            $data['nom_organizacion'] = $this->session->userdata('nom_organizacion');
            $data['id_rol'] = $id_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema'] = explode(',', $this->acceso_sistema_model->get_accesos_sistema_rol($id_rol)['accesos']);
            $data['opciones_sistema'] = $this->opcion_sistema_model->get_opciones_sistema();

            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');

            $nom_organizacion = $this->session->userdata('nom_organizacion');
            $usuario = $this->session->userdata('usuario');
            $id_rol = $data['id_rol'];
            $filtros = $this->input->post();
            if ($filtros) {
                $accion = $filtros['accion'];
                $entidad = $filtros['entidad'];
            } else {
                $accion = '';
                $entidad = '';
            }

            if ($id_rol == 'sup') {
                $usuario = '%';
            }
            if ($id_rol == 'adm') {
                $usuario = '%';
                $nom_organizacion = '%';
            }

            $sql = "select b.* from bitacora b where b.usuario LIKE ? and b.nom_organizacion LIKE ? ";
            if ($id_rol !== 'adm') {
                $sql .= " and b.usuario not in (select usuario from usuario where id_rol = 'adm')";
            }
            $parametros = array();
            array_push($parametros, "$usuario");
            array_push($parametros, "$nom_organizacion");
            if ($accion <> "") {
                $sql .= ' and b.accion = ?';
                array_push($parametros, "$accion");
            } 
            if ($entidad <> "") {
                $sql .= ' and b.entidad = ?';
                array_push($parametros, "$entidad");
            } 
            $sql .= ' order by b.id_evento desc;';
            $query = $this->db->query($sql, $parametros);

            $delimiter = ",";
            $newline = "\r\n";
            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            force_download("listado_bitacora_01.csv", $data);
        }
    }

}
