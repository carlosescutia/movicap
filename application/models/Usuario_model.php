<?php
class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function usuario_por_nombre($usuario, $password) {
        $this->db->select('u.id_usuario, u.nom_usuario, u.usuario, u.id_organizacion, d.nom_organizacion, u.id_rol, r.nombre as nom_rol');
        $this->db->from('usuario u');
        $this->db->join('rol r', 'u.id_rol = r.id_rol', 'left');
        $this->db->join('organizacion d', 'u.id_organizacion = d.id_organizacion', 'left');
        $this->db->where('u.usuario', $usuario);
        $this->db->where('u.password', $password);
        $this->db->where('u.activo', '1');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function get_usuarios() {
        $sql = 'select u.*, r.nombre as nom_rol, d.nom_organizacion from usuario u left join rol r on u.id_rol = r.id_rol left join organizacion d on u.id_organizacion = d.id_organizacion order by u.id_usuario;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_usuario($id_usuario) {
        $sql = 'select u.*, d.nom_organizacion, r.nombre as nom_rol from usuario u left join rol r on u.id_rol = r.id_rol left join organizacion d on u.id_organizacion = d.id_organizacion where u.id_usuario = ?;';
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
