<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h2>Organizaciones</h2>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>organizacion/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-10">
            <div class="row">
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-5 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($organizaciones as $organizaciones_item) { ?>
        <div class="col-10 alternate-color">
            <div class="row">
                <div class="col-2 align-self-center">
                    <p><a href="<?=base_url()?>organizacion/detalle/<?=$organizaciones_item['id_organizacion']?>"><?= $organizaciones_item['id_organizacion'] ?></a></p>
                </div>
                <div class="col-5 align-self-center">
                    <p><a href="<?=base_url()?>organizacion/detalle/<?=$organizaciones_item['id_organizacion']?>"><?= $organizaciones_item['nom_organizacion'] ?></a></p>
                </div>
                <div class="col-1">
                    <?php 
                    $item_eliminar = $organizaciones_item['id_organizacion'] . ' ' . $organizaciones_item['nom_organizacion']; 
                    $url = base_url() . "organizacion/eliminar/". $organizaciones_item['id_organizacion']; 
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
