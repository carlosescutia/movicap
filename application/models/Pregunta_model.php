<?php
class Pregunta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_preguntas_cuestionario($id_cuestionario) {
        $sql = 'select p.*, nom_tipo_pregunta from pregunta p left join tipo_pregunta tp on tp.cve_tipo_pregunta = p.cve_tipo_pregunta left join seccion s on s.id_seccion = p.id_seccion where s.id_cuestionario = ? order by p.orden;';
        $query = $this->db->query($sql, array($id_cuestionario));
        return $query->result_array();
    }

    public function get_preguntas_seccion($id_seccion) {
        $sql = 'select p.*, nom_tipo_pregunta from pregunta p left join tipo_pregunta tp on tp.cve_tipo_pregunta = p.cve_tipo_pregunta where p.id_seccion = ? order by p.orden;';
        $query = $this->db->query($sql, array($id_seccion));
        return $query->result_array();
    }

    public function get_pregunta($id_pregunta) {
        $sql = 'select * from pregunta where id_pregunta = ?;';
        $query = $this->db->query($sql, array($id_pregunta));
        return $query->row_array();
    }

    public function get_pregunta_cuestionario_nombre($id_cuestionario, $nombre) {
        $sql = ""
            ."select "
            ."p.* "
            ."from "
            ."pregunta p "
            ."left join seccion s on s.id_seccion = p.id_seccion "
            ."where "
            ."p.cve_tipo_pregunta in ('abierta', 'op_multiple') "
            ."and s.id_cuestionario = ? "
            ."and nom_pregunta = ? "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario, $nombre));
        return $query->row_array();
    }

    public function get_tipo_pregunta($id_pregunta) {
        $sql = 'select * from pregunta where id_pregunta = ?;';
        $query = $this->db->query($sql, array($id_pregunta));
        return $query->row_array();
    }

    public function guardar($data, $id_pregunta)
    {
        if ($id_pregunta) {
            $this->db->where('id_pregunta', $id_pregunta);
            $this->db->update('pregunta', $data);
            $id = $id_pregunta;
        } else {
            $this->db->insert('pregunta', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_pregunta)
    {
        $this->db->where('id_pregunta', $id_pregunta);
        $result = $this->db->delete('pregunta');
    }

}
