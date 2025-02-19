<?php
class Respuesta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_respuestas() {
        $sql = 'select * from respuesta order by id_respuesta;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_respuestas_captura($id_captura) {
        $sql = 'select * from respuesta where id_captura = ?';
        $query = $this->db->query($sql, array($id_captura));
        return $query->result_array();
    }

    public function get_respuesta($id_respuesta) {
        $sql = 'select * from respuesta where id_respuesta = ?;';
        $query = $this->db->query($sql, array($id_respuesta));
        return $query->row_array();
    }

    public function get_respuesta_captura_pregunta($id_captura, $id_pregunta) {
        $sql = 'select * from respuesta where id_captura = ? and id_pregunta = ?';
        $query = $this->db->query($sql, array($id_captura, $id_pregunta));
        return $query->row_array();
    }

    public function guardar($data, $id_respuesta)
    {
        if ($id_respuesta) {
            $this->db->where('id_respuesta', $id_respuesta);
            $this->db->update('respuesta', $data);
            $id = $id_respuesta;
        } else {
            $this->db->insert('respuesta', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_respuesta)
    {
        $this->db->where('id_respuesta', $id_respuesta);
        $result = $this->db->delete('respuesta');
    }

}
