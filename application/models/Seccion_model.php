<?php
class Seccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_secciones_cuestionario($id_cuestionario) {
        $sql = 'select * from seccion where id_cuestionario = ? order by id_seccion;';
        $query = $this->db->query($sql, array($id_cuestionario));
        return $query->result_array();
    }

    public function get_seccion($id_seccion) {
        $sql = 'select * from seccion where id_seccion = ?;';
        $query = $this->db->query($sql, array($id_seccion));
        return $query->row_array();
    }

    public function guardar($data, $id_seccion)
    {
        if ($id_seccion) {
            $this->db->where('id_seccion', $id_seccion);
            $this->db->update('seccion', $data);
            $id = $id_seccion;
        } else {
            $this->db->insert('seccion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_seccion)
    {
        $this->db->where('id_seccion', $id_seccion);
        $result = $this->db->delete('seccion');
    }

}


