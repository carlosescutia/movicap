<?php
class Captura extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->model('captura_model');
        $this->load->model('seccion_model');
        $this->load->model('pregunta_model');
        $this->load->model('respuesta_model');
        $this->load->model('valor_posible_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'captura.can_view',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['capturas'] = $this->captura_model->get_capturas();

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('captura/lista', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function detalle($id_captura)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'captura.can_view',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['captura'] = $this->captura_model->get_captura($id_captura);
                $id_cuestionario = $data['captura']['id_cuestionario'];
                $data['secciones'] = $this->seccion_model->get_secciones_cuestionario($id_cuestionario);
                $data['preguntas'] = $this->pregunta_model->get_preguntas_cuestionario($id_cuestionario);
                $data['respuestas'] = $this->respuesta_model->get_respuestas_captura($id_captura);
                $data['resp_calc'] = $this->respuesta_model->get_respuestas_calculo($id_captura);
                $data['valores_posibles'] = $this->valor_posible_model->get_valores_posibles();
                $data['error'] = $this->session->flashdata('error');

                $this->load->view('templates/admheader', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('templates/dlg_borrar_archivo');
                $this->load->view('proyecto/captura_detalle', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
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
                'captura.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $captura = $this->input->post();
                $capturista = $data['id_usuario'];

                if ($captura) {
                    // guardado
                    $data = array(
                        'id_cuestionario' => $captura['id_cuestionario'],
                        'id_usuario' => $capturista,
                        'fecha' => $captura['fecha'],
                        'hora' => $captura['hora'],
                        'lat' => $captura['lat'],
                        'lon' => $captura['lon'],
                    );
                    $id_captura = $this->captura_model->guardar($data, null);

                    // registro en bitacora
                    $accion = 'agregó';
                    $entidad = 'captura';
                    $valor = $id_captura;
                    $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                    $this->detalle($id_captura);
                }
            } else {
                redirect(base_url() . 'proyecto');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function get_layer($id_cuestionario)
    {
        $data = [];
        $data += $this->funciones_sistema->get_userdata();
        $data += $this->funciones_sistema->get_system_params();

        $result = $this->captura_model->get_layer($id_cuestionario, $data['id_usuario'], $data['id_rol']);
        echo json_encode($result);
    }

    /*
    public function guardar($id_captura=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_captura = is_null($id_captura);

            $captura = $this->input->post();
            if ($captura) {

                if ($id_captura) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'fecha' => empty($captura['fecha']) ? null : $captura['fecha'],
                    'hora' => empty($captura['hora']) ? null : $captura['hora'],
                );
                $id_captura = $this->captura_model->guardar($data, $id_captura);

                // registro en bitacora
                $entidad = 'captura';
                $valor = $id_captura . " " . $captura['nom_captura'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'captura/detalle' . $id_captura);

        } else {
            redirect(base_url() . 'admin/login');
        }
    }
    */

    public function importar_csv()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();

            $captura = $this->input->post();
            $num_registros_importados = 0;
            if ($captura) {
                $id_cuestionario = $captura['id_cuestionario'];
                $id_usuario = $data['id_usuario'];
                $fecha = date('Y/m/d');
                $hora = date('H:i:s');

                $nombre_archivo = $captura['nombre_archivo'];
                $nombre_archivo_fs = $captura['dir_docs'] . $nombre_archivo;
                if ( file_exists($nombre_archivo_fs) ) {
                    $rows = array_map('str_getcsv', file($nombre_archivo_fs));
                    $header = array_shift($rows);
                    $csv = array();
                    foreach ($rows as $row) {
                        $csv[] = array_combine($header, $row);
                    }

                    foreach ($csv as $registro) {
                        $lat = empty($registro['lat']) ? 21 : $registro['lat'];
                        $lon = empty($registro['lon']) ? -101 : $registro['lon'];
                        $nueva_captura = array (
                            'id_cuestionario' => $id_cuestionario,
                            'id_usuario' => $id_usuario,
                            'fecha' => $fecha,
                            'hora' => $hora,
                            'lat' => $lat,
                            'lon' => $lon,
                        );
                        $id_captura = null;
                        $id_captura = $this->captura_model->guardar($nueva_captura, null);
                        if ($id_captura) {
                            $num_registros_importados++;
                        }
                        foreach ($registro as $campo => $valor) {
                            if ( ! in_array($campo, array("lat", "lon")) ) { 
                                $id_pregunta = $this->pregunta_model->get_pregunta_cuestionario_nombre($id_cuestionario, $campo)['id_pregunta'];
                                $cve_tipo_pregunta = $this->pregunta_model->get_pregunta_cuestionario_nombre($id_cuestionario, $campo)['cve_tipo_pregunta'];
                                if ($cve_tipo_pregunta == 'op_multiple') {
                                    $valor_posible = $this->valor_posible_model->get_valor_posible_pregunta_valor($id_pregunta, $valor);
                                    if ($valor_posible) {
                                        $valor_final = $valor_posible['id_valor_posible'];
                                    } else {
                                        $valor_final = null;
                                    }
                                } else {
                                    $valor_final = $valor;
                                }
                                if ($id_captura and $id_pregunta and $valor_final) {
                                    $nueva_respuesta = array (
                                        'id_captura' => $id_captura,
                                        'id_pregunta' => $id_pregunta,
                                        'valor' => $valor_final,
                                    );
                                    $id_respuesta = $this->respuesta_model->guardar($nueva_respuesta, null);
                                }
                            }
                        }
                    }

                    // Eliminar archivo
                    $status = unlink($nombre_archivo_fs) ? 'Se eliminó el archivo '.$nombre_archivo_fs : 'Error al eliminar el archivo '.$nombre_archivo_fs;
                    echo $status;
                }
                $this->session->set_flashdata('num_registros_importados', $num_registros_importados);
                // registro en bitacora
                $accion = 'importó';
                $entidad = 'captura';
                $valor = $num_registros_importados . " registros en cuestionario " . $id_cuestionario;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                redirect(base_url() . 'proyecto');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function eliminar($id_captura)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $captura = $this->captura_model->get_captura($id_captura);
            $accion = 'eliminó';
            $entidad = 'captura';
            $valor = $id_captura . " " . $captura['nom_captura'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->captura_model->eliminar($id_captura);

            redirect(base_url() . 'cuestionario');

        } else {
            redirect(base_url() . 'admin/login');
        }
    }

}

