<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-left">
                    <h1 class="h2">Opciones</h1>
                </div>
                <div class="col-sm-2 text-right">
                    <form method="post" action="<?= base_url() ?>opcion_publica/nuevo">
                        <button type="submit" class="btn btn-primary">Nuevo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div style="min-height: 46vh">
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
                <div class="col-sm-7 alternate-color">
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
                            $item_eliminar = $opciones_publicas_item['orden'] . " " . $opciones_publicas_item['nombre'] ;
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
    </div>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</main>
