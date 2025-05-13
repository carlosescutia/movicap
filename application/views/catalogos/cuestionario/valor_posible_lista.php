<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-secondary">
        Valores posibles
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Texto</th>
                    <th scope="col" class="d-none d-sm-table-cell">Valor</th>
                    <th scope="col" class="text-center">Orden</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach( $valores_posibles as $valores_posibles_item) { ?>
                    <tr>
                        <td><a href="<?= base_url() ?>valor_posible/detalle/<?= $valores_posibles_item['id_valor_posible']?>"><?= $valores_posibles_item['texto'] ?></a></td>
                        <td class="d-none d-sm-table-cell"><?= $valores_posibles_item['valor'] ?></td>
                        <td class="text-center"><?= $valores_posibles_item['orden'] ?></td>
                        <?php
                            $permisos_requeridos = array(
                            'valor_posible.can_edit',
                            );
                        ?>
                        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                            <?php 
                                $item_eliminar = $valores_posibles_item['id_valor_posible'] ." " . $valores_posibles_item['texto'] ;
                                $url = base_url() . "valor_posible/eliminar/". $valores_posibles_item['id_valor_posible']; 
                            ?>
                            <td><a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
        $permisos_requeridos = array(
        'valor_posible.can_edit',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
            <div class="card-footer text-end d-print-none">
                <form method="post" action="<?= base_url() ?>valor_posible/nuevo">
                    <input type="hidden" name="id_pregunta" value="<?= $pregunta['id_pregunta'] ?>">
                    <button type="submit" class="btn btn-primary">Nuevo</button>
                </form>
            </div>
    <?php } ?>
</div>
