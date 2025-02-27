<?php
class Captura_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('directory');
    }

    public function get_capturas() {
        $sql = 'select * from captura order by id_cuestionario, fecha;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_capturas_cuestionario($id_cuestionario, $salida=null)
    {
        // lista de archivos de fotos del cuestionario existentes
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
        $sql = "select distinct cst.id_cuestionario, cst.nom_cuestionario, cst.fecha as fecha_cuestionario, cst.lugar, cap.id_captura, cap.fecha as fecha_captura, ";
        foreach ($preguntas as $preguntas_item) {
            $orig_valor = '';
            $tabla_adicional = '';
            switch ($preguntas_item['cve_tipo_pregunta']) {
                case 'abierta':
                    $sql .= ''
                        .'(select '
                        .'r2.valor as "' . $preguntas_item['texto'] . '" '
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
                        .'vp.texto as "' . $preguntas_item['texto'] . '" '
                        .'from '
                        .'respuesta r2 '
                        .'left join valor_posible vp on vp.id_pregunta = r2.id_pregunta and vp.valor = r2.valor '
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
                        .'in (' . $lista_fotos_cuestionario . ') then \'ft_\' || c.id_captura::text || \'_\' || p.id_pregunta::text || \'.jpg\' '
                        .'else \'\' end) as "'. $preguntas_item['texto'] . '" '
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
            ."where  "
            ."cap.id_cuestionario = ? "
            ."";
        $query = $this->db->query($sql, array($id_cuestionario));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function get_fotos_cuestionario($id_cuestionario)
    {
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
            .'order by '
            .'c.id_captura, s.orden, p.orden '
            .'';
        $query = $this->db->query($sql, array($id_cuestionario));
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
        $sql = 'select * from captura where id_captura = ?;';
        $query = $this->db->query($sql, array($id_captura));
        return $query->row_array();
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

    public function eliminar($id_captura)
    {
        $this->db->where('id_captura', $id_captura);
        $result = $this->db->delete('captura');
    }

}

