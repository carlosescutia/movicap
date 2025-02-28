<?php
class Cuestionario_usuario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('cuestionario_usuario_model');
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $cuestionario_usuario = $this->input->post();
            if ($cuestionario_usuario) {
                $id_cuestionario = $cuestionario_usuario['id_cuestionario'];
                $id_usuario = $cuestionario_usuario['id_usuario'];

                // guardado
                $data = array(
                    'id_cuestionario' => $id_cuestionario,
                    'id_usuario' => $id_usuario,
                );
                $id_cuestionario_usuario = $this->cuestionario_usuario_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'cuestionario_usuario';
                $valor = $id_cuestionario . " " . $id_usuario;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'cuestionario/detalle/' . $id_cuestionario);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_cuestionario_usuario)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $cuestionario_usuario = $this->cuestionario_usuario_model->get_cuestionario_usuario($id_cuestionario_usuario);
            $id_cuestionario = $cuestionario_usuario['id_cuestionario'];
            $id_usuario = $cuestionario_usuario['id_usuario'];

            $accion = 'eliminó';
            $entidad = 'cuestionario_usuario';
            $valor = $id_cuestionario . " " . $id_usuario;
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->cuestionario_usuario_model->eliminar($id_cuestionario_usuario);

            redirect(base_url() . 'cuestionario/detalle/' . $id_cuestionario);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
