<?php
class Reportes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->helper('download');

        $this->load->model('bitacora_model');
        $this->load->model('captura_model');
        $this->load->model('cuestionario_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'reportes.can_view',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $this->load->view('templates/admheader', $data);
                $this->load->view('reportes/index', $data);
                $this->load->view('templates/footer', $data);
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function listado_bitacora_01($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $permisos_requeridos = array(
                'reportes_usuario.can_view',
                'reportes_supervisor.can_view',
                'reportes_administrador.can_view',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $filtros = $this->input->post();
                if ($filtros) {
                    $accion = $filtros['accion'];
                    $entidad = $filtros['entidad'];
                } else {
                    $accion = '';
                    $entidad = '';
                }

                $data['accion'] = $accion;
                $data['entidad'] = $entidad;
                $id_rol = $data['id_rol'];

                $nom_organizacion = $this->session->userdata['nom_organizacion'];
                $usuario = $this->session->userdata['usuario'];
                $data['bitacora'] = $this->bitacora_model->get_bitacora($usuario, $nom_organizacion, $id_rol, $accion, $entidad, $salida);

                if ($salida == 'csv') {
                    force_download("listado_bitacora_01.csv", $data['bitacora']);
                } else {
                    $this->load->view('templates/admheader', $data);
                    $this->load->view('reportes/listado_bitacora_01', $data);
                    $this->load->view('templates/footer', $data);
                }
            } else {
                redirect(base_url() . 'admin');
            }
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function capturas_cuestionario()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $parametros = $this->input->post();
            if ($parametros) {
                $id_cuestionario = $parametros['id_cuestionario'];
                $salida = $parametros['salida'];

                $capturas_cuestionario = $this->captura_model->get_capturas_cuestionario($id_cuestionario, $salida);

                $cuestionario = $this->cuestionario_model->get_cuestionario($id_cuestionario);
                $nom_archivo = $cuestionario['nom_cuestionario'] . ' - ' . date('d', time()) . get_nom_mes(date('m',time())) . date('y',time()) . '.csv';

                if ($salida == 'csv') {
                    force_download($nom_archivo, $capturas_cuestionario);
                } else {
                    print_r($capturas_cuestionario);
                }
            }
            redirect(base_url() . 'cuestionario');
        } else {
            redirect(base_url() . 'admin/login');
        }
    }

    public function fotos_cuestionario()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->funciones_sistema->get_userdata();
            $data += $this->funciones_sistema->get_system_params();

            $parametros = $this->input->post();
            if ($parametros) {
                $id_cuestionario = $parametros['id_cuestionario'];

                $fotos_cuestionario = $this->captura_model->get_fotos_cuestionario($id_cuestionario);
                foreach ($fotos_cuestionario as $foto) {
                    $this->zip->read_file($foto);
                }

                $cuestionario = $this->cuestionario_model->get_cuestionario($id_cuestionario);
                $nom_archivo_zip = 'Fotos ' . $cuestionario['nom_cuestionario'] . ' - ' . date('d', time()) . get_nom_mes(date('m',time())) . date('y',time()) . '.zip';

                $this->zip->download($nom_archivo_zip);
            }
            redirect(base_url() . 'cuestionario');
        } else {
            redirect(base_url() . 'admin/login');
        }
    }


}
