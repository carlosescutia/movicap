<div class="my-3 pb-2 border-bottom">
    <?php if ($num_registros_importados > 0 ) { ?>
        <div class="col-sm-4 alert alert-primary alert-dismissible fade show text-center pb-0" role="alert">
            <p>Se importaron <?= $num_registros_importados ?> registros</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <div class="col-12 col-sm-6 mb-3">
        <form method="post" name="frm_set_proyecto_activo" action="<?= base_url() ?>proyecto/set_proyecto_activo">
            <select class="form-select form-select-lg text-primary-emphasis bg-success-subtle" name="proyecto_activo" id="proyecto_activo" onchange="frm_set_proyecto_activo.submit()">
                <?php foreach ($cuestionarios as $cuestionarios_item) { ?>
                    <option value="<?=$cuestionarios_item['id_cuestionario']?>" <?= $cuestionarios_item['id_cuestionario'] == $proyecto_activo ? 'selected' : '' ?> ><?=$cuestionarios_item['nom_cuestionario']?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="previous_url" value="<?= current_url() ?>">
        </form>
    </div>

    <div class="col-12 col-sm-6">
        <div class="row">
            <div class="col-auto me-auto mt-1">
                <h6><?= $cuestionario['lugar'] ?> - (<?= $cuestionario['fecha'] ?>)</h6>
            </div>
            <?php
                $permisos_requeridos = array(
                'cuestionario.can_download',
                );
                if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                    <div class="col-auto">
                        <form method="post" action="<?= base_url() ?>reportes/capturas_cuestionario/">
                            <input type="hidden" name="id_cuestionario" value="<?=$cuestionario['id_cuestionario']?>">
                            <input type="hidden" name="salida" value="csv">
                            <button type="submit" class="btn btn-success btn-sm">csv del proyecto</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form method="post" action="<?= base_url() ?>reportes/fotos_cuestionario/">
                            <input type="hidden" name="id_cuestionario" value="<?=$cuestionario['id_cuestionario']?>">
                            <input type="hidden" name="salida" value="csv">
                            <button type="submit" class="btn btn-success btn-sm">fotos</button>
                        </form>
                    </div>
                <?php }
            ?>
        </div>
    </div>

</div>

<form method="post" action="<?= base_url() ?>captura/nuevo" id="frm_captura">
    <?php date_default_timezone_set("America/Mexico_City"); ?>
    <input type="hidden" name="id_cuestionario" value="<?= $cuestionario['id_cuestionario'] ?>">
    <input type="hidden" name="fecha" value="<?= date('Y-m-d') ?>">
    <input type="hidden" name="hora" value="<?= date('H:i') ?>">
    <input type="hidden" name="lat" value="21">
    <input type="hidden" name="lon" value="-101">
</form>

<form method="post" action="<?= base_url() ?>reportes/csv_machote/" id="frm_csv_machote">
    <input type="hidden" name="id_cuestionario" value="<?=$cuestionario['id_cuestionario']?>">
    <input type="hidden" name="salida" value="csv">
</form>

<form method="post" enctype="multipart/form-data" action="<?=base_url()?>archivo/subir" id="frm_cargar_csv">
    <?php 
        $nombre_archivo = 'import.csv';
        $dir_docs = 'doc/';
        $tipo_archivo = 'csv';
        $url_actual = base_url() . 'proyecto';
        $descripcion = 'Importar capturas: ';
    ?>
    <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
    <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
    <input type="hidden" name="tipo_archivo" value="<?=$tipo_archivo?>">
    <input type="hidden" name="url_actual" value="<?=$url_actual?>">
    <input type="hidden" name="descripcion" value="<?=$descripcion?>">
</form>

<div class="area-contenido col-12 col-sm-6">
    <?php if ($error) { ?>
        <div class="col-12 text-danger">
            <p><?= $error ?></p>
        </div>
    <?php } ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="mapa-tab" data-bs-toggle="tab" data-bs-target="#mapa-tab-pane" type="button" role="tab" aria-controls="mapa-tab-pane" aria-selected="true"><i class="bi bi-globe-americas"></i></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tabla-tab" data-bs-toggle="tab" data-bs-target="#tabla-tab-pane" type="button" role="tab" aria-controls="tabla-tab-pane" aria-selected="false"><i class="bi bi-table"></i></button>
        </li>
        <?php
            $permisos_requeridos = array(
            'captura.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                <div class="col-auto ms-auto">
                    <div class="row justify-content-end">
                        <div class="col-auto ms-auto">
                            <button type="submit" class="btn btn-secondary btn-sm" form="frm_csv_machote">machote csv</button>
                            <label tabindex="0" name="btn_sel_csv" id="btn_sel_csv" class="btn btn-secondary btn-sm">seleccionar csv
                                <input name="subir_archivo" id="subir_archivo" type="file" class="d-none" onchange="$('#btn_up_csv').removeClass('d-none'); $('#btn_sel_csv').addClass('d-none');" form="frm_cargar_csv">
                            </label>
                            <button id="btn_up_csv" type="submit" class="btn btn-success btn-sm d-none" form="frm_cargar_csv">subir csv</button>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm" form="frm_captura">Capturar</button>
                        </div>
                    </div>
                </div>
            <?php }
        ?>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active my-3" id="mapa-tab-pane" role="tabpanel" aria-labelledby="mapa-tab" tabindex="0">
            <div id="map_capturas" style="height: 400px">
            </div>
        </div>
        <div class="tab-pane fade" id="tabla-tab-pane" role="tabpanel" aria-labelledby="tabla-tab" tabindex="0">
            <div class="align-self-center my-3">
                <table id="tbl_capturas" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">capturista</th>
                            <th scope="col">fecha</th>
                            <th scope="col">hora</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($capturas as $capturas_item) { ?>
                            <tr>
                                <td>
                                    <?php
                                        $permisos_requeridos = array(
                                        'captura.can_view',
                                        );
                                        if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                            <a href="<?= base_url() ?>captura/detalle/<?= $capturas_item['id_captura']?>">
                                        <?php }
                                    ?>
                                    <?= $capturas_item['capturista'] ?>
                                    <?php if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                        </a>
                                    <?php } ?>
                                </td>
                                <td><?= date('d/m/y', strtotime($capturas_item['fecha_captura'])) ?></td>
                                <td><?= date('H:i', strtotime($capturas_item['hora_captura'])) ?></td>
                                <?php
                                    $permisos_requeridos = array(
                                    'captura.can_edit',
                                    );
                                ?>
                                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                    <?php 
                            $item_eliminar = $capturas_item['id_captura'] ." " . $capturas_item['capturista'] . " " . date('d/m/y', strtotime($capturas_item['fecha_captura'])) . " " . date('H:i', strtotime($capturas_item['hora_captura'])) ;
                                        $url = base_url() . "captura/eliminar/". $capturas_item['id_captura']; 
                                    ?>
                                    <td><a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></a></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php 
        $nombre_archivo = 'import.csv';
        $dir_docs = 'doc/';
        $nombre_archivo_fs = $dir_docs . $nombre_archivo;
        $url_actual = base_url() . 'proyecto';
    ?>
    <?php if ( file_exists($nombre_archivo_fs) ) { ?>
        <form method="post" action="<?= base_url() ?>archivo/eliminar/" id="frm_cancelar_csv">
            <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
            <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
            <input type="hidden" name="url_actual" value="<?=$url_actual?>">
        </form>

        <form method="post" action="<?= base_url() ?>captura/importar_csv/" id="frm_importar_csv">
            <input type="hidden" name="id_cuestionario" value="<?= $cuestionario['id_cuestionario'] ?>">
            <input type="hidden" name="nombre_archivo" value="<?=$nombre_archivo?>">
            <input type="hidden" name="dir_docs" value="<?=$dir_docs?>">
            <input type="hidden" name="fecha" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="hora" value="<?= date('H:i') ?>">
            <input type="hidden" name="lat" value="21">
            <input type="hidden" name="lon" value="-101">
        </form>

        <hr>
        <div class="col mb-5">
            <div class="row">
                <div class="col-auto me-auto">
                    <h5>Datos del archivo a importar:</h5>
                </div>
                <div class="col-auto mb-2">
                    <button type="submit" class="btn btn-danger btn-sm" form="frm_cancelar_csv">cancelar</button>
                    <button type="submit" class="btn btn-success btn-sm" form="frm_importar_csv">importar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm">
                        <tbody>
                            <?php
                                $contador = 0;
                                $file = fopen($nombre_archivo_fs, "r");
                                while(!feof($file) and $contador < 4) {
                                    $contador += 1;
                                    $linea = fgetcsv($file, 0, "\t");
                                    if ( $linea and !is_null($linea[0]) ) { 
                                        $campos = explode(',', $linea[0]); ?>
                                            <tr>
                                                <td><?= $campos[0] ?></td>
                                                <td><?= $campos[1] ?></td>
                                                <td><?= $campos[2] ?></td>
                                                <td><?= $campos[3] ?></td>
                                                <td> ...</td>
                                            </tr>
                                    <?php } 
                                }
                                fclose($file);
                            ?>
                                            <tr>
                                                <td> ...</td>
                                                <td> ...</td>
                                                <td> ...</td>
                                                <td> ...</td>
                                                <td> ...</td>
                                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<hr />

<script type="text/javascript">
    $(document).ready( function () {
        $('#tbl_capturas').DataTable( {
            language: {
                url: '<?=base_url()?>js/es-MX.json',
            },
        });
    });

    // crear mapa en el div "map_capturas"
    var map_capturas = L.map('map_capturas', {
        center: new L.LatLng(21, -101),
        zoom: 8,
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: 'topleft'
        }
    });

    // crear layer openstreetmap
    var backgUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    backgAttrib = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
    var backg_lyr = L.tileLayer(backgUrl, {maxZoom: 18, attribution: backgAttrib});

    // agregar layer openstreetmap a map_capturas
    map_capturas.addLayer(backg_lyr);

    // mostrar capturas
    if (typeof markers !== 'undefined') {
        map_capturas.removeLayer(markers);
    }

    var markers = L.markerClusterGroup();

    id_cuestionario = <?= $cuestionario['id_cuestionario'] ?>;
    uri = "<?=base_url()?>captura/get_layer/" + id_cuestionario;
    $.get(uri, function( data ) {
        var datos = JSON.parse(JSON.parse(data));
        capturas_layer = new L.GeoJSON(datos, { 
            onEachFeature: function(feature, layer){
                layer.bindPopup(feature.properties.nom_usuario + '<br>' + feature.properties.fecha + ' ' + feature.properties.hora),
                layer.on({
                    click: function(e) {
                        url = '<?= base_url() ?>' + 'captura/detalle/' + feature.properties.id_captura.toString();
                        window.open(url, '_self');
                    }
                });
            }
        });
        //markers.addLayer(capturas_layer);
        map_capturas.addLayer(capturas_layer);
        map_capturas.fitBounds(capturas_layer.getBounds(), {padding: [30,30]});
    });

    //map_capturas.addLayer(markers);
</script>
