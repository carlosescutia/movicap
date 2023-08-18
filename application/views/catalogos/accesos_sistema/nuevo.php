<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>accesos_sistema/guardar">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Nuevo acceso al sistema</h1>
                </div>
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="cod_opcion" class="col-sm-2 col-form-label">Opción</label>
                <div class="col-sm-3">
                    <select class="form-select" name="cod_opcion" id="cod_opcion">
                        <?php foreach ($opciones_sistema as $opciones_sistema_item) { ?>
                        <option value="<?= $opciones_sistema_item['cod_opcion'] ?>" ><?= $opciones_sistema_item['cod_opcion'] ?> <?= $opciones_sistema_item['nom_opcion'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cve_rol" class="col-sm-2 col-form-label">Rol</label>
                <div class="col-sm-3">
                    <select class="form-select" name="cve_rol" id="cve_rol">
                        <?php foreach ($roles as $roles_item) { ?>
                        <option value="<?= $roles_item['cve_rol'] ?>" ><?= $roles_item['nom_rol'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>accesos_sistema" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
