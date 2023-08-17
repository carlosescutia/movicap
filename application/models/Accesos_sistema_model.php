<?php
class Accesos_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_accesos_sistema_rol($cve_rol) {
        $sql = "select string_agg(cod_opcion::text, ',') as accesos from accesos_sistema where cve_rol = ?";
        $query = $this->db->query($sql, array($cve_rol));
        return $query->row_array();
    }
}
