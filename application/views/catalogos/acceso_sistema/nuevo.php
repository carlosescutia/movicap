<form method="post" action="<?= base_url() ?>acceso_sistema/guardar">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-9">
                <h2>Nuevo acceso al sistema</h2>
            </div>
            <div class="col-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="area-contenido col-12">
        <div class="form-group row">
            <label for="cod_opcion_sistema" class="col-sm-2 col-form-label">Opción</label>
            <div class="col-sm-3">
                <select class="form-select" name="cod_opcion_sistema" id="cod_opcion_sistema">
                    <?php foreach ($opciones_sistema as $opciones_sistema_item) { ?>
                        <option value="<?= $opciones_sistema_item['cod_opcion_sistema'] ?>" ><?= $opciones_sistema_item['cod_opcion_sistema'] ?> <?= $opciones_sistema_item['nom_opcion_sistema'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="id_rol" class="col-sm-2 col-form-label">Rol</label>
            <div class="col-sm-3">
                <select class="form-select" name="id_rol" id="id_rol">
                    <?php foreach ($roles as $roles_item) { ?>
                        <option value="<?= $roles_item['id_rol'] ?>" ><?= $roles_item['nom_rol'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</form>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>acceso_sistema" class="btn btn-secondary">Volver</a>
    </div>
</div>
