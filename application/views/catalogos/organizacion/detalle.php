<form method="post" action="<?= base_url() ?>organizacion/guardar/<?= $organizacion['id_organizacion'] ?>">
    <div class="my-3 pb-2 border-bottom">
        <div class="row">
            <div class="col-md-10">
                <h2>Editar organizacion</h2>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

    <div class="area-contenido">
        <div class="form-group row">
            <label for="id_organizacion" class="col-sm-2 col-form-label">Clave</label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="id_organizacion" id="id_organizacion" value="<?=$organizacion['id_organizacion'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="nom_organizacion" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="nom_organizacion" id="nom_organizacion" value="<?=$organizacion['nom_organizacion'] ?>">
            </div>
        </div>
    </div>
</form>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>organizacion" class="btn btn-secondary">Volver</a>
    </div>
</div>
