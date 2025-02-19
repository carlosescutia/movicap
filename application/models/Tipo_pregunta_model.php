<?php
class Tipo_pregunta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_tipos_pregunta() {
        $sql = 'select * from tipo_pregunta order by orden;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_tipo_pregunta_cve($cve_tipo_pregunta) {
        $sql = 'select * from tipo_pregunta where cve_tipo_pregunta = ?;';
        $query = $this->db->query($sql, array($cve_tipo_pregunta));
        return $query->row_array();
    }

    public function get_tipo_pregunta_nom($nom_tipo_pregunta) {
        $sql = 'select valor from tipo_pregunta where nom_tipo_pregunta = ?;';
        $query = $this->db->query($sql, array($nom_tipo_pregunta));
        return $query->row_array()['valor'] ?? null ;
    }

}
