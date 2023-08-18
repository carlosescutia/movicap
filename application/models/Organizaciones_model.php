<?php
class Organizaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_organizaciones() {
        $sql = 'select * from organizaciones order by cve_organizacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_organizacion($cve_organizacion) {
        $sql = 'select * from organizaciones where cve_organizacion = ?;';
        $query = $this->db->query($sql, array($cve_organizacion));
        return $query->row_array();
    }

    public function guardar($data, $cve_organizacion)
    {
        if ($cve_organizacion) {
            $this->db->where('cve_organizacion', $cve_organizacion);
            $this->db->update('organizaciones', $data);
            $id = $cve_organizacion;
        } else {
            $this->db->insert('organizaciones', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_organizacion)
    {
        $this->db->where('cve_organizacion', $cve_organizacion);
        $result = $this->db->delete('organizaciones');
    }

}
