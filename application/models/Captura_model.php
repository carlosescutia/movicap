<?php
class Captura_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_capturas() {
        $sql = 'select * from captura order by id_cuestionario, fecha;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_capturas_cuestionario($id_cuestionario) {
        $sql = 'select * from captura where id_cuestionario = ? order by fecha;';
        $query = $this->db->query($sql, array($id_cuestionario));
        return $query->result_array();
    }

    public function get_captura($id_captura) {
        $sql = 'select * from captura where id_captura = ?;';
        $query = $this->db->query($sql, array($id_captura));
        return $query->row_array();
    }

    public function guardar($data, $id_captura)
    {
        if ($id_captura) {
            $this->db->where('id_captura', $id_captura);
            $this->db->update('captura', $data);
            $id = $id_captura;
        } else {
            $this->db->insert('captura', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_captura)
    {
        $this->db->where('id_captura', $id_captura);
        $result = $this->db->delete('captura');
    }

}

