<?php
class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('usuario_model');
        $this->load->model('rol_model');
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

            $data['usuarios'] = $this->usuario_model->get_usuarios();

            $this->load->view('templates/admheader', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/usuario/lista', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_usuario)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            if ($data['id_rol'] != 'adm') {
                redirect(base_url() . 'admin');
            }

            $data['usuario'] = $this->usuario_model->get_usuario($id_usuario);
            $data['roles'] = $this->rol_model->get_roles();
            $data['organizaciones'] = $this->organizacion_model->get_organizaciones();

            $this->load->view('templates/admheader', $data);
            $this->load->view('catalogos/usuario/detalle', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {

            // guardado
            $data = array(
                'id_organizacion' => null,
            );
            $id_usuario = $this->usuario_model->guardar($data, null);

            // registro en bitacora
            $accion = 'agregó';
            $entidad = 'usuario';
            $valor = $id_usuario ;
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            $this->detalle($id_usuario);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_usuario=null)
    {
        if ($this->session->userdata('logueado')) {

            $usuario = $this->input->post();
            if ($usuario) {

                if ($id_usuario) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'id_organizacion' => $usuario['id_organizacion'],
                    'id_rol' => $usuario['id_rol'],
                    'nom_usuario' => $usuario['nom_usuario'],
                    'usuario' => $usuario['usuario'],
                    'password' => $usuario['password'],
                    'activo' => empty($usuario['activo']) ? '0' : $usuario['activo']
                );
                $id_usuario = $this->usuario_model->guardar($data, $id_usuario);

                // registro en bitacora
                $organizacion = $this->organizacion_model->get_organizacion($usuario['id_organizacion']);
                $separador = ' -> ';
                $entidad = 'usuario';
                $valor = $id_usuario ." ". $usuario['nom_usuario'] . $separador . $organizacion['nom_organizacion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect(base_url() . 'usuario');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_usuario)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $datos_usuario = $this->usuario_model->get_usuario($id_usuario);
            $separador = ' -> ';
            $accion = 'eliminó';
            $entidad = 'usuario';
            $valor = $id_usuario ." ". $datos_usuario['nom_usuario'] . $separador . $datos_usuario['nom_organizacion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->usuario_model->eliminar($id_usuario);

            redirect(base_url() . 'usuario');
        } else {
            redirect(base_url() . 'admin/login');
        }
    }
}
