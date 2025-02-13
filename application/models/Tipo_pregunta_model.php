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

    public function get_tipo_pregunta_id($id_tipo_pregunta) {
        $sql = 'select * from tipo_pregunta where id_tipo_pregunta = ?;';
        $query = $this->db->query($sql, array($id_tipo_pregunta));
        return $query->row_array();
    }

    public function get_tipo_pregunta_nom($nom_tipo_pregunta) {
        $sql = 'select valor from tipo_pregunta where nom_tipo_pregunta = ?;';
        $query = $this->db->query($sql, array($nom_tipo_pregunta));
        return $query->row_array()['valor'] ?? null ;
    }

    public function guardar($data, $id_tipo_pregunta)
    {
        if ($id_tipo_pregunta) {
            $this->db->where('id_tipo_pregunta', $id_tipo_pregunta);
            $this->db->update('tipo_pregunta', $data);
            $id = $id_tipo_pregunta;
        } else {
            $this->db->insert('tipo_pregunta', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_tipo_pregunta)
    {
        $this->db->where('id_tipo_pregunta', $id_tipo_pregunta);
        $result = $this->db->delete('tipo_pregunta');
    }

}
