<?php
class Opciones_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_opciones_sistema() {
        $sql = 'select * from opciones_sistema order by cod_opcion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
