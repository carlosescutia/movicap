<?php
class Accesos_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_accesos_sistema() {
        $sql = 'select acs.*, o.nom_opcion, r.nom_rol from accesos_sistema acs left join opciones_sistema o on acs.cod_opcion = o.cod_opcion left join roles r on acs.cve_rol = r.cve_rol order by cve_rol, cod_opcion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_acceso_sistema($cve_acceso) {
        $sql = 'select * from accesos_sistema where cve_acceso = ?;';
        $query = $this->db->query($sql, array($cve_acceso));
        return $query->row_array();
    }

    public function get_accesos_sistema_rol($cve_rol) {
        $sql = "select string_agg(cod_opcion::text, ',') as accesos from accesos_sistema where cve_rol = ?";
        $query = $this->db->query($sql, array($cve_rol));
        return $query->row_array();
    }

    public function get_acceso_opcion_rol($cod_opcion, $cve_rol) {
        $sql = 'select * from accesos_sistema where cod_opcion = ? and $cve_rol = ?;';
        $query = $this->db->query($sql, array($cod_opcion, $cve_rol));
        return $query->row_array();
    }

    public function guardar($data, $cve_acceso)
    {
        if ($cve_acceso) {
            $this->db->where('cve_acceso', $cve_acceso);
            $this->db->update('accesos_sistema', $data);
            $id = $cve_acceso;
        } else {
            $this->db->insert('accesos_sistema', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_acceso)
    {
        $this->db->where('cve_acceso', $cve_acceso);
        $result = $this->db->delete('accesos_sistema');
        return $result;
    }

}
