<?php
class Usuarios extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('usuarios_model');
        $this->load->model('roles_model');
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

            $data['usuarios'] = $this->usuarios_model->get_usuarios();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/usuarios/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/login');
        }
    }

    public function detalle($cve_usuario)
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

            $data['usuarios'] = $this->usuarios_model->get_usuario($cve_usuario);
            $data['roles'] = $this->roles_model->get_roles();
            $data['organizaciones'] = $this->organizaciones_model->get_organizaciones();

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/usuarios/detalle', $data);
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

            $data['roles'] = $this->roles_model->get_roles();
            $data['organizaciones'] = $this->organizaciones_model->get_organizaciones();

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/usuarios/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/login');
        }
    }

    public function guardar($cve_usuario=null)
    {
        if ($this->session->userdata('logueado')) {

            $usuarios = $this->input->post();
            if ($usuarios) {
                
                if ($cve_usuario) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'cve_organizacion' => $usuarios['cve_organizacion'],
                    'cve_rol' => $usuarios['cve_rol'],
                    'nom_usuario' => $usuarios['nom_usuario'],
                    'usuario' => $usuarios['usuario'],
                    'password' => $usuarios['password'],
                    'activo' => empty($usuarios['activo']) ? '0' : $usuarios['activo']
                );
                $cve_usuario = $this->usuarios_model->guardar($data, $cve_usuario);
            }
            redirect('usuarios');

        } else {
            redirect('admin/login');
        }
    }

    public function eliminar($cve_usuario)
    {
        if ($this->session->userdata('logueado')) {
            // eliminado
			$this->usuarios_model->eliminar($cve_usuario);

			redirect('usuarios');
		} else {
			redirect('admin/login');
		}
	}
}
