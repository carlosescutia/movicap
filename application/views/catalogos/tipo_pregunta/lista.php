<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h1 class="h2">Tipos de preguntas</h1>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>tipo_pregunta/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-12 col-sm-8">
            <div class="row">
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-6 col-sm-4 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-2 align-self-center text-center">
                    <p class="small"><strong>Orden</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($tipos_pregunta as $tipos_pregunta_item) { ?>
            <div class="col-12 col-sm-8 alternate-color">
                <div class="row">
                    <div class="col-2 align-self-center">
                        <p><a href="<?=base_url()?>tipo_pregunta/detalle/<?=$tipos_pregunta_item['id_tipo_pregunta']?>"><?= $tipos_pregunta_item['id_tipo_pregunta'] ?></a></p>
                    </div>
                    <div class="col-6 col-sm-4 align-self-center">
                        <p><a href="<?=base_url()?>tipo_pregunta/detalle/<?=$tipos_pregunta_item['id_tipo_pregunta']?>"><?= $tipos_pregunta_item['nom_tipo_pregunta'] ?></a></p>
                    </div>
                    <div class="col-2 align-self-center text-center">
                        <p><?= $tipos_pregunta_item['orden'] ?></a></p>
                    </div>
                    <div class="col-1 align-self-center">
                        <?php 
                        $item_eliminar = $tipos_pregunta_item['id_tipo_pregunta'] . " " . $tipos_pregunta_item['nom_tipo_pregunta']; 
                        $url = base_url() . "tipo_pregunta/eliminar/". $tipos_pregunta_item['id_tipo_pregunta']; 
                        ?>
                        <p><a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                        </a></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-10">
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
