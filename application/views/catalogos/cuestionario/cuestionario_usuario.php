<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Capturistas
    </div>
    <div class="card-body">
        <ul>
            <?php foreach( $cuestionario_usuarios as $cuestionario_usuarios_item) { ?>
            <li>
                <div class="row">
                    <div class="col-6">
                        <?= $cuestionario_usuarios_item['nom_usuario'] ?>
                    </div>
                    <div class="col-2">
                        <?php 
                            $item_eliminar = $cuestionario_usuarios_item['id_cuestionario'] . ' ' . $cuestionario_usuarios_item['id_cuestionario'];
                            $url = base_url() . "cuestionario_usuario/eliminar/". $cuestionario_usuarios_item['id_cuestionario_usuario']; 
                        ?>
                        <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                        </a>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="card-footer text-end">
        <form method="post" action="<?= base_url() ?>cuestionario_usuario/guardar">
            <div class="row">
                <div class="col-8">
                    <select class="form-select" name="id_usuario" id="id_usuario">
                        <?php foreach ($usuarios as $usuarios_item) { ?>
                            <option value="<?= $usuarios_item['id_usuario'] ?>"><?= $usuarios_item['nom_usuario'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" name="id_cuestionario" value="<?= $cuestionario['id_cuestionario'] ?>">
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

