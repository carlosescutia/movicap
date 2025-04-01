<?php
class Respuesta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_respuestas() {
        $sql = 'select * from respuesta order by id_respuesta;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_respuestas_captura($id_captura) {
        $sql = 'select * from respuesta where id_captura = ?';
        $query = $this->db->query($sql, array($id_captura));
        return $query->result_array();
    }

    public function get_respuestas_calculo($id_captura, $salida=null) {
        // obtener lista de preguntas del cuestionario
        $sql = ""
            ."select "
            ."p.* "
            ."from "
            ."pregunta p "
            ."left join seccion s on s.id_seccion = p.id_seccion "
            ."left join cuestionario c on c.id_cuestionario = s.id_cuestionario "
            ."left join captura cap on cap.id_cuestionario = c.id_cuestionario "
            ."where "
            ."cap.id_captura = ? "
            ."order by  "
            ."s.id_seccion, p.orden "
            ."";
        $query = $this->db->query($sql, array($id_captura));
        $preguntas = $query->result_array();

        // query final 
        $sql = ""
            ."select distinct cst.id_cuestionario, cst.nom_cuestionario, cst.fecha as fecha_cuestionario, "
            ."cst.lugar, cap.id_captura, u.nom_usuario as capturista, cap.fecha as fecha_captura, cap.hora as hora_captura, ";
        foreach ($preguntas as $preguntas_item) {
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
            }
        }
        $sql .= "cap.lat, cap.lon "
            ."from  "
            ."captura cap "
            ."left join respuesta r on r.id_captura = cap.id_captura "
            ."left join cuestionario cst on cst.id_cuestionario = cap.id_cuestionario "
            ."left join usuario u on u.id_usuario = cap.id_usuario "
            ."where  "
            ."cap.id_captura = ? "
            ."order by "
            ."cap.fecha desc, cap.hora desc "
            ."";
        $query = $this->db->query($sql, array($id_captura));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->row_array();
        }
    }

    public function get_respuesta($id_respuesta) {
        $sql = 'select * from respuesta where id_respuesta = ?;';
        $query = $this->db->query($sql, array($id_respuesta));
        return $query->row_array();
    }

    public function get_respuesta_captura_pregunta($id_captura, $id_pregunta) {
        $sql = 'select * from respuesta where id_captura = ? and id_pregunta = ?';
        $query = $this->db->query($sql, array($id_captura, $id_pregunta));
        return $query->row_array();
    }

    public function guardar($data, $id_respuesta)
    {
        if ($id_respuesta) {
            $this->db->where('id_respuesta', $id_respuesta);
            $this->db->update('respuesta', $data);
            $id = $id_respuesta;
        } else {
            $this->db->insert('respuesta', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_respuesta)
    {
        $this->db->where('id_respuesta', $id_respuesta);
        $result = $this->db->delete('respuesta');
    }

}
