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
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-1 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-4 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Lugar</strong></p>
                </div>
                <div class="col-3 align-self-center">
                    <p class="small"><strong>Fecha</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($cuestionarios as $cuestionarios_item) { ?>
        <div class="col-12 alternate-color">
            <div class="row">
                <div class="col-1 align-self-center">
                    <p><a href="<?=base_url()?>cuestionario/detalle/<?=$cuestionarios_item['id_cuestionario']?>"><?= $cuestionarios_item['id_cuestionario'] ?></a></p>
                </div>
                <div class="col-4 align-self-center">
                    <p><a href="<?=base_url()?>cuestionario/detalle/<?=$cuestionarios_item['id_cuestionario']?>"><?= $cuestionarios_item['nom_cuestionario'] ?></a></p>
                </div>
                <div class="col-2 align-self-center">
                    <p><?= $cuestionarios_item['lugar'] ?></p>
                </div>
                <div class="col-3 align-self-center">
                    <p><?= $cuestionarios_item['fecha'] ? date('d/m/Y', strtotime($cuestionarios_item['fecha'])) : '' ?></p>
                </div>
                <div class="col-1">
                    <?php 
                    $item_eliminar = $cuestionarios_item['id_cuestionario'] . ' ' . $cuestionarios_item['nom_cuestionario']; 
                    $url = base_url() . "cuestionario/eliminar/". $cuestionarios_item['id_cuestionario']; 
                    ?>
                    <p><a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                    </a></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
    </div>
</div>
