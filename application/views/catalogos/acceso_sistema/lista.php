<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h1 class="h2">Accesos al sistema</h1>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>acceso_sistema/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-5 align-self-center">
                    <p class="small"><strong>Opción</strong></p>
                </div>
                <div class="col-3 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-3 align-self-center">
                    <p class="small"><strong>Rol</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($ed_accesos_sistema as $accesos_sistema_item) { ?>
            <div class="col-12 alternate-color">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <p><?= $accesos_sistema_item['cod_opcion_sistema'] ?></p>
                    </div>
                    <div class="col-3 align-self-center">
                        <p><?= $accesos_sistema_item['nom_opcion_sistema'] ?></p>
                    </div>
                    <div class="col-3 align-self-center">
                        <p><?= $accesos_sistema_item['nom_rol'] ?></p>
                    </div>
                    <div class="col-1 align-self-center">
                        <?php 
                        $item_eliminar = $accesos_sistema_item['cod_opcion_sistema'] . " " . $accesos_sistema_item['nom_opcion_sistema'] . " - " . $accesos_sistema_item['nom_rol'] ;
                        $url = base_url() . "acceso_sistema/eliminar/". $accesos_sistema_item['id_acceso_sistema']; 
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
