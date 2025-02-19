<div class="area-contenido">
    <div class="col-12">
        <form method="post" action="<?= base_url() ?>pregunta/guardar/<?= $pregunta['id_pregunta'] ?>">
            <div class="pt-3 pb-2 ps-2 mb-3 bg-success-subtle border-bottom border-success-subtle">
                <div class="row">
                    <div class="col-9">
                        <h2>Editar pregunta</h2>
                    </div>
                    <div class="col-2 text-end">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="form-group row">
                    <label for="texto" class="col-sm-2 col-form-label">Texto</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="texto" id="texto" value="<?=$pregunta['texto'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cve_tipo_pregunta" class="col-sm-2 col-form-label">Tipo de pregunta</label>
                    <div class="col-sm-2">
                        <select class="form-select" name="cve_tipo_pregunta" id="cve_tipo_pregunta">
                            <?php foreach ($tipos_pregunta as $tipos_pregunta_item) { ?>
                            <option value="<?= $tipos_pregunta_item['cve_tipo_pregunta'] ?>" <?= $tipos_pregunta_item['cve_tipo_pregunta'] == $pregunta['cve_tipo_pregunta'] ? 'selected' : '' ?> ><?= $tipos_pregunta_item['nom_tipo_pregunta'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="orden" class="col-sm-2 col-form-label">Orden</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="orden" id="orden" value="<?=$pregunta['orden'] ?>">
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_seccion" value="<?=$pregunta['id_seccion']?>">
        </form>
    </div>
    <?php if ($pregunta['cve_tipo_pregunta'] == 'op_multiple') { ?>
        <div class="col-12 col-sm-8 offset-sm-1 mt-5">
            <?php include "valor_posible_lista.php" ?>
        </div>
    <?php } ?>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
    <a href="<?=base_url()?>seccion/detalle/<?=$pregunta['id_seccion']?>" class="btn btn-secondary">Volver</a>
    </div>
</div>

