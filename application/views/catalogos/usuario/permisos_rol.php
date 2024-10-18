<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Permisos del rol
    </div>
    <div class="card-body">
        <ul>
        <?php foreach( $accesos_sistema_rol as $accesos_sistema_rol_item) { ?>
            <li><?= $accesos_sistema_rol_item['cod_opcion_sistema'] ?></li>
        <?php } ?>
        </ul>
    </div>
</div>
