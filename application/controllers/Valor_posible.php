<?php
class Valor_posible extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('valor_posible_model');
    }

    public function detalle($id_valor_posible)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $data['valor_posible'] = $this->valor_posible_model->get_valor_posible($id_valor_posible);
            $id_pregunta = $data['valor_posible']['id_pregunta'];

            $permisos_requeridos = array(
                'valor_posible.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {

                $this->load->view('templates/admheader', $data);
                $this->load->view('cuestionario/valor_posible_detalle', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'pregunta/detalle/' . $id_pregunta);
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();

            $permisos_requeridos = array(
                'valor_posible.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                // guardado
                $valor_posible = $this->input->post();
                if ($valor_posible) {
                    $data = array(
                        'id_pregunta' => $valor_posible['id_pregunta'],
                        'texto' => 'Nuevo valor posible',
                    );
                    $id_valor_posible = $this->valor_posible_model->guardar($data, null);

                    // registro en bitacora
                    $accion = 'agregó';
                    $entidad = 'valor_posible';
                    $valor = $id_valor_posible;
                    $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                    $this->detalle($id_valor_posible);
                }
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function guardar($id_valor_posible=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_valor_posible = is_null($id_valor_posible);

            $valor_posible = $this->input->post();
            $id_cuestionario = $valor_posible['id_cuestionario'];
            if ($valor_posible) {

                if ($id_valor_posible) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'id_pregunta' => $valor_posible['id_pregunta'],
                    'texto' => $valor_posible['texto'],
                    'valor' => $valor_posible['valor'],
                    'orden' => empty($valor_posible['orden']) ? null : $valor_posible['orden'],
                );
                $id_valor_posible = $this->valor_posible_model->guardar($data, $id_valor_posible);

                // registro en bitacora
                $entidad = 'valor_posible';
                $valor = $id_valor_posible . " " . $valor_posible['texto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'pregunta/detalle/' . $valor_posible['id_pregunta']);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_valor_posible)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $valor_posible = $this->valor_posible_model->get_valor_posible($id_valor_posible);
            $id_pregunta = $valor_posible['id_pregunta'];
            $accion = 'eliminó';
            $entidad = 'valor_posible';
            $valor = $id_valor_posible . " " . $valor_posible['texto'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->valor_posible_model->eliminar($id_valor_posible);

            redirect(base_url() . 'pregunta/detalle/' . $id_pregunta);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}

