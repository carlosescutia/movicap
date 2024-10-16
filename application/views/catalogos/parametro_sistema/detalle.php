<form method="post" action="<?= base_url() ?>parametro_sistema/guardar/<?= $parametro_sistema['id_parametro_sistema'] ?>">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-md-10">
                <h1 class="h2">Editar parámetro del sistema</h1>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="area-contenido">
        <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Parámetro</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$parametro_sistema['nombre'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="valor" class="col-sm-2 col-form-label">Valor</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="valor" id="valor" value="<?=$parametro_sistema['valor'] ?>">
            </div>
        </div>
    </div>
</form>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>parametro_sistema" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
