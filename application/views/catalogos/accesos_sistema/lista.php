<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-10 text-left">
                    <h1 class="h2">Accesos al sistema</h1>
                </div>
                <div class="col-sm-2 text-right">
                    <form method="post" action="<?= base_url() ?>accesos_sistema/nuevo">
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
                            <p class="small"><strong>Opción</strong></p>
                        </div>
                        <div class="col-sm-5 align-self-center">
                            <p class="small"><strong>Rol</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($accesos_sistema as $accesos_sistema_item) { ?>
                <div class="col-sm-7 alternate-color">
                    <div class="row">
                        <div class="col-sm-2 align-self-center">
                            <p><?= $accesos_sistema_item['cve_acceso'] ?></p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <p><?= $accesos_sistema_item['cod_opcion'] ?> <?= $accesos_sistema_item['nom_opcion'] ?></p>
                        </div>
                        <div class="col-sm-5 align-self-center">
                            <p><?= $accesos_sistema_item['nom_rol'] ?></p>
                        </div>
                        <div class="col-sm-1">
                            <?php 
                            $item_eliminar = $accesos_sistema_item['cod_opcion'] . " " . $accesos_sistema_item['nom_opcion'] . " - " . $accesos_sistema_item['nom_rol'] ;
                            $url = base_url() . "accesos_sistema/eliminar/". $accesos_sistema_item['cve_acceso']; 
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
