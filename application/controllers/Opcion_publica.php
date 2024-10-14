<?php
class Opcion_publica extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('opcion_sistema_model');
        $this->load->model('acceso_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametro_sistema_model');

        $this->load->model('opcion_publica_model');
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

            $data['opciones_publicas'] = $this->opcion_publica_model->get_opciones_publicas();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/opcion_publica/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function detalle($id_opcion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $data += $this->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect('admin');
            }

            $data['opcion_publica'] = $this->opcion_publica_model->get_opcion_publica($id_opcion);

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/opcion_publica/detalle', $data);
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

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/opcion_publica/nuevo', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function guardar($id_opcion=null)
    {
        if ($this->session->userdata('logueado')) {

            $opcion_publica = $this->input->post();
            if ($opcion_publica) {

                if ($id_opcion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'orden' => $opcion_publica['orden'],
                    'nombre' => $opcion_publica['nombre'],
                    'url' => $opcion_publica['url'],
                );
                $id_opcion = $this->opcion_publica_model->guardar($data, $id_opcion);

                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_organizacion = $this->session->userdata('nom_organizacion');
                $entidad = 'opcion_publica';
                $valor = $id_opcion ." ". $opcion_publica['orden'] . " " . $opcion_publica['nombre'];
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
            redirect('opcion_publica');

        } else {
            redirect('admin/login');
        }
    }

    public function eliminar($id_opcion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $opcion = $this->opcion_publica_model->get_opcion_publica($id_opcion);
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_organizacion = $this->session->userdata('nom_organizacion');
            $accion = 'eliminó';
            $entidad = 'opcion_publica';
            $valor = $id_opcion ." ". $opcion['orden'] . " " . $opcion['nombre'];
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
            $this->opcion_publica_model->eliminar($id_opcion);
            redirect('opcion_publica');

        } else {
            redirect('admin/login');
        }
    }

}

