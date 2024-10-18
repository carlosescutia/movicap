<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-sm-10 text-start">
            <h2 class="h2">Roles</h2>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-3 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-sm-8 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($roles as $roles_item) { ?>
        <div class="col-sm-7 alternate-color mx-2">
            <div class="row">
                <div class="col-sm-3 align-self-center">
                    <p><?= $roles_item['id_rol'] ?></p>
                </div>
                <div class="col-sm-8 align-self-center">
                    <p><?= $roles_item['nom_rol'] ?></p>
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
