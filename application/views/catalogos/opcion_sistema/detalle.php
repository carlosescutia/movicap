<form method="post" action="<?= base_url() ?>opcion_sistema/guardar/<?= $opcion_sistema['id_opcion_sistema'] ?>">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-md-10">
                <h2>Editar opcion</h2>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-5">
        <div class="form-group row">
            <label for="codigo" class="col-sm-2 col-form-label">Código</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="codigo" id="codigo" value="<?=$opcion_sistema['codigo'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$opcion_sistema['nombre'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="otorgable" class="col-sm-2 col-form-label">Otorgable</label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="otorgable" id="otorgable" value="<?=$opcion_sistema['otorgable'] ?>">
            </div>
        </div>
    </div>
</form>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-4 offset-md-1">
            <?php include 'roles_acceso.php' ?>
        </div>
        <div class="col-md-4 offset-md-1">
            <?php include 'usuarios_acceso.php' ?>
        </div>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>opcion_sistema" class="btn btn-secondary">Volver</a>
    </div>
</div>
