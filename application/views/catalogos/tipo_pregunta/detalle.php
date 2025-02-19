<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9">
            <h1 class="h2">Detalle de tipo de pregunta</h1>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="form-group row">
        <label for="id_tipo_pregunta" class="col-sm-2 col-form-label">Clave</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="id_tipo_pregunta" id="id_tipo_pregunta" value="<?=$tipo_pregunta['id_tipo_pregunta'] ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="nom_tipo_pregunta" class="col-sm-2 col-form-label">Nombre</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="nom_tipo_pregunta" id="nom_tipo_pregunta" value="<?=$tipo_pregunta['nom_tipo_pregunta'] ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="orden" class="col-sm-2 col-form-label">Orden</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="orden" id="orden" value="<?=$tipo_pregunta['orden'] ?>">
        </div>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>parametro_sistema" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
