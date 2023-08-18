<?php
class Roles_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_roles() {
        $sql = 'select * from roles order by cve_rol;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_rol($cve_rol) {
        $sql = 'select * from roles where cve_rol = ?;';
        $query = $this->db->query($sql, array($cve_rol));
        return $query->row_array();
    }

    public function guardar($data, $cve_rol)
    {
        if ($cve_rol) {
            $this->db->where('cve_rol', $cve_rol);
            $result = $this->db->update('roles', $data);
        } else {
            $result = $this->db->insert('roles', $data);
        }
        return $result;
    }

    public function eliminar($cve_rol)
    {
        $this->db->where('cve_rol', $cve_rol);
        $result = $this->db->delete('roles');
        return $result;
    }

}
