<?php
class Opciones_publicas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_opciones_publicas() {
        $sql = 'select * from opciones_publicas order by orden;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_opcion($cve_opcion) {
        $sql = 'select * from opciones_publicas where cve_opcion = ?;';
        $query = $this->db->query($sql, array($cve_opcion));
        return $query->row_array();
    }

    public function guardar($data, $cve_opcion)
    {
        if ($cve_opcion) {
            $this->db->where('cve_opcion', $cve_opcion);
            $this->db->update('opciones_publicas', $data);
            $id = $cve_opcion;
        } else {
            $this->db->insert('opciones_publicas', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_opcion)
    {
        $this->db->where('cve_opcion', $cve_opcion);
        $result = $this->db->delete('opciones_publicas');
        return $result;
    }

}
