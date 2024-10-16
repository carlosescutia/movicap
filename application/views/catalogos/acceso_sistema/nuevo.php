<form method="post" action="<?= base_url() ?>acceso_sistema/guardar">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-md-10">
                <h2>Nuevo acceso al sistema</h2>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="area-contenido col-md-12">
        <div class="form-group row">
            <label for="codigo" class="col-sm-2 col-form-label">Opción</label>
            <div class="col-sm-3">
                <select class="form-select" name="codigo" id="codigo">
                    <?php foreach ($opciones_sistema as $opciones_sistema_item) { ?>
                        <option value="<?= $opciones_sistema_item['codigo'] ?>" ><?= $opciones_sistema_item['codigo'] ?> <?= $opciones_sistema_item['nombre'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="id_rol" class="col-sm-2 col-form-label">Rol</label>
            <div class="col-sm-3">
                <select class="form-select" name="id_rol" id="id_rol">
                    <?php foreach ($roles as $roles_item) { ?>
                        <option value="<?= $roles_item['id_rol'] ?>" ><?= $roles_item['nombre'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</form>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>acceso_sistema" class="btn btn-secondary">Volver</a>
    </div>
</div>
