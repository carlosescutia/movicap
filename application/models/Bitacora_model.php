<?php
class Bitacora_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function guardar($data)
    {
        $result = $this->db->insert('bitacora', $data);
        return $result;
    }

    public function get_bitacora($usuario, $nom_organizacion, $cve_rol, $accion, $entidad)
    {
        if ($cve_rol == 'sup') {
            $usuario = '%';
        }
        if ($cve_rol == 'adm') {
            $usuario = '%';
            $nom_organizacion = '%';
        }
        $sql = "select b.* from bitacora b where b.usuario LIKE ? and b.nom_organizacion LIKE ? ";
        if ($cve_rol !== 'adm') {
            $sql .= " and b.usuario not in (select usuario from usuarios where cve_rol = 'adm')";
        }
        $parametros = array();
        array_push($parametros, "$usuario");
        array_push($parametros, "$nom_organizacion");
        if ($accion <> "") {
            $sql .= ' and b.accion = ?';
            array_push($parametros, "$accion");
        } 
        if ($entidad <> "") {
            $sql .= ' and b.entidad = ?';
            array_push($parametros, "$entidad");
        } 
        $sql .= ' order by b.cve_evento desc;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

}
