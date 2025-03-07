<div class="area-contenido">
    <div class="col-12">
        <form method="post" action="<?= base_url() ?>seccion/guardar/<?= $seccion['id_seccion'] ?>">
            <div class="pt-3 pb-2 ps-2 mb-3 bg-primary-subtle border-bottom border-primary-subtle">
                <div class="row">
                    <div class="col-9">
                        <h2>Editar seccion</h2>
                    </div>
                    <div class="col-2 text-end">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="form-group row">
                    <label for="nom_seccion" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nom_seccion" id="nom_seccion" value="<?=$seccion['nom_seccion'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="orden" class="col-sm-2 col-form-label">Orden</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="orden" id="orden" value="<?=$seccion['orden'] ?>">
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_cuestionario" value="<?=$seccion['id_cuestionario']?>">
        </form>
    </div>

    <div class="col-12 col-sm-8 offset-sm-1 mt-5">
        <?php include "pregunta_lista.php" ?>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
    <a href="<?=base_url()?>cuestionario/detalle/<?=$seccion['id_cuestionario']?>" class="btn btn-secondary">Volver</a>
    </div>
</div>
