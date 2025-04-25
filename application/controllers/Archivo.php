<?php
class Archivo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
    }

    public function subir()
    {
        if ($this->session->userdata('logueado')) {

            $dir_docs = $this->input->post('dir_docs');
            $nombre_archivo = $this->input->post('nombre_archivo');
            $tipo_archivo = $this->input->post('tipo_archivo');
            $url_actual = $this->input->post('url_actual');
            $descripcion = $this->input->post('descripcion');
            //
            //crear directorio destino si no existe
            if ( !is_dir($dir_docs) ) {
                mkdir($dir_docs);
            }

            $config = array();
            $config['upload_path'] = $dir_docs;
            $config['file_name'] = $nombre_archivo;
            $config['allowed_types'] = $tipo_archivo;
            $config['max_size'] = '20480';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('subir_archivo') ) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $error['error']);
            } else {
                // registro en bitacora
                $accion = 'subió';
                $entidad = 'archivo';
                $valor = $descripcion . ' -> ' . $nombre_archivo;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect($url_actual);
        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar()
    {
        if ($this->session->userdata('logueado')) {

            $datos = $this->input->post();
            if ($datos) {
                $dir_docs = $datos['dir_docs'];
                $nombre_archivo = $datos['nombre_archivo'];
                $nombre_archivo_fs = './' . $dir_docs . $nombre_archivo ;
                $url_actual = $datos['url_actual'];

                // registro en bitacora
                $accion = 'eliminó';
                $entidad = 'archivo';
                $valor = $nombre_archivo;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                // Eliminar archivo
                $status = unlink($nombre_archivo_fs) ? 'Se eliminó el archivo '.$nombre_archivo_fs : 'Error al eliminar el archivo '.$nombre_archivo_fs;
                echo $status;
            }

            redirect($url_actual);
        } else {
            redirect('inicio/login');
        }
    }

}
