<div class="my-3 pb-2 border-bottom">
    <div class="row">
        <div class="col-9 text-start">
            <h1 class="h2">Usuarios</h1>
        </div>
        <div class="col-2 text-end">
            <form method="post" action="<?= base_url() ?>usuario/nuevo">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    </div>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-1 align-self-center">
                    <p class="small"><strong>Clave</strong></p>
                </div>
                <div class="col-3 align-self-center">
                    <p class="small"><strong>Nombre</strong></p>
                </div>
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Usuario</strong></p>
                </div>
                <div class="col-2 align-self-center">
                    <p class="small"><strong>Org.</strong></p>
                </div>
                <div class="col-1 align-self-center">
                    <p class="small"><strong>Rol</strong></p>
                </div>
                <div class="col-1 align-self-center text-center">
                    <p class="small"><strong>Perm</strong></p>
                </div>
                <div class="col-1 align-self-center text-center">
                    <p class="small"><strong>Activo</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($usuarios as $usuarios_item) { ?>
        <div class="col-12 alternate-color">
            <div class="row">
                <div class="col-1 align-self-center">
                    <p><a href="<?=base_url()?>usuario/detalle/<?=$usuarios_item['id_usuario']?>"><?= $usuarios_item['id_usuario'] ?></a></p>
                </div>
                <div class="col-3 align-self-center">
                    <p><a href="<?=base_url()?>usuario/detalle/<?=$usuarios_item['id_usuario']?>"><?= $usuarios_item['nom_usuario'] ?></a></p>
                </div>
                <div class="col-2 align-self-center">
                    <p><?= $usuarios_item['usuario'] ?></p>
                </div>
                <div class="col-2 align-self-center">
                    <p><?= $usuarios_item['nom_organizacion'] ?></p>
                </div>
                <div class="col-1 align-self-center">
                    <p><?= $usuarios_item['id_rol'] ?></p>
                </div>
                <div class="col-1 align-self-center text-center">
                    <p><?= $usuarios_item['num_permisos'] > 0 ? $usuarios_item['num_permisos'] : '' ?></p>
                </div>
                <div class="col-1 align-self-center text-center">
                    <p><?= $usuarios_item['activo'] ?></p>
                </div>
                <div class="col-1 align-self-center">
                    <?php 
                    $item_eliminar = $usuarios_item['id_usuario'] ." " . $usuarios_item['nom_usuario'] . " - " . $usuarios_item['nom_organizacion'] ;
                    $url = base_url() . "usuario/eliminar/". $usuarios_item['id_usuario']; 
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
        <a href="<?=base_url()?>catalogos" class="btn btn-secondary">Volver</a>
    </div>
</div>
