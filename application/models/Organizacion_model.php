<?php
class Organizacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_organizaciones() {
        $sql = 'select * from organizacion order by id_organizacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_organizacion($id_organizacion) {
        $sql = 'select * from organizacion where id_organizacion = ?;';
        $query = $this->db->query($sql, array($id_organizacion));
        return $query->row_array();
    }

    public function guardar($data, $id_organizacion)
    {
        if ($id_organizacion) {
            $this->db->where('id_organizacion', $id_organizacion);
            $this->db->update('organizacion', $data);
            $id = $id_organizacion;
        } else {
            $this->db->insert('organizacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_organizacion)
    {
        $this->db->where('id_organizacion', $id_organizacion);
        $result = $this->db->delete('organizacion');
    }

}
