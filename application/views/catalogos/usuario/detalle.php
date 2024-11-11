<form method="post" action="<?= base_url() ?>usuario/guardar/<?= $usuario['id_usuario'] ?>">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-9">
                <h2 class="h2">Editar usuario</h2>
            </div>
            <div class="col-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="col-12 mb-5">
        <div class="form-group row">
            <label for="id_usuario" class="col-sm-2 col-form-label">Clave</label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="nom_usuario" id="id_usuario" value="<?=$usuario['id_usuario'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nom_usuario" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="nom_usuario" id="nom_usuario" value="<?=$usuario['nom_usuario'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="usuario" id="usuario" value="<?=$usuario['usuario'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="password" id="password" value="<?=$usuario['password'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="id_organizacion" class="col-sm-2 col-form-label">organizacion</label>
            <div class="col-sm-3">
                <select class="form-select" name="id_organizacion" id="id_organizacion">
                    <?php foreach ($organizaciones as $organizaciones_item) { ?>
                    <option value="<?= $organizaciones_item['id_organizacion'] ?>" <?= ($usuario['id_organizacion'] == $organizaciones_item['id_organizacion']) ? 'selected' : '' ?> ><?= $organizaciones_item['nom_organizacion'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="id_rol" class="col-sm-2 col-form-label">Rol</label>
            <div class="col-sm-3">
                <select class="form-select" name="id_rol" id="id_rol">
                    <?php foreach ($roles as $roles_item) { ?>
                    <option value="<?= $roles_item['id_rol'] ?>" <?= ($usuario['id_rol'] == $roles_item['id_rol']) ? 'selected' : '' ?> ><?= $roles_item['nom_rol'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="activo" class="col-sm-2 col-form-label">Activo</label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="activo" id="activo" value="<?=$usuario['activo'] ?>">
            </div>
        </div>
    </div>
</form>

<div class="col-12">
    <div class="row">
        <div class="col-sm-4 offset-sm-1">
            <?php include 'permisos_rol.php' ?>
        </div>
        <div class="col-sm-4 offset-sm-1">
            <?php include 'permisos_usuario.php' ?>
        </div>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>usuario" class="btn btn-secondary">Volver</a>
    </div>
</div>
