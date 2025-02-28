<?php
class Cuestionario_usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_cuestionario_usuario($id_cuestionario_usuario) {
        $sql = 'select * from cuestionario_usuario where id_cuestionario_usuario = ?';
        $query = $this->db->query($sql, array($id_cuestionario_usuario));
        return $query->row_array();
    }

    public function get_usuarios_cuestionario($id_cuestionario) {
        $sql = 'select cu.*, u.nom_usuario from cuestionario_usuario cu left join usuario u on u.id_usuario = cu.id_usuario where id_cuestionario = ?';
        $query = $this->db->query($sql, array($id_cuestionario));
        return $query->result_array();
    }

    public function guardar($data, $id_cuestionario_usuario)
    {
        if ($id_cuestionario_usuario) {
            $this->db->where('id_cuestionario_usuario', $id_cuestionario_usuario);
            $this->db->update('cuestionario_usuario', $data);
            $id = $id_cuestionario_usuario;
        } else {
            $this->db->insert('cuestionario_usuario', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_cuestionario_usuario)
    {
        $this->db->where('id_cuestionario_usuario', $id_cuestionario_usuario);
        $result = $this->db->delete('cuestionario_usuario');
    }

}
