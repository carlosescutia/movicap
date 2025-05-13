<div class="area-contenido">
    <div class="col-12">
        <form method="post" action="<?= base_url() ?>valor_posible/guardar/<?= $valor_posible['id_valor_posible'] ?>">
            <div class="pt-3 pb-2 ps-2 mb-3 bg-dark-subtle border-bottom border-success-subtle">
                <div class="row">
                    <div class="col-9">
                        <h2>Editar valor posible</h2>
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
                        <input type="text" class="form-control" name="texto" id="texto" value="<?=$valor_posible['texto'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="valor" class="col-sm-2 col-form-label">Valor</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="valor" id="valor" value="<?=$valor_posible['valor'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="orden" class="col-sm-2 col-form-label">Orden</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="orden" id="orden" value="<?=$valor_posible['orden'] ?>">
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_pregunta" value="<?=$valor_posible['id_pregunta']?>">
        </form>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
    <a href="<?=base_url()?>pregunta/detalle/<?=$valor_posible['id_pregunta']?>" class="btn btn-secondary">Volver</a>
    </div>
</div>
