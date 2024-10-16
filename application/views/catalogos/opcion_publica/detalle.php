<form method="post" action="<?= base_url() ?>opcion_publica/guardar/<?= $opcion_publica['id_opcion_publica'] ?>">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-md-10">
                <h1 class="h2">Editar opcion</h1>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="area-contenido">
        <div class="form-group row">
            <label for="orden" class="col-sm-2 col-form-label">Orden</label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="orden" id="orden" value="<?=$opcion_publica['orden'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$opcion_publica['nombre'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="url" class="col-sm-2 col-form-label">Url</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="url" id="url" value="<?=$opcion_publica['url'] ?>">
            </div>
        </div>
    </div>
</form>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>opcion_publica" class="btn btn-secondary">Volver</a>
    </div>
</div>
