<?php
class Organizaciones extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('organizaciones_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('parametros_sistema_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_organizacion'] = $this->session->userdata('cve_organizacion');
            $data['nom_organizacion'] = $this->session->userdata('nom_organizacion');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            
            if ($cve_rol != 'adm') {
                redirect('admin');
            }

            $data['organizaciones'] = $this->organizaciones_model->get_organizaciones();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/organizaciones/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/login');
        }
    }

    public function detalle($cve_organizacion)
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_organizacion'] = $this->session->userdata('cve_organizacion');
            $data['nom_organizacion'] = $this->session->userdata('nom_organizacion');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

            if ($cve_rol != 'adm') {
                redirect('admin');
            }

            $data['organizaciones'] = $this->organizaciones_model->get_organizacion($cve_organizacion);

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/organizaciones/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_organizacion'] = $this->session->userdata('cve_organizacion');
            $data['nom_organizacion'] = $this->session->userdata('nom_organizacion');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

            if ($cve_rol != 'adm') {
                redirect('admin');
            }

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/organizaciones/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/login');
        }
    }

    public function guardar($cve_organizacion=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_organizacion = is_null($cve_organizacion);

            $organizaciones = $this->input->post();
            if ($organizaciones) {

                if ($cve_organizacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_organizacion' => $organizaciones['nom_organizacion']
                );
                $cve_organizacion = $this->organizaciones_model->guardar($data, $cve_organizacion);
            }

            redirect('organizaciones');

        } else {
            redirect('admin/login');
        }
    }

    public function eliminar($cve_organizacion)
    {
        if ($this->session->userdata('logueado')) {
            // eliminado
            $this->organizaciones_model->eliminar($cve_organizacion);

            redirect('organizaciones');

        } else {
            redirect('admin/login');
        }
    }

}
