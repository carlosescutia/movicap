<?php
class Organizacion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('organizacion_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $data['organizaciones'] = $this->organizacion_model->get_organizaciones();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/organizacion/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_organizacion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $data['organizacion'] = $this->organizacion_model->get_organizacion($id_organizacion);

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/organizacion/detalle', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/organizacion/nuevo', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_organizacion=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_organizacion = is_null($id_organizacion);

            $organizacion = $this->input->post();
            if ($organizacion) {

                if ($id_organizacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_organizacion' => $organizacion['nom_organizacion']
                );
                $id_organizacion = $this->organizacion_model->guardar($data, $id_organizacion);

                // registro en bitacora
                $entidad = 'organizacion';
                $valor = $id_organizacion . " " . $organizacion['nom_organizacion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'organizacion');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_organizacion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $organizacion = $this->organizacion_model->get_organizacion($id_organizacion);
            $accion = 'eliminó';
            $entidad = 'organizacion';
            $valor = $id_organizacion . " " . $organizacion['nom_organizacion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->organizacion_model->eliminar($id_organizacion);

            redirect(base_url() . 'organizacion');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
