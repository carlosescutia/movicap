<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Secciones
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Sección</th>
                    <th scope="col" class="text-center">Orden</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach( $secciones as $secciones_item) { ?>
                    <tr>
                        <td><a href="<?= base_url() ?>seccion/detalle/<?= $secciones_item['id_seccion']?>"><?= $secciones_item['nom_seccion'] ?></a></td>
                        <td class="text-center"><?= $secciones_item['orden'] ?></td>
                        <?php
                            $permisos_requeridos = array(
                            'seccion.can_edit',
                            );
                        ?>
                        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                            <?php 
                                $item_eliminar = $secciones_item['id_seccion'] ." " . $secciones_item['nom_seccion'] ;
                                $url = base_url() . "seccion/eliminar/". $secciones_item['id_seccion']; 
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
        'seccion.can_edit',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <div class="card-footer text-end d-print-none">
            <form method="post" action="<?= base_url() ?>seccion/nuevo">
                <input type="hidden" name="id_cuestionario" value="<?= $cuestionario['id_cuestionario'] ?>">
                <button type="submit" class="btn btn-primary">Nuevo</button>
            </form>
        </div>
    <?php } ?>
</div>

