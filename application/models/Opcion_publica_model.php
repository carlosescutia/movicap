<?php
class Opcion_publica_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_opciones_publicas() {
        $sql = 'select * from opcion_publica order by orden;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_opcion_publica($id_opcion_publica) {
        $sql = 'select * from opcion_publica where id_opcion_publica = ?;';
        $query = $this->db->query($sql, array($id_opcion_publica));
        return $query->row_array();
    }

    public function guardar($data, $id_opcion_publica)
    {
        if ($id_opcion_publica) {
            $this->db->where('id_opcion_publica', $id_opcion_publica);
            $this->db->update('opcion_publica', $data);
            $id = $id_opcion_publica;
        } else {
            $this->db->insert('opcion_publica', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_opcion_publica)
    {
        $this->db->where('id_opcion_publica', $id_opcion_publica);
        $result = $this->db->delete('opcion_publica');
        return $result;
    }

}
