<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>usuarios/guardar/<?= $usuarios['cve_usuario'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar usuario</h1>
                </div>
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="cve_usuario" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cve_usuario" id="cve_usuario" value="<?=$usuarios['cve_usuario'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_usuario" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_usuario" id="nom_usuario" value="<?=$usuarios['nom_usuario'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="usuario" id="usuario" value="<?=$usuarios['usuario'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="password" id="password" value="<?=$usuarios['password'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="cve_organizacion" class="col-sm-2 col-form-label">organizacion</label>
                <div class="col-sm-3">
                    <select class="form-select" name="cve_organizacion" id="cve_organizacion">
                        <?php foreach ($organizaciones as $organizaciones_item) { ?>
                        <option value="<?= $organizaciones_item['cve_organizacion'] ?>" <?= ($usuarios['cve_organizacion'] == $organizaciones_item['cve_organizacion']) ? 'selected' : '' ?> ><?= $organizaciones_item['nom_organizacion'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cve_rol" class="col-sm-2 col-form-label">Rol</label>
                <div class="col-sm-3">
                    <select class="form-select" name="cve_rol" id="cve_rol">
                        <?php foreach ($roles as $roles_item) { ?>
                        <option value="<?= $roles_item['cve_rol'] ?>" <?= ($usuarios['cve_rol'] == $roles_item['cve_rol']) ? 'selected' : '' ?> ><?= $roles_item['nom_rol'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="activo" class="col-sm-2 col-form-label">Activo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="activo" id="activo" value="<?=$usuarios['activo'] ?>">
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>usuarios" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>

