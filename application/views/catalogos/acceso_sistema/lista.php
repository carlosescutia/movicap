<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-sm-10 text-start">
            <h1 class="h2">Accesos al sistema</h1>
        </div>
        <div class="col-sm-2 text-end">
            <form method="post" action="<?= base_url() ?>acceso_sistema/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-4 align-self-center">
                    <p class="small"><strong>Opción</strong></p>
                </div>
                <div class="col-sm-4 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-sm-2 align-self-center">
                    <p class="small"><strong>Rol</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($ed_accesos_sistema as $accesos_sistema_item) { ?>
            <div class="col-sm-10 alternate-color mx-2">
                <div class="row">
                    <div class="col-sm-4 align-self-center">
                        <p><?= $accesos_sistema_item['codigo'] ?></p>
                    </div>
                    <div class="col-sm-4 align-self-center">
                        <p><?= $accesos_sistema_item['nom_opcion'] ?></p>
                    </div>
                    <div class="col-sm-2 align-self-center">
                        <p><?= $accesos_sistema_item['nom_rol'] ?></p>
                    </div>
                    <div class="col-sm-1">
                        <?php 
                        $item_eliminar = $accesos_sistema_item['codigo'] . " " . $accesos_sistema_item['nom_opcion'] . " - " . $accesos_sistema_item['nom_rol'] ;
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
    <div class="col-sm-10">
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
    </div>
</div>
