<div class="area-contenido">
    <form method="post" action="<?= base_url() ?>respuesta/guardar/" id="frm_captura">
        <input type="hidden" name="id_captura" value="<?= $captura['id_captura'] ?>" >
        <input type="hidden" name="lat" id="lat" value="<?= $captura['lat'] ?>" >
        <input type="hidden" name="lon" id="lon" value="<?= $captura['lon'] ?>" >
    </form>
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-10">
                <h2 id="titulo">Editar captura</h2>
                <h6><?= $captura['nom_usuario'] ?> - <?= date('d/m/y', strtotime($captura['fecha'])) ?> <?= date('H:i', strtotime($captura['hora'])) ?></h6>
            </div>
            <?php
                $permisos_requeridos = array(
                'captura.can_edit',
                );
                if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                    <div class="col-1 text-end">
                        <button type="submit" class="btn btn-primary btn-sm" form="frm_captura">Guardar</button>
                    </div>
                <?php }
            ?>
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

    <div class="offcanvas offcanvas-end offcanvas-size-sm" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group">
                <button 
                    class="list-group-item list-group-item-action active" 
                    id="tab-ubicacion" 
                    data-bs-toggle="tab" 
                    data-bs-target="#panel-ubicacion" 
                    type="button" 
                    role="tab" 
                    aria-controls="panel-ubicacion" 
                    aria-selected="true"
                    onclick="update_titulo('Ubicación')"
                >
                    Ubicación
                </button>
                <?php foreach ($secciones as $secciones_item) { ?>
                    <button 
                        class="list-group-item list-group-item-action" 
                        id="tab-<?= $secciones_item['id_seccion'] ?>" 
                        data-bs-toggle="tab" 
                        data-bs-target="#panel-<?= $secciones_item['id_seccion'] ?>" 
                        type="button" 
                        role="tab" 
                        aria-controls="panel-<?= $secciones_item['id_seccion'] ?>" 
                        aria-selected="false"
                        onclick="update_titulo('<?= $secciones_item['nom_seccion'] ?>')"
                    >
                        <?= $secciones_item['nom_seccion'] ?> 
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12" id="area1">
            <div class="d-none d-sm-block col-12">
                <ul class="nav nav-tabs rounded bg-success-subtle" id="tabs-secciones" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button 
                            class="nav-link active" 
                            id="tab-ubicacion" 
                            data-bs-toggle="tab" 
                            data-bs-target="#panel-ubicacion" 
                            type="button" 
                            role="tab" 
                            aria-controls="panel-ubicacion" 
                            aria-selected="true"
                            onclick="update_titulo('Ubicación')"
                        >
                            Ubicación
                        </button>
                    </li>
                    <?php foreach ($secciones as $secciones_item) { ?>
                    <li class="nav-item" role="presentation">
                        <button 
                            class="nav-link" 
                            id="tab-<?= $secciones_item['id_seccion'] ?>" 
                            data-bs-toggle="tab" 
                            data-bs-target="#panel-<?= $secciones_item['id_seccion'] ?>" 
                            type="button" 
                            role="tab" 
                            aria-controls="panel-<?= $secciones_item['id_seccion'] ?>" 
                            aria-selected="false"
                            onclick="update_titulo('<?= $secciones_item['nom_seccion'] ?>')"
                        >
                            <?= $secciones_item['nom_seccion'] ?> 
                        </button>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-content mx-0 mx-sm-3 my-3" id="panes-secciones">
                <div 
                    class="tab-pane fade show active" 
                    id="panel-ubicacion" 
                    role="tabpanel" 
                    aria-labelledby="tab-ubicacion" 
                    tabindex="0"
                >
                    <div class="card col-12 col-sm-3">
                        <div class="card-header">
                            Ubicación:
                            <label id="lbl_lat"><?=number_format($captura['lat'], 6) ?></label>,
                            <label id="lbl_lon"><?=number_format($captura['lon'],6) ?></label>
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 180px">
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-success" onclick="get_coords();">Detectar</button>
                        </div>
                    </div>
                </div>
                <?php foreach ($secciones as $secciones_item) { ?>
                    <div 
                        class="tab-pane fade" 
                        id="panel-<?= $secciones_item['id_seccion'] ?>" 
                        role="tabpanel" 
                        aria-labelledby="tab-<?= $secciones_item['id_seccion'] ?>" 
                        tabindex="0" >
                        <?php foreach ($preguntas as $preguntas_item) { ?>
                            <?php if($preguntas_item['id_seccion'] == $secciones_item['id_seccion']) { ?>
                                <?php
                                    $valor = '';
                                    foreach ($respuestas as $respuestas_item) {
                                        if ($respuestas_item['id_pregunta'] == $preguntas_item['id_pregunta']) {
                                            $valor = $respuestas_item['valor'];
                                            $id_respuesta = $respuestas_item['id_respuesta'];
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
                                                    <option value="" <?= $valor == "" ? 'selected' : '' ?> ></option>
                                                    <?php foreach ($valores_posibles as $valores_posibles_item) { ?>
                                                        <?php if ($valores_posibles_item['id_pregunta'] == $preguntas_item['id_pregunta'] ) { ?>
                                                            <option value="<?= $valores_posibles_item['id_valor_posible'] ?>" <?= $valores_posibles_item['id_valor_posible'] == $valor ? 'selected' : '' ?> ><?= $valores_posibles_item['texto'] ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <?php break; ?>
                                    <?php case 'calculo': ?>
                                        <div class="form-group row">
                                            <?php
                                                $exp1 = str_replace('{', '$resp_calc["', $preguntas_item['expresion']);
                                                $finalexp = str_replace('}', '"]', $exp1);
                                                eval('$result = '.$finalexp.';');
                                            ?>
                                            <label for="p_<?=$preguntas_item['id_pregunta']?>"><?= $preguntas_item['texto'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $preguntas_item['expresion'] ?></label>
                                            <div class="col-12">
                                                <input type="text" class="form-control" name="p_<?=$preguntas_item['id_pregunta']?>" id="p_<?=$preguntas_item['id_pregunta']?>" value="<?= $result ?>" disabled>
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

                                                    <?php
                                                        $permisos_requeridos = array(
                                                        'captura.can_edit',
                                                        );
                                                        if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
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
                                                                <?php if ( file_exists($nombre_archivo_fs) ) { 
                                                                    $item_eliminar = $nombre_archivo; ?>
                                                                    &nbsp;
                                                                    <a href="#dlg_borrar_archivo" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                                                <?php } ?>
                                                            </form>
                                                        <?php }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php break; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
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
    var map = L.map('map', {
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: 'topleft'
        }
    });

    // crear layer openstreetmap
    var backgUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    backgAttrib = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
    var backg_lyr = L.tileLayer(backgUrl, {maxZoom: 18, attribution: backgAttrib});

    // agregar layer openstreetmap a mapa
    map.addLayer(backg_lyr);
    var curr_position = L.marker();
    curr_position.addTo(map)

    // actualizar coordenadas al hacer click en el mapa
    function onMapClick(e) {
        lati = e.latlng.lat.toFixed(7);
        longi = e.latlng.lng.toFixed(7);
        update_position(lati,longi);
    }
    map.on('click', onMapClick);

    function update_position(lati,longi) {
        new_position = new L.LatLng(lati, longi);
        curr_position.setLatLng(new_position);
        $("#lat").attr('value',lati);
        $("#lon").attr('value',longi);
        $("#lbl_lat").html(lati);
        $("#lbl_lon").html(longi);
        map.setView(new_position, 15);
    }

    function update_titulo(titulo) {
        $("#titulo").html(titulo);
        return offcanvas.hide();
    }

    $(document).ready(function(){
        lati = $("#lat").attr('value');
        longi = $("#lon").attr('value');
        update_position(lati,longi);

        offcanvasElement = document.getElementById("offcanvasExample");
        offcanvas = new bootstrap.Offcanvas(offcanvasElement);

    });

    // Swipe support 
    var initialTouchX, initialTouchY, finalTouchX, finalTouchY;
    var swipeThreshold = 75; 

    function handleTouch(startX, endX, onSwipeLeft, onSwipeRight) {
        var horizontalDistance = finalTouchX - initialTouchX;
        var verticalDistance = finalTouchY - initialTouchY;

        if (Math.abs(horizontalDistance) > Math.abs(verticalDistance) && Math.abs(horizontalDistance) > swipeThreshold) {
            if (finalTouchX - initialTouchX < 0) {
                onSwipeLeft(); 
            } else {
                onSwipeRight(); 
            }
        }
    }

    var swipeLeft = () => {
        return offcanvas.toggle();
    };

    var swipeRight = () => {
        return offcanvas.hide();
    };

    window.onload = function () {
        window.addEventListener ('touchstart', function (event) {
            initialTouchX = event.touches[0].clientX;
            initialTouchY = event.touches[0].clientY;
        });

        window.addEventListener ('touchend', function (event) {
            finalTouchX = event.changedTouches[0].clientX;
            finalTouchY = event.changedTouches[0].clientY;

            handleTouch(initialTouchX, finalTouchX, swipeLeft, swipeRight);
        });
    };
    // Swipe support 

    function get_coords() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                lati = position.coords.latitude;
                longi = position.coords.longitude;
                update_position(lati,longi);
            });
        } else {
            console.log("no se puede obtener ubicacion");
        }
    }


</script>
