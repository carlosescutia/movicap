<?php
class Respuesta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('respuesta_model');
        $this->load->model('captura_model');
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $respuestas = $this->input->post();
            if ($respuestas) {
                $id_captura = $respuestas['id_captura'];
                $lat = $respuestas['lat'];
                $lon = $respuestas['lon'];
                foreach ($respuestas as $clave => $valor) {
                    if ($clave !== 'id_captura' and $clave !== 'lat' and $clave !== 'lon') {
                        if (strpos($clave, "_")) {
                            $id_pregunta = substr($clave, 2, strlen($clave) );
                        } else {
                            $id_pregunta = $clave;
                        }
                        $data = array(
                            'id_captura' => $id_captura,
                            'id_pregunta' => $id_pregunta,
                            'valor' => $valor,
                        );

                        $respuesta = $this->respuesta_model->get_respuesta_captura_pregunta($id_captura, $id_pregunta);
                        if ($respuesta) {
                            $id_respuesta = $respuesta['id_respuesta'];
                            if ($id_respuesta) {
                                $accion = 'modificó';
                            } else {
                                $accion = 'agregó';
                            }
                        } else {
                            $id_respuesta = null;
                        }
                        $id_respuesta = $this->respuesta_model->guardar($data, $id_respuesta);

                    }
                }
                // actualizar coordenadas en Captura
                $data = array(
                    'lat' => $lat,
                    'lon' => $lon,
                );
                $this->captura_model->guardar($data, $id_captura);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'captura';
                $valor = $id_captura ;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);
            }
            redirect(base_url() . 'captura/detalle/' . $id_captura);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}
