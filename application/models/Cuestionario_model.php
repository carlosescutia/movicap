<?php
class Cuestionario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_cuestionarios() {
        $sql = 'select * from cuestionario order by id_cuestionario;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_cuestionario($id_cuestionario) {
        $sql = 'select * from cuestionario where id_cuestionario = ?;';
        $query = $this->db->query($sql, array($id_cuestionario));
        return $query->row_array();
    }

    public function guardar($data, $id_cuestionario)
    {
        if ($id_cuestionario) {
            $this->db->where('id_cuestionario', $id_cuestionario);
            $this->db->update('cuestionario', $data);
            $id = $id_cuestionario;
        } else {
            $this->db->insert('cuestionario', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_cuestionario)
    {
        $this->db->where('id_cuestionario', $id_cuestionario);
        $result = $this->db->delete('cuestionario');
    }

}

