<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-success">
        Preguntas
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Texto</th>
                    <th scope="col" class="d-none d-sm-table-cell">Tipo</th>
                    <th scope="col" class="text-center">Orden</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach( $preguntas as $preguntas_item) { ?>
                    <tr>
                        <td><a href="<?= base_url() ?>pregunta/detalle/<?= $preguntas_item['id_pregunta']?>"><?= $preguntas_item['nom_pregunta'] ?></a></td>
                        <td><?= $preguntas_item['texto'] ?></td>
                        <td class="d-none d-sm-table-cell"><?= $preguntas_item['nom_tipo_pregunta'] ?></td>
                        <td class="text-center"><?= $preguntas_item['orden'] ?></td>
                        <?php
                            $permisos_requeridos = array(
                            'pregunta.can_edit',
                            );
                        ?>
                        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                            <?php 
                                $item_eliminar = $preguntas_item['id_pregunta'] ." " . $preguntas_item['texto'] ;
                                $url = base_url() . "pregunta/eliminar/". $preguntas_item['id_pregunta']; 
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
        'pregunta.can_edit',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <div class="card-footer text-end d-print-none">
            <form method="post" action="<?= base_url() ?>pregunta/nuevo">
                <input type="hidden" name="id_seccion" value="<?= $seccion['id_seccion'] ?>">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    <?php } ?>
</div>

