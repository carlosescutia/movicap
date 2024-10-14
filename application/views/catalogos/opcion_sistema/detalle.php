<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>opcion_sistema/guardar/<?= $opcion_sistema['id_opcion_sistema'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar opcion</h1>
                </div>
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_opcion_sistema" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_opcion_sistema" id="id_opcion_sistema" value="<?=$opcion_sistema['id_opcion_sistema'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="codigo" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="codigo" id="codigo" value="<?=$opcion_sistema['codigo'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$opcion_sistema['nombre'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Url</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="url" id="url" value="<?=$opcion_sistema['url'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="es_menu" class="col-sm-2 col-form-label">Es menú?</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="es_menu" id="es_menu" value="<?=$opcion_sistema['es_menu'] ?>">
                </div>
            </div>
        </div>

    </form>


    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>opcion_sistema" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>

