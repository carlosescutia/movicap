<div class="area-contenido">
    <form method="post" action="<?= base_url() ?>respuesta/guardar/" id="frm_captura">
        <input type="hidden" name="id_captura" value="<?= $captura['id_captura'] ?>" >
    </form>
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-9">
                <h2>Editar captura</h2>
            </div>
            <div class="col-2 text-end">
                <button type="submit" class="btn btn-primary" form="frm_captura">Guardar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 text-end">
                <div class="row text-danger">
                    <?php if ($error) {
                    echo $error;
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
        <?php foreach ($secciones as $secciones_item) { ?>
            <h4><?= $secciones_item['nom_seccion'] ?></h4>
            <div class="col-12 col-sm-11 offset-sm-1 mb-5">
                <div class="row">
                    <?php foreach ($preguntas as $preguntas_item) { ?>
                        <?php if($preguntas_item['id_seccion'] == $secciones_item['id_seccion']) { ?>
                            <?php
                                $valor = '';
                                foreach ($respuestas as $respuestas_item) {
                                    if ($respuestas_item['id_pregunta'] == $preguntas_item['id_pregunta']) {
                                        $valor = $respuestas_item['valor'];
                                    }
                                }
                            ?>
                            <?php switch ($preguntas_item['cve_tipo_pregunta']) { 
                                case 'abierta': ?>
                                    <div class="form-group row">
                                        <label for="p_<?=$preguntas_item['id_pregunta']?>"><?= $preguntas_item['texto'] ?></label>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="p_<?=$preguntas_item['id_pregunta']?>" id="p_<?=$preguntas_item['id_pregunta']?>" value="<?= $valor ?>" form="frm_captura">
                                        </div>
                                    </div>
                                    <?php break; ?>
                                <?php case 'op_multiple': ?>
                                    <div class="form-group row">
                                        <label for="p_<?=$preguntas_item['id_pregunta']?>"><?= $preguntas_item['texto'] ?></label>
                                        <div class="col-12 col-sm-4">
                                            <select class="form-select" name="p_<?=$preguntas_item['id_pregunta']?>" id="p_<?=$preguntas_item['id_pregunta']?>" form="frm_captura">
                                                <?php foreach ($valores_posibles as $valores_posibles_item) { ?>
                                                    <?php if ($valores_posibles_item['id_pregunta'] == $preguntas_item['id_pregunta'] ) { ?>
                                                        <option value="<?= $valores_posibles_item['valor'] ?>" <?= $valores_posibles_item['valor'] == $valor ? 'selected' : '' ?> ><?= $valores_posibles_item['texto'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                                </select>
                                            </div>
                                    </div>
                                    <?php break; ?>
                                <?php case 'foto': ?>
                                    <div class="col-6 col-sm-4 offset-sm-0 mb-3">
                                        <div class="card">
                                            <?php
                                                $prefijo = 'ft' ;
                                                $tipo_archivo = 'jpg';
                                                $nombre_archivo = $prefijo . '_' . $captura['id_captura'] . '_' . $preguntas_item['id_pregunta'] . '.' . $tipo_archivo;
                                                $dir_docs = './doc/';
                                                $url_actual = base_url() . 'captura/detalle/' . $captura['id_captura'] ;
                                                $nom_archivo = $preguntas_item['id_pregunta'];
                                                $descripcion = $nombre_archivo;
                                                $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                                                $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                                                $selector_archivo = 'sel_arch_' . $nom_archivo ;
                                            ?>
                                            <?php if ( file_exists($nombre_archivo_fs) ) { ?>
                                                <img src="<?= $nombre_archivo_url ?>" class="card-img-top img-fluid">
                                            <?php } ?>
                                            <div class="card-body text-center">
                                                <p class="card-text text-start"><?= $preguntas_item['texto'] ?></p>

                                                <form method="post" enctype="multipart/form-data" action="<?=base_url()?>archivo/subir" id="frm_foto">
                                                    <label tabindex="0" name="btn_sel_<?=$nom_archivo?>" id="btn_sel_<?=$nom_archivo?>"><i class="bi bi-camera-fill boton-archivo-sm"></i>
                                                        <input name="subir_archivo" id="<?=$selector_archivo?>" type="file" accept="image/*" capture="environment" class="d-none" onchange="$('#btn_subir_<?=$nom_archivo?>').removeClass('d-none'); $('#btn_sel_<?=$nom_archivo?>').addClass('d-none');">
                                                    </label>
                                                    <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
                                                    <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
                                                    <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
                                                    <input type="hidden" name="url_actual" value="<?=$url_actual?>">
                                                    <input type="hidden" name="descripcion" value="<?=$descripcion?>">
                                                    <input type="hidden" name="selector_archivo" value="<?=$selector_archivo?>">

                                                    <button id="btn_subir_<?=$nom_archivo?>" type="submit" class="btn btn-sm d-none" style="background: none; color: #28A745">
                                                        <i class="bi bi-upload boton-subir-sm"></i>
                                                    </button>
                                                </form>
                                                <?php if ( file_exists($nombre_archivo_fs) ) { 
                                                    $item_eliminar = $nombre_archivo; ?>
                                                    &nbsp;
                                                    <a href="#dlg_borrar_archivo" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php break; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>

        <div class="col-sm-3">
            <div class="form-group row">
                <label> <?=$captura['fecha'] ?> - <?=$captura['lat'] ?>, <?=$captura['lon'] ?></label>
            </div>
            <div id="map" style="height: 180px">
            </div>
        </div>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>cuestionario" class="btn btn-secondary">Volver</a>
    </div>
</div>

<script type="text/javascript">
    // crear mapa en el div "map"
    var map = L.map('map');

    // crear layer openstreetmap
    var backgUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    backgAttrib = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
    var backg_lyr = L.tileLayer(backgUrl, {maxZoom: 18, attribution: backgAttrib});                        

    // agregar layer openstreetmap a mapa
    map.addLayer(backg_lyr);
    var curr_position = L.marker();

    $(document).ready(function(){
        lati = <?= $captura['lat'] ?> ;
        longi = <?= $captura['lon'] ?> ;
        new_position = new L.LatLng(lati, longi);
        curr_position.setLatLng(new_position);
        curr_position.addTo(map)
        map.setView(new_position, 15);
    });
</script>
