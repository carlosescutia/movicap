<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h1 class="h2">Parámetros del sistema</h1>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>parametro_sistema/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-4 align-self-center">
                    <p class="small"><strong>Parámetro</strong></p>
                </div>
                <div class="col-5 align-self-center">
                    <p class="small"><strong>Valor</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($parametros_sistema as $parametros_sistema_item) { ?>
            <div class="col-12 alternate-color">
                <div class="row">
                    <div class="col-2 align-self-center">
                        <p><a href="<?=base_url()?>parametro_sistema/detalle/<?=$parametros_sistema_item['id_parametro_sistema']?>"><?= $parametros_sistema_item['id_parametro_sistema'] ?></a></p>
                    </div>
                    <div class="col-4 align-self-center">
                        <p><a href="<?=base_url()?>parametro_sistema/detalle/<?=$parametros_sistema_item['id_parametro_sistema']?>"><?= $parametros_sistema_item['nom_parametro_sistema'] ?></a></p>
                    </div>
                    <div class="col-5 align-self-center">
                        <p><?= $parametros_sistema_item['valor'] ?></a></p>
                    </div>
                    <div class="col-1 align-self-center">
                        <?php 
                        $item_eliminar = $parametros_sistema_item['id_parametro_sistema'] . " " . $parametros_sistema_item['nom_parametro_sistema']; 
                        $url = base_url() . "parametro_sistema/eliminar/". $parametros_sistema_item['id_parametro_sistema']; 
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
