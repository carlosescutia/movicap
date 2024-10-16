<?php
class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function usuario_por_nombre($usuario, $password) {
        $sql = ""
            ."select u.id_usuario, u.nom_usuario, u.usuario, u.id_organizacion, o.nom_organizacion, u.id_rol, r.nombre as nom_rol "
            ."from usuario u "
            ."left join rol r on r.id_rol = u.id_rol "
            ."left join organizacion o on o.id_organizacion = u.id_organizacion "
            ."where "
            ."u.usuario = ? "
            ."and password = ? "
            ."and activo = 1 "
            ."";
        $query = $this->db->query($sql, array($usuario, $password));
        return $query->row_array();
    }

    public function get_usuarios() {
        $sql = ""
            ."select "
            ."u.*, r.nombre as nom_rol, o.nom_organizacion, "
            ."(select count(*) from acceso_sistema_usuario asu where asu.id_usuario = u.id_usuario) as num_permisos "
            ."from "
            ."usuario u "
            ."left join rol r on u.id_rol = r.id_rol "
            ."left join organizacion o on u.id_organizacion = o.id_organizacion "
            ."order by "
            ."u.id_usuario "
            ."";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_usuario($id_usuario) {
        $sql = ""
            ."select u.*, o.nom_organizacion, r.nombre as nom_rol "
            ."from usuario u "
            ."left join rol r on u.id_rol = r.id_rol "
            ."left join organizacion o on u.id_organizacion = o.id_organizacion "
            ."where u.id_usuario = ? "
            ."";
        $query = $this->db->query($sql, array($id_usuario));
        return $query->row_array();
    }

    public function guardar($data, $id_usuario)
    {
        if ($id_usuario) {
            $this->db->where('id_usuario', $id_usuario);
            $this->db->update('usuario', $data);
            $id = $id_usuario;
        } else {
            $this->db->insert('usuario', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_usuario)
    {
        $this->db->where('id_usuario', $id_usuario);
        $result = $this->db->delete('usuario');
        return $result;
    }

}
