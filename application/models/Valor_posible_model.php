<?php
class Valor_posible_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valores_posibles() {
        $sql = 'select * from valor_posible order by id_pregunta, orden;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_valores_posibles_pregunta($id_pregunta) {
        $sql = 'select * from valor_posible where id_pregunta = ? order by orden;';
        $query = $this->db->query($sql, array($id_pregunta));
        return $query->result_array();
    }

    public function get_valor_posible($id_valor_posible) {
        $sql = 'select * from valor_posible where id_valor_posible = ?;';
        $query = $this->db->query($sql, array($id_valor_posible));
        return $query->row_array();
    }

    public function guardar($data, $id_valor_posible)
    {
        if ($id_valor_posible) {
            $this->db->where('id_valor_posible', $id_valor_posible);
            $this->db->update('valor_posible', $data);
            $id = $id_valor_posible;
        } else {
            $this->db->insert('valor_posible', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_valor_posible)
    {
        $this->db->where('id_valor_posible', $id_valor_posible);
        $result = $this->db->delete('valor_posible');
    }

}

