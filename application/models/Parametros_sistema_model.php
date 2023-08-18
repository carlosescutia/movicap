<?php
class Parametros_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_parametros_sistema() {
        $sql = 'select * from parametros_sistema order by cve_parametro_sistema;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_parametro_sistema_cve($cve_parametro_sistema) {
        $sql = 'select * from parametros_sistema where cve_parametro_sistema = ?;';
        $query = $this->db->query($sql, array($cve_parametro_sistema));
        return $query->row_array();
    }

    public function get_parametro_sistema_nom($nom_parametro_sistema) {
        $sql = 'select valor_parametro_sistema from parametros_sistema where nom_parametro_sistema = ?;';
        $query = $this->db->query($sql, array($nom_parametro_sistema));
        return $query->row_array()['valor_parametro_sistema'] ?? null ;
    }

    public function guardar($data, $cve_parametro_sistema)
    {
        if ($cve_parametro_sistema) {
            $this->db->where('cve_parametro_sistema', $cve_parametro_sistema);
            $this->db->update('parametros_sistema', $data);
            $id = $cve_parametro_sistema;
        } else {
            $this->db->insert('parametros_sistema', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_parametro_sistema)
    {
        $this->db->where('cve_parametro_sistema', $cve_parametro_sistema);
        $result = $this->db->delete('parametros_sistema');
    }

}
