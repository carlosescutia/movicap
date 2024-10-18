<?php
class Acceso_sistema_usuario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('acceso_sistema_usuario_model');
        $this->load->model('usuario_model');
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $acceso_sistema_usuario = $this->input->post();
            if ($acceso_sistema_usuario) {

                $id_usuario = $acceso_sistema_usuario['id_usuario'];
                // guardado
                $data = array(
                    'id_usuario' => $acceso_sistema_usuario['id_usuario'],
                    'cod_opcion_sistema' => $acceso_sistema_usuario['cod_opcion_sistema'],
                );
                $id_acceso_sistema_usuario = $this->acceso_sistema_usuario_model->guardar($data, $acceso_sistema_usuario['id_acceso_sistema_usuario']);

                // registro en bitacora
                $usuario = $this->usuario_model->get_usuario($id_usuario);
                $accion = 'agregó';
                $entidad = 'acceso_sistema_usuario';
                $valor = $acceso_sistema_usuario['cod_opcion_sistema'] . " - " . $usuario['usuario'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'usuario/detalle/'.$id_usuario);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_acceso_sistema_usuario)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $acceso_sistema_usuario = $this->acceso_sistema_usuario_model->get_acceso_sistema_usuario($id_acceso_sistema_usuario);
            $id_usuario = $acceso_sistema_usuario['id_usuario'];
            $usuario = $this->usuario_model->get_usuario($id_usuario);
            $accion = 'eliminó';
            $entidad = 'acceso_sistema_usuario';
            $valor = $acceso_sistema_usuario['cod_opcion_sistema'] . " - " . $usuario['usuario'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->acceso_sistema_usuario_model->eliminar($id_acceso_sistema_usuario);

            redirect(base_url() . 'usuario/detalle/'.$id_usuario);

        } else {
            redirect('inicio/login');
        }
    }

}
