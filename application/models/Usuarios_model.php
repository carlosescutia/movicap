<?php
class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function usuario_por_nombre($usuario, $password) {
        $this->db->select('u.cve_usuario, u.nom_usuario, u.usuario, u.cve_organizacion, d.nom_organizacion, u.cve_rol, r.nom_rol');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.cve_rol = r.cve_rol', 'left');
        $this->db->join('organizaciones d', 'u.cve_organizacion = d.cve_organizacion', 'left');
        $this->db->where('u.usuario', $usuario);
        $this->db->where('u.password', $password);
        $this->db->where('u.activo', '1');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function get_usuarios() {
        $sql = 'select u.*, r.nom_rol, d.nom_organizacion from usuarios u left join roles r on u.cve_rol = r.cve_rol left join organizaciones d on u.cve_organizacion = d.cve_organizacion order by u.cve_usuario;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_usuario($cve_usuario) {
        $sql = 'select u.*, d.nom_organizacion, r.nom_rol from usuarios u left join roles r on u.cve_rol = r.cve_rol left join organizaciones d on u.cve_organizacion = d.cve_organizacion where u.cve_usuario = ?;';
        $query = $this->db->query($sql, array($cve_usuario));
        return $query->row_array();
    }

    public function guardar($data, $cve_usuario)
    {
        if ($cve_usuario) {
            $this->db->where('cve_usuario', $cve_usuario);
            $this->db->update('usuarios', $data);
            $id = $cve_usuario;
        } else {
            $this->db->insert('usuarios', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_usuario)
    {
        $this->db->where('cve_usuario', $cve_usuario);
        $result = $this->db->delete('usuarios');
        return $result;
    }

}
