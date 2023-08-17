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
}
