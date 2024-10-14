<?php
class Rol_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_roles() {
        $sql = 'select * from rol order by id_rol;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_rol($id_rol) {
        $sql = 'select * from rol where id_rol = ?';
        $query = $this->db->query($sql, array($id_rol));
        return $query->row_array();
    }

}
