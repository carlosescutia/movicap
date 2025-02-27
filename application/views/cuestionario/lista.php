<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h2>Cuestionarios</h2>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>cuestionario/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <?php foreach ($cuestionarios as $cuestionarios_item) { ?>
        <div class="row">
            <div class="col-12 pt-3 pb-2 mb-3 align-self-center bg-success-subtle">
                <div class="row">
                    <div class="col-9 align-self-center">
                        <div class="row">
                            <div class="col-sm-auto">
                                <h4>
                                    <a href="<?=base_url()?>cuestionario/detalle/<?=$cuestionarios_item['id_cuestionario']?>"><?= $cuestionarios_item['nom_cuestionario'] ?></a>
                                    -
                                    <?= $cuestionarios_item['lugar'] ?>
                                    <small>(<?= date('d/m/y', strtotime($cuestionarios_item['fecha'])) ?>)</small>
                                </h4>
                            </div>
                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-2 col-sm-4">
                                        <form method="post" action="<?= base_url() ?>reportes/capturas_cuestionario/">
                                            <input type="hidden" name="id_cuestionario" value="<?=$cuestionarios_item['id_cuestionario']?>">
                                            <input type="hidden" name="salida" value="csv">
                                            <button type="submit" class="btn btn-success btn-sm">csv</button>
                                        </form>
                                    </div>
                                    <div class="col-2 col-sm-4">
                                        <form method="post" action="<?= base_url() ?>reportes/fotos_cuestionario/">
                                            <input type="hidden" name="id_cuestionario" value="<?=$cuestionarios_item['id_cuestionario']?>">
                                            <input type="hidden" name="salida" value="csv">
                                            <button type="submit" class="btn btn-success btn-sm">fotos</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 text-end">
                        <form method="post" action="<?= base_url() ?>captura/nuevo">
                            <input type="hidden" name="id_cuestionario" value="<?= $cuestionarios_item['id_cuestionario'] ?>">
                            <input type="hidden" name="id_usuario" value="1">
                            <input type="hidden" name="fecha" value="<?= date('Y-m-d') ?>">
                            <input type="hidden" name="lat" value="21.008110">
                            <input type="hidden" name="lon" value="-101.506989">
                            <button type="submit" class="btn btn-primary btn-sm">Capturar</button>
                        </form>
                    </div>
                    <div class="col-1 mt-1 text-end">
                        <?php 
                        $item_eliminar = $cuestionarios_item['id_cuestionario'] . ' ' . $cuestionarios_item['nom_cuestionario']; 
                        $url = base_url() . "cuestionario/eliminar/". $cuestionarios_item['id_cuestionario']; 
                        ?>
                        <p><a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                        </a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9 align-self-center">
                <ul>
                <?php foreach ($capturas as $capturas_item) { ?>
                    <?php if ($capturas_item['id_cuestionario'] == $cuestionarios_item['id_cuestionario']) { ?>
                        <li><a href="<?= base_url() ?>captura/detalle/<?= $capturas_item['id_captura']?>"><?= $capturas_item['id_captura'] ?> - <?= $capturas_item['id_cuestionario'] ?> - <?= $capturas_item['id_usuario'] ?> - <?= $capturas_item['fecha'] ?></a></li>
                    <?php } ?>
                <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
    </div>
</div>
