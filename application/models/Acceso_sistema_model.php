<?php
class Acceso_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_accesos_sistema() {
        $sql = 'select acs.*, o.nombre as nom_opcion, r.nombre as nom_rol from acceso_sistema acs left join opcion_sistema o on acs.codigo = o.codigo left join rol r on acs.id_rol = r.id_rol order by id_rol, codigo;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_acceso_sistema($id_acceso_sistema) {
        $sql = 'select * from acceso_sistema where id_acceso_sistema = ?;';
        $query = $this->db->query($sql, array($id_acceso_sistema));
        return $query->row_array();
    }

    public function get_accesos_sistema_rol_usuario($id_usuario) {
        // solo accesos del rol al que pertenece el usuario
        $sql = "select acs.codigo, ops.nombre as nom_opcion from acceso_sistema acs left join opcion_sistema ops on acs.codigo = ops.codigo left join usuario usu on acs.id_rol = usu.id_rol where usu.id_usuario = ?";
        $query = $this->db->query($sql, array($id_usuario));
        return $query->result_array();
    }

    public function get_permisos_usuario($id_usuario) {
        // accesos del usuario y su rol
        $sql = ""
        ."select "
        ."string_agg(codigo::text, ',') as permisos "
        ."from ( "
        ."select "
        ."acs.codigo "
        ."from "
        ."acceso_sistema acs "
        ."left join usuario usu on acs.id_rol = usu.id_rol "
        ."where "
        ."usu.id_usuario = ? "
        ."union "
        ."select "
        ."asu.codigo "
        ."from "
        ."acceso_sistema_usuario asu "
        ."where "
        ."asu.id_usuario = ? "
        .") subconsulta "
        ."";

        $query = $this->db->query($sql, array($id_usuario, $id_usuario));
        return $query->row_array()['permisos'] ?? null ;
    }

    public function get_accesos_sistema_rol($id_rol) {
        $sql = "select string_agg(codigo::text, ',') as accesos from acceso_sistema where id_rol = ?";
        $query = $this->db->query($sql, array($id_rol));
        return $query->row_array();
    }

    public function get_acceso_opcion_rol($codigo, $id_rol) {
        $sql = 'select * from acceso_sistema where codigo = ? and $id_rol = ?;';
        $query = $this->db->query($sql, array($codigo, $id_rol));
        return $query->row_array();
    }

    public function get_roles_acceso($id_opcion_sistema) {
        // Devuelve roles con acceso a una opción
        $sql = 'select acs.id_rol, r.nombre from acceso_sistema acs left join opcion_sistema ops on ops.codigo = acs.codigo left join rol r on r.id_rol = acs.id_rol where ops.id_opcion_sistema = ?';
        $query = $this->db->query($sql, array($id_opcion_sistema));
        return $query->result_array();
    }

    public function guardar($data, $id_acceso_sistema)
    {
        if ($id_acceso_sistema) {
            $this->db->where('id_acceso_sistema', $id_acceso_sistema);
            $this->db->update('acceso_sistema', $data);
            $id = $id_acceso_sistema;
        } else {
            $this->db->insert('acceso_sistema', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_acceso_sistema)
    {
        $this->db->where('id_acceso_sistema', $id_acceso_sistema);
        $result = $this->db->delete('acceso_sistema');
        return $result;
    }

}
