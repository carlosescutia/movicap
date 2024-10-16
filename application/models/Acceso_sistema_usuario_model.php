<?php
class Acceso_sistema_usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_acceso_sistema_usuario($id_acceso_sistema_usuario) {
        $sql = 'select * from acceso_sistema_usuario where id_acceso_sistema_usuario = ?';
        $query = $this->db->query($sql, array($id_acceso_sistema_usuario));
        return $query->row_array();
    }


    public function get_accesos_sistema_usuario($id_usuario) {
        // solo accesos del usuario
        $sql = "select asu.id_usuario, asu.id_acceso_sistema_usuario, asu.codigo, ops.nombre as nom_opcion from acceso_sistema_usuario asu left join opcion_sistema ops on asu.codigo = ops.codigo where id_usuario = ?";
        $query = $this->db->query($sql, array($id_usuario));
        return $query->result_array();
    }

    public function get_usuarios_acceso($id_opcion_sistema) {
        // Devuelve usuarios con acceso a una opción
        $sql = 'select asu.id_usuario, u.nom_usuario, o.nom_organizacion from acceso_sistema_usuario asu left join opcion_sistema ops on ops.codigo = asu.codigo left join usuario u on u.id_usuario = asu.id_usuario left join organizacion o on o.id_organizacion = u.id_organizacion where ops.id_opcion_sistema = ? ;';
        $query = $this->db->query($sql, array($id_opcion_sistema));
        return $query->result_array();
    }


    public function guardar($data, $id_acceso_sistema_usuario)
    {
        if ($id_acceso_sistema_usuario) {
            $this->db->where('id_acceso_sistema_usuario', $id_acceso_sistema_usuario);
            $this->db->update('acceso_sistema_usuario', $data);
            $id = $id_acceso_sistema_usuario;
        } else {
            $this->db->insert('acceso_sistema_usuario', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_acceso_sistema_usuario)
    {
        $this->db->where('id_acceso_sistema_usuario', $id_acceso_sistema_usuario);
        $result = $this->db->delete('acceso_sistema_usuario');
        return $result;
    }

}
