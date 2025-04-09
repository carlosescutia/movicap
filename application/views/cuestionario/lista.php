<div class="my-3 pb-2 border-bottom">
    <div class="row justify-content-between mb-3">
        <div class="col-9 col-sm-6 align-middle">
            <form method="post" name="frm_set_cuestionario_activo" action="<?= base_url() ?>cuestionario/set_cuestionario_activo">
                <select class="form-select form-select-lg text-primary-emphasis bg-success-subtle" name="cuestionario_activo" id="cuestionario_activo" onchange="frm_set_cuestionario_activo.submit()">
                    <?php foreach ($cuestionarios as $cuestionarios_item) { ?>
                        <option value="<?=$cuestionarios_item['id_cuestionario']?>" <?= $cuestionarios_item['id_cuestionario'] == $cuestionario_activo ? 'selected' : '' ?> ><?=$cuestionarios_item['nom_cuestionario']?></option>
                    <?php } ?>
                </select>
                <input type="hidden" name="previous_url" value="<?= current_url() ?>">
            </form>
        </div>
        <div class="col col-sm-2 text-end mt-1">
            <?php
                $permisos_requeridos = array(
                'cuestionario.can_edit',
                );
                if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                    <form method="post" action="<?= base_url() ?>cuestionario/nuevo">
                        <button type="submit" class="btn btn-primary">Nuevo</button>
                    </form>
                <?php }
            ?>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-auto mt-1">
                <h5>
                    <?php
                        $permisos_requeridos = array(
                        'cuestionario.can_edit',
                        );
                        if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                            <a href="<?=base_url()?>cuestionario/detalle/<?=$cuestionario['id_cuestionario']?>">
                        <?php } ?>
                        <?= $cuestionario['lugar'] ?> - (<?= $cuestionario['fecha'] ?>)
                        <?php if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                            </a>
                    <?php } ?>
                </h5>
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
                            <button type="submit" class="btn btn-success btn-sm">csv</button>
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

<div class="area-contenido col-12 col-sm-6">
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
                <div class="col-9 text-end">
                    <form method="post" action="<?= base_url() ?>captura/nuevo">
                        <?php date_default_timezone_set("America/Mexico_City"); ?>
                        <input type="hidden" name="id_cuestionario" value="<?= $cuestionario['id_cuestionario'] ?>">
                        <input type="hidden" name="id_usuario" value="1">
                        <input type="hidden" name="fecha" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="hora" value="<?= date('H:i') ?>">
                        <input type="hidden" name="lat" value="21">
                        <input type="hidden" name="lon" value="-101">
                        <button type="submit" class="btn btn-primary btn-sm">Capturar</button>
                    </form>
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
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">capturista</th>
                            <th scope="col">fecha</th>
                            <th scope="col">hora</th>
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
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
    </div>
</div>

<script type="text/javascript">
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

    function onClick(e) {
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
