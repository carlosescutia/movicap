<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h2>Opciones del sistema</h2>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>opcion_sistema/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-4 align-self-center">
                    <p class="small"><strong>Código</strong></p>
                </div>
                <div class="col-3 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-1 align-self-center">
                    <p class="small"><strong>Otorgable</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($opciones_sistema as $opciones_sistema_item) { ?>
        <div class="col-12 alternate-color">
            <div class="row">
                <div class="col-2 align-self-center">
                    <p><a href="<?=base_url()?>opcion_sistema/detalle/<?=$opciones_sistema_item['id_opcion_sistema']?>"><?= $opciones_sistema_item['id_opcion_sistema'] ?></a></p>
                </div>
                <div class="col-4 align-self-center">
                    <p><a href="<?=base_url()?>opcion_sistema/detalle/<?=$opciones_sistema_item['id_opcion_sistema']?>"><?= $opciones_sistema_item['cod_opcion_sistema'] ?></a></p>
                </div>
                <div class="col-3 align-self-center">
                    <p><?= $opciones_sistema_item['nom_opcion_sistema'] ?></p>
                </div>
                <div class="col-1 align-self-center text-center">
                    <p><?= $opciones_sistema_item['otorgable'] ?></p>
                </div>
                <div class="col-1 align-self-center">
                    <?php 
                    $item_eliminar = $opciones_sistema_item['id_opcion_sistema'] . " " . $opciones_sistema_item['cod_opcion_sistema'] . " " . $opciones_sistema_item['nom_opcion_sistema'] ;
                    $url = base_url() . "opcion_sistema/eliminar/". $opciones_sistema_item['id_opcion_sistema']; 
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
