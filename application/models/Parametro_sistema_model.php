<?php
class Parametro_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_parametros_sistema() {
        $sql = 'select * from parametro_sistema order by id_parametro_sistema;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_parametro_sistema_id($id_parametro_sistema) {
        $sql = 'select * from parametro_sistema where id_parametro_sistema = ?;';
        $query = $this->db->query($sql, array($id_parametro_sistema));
        return $query->row_array();
    }

    public function get_parametro_sistema_nombre($nombre) {
        $sql = 'select valor from parametro_sistema where nombre = ?;';
        $query = $this->db->query($sql, array($nombre));
        return $query->row_array()['valor'] ?? null ;
    }

    public function guardar($data, $id_parametro_sistema)
    {
        if ($id_parametro_sistema) {
            $this->db->where('id_parametro_sistema', $id_parametro_sistema);
            $this->db->update('parametro_sistema', $data);
            $id = $id_parametro_sistema;
        } else {
            $this->db->insert('parametro_sistema', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_parametro_sistema)
    {
        $this->db->where('id_parametro_sistema', $id_parametro_sistema);
        $result = $this->db->delete('parametro_sistema');
    }

}
