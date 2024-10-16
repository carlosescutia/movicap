<div class="my-3 pb-2 border-bottom">
    <form method="post" action="<?= base_url() ?>reportes/listado_bitacora_01">
        <div class="row">
            <div class="col-sm-8 text-start">
                <h1 class="h2">Bitácora de actividad</h1>
            </div>
            <div class="col-sm-4 text-end">
                <button formaction="<?= base_url() ?>reportes/listado_bitacora_01/csv" class="btn btn-primary d-print-none">Exportar a excel</button>
                <a href="javascript:window.print()" class="btn btn-primary d-print-none">Generar pdf</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 align-self-center">
                <div class="row">
                    <div class="col-2">
                        <select class="form-select form-select-sm" name="accion">
                            <option value="" <?= ($accion == '') ? 'selected' : '' ?>>Todas las acciones</option>
                            <option value="login" <?= ($accion == 'login') ? 'selected' : '' ?>>login</option>
                            <option value="logout" <?= ($accion == 'logout') ? 'selected' : '' ?>>logout</option>
                            <option value="agregó" <?= ($accion == 'agregó') ? 'selected' : '' ?>>agregó</option>
                            <option value="modificó" <?= ($accion == 'modificó') ? 'selected' : '' ?>>modificó</option>
                            <option value="eliminó" <?= ($accion == 'eliminó') ? 'selected' : '' ?>>eliminó</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select form-select-sm" name="entidad">
                            <option value="" <?= ($entidad == '') ? 'selected' : '' ?>>Todas las entidades</option>
                            <option value="usuario" <?= ($entidad == 'usuario') ? 'selected' : '' ?>>usuario</option>
                            <option value="opcion_sistema" <?= ($entidad == 'opcion_sistema') ? 'selected' : '' ?>>opcion_sistema</option>
                            <option value="acceso_sistema" <?= ($entidad == 'acceso_sistema') ? 'selected' : '' ?>>acceso_sistema</option>
                            <option value="organizacion" <?= ($entidad == 'organizacion') ? 'selected' : '' ?>>organizacion</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-success btn-sm d-print-none">Filtrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="area-contenido">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Origen</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Nombre de usuario</th>
                        <th scope="col">organizacion</th>
                        <th scope="col">Acción</th>
                        <th scope="col">Entidad</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bitacora as $bitacora_item) { ?>
                    <tr>
                        <td><?= $bitacora_item['id_evento'] ?></td>
                        <td><?= empty($bitacora_item['fecha']) ? '' : date('d/m/y', strtotime($bitacora_item['fecha'])) ?></td>
                        <td><?= empty($bitacora_item['hora']) ? '' : date('H:i', strtotime($bitacora_item['hora'])) ?></td>
                        <td><?= $bitacora_item['origen'] ?></td>
                        <td><?= $bitacora_item['usuario'] ?></td>
                        <td><?= $bitacora_item['nom_usuario'] ?></td>
                        <td><?= $bitacora_item['nom_organizacion'] ?></td>
                        <td><?= $bitacora_item['accion'] ?></td>
                        <td><?= $bitacora_item['entidad'] ?></td>
                        <td><?= $bitacora_item['valor'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
