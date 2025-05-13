<div class="area-contenido">
    <form method="post" action="<?= base_url() ?>cuestionario/guardar/<?= $cuestionario['id_cuestionario'] ?>">
        <div class="my-3 pb-2 border-bottom">
            <div class="row">
                <div class="col-9">
                    <h2>Editar proyecto</h2>
                </div>
                <div class="col-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div>
            <div class="form-group row">
                <label for="id_cuestionario" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" name="id_cuestionario" id="id_cuestionario" value="<?=$cuestionario['id_cuestionario'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_cuestionario" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nom_cuestionario" id="nom_cuestionario" value="<?=$cuestionario['nom_cuestionario'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="lugar" class="col-sm-2 col-form-label">Lugar</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="lugar" id="lugar" value="<?=$cuestionario['lugar'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="fecha" id="fecha" value="<?=$cuestionario['fecha'] ?>">
                </div>
            </div>
        </div>
    </form>

    <div class="col-12 mt-5">
        <div class="row">
            <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                <?php include "seccion_lista.php" ?>
            </div>
            <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                <?php include "cuestionario_usuario.php" ?>
            </div>
        </div>
    </div>

</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>cuestionario" class="btn btn-secondary">Volver</a>
    </div>
</div>
