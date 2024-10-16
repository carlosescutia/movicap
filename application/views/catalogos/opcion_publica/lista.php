<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-sm-10 text-start">
            <h1 class="h2">Opciones</h1>
        </div>
        <div class="col-sm-2 text-end">
            <form method="post" action="<?= base_url() ?>opcion_publica/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-2 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-sm-2 align-self-center">
                    <p class="small"><strong>Orden</strong></p>
                </div>
                <div class="col-sm-4 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-sm-3 align-self-center">
                    <p class="small"><strong>Url</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($opciones_publicas as $opciones_publicas_item) { ?>
            <div class="col-sm-7 alternate-color mx-2">
                <div class="row">
                    <div class="col-sm-2 align-self-center">
                        <p><?= $opciones_publicas_item['id_opcion_publica'] ?></p>
                    </div>
                    <div class="col-sm-2 align-self-center">
                        <p><?= $opciones_publicas_item['orden'] ?></p>
                    </div>
                    <div class="col-sm-4 align-self-center">
                        <p><a href="<?=base_url()?>opcion_publica/detalle/<?=$opciones_publicas_item['id_opcion_publica']?>"><?= $opciones_publicas_item['nombre'] ?></a></p>
                    </div>
                    <div class="col-sm-3 align-self-center">
                        <p><?= $opciones_publicas_item['url'] ?></p>
                    </div>
                    <div class="col-sm-1">
                        <?php 
                            $item_eliminar = $opciones_publicas_item['id_opcion_publica'] . " " . $opciones_publicas_item['orden'] . " " . $opciones_publicas_item['nombre'] ;
                            $url = base_url() . "opcion_publica/eliminar/". $opciones_publicas_item['id_opcion_publica']; 
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
    <div class="col-sm-10">
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
    </div>
</div>
