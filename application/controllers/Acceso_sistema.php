<?php
class Acceso_sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('acceso_sistema_model');
        $this->load->model('opcion_sistema_model');
        $this->load->model('rol_model');
        $this->load->model('acceso_sistema_model');
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

            if ($data['id_rol'] != 'adm') {
                redirect('admin');
            }

            $data['accesos_sistema'] = $this->acceso_sistema_model->get_accesos_sistema();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/acceso_sistema/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $data += $this->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect('admin');
            }

            $data['opciones_sistema'] = $this->opcion_sistema_model->get_opciones_sistema();
            $data['roles'] = $this->rol_model->get_roles();

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/acceso_sistema/nuevo', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function guardar($id_acceso=null)
    {
        if ($this->session->userdata('logueado')) {

            $acceso_sistema = $this->input->post();
            if ($acceso_sistema) {

                if ($id_acceso) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'codigo' => $acceso_sistema['codigo'],
                    'id_rol' => $acceso_sistema['id_rol']
                );
                $id_acceso = $this->acceso_sistema_model->guardar($data, $id_acceso);

                // registro en bitacora
                $opcion = $this->opcion_sistema_model->get_opcion_sistema_codigo($acceso_sistema['codigo']);
                $rol = $this->rol_model->get_rol($acceso_sistema['id_rol']);
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_organizacion = $this->session->userdata('nom_organizacion');
                $entidad = 'acceso_sistema';
                $valor = $opcion['codigo'] . " " . $opcion['nom_opcion'] . $separador . $rol['nom_rol'];
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
                $this->bitacora_model->guardar($data);

            }
            redirect('acceso_sistema');

        } else {
            redirect('admin/login');
        }
    }

    public function eliminar($id_acceso)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $acceso = $this->acceso_sistema_model->get_acceso_sistema($id_acceso);
            $opcion = $this->opcion_sistema_model->get_opcion_sistema_codigo($acceso['codigo']);
            $rol = $this->rol_model->get_rol($acceso['id_rol']);
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_organizacion = $this->session->userdata('nom_organizacion');
            $accion = 'eliminó';
            $entidad = 'acceso_sistema';
            $valor = $opcion['codigo'] . " " . $opcion['nom_opcion'] . $separador . $rol['nom_rol'];
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
            $this->bitacora_model->guardar($data);

            // eliminado
            $this->acceso_sistema_model->eliminar($id_acceso);

            redirect('acceso_sistema');
        } else {
            redirect('admin/login');
        }
    }

}
