<?php
class Captura_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('directory');
    }

    public function get_capturas() {
        $sql = 'select c.*, u.nom_usuario from captura c left join usuario u on u.id_usuario = c.id_usuario order by fecha desc, id_cuestionario desc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_capturas_usuario($id_usuario, $id_rol) {
        if ($id_rol == 'adm' or $id_rol=='sup') {
            $id_usuario = '%';
        }
        $sql = ''
            .'select '
            .'c.*, u.nom_usuario '
            .'from '
            .'captura c '
            .'left join usuario u on u.id_usuario = c.id_usuario '
            .'where '
            .'c.id_usuario::text like ? '
            .'order by '
            .'fecha desc, id_cuestionario desc'
            .'';
        $query = $this->db->query($sql, array($id_usuario));
        return $query->result_array();
    }

    public function get_capturas_cuestionario($id_cuestionario, $id_usuario, $id_rol, $salida=null)
    {
        if ($id_rol == 'adm' or $id_rol=='sup') {
            $id_usuario = '%';
        }

        $sql = ""
            ."select distinct cst.id_cuestionario, cst.nom_cuestionario, cst.fecha as fecha_cuestionario, "
            ."cst.lugar, cap.id_captura, u.nom_usuario as capturista, cap.fecha as fecha_captura, cap.hora as hora_captura, "
            ."cap.lat, cap.lon "
            ."from  "
            ."captura cap "
            ."left join respuesta r on r.id_captura = cap.id_captura "
            ."left join cuestionario cst on cst.id_cuestionario = cap.id_cuestionario "
            ."left join usuario u on u.id_usuario = cap.id_usuario "
            ."where  "
            ."cap.id_cuestionario = ? "
            ."and cap.id_usuario::text like ? "
            ."order by "
            ."cap.fecha desc, cap.hora desc "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario, $id_usuario));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function get_capturas_cuestionario_csv($id_cuestionario, $id_usuario, $id_rol, $salida=null)
    {
        if ($id_rol == 'adm' or $id_rol=='sup') {
            $id_usuario = '%';
        }
        // lista de archivos de fotos del cuestionario existentes
        $sql = ''
            .'select '
            .'c.id_captura, p.id_pregunta, u.nom_usuario '
            .'from  '
            .'captura c  '
            .'left join usuario u on u.id_usuario = c.id_usuario '
            .'left join seccion s on s.id_cuestionario = c.id_cuestionario  '
            .'left join pregunta p on p.id_seccion = s.id_seccion  '
            .'where  '
            .'p.cve_tipo_pregunta = \'foto\' '
            .'and c.id_cuestionario = ? '
            .'order by '
            .'c.id_captura, s.orden, p.orden '
            .'';
        $query = $this->db->query($sql, array($id_cuestionario));
        $lista_fotos_posibles = $query->result_array();

        $prefijo = 'ft' ;
        $tipo_archivo = 'jpg';
        $dir_docs = './doc/';
        $lista_fotos_array = [];
        foreach ($lista_fotos_posibles as $foto) {
            $identificador = $foto['id_captura'] . '_' . $foto['id_pregunta'] ;
            $nombre_archivo = $prefijo . '_' . $identificador . '.' . $tipo_archivo;
            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
            if ( file_exists($nombre_archivo_fs) ) { 
                array_push($lista_fotos_array, '\''.$identificador.'\'');
            }
        }
        $lista_fotos_cuestionario = implode(',', $lista_fotos_array);
        if (empty($lista_fotos_cuestionario)) {
            $lista_fotos_cuestionario = '\'none\'';
        }

        // obtener lista de preguntas del cuestionario
        $sql = ""
            ."select  "
            ."p.*  "
            ."from  "
            ."pregunta p  "
            ."left join seccion s on s.id_seccion = p.id_seccion  "
            ."where  "
            ."s.id_cuestionario = ? "
            ."order by  "
            ."s.id_seccion, p.orden "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario));
        $preguntas = $query->result_array();

        // query final para obtener el csv
        $url = base_url() . 'doc/';
        $sql = ""
            ."select distinct cst.id_cuestionario, cst.nom_cuestionario, cst.fecha as fecha_cuestionario, "
            ."cst.lugar, cap.id_captura, u.nom_usuario as capturista, cap.fecha as fecha_captura, cap.hora as hora_captura, ";
        foreach ($preguntas as $preguntas_item) {
            $orig_valor = '';
            $tabla_adicional = '';
            switch ($preguntas_item['cve_tipo_pregunta']) {
                case 'abierta':
                    $sql .= ''
                        .'(select '
                        .'r2.valor as "' . $preguntas_item['nom_pregunta'] . '" '
                        .'from '
                        .'respuesta r2 '
                        .'where '
                        .'r2.id_captura = cap.id_captura '
                        .'and r2.id_pregunta = ' . $preguntas_item['id_pregunta'] 
                        .'), '
                        .'';
                    break;
                case 'op_multiple':
                    $sql .= ''
                        .'(select '
                        .'vp.valor as "' . $preguntas_item['nom_pregunta'] . '" '
                        .'from '
                        .'respuesta r2 '
                        .'left join valor_posible vp on vp.id_pregunta = r2.id_pregunta and vp.id_valor_posible = r2.valor::integer '
                        .'where '
                        .'r2.id_captura = cap.id_captura '
                        .'and r2.id_pregunta = ' . $preguntas_item['id_pregunta'] 
                        .'), '
                        .'';
                    break;
                case 'foto':
                    $sql .= ''
                        .'(select '
                        .'(case when c.id_captura::text || \'_\' || p.id_pregunta::text '
                        .'in (' . $lista_fotos_cuestionario . ') then \'' . $url . 'ft_\' || c.id_captura::text || \'_\' || p.id_pregunta::text || \'.jpg\' '
                        .'else \'\' end) as "'. $preguntas_item['nom_pregunta'] . '" '
                        .'from  '
                        .'captura c  '
                        .'left join seccion s on s.id_cuestionario = c.id_cuestionario  '
                        .'left join pregunta p on p.id_seccion = s.id_seccion  '
                        .'where  '
                        .'p.cve_tipo_pregunta = \'foto\' '
                        .'and c.id_cuestionario = cap.id_cuestionario '
                        .'and c.id_captura = cap.id_captura '
                        .'and p.id_pregunta = ' . $preguntas_item['id_pregunta']
                        .'), ';
                    break;
            }
        }
        $sql .= "cap.lat, cap.lon "
            ."from  "
            ."captura cap "
            ."left join respuesta r on r.id_captura = cap.id_captura "
            ."left join cuestionario cst on cst.id_cuestionario = cap.id_cuestionario "
            ."left join usuario u on u.id_usuario = cap.id_usuario "
            ."where  "
            ."cap.id_cuestionario = ? "
            ."and cap.id_usuario::text like ? "
            ."order by "
            ."cap.fecha desc, cap.hora desc "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario, $id_usuario));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function get_fotos_cuestionario($id_cuestionario, $id_usuario, $id_rol)
    {
        if ($id_rol == 'adm' or $id_rol=='sup') {
            $id_usuario = '%';
        }
        $sql = ''
            .'select '
            .'c.id_captura, p.id_pregunta '
            .'from  '
            .'captura c  '
            .'left join seccion s on s.id_cuestionario = c.id_cuestionario  '
            .'left join pregunta p on p.id_seccion = s.id_seccion  '
            .'where  '
            .'p.cve_tipo_pregunta = \'foto\' '
            .'and c.id_cuestionario = ? '
            .'and c.id_usuario::text like ? '
            .'order by '
            .'c.id_captura, s.orden, p.orden '
            .'';
        $query = $this->db->query($sql, array($id_cuestionario, $id_usuario));
        $lista_fotos = $query->result_array();

        $prefijo = 'ft' ;
        $tipo_archivo = 'jpg';
        $dir_docs = './doc/';
        $lista_fotos_cuestionario = [];
        foreach ($lista_fotos as $foto) {
            $nombre_archivo = $prefijo . '_' . $foto['id_captura'] . '_' . $foto['id_pregunta'] . '.' . $tipo_archivo;
            $nombre_archivo_fs = $dir_docs . $nombre_archivo;
            if ( file_exists($nombre_archivo_fs) ) { 
                array_push($lista_fotos_cuestionario, $nombre_archivo_fs);
            }
        }
        return $lista_fotos_cuestionario;
    }


    public function get_captura($id_captura) {
        $sql = 'select c.*, u.nom_usuario from captura c left join usuario u on u.id_usuario = c.id_usuario where id_captura = ?;';
        $query = $this->db->query($sql, array($id_captura));
        return $query->row_array();
    }

    public function get_capturas_cuestionario_encabezado($id_cuestionario, $id_usuario, $id_rol, $salida=null)
    {
        // obtener lista de preguntas del cuestionario
        $sql = ""
            ."select  "
            ."p.*  "
            ."from  "
            ."pregunta p  "
            ."left join seccion s on s.id_seccion = p.id_seccion  "
            ."where  "
            ."s.id_cuestionario = ? "
            ."order by  "
            ."s.id_seccion, p.orden "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario));
        $preguntas = $query->result_array();

        // query final para obtener el csv
        $sql = ""
            ."select "
            ."";
        foreach ($preguntas as $preguntas_item) {
            $orig_valor = '';
            $tabla_adicional = '';
            switch ($preguntas_item['cve_tipo_pregunta']) {
                case 'abierta':
                    $sql .= ''
                        .'(select '
                        .'r2.valor as "' . $preguntas_item['nom_pregunta'] . '" '
                        .'from '
                        .'respuesta r2 '
                        .'where '
                        .'r2.id_pregunta = ' . $preguntas_item['id_pregunta'] 
                        .'), '
                        .'';
                    break;
                case 'op_multiple':
                    $sql .= ''
                        .'(select '
                        .'vp.valor as "' . $preguntas_item['nom_pregunta'] . '" '
                        .'from '
                        .'respuesta r2 '
                        .'left join valor_posible vp on vp.id_pregunta = r2.id_pregunta and vp.id_valor_posible = r2.valor::integer '
                        .'where '
                        .'r2.id_pregunta = ' . $preguntas_item['id_pregunta'] 
                        .'), '
                        .'';
                    break;
            }
        }
        $sql .= "cap.lat, cap.lon "
            ."from  "
            ."captura cap "
            ."where  "
            ."false "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario, $id_usuario));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function guardar($data, $id_captura)
    {
        if ($id_captura) {
            $this->db->where('id_captura', $id_captura);
            $this->db->update('captura', $data);
            $id = $id_captura;
        } else {
            $this->db->insert('captura', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function get_layer($id_cuestionario, $id_usuario, $id_rol)
    {
        if ($id_rol == 'adm' or $id_rol=='sup') {
            $id_usuario = '%';
        }
        $sql = "SELECT row_to_json(fc) FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features FROM ( SELECT 'Feature' As type, ST_AsGeoJSON(c.geom, 4)::json As geometry, row_to_json((SELECT l FROM (SELECT c.id_captura, c.fecha, c.hora, u.nom_usuario) As l )) As properties FROM captura As c left join usuario u on u.id_usuario = c.id_usuario where c.id_cuestionario = ? and c.id_usuario::text like ? ) As f ) As fc;";
        $query = $this->db->query($sql, array($id_cuestionario, $id_usuario));
        $result = $query->result_array();
        return $result[0]['row_to_json'];
    }

    public function eliminar($id_captura)
    {
        $this->db->where('id_captura', $id_captura);
        $result = $this->db->delete('captura');
    }

}

