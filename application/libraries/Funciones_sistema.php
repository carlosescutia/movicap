<?php
class Funciones_sistema extends CI_Controller {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function get_userdata()
    {
        $this->CI->load->model('acceso_sistema_model');
        $this->CI->load->model('opcion_sistema_model');
        $this->CI->load->library('session');

        $id_rol = $this->CI->session->userdata('id_rol');
        $id_usuario = $this->CI->session->userdata('id_usuario');
        $data['id_usuario'] = $id_usuario;
        $data['id_organizacion'] = $this->CI->session->userdata('id_organizacion');
        $data['nom_organizacion'] = $this->CI->session->userdata('nom_organizacion');
        $data['id_rol'] = $id_rol;
        $data['nom_usuario'] = $this->CI->session->userdata('nom_usuario');
        $data['error'] = $this->CI->session->flashdata('error');
        $data['cuestionario_activo'] = $this->CI->session->userdata('cuestionario_activo');
        $data['permisos_usuario'] = explode(',', $this->CI->acceso_sistema_model->get_permisos_usuario($id_usuario));
        $data['accesos_sistema'] = explode(',', $this->CI->acceso_sistema_model->get_accesos_sistema_rol($id_rol)['accesos']);
        $data['opciones_sistema'] = $this->CI->opcion_sistema_model->get_opciones_sistema();
        return $data;
    }

    public function get_system_params()
    {
        $this->CI->load->model('parametro_sistema_model');

        $data['nom_sitio_corto'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('nom_sitio_corto');
        $data['nom_sitio_largo'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('nom_sitio_largo');
        $data['nom_org_sitio'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('nom_org_sitio');
        $data['anio_org_sitio'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('anio_org_sitio');
        $data['tel_org_sitio'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('tel_org_sitio');
        $data['correo_org_sitio'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('correo_org_sitio');
        $data['logo_org_sitio'] = $this->CI->parametro_sistema_model->get_parametro_sistema_nom('logo_org_sitio');
        return $data;
    }

    public function registro_bitacora($accion, $entidad, $valor)
    {
        $this->CI->load->model('bitacora_model');
        $this->CI->load->library('session');

        // registro en bitacora
        $usuario = $this->CI->session->userdata('usuario');
        $nom_usuario = $this->CI->session->userdata('nom_usuario');
        $nom_organizacion = $this->CI->session->userdata('nom_organizacion');
        $data = array(
            'fecha' => date("Y-m-d"),
            'hora' => date("H:i"),
            'origen' => $_SERVER['REMOTE_ADDR'],
            'usuario' => $usuario,
            'nom_usuario' => $nom_usuario,
            'nom_organizacion' => $nom_organizacion,
            'accion' => $accion,
            'entidad' => $entidad,
            'valor' => $valor
        );
        $this->CI->bitacora_model->guardar($data);
    }
}

